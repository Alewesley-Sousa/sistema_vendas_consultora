<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutosRequest;
use App\Services\ProdutoService;
use Illuminate\Http\JsonResponse;

class ProdutosController extends Controller
{
    public function __construct(
        protected ProdutoService $produtoService
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->produtoService->index());
    }

    public function store(ProdutosRequest $request): JsonResponse
    {
        // Passa o Request completo em vez de apenas os dados validados array,
        // pois o Service precisará extrair o arquivo binário com $request->file()
        $result = $this->produtoService->store($request);
        return response()->json($result, 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->produtoService->show($id));
    }

    // Alterado para receber o Request completo por conta do upload na edição
    public function update(ProdutosRequest $request, int $id): JsonResponse
    {
        $result = $this->produtoService->update($request, $id);
        return response()->json($result);
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json($this->produtoService->destroy($id));
    }
}
