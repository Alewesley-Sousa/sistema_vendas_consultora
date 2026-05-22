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

<div class="space-y-8 bg-[#f8fafc] p-4 sm:p-6 rounded-[2rem]">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div data-aurora-card class="relative p-[1px] bg-slate-200/60 rounded-2xl overflow-hidden group/aurora transition-all duration-300 hover:shadow-lg hover:shadow-amber-500/5">
            <div class="absolute inset-0 opacity-0 group-hover/aurora:opacity-100 bg-aurora-gradient transition-opacity duration-300 pointer-events-none z-0"></div>
            <div class="relative z-10 p-6 bg-white rounded-[15px] h-full flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Faturamento Bruto</span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-200/60">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <div>
                    <h3 id="faturamento-bruto" data-target="142380.00" class="text-2xl font-black text-slate-900 tracking-tight">R$ 0,00</h3>
                    <p class="mt-2 inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] bg-emerald-50 text-emerald-700 font-bold">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7 7 7M12 3v18"/></svg>
                        +12.4% <span class="text-slate-500 font-normal ml-0.5">mês anterior</span>
                    </p>
                </div>
            </div>
        </div>

        <div data-aurora-card class="relative p-[1px] bg-slate-200/60 rounded-2xl overflow-hidden group/aurora transition-all duration-300 hover:shadow-lg hover:shadow-amber-500/5">
            <div class="absolute inset-0 opacity-0 group-hover/aurora:opacity-100 bg-aurora-gradient transition-opacity duration-300 pointer-events-none z-0"></div>
            <div class="relative z-10 p-6 bg-white rounded-[15px] h-full flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Comissões Pagas</span>
                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-200/60">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                    </div>
                </div>
                <div>
                    <h3 id="comissoes-pagas" data-target="54104.40" class="text-2xl font-black text-slate-900 tracking-tight">R$ 0,00</h3>
                    <p class="text-[11px] text-slate-500 font-medium mt-2">
                        Média de <span class="font-bold text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded text-xs">38%</span> do faturamento
                    </p>
                </div>
            </div>
        </div>

        <div data-aurora-card class="relative p-[1px] bg-slate-200/60 rounded-2xl overflow-hidden group/aurora transition-all duration-300 hover:shadow-lg hover:shadow-amber-500/5">
            <div class="absolute inset-0 opacity-0 group-hover/aurora:opacity-100 bg-aurora-gradient transition-opacity duration-300 pointer-events-none z-0"></div>
            <div class="relative z-10 p-6 bg-white rounded-[15px] h-full flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Margem Líquida</span>
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center border border-indigo-200/60">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    </div>
                </div>
                <div>
                    <h3 id="margem-liquida" data-target="88275.60" class="text-2xl font-black text-slate-900 tracking-tight">R$ 0,00</h3>
                    <p class="text-[11px] text-indigo-700 font-bold mt-2 bg-indigo-50/70 inline-block px-2 py-0.5 rounded">
                        Retido pela distribuidora
                    </p>
                </div>
            </div>
        </div>

        <div data-aurora-card class="relative p-[1px] bg-slate-200/60 rounded-2xl overflow-hidden group/aurora transition-all duration-300 hover:shadow-lg hover:shadow-amber-500/5">
            <div class="absolute inset-0 opacity-0 group-hover/aurora:opacity-100 bg-aurora-gradient transition-opacity duration-300 pointer-events-none z-0"></div>
            <div class="relative z-10 p-6 bg-white rounded-[15px] h-full flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tamanho da Rede</span>
                    <div class="w-9 h-9 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center border border-slate-300/60">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">
                        <span id="tamanho-rede" data-target="1248">0</span>
                        <span class="text-xs font-normal text-slate-400">consultoras</span>
                    </h3>
                    <p class="text-[11px] text-slate-500 font-medium mt-2">
                        <span class="text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded">1.012 ativas</span> nesta quinzena
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 p-6 bg-white border border-slate-200/80 rounded-2xl shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Pico de Vendas Diárias</h4>
                    <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wider">Evolução do Mês Atual</p>
                </div>
                <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-lg border border-slate-200">
                    <button class="px-3 py-1 text-[11px] font-bold bg-white rounded-md text-slate-900 shadow-sm">Linha</button>
                    <button class="px-3 py-1 text-[11px] font-bold text-slate-500 hover:text-slate-900 transition-colors">Tabela</button>
                </div>
            </div>
            
            <div class="h-64 w-full bg-slate-50 border border-dashed border-slate-200 rounded-xl flex flex-col items-center justify-center p-6 text-center">
                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-slate-400 mb-2 border border-slate-200 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" /></svg>
                </div>
                <p class="text-xs font-semibold text-slate-700">Área do Gráfico de Sazonalidade</p>
                <p class="text-[11px] text-slate-400 max-w-[240px] mt-0.5">Eixo X: Dias do Mês (1-31), Eixo Y: Volume R$.</p>
            </div>
        </div>

        <div class="p-6 bg-white border border-slate-200/80 rounded-2xl shadow-sm flex flex-col">
            <div class="mb-6">
                <h4 class="text-base font-bold text-slate-900 tracking-tight">Atividades em Tempo Real</h4>
                <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wider">Eventos do Sistema</p>
            </div>

            <div class="flex-1 space-y-6 relative before:absolute before:inset-y-0 before:left-[15px] before:w-[1px] before:bg-slate-200 overflow-y-auto max-h-[265px] pr-1">
                <div class="flex gap-4 relative">
                    <div class="w-8 h-8 rounded-full bg-emerald-500 border-4 border-white shadow flex items-center justify-center text-white shrink-0 z-10">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Pedido #4982 Pago</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Mariana Silva</p>
                        <span class="text-[10px] font-bold text-slate-400 block mt-1">Há 2 minutos</span>
                    </div>
                </div>

                <div class="flex gap-4 relative">
                    <div class="w-8 h-8 rounded-full bg-blue-500 border-4 border-white shadow flex items-center justify-center text-white shrink-0 z-10">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Nova Líder Cadastrada</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Beatriz Costa</p>
                        <span class="text-[10px] font-bold text-slate-400 block mt-1">Há 14 minutos</span>
                    </div>
                </div>

                <div class="flex gap-4 relative">
                    <div class="w-8 h-8 rounded-full bg-amber-500 border-4 border-white shadow flex items-center justify-center text-white shrink-0 z-10">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-800">Solicitação de Saque</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">Juana Dias (R$ 1.200,00)</p>
                        <span class="text-[10px] font-bold text-slate-400 block mt-1">Há 1 hora</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="p-6 bg-white border border-slate-200/80 rounded-2xl shadow-sm">
            <div class="mb-4 flex justify-between items-center">
                <div>
                    <h4 class="text-base font-bold text-slate-900 tracking-tight">Top 5 Consultoras</h4>
                    <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wider">Maior Volume de Vendas</p>
                </div>
                <span class="px-2 py-1 rounded bg-slate-900 text-white text-[10px] font-bold tracking-wider">Mês Vigente</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-slate-500">
                            <th class="p-2.5 text-[11px] font-bold uppercase w-12 rounded-l-lg">Pos</th>
                            <th class="p-2.5 text-[11px] font-bold uppercase">Consultora</th>
                            <th class="p-2.5 text-[11px] font-bold uppercase">Nível</th>
                            <th class="p-2.5 text-right text-[11px] font-bold uppercase rounded-r-lg">Total Pago</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs font-medium text-slate-700">
                        <tr class="border-b border-slate-100 hover:bg-slate-50/80 transition-colors">
                            <td class="p-2.5 font-bold text-slate-900">#1</td>
                            <td class="p-2.5 font-bold text-slate-800">Alessandra M. Albuquerque</td>
                            <td class="p-2.5"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">Diamante</span></td>
                            <td class="p-2.5 text-right font-black text-slate-900">R$ 14.250,00</td>
                        </tr>
                        <tr class="border-b border-slate-100 hover:bg-slate-50/80 transition-colors">
                            <td class="p-2.5 font-bold text-slate-500">#2</td>
                            <td class="p-2.5 text-slate-800">Carla Rejane Souza</td>
                            <td class="p-2.5"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">Ouro</span></td>
                            <td class="p-2.5 text-right font-black text-slate-900">R$ 11.900,00</td>
                        </tr>
                        <tr class="border-b border-slate-100 hover:bg-slate-50/80 transition-colors">
                            <td class="p-2.5 font-bold text-slate-500">#3</td>
                            <td class="p-2.5 text-slate-800">Fernanda Lima Guimarães</td>
                            <td class="p-2.5"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">Ouro</span></td>
                            <td class="p-2.5 text-right font-black text-slate-900">R$ 9.420,00</td>
                        </tr>
                        <tr class="border-b border-slate-100 hover:bg-slate-50/80 transition-colors">
                            <td class="p-2.5 font-bold text-slate-500">#4</td>
                            <td class="p-2.5 text-slate-800">Juliana K. Medeiros</td>
                            <td class="p-2.5"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-orange-50 text-orange-700 border border-orange-200">Prata</span></td>
                            <td class="p-2.5 text-right font-black text-slate-900">R$ 7.110,00</td>
                        </tr>
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-2.5 font-bold text-slate-500">#5</td>
                            <td class="p-2.5 text-slate-800">Patrícia Novaes Pontes</td>
                            <td class="p-2.5"><span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-50 text-amber-900 border border-amber-200">Bronze</span></td>
                            <td class="p-2.5 text-right font-black text-slate-900">R$ 6.890,00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="p-6 bg-white border border-slate-200/80 rounded-2xl shadow-sm">
            <div class="mb-4">
                <h4 class="text-base font-bold text-slate-900 tracking-tight">Produtos Mais Vendidos</h4>
                <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wider">Volume de Saída em Estoque</p>
            </div>

            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50/60 border border-slate-200/60 hover:bg-slate-50 hover:border-slate-300 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center font-black text-slate-400 text-[9px] tracking-widest shadow-inner">
                            GLOW
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">Batom Matte Velvet - Red Luxury</p>
                            <p class="text-[10px] text-slate-400 font-semibold uppercase mt-0.5">Maquiagem</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-black text-slate-900">420 <span class="text-[10px] text-slate-400 font-normal">unid.</span></p>
                        <span class="inline-block text-[9px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded mt-1">Em Alta</span>
                    </div>
                </div>

                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50/60 border border-slate-200/60 hover:bg-slate-50 hover:border-slate-300 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center font-black text-slate-400 text-[9px] tracking-widest shadow-inner">
                            GLOW
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">Sérum Facial Ácido Hialurônico</p>
                            <p class="text-[10px] text-slate-400 font-semibold uppercase mt-0.5">Skincare</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-black text-slate-900">385 <span class="text-[10px] text-slate-400 font-normal">unid.</span></p>
                        <span class="inline-block text-[9px] font-bold text-emerald-700 bg-emerald-50 px-1.5 py-0.5 rounded mt-1">Em Alta</span>
                    </div>
                </div>

                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50/60 border border-slate-200/60 hover:bg-slate-50 hover:border-slate-300 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center font-black text-slate-400 text-[9px] tracking-widest shadow-inner">
                            GLOW
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">Perfume L'Éclat Gold Éclatant</p>
                            <p class="text-[10px] text-slate-400 font-semibold uppercase mt-0.5">Fragrâncias</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-black text-slate-900">190 <span class="text-[10px] text-slate-400 font-normal">unid.</span></p>
                        <span class="inline-block text-[9px] font-bold text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded mt-1">Estável</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    import { CountUp } from 'https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.8.0/countUp.min.js';

    document.addEventListener("DOMContentLoaded", function() {
        
        // ----------------------------------------------------
        // PARTE 1: ANIMAÇÃO DOS NÚMEROS (CountUp)
        // ----------------------------------------------------
        const opcoesMoeda = {
            prefix: 'R$ ',
            decimalPlaces: 2,
            decimal: ',',
            separator: '.',
            duration: 2.0
        };

        const opcoesInteiro = {
            decimalPlaces: 0,
            separator: '.',
            duration: 1.8
        };

        const elFaturamento = document.getElementById('faturamento-bruto');
        if(elFaturamento) {
            const valor = parseFloat(elFaturamento.getAttribute('data-target'));
            const animarFaturamento = new CountUp('faturamento-bruto', valor, opcoesMoeda);
            if (!animarFaturamento.error) animarFaturamento.start();
        }

        const elComissoes = document.getElementById('comissoes-pagas');
        if(elComissoes) {
            const valor = parseFloat(elComissoes.getAttribute('data-target'));
            const animarComissoes = new CountUp('comissoes-pagas', valor, opcoesMoeda);
            if (!animarComissoes.error) animarComissoes.start();
        }

        const elMargem = document.getElementById('margem-liquida');
        if(elMargem) {
            const valor = parseFloat(elMargem.getAttribute('data-target'));
            const animarMargem = new CountUp('margem-liquida', valor, opcoesMoeda);
            if (!animarMargem.error) animarMargem.start();
        }

        const elRede = document.getElementById('tamanho-rede');
        if(elRede) {
            const valor = parseInt(elRede.getAttribute('data-target'));
            const animarRede = new CountUp('tamanho-rede', valor, opcoesInteiro);
            if (!animarRede.error) animarRede.start();
        }

        // ----------------------------------------------------
        // PARTE 2: RASTREADOR DO MOUSE PARA A AURORA BORDER
        // ----------------------------------------------------
        const cards = document.querySelectorAll("[data-aurora-card]");
        cards.forEach((card) => {
            card.addEventListener("mousemove", (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                card.style.setProperty("--mouse-x", `${x}px`);
                card.style.setProperty("--mouse-y", `${y}px`);
            });
        });
    });
</script>
@endsection
