<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\pedidos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;


class RelatorioService
{
    public function vendasPessoais(?string $dataInicio = null, ?string $dataFim = null)
    {
        $query = pedidos::where('usuario_id', Auth::id())
            ->whereNotIn('status_id', [1, 7]); // Exclui pendente/cancelado

        $query->when($dataInicio, function ($q) use ($dataInicio) {
            $q->whereDate('created_at', '>=', $dataInicio);
        });

        $query->when($dataFim, function ($q) use ($dataFim) {
            $q->whereDate('created_at', '<=', $dataFim);
        });

        return $query->selectRaw("
                strftime('%Y-%m', created_at) as periodo,
                COUNT(*) as total_pedidos,
                SUM(valor_total) as total_vendas,
                AVG(valor_total) as ticket_medio
            ")
            ->groupBy('periodo')
            ->orderBy('periodo', 'DESC')
            ->get()
            ->map(function ($item) {
                $item->ticket_medio = round((float)$item->ticket_medio, 2);
                $item->total_vendas = round((float)$item->total_vendas, 2);
                return $item;
            });
    }

    public function comissoesDetalhadas(?string $dataInicio = null, ?string $dataFim = null, ?int $tipoId = null)
    {
        $query = DB::table('historico_comissoes as hc')
            ->join('tipo_movimentacao_comissao as tmc', 'hc.tipo_movimentacao_id', '=', 'tmc.id')
            ->where('hc.consultora_id', Auth::id());

        $query->when($dataInicio, function ($q) use ($dataInicio) {
            $q->whereDate('hc.data_movimentacao', '>=', $dataInicio);
        });

        $query->when($dataFim, function ($q) use ($dataFim) {
            $q->whereDate('hc.data_movimentacao', '<=', $dataFim);
        });

        $query->when($tipoId, function ($q) use ($tipoId) {
            $q->where('hc.tipo_movimentacao_id', $tipoId);
        });

        return $query->selectRaw("
                strftime('%Y-%m', hc.data_movimentacao) as periodo,
                tmc.nome as tipo_movimentacao,
                hc.tipo_movimentacao_id,
                SUM(CASE 
                    WHEN hc.tipo_movimentacao_id = 1 THEN hc.valor 
                    WHEN hc.tipo_movimentacao_id = 2 THEN -hc.valor 
                    ELSE 0 
                END) as valor_liquido
            ")
            ->groupBy('periodo', 'tmc.nome', 'hc.tipo_movimentacao_id')
            ->orderBy('periodo', 'DESC')
            ->orderBy('tmc.nome')
            ->get()
            ->map(function ($item) {
                $item->valor_liquido = round((float)$item->valor_liquido, 2);
                return $item;
            });
    }

    /**
     * Processa o desempenho completo da rede.
     */
    public function analisarDesempenhoRede(?string $dataInicio = null, ?string $dataFim = null)
    {
        $userId = Auth::id();

        // 1. Mapeamento da "Família" (CTE Recursiva)
        $rede = $this->mapearRede($userId);
        $redeIds = $rede->pluck('id')->toArray();

        // 2. Definição dos Períodos
        $periodoA_Inicio = $dataInicio ? Carbon::parse($dataInicio)->startOfDay() : Carbon::now()->startOfMonth();
        $periodoA_Fim = $dataFim ? Carbon::parse($dataFim)->endOfDay() : Carbon::now()->endOfDay();

        $periodoB_Inicio = $periodoA_Inicio->copy()->subMonth();
        $periodoB_Fim = $periodoA_Fim->copy()->subMonth();

        // 3. Processamentos de Vendas
        $vendasA = $this->calcularVendasNoPeriodo($redeIds, $periodoA_Inicio, $periodoA_Fim);
        $vendasB = $this->calcularVendasNoPeriodo($redeIds, $periodoB_Inicio, $periodoB_Fim);

        // 4. Processamento de Metas (Passando o objeto Carbon)
        $metasTotais = $this->buscarMetasDaRede($redeIds, $periodoA_Inicio);

        // 5. Cálculos de Comparativos
        $crescimentoPercent = $this->calcularCrescimento($vendasA, $vendasB);
        $percentualMeta = $metasTotais > 0 ? round(($vendasA / $metasTotais) * 100, 2) : 0;

        return [
            'resumo' => [
                'vendas_atuais' => round($vendasA, 2),
                'vendas_anteriores' => round($vendasB, 2),
                'crescimento_percent' => $crescimentoPercent,
                'total_metas' => round($metasTotais, 2),
                'atingimento_meta_percent' => $percentualMeta,
            ],
            'rede' => [
                'total_membros' => count($redeIds),
                'membros_ativos' => $this->contarMembrosAtivos($redeIds, $periodoA_Inicio, $periodoA_Fim),
            ],
            'periodos' => [
                'atual' => [
                    'de' => $periodoA_Inicio->toDateTimeString(),
                    'ate' => $periodoA_Fim->toDateTimeString()
                ],
                'anterior' => [
                    'de' => $periodoB_Inicio->toDateTimeString(),
                    'ate' => $periodoB_Fim->toDateTimeString()
                ],
            ]
        ];
    }

    private function mapearRede(int $userId)
    {
        $sql = "
            WITH RECURSIVE rede_hierarquia AS (
                SELECT id FROM usuarios WHERE id = ?
                UNION ALL
                SELECT u.id FROM usuarios u
                INNER JOIN rede_hierarquia rh ON u.consultora_id = rh.id
            )
            SELECT id FROM rede_hierarquia
        ";
        return collect(DB::select($sql, [$userId]));
    }

    private function calcularVendasNoPeriodo(array $ids, Carbon $inicio, Carbon $fim)
    {
        return (float) DB::table('pedidos')
            ->whereIn('usuario_id', $ids)
            ->whereNotIn('status_id', [1, 7])
            ->whereBetween('created_at', [$inicio, $fim])
            ->sum('valor_total');
    }

    private function buscarMetasDaRede(array $ids, Carbon $periodo)
    {
        return (float) DB::table('metas')
            ->whereIn('consultora_id', $ids)
            ->whereYear('data_referencia', $periodo->year)
            ->whereMonth('data_referencia', $periodo->month)
            ->sum('valor_meta');
    }

    private function calcularCrescimento($atual, $anterior)
    {
        if ($anterior <= 0) {
            return $atual > 0 ? 100.0 : 0.0;
        }
        return round((($atual - $anterior) / $anterior) * 100, 2);
    }

    private function contarMembrosAtivos(array $ids, Carbon $inicio, Carbon $fim)
    {
        return DB::table('pedidos')
            ->whereIn('usuario_id', $ids)
            ->whereBetween('created_at', [$inicio, $fim])
            ->distinct('usuario_id')
            ->count('usuario_id');
    }

    /**
     * Ranking de consultoras por critério e período.
     */
    public function rankingConsultoras(?string $inicio = null, ?string $fim = null, string $criterio = 'vendas', int $limit = 10): array
    {
        // 1. Inicia a Query Base comum a todos os rankings
        $query = DB::table('usuarios as u')
            ->where('u.cargo', 'consultora')
            ->select('u.id', 'u.nome', 'u.telefone');

        // 2. Aplica a estratégia de ranking baseada no critério
        try {
            $query = match ($criterio) {
                'vendas'      => $this->applyVendasRanking($query, $inicio, $fim),
                'comissoes'   => $this->applyComissoesRanking($query, $inicio, $fim),
                'performance' => $this->applyPerformanceRanking($query, $inicio, $fim),
                default       => throw new \InvalidArgumentException("Critério inválido: {$criterio}")
            };

            return $query->limit($limit)
                ->get()
                ->map(fn($item) => $this->formatRankingItem($item, $criterio))
                ->toArray();
        } catch (\Exception $e) {
            // Log ou tratamento de erro conforme sua necessidade
            throw $e;
        }
    }

    /**
     * Ranking por volume total de vendas (Pedidos pagos)
     */
    private function applyVendasRanking($query, $inicio, $fim)
    {
        return $query->leftJoin('pedidos as p', 'u.id', '=', 'p.usuario_id')
            ->whereNotIn('p.status_id', [1, 7]) // Ignora pendentes/cancelados
            ->when($inicio, fn($q) => $q->whereDate('p.created_at', '>=', $inicio))
            ->when($fim, fn($q) => $q->whereDate('p.created_at', '<=', $fim))
            ->groupBy('u.id', 'u.nome', 'u.telefone')
            ->selectRaw('COALESCE(SUM(p.valor_total), 0) as total')
            ->orderByDesc('total');
    }

    /**
     * Ranking por valor líquido de comissões
     */
    private function applyComissoesRanking($query, $inicio, $fim)
    {
        // Subquery para calcular o líquido (Entradas - Saídas)
        $subQuery = DB::table('historico_comissoes')
            ->select('consultora_id')
            ->selectRaw("SUM(CASE WHEN tipo_movimentacao_id = 1 THEN valor ELSE -valor END) as valor_liquido")
            ->when($inicio, fn($q) => $q->whereDate('data_movimentacao', '>=', $inicio))
            ->when($fim, fn($q) => $q->whereDate('data_movimentacao', '<=', $fim))
            ->groupBy('consultora_id');

        return $query->leftJoinSub($subQuery, 'hc', 'u.id', '=', 'hc.consultora_id')
            ->selectRaw('COALESCE(hc.valor_liquido, 0) as total')
            ->orderByDesc('total');
    }

    /**
     * Ranking por % de atingimento da meta (Performance)
     */
    private function applyPerformanceRanking($query, $inicio, $fim)
    {
        return $query->leftJoin('pedidos as p', 'u.id', '=', 'p.usuario_id')
            ->leftJoin('metas as m', 'u.id', '=', 'm.consultora_id')
            ->whereNotIn('p.status_id', [1, 7])
            ->when($inicio, fn($q) => $q->whereDate('p.created_at', '>=', $inicio))
            ->when($fim, fn($q) => $q->whereDate('p.created_at', '<=', $fim))
            ->groupBy('u.id', 'u.nome', 'u.telefone')
            // SQLite: Multiplicamos por 1.0 para forçar float e usamos NULLIF para evitar divisão por zero
            ->selectRaw('
            COALESCE(
                (SUM(p.valor_total) * 1.0) / NULLIF(SUM(DISTINCT m.valor_meta), 0) * 100, 
                0
            ) as total
        ')
            ->orderByDesc('total');
    }

    /**
     * Padroniza a saída do ranking
     */
    private function formatRankingItem($item, $criterio): array
    {
        return [
            'id'       => (int) $item->id,
            'nome'     => $item->nome,
            'telefone' => $item->telefone,
            'total'    => round((float) $item->total, 2),
            'criterio' => $criterio
        ];
    }


    /**
     * Análise de produtos GLOBAL: mais/menos vendidos, estoque crítico.
     */
    public function analiseProdutos(?string $dataInicio = null, ?string $dataFim = null, ?int $limiteEstoque = 10, string $ordem = 'mais_vendidos'): array
    {
        try {
            // 1. Constrói a Query Base
            $query = $this->montarQueryAnalise($dataInicio, $dataFim);

            // 2. Executa e Transforma em Collection formatada
            $produtos = $query->get()->map(fn($item) => $this->formatarItemAnalise($item));

            // 3. Aplica Ordenação e Filtros de Negócio
            $produtos = $this->aplicarOrdenacaoEFiltros($produtos, $ordem, $limiteEstoque);

            // 4. Prepara o Resultado Final (Top 50)
            $produtosFinal = $produtos->values()->take(50);

            return [
                'status' => 'success',
                'dados' => [
                    'produtos' => $produtosFinal,
                    'resumo'   => $this->gerarResumoAnalise($produtosFinal, $limiteEstoque),
                    'filtros'  => compact('dataInicio', 'dataFim', 'limiteEstoque', 'ordem') + ['tipo_analise' => 'global']
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status'   => 'error',
                'mensagem' => "Erro ao gerar análise de produtos: {$e->getMessage()}"
            ];
        }
    }

    /**
     * Isola a complexidade dos JOINs e SelectRaw (Dialeto SQLite compatível)
     */
    private function montarQueryAnalise(?string $inicio, ?string $fim)
    {
        return DB::table('itens_pedido')
            ->join('itens_catalogo', 'itens_pedido.item_catalogo_id', '=', 'itens_catalogo.id')
            ->join('produtos', 'itens_catalogo.produto_id', '=', 'produtos.id')
            ->leftJoin('estoques', 'produtos.id', '=', 'estoques.produto_id')
            ->join('pedidos', 'itens_pedido.pedido_id', '=', 'pedidos.id')
            ->whereNotIn('pedidos.status_id', [1, 7])
            ->when($inicio, fn($q) => $q->whereDate('pedidos.created_at', '>=', $inicio))
            ->when($fim, fn($q) => $q->whereDate('pedidos.created_at', '<=', $fim))
            ->groupBy('produtos.id', 'produtos.nome', 'estoques.quantidade')
            ->selectRaw('
            produtos.id,
            produtos.nome,
            SUM(itens_pedido.quantidade) as total_vendido,
            SUM(itens_pedido.quantidade * itens_pedido.preco_unitario) as faturamento,
            COALESCE(estoques.quantidade, 0) as estoque_atual,
            ROUND(AVG(itens_pedido.preco_unitario), 2) as preco_medio,
            CASE 
                WHEN COALESCE(estoques.quantidade, 0) > 0 
                THEN ROUND(SUM(itens_pedido.quantidade) * 1.0 / estoques.quantidade, 2) 
                ELSE 0 
            END as rotatividade
        ');
    }

    /**
     * Formata os tipos de dados para garantir consistência no JSON
     */
    private function formatarItemAnalise($item): array
    {
        return [
            'id'             => (int) $item->id,
            'nome'           => $item->nome,
            'total_vendido'  => (int) $item->total_vendido,
            'faturamento'    => round((float) $item->faturamento, 2),
            'estoque_atual'  => (int) $item->estoque_atual,
            'preco_medio'    => round((float) $item->preco_medio, 2),
            'rotatividade'   => round((float) $item->rotatividade, 2)
        ];
    }

    /**
     * Gerencia a lógica de ordenação e filtros extras na Collection
     */
    private function aplicarOrdenacaoEFiltros($colecao, $ordem, $limiteEstoque)
    {
        $ordenadores = [
            'mais_vendidos'   => fn($c) => $c->sortByDesc('total_vendido'),
            'menos_vendidos'  => fn($c) => $c->sortBy('total_vendido'),
            'estoque_critico' => fn($c) => $c->where('estoque_atual', '<', $limiteEstoque)->sortBy('estoque_atual'),
        ];

        return isset($ordenadores[$ordem])
            ? $ordenadores[$ordem]($colecao)
            : $colecao->sortByDesc('total_vendido');
    }

    /**
     * Consolida o resumo financeiro e estatístico
     */
    private function gerarResumoAnalise($produtos, $limiteEstoque): array
    {
        return [
            'faturamento_total'         => round($produtos->sum('faturamento'), 2),
            'produtos_estoque_critico'  => $produtos->where('estoque_atual', '<=', $limiteEstoque)->count(),
            'total_produtos_analisados' => $produtos->count()
        ];
    }

    /**
     * Relatório geral de Metas e Bonificações com Escalonamento Profissional.
     */
    public function metasBonificacoes(?string $dataInicio = null, ?string $dataFim = null): array
    {
        try {
            // 1. Prepara a base de dados com as vendas e metas cruzadas
            $query = $this->prepararQueryMetas($dataInicio, $dataFim);

            // 2. Executa a busca
            $metas = $query->get();

            // 3. Consolida o resultado final
            return [
                'status' => 'success',
                'dados' => [
                    'metas' => $metas,
                    'resumo' => $this->gerarResumoColetivo($metas),
                    'filtros' => compact('dataInicio', 'dataFim'),
                    'regra_aplicada' => 'Bonificação Escalonada Profissional (3%, 5%, 8%)'
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'mensagem' => "Falha ao processar relatório: {$e->getMessage()}"
            ];
        }
    }

    /**
     * Constrói a query principal unindo usuários, metas e vendas.
     */
    private function prepararQueryMetas(?string $inicio, ?string $fim)
    {
        return DB::table('metas as m')
            ->join('usuarios as u', 'm.consultora_id', '=', 'u.id')
            ->leftJoinSub($this->subqueryVendasMensais(), 'v', function ($join) {
                $join->on('m.consultora_id', '=', 'v.consultora_id')
                    ->on(DB::raw("strftime('%Y-%m', m.data_referencia)"), '=', 'v.mes_ano');
            })
            ->when($inicio, fn($q) => $q->whereDate('m.data_referencia', '>=', $inicio))
            ->when($fim, fn($q) => $q->whereDate('m.data_referencia', '<=', $fim))
            ->selectRaw($this->definirCamposESequenciaDeBonus())
            ->orderBy('m.data_referencia', 'DESC');
    }

    /**
     * Define a subquery de vendas agregadas por mês e consultora.
     */
    private function subqueryVendasMensais()
    {
        return DB::table('pedidos')
            ->select('usuario_id as consultora_id')
            ->selectRaw("strftime('%Y-%m', created_at) as mes_ano")
            ->selectRaw("SUM(valor_total) as total_vendido")
            ->whereNotIn('status_id', [1, 7])
            ->groupBy('mes_ano', 'consultora_id');
    }

    /**
     * Retorna a string SQL com os cálculos de performance e bônus.
     */
    private function definirCamposESequenciaDeBonus(): string
    {
        return '
        m.id,
        m.consultora_id,
        u.nome,
        m.valor_meta,
        m.data_referencia,
        COALESCE(v.total_vendido, 0) as vendas_realizadas,
        CASE 
            WHEN m.valor_meta > 0 
            THEN ROUND((COALESCE(v.total_vendido, 0) * 100.0) / m.valor_meta, 2) 
            ELSE 0 
        END as percentual_atingimento,
        CASE 
            WHEN (COALESCE(v.total_vendido, 0) * 100.0 / NULLIF(m.valor_meta, 0)) >= 120 
                THEN ROUND(COALESCE(v.total_vendido, 0) * 0.08, 2)
            WHEN (COALESCE(v.total_vendido, 0) * 100.0 / NULLIF(m.valor_meta, 0)) >= 100 
                THEN ROUND(COALESCE(v.total_vendido, 0) * 0.05, 2)
            WHEN (COALESCE(v.total_vendido, 0) * 100.0 / NULLIF(m.valor_meta, 0)) >= 80 
                THEN ROUND(COALESCE(v.total_vendido, 0) * 0.03, 2)
            ELSE 0 
        END as bonificacao
    ';
    }

    /**
     * Gera os totais e indicadores coletivos para o topo do relatório.
     */
    private function gerarResumoColetivo($metas): array
    {
        $totalMetas = $metas->sum('valor_meta');
        $totalVendas = $metas->sum('vendas_realizadas');

        return [
            'faturamento_total_metas'    => round($totalMetas, 2),
            'vendas_totais_realizadas'   => round($totalVendas, 2),
            'percentual_coletivo'        => $totalMetas > 0 ? round(($totalVendas / $totalMetas) * 100, 2) : 0,
            'total_bonificacoes_pagar'   => round($metas->sum('bonificacao'), 2),
            'quantidade_metas_atingidas' => $metas->where('percentual_atingimento', '>=', 100)->count(),
            'consultoras_em_alerta'      => $metas->where('percentual_atingimento', '<', 80)->count()
        ];
    }

    /**
     * Relatório Histórico de Retenção Global - Visão Administrador.
     */
    public function relatorioRetencaoMensal(?int $limiteMeses = 12, ?int $consultoraId = null): array
    {
        try {
            // 1. Busca as métricas globais ou filtradas por consultora
            $historicoMensal = $this->buscarMetricasMensaisGlobais($limiteMeses, $consultoraId);

            // 2. Processa os Cohorts globais
            $analiseCohorts = $this->processarAnaliseCohortsGlobal($consultoraId);

            return [
                'status' => 'success',
                'dados' => [
                    'historico' => $historicoMensal,
                    'cohorts'   => $analiseCohorts,
                    'resumo_geral' => [
                        'periodo_analisado' => "$limiteMeses meses",
                        'faturamento_total' => round($historicoMensal->sum('faturamento'), 2),
                        'media_recorrencia_global' => round($historicoMensal->avg('taxa_recorrencia'), 2) . '%',
                    ],
                    'filtro_aplicado' => $consultoraId ? "Consultora ID: $consultoraId" : "Geral (Toda a Base)"
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status'   => 'error',
                'mensagem' => "Erro ao processar visão admin: " . $e->getMessage()
            ];
        }
    }

    /**
     * Agrega dados de TODOS os pedidos da plataforma.
     */
    private function buscarMetricasMensaisGlobais($limiteMeses, $consultoraId)
    {
        return DB::table('pedidos as p')
            ->selectRaw('strftime("%Y-%m", p.created_at) as mes')
            ->selectRaw('COUNT(DISTINCT p.cliente_id) as total_clientes')
            ->selectRaw('SUM(p.valor_total) as faturamento_mensal')
            ->selectRaw('
            COUNT(DISTINCT (
                SELECT p2.cliente_id 
                FROM pedidos p2 
                WHERE p2.cliente_id = p.cliente_id 
                AND p2.created_at < p.created_at
                AND p2.status_id NOT IN (1, 7)
            )) as clientes_recorrentes
        ')
            // Removemos o Auth::id() e usamos o filtro opcional
            ->when($consultoraId, fn($q) => $q->where('p.usuario_id', $consultoraId))
            ->whereNotIn('p.status_id', [1, 7])
            ->groupBy('mes')
            ->orderBy('mes', 'DESC')
            ->limit($limiteMeses)
            ->get()
            ->map(function ($item) {
                $total = (int) $item->total_clientes;
                $recorrentes = (int) $item->clientes_recorrentes;

                return [
                    'mes'               => $item->mes,
                    'faturamento'       => round((float) $item->faturamento_mensal, 2),
                    'total_clientes'    => $total,
                    'novos_clientes'    => $total - $recorrentes,
                    'recorrentes'       => $recorrentes,
                    'taxa_recorrencia'  => $total > 0 ? round(($recorrentes / $total) * 100, 2) : 0,
                    'ticket_medio'      => $total > 0 ? round($item->faturamento_mensal / $total, 2) : 0
                ];
            });
    }

    /**
     * Cohorts Globais (Base de clientes de toda a empresa).
     */
    private function processarAnaliseCohortsGlobal($consultoraId)
    {
        return DB::table('pedidos as p1')
            ->selectRaw('
            strftime("%Y-%m", p1.created_at) as mes_entrada,
            COUNT(DISTINCT p1.cliente_id) as tamanho_grupo
        ')
            ->when($consultoraId, fn($q) => $q->where('p1.usuario_id', $consultoraId))
            ->selectRaw('
            COUNT(DISTINCT (
                SELECT p2.cliente_id 
                FROM pedidos p2 
                WHERE p2.cliente_id = p1.cliente_id 
                AND strftime("%Y-%m", p2.created_at) >= strftime("%Y-%m", date(p1.created_at, "+3 months"))
            )) as retidos_3_meses
        ')
            ->groupBy('mes_entrada')
            ->orderBy('mes_entrada', 'DESC')
            ->limit(6)
            ->get();
    }

    /**
     * Crescimento da Rede: Filtra a rede por permissão e isola distribuidoras.
     */
    public function crescimentoRede(?string $dataInicio = null, ?string $dataFim = null): array
    {
        try {
            $usuario = Auth::user();
            $isDistribuidora = $usuario->cargo === 'distribuidora';

            if ($isDistribuidora) {
                // A distribuidora vê todos que NÃO são distribuidoras (consultoras, líderes, etc)
                $todasConsultoras = DB::table('usuarios')
                    ->where('cargo', '!=', 'distribuidora')
                    ->select('id', 'nome', 'consultora_id', 'created_at', 'cargo')
                    ->get();
            } else {
                // Consultora só vê a si mesma e quem está abaixo dela
                $sqlRecursivo = "
                WITH RECURSIVE rede_descendente AS (
                    SELECT id, nome, consultora_id, created_at, cargo
                    FROM usuarios
                    WHERE id = ?
                    UNION ALL
                    SELECT u.id, u.nome, u.consultora_id, u.created_at, u.cargo
                    FROM usuarios u
                    INNER JOIN rede_descendente rd ON u.consultora_id = rd.id
                )
                SELECT * FROM rede_descendente 
                WHERE cargo != 'distribuidora' OR id = ?
            ";

                $resultados = DB::select($sqlRecursivo, [$usuario->id, $usuario->id]);
                $todasConsultoras = collect($resultados);
            }

            $redeIds = $todasConsultoras->pluck('id')->toArray();

            // 2. Evolução de novos cadastros (Exclui distribuidoras automaticamente pelo whereIn)
            $evolucao = DB::table('usuarios')
                ->whereIn('id', $redeIds)
                ->selectRaw("strftime('%Y-%m', created_at) as mes, COUNT(*) as novos")
                ->when($dataInicio, fn($q) => $q->whereDate('created_at', '>=', $dataInicio))
                ->when($dataFim, fn($q) => $q->whereDate('created_at', '<=', $dataFim))
                ->groupBy('mes')
                ->orderBy('mes', 'DESC')
                ->get();

            // 3. Retenção (Apenas da rede visível e sem cargo distribuidora)
            $cutoff = now()->subMonths(6)->toDateTimeString();
            $ativos = DB::table('usuarios as u')
                ->leftJoin('pedidos as p', 'u.id', '=', 'p.usuario_id')
                ->whereIn('u.id', $redeIds)
                ->groupBy('u.id')
                ->havingRaw('MAX(p.created_at) >= ? OR u.created_at >= ?', [$cutoff, $cutoff])
                ->get()
                ->count();

            $totalRede = count($redeIds);

            // 4. Montagem da Árvore
            $rootId = $isDistribuidora ? null : $usuario->id;
            $tree = $this->montarArvorePerformance($todasConsultoras, $rootId);

            return [
                'status' => 'success',
                'dados' => [
                    'resumo' => [
                        'perfil_visao' => $usuario->cargo,
                        'total_na_rede' => $totalRede,
                        'consultoras_ativas' => $ativos,
                        'taxa_retencao_percentual' => $totalRede > 0 ? round(($ativos / $totalRede) * 100, 2) : 0
                    ],
                    'evolucao_mensal' => $evolucao,
                    'estrutura_arvore' => array_values($tree)
                ]
            ];
        } catch (\Exception $e) {
            return ['status' => 'error', 'mensagem' => 'Erro ao processar rede: ' . $e->getMessage()];
        }
    }

    /**
     * Montagem otimizada da árvore hierárquica.
     */
    private function montarArvorePerformance($usuarios, $rootId = null)
    {
        $dataset = [];

        // 1. Indexa todos os usuários pelo ID para acesso rápido
        foreach ($usuarios as $u) {
            $dataset[$u->id] = [
                'id' => $u->id,
                'nome' => $u->nome,
                'cargo' => $u->cargo,
                'cadastro' => $u->created_at,
                'subordinados' => []
            ];
        }

        $tree = [];
        foreach ($dataset as $id => &$node) {
            // Pega o objeto original para saber quem é o pai
            $userObj = $usuarios->firstWhere('id', $id);
            $paiId = $userObj->consultora_id ?? null;

            // SE for o nó raiz que solicitamos OU se for uma distribuidora (que não tem pai)
            if ($id == $rootId || (is_null($rootId) && !$paiId)) {
                $tree[] = &$node;
            } else {
                // Se o pai existe no nosso set de dados, adiciona como subordinado
                if (isset($dataset[$paiId])) {
                    $dataset[$paiId]['subordinados'][] = &$node;
                }
            }
        }

        return $tree;
    }


    /**
     * Financeiro Consolidado: Fluxo de caixa global detalhado por mês.
     */
    public function financeiroConsolidado(?string $dataInicio = null, ?string $dataFim = null): array
    {
        try {
            // IDs de todos que não são administradores/distribuidoras para compor a rede operacional
            $operacionalIds = DB::table('usuarios')
                ->where('cargo', '!=', 'distribuidora')
                ->pluck('id')
                ->toArray();

            // 1. Faturamento (Entradas de Pedidos Aprovados)
            $faturamentoMensal = DB::table('pagamentos')
                ->selectRaw('strftime("%Y-%m", data_confirmacao) as mes, SUM(valor) as total')
                ->where('status', 'aprovado')
                ->when($dataInicio, fn($q) => $q->whereDate('data_confirmacao', '>=', $dataInicio))
                ->when($dataFim, fn($q) => $q->whereDate('data_confirmacao', '<=', $dataFim))
                ->groupBy('mes')
                ->get()
                ->keyBy('mes');

            // 2. Comissões Geradas (Custo da Rede)
            $comissoesMensais = DB::table('comissoes')
                ->selectRaw('strftime("%Y-%m", created_at) as mes, SUM(saldo_liquido) as total')
                ->whereIn('consultora_id', $operacionalIds)
                ->when($dataInicio, fn($q) => $q->whereDate('created_at', '>=', $dataInicio))
                ->when($dataFim, fn($q) => $q->whereDate('created_at', '<=', $dataFim))
                ->groupBy('mes')
                ->get()
                ->keyBy('mes');

            // 3. Saques Pagos (Saída Real de Caixa)
            $saquesMensais = collect();
            if (Schema::hasTable('solicitacoes_saque')) {
                $saquesMensais = DB::table('solicitacoes_saque')
                    ->selectRaw('strftime("%Y-%m", updated_at) as mes, SUM(valor_solicitado) as total')
                    ->where('status_id', 4) // Pago
                    ->when($dataInicio, fn($q) => $q->whereDate('updated_at', '>=', $dataInicio))
                    ->groupBy('mes')
                    ->get()
                    ->keyBy('mes');
            }

            // 4. Consolidação da Linha do Tempo
            $mesesUnicos = $faturamentoMensal->keys()
                ->concat($comissoesMensais->keys())
                ->concat($saquesMensais->keys())
                ->unique()
                ->filter()
                ->sortDesc();

            $fluxoMensal = $mesesUnicos->map(function ($mes) use ($faturamentoMensal, $comissoesMensais, $saquesMensais) {
                $vendas = $faturamentoMensal->get($mes)->total ?? 0;
                $comissoes = $comissoesMensais->get($mes)->total ?? 0;
                $saques = $saquesMensais->get($mes)->total ?? 0;

                return [
                    'mes' => $mes,
                    'faturamento_bruto' => round($vendas, 2),
                    'custo_comissoes'   => round($comissoes, 2),
                    'saídas_saques'     => round($saques, 2),
                    'lucro_operacional' => round($vendas - $comissoes - $saques, 2)
                ];
            })->values();

            return [
                'status' => 'success',
                'dados' => [
                    'resumo_geral' => [
                        'faturamento_total' => round($fluxoMensal->sum('faturamento_bruto'), 2),
                        'comissoes_totais'  => round($fluxoMensal->sum('custo_comissoes'), 2),
                        'saques_totais'     => round($fluxoMensal->sum('saídas_saques'), 2),
                        'lucro_acumulado'   => round($fluxoMensal->sum('lucro_operacional'), 2)
                    ],
                    'listagem_mensal' => $fluxoMensal,
                    'periodo' => [
                        'desde' => $dataInicio ?? 'Início',
                        'ate'   => $dataFim ?? 'Hoje'
                    ]
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'mensagem' => 'Falha na análise financeira geral: ' . $e->getMessage()
            ];
        }
    }
}
