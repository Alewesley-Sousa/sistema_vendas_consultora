<?php

namespace App\Http\Controllers;

use App\Services\CatalogoService;
use Illuminate\Http\Request;
use App\Http\Requests\ItemCatalogoRequest;

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
    
    /**
 * Adicionar novo item
 */
public function store(ItemCatalogoRequest $request)
{
    $resultado = $this->catalogoService->saveItem($request->validated());
    return response()->json($resultado, 201);
}

/**
 * Editar item existente
 */
public function update(ItemCatalogoRequest $request, $id)
{
    $resultado = $this->catalogoService->saveItem($request->validated(), $id);
    
    $statusHttp = $resultado['status'] === 'success' ? 200 : 400;
    return response()->json($resultado, $statusHttp);
}
}
