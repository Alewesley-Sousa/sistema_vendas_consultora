<?php

namespace App\Http\Controllers;

use App\Models\historico_comissoes;
use App\Services\HistoricoComissaoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoricoComissoesController extends Controller
{
    protected $historicoComissaoService;

    public function __construct(HistoricoComissaoService $historicoComissao)
    {
        $this->historicoComissaoService = $historicoComissao;
    }

    public function visualizarHistorico(Request $request): JsonResponse
    {
        try {
            $historico = $this->historicoComissaoService->PegarHistoricoComissao($request);

            return response()->json([
                'status' => 'success',
                'data' => $historico
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'messagem' => 'erro ao buscar dados...'
            ], 500);
        }
    }
}
