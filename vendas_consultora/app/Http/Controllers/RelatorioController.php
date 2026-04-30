<?php

namespace App\Http\Controllers;

use App\Services\RelatorioService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RelatorioController extends Controller
{
    public function vendasPessoais(Request $request, RelatorioService $service): JsonResponse
    {
        $dados = $service->vendasPessoais(
            $request->query('data_inicio'),
            $request->query('data_fim')
        );
        $dataInicio = $request->query('data_inicio');
        $dataFim = $request->query('data_fim');
        
        $dados = $service->vendasPessoais($dataInicio, $dataFim);

        return response()->json([
            'status' => 'success',
            'data' => $dados
        ]);
    }

    public function comissoesDetalhadas(Request $request, RelatorioService $service): JsonResponse
    {
        $dados = $service->comissoesDetalhadas(
            $request->query('data_inicio'),
            $request->query('data_fim'),
            $request->query('tipo_id') ? (int)$request->query('tipo_id') : null
        );

        return response()->json([
            'status' => 'success',
            'data' => $dados
        ]);
    }

    public function desempenhoRede(Request $request, RelatorioService $service): JsonResponse
    {
        // O Laravel resolve o $service automaticamente para você
        $dataInicio = $request->query('data_inicio');
        $dataFim = $request->query('data_fim');
        
        try {
            // Chamando o novo método refatorado
            $dados = $service->analisarDesempenhoRede($dataInicio, $dataFim);

            return response()->json([
                'status' => 'success',
                'data' => $dados
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'mensagem' => 'Erro ao processar relatório: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ranking de consultoras.
     */
    public function rankingConsultoras(Request $request, RelatorioService $service): JsonResponse
    {
        $dataInicio = $request->query('data_inicio');
        $dataFim = $request->query('data_fim');
        $criterio = $request->query('criterio', 'vendas');
        $limit = (int) $request->query('limit', 10);
        
        try {
            $dados = $service->rankingConsultoras($dataInicio, $dataFim, $criterio, $limit);

            return response()->json([
                'status' => 'success',
                'data' => $dados,
                'filtros' => [
                    'criterio' => $criterio,
                    'limit' => $limit
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'mensagem' => 'Erro ao gerar ranking: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Análise de produtos.
     */
    public function analiseProdutos(Request $request, RelatorioService $service): JsonResponse
    {
        $dataInicio = $request->query('data_inicio');
        $dataFim = $request->query('data_fim');
        $thresholdEstoque = (int) $request->query('threshold_estoque', 10);
        $ordem = $request->query('ordem', 'mais_vendidos');
        
        try {
            $dados = $service->analiseProdutos($dataInicio, $dataFim, $thresholdEstoque, $ordem);

            return response()->json([
                'status' => 'success',
                'data' => $dados
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'mensagem' => 'Erro ao gerar análise de produtos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Metas e Bonificações (Admin geral)
     */
    public function metasBonificacoes(Request $request, RelatorioService $service): JsonResponse
    {
        $dataInicio = $request->query('data_inicio');
        $dataFim = $request->query('data_fim');
        
        try {
            $dados = $service->metasBonificacoes($dataInicio, $dataFim);

            return response()->json([
                'status' => 'success',
                'data' => $dados
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'mensagem' => 'Erro ao gerar relatório de metas: ' . $e->getMessage()
            ], 500);
        }
    }

/**
 * Retenção de Clientes (Evolução Mensal)
 */
public function retencaoClientes(Request $request, RelatorioService $service): JsonResponse
{
    $meses = $request->query('meses', 12);
    $consultoraId = $request->query('consultora_id'); // Opcional

    try {
        $resultado = $service->relatorioRetencaoMensal((int) $meses, $consultoraId ? (int) $consultoraId : null);
        return response()->json($resultado);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'mensagem' => $e->getMessage()], 500);
    }
}

/**
 * Crescimento da Rede (Visão Dinâmica)
 */
public function crescimentoRede(Request $request, RelatorioService $service): JsonResponse
{
    $dataInicio = $request->query('data_inicio');
    $dataFim = $request->query('data_fim');
    
    try {
        // O Service já resolve a lógica de Distribuidora vs Consultora
        // e já retorna o array no formato ['status' => ..., 'dados' => ...]
        $resultado = $service->crescimentoRede($dataInicio, $dataFim);

        // Retornamos o resultado diretamente. 
        // Se o service der erro interno capturado pelo try/catch de lá,
        // ele já virá com 'status' => 'error'.
        return response()->json($resultado);

    } catch (\Exception $e) {
        // Erro inesperado (ex: banco fora do ar no Termux)
        return response()->json([
            'status' => 'error',
            'mensagem' => 'Erro crítico ao gerar relatório: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Financeiro Consolidado: Fluxo de caixa detalhado.
 */
public function financeiroConsolidado(Request $request, RelatorioService $service): JsonResponse
{
    $dataInicio = $request->query('data_inicio');
    $dataFim = $request->query('data_fim');
    
    try {
        // O Service já lida com a lógica de cargo (distribuidora vs consultora)
        // e retorna o array formatado com ['status' => 'success', 'dados' => [...]]
        $resultado = $service->financeiroConsolidado($dataInicio, $dataFim);

        // Retornamos o array do service diretamente
        return response()->json($resultado);

    } catch (\Exception $e) {
        // Captura falhas críticas (ex: erro de conexão com SQLite no Termux)
        return response()->json([
            'status' => 'error',
            'mensagem' => 'Erro crítico ao processar financeiro: ' . $e->getMessage()
        ], 500);
    }
}


}
