<?php

namespace App\Http\Controllers;

use App\Services\CatalogoService;
use Illuminate\Http\Request;

class ItensCatalogoController extends Controller
{
    protected $catalogoService;

    public function __construct(CatalogoService $service){$this->catalogoService = $service;}

    /**
     * Visualiza os itens do catálogo.
     */
    public function visualizarItensCatalogo(Request $request, $id) {
        $busca = $request->query('search');
        $resultado = $this->catalogoService->trazerItens($id, $busca);

        return response()->json($resultado);
    }

    /**
     * Visualiza os itens selecionados.
     */
    public function visualizarItens($ids) {
        $idsArray = array_map('trim', explode(',', $ids));
        if (empty($idsArray)) {
            $resultado = ['status' => 'error', 'mensagem' => 'nenhum produto selecionado'];
            return response()->json($resultado);
            }
        $resultado = $this->catalogoService->visualizarItens($idsArray);
        

        return response()->json($resultado);
    }
}
