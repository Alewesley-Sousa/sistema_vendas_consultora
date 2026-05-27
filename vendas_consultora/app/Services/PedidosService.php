<?php

namespace App\Services;

use App\Models\itens_pedido;
use App\Models\pedidos;
use App\Models\pagamentos;
use Exception;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Interfaces\calcularSubtotal;
use App\Interfaces\calcularTotal;
use App\Services\LogService;
use Illuminate\Support\Str;
use App\Jobs\CancelarPedidoInativo;

class PedidosService
{
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

      $itensPedidos = itens_pedido::where("pedido_id", $id)->get();

      if (!empty($data["ids_excluidos"])) {
        itens_pedido::where("pedidoid", $id)
          ->whereIn("produtoid", $data["id_itens_excluidos"])
          ->delete();
      }

      //tabela pedidos
      $pedido->status_id = $data["status_id"] ?? $pedido->status_id;
      $pedido->tipo_pagamento =
        $data["tipo_pagamento"] ?? $pedido->tipo_pagamento;

      // tabela itens_pedido
      $itensAtualizados = collect($data["itens"])->map(function (
        $itemData
      ) use ($itensPedidos, $usuarioLongado) {
        $item = $itensPedidos->firstWhere(
          "produto_id",
          $itemData["produto_id"]
        );

        if ($item) {
          $item->quantidade = $itemData["quantidade"] ?? $item->quantidade;
          if ($usuarioLongado->cargo == "distribuidora") {
            $item->preco_unitario =
              $itemData["preco_unitario"] ?? $item->preco_unitario;
          }
          $calculador = new calcularSubtotal(
            $item->quantidade,
            $item->preco_unitario
          );
          $item->subtotal = $calculador->calcular();
          $item->save();
        }

        return $item;
      });
      $subtotais = $itensAtualizados
        ->map(function ($item) {
          return $item->subtotal;
        })
        ->toArray();
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
  public function listarPedidosPorEquipe($liderId)
{
    return pedidos::with(['consultora', 'clientes', 'itensPedidos'])
        // Filtra para NÃO trazer pedidos com status de cancelado (ID 7)
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

        $resultado = pedidos::select(
            "id", 
            "usuario_id",
            "cliente_id",
            "link",
            "valor_total",
            "status_id",
            "tipo_pagamento"
        )
        ->where("id", $id)
        ->with([
            // Ajustado para 'consultora' conforme seu Model
            'consultora' => function ($query) {
                $query->select("id", "nome"); 
            },
            // Ajustado para 'clientes' conforme seu Model
            'clientes' => function ($query) {
                $query->select("id", "nome");
            },
            'itensPedidos' => function ($query) {
                $query->select("id", "pedido_id", "item_catalogo_id", "quantidade", "preco_unitario");
            },
            'itensPedidos.itemCatalogo' => function ($query) {
                $query->select("id", "produto_id");
            },
            'itensPedidos.itemCatalogo.produto' => function ($query) {
                $query->select("id", "nome");
            },
            'status' => function ($query) {
            	$query->select('id', 'nome');
            }
        ])
        ->first();

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
      $pagamento = pagamentos::where("pedido_id", $pedido->id)->first();
      if ($pedido->status_id !== 1) {
        throw new Exception("pedido náo pode ser mais cancelado.");
      } elseif ($pedido->status_id === 7) {
        throw new Exception(
          "o pedido ja foi cancelado á " .
            $this->diasDesde($pedido->created_at) .
            " dias."
        );
      }

      $pedido->status_id = 7;
      $pagamento->status = "recusado";
      $pedido->save();
      $pagamento->save();

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

      // 1. Criar a instância básica do pedido
      $pedido = new pedidos();
      $pedido->uuid = (string) Str::uuid();
      $pedido->usuario_id = $usuarioLogado->id;
      $pedido->cliente_id = $data["cliente_id"];
      $pedido->status_id = $data["status_id"] ?? 1;
      $pedido->tipo_pagamento = $data["tipo_pagamento"];

      // PEGA O DOMÍNIO COMPLETO DINAMICAMENTE (HTTP ou HTTPS com base no ambiente)
      // Ajuste o nome da rota ("cliente.pedido.montado") se necessário
      $pedido->link = route("pedido.rastreio", ["uuid" => $pedido->uuid]);

      $pedido->save();

      $subtotais = [];

      // 2. Salvar os itens do pedido
      foreach ($data["itens"] as $itemData) {
        $item = new itens_pedido();
        $item->pedido_id = $pedido->id;
        $item->item_catalogo_id = $itemData["item_catalogo_id"];
        $item->quantidade = $itemData["quantidade"];
        $item->preco_unitario = $itemData["preco_unitario"];

        $calculadorSubtotal = new calcularSubtotal(
          $item->quantidade,
          $item->preco_unitario
        );
        $item->subtotal = $calculadorSubtotal->calcular();

        $item->save();
        $subtotais[] = $item->subtotal;
      }

      // 3. Calcular o valor total final
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

  /**
   * Busca o UUID de um pedido pelo ID e retorna a URL completa da rota.
   * * @param int $id
   * @return string
   * @throws Exception
   */
  public function obterLinkPorId($id)
  {
    $pedido = pedidos::select("uuid")->find($id);

    if (!$pedido) {
      throw new Exception("Pedido #{$id} não encontrado para geração de link.");
    }

    // Retorna a URL completa baseada no UUID do banco
    return route("cliente.pedido.montado", ["uuid" => $pedido->uuid]);
  }
}
