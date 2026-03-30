<?php

namespace App\Http\Controllers;

use App\Models\pedidos;
use App\Services\PedidosService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidosController extends Controller
{
    protected $pedidosService;

    public function __construct(PedidosService $pedidosService)
    {
        $this->pedidosService = $pedidosService;
    }
    /**
     * pegar dados de um pedido pelo id
     */
    public function visualizarPedido($id)
    {
        try {
            $usuarioLongado = Auth::check();
            if (!$usuarioLongado) {
                throw new Exception('Acesso negado!');
            }
            $resultado = pedidos::select('id', 'usuario_id', 'cliente_id', 'link', 'valor_total', 'status_id', 'tipo_pagamento')->where('id', $id)->with('itensPedidos', function ($query) {
                $query->select('id', 'produto_id', 'quantidade', 'preco');
            })->first();
            if(!$resultado) {
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

    /**
     * atualizar pedido do usuario
     */
    public function atualizarPedido(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(pedidos $pedidos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pedidos $pedidos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pedidos $pedidos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pedidos $pedidos)
    {
        //
    }
}
