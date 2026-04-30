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
            // Carregamos o pedido com os itens para a baixa do estoque
            $pedido = pedidos::with('itensPedidos')->find($pedidoId);
            
            if (!$pedido) {
                throw new Exception("Pedido não encontrado.");
            }

            if ($pedido->status_id === 7) {
                throw new Exception("Este pedido já foi cancelado e não pode ser pago.");
            }
            if ($pedido->status_id === 2) {
                throw new Exception("Este pedido já consta como pago.");
            }

            // 1. Registrar o pagamento
            $pagamento = pagamentos::updateOrCreate(
                ['pedido_id' => $pedido->id],
                [
                    'tipo_pagamento'    => $pedido->tipo_pagamento,
                    'valor'             => $pedido->valor_total,
                    'status'            => 'aprovado',
                    'codigo_transacao'  => 'SIMULADO-' . strtoupper(Str::random(10)),
                    'data_confirmacao'  => now(),
                ]
            );

            // 2. ATUALIZAÇÃO: Realizar a baixa no estoque
            // Se o estoque estiver insuficiente, isso lançará uma Exception e fará o Rollback do pagamento!
            $this->estoqueService->baixarEstoquePedido($pedido);

            // 3. Atualizar o status do Pedido
            $pedido->status_id = 2; 
            $pedido->save();

            LogService::registrarAcao(
                "Pagamento e Baixa de Estoque aprovados para o pedido #$pedido->id",
                "Financeiro/Estoque",
                $pedido->id,
                "Fluxo completo de aprovação concluído."
            );

            DB::commit();

            return [
                'status' => 'success', 
                'mensagem' => 'Pagamento aprovado e estoque atualizado!',
                'transacao' => $pagamento->codigo_transacao
            ];

        } catch (Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error', 
                'mensagem' => $e->getMessage()
            ];
        }
    }
}
