<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\clientes;
use App\Services\ClientesService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientesController extends Controller
{
    protected $clienteService;

    public function __construct(ClientesService $clientesService)
    {
        $this->clienteService = $clientesService;
    }

    public function formulario($id = null) {
        return view('formularios.formulario-cliente', ['id' => $id]);
    }

    public function cadastrarCliente(ClienteRequest $request)
    {

        // O $request aqui já passou pela validação de CPF/Email único!
        $resultado = $this->clienteService->armazenar($request);

        if ($resultado['status'] === 'success') {
            return response()->json($resultado, 200);
        }

        return response()->json($resultado, 400);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function atualizarDados(ClienteRequest $request, $id)
    {
        // O $request aqui já passou pela validação de CPF/Email único!
        $resultado = $this->clienteService->editar($request, $id);

        if ($resultado['status'] === 'success') {
            return response()->json($resultado, 200);
        }

        return response()->json($resultado, 400);

    }

    /**
     * Display the specified resource.
     */
    public function exibir(clientes $cliente): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $cliente
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(clientes $clientes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, clientes $clientes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(clientes $clientes)
    {
        //
    }
}
