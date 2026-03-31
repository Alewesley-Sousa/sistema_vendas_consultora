<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatalogosRequest;
use App\Services\CatalogoService;
use Illuminate\Http\JsonResponse;

class CatalogosController extends Controller
{
    public function __construct(
        protected CatalogoService $CatalogoService
    ) {}

    public function index(): JsonResponse
    {
        $result = $this->CatalogoService->index();
        return response()->json($result);
    }

    public function store(CatalogosRequest $request): JsonResponse
    {
        $result = $this->CatalogoService->store($request->validated());
        return response()->json($result, 201);
    }

    public function show(int $id): JsonResponse
    {
        $result = $this->CatalogoService->show($id);
        return response()->json($result);
    }

    public function update(CatalogosRequest $request, int $id): JsonResponse
    {
        $result = $this->CatalogoService->update($request->validated(), $id);
        return response()->json($result);
    }

    public function destroy(int $id): JsonResponse
    {
        $result = $this->CatalogoService->destroy($id);
        return response()->json($result);
    }
}