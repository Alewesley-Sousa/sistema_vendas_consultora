<?php
/**
 * Autor: Alewesley-Sousa
 * Data: 01/03/2026
 * Descrição: Controler responsavel por controlar entrada e saida de dados
 */

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Http\Requests\UsuariosRequest;
use App\Models\Status\status_consultora;
use App\Models\usuarios;
use App\Services\UsuarioService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    protected $usuarioService;

    public function __construct(protected UsuarioService $service) {$this->usuarioService = $service;}

    public function formulario($id = null) {
        $status = status_consultora::all();
        return view('formularios.formulario-usuario', ['id' => $id, 'status' => $status]);
    }

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

    public function listarPreCadastros(): JsonResponse
    {
        $resultado = $this->usuarioService->visualizarSolicitacoesDeNovasConsultora();
        
        return response()->json($resultado, $resultado['status'] === 'success' ? 200 : 400);
    }

    public function aprovarOuRecusar($id, Request $request): JsonResponse
    {
        $decisao = $request->input('decisao', 0); // 1=aprovar, 0=recusar
        $resultado = $this->usuarioService->aprovarOuRecusarCadastro((int)$id, (int)$decisao);
        
        return response()->json($resultado, $resultado['status'] === 'success' ? 200 : 400);
    }
}
