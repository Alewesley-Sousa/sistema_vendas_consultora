<?php

namespace App\Http\Controllers;

use App\Models\historico_comissoes;
use App\Services\HistoricoComissaoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HistoricoComissoesController extends Controller
{
    protected $historicoComissaoService;

    public function __construct(HistoricoComissaoService $historicoComissao)
    {
        $this->historicoComissaoService = $historicoComissao;
    }

public function historicoComissao() 
{
    // Retorna o componente Vue localizado em resources/js/Pages/Consultora/HistoricoComissao.vue
    return Inertia::render('Consultora/HistoricoComissao');
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
