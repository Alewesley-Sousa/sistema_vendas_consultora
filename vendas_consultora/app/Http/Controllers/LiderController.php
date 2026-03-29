<?php

namespace App\Http\Controllers;

use App\Services\LiderService;
use Illuminate\Http\Request;

class LiderController extends Controller
{
    protected $liderService;

    public function __construct(protected LiderService $service)
    {
        $this->liderService = $service;
    }
    
    /**
     * Visualizar equipe
     * @param int $id
     */
    public function visualizarEquipe() {
        $resultado = $this->liderService->consultorasVinculadas();

        return response()->json($resultado);
    }
}
