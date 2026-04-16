<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstoquesRequest;
use App\Services\EstoqueService;
use Illuminate\Http\JsonResponse;

class EstoquesController extends Controller
{
    public function __construct(
        protected EstoqueService $estoqueService
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->estoqueService->index());
    }

    public function store(EstoquesRequest $request): JsonResponse
    {
        $result = $this->estoqueService->store($request->validated());
        return response()->json($result, 201);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->estoqueService->show($id));
    }

    public function update(EstoquesRequest $request, int $id): JsonResponse
    {
        $result = $this->estoqueService->update($request->validated(), $id);
        return response()->json($result);
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json($this->estoqueService->destroy($id));
    }
}