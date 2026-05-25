@extends('layouts.appAdmin')

@section('title', 'Glow | Painel Consolidado de Relatórios')
@section('header', 'Relatórios Estratégicos')

@section('content')
<div x-data="relatoriosMaster()" x-init="init()" class="space-y-8">
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-200/60 items-end">
        <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Data Início</label>
            <input type="date" x-model="filtros.data_inicio" @change="recarregarAbaAtual()" class="w-full bg-white text-sm rounded-xl border-slate-200 p-2.5 shadow-sm focus:ring-black focus:border-black">
        </div>
        <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Data Fim</label>
            <input type="date" x-model="filtros.data_fim" @change="recarregarAbaAtual()" class="w-full bg-white text-sm rounded-xl border-slate-200 p-2.5 shadow-sm focus:ring-black focus:border-black">
        </div>
        <div>
            <button @click="resetarFiltros()" class="w-full bg-slate-900 hover:bg-black text-white text-xs font-semibold uppercase tracking-widest py-3 rounded-xl transition-all shadow-md">
                Limpar Período
            </button>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        
        <div class="w-full lg:w-64 shrink-0 space-y-1">
            <p class="px-3 mb-3 text-[9px] font-bold text-slate-400 uppercase tracking-[0.2em]">Selecione a Análise</p>
            
            <template x-for="aba in abas" :key="aba.id">
                <button @click="setAba(aba.id)" 
                        :class="abaAtiva === aba.id ? 'bg-slate-900 text-white shadow-lg' : 'text-slate-600 hover:bg-slate-100'"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all font-medium text-xs uppercase tracking-wider text-left">
                    <span x-text="aba.titulo"></span>
                    <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>
            </template>
        </div>

        <div class="flex-1 min-w-0 bg-white border border-slate-100 rounded-3xl p-2">
            
            <div x-show="loading" x-cloak class="flex flex-col items-center justify-center py-20 space-y-4">
                <div class="w-8 h-8 border-4 border-slate-900 border-t-transparent rounded-full animate-spin"></div>
                <p class="text-xs text-slate-400 font-medium uppercase tracking-widest">Processando base de dados...</p>
            </div>

            <div x-show="!loading">
                <div x-show="abaAtiva === 'vendas-pessoais'">
                    @include('distribuidora.componentes.vendas-pessoais')
                </div>
                <div x-show="abaAtiva === 'comissoes-detalhadas'">
                    @include('distribuidora.componentes.comissoes-detalhadas')
                </div>
                <div x-show="abaAtiva === 'desempenho-rede'">
                    @include('distribuidora.componentes.desempenho-rede')
                </div>
                <div x-show="abaAtiva === 'ranking-consultoras'">
                    @include('distribuidora.componentes.ranking-consultoras')
                </div>
                <div x-show="abaAtiva === 'analise-produtos'">
                    @include('distribuidora.componentes.analise-produtos')
                </div>
                <div x-show="abaAtiva === 'metas-bonificacoes'">
                    @include('distribuidora.componentes.metas-bonificacoes')
                </div>
                <div x-show="abaAtiva === 'retencao-clientes'">
                    @include('distribuidora.componentes.retencao-clientes')
                </div>
                <div x-show="abaAtiva === 'crescimento-rede'">
                    @include('distribuidora.componentes.crescimento-rede')
                </div>
                <div x-show="abaAtiva === 'financeiro-consolidado'">
                    @include('distribuidora.componentes.financeiro-consolidado')
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function relatoriosMaster() {
    return {
        abaAtiva: 'vendas-pessoais',
        loading: false,
        filtros: {
            data_inicio: '',
            data_fim: ''
        },
        // Dados das respostas salvos localmente no estado reativo
        dados: {
            vendas_pessoais: [],
            comissoes: [],
            desempenho_rede: { resumo: {}, rede: {} },
            ranking: [],
            produtos: { produtos: [], resumo: {} },
            metas: { metas: [], resumo: {} },
            retencao: { historico: [], cohorts: [], resumo_geral: {} },
            crescimento: { resumo: {}, evolucao_mensal: [], estrutura_arvore: [] },
            financeiro: { resumo_geral: {}, listagem_mensal: [] }
        },
        abas: [
            { id: 'vendas-pessoais', titulo: 'Vendas Pessoais' },
            { id: 'comissoes-detalhadas', titulo: 'Comissões Detalhadas' },
            { id: 'desempenho-rede', titulo: 'Desempenho da Rede' },
            { id: 'ranking-consultoras', titulo: 'Ranking de Consultoras' },
            { id: 'analise-produtos', titulo: 'Análise de Produtos' },
            { id: 'metas-bonificacoes', titulo: 'Metas & Bônus' },
            { id: 'retencao-clientes', titulo: 'Retenção de Clientes' },
            { id: 'crescimento-rede', titulo: 'Crescimento de Rede' },
            { id: 'financeiro-consolidado', titulo: 'Financeiro Consolidado' }
        ],

        init() {
            this.carregarDados(this.abaAtiva);
        },

        setAba(id) {
            this.abaAtiva = id;
            this.carregarDados(id);
        },

        recarregarAbaAtual() {
            this.carregarDados(this.abaAtiva);
        },

        resetarFiltros() {
            this.filtros.data_inicio = '';
            this.filtros.data_fim = '';
            this.recarregarAbaAtual();
        },

        async carregarDados(routeSlug) {
            this.loading = true;
            try {
                // Monta a query string dinamicamente
                const params = new URLSearchParams();
                if (this.filtros.data_inicio) params.append('data_inicio', this.filtros.data_inicio);
                if (this.filtros.data_fim) params.append('data_fim', this.filtros.data_fim);
                
                const response = await fetch(`/api/relatorios/${routeSlug}?${params.toString()}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                const resData = await response.json();
                
                // Mapeia o retorno da rota do controller para a chave correta no AlpineJS
                const chaveDados = routeSlug.replace('-', '_');
                
                if (resData.status === 'success' || !resData.status) {
                    // Algumas rotas retornam direto os dados ou envelopados em resData.data
                    this.dados[chaveDados] = resData.data || resData.dados || resData;
                } else {
                    Swal.fire('Erro', resData.mensagem || 'Erro ao carregar dados.', 'error');
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Erro Crítico', 'Falha ao se conectar com o servidor local.', 'error');
            } finally {
                this.loading = false;
                // Executa os contadores e efeitos visuais do appAdmin se aplicável
                if(window.PageScriptsManager) window.PageScriptsManager.init();
            }
        }
    }
}
</script>
@endsection
