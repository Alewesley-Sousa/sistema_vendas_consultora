<?php

namespace App\Http\Controllers;

use App\Services\CatalogoService;
use Illuminate\Http\Request;
use App\Http\Requests\ItemCatalogoRequest;
use Illuminate\Http\JsonResponse;
use Exception;

class ItensCatalogoController extends Controller
{
    protected $catalogoService;

    public function __construct(CatalogoService $service)
    {
        $this->catalogoService = $service;
    }

    /**
     * Lista os itens de um catálogo específico com filtro de busca.
     */
    public function visualizarItensCatalogo(Request $request, int $id): JsonResponse
    {
        $busca = $request->query('search');
        $resultado = $this->catalogoService->trazerItens($id, $busca);

        $statusHttp = $resultado['status'] === 'success' ? 200 : 400;
        return response()->json($resultado, $statusHttp);
    }

    /**
     * Visualiza detalhes de itens específicos passados por vírgula (Ex: 1,2,3).
     */
    public function visualizarItens(string $ids): JsonResponse
    {
        // Converte string "1,2,3" em array [1, 2, 3] limpando espaços
        $idsArray = array_filter(array_map('trim', explode(',', $ids)));

        if (empty($idsArray)) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Nenhum ID de produto foi fornecido.'
            ], 400);
        }

        $resultado = $this->catalogoService->visualizarItens($idsArray);
        
        $statusHttp = $resultado['status'] === 'success' ? 200 : 404;
        return response()->json($resultado, $statusHttp);
    }
    
    /**
     * Adicionar novo item ao catálogo.
     */
    public function store(ItemCatalogoRequest $request): JsonResponse
    {
        $resultado = $this->catalogoService->saveItem($request->validated());

        if ($resultado['status'] === 'error') {
            return response()->json($resultado, 400);
        }

        return response()->json($resultado, 201);
    }

    /**
     * Editar item existente no catálogo.
     */
    public function update(ItemCatalogoRequest $request, int $id): JsonResponse
    {
        $resultado = $this->catalogoService->saveItem($request->validated(), $id);
        
        $statusHttp = $resultado['status'] === 'success' ? 200 : 400;
        return response()->json($resultado, $statusHttp);
    }


    /**
     * Deletar item do catálogo e devolver estoque
     */
    public function destroy(int $id): JsonResponse
    {
        $resultado = $this->catalogoService->excluirItem($id);
        
        $statusHttp = $resultado['status'] === 'success' ? 200 : 400;
        return response()->json($resultado, $statusHttp);
    }
}