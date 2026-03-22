<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: Controler responsavel por controlar entrada e saida de dados
 */

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Http\Requests\UsuariosRequest;
use App\Models\usuarios;
use App\Services\UsuarioService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    protected $usuarioService;

    public function __construct(protected UsuarioService $service) {$this->usuarioService = $service;}

    public function cadastrarUsuario(UsuarioRequest $request)
    {
            $resultado = $this->usuarioService->registrarUsuario($request);

            if ($resultado['status'] === 'success') {
                return response()->json($resultado, 200);
            }

            return response()->json($resultado, 400);
    }

    public function exibirUsuario(usuarios $usuario): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $usuario
        ], 200);
    }

    public function atualizarUsuario(UsuarioRequest $request, $id)
    {
        $resultado = $this->usuarioService->atualizarRegistro($request, $id);

        if ($resultado['status'] === 'success') {
            return response()->json($resultado, 200);
        }

        return response()->json($resultado, 400);
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
