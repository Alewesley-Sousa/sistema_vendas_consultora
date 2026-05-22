@extends('layouts.appAdmin')

@section('title', 'Glow | Central de Estoques')

@section('header', 'Controle de Estoque Global')

@section('content')
<div x-data="{ 
    currentTab: 'saldo',
    drawerOpen: false,
    selectedProduto: { nome: '', estoque_atual: 0, categoria: '' },
    justificativa: 'Entrada de Lote',
    quantidadeAjuste: 1,
    
    // Dados fictícios baseados no catálogo e inventário Glow
    produtos: [
        { id: 1, nome: 'Batom Matte Velvet Glow', categoria: 'Maquiagem', estoque_atual: 150, estoque_minimo: 50, sku: 'BAT-MAT-01', status: 'Normal' },
        { id: 2, nome: 'Sérum Facial Ácido Hialurônico', categoria: 'Skincare', estoque_atual: 12, estoque_minimo: 30, sku: 'SRM-HIA-02', status: 'Crítico' },
        { id: 3, nome: 'Perfume Luxury Gold Edição Limitada', categoria: 'Fragrâncias', estoque_atual: 0, estoque_minimo: 10, sku: 'PRF-LUX-03', status: 'Esgotado' },
        { id: 4, nome: 'Protetor Solar Fluido FPS 60', categoria: 'Skincare', estoque_atual: 120, estoque_minimo: 40, sku: 'PRT-FPS-04', status: 'Normal' }
    ],
    
    // Histórico detalhado para auditoria e rastreabilidade total (RNF23 e RNF24)
    movimentacoes: [
        { id: 501, data: '2026-03-18 14:32', produto: 'Batom Matte Velvet Glow', tipo: 'Saída', qtd: 2, motivo: 'Venda via Pedido #1024', responsavel: 'Sistema (Automático)' },
        { id: 502, data: '2026-03-18 11:15', produto: 'Sérum Facial Ácido Hialurônico', tipo: 'Entrada', qtd: 50, motivo: 'Ajuste Manual - Lançamento de Lote', responsavel: 'Maria Silva (Diretoria)' },
        { id: 503, data: '2026-03-17 09:44', produto: 'Perfume Luxury Gold Edição Limitada', tipo: 'Saída', qtd: 1, motivo: 'Venda via Pedido #1019', responsavel: 'Sistema (Automático)' },
        { id: 504, data: '2026-03-16 16:20', produto: 'Protetor Solar Fluido FPS 60', tipo: 'Entrada', qtd: 5, motivo: 'Retorno por Devolução - Pedido #0998', responsavel: 'Sistema (Automático)' }
    ],

    openAjuste(prod) {
        this.selectedProduto = Object.assign({}, prod);
        this.quantidadeAjuste = 1;
        this.justificativa = 'Entrada de Lote';
        this.drawerOpen = true;
    },

    processarAjuste() {
        // Validação estrita para impedir inconsistência de estoque negativo (RNF22)
        if (this.justificativa === 'Saída por Quebra/Avaria' && this.quantidadeAjuste > this.selectedProduto.estoque_atual) {
            Swal.fire({
                title: 'Erro de Validação!',
                text: 'A quantidade de saída não pode ser maior do que o estoque atual disponível no inventário físico.',
                icon: 'error',
                confirmButtonColor: '#0F172A'
            });
            return;
        }

        this.drawerOpen = false;
        Swal.fire({
            title: 'Movimentação Gravada!',
            text: 'O histórico de transação foi registrado sob conformidade jurídica e fiscal.',
            icon: 'success',
            confirmButtonColor: '#0F172A'
        });
    }
}" class="space-y-8 relative">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in">
        <div class="bg-slate-50 border border-slate-200/60 rounded-2xl p-6 flex items-center justify-between transition-all hover:shadow-sm">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Estocado</span>
                <h4 class="text-2xl font-bold text-slate-900 mt-1">282 Unidades</h4>
                <p class="text-[11px] text-slate-400 mt-0.5">Soma volumétrica total nos galpões</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-700 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 11m8 4V5M4 11v10l8 4" /></svg>
            </div>
        </div>

        <div class="bg-slate-50 border border-slate-200/60 rounded-2xl p-6 flex items-center justify-between transition-all hover:shadow-sm">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Atenção Crítica</span>
                <h4 class="text-2xl font-bold text-slate-900 mt-1">02 Alertas</h4>
                <p class="text-[11px] text-red-600 font-medium mt-0.5 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span> Produtos abaixo do nível de segurança
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-red-500 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
        </div>

        <div class="bg-slate-50 border border-slate-200/60 rounded-2xl p-6 flex items-center justify-between transition-all hover:shadow-sm">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Giro de Inventário</span>
                <h4 class="text-2xl font-bold text-slate-900 mt-1">94.2% Eficiência</h4>
                <p class="text-[11px] text-emerald-600 font-medium mt-0.5">Ruptura zero nas vitrines ativas</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-700 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2 border-b border-slate-100">
        <div class="flex p-1 bg-slate-100 rounded-xl max-w-md w-full sm:w-auto">
            <button @click="currentTab = 'saldo'" :class="currentTab === 'saldo' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-500 font-medium hover:text-slate-800'" class="flex-1 sm:flex-none px-4 py-2 text-xs rounded-lg transition-all duration-200 uppercase tracking-wider">
                Volumetria & Saldo Atual
            </button>
            <button @click="currentTab = 'historico'" :class="currentTab === 'historico' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-500 font-medium hover:text-slate-800'" class="flex-1 sm:flex-none px-4 py-2 text-xs rounded-lg transition-all duration-200 uppercase tracking-wider">
                Livro de Movimentações
            </button>
        </div>

        <div class="text-right pb-2">
            <p class="text-[11px] font-semibold text-slate-400 uppercase">Padrão de Transação</p>
            <p class="text-xs font-bold text-slate-800">ISO 9001 Logística Garantida</p>
        </div>
    </div>

    <div x-show="currentTab === 'saldo'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/60 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        <th class="py-4 px-6 font-semibold">Produto / SKU</th>
                        <th class="py-4 px-6 font-semibold">Categoria</th>
                        <th class="py-4 px-6 font-semibold">Quantidade Física</th>
                        <th class="py-4 px-6 font-semibold">Status Alerta</th>
                        <th class="py-4 px-6 font-semibold text-right">Ação</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    <template x-for="prod in produtos" :key="prod.id">
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-900" x-text="prod.nome"></p>
                                <span class="text-[10px] font-mono text-slate-400 uppercase block tracking-wider" x-text="prod.sku"></span>
                            </td>
                            <td class="py-4 px-6 text-slate-500" x-text="prod.categoria"></td>
                            <td class="py-4 px-6">
                                <span class="text-sm font-extrabold text-slate-900" x-text="prod.estoque_atual"></span>
                                <span class="text-[10px] text-slate-400 font-light" x-text="'/ min ' + prod.estoque_minimo"></span>
                            </td>
                            <td class="py-4 px-6">
                                <span :class="{
                                    'bg-emerald-50 text-emerald-700 border-emerald-200/50': prod.status === 'Normal',
                                    'bg-amber-50 text-amber-700 border-amber-200/50 animate-pulse': prod.status === 'Crítico',
                                    'bg-rose-50 text-rose-700 border-rose-200/50': prod.status === 'Esgotado'
                                }" class="px-2.5 py-1 rounded-md text-[9px] font-extrabold uppercase tracking-widest border" x-text="prod.status"></span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <button @click="openAjuste(prod)" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg transition-colors text-[10px] uppercase font-bold tracking-wider shadow-sm active:scale-95 duration-150">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                                    Ajustar Lote
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="currentTab === 'historico'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/60 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        <th class="py-4 px-6 font-semibold">Data / Carimbo</th>
                        <th class="py-4 px-6 font-semibold">Produto Vinculado</th>
                        <th class="py-4 px-6 font-semibold">Fluxo</th>
                        <th class="py-4 px-6 font-semibold">Volume</th>
                        <th class="py-4 px-6 font-semibold">Origem / Justificativa (Rastreabilidade)</th>
                        <th class="py-4 px-6 font-semibold">Operador</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-600">
                    <template x-for="mov in movimentacoes" :key="mov.id">
                        <tr class="hover:bg-slate-50/50 transition-colors font-sans">
                            <td class="py-4 px-6 font-mono text-[10px] text-slate-400" x-text="mov.data"></td>
                            <td class="py-4 px-6 font-bold text-slate-900" x-text="mov.produto"></td>
                            <td class="py-4 px-6">
                                <span :class="mov.tipo === 'Entrada' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-rose-50 text-rose-700 border-rose-100'" class="px-2 py-0.5 rounded font-extrabold text-[9px] uppercase border" x-text="mov.tipo"></span>
                            </td>
                            <td class="py-4 px-6 font-mono font-bold text-sm" :class="mov.tipo === 'Entrada' ? 'text-emerald-600' : 'text-rose-600'" x-text="mov.tipo === 'Entrada' ? '+' + mov.qtd : '-' + mov.qtd"></td>
                            <td class="py-4 px-6 font-medium text-slate-800">
                                <span x-html="mov.motivo.replace(/(Pedido\s#\d+)/g, '<span class=\'underline cursor-pointer font-bold text-slate-900 hover:text-indigo-600\'>$1</span>')"></span>
                            </td>
                            <td class="py-4 px-6 text-slate-400 text-[11px]" x-text="mov.responsavel"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="drawerOpen" class="fixed inset-0 overflow-hidden z-50 shadow-2xl" x-cloak>
        <div class="absolute inset-0 overflow-hidden">
            <div x-show="drawerOpen" x-transition:opacity @click="drawerOpen = false" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>

            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div x-show="drawerOpen" x-transition:enter="transform transition ease-in-out duration-400" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-400" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="pointer-events-auto w-screen max-w-md bg-white border-l border-slate-200 p-8 flex flex-col justify-between shadow-2xl md:rounded-l-[2.5rem]">
                    
                    <div class="space-y-6">
                        <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                            <div>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Painel de Ajuste</span>
                                <h2 class="text-lg font-bold text-slate-900 tracking-tight">Lançar Movimentação</h2>
                                <p class="text-xs text-slate-400 mt-0.5">Lançamentos manuais geram logs permanentes de auditoria.</p>
                            </div>
                            <button @click="drawerOpen = false" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l18 18" /></svg>
                            </button>
                        </div>

                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/50">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Produto Selecionado</span>
                            <h4 class="text-sm font-bold text-slate-900 mt-0.5" x-text="selectedProduto.nome"></h4>
                            <div class="flex items-center gap-4 mt-2 text-[11px] font-medium text-slate-500">
                                <span>Categoria: <strong class="text-slate-700" x-text="selectedProduto.categoria"></strong></span>
                                <span>Saldo Físico Atual: <strong class="text-slate-900 font-extrabold" x-text="selectedProduto.estoque_atual"></strong></span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">Natureza da Operação / Justificativa</label>
                                <select x-model="justificativa" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs focus:outline-none focus:bg-white focus:border-slate-400 text-slate-800 font-medium">
                                    <option value="Entrada de Lote">Entrada - Recebimento de Lote do Fornecedor</option>
                                    <option value="Ajuste de Balanço">Entrada - Correção de Inventário / Balanço</option>
                                    <option value="Saída por Quebra/Avaria">Saída - Produto Danificado / Avariado</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">Volume da Carga (Quantidade)</label>
                                <div class="flex items-center gap-3">
                                    <button @click="if(quantidadeAjuste > 1) quantidadeAjuste--" class="w-10 h-10 border border-slate-200 bg-slate-50 hover:bg-slate-100 rounded-xl flex items-center justify-center font-bold text-slate-700 active:scale-95 transition-all">-</button>
                                    <input type="number" x-model.number="quantidadeAjuste" min="1" class="flex-1 h-10 bg-slate-50 border border-slate-200 rounded-xl text-center text-sm font-extrabold text-slate-900 focus:outline-none focus:bg-white focus:border-slate-400" />
                                    <button @click="quantidadeAjuste++" class="w-10 h-10 border border-slate-200 bg-slate-50 hover:bg-slate-100 rounded-xl flex items-center justify-center font-bold text-slate-700 active:scale-95 transition-all">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
                        <button @click="drawerOpen = false" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors uppercase tracking-wider">
                            Cancelar
                        </button>
                        <button @click="processarAjuste()" class="flex-1 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition-all shadow-sm uppercase tracking-wider">
                            Confirmar Lançamento
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(14px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
    }
</style>
@endsection
