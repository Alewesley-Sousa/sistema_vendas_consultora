<?php

namespace App\Http\Controllers;

use App\Models\itens_catalogo;
use App\Services\CatalogoService;
use Illuminate\Http\Request;

class ItensCatalogoController extends Controller
{
    protected $catalogoService;

    public function __construct(CatalogoService $service){$this->catalogoService = $service;}

    public function visualizarItens(Request $request, $id) {
        $busca = $request->query('search');
        $resultado = $this->catalogoService->trazerItens($id, $busca);

        return response()->json($resultado);
    }
}
