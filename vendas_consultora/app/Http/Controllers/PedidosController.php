<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoRequest;
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
        $resultado = $this->pedidosService->trazerPedidoPorId($id);

        return response()->json($resultado);
    }

    /**
     * atualizar pedido do usuario
     */
    public function atualizarPedido(PedidoRequest $request, $id)
    {
        $dadosValidados = $request->validated();
        $resultado = $this->pedidosService->atualizarPedido($id,
        $dadosValidados);
        
        return response()->json($resultado);
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
