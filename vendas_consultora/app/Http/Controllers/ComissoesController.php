<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\comissoes;
use App\Services\ComissaoService;
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

    /**
     * Store a newly created resource in storage.
     */
    public function armazernar(Request $request)
    {
        //
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
