@extends('layouts.app')

@section('content')
{{-- Estilos Customizados --}}
<style>
    :root {
        --azul-petroleo: #083344;
        --azul-claro: #0e7490;
        --dourado: #d4af37;
        --texto-escuro: #020617;
        --texto-claro: #f8fafc;
    }
    [x-cloak] { display: none !important; }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(8, 51, 68, 0.1);
    }

    /* Animações */
    .fade-in-up {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .float-anim {
        animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-6px); }
        100% { transform: translateY(0px); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .custom-scroll::-webkit-scrollbar { height: 6px; }
    .custom-scroll::-webkit-scrollbar-track { background: #f1f5f9; }
    .custom-scroll::-webkit-scrollbar-thumb { background: var(--azul-petroleo); border-radius: 10px; }
</style>

<div x-data="desempenhoApp()" x-init="init()" class="p-4 md:p-8 max-w-[1400px] mx-auto min-h-screen selection:bg-cyan-100 bg-slate-50">
    
    {{-- Top Action Bar --}}
    <div class="mb-8 fade-in-up flex justify-between items-center">
        <a href="javascript:history.back()" 
           class="inline-flex items-center gap-3 px-6 py-3 bg-white border border-slate-200 rounded-2xl text-[var(--azul-petroleo)] font-black text-xs uppercase tracking-widest shadow-sm hover:shadow-md hover:border-[var(--azul-claro)] transition-all duration-300 group float-anim">
            <svg class="w-4 h-4 transform group-hover:-translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Voltar
        </a>

        <button @click="init()" 
                class="flex items-center gap-3 px-8 py-4 bg-[var(--azul-petroleo)] text-white rounded-2xl hover:bg-cyan-950 transition-all duration-300 shadow-xl active:scale-95 group">
            <svg :class="loading ? 'animate-spin' : ''" class="w-5 h-5 text-[var(--dourado)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span class="text-xs font-black uppercase tracking-widest" x-text="loading ? 'Sincronizando...' : 'Sincronizar Dados'"></span>
        </button>
    </div>

    {{-- Header --}}
    <div class="mb-12 fade-in-up">
        <div class="flex items-center gap-3 mb-2">
            <div class="h-6 w-1.5 bg-gradient-to-b from-[var(--dourado)] to-[var(--azul-petroleo)] rounded-full"></div>
            <span class="text-[11px] font-black text-[var(--azul-claro)] uppercase tracking-[0.4em]">Intelligence Suite</span>
        </div>
        <h2 class="text-4xl font-black text-[var(--azul-petroleo)] tracking-tighter">Análise de <span class="text-[var(--azul-claro)]">Desempenho</span></h2>
        <p class="text-slate-600 font-bold">Gestão estratégica de faturamento e metas da rede.</p>
    </div>

    {{-- Cards de Impacto Superior --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        {{-- Card 1: Vendas --}}
        <div class="glass-card p-10 rounded-[2.5rem] relative overflow-hidden fade-in-up border-l-4 border-l-[var(--dourado)] shadow-xl shadow-slate-200/50">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Volume Faturado (Rede)</p>
            <h3 class="text-4xl font-black text-[var(--texto-escuro)] tracking-tight" x-text="formatarDinheiro(totais.vendas)"></h3>
            <div class="mt-6 flex items-center gap-2 text-emerald-700 font-black">
                <span class="text-xs uppercase tracking-tighter" x-text="totais.qtdConsultoras + ' Ativas no ciclo'"></span>
            </div>
        </div>

        {{-- Card 2: Ticket Médio --}}
        <div class="glass-card p-10 rounded-[2.5rem] fade-in-up shadow-xl shadow-slate-200/50" style="animation-delay: 0.1s">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Ticket Médio Geral</p>
            <h3 class="text-4xl font-black text-[var(--texto-escuro)] tracking-tight" x-text="formatarDinheiro(totais.ticketMedio)"></h3>
            <p class="mt-6 text-[11px] font-black text-[var(--azul-claro)] uppercase">Qualidade média do pedido</p>
        </div>

        {{-- Card 3: Meta Global (Ajustado para Azul Petróleo) --}}
        <div class="p-10 rounded-[2.5rem] bg-[var(--azul-petroleo)] fade-in-up shadow-2xl shadow-cyan-950/40 border border-cyan-800/50 relative overflow-hidden" style="animation-delay: 0.2s">
            <p class="text-[10px] font-black text-cyan-300 uppercase tracking-[0.2em] mb-4">Atingimento de Meta Equipe</p>
            <div class="flex justify-between items-end mb-1">
                <h3 class="text-4xl font-black text-[var(--texto-claro)] tracking-tight" x-text="totais.percentualMetaGlobal + '%'"></h3>
                <span class="text-[10px] font-black text-[var(--dourado)] uppercase pb-1" x-text="'Alvo: ' + formatarDinheiro(totais.metaTotal)"></span>
            </div>
            
            <div class="w-full h-3 bg-cyan-950 rounded-full mt-4 overflow-hidden border border-cyan-800/50">
                <div class="h-full bg-gradient-to-r from-[var(--dourado)] to-yellow-500 transition-all duration-1000" :style="'width: ' + Math.min(totais.percentualMetaGlobal, 100) + '%'"></div>
            </div>
            <p class="mt-4 text-[11px] font-black text-cyan-200/70 uppercase tracking-widest">Faturado: <span class="text-[var(--texto-claro)]" x-text="formatarDinheiro(totais.vendas)"></span></p>
        </div>
    </div>

    {{-- Listagem Principal --}}
    <div class="glass-card rounded-[3rem] shadow-2xl shadow-slate-200/60 overflow-hidden fade-in-up border-none bg-white" style="animation-delay: 0.3s">
        <div class="p-10 border-b border-slate-100">
            <h4 class="text-xl font-black text-[var(--texto-escuro)] uppercase tracking-tighter">Ranking & Metas</h4>
            <p class="text-xs text-slate-500 font-bold uppercase tracking-tight">Análise individual de performance.</p>
        </div>
        
        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] uppercase tracking-[0.25em] text-slate-600 font-black bg-slate-50">
                        <th class="px-12 py-6">Consultora</th>
                        <th class="px-8 py-6">Realizado (Mês)</th>
                        <th class="px-8 py-6">Progresso</th>
                        <th class="px-12 py-6 text-right">Meta Alvo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <template x-for="item in equipe" :key="item.id">
                        <tr class="hover:bg-cyan-50/50 transition-all duration-300 group">
                            <td class="px-12 py-8">
                                <div class="flex items-center gap-5">
                                    <div class="w-14 h-14 rounded-2xl bg-[var(--azul-petroleo)] flex items-center justify-center font-black text-[var(--dourado)] shadow-lg" x-text="item.nome.substring(0,2).toUpperCase()"></div>
                                    <div>
                                        <p class="font-black text-[var(--texto-escuro)] text-sm uppercase tracking-tight" x-text="item.nome"></p>
                                        <p class="text-[10px] text-slate-500 font-black tracking-tight uppercase" x-text="item.email || 'Membro Ativo'"></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-8">
                                <span class="font-black text-slate-800 text-lg" x-text="formatarDinheiro(getVendaAtual(item))"></span>
                            </td>
                            <td class="px-8 py-8">
                                <div class="flex flex-col min-w-[200px]">
                                    <div class="flex justify-between mb-2">
                                        <span class="text-[10px] font-black uppercase tracking-widest" 
                                              :class="getPercentMeta(item) >= 100 ? 'text-emerald-700' : 'text-slate-600'"
                                              x-text="getPercentMeta(item).toFixed(1) + '%'"></span>
                                        <span class="text-[10px] font-black text-slate-400 uppercase" x-text="getPercentMeta(item) >= 100 ? 'Batida!' : 'Em curso'"></span>
                                    </div>
                                    <div class="w-full h-2.5 bg-slate-100 rounded-full overflow-hidden border border-slate-200">
                                        <div class="h-full transition-all duration-1000" 
                                             :class="getPercentMeta(item) >= 100 ? 'bg-emerald-500' : 'bg-[var(--azul-claro)]'"
                                             :style="'width: ' + Math.min(getPercentMeta(item), 100) + '%'"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-12 py-8 text-right">
                                <span class="text-sm font-black text-[var(--texto-escuro)]" x-text="formatarDinheiro(item.valor_meta)"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            
            <template x-if="loading">
                <div class="p-24 text-center flex flex-col items-center bg-white">
                    <div class="w-16 h-16 border-4 border-slate-200 border-t-[var(--dourado)] rounded-full animate-spin mb-6"></div>
                    <p class="text-[10px] font-black text-slate-600 uppercase tracking-[0.3em]">Processando dados da equipe...</p>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
function desempenhoApp() {
    return {
        equipe: [],
        metas: [],
        loading: false,
        totais: { vendas: 0, pedidos: 0, ticketMedio: 0, qtdConsultoras: 0, percentualMetaGlobal: 0, metaTotal: 0 },

        async init() {
            this.loading = true;
            try {
                const [resVendas, resMetas] = await Promise.all([
                    fetch('/api/lider/equipe/desempenho').then(res => res.json()),
                    fetch('/api/meta/historico').then(res => res.json())
                ]);

                if (resVendas.status === 'success' && resMetas.status === 'success') {
                    this.metas = resMetas.data;
                    this.equipe = resVendas.data.map(consultora => {
                        const metaInfo = this.metas.find(m => m.id === consultora.id);
                        const valorMeta = metaInfo?.metas_consultora?.[0]?.valor_meta ?? 0;
                        return { ...consultora, valor_meta: parseFloat(valorMeta) };
                    });
                    this.calcularMetricasGlobais();
                }
            } catch (e) {
                console.error("Erro na carga de dados:", e);
            } finally {
                this.loading = false;
            }
        },

        calcularMetricasGlobais() {
            let totalVendas = 0, totalPedidos = 0, somaMetaTotal = 0;
            
            this.equipe.forEach(c => {
                totalVendas += this.getVendaAtual(c);
                totalPedidos += this.getPedidosAtual(c);
                somaMetaTotal += c.valor_meta || 0;
            });

            this.totais = {
                vendas: totalVendas,
                pedidos: totalPedidos,
                ticketMedio: totalPedidos > 0 ? (totalVendas / totalPedidos) : 0,
                qtdConsultoras: this.equipe.length,
                metaTotal: somaMetaTotal,
                percentualMetaGlobal: somaMetaTotal > 0 ? ((totalVendas / somaMetaTotal) * 100).toFixed(1) : 0
            };
        },

        getVendaAtual(c) { return c.TotalVendido?.[0]?.total_vendas ?? 0; },
        getPedidosAtual(c) { return c.TotalPedidos?.[0]?.total_pedidos ?? 0; },
        getPercentMeta(c) {
            if (!c.valor_meta || c.valor_meta <= 0) return 0;
            return (this.getVendaAtual(c) / c.valor_meta) * 100;
        },
        formatarDinheiro(v) { 
            return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(v); 
        }
    }
}
</script>
@endsection
