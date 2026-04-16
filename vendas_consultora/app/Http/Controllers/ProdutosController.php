<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutosRequest;
use App\Services\ProdutoService;
use Illuminate\Http\Request;
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
        $result = $this->produtoService->store($request->validated());
        return response()->json($result, 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->produtoService->show($id));
    }

    public function update(ProdutosRequest $request, int $id): JsonResponse
    {
        $result = $this->produtoService->update($request->validated(), $id);
        return response()->json($result);
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json($this->produtoService->destroy($id));
    }
}
