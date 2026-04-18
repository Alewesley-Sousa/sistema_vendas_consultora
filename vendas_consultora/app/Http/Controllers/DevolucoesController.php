<?php

namespace App\Http\Controllers;

use App\Services\DevolucaoService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DevolucoesController extends Controller
{
    public function __construct(
        protected DevolucaoService $devolucaoService
    ) {}
/**
     * Listar solicitações pendentes (Distribuidora)
     */
    public function pendentes(): JsonResponse
    {
        if (Auth::user()->cargo !== 'distribuidora') {
            return response()->json(['status' => 'error', 'message' => 'Acesso negado.'], 403);
        }

        $result = $this->devolucaoService->listarPendentes();
        return response()->json($result);
    }
    /**
     * Solicitar uma nova devolução (Consultora)
     */
    public function solicitar(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'pedido_id'         => 'required|exists:pedidos,id',
            'cliente_id'        => 'required|exists:clientes,id',
            'tipo_devolucao_id' => 'required|exists:tipo_devolucao,id',
            'motivo'            => 'nullable|string',
            'itens'             => 'array|required_if:tipo_devolucao_id,1', // Obrigatório se parcial
            'itens.*.item_pedido_id' => 'required_with:itens|exists:itens_pedido,id',
            'itens.*.quantidade'     => 'required_with:itens|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro de validação',
                'errors' => $validator->errors()
            ], 422);
        }

        $result = $this->devolucaoService->solicitarDevolucao($request->all());
        
        $code = ($result['status'] === 'success') ? 201 : 400;
        return response()->json($result, $code);
    }

    /**
     * Aprovar uma devolução (Distribuidora)
     */
    public function aprovar(int $id): JsonResponse
    {
        $result = $this->devolucaoService->aprovarDevolucao($id, Auth::id());
        
        $code = ($result['status'] === 'success') ? 200 : 400;
        return response()->json($result, $code);
    }

    /**
     * Rejeitar uma devolução (Distribuidora)
     */
    public function rejeitar(Request $request, int $id): JsonResponse
    {
        // Opcional: validar se o motivo foi enviado na rejeição
        $result = $this->devolucaoService->rejeitarDevolucao($id, Auth::id(), $request->motivo);
        
        $code = ($result['status'] === 'success') ? 200 : 400;
        return response()->json($result, $code);
    }
}