<?php

namespace App\Services;

use App\Models\itens_catalogo;
use App\Models\pedidos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinanceiroService
{
    /**
     * Cria um novo pedido
     */
    public function CriarPedido(array $dados)
    {
        DB::beginTransaction();
        try {
            $todosProdutos = $dados['produtos'];
            $idCliente = $dados['cliente_id'] ? $dados['cliente_id'] : null;
            $idUsuario = Auth::id();

            $pedido = pedidos::create([
                'cliente_id' => $idCliente,
                'usuario_id' => $idUsuario,
                'produtos' => $todosProdutos
            ]);



            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    
}