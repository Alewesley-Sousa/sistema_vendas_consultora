<?php

namespace App\Http\Controllers;

use App\Models\metas;
use App\Services\MetaService;
use Illuminate\Http\Request;

class MetasController extends Controller
{
    protected $metaService;

    public function __construct(MetaService $metaService)
    {
        $this->metaService = $metaService;
    }

    public function metaAtual() {
        $meta = $this->metaService->metaUsuario();

        return response()->json([
            'status' => 'sucesso',
            'data' => $meta
        ]);
    }
}
