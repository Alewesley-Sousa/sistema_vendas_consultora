<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\comissoes;
use App\Services\ComissaoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComissoesController extends Controller
{
    protected $comissaoService;

    public function __construct(ComissaoService $comissaoService)
    {
        $this->comissaoService = $comissaoService;
    }

    public function visualizar()
    {
        $idUsuario = Auth::id();
        $comissao = $this->comissaoService->comissaoUsuario($idUsuario);

        return response()->json([
            'status' => 'sucesso',
            'data' => $comissao ? $comissao->saldo_liquido : 0
        ]);
    }

    public function solicitarComissao(Request $request): JsonResponse
    {
        try {
            $resultado = $this->comissaoService->solicitarSaque();

            if ($resultado['status'] === 'success') {
                return response()->json([
                    'status'  => 'success',
                    'message' => $resultado['mensagem'],
                    'valor_solicitado' => $resultado['valor_solicitado'] 
                ], 200);
            }

            return response()->json([
                'status'  => 'error',
                'message' => $resultado['mensagem']
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Erro interno: ' . $e->getMessage()
            ], 500);
        }
    }

    // --- NOVOS MÉTODOS PARA A DISTRIBUIDORA ---

    /**
     * Lista todas as solicitações pendentes para a Distribuidora.
     */
    public function listarPendentes(): JsonResponse
    {
        try {
            $solicitacoes = $this->comissaoService->listarSolicitacoesPendentes();
            
            return response()->json([
                'status' => 'success',
                'data' => $solicitacoes
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 403); // 403 pois a falha geralmente será o cargo negado
        }
    }

    /**
     * Aprova ou Reprova uma solicitação.
     * Espera 'status_id' no corpo da requisição (2 para aprovar, 3 para reprovar).
     */
    public function processarSolicitacao(Request $request, $id): JsonResponse
    {
        try {
            $statusDesejado = $request->input('status_id');

            // Validação básica do input
            if (!in_array($statusDesejado, [2, 3])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Status inválido. Use 2 para Aprovar ou 3 para Reprovar.'
                ], 400);
            }

            $resultado = $this->comissaoService->processarSolicitacao($id, $statusDesejado);

            if ($resultado['status'] === 'success') {
                return response()->json($resultado, 200);
            }

            return response()->json($resultado, 400);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao processar: ' . $e->getMessage()
            ], 500);
        }
    }

    // --- MÉTODOS PADRÃO (OPCIONAIS) ---

    public function atualizar(Request $request, comissoes $comissoes)
    {
        // Implementar se necessário
    }

    public function apagar(comissoes $comissoes)
    {
        // Implementar se necessário
    }
}
