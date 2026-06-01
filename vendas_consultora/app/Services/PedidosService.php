<?php

namespace App\Services;

use App\Models\itens_pedido;
use App\Models\itens_catalogo;
use App\Models\pedidos;
use App\Models\pagamentos;
use App\Models\usuarios;
use App\Models\comissoes;
use App\Models\historico_comissoes;
use App\Services\EstoqueService;
use App\Services\LogService;
use App\Interfaces\calcularSubtotal;
use App\Interfaces\calcularTotal;
use App\Jobs\CancelarPedidoInativo;
use Exception;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PedidosService
{
  protected $estoqueService;

  /**
   * Construtor preparado com a injeção do EstoqueService
   * necessário para realizar as devoluções automáticas de estoque.
   */
  public function __construct(EstoqueService $estoqueService)
  {
    $this->estoqueService = $estoqueService;
  }

  public function atualizarPedido($id, $data)
  {
    DB::beginTransaction();
    try {
      $usuarioLongado = Auth::user();
      if (!$usuarioLongado) {
        throw new Exception("Usuário não autenticado");
      }

      $pedido = pedidos::find($id);
      if (!$pedido) {
        throw new Exception("Pedido não encontrado");
      }

      if (!$this->usuarioPodeGerenciarPedido($usuarioLongado, $pedido)) {
        throw new Exception("Você não tem permissão para alterar este pedido.");
      }

      // tabela pedidos
      $pedido->status_id = $data["status_id"] ?? $pedido->status_id;
      $pedido->tipo_pagamento = $data["tipo_pagamento"] ?? $pedido->tipo_pagamento;

      $itensPayload = collect($data["itens"]);
      $idsCatalogoPayload = $itensPayload->pluck("item_catalogo_id")->filter()->unique()->values()->all();

      itens_pedido::where("pedido_id", $id)
        ->whereNotIn("item_catalogo_id", $idsCatalogoPayload)
        ->delete();

      $itensAtuais = itens_pedido::where("pedido_id", $id)
        ->get()
        ->keyBy("item_catalogo_id");

      $catalogoItens = itens_catalogo::with("produto")
        ->whereIn("id", $idsCatalogoPayload)
        ->get()
        ->keyBy("id");

      $itensAtualizados = $itensPayload->map(function ($itemData) use ($itensAtuais, $catalogoItens, $pedido, $usuarioLongado) {
        $itemCatalogoId = $itemData["item_catalogo_id"];
        $itemCatalogo = $catalogoItens->get($itemCatalogoId);

        if (!$itemCatalogo) {
          throw new Exception("Produto de catálogo inválido no pedido.");
        }

        $item = $itensAtuais->get($itemCatalogoId) ?? new itens_pedido();
        $item->pedido_id = $pedido->id;
        $item->item_catalogo_id = $itemCatalogoId;
        $item->quantidade = $itemData["quantidade"] ?? $item->quantidade ?? 1;

        if (!$item->exists || $usuarioLongado->cargo == "distribuidora") {
          $item->preco_unitario = $itemData["preco_unitario"]
            ?? $item->preco_unitario
            ?? $itemCatalogo->produto?->preco_final
            ?? 0;
        }

        $calculador = new calcularSubtotal($item->quantidade, $item->preco_unitario);
        $item->subtotal = $calculador->calcular();
        $item->save();

        return $item;
      });

      $subtotais = $itensAtualizados->filter()->map(function ($item) {
        return $item->subtotal;
      })->toArray();

      $calculador = new calcularTotal($subtotais);
      $pedido->valor_total = $calculador->calcular();
      $pedido->save();

      LogService::registrarAcao(
        "Atualizar os produtos do pedido #$pedido->id",
        "Pedidos e itens_pedido",
        $pedido->id,
        "Atualizando os dados dos produtos de um pedido"
      );
      DB::commit();

      return [
        "status" => "success",
        "mensagem" => "os produtos do pedido #{$pedido->id} foram atualizados com sucesso",
      ];
    } catch (Exception $e) {
      DB::rollBack();
      return [
        "status" => "error",
        "mensagem" => "houve um erro no sistema: " . $e->getMessage(),
      ];
    }
  }

  private function usuarioPodeGerenciarPedido($usuario, pedidos $pedido): bool
  {
    if ($usuario->cargo === "distribuidora") {
      return true;
    }

    if ($usuario->cargo === "consultora") {
      return (int) $pedido->usuario_id === (int) $usuario->id;
    }

    if ($usuario->cargo === "lider") {
      return usuarios::where("id", $pedido->usuario_id)
        ->where("consultora_id", $usuario->id)
        ->exists();
    }

    return false;
  }

  public function listarPedidosPorEquipe($liderId)
  {
    return pedidos::with(['consultora', 'clientes', 'itensPedidos'])
        ->where('status_id', '!=', 7) 
        ->whereHas('consultora', function ($query) use ($liderId) {
            $query->where('consultora_id', $liderId);
        })
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function ($pedido) {
            return [
                'id'        => $pedido->id,
                'data'      => $pedido->created_at->format('d/m/Y'),
                'nome'      => $pedido->consultora->nome ?? 'Consultora',
                'cliente'   => $pedido->clientes->nome ?? 'Consumidor',
                'pagamento' => strtoupper($pedido->tipo_pagamento),
                'status'    => $pedido->status->nome ?? 'Pendente',
                'total'     => (float) $pedido->valor_total,
                'itens'     => $pedido->itensPedidos->map(function ($item) {
                    return [
                        'produto' => $item->produto->nome ?? 'Produto',
                        'qtd'     => $item->quantidade,
                        'preco'   => (float) $item->preco_unitario
                    ];
                })
            ];
        });
  }

  public function trazerPedidoPorId($id)
  {
    try {
        if (!Auth::check()) {
            throw new Exception("Acesso negado!");
        }

        $query = pedidos::select("id", "usuario_id", "cliente_id", "link", "valor_total", "status_id", "tipo_pagamento")
        ->where("id", $id)
        ->with([
            'consultora' => function ($query) { $query->select("id", "nome"); },
            'clientes' => function ($query) { $query->select("id", "nome"); },
            'itensPedidos' => function ($query) {
                $query->select("id", "pedido_id", "item_catalogo_id", "quantidade", "preco_unitario");
            },
            'itensPedidos.itemCatalogo' => function ($query) { $query->select("id", "produto_id"); },
            'itensPedidos.itemCatalogo.produto' => function ($query) { $query->select("id", "nome"); },
            'status' => function ($query) { $query->select('id', 'nome'); }
        ]);

        $usuarioLogado = Auth::user();
        if ($usuarioLogado->cargo === "consultora") {
            $query->where("usuario_id", $usuarioLogado->id);
        } elseif ($usuarioLogado->cargo === "lider") {
            $query->whereHas("consultora", function ($query) use ($usuarioLogado) {
                $query->where("consultora_id", $usuarioLogado->id);
            });
        }

        $resultado = $query->first();

        if (!$resultado) {
            throw new Exception("Pedido não registrado no sistema!");
        }

        return [
            "status" => "success",
            "data" => $resultado,
        ];
    } catch (Exception $e) {
        return [
            "status" => "error",
            "mensagem" => "Erro encontrado: " . $e->getMessage(),
        ];
    }
  }

  protected function diasDesde(string $data)
  {
    $data = new DateTime($data);
    $hoje = new DateTime();
    $intervalo = $data->diff($hoje);
    return $intervalo->days;
  }

  public function excluirPedido($id)
  {
    DB::beginTransaction();
    try {
      $pedido = pedidos::find($id);
      if (!$pedido) {
        throw new Exception("Pedido não encontrado.");
      }

      $usuarioLongado = Auth::user();
      if (!$usuarioLongado || !$this->usuarioPodeGerenciarPedido($usuarioLongado, $pedido)) {
        throw new Exception("Você não tem permissão para cancelar este pedido.");
      }

      $pagamento = pagamentos::where("pedido_id", $pedido->id)->first();

      if ($pedido->status_id === 7) {
        throw new Exception("o pedido ja foi cancelado á " . $this->diasDesde($pedido->created_at) . " dias.");
      }

      // Permite cancelar os status: 1 (Aguardando Pagamento), 2 (Pagamento Confirmado) e 3 (Separando Pedido)
      $statusPermitidos = [1, 2, 3]; 

      if (!in_array($pedido->status_id, $statusPermitidos)) {
        throw new Exception("pedido não pode ser mais cancelado.");
      }

      // GATILHO INTERNO: Se o pedido cancelado já estiver pago (Status 2), executa a reversão completa
      if ($pedido->status_id === 2) {
        $this->estornarFluxoPagamento($pedido->id);
      }

      // Executa a alteração final para Cancelado (7)
      $pedido->status_id = 7;
      
      if ($pagamento && $pagamento->status !== 'estornado') {
        $pagamento->status = "recusado";
        $pagamento->save();
      }
      
      $pedido->save();

      LogService::registrarAcao(
        "O pedido #$pedido->id foi cancelado",
        "Pedidos e pagamentos",
        $pedido->id,
        "Atualizando os dados dos produtos de um pedido"
      );

      DB::commit();
      return [
        "status" => "sucesso",
        "mensagem" => "pedido cancelado com sucesso",
      ];
    } catch (Exception $e) {
      DB::rollBack();
      return [
        "status" => "error",
        "mensagem" => "erro ao cancelar: " . $e->getMessage(),
      ];
    }
  }

  public function criarPedido($data)
  {
    DB::beginTransaction();
    try {
      $usuarioLogado = Auth::user();
      if (!$usuarioLogado) {
        throw new Exception("Usuário não autenticado");
      }

      $pedido = new pedidos();
      $pedido->uuid = (string) Str::uuid();
      $pedido->usuario_id = $usuarioLogado->id;
      $pedido->cliente_id = $data["cliente_id"];
      $pedido->status_id = $data["status_id"] ?? 1;
      $pedido->tipo_pagamento = $data["tipo_pagamento"];
      $pedido->link = route("pedido.rastreio", ["uuid" => $pedido->uuid]);
      $pedido->save();

      $subtotais = [];

      foreach ($data["itens"] as $itemData) {
        $item = new itens_pedido();
        $item->pedido_id = $pedido->id;
        $item->item_catalogo_id = $itemData["item_catalogo_id"];
        $item->quantidade = $itemData["quantidade"];
        $item->preco_unitario = $itemData["preco_unitario"];

        $calculadorSubtotal = new calcularSubtotal($item->quantidade, $item->preco_unitario);
        $item->subtotal = $calculadorSubtotal->calcular();
        $item->save();
        
        $subtotais[] = $item->subtotal;
      }

      $calculadorTotal = new calcularTotal($subtotais);
      $pedido->valor_total = $calculadorTotal->calcular();
      $pedido->save();

      LogService::registrarAcao(
        "Criou o pedido #$pedido->id",
        "Pedidos e itens_pedido",
        $pedido->id,
        "Criação de pedido com UUID: $pedido->uuid"
      );

      DB::commit();
      CancelarPedidoInativo::dispatch($pedido->id)->delay(now()->addMinutes(8));

      return [
        "status" => "success",
        "mensagem" => "Pedido realizado com sucesso!",
        "data" => [
          "id" => $pedido->id,
          "uuid" => $pedido->uuid,
          "link_cliente" => $pedido->link,
        ],
      ];
    } catch (Exception $e) {
      DB::rollBack();
      return [
        "status" => "error",
        "mensagem" => "Erro ao realizar pedido: " . $e->getMessage(),
      ];
    }
  }

  public function obterLinkPorId($id)
  {
    $pedido = pedidos::select("uuid")->find($id);
    if (!$pedido) {
      throw new Exception("Pedido #{$id} não encontrado para geração de link.");
    }
    return route("cliente.pedido.montado", ["uuid" => $pedido->uuid]);
  }

  public function estornarFluxoPagamento($pedidoId)
  {
    // Verifica se já existe uma transação ativa (por exemplo, vinda do método excluirPedido)
    $hasTransaction = DB::transactionLevel() > 0;
    if (!$hasTransaction) DB::beginTransaction();

    try {
      $pedido = pedidos::with(["itensPedidos", "consultora"])->find($pedidoId);
      if (!$pedido) {
        throw new Exception("Pedido não encontrado para estorno.");
      }

      $pagamento = pagamentos::where("pedido_id", $pedido->id)->first();
      if (!$pagamento) {
        throw new Exception("Nenhum registro de pagamento encontrado para este pedido.");
      }
      if ($pagamento->status === 'estornado') {
        throw new Exception("O pagamento deste pedido já foi estornado anteriormente.");
      }

      // 1. Devolver os produtos para o estoque usando a instância injetada
      $this->estoqueService->devolverEstoquePedido($pedido);

      // 2. Reverter Comissões e Pontos distribuídos
      $this->reverterRecompensas($pedido);

      // 3. Atualizar o status do pagamento para estornado
      $pagamento->status = "estornado";
      $pagamento->save();

      LogService::registrarAcao(
        "Estorno completo de pagamento, comissões e estoque processado para o pedido #$pedido->id",
        "Financeiro",
        $pedido->id,
        "Fluxo de reversão concluído com sucesso."
      );

      if (!$hasTransaction) DB::commit();
      
      return [
        "status" => "success",
        "mensagem" => "Pagamento e benefícios estornados com sucesso.",
      ];
    } catch (Exception $e) {
      if (!$hasTransaction) DB::rollBack();
      throw $e;
    }
  }

  private function reverterRecompensas(pedidos $pedido)
  {
    $valorTotal = $pedido->valor_total;
    $vendedor = $pedido->consultora;

    if (!$vendedor) {
      return;
    }

    $vendedor->decrement("pontos", (int) $valorTotal);

    // Nível 1: Venda Direta (30%)
    $this->debitarComissao($vendedor->id, $pedido->id, $valorTotal * 0.3, 1);

    // Nível 2: Líder 1 (5%)
    if ($vendedor->consultora_id) {
      $liderNivel1 = usuarios::find($vendedor->consultora_id);
      if ($liderNivel1) {
        $this->debitarComissao($liderNivel1->id, $pedido->id, $valorTotal * 0.05, 2);

        // Nível 3: Líder 2 (2%)
        if ($liderNivel1->consultora_id) {
          $liderNivel2 = usuarios::find($liderNivel1->consultora_id);
          if ($liderNivel2) {
            $this->debitarComissao($liderNivel2->id, $pedido->id, $valorTotal * 0.02, 3);
          }
        }
      }
    }
  }

  private function debitarComissao($usuarioId, $pedidoId, $valor, $tipoComissaoId)
  {
    $saldo = comissoes::where("consultora_id", $usuarioId)->first();
    if ($saldo) {
      $saldo->decrement("saldo_liquido", $valor);
    }

    historico_comissoes::create([
      "consultora_id" => $usuarioId,
      "pedido_id" => $pedidoId,
      "tipo_comissao_id" => $tipoComissaoId,
      "valor" => $valor,
      "tipo_movimentacao_id" => 2, // 2 = Débito/Saída
      "data_movimentacao" => now(),
      "usuario_responsavel" => Auth::id(), 
    ]);
  }
}
