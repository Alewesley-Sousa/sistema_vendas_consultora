<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatalogosRequest;
use App\Services\CatalogoService;
use Illuminate\Http\JsonResponse;
use Exception;
use Inertia\Inertia;

class CatalogosController extends Controller
{
    protected $catalogoService;

    public function __construct(CatalogoService $catalogoService)
    {
        $this->catalogoService = $catalogoService;
    }

    public function index() {
        return Inertia::render('Consultora/Catalogo');
    }

    public function listar(): JsonResponse
    {
        $resultado = $this->catalogoService->listarTodos();
        return response()->json($resultado, 200);
    }

    public function exibir(int $id): JsonResponse
    {
        try {
            $resultado = $this->catalogoService->exibir($id);
            return response()->json($resultado, 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Catálogo não encontrado.'], 404);
        }
    }

    public function cadastrar(CatalogosRequest $request): JsonResponse
    {
        $resultado = $this->catalogoService->armazenar($request);

        // Se o Service retornar um array com status 'error', algo falhou
        if (isset($resultado['status']) && $resultado['status'] === 'error') {
            return response()->json($resultado, 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Catálogo cadastrado com sucesso!',
            'data' => $resultado
        ], 201);
    }

    public function atualizar(CatalogosRequest $request, int $id): JsonResponse
    {
        $resultado = $this->catalogoService->editar($request, $id);

        if (isset($resultado['status']) && $resultado['status'] === 'error') {
            return response()->json($resultado, 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Catálogo atualizado com sucesso!',
            'data' => $resultado
        ], 200);
    }

    public function excluir(int $id): JsonResponse
    {
        try {
            $resultado = $this->catalogoService->excluir($id);
            return response()->json($resultado, 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Erro ao excluir catálogo: ' . $e->getMessage()
            ], 400);
        }
    }
}