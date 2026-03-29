<?php

namespace App\Http\Controllers;

use App\Models\pedidos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidosController extends Controller
{
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
            $resultado = pedidos::select('id', 'usuario_id', 'cliente_id', 'link', 'valor_total', 'status_id', 'tipo_pagamento')->find($id);
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
