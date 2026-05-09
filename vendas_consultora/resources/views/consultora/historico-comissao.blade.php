@extends('layouts.app')

@section('title', 'Histórico de Comissões')

@section('header', '')

@section('content')

<style>
    [x-cloak] { display: none !important; }
    /* Estilização para esconder scrollbar da paginação mobile sem perder funcionalidade */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<div x-data="historicoComissao()" x-init="init()" class="space-y-8 relative">

    <div x-show="showModal" class="fixed inset-0 z-[110] overflow-y-auto" x-cloak>
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity" @click="showModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="showModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="relative bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full text-center space-y-6">
                <div class="w-20 h-20 bg-red-50 text-[#8B2E2E] rounded-full flex items-center justify-center mx-auto text-4xl">💰</div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Confirmar Saque?</h3>
                    <p class="text-gray-500 mt-2">
                        Você deseja solicitar o saque total do seu saldo disponível?<br>
                        <span class="font-bold text-[#8B2E2E] text-lg" x-text="formatCurrency(saldoTotal)"></span>
                    </p>
                </div>
                <div class="flex gap-3 pt-2">
                    <button @click="showModal = false" class="flex-1 px-6 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-100 transition-colors">Cancelar</button>
                    <button @click="confirmarSaqueReal()" class="flex-1 px-6 py-3 rounded-xl font-bold bg-[#FF7A6A] text-white hover:bg-[#ff6b5a] shadow-lg shadow-red-100 transition-all">Sim, Sacar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed top-5 right-5 z-[120] space-y-3">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.show" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-8"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                :class="toast.type === 'success' ? 'bg-green-600' : 'bg-red-600'"
                class="text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-3 min-w-[300px]">
                <span x-text="toast.type === 'success' ? '✅' : '❌'"></span>
                <span x-text="toast.message" class="font-medium text-sm"></span>
            </div>
        </template>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-3xl font-bold text-[#8B2E2E]">Histórico de Comissões</h1>
            <p class="text-gray-500">Gerencie seus ganhos e acompanhe o fluxo financeiro.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col sm:flex-row items-center gap-6 w-full md:w-auto">
            <div class="text-center sm:text-left">
                <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Saldo Líquido Disponível</p>
                <p class="text-3xl font-bold text-[#2C3E50]" x-text="formatCurrency(saldoTotal)"></p>
            </div>
            <button @click="abrirModalSaque()" 
                :disabled="loadingSaque || saldoTotal <= 0"
                class="w-full sm:w-auto bg-[#FF7A6A] hover:bg-[#ff6b5a] text-white px-8 py-3 rounded-xl font-bold transition-all shadow-lg shadow-red-100 disabled:opacity-50">
                <span x-show="!loadingSaque">Solicitar Saque</span>
                <span x-show="loadingSaque" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Processando...
                </span>
            </button>
        </div>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-50 flex flex-col md:flex-row items-end gap-4">
        <div class="w-full md:flex-1">
            <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Período</label>
            <div class="flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50/30">
                <input type="date" x-model="filtros.data_inicio" class="outline-none text-gray-600 bg-transparent w-full" />
                <span class="text-gray-300">até</span>
                <input type="date" x-model="filtros.data_fim" class="outline-none text-gray-600 bg-transparent w-full" />
            </div>
        </div>
        <div class="w-full md:w-48">
            <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Origem</label>
            <select x-model="filtros.tipo_comissao_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-600 outline-none bg-gray-50/30 font-medium">
                <option value="">Todas as origens</option>
                <option value="1">Vendas Direta</option>
                <option value="2">Nível 1</option>
                <option value="3">Nível 2</option>
            </select>
        </div>
        <div class="w-full md:w-48">
            <label class="block text-[10px] uppercase font-bold text-gray-400 mb-1">Movimentação</label>
            <select x-model="filtros.tipo" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-600 outline-none bg-gray-50/30 font-medium">
                <option value="">Todos os tipos</option>
                <option value="1">Venda (Entrada)</option>
                <option value="2">Estorno (Saída)</option>
                <option value="3">Saque (Retirada)</option>
            </select>
        </div>
        <div class="flex w-full md:w-auto gap-2">
            <button @click="fetchData(1)" class="flex-1 bg-[#4A5568] text-white px-8 py-2.5 rounded-lg font-semibold text-sm hover:bg-[#2D3748] transition-colors">Filtrar</button>
            <button @click="limparFiltros()" class="text-[#8B2E2E] text-sm font-bold px-4 py-2.5 hover:underline">Limpar</button>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative min-h-[500px] flex flex-col">
        
        <div x-show="loading" class="absolute inset-0 bg-white/60 flex items-center justify-center z-10" x-cloak>
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-[#8B2E2E]"></div>
        </div>

        <div class="flex-grow">
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-6 py-4 text-[10px] uppercase font-bold text-gray-400">Data</th>
                            <th class="px-6 py-4 text-[10px] uppercase font-bold text-gray-400">Tipo de Comissão</th>
                            <th class="px-6 py-4 text-[10px] uppercase font-bold text-gray-400">Movimentação</th>
                            <th class="px-6 py-4 text-[10px] uppercase font-bold text-gray-400 text-right">Valor</th>
                            <th class="px-6 py-4 text-[10px] uppercase font-bold text-gray-400 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <template x-for="item in transacoes" :key="item.id">
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-600" x-text="formatDate(item.data_movimentacao)"></td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-700" x-text="item.tipo_comissao?.nome || 'N/A'"></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span :class="item.tipo_movimentacao_id == 1 ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'"
                                              class="w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold"
                                              x-text="item.tipo_movimentacao_id == 1 ? '+' : '-'"></span>
                                        <span class="text-xs font-bold text-gray-700 uppercase" x-text="item.tipo_movimentacao?.nome"></span>
                                    </div>
                                </td>
                                <td :class="item.tipo_movimentacao_id == 1 ? 'text-green-600' : 'text-red-600'"
                                    class="px-6 py-4 text-sm font-bold text-right"
                                    x-text="formatCurrency(item.valor)"></td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 text-[10px] font-bold rounded-full uppercase">Processado</span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="block md:hidden divide-y divide-gray-100">
                <template x-for="item in transacoes" :key="item.id">
                    <div class="p-4 space-y-3">
                        <div class="flex justify-between items-start">
                            <div class="text-[10px] text-gray-400 font-bold uppercase" x-text="formatDate(item.data_movimentacao)"></div>
                            <span class="px-2 py-0.5 bg-gray-100 text-gray-500 text-[9px] font-black rounded-md uppercase">Processado</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs font-bold text-gray-800 uppercase" x-text="item.tipo_comissao?.nome || 'N/A'"></p>
                                <div class="flex items-center gap-1.5 mt-1">
                                    <span :class="item.tipo_movimentacao_id == 1 ? 'text-green-600' : 'text-red-600'" class="text-xs font-bold" x-text="item.tipo_movimentacao_id == 1 ? '↑' : '↓'"></span>
                                    <span class="text-[10px] font-bold text-gray-500 uppercase" x-text="item.tipo_movimentacao?.nome"></span>
                                </div>
                            </div>
                            <p :class="item.tipo_movimentacao_id == 1 ? 'text-green-600' : 'text-red-600'" 
                               class="text-lg font-black" 
                               x-text="formatCurrency(item.valor)"></p>
                        </div>
                    </div>
                </template>
            </div>

            <template x-if="transacoes.length === 0 && !loading">
                <div class="flex flex-col items-center justify-center py-20 px-6 text-center">
                    <span class="text-4xl mb-4">📭</span>
                    <p class="text-gray-400 italic font-medium">Nenhum registro encontrado para este período.</p>
                </div>
            </template>
        </div>

        <div class="sticky bottom-0 z-20 bg-white border-t border-gray-100 p-4 md:p-6 flex flex-col md:flex-row justify-between items-center gap-4 shadow-[0_-4px_10px_-1px_rgba(0,0,0,0.05)]">
            <div class="text-xs text-gray-400">
                <template x-if="pagination.total > 0">
                    <span>Mostrando <span class="font-bold text-gray-600" x-text="pagination.from"></span> até <span class="font-bold text-gray-600" x-text="pagination.to"></span> de <span class="font-bold text-gray-600" x-text="pagination.total"></span> registros</span>
                </template>
                <template x-if="pagination.total === 0">
                    <span>Nenhum registro para exibir</span>
                </template>
            </div>
            
            <div class="flex items-center gap-1 overflow-x-auto max-w-full no-scrollbar">
                <template x-for="link in pagination.links" :key="link.label">
                    <button @click="changePage(link.url)" :disabled="!link.url || link.active"
                        :class="link.active ? 'bg-[#8B2E2E] text-white shadow-md' : 'text-gray-500 hover:bg-gray-100 border border-transparent'"
                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all disabled:opacity-30 whitespace-nowrap"
                        x-html="link.label">
                    </button>
                </template>
            </div>
        </div>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>

<script>
function historicoComissao() {
    return {
        transacoes: [],
        saldoTotal: 0,
        loading: false,
        loadingSaque: false,
        showModal: false,
        toasts: [],
        token: localStorage.getItem('auth_token'),
        filtros: { data_inicio: '', data_fim: '', tipo: '', tipo_comissao_id: '' },
        pagination: {},

        init() {
            this.fetchSaldo();
            this.fetchData();
        },

        addToast(message, type = 'success') {
            const id = Date.now();
            this.toasts.push({ id, message, type, show: true });
            setTimeout(() => {
                const index = this.toasts.findIndex(t => t.id === id);
                if (index > -1) this.toasts[index].show = false;
            }, 4000);
        },

        async fetchSaldo() {
            try {
                const response = await fetch('/api/comissao', {
                    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${this.token}`, 'X-Requested-With': 'XMLHttpRequest' }
                });
                const res = await response.json();
                if (res.status === "sucesso") this.saldoTotal = res.data;
            } catch (error) { console.error("Erro saldo:", error); }
        },

        async fetchData(page = 1) {
            this.loading = true;
            try {
                const params = new URLSearchParams();
                params.append('page', page);
                if (this.filtros.data_inicio) params.append('data_inicio', this.filtros.data_inicio);
                if (this.filtros.data_fim) params.append('data_fim', this.filtros.data_fim);
                if (this.filtros.tipo) params.append('tipo', this.filtros.tipo);
                if (this.filtros.tipo_comissao_id) params.append('tipo_comissao_id', this.filtros.tipo_comissao_id);

                const response = await fetch(`/api/comissao/historico?${params.toString()}`, {
                    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${this.token}`, 'X-Requested-With': 'XMLHttpRequest' }
                });
                const res = await response.json();
                if (res.status === "success") {
                    this.transacoes = res.data.historico.data || [];
                    this.pagination = res.data.historico || {};
                }
            } catch (error) {
                this.addToast("Erro ao carregar dados", "error");
            } finally {
                this.loading = false;
            }
        },

        abrirModalSaque() {
            if (this.saldoTotal <= 0) return;
            this.showModal = true;
        },

        async confirmarSaqueReal() {
            this.showModal = false;
            this.loadingSaque = true;
            try {
                const response = await fetch('/api/comissao/solicitar', {
                    method: 'GET',
                    headers: { 'Accept': 'application/json', 'Authorization': `Bearer ${this.token}`, 'X-Requested-With': 'XMLHttpRequest' }
                });
                const res = await response.json();
                if (res.status === 'success') {
                    this.addToast(res.message, 'success');
                    await this.fetchSaldo();
                    await this.fetchData(1);
                } else {
                    this.addToast(res.message, 'error');
                }
            } catch (error) {
                this.addToast("Erro de conexão", "error");
            } finally {
                this.loadingSaque = false;
            }
        },

        formatCurrency(v) { return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(v || 0); },
        formatDate(d) { return d ? new Date(d).toLocaleDateString('pt-BR') : '-'; },
        changePage(url) { if (url) { const p = new URL(url).searchParams.get('page'); this.fetchData(p); } },
        limparFiltros() { this.filtros = { data_inicio: '', data_fim: '', tipo: '', tipo_comissao_id: '' }; this.fetchData(1); }
    }
}
</script>

@endsection
