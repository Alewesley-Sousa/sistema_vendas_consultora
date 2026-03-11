<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: Controler responsavel por controlar entrada e saida de dados
 */

namespace App\Http\Controllers;

use App\Models\usuarios;
use Illuminate\Http\Request;
use App\Services\UsuarioService;
use App\Http\Requests\UsuariosRequest;

class UsuariosController extends Controller
{

    public function __construct(protected UsuarioService $service) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->service->listar());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // vai ficar o codigo que leva a pagina de criar usuarios
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UsuarioRequest $request): JsonResponse
    {
        // O UsuarioRequest já validou os dados aqui
        $usuario = $this->service->store($request->validated());

        return response()->json([
            'message' => 'Usuário criado com sucesso!',
            'data' => $usuario
        ], 210);
    }
    /**
     * Display the specified resource.
     */
    public function show(usuarios $usuarios)
    {
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(usuarios $usuarios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UsuarioRequest $request, $id): JsonResponse
    {
        // O Request validado garante que os dados estão corretos
        $usuario = $this->usuarioService->update($id, $request->validated());

        return response()->json([
            'message' => 'Usuário atualizado com sucesso!',
            'data' => $usuario
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $this->usuarioService->destroy($id);
    
        return response()->json([
            'message' => 'Usuário removido com sucesso!'
        ], 200);
    }
}
