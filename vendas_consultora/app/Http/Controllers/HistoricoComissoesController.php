<?php

namespace App\Http\Controllers;

use App\Models\historico_comissoes;
use App\Services\HistoricoComissaoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoricoComissoesController extends Controller
{
    protected $historicoComissaoService;

    public function __construct(HistoricoComissaoService $historicoComissao)
    {
        $this->historicoComissaoService = $historicoComissao;
    }

    public function visualizarHistorico()
    {
        $idUsuario = Auth::id();
        $historicoComissoes = $this->historicoComissaoService->PegarHistoricoComissao($idUsuario);

        return response()->json([
            'status' => 'sucesso',
            'data' => $historicoComissoes
        ]);
    }
}
