<?php

namespace App\Services;

use App\Models\itens_pedido;
use App\Models\pedidos;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidosService
{
    public function atualizarPedido($id, $data)
    {
        DB::beginTransaction();
        try {
            $usuarioLongado = Auth::user();
            if (!$usuarioLongado) {
                throw new Exception('Usuário não autenticado');
            }

            $pedido = pedidos::find($id);
            if (!$pedido) {
                throw new Exception('Pedido não encontrado');
            }

            $itensPedidos = itens_pedido::where('pedido_id', $id)->get();

            // apenas pode ser feita a atualização dos campos abaixo

            //tabela pedidos
            $pedido->valor_total = $data['valor_total'] ?? $pedido->valor_total;
            $pedido->status_id = $data['status_id'] ?? $pedido->status_id;
            $pedido->tipo_pagamento = $data['tipo_pagamento'] ?? $pedido->tipo_pagamento;

            // tabela itens_pedido
            collect($data['itens'])->map(function ($itemData) use ($itensPedidos) {
                $item = $itensPedidos->firstWhere('produto_id', $itemData['produto_id']);

                if ($item) {
                    $item->quantidade = $itemData['quantidade'] ?? $item->quantidade;
                    $item->save();
                }
            });

            $pedido->save();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function trazerPedidoPorId($id)
    {
        try {
            $usuarioLongado = Auth::check();
            if (!$usuarioLongado) {
                throw new Exception('Acesso negado!');
            }
            $resultado = pedidos::select('id', 'usuario_id', 'cliente_id', 'link', 'valor_total', 'status_id', 'tipo_pagamento')->where('id', $id)->with('itensPedidos', function ($query) {
                $query->select('id', 'produto_id', 'quantidade', 'preco');
            })->first();
            if (!$resultado) {
                throw new Exception('Pedido não registrado no sistema!');
            }

            return [
                'status' => 'success',
                'data' => $resultado
            ];
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'mensagem' => 'Erro encontrado: ' . $e->getMessage()
            ];
        }
    }
}
