@extends('layouts.appAdmin')

@section('header', 'Painel de Controle')

@section('content')
<style>
    .bg-aurora-gradient {
        background: radial-gradient(
            220px circle at var(--mouse-x, 0px) var(--mouse-y, 0px),
            rgba(212, 163, 89, 0.4) 0%,     /* Dourado GLOW */
            rgba(168, 85, 247, 0.2) 50%,    /* Roxo Transparente */
            transparent 100%
        );
    }
</style>

<div class="space-y-8 bg-[#f8fafc] p-4 sm:p-6 rounded-[2rem]"
     x-data="{ 
        dados: null,
        loading: true,
        erro: false,
        chart: null,
        pieChart: null,
        lineChart: null,

        // Estados reativos locais para a animação de contagem incremental
        faturamentoAlvoAnimado: 0,
        volumeRealizadoAnimado: 0,
        bonusPagarAnimado: 0,
        consultorasAlertaAnimado: 0,

        init() {
            axios.get('/api/relatorios/metas-bonificacoes')
                .then(response => {
                    if (response.data && response.data.data && response.data.data.dados) {
                        this.dados = response.data.data.dados;
                        this.loading = false; 

                        this.$nextTick(() => {
                            this.inicializarERenderizarGraficos();
                            this.initAuroraEffects();
                            
                            // Dispara as animações de subida dos números de forma assíncrona
                            this.animarValor('faturamentoAlvoAnimado', this.dados.resumo.faturamento_total_metas);
                            this.animarValor('volumeRealizadoAnimado', this.dados.resumo.vendas_totais_realizadas);
                            this.animarValor('bonusPagarAnimado', this.dados.resumo.total_bonificacoes_pagar);
                            this.animarValor('consultorasAlertaAnimado', this.dados.resumo.consultoras_em_alerta);
                        });
                    } else {
                        this.erro = true;
                        this.loading = false;
                    }
                })
                .catch(error => {
                    console.error('Erro ao alimentar o painel de controle:', error);
                    this.erro = true;
                    this.loading = false;
                });
        },

        // Função genérica de animação de números (Count-Up) usando requestAnimationFrame
        animarValor(propriedade, valorFinal, duracao = 1200) {
            const valorFinalNum = parseFloat(valorFinal) || 0;
            if (valorFinalNum === 0) return;

            const tempoInicial = performance.now();
            
            const passo = (tempoAtual) => {
                const progresso = Math.min((tempoAtual - tempoInicial) / duracao, 1);
                
                // Aplica o valor incremental baseado na progressão do tempo
                this[propriedade] = progresso * valorFinalNum;

                if (progresso < 1) {
                    requestAnimationFrame(passo);
                } else {
                    this[propriedade] = valorFinalNum; // Garante a precisão exata do número final
                }
            };

            requestAnimationFrame(passo);
        },

        inicializarERenderizarGraficos() {
            if (!this.dados.metas || this.dados.metas.length === 0) return;

            const amostragem = this.dados.metas.slice(0, 6);
            const nomes = amostragem.map(m => m.nome.split(' ')[0]);

            // 1º Gráfico: Barras Comparativas (Principal)
            const optionsBar = {
                chart: {
                    type: 'bar',
                    height: 260,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif'
                },
                colors: ['#6366f1', '#10b981'], 
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '45%',
                        borderRadius: 5
                    }
                },
                dataLabels: { enabled: false },
                grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
                series: [
                    { name: 'Meta Alvo', data: amostragem.map(m => m.valor_meta) },
                    { name: 'Vendas Realizadas', data: amostragem.map(m => m.vendas_realizadas) }
                ],
                xaxis: {
                    categories: nomes,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { style: { colors: '#94a3b8', fontSize: '11px' } }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#94a3b8', fontSize: '11px' },
                        formatter: (val) => 'R$ ' + val.toLocaleString('pt-BR', { minimumFractionDigits: 0 })
                    }
                },
                tooltip: {
                    theme: 'light',
                    y: { formatter: (val) => 'R$ ' + val.toLocaleString('pt-BR', { minimumFractionDigits: 2 }) }
                }
            };

            // 2º Gráfico: Distribuição de Status (Donut)
            const alcancadas = this.dados.resumo.quantidade_metas_atingidas || 0;
            const alerta = this.dados.resumo.consultoras_em_alerta || 0;
            const totalFiltro = this.dados.metas.length;
            const emProgresso = Math.max(0, totalFiltro - (alcancadas + alerta));

            const optionsPie = {
                chart: {
                    type: 'donut',
                    height: 240,
                    fontFamily: 'Inter, sans-serif'
                },
                colors: ['#10b981', '#fbbf24', '#f43f5e'],
                labels: ['Metas Alcançadas', 'Em Progresso', 'Em Alerta'],
                series: [alcancadas, emProgresso, alerta],
                dataLabels: { enabled: false },
                legend: {
                    position: 'bottom',
                    fontSize: '11px',
                    labels: { colors: '#64748b' }
                },
                stroke: { width: 2, colors: ['#fff'] },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '75%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    fontSize: '12px',
                                    fontWeight: 'bold',
                                    color: '#94a3b8',
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                }
            };

            // 3º Gráfico: Curva de Crescimento/Performance (Line)
            const optionsLine = {
                chart: {
                    type: 'line',
                    height: 260,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif'
                },
                colors: ['#8b5cf6'],
                stroke: { width: 3, curve: 'smooth' },
                series: [{ 
                    name: 'Atingimento Real', 
                    data: amostragem.map(m => parseFloat(m.percentual_atingimento || 0)) 
                }],
                grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
                xaxis: {
                    categories: nomes,
                    labels: { style: { colors: '#94a3b8', fontSize: '11px' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#94a3b8', fontSize: '11px' },
                        formatter: (val) => Number(val).toFixed(0) + '%'
                    }
                },
                tooltip: {
                    theme: 'light',
                    y: { formatter: (val) => Number(val).toFixed(1) + '%' }
                }
            };

            this.chart = new ApexCharts(this.$refs.dashboardChart, optionsBar);
            this.chart.render();

            this.pieChart = new ApexCharts(this.$refs.pieChartContainer, optionsPie);
            this.pieChart.render();

            this.lineChart = new ApexCharts(this.$refs.lineChartContainer, optionsLine);
            this.lineChart.render();
        },

        initAuroraEffects() {
            document.querySelectorAll('[data-aurora-card]').forEach((card) => {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    card.style.setProperty('--mouse-x', `${e.clientX - rect.left}px`);
                    card.style.setProperty('--mouse-y', `${e.clientY - rect.top}px`);
                });
            });
        }
     }">

    <template x-if="loading">
        <div class="flex flex-col items-center justify-center py-24 space-y-4">
            <div class="animate-spin rounded-full h-9 w-9 border-b-2 border-indigo-600"></div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest animate-pulse">Sincronizando com a API Comercial...</p>
        </div>
    </template>

    <template x-if="erro && !loading">
        <div class="p-6 bg-rose-50 border border-rose-100 rounded-2xl text-rose-700 text-center text-xs font-bold uppercase tracking-wider shadow-sm">
            ⚠️ Erro de comunicação. Verifique a rota /api/relatorios/metas-bonificacoes ou os cabeçalhos do Sanctum.
        </div>
    </template>

    <template x-if="!loading && !erro && dados">
        <div class="space-y-8">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div data-aurora-card class="relative p-[1px] bg-slate-200/60 rounded-2xl overflow-hidden group/aurora transition-all duration-300 hover:shadow-lg">
                    <div class="absolute inset-0 opacity-0 group-hover/aurora:opacity-100 bg-aurora-gradient transition-opacity duration-300 pointer-events-none z-0"></div>
                    <div class="relative z-10 p-6 bg-white rounded-[15px] h-full flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Faturamento Alvo</span>
                            <div class="w-9 h-9 rounded-xl bg-slate-50 text-slate-700 flex items-center justify-center border border-slate-200/60">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight" x-text="'R$ ' + Number(faturamentoAlvoAnimado).toLocaleString('pt-BR', {minimumFractionDigits: 2})">R$ 0,00</h3>
                            <p class="mt-2 inline-flex items-center gap-1 text-[10px] text-slate-400 font-bold uppercase tracking-wide">Planejado por Metas</p>
                        </div>
                    </div>
                </div>

                <div data-aurora-card class="relative p-[1px] bg-slate-200/60 rounded-2xl overflow-hidden group/aurora transition-all duration-300 hover:shadow-lg">
                    <div class="absolute inset-0 opacity-0 group-hover/aurora:opacity-100 bg-aurora-gradient transition-opacity duration-300 pointer-events-none z-0"></div>
                    <div class="relative z-10 p-6 bg-white rounded-[15px] h-full flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Volume Realizado</span>
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-emerald-600 tracking-tight" x-text="'R$ ' + Number(volumeRealizadoAnimado).toLocaleString('pt-BR', {minimumFractionDigits: 2})">R$ 0,00</h3>
                            <p class="mt-2 inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] bg-emerald-50 text-emerald-700 font-bold" x-text="Number(dados.resumo.percentual_coletivo).toFixed(2) + '% coletivo'"></p>
                        </div>
                    </div>
                </div>

                <div data-aurora-card class="relative p-[1px] bg-slate-200/60 rounded-2xl overflow-hidden group/aurora transition-all duration-300 hover:shadow-lg">
                    <div class="absolute inset-0 opacity-0 group-hover/aurora:opacity-100 bg-aurora-gradient transition-opacity duration-300 pointer-events-none z-0"></div>
                    <div class="relative z-10 p-6 bg-white rounded-[15px] h-full flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Bônus a Pagar</span>
                            <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-indigo-600 tracking-tight" x-text="'R$ ' + Number(bonusPagarAnimado).toLocaleString('pt-BR', {minimumFractionDigits: 2})">R$ 0,00</h3>
                            <p class="text-[11px] text-slate-400 font-semibold mt-2 uppercase tracking-wide" x-text="dados.resumo.quantidade_metas_atingidas + ' metas alcançadas'"></p>
                        </div>
                    </div>
                </div>

                <div data-aurora-card class="relative p-[1px] bg-slate-200/60 rounded-2xl overflow-hidden group/aurora transition-all duration-300 hover:shadow-lg">
                    <div class="absolute inset-0 opacity-0 group-hover/aurora:opacity-100 bg-aurora-gradient transition-opacity duration-300 pointer-events-none z-0"></div>
                    <div class="relative z-10 p-6 bg-white rounded-[15px] h-full flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Consultoras em Alerta</span>
                            <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center border border-rose-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-rose-600 tracking-tight" x-text="Math.floor(consultorasAlertaAnimado)">0</h3>
                            <p class="text-[11px] text-rose-500 font-bold mt-2 uppercase tracking-wider">Abaixo da performance</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-2 p-6 bg-white border border-slate-200/80 rounded-2xl shadow-sm flex flex-col justify-between">
                    <div>
                        <h4 class="text-base font-bold text-slate-900 tracking-tight">Gráfico Comparativo de Metas</h4>
                        <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wider mb-4">Alvo estipulado vs. Venda Realizada por profissional</p>
                    </div>
                    <div x-ref="dashboardChart"></div>
                </div>

                <div class="p-6 bg-white border border-slate-200/80 rounded-2xl shadow-sm flex flex-col justify-between">
                    <div>
                        <h4 class="text-base font-bold text-slate-900 tracking-tight">Status do Ecossistema</h4>
                        <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wider mb-4">Proporção operacional da rede</p>
                    </div>
                    <div class="py-2" x-ref="pieChartContainer"></div>
                </div>

                <div class="lg:col-span-2 p-6 bg-white border border-slate-200/80 rounded-2xl shadow-sm flex flex-col justify-between">
                    <div>
                        <h4 class="text-base font-bold text-slate-900 tracking-tight">Curva de Atingimento %</h4>
                        <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wider mb-4">Nível de assertividade em relação à meta (100% como base alvo)</p>
                    </div>
                    <div x-ref="lineChartContainer"></div>
                </div>

                <div class="p-6 bg-white border border-slate-200/80 rounded-2xl shadow-sm flex flex-col justify-between">
                    <div>
                        <h4 class="text-base font-bold text-slate-900 tracking-tight mb-1">Regra de Negócio</h4>
                        <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wider mb-6">Mecanismo ativo na controller</p>
                        
                        <div class="p-4 bg-indigo-50/70 border border-indigo-100 rounded-xl">
                            <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest block mb-1">Escalonamento Activo</span>
                            <p class="text-xs font-bold text-indigo-950 leading-relaxed" x-text="dados.regra_aplicada"></p>
                        </div>
                    </div>
                    
                    <div class="text-[11px] text-slate-400 bg-slate-50 p-3 rounded-lg border border-slate-100 leading-normal">
                        💡 Este bloco lê diretamente as regras estruturadas na resposta JSON da rota de relatórios comerciais.
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white border border-slate-200/80 rounded-2xl shadow-sm">
                <div class="mb-4">
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Status de Alvos Recentes</h4>
                    <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wider">Lista dinâmica mapeada pelo retorno do JSON da API</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50 text-slate-500 font-bold uppercase tracking-wider">
                                <th class="p-3">Consultora / Profissional</th>
                                <th class="p-3 text-right">Meta Alvo</th>
                                <th class="p-3 text-right">Realizado</th>
                                <th class="p-3 text-center">Atingimento</th>
                                <th class="p-3 text-right rounded-r-lg">Bônus Gerado</th>
                            </tr>
                        </thead>
                        <tbody class="font-medium text-slate-700">
                            <template x-for="item in dados.metas.slice(0, 5)" :key="item.id">
                                <tr class="border-b border-slate-100 hover:bg-slate-50/40 transition-colors">
                                    <td class="p-3 font-bold text-slate-900" x-text="item.nome"></td>
                                    <td class="p-3 text-right font-semibold text-slate-600" x-text="'R$ ' + Number(item.valor_meta).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></td>
                                    <td class="p-3 text-right font-bold text-slate-900" x-text="'R$ ' + Number(item.vendas_realizadas).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></td>
                                    <td class="p-3 text-center">
                                        <span class="px-2.5 py-0.5 rounded text-[10px] font-extrabold border"
                                              :class="item.percentual_atingimento >= 100 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : (item.percentual_atingimento > 0 ? 'bg-amber-50 text-amber-700 border-amber-200' : 'bg-slate-50 text-slate-400 border-slate-200')"
                                              x-text="Number(item.percentual_atingimento).toFixed(1) + '%'">
                                        </span>
                                    </td>
                                    <td class="p-3 text-right font-black text-indigo-600" x-text="'R$ ' + Number(item.bonificacao).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </template>
</div>
@endsection
