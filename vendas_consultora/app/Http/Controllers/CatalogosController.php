<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatalogosRequest;
use App\Services\CatalogoService;
use Illuminate\Http\JsonResponse;

class CatalogosController extends Controller
{
    protected $catalogoService;

    public function __construct(CatalogoService $catalogoService)
    {
        $this->catalogoService = $catalogoService;
    }

    public function listar(): JsonResponse
    {
        $resultado = $this->catalogoService->listarTodos();
        return response()->json($resultado, 200);
    }

    public function exibir(int $id): JsonResponse
    {
        $resultado = $this->catalogoService->exibir($id);
        return response()->json($resultado, 200);
    }

    public function cadastrar(CatalogosRequest $request): JsonResponse
    {
        $resultado = $this->catalogoService->armazenar($request);

        if ($resultado['status'] === 'success') {
            return response()->json($resultado, 201);
        }

        return response()->json($resultado, 400);
    }

    public function atualizar(CatalogosRequest $request, int $id): JsonResponse
    {
        $resultado = $this->catalogoService->editar($request, $id);

        if ($resultado['status'] === 'success') {
            return response()->json($resultado, 200);
        }

        return response()->json($resultado, 400);
    }

    public function excluir(int $id): JsonResponse
    {
        $resultado = $this->catalogoService->excluir($id);
        return response()->json($resultado, $resultado['status'] === 'success' ? 200 : 400);
    }
}