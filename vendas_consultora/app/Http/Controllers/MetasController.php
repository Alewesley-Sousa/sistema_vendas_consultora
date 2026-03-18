<?php

namespace App\Http\Controllers;

use App\Models\metas;
use App\Services\MetaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MetasController extends Controller
{
    protected $metaService;

    public function __construct(MetaService $metaService)
    {
        $this->metaService = $metaService;
    }

    public function metaAtual($idUsuario) {
        $meta = $this->metaService->metaUsuario($idUsuario);
        return response()->json([
            'status' => 'sucesso',
            'data' => $meta->toArray()
        ]);
    }

    public function progressoMeta() {
        $progresso = $this->metaService->progressoMeta();
        return response()->json([
            'status' => 'sucesso',
            'data' => $progresso
        ]);
    }
}
