<?php

namespace App\Services;

use App\Models\pagamentos;
use App\Models\pedidos;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Services\LogService;
use Illuminate\Support\Str;

class FinanceiroService
{
    public function confirmarPagamentoSimulado($pedidoId)
    {
        DB::beginTransaction();
        try {
            $pedido = pedidos::find($pedidoId);
            if (!$pedido) {
                throw new Exception("Pedido não encontrado.");
            }

            // Evitar pagar um pedido que já foi cancelado ou já está pago
            if ($pedido->status_id === 7) {
                throw new Exception("Este pedido já foi cancelado e não pode ser pago.");
            }
            if ($pedido->status_id === 2) {
                throw new Exception("Este pedido já consta como pago.");
            }

            // 1. Criar ou Atualizar o registro seguindo sua MIGRATION
            $pagamento = pagamentos::updateOrCreate(
                ['pedido_id' => $pedido->id],
                [
                    'tipo_pagamento'    => $pedido->tipo_pagamento, // credito, debito, pix
                    'valor'             => $pedido->valor_total,
                    'status'            => 'aprovado',
                    'codigo_transacao'  => 'SIMULADO-' . strtoupper(Str::random(10)),
                    'data_confirmacao'  => now(),
                    // 'usuario_responsavel' ficaria null pois foi via sistema (cliente)
                ]
            );

            // 2. Atualizar o status do Pedido para "Pago/Aprovado" (status_id 2)
            $pedido->status_id = 2; 
            $pedido->save();

            LogService::registrarAcao(
                "Simulação de pagamento aprovada para o pedido #$pedido->id",
                "Pagamentos",
                $pedido->id,
                "O cliente clicou no botão de simulação de pagamento"
            );

            DB::commit();

            return [
                'status' => 'success', 
                'mensagem' => 'Pagamento simulado com sucesso!',
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
