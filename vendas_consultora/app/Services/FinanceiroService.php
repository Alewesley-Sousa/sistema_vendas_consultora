<?php

namespace App\Services;

use App\Models\pagamentos;
use App\Models\pedidos;
use App\Services\EstoqueService; // Importar o serviço
use Exception;
use Illuminate\Support\Facades\DB;
use App\Services\LogService;
use Illuminate\Support\Str;

class FinanceiroService
{
  protected $estoqueService;

  public function __construct(EstoqueService $estoqueService)
  {
    $this->estoqueService = $estoqueService;
  }

  public function confirmarPagamentoSimulado($pedidoId)
  {
    DB::beginTransaction();
    try {
      // Carregamos o pedido com itens e o usuário que realizou a venda
      $pedido = pedidos::with(["itensPedidos", "usuario"])->find($pedidoId);

      if (!$pedido) {
        throw new Exception("Pedido não encontrado.");
      }
      if ($pedido->status_id === 7) {
        throw new Exception("Este pedido já foi cancelado.");
      }
      if ($pedido->status_id === 2) {
        throw new Exception("Este pedido já consta como pago.");
      }

      // 1. Registrar o pagamento
      $pagamento = pagamentos::updateOrCreate(
        ["pedido_id" => $pedido->id],
        [
          "tipo_pagamento" => $pedido->tipo_pagamento,
          "valor" => $pedido->valor_total,
          "status" => "aprovado",
          "codigo_transacao" => "SIMULADO-" . strtoupper(Str::random(10)),
          "data_confirmacao" => now(),
        ]
      );

      // 2. Baixa no estoque
      $this->estoqueService->baixarEstoquePedido($pedido);

      // 3. Processar Comissões e Pontos (Novo método)
      $this->processarRecompensas($pedido);

      // 4. Atualizar o status do Pedido
      $pedido->status_id = 2;
      $pedido->save();

      LogService::registrarAcao(
        "Pagamento, Comissões e Pontos processados para o pedido #$pedido->id",
        "Financeiro",
        $pedido->id,
        "Fluxo completo concluído."
      );

      DB::commit();

      return [
        "status" => "success",
        "mensagem" =>
          "Pagamento aprovado, estoque baixado e comissões distribuídas!",
        "transacao" => $pagamento->codigo_transacao,
      ];
    } catch (Exception $e) {
      DB::rollBack();
      return ["status" => "error", "mensagem" => $e->getMessage()];
    }
  }

  /**
   * Método Privado para gerenciar a distribuição de valores e pontos
   */
  private function processarRecompensas(pedidos $pedido)
  {
    $valorTotal = $pedido->valor_total;
    $vendedor = $pedido->usuario; // O usuário que montou o pedido

    if (!$vendedor) {
      return;
    }

    // --- 1. PONTUAÇÃO (1 real = 1 ponto) ---
    $vendedor->increment("pontos", (int) $valorTotal);

    // --- 2. COMISSÕES ---

    // Nível 1: Venda Direta (30%)
    $this->creditarComissao($vendedor->id, $pedido->id, $valorTotal * 0.3, 1); // assumindo ID 1 para Venda Direta

    // Nível 2: Multinível 1 (5% para quem indicou o vendedor)
    if ($vendedor->consultora_id) {
      $liderNivel1 = usuarios::find($vendedor->consultora_id);
      if ($liderNivel1) {
        $this->creditarComissao(
          $liderNivel1->id,
          $pedido->id,
          $valorTotal * 0.05,
          2
        ); // ID 2 para Multinível 1

        // Nível 3: Multinível 2 (2% para quem indicou o líder)
        if ($liderNivel1->consultora_id) {
          $liderNivel2 = usuarios::find($liderNivel1->consultora_id);
          if ($liderNivel2) {
            $this->creditarComissao(
              $liderNivel2->id,
              $pedido->id,
              $valorTotal * 0.02,
              3
            ); // ID 3 para Multinível 2
          }
        }
      }
    }
  }

  /**
   * Auxiliar para salvar no banco o saldo e o histórico
   */
  private function creditarComissao(
    $usuarioId,
    $pedidoId,
    $valor,
    $tipoComissaoId
  ) {
    if ($valor <= 0) {
      return;
    }

    // Atualiza ou cria o saldo na tabela 'comissoes'
    $saldo = comissoes::firstOrCreate(["consultora_id" => $usuarioId]);
    $saldo->increment("saldo_liquido", $valor);

    // Registra o histórico
    historico_comissoes::create([
      "consultora_id" => $usuarioId,
      "pedido_id" => $pedidoId,
      "tipo_comissao_id" => $tipoComissaoId,
      "valor" => $valor,
      "tipo_movimentacao_id" => 1, // Assumindo 1 como 'Crédito' ou 'Entrada'
      "data_movimentacao" => now(),
      "usuario_responsavel" => null, // Sistema
    ]);
  }
}