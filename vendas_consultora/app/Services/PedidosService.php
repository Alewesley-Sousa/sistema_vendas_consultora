<?php
namespace App\Services;

use App\Models\pedidos;
use Exception;
use Illuminate\Support\Facades\Auth;

class PedidosService
{
    public function atualizarPedido($id, $data)
    {
        $usuarioLongado = Auth::user();
        if (!$usuarioLongado) {
            throw new Exception('Usuário não autenticado');
        }
        
        $pedido = pedidos::find($id);
        if (!$pedido) {
            throw new Exception('Pedido não encontrado');
        }

        $pedido->valor_total = $data['valor_total'] ?? $pedido->valor_total;
        $pedido->status_id = $data['status_id'] ?? $pedido->status_id;
        $pedido->tipo_pagamento = $data['tipo_pagamento'] ?? $pedido->tipo_pagamento;

        $pedido->save();
    }
}