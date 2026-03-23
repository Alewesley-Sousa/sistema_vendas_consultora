<?php

namespace App\Http\Controllers;

use App\Models\catalogos;
use App\Services\CatalogoService;
use Illuminate\Http\Request;

class CatalogosController extends Controller
{
    protected $catalogoService;

    public function __construct(CatalogoService $service) {$this->catalogoService = $service;}
    
    public function index() {
        return view('consultora.catalogo-produtos');
    }

    public function visualizarCatalogo(Request $request) {
        $busca = $request->query('search');
        $resultado = $this->catalogoService->trazerCatalogos($busca);

        return response()->json($resultado);
    }
}
