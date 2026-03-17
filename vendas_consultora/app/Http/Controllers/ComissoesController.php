<?php

namespace App\Http\Controllers;

use App\Models\comissoes;
use App\Http\Controllers\Controller;
use App\Services\ComissaoService;
use Illuminate\Http\Request;

class ComissoesController extends Controller
{
    protected $comissaoService;

    public function __construct(ComissaoService $comissaoService)
    {
        $this->comissaoService = $comissaoService;
    }

    public function visualizar(comissoes $comissoes)
    {
        $comissao =  $this->comissaoService->comissaoUsuario();

        return response()->json([
            'status' => 'sucesso',
            'data' => $comissao
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
