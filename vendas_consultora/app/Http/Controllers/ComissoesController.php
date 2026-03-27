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
        $comissao =  $this->comissaoService->comissaoUsuario($idUsuario);

        return response()->json([
            'status' => 'sucesso',
            'data' => $comissao->saldo_liquido
        ]);
    }

    public function solicitarComissao(Request $request): JsonResponse
    {
        try {
            $resultado = $this->comissaoService->solicitarSaque();

        // Se toda operação for um sucesso
        if ($resultado['status'] === 'success') {
            return response()->json([
                'status'  => 'success',
                'message' => $resultado['mensagem'],
                // Usamos o valor que o Service confirmou que está em análise
                'valor_solicitado' => $resultado['valor_solicitado'] 
            ], 200);
        }

        // Caso o Service retorne um status de erro controlado
        return response()->json([
            'status'  => 'error',
            'message' => $resultado['mensagem']
        ], 400);

    } catch (\Exception $e) {
        // Se algo explodiu (erro de banco, código, etc)
        return response()->json([
            'status'  => 'error',
            'message' => 'Erro interno: ' . $e->getMessage()
        ], 500);
    }
    }


    /**
     * Update the specified resource in storage.
     */
    public function atualizar(Request $request, comissoes $comissoes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function apagar(comissoes $comissoes)
    {
        //
    }
}
