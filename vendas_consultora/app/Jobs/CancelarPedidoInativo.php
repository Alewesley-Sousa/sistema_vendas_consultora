<?php

namespace App\Jobs;

use App\Models\pedidos;
use App\Services\LogService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancelarPedidoInativo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $pedidoId;

    public function __construct($pedidoId)
    {
        $this->pedidoId = $pedidoId;
    }

    public function handle()
    {
        $pedido = pedidos::find($this->pedidoId);

        // Verifica se o pedido existe e se ainda está com status "Aguardando Pagamento" (status_id = 1)
        if ($pedido && $pedido->status_id === 1) {
            $pedido->status_id = 7; // Status Cancelado
            $pedido->save();

            LogService::registrarAcao(
                "Pedido #{$pedido->id} cancelado automaticamente por falta de pagamento (8 min)",
                "Pedidos",
                $pedido->id,
                "Sistema de cancelamento automático"
            );
        }
    }
}
