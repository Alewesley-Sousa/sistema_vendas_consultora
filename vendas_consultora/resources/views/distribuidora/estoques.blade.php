@extends('layouts.appAdmin')

@section('title', 'Glow | Central de Estoques')

@section('header', 'Controle de Estoque Global')

@section('content')
<div wire:ignore x-data="{ 
    currentTab: 'saldo',
    drawerOpen: false,
    drawerNovoOpen: false, // Controla o drawer de novos estoques
    loading: false,
    
    produtos: [],
    produtosSemEstoque: [], // Armazena a lista da nova API
    movimentacoes: [],
    
    // Armazena a linha do estoque selecionada
    selectedEstoque: { id: null, quantidade: 0, produto: { nome: '', sku: '' } },
    justificativa: 'Entrada de Lote',
    quantidadeAjuste: 1,

    // Armazena o produto selecionado para criar estoque inicial
    selectedProdutoNovo: { id: null, nome: '', sku: '' },
    quantidadeInicial: 0,

    init() {
        this.carregarEstoque();
        this.carregarProdutosSemEstoque();
    },

    // GET /api/estoque
    async carregarEstoque() {
        this.loading = true;
        try {
            const response = await axios.get('/api/estoque'); 
            
            if (Array.isArray(response.data)) {
                this.produtos = response.data;
            } else if (response.data && Array.isArray(response.data.data)) {
                this.produtos = response.data.data;
            } else if (response.data && typeof response.data === 'object') {
                this.produtos = Object.values(response.data).filter(item => typeof item === 'object' && item !== null);
            } else {
                this.produtos = [];
            }
        } catch (error) {
            console.error('Erro ao carregar estoque:', error);
            Swal.fire('Erro!', 'Não foi possível carregar os dados do estoque.', 'error');
        } finally {
            this.loading = false;
        }
    },

    // GET /api/estoque/sem-estoque
    async carregarProdutosSemEstoque() {
        try {
            const response = await axios.get('/api/estoque/sem-estoque');
            if (Array.isArray(response.data)) {
                this.produtosSemEstoque = response.data;
            } else {
                this.produtosSemEstoque = [];
            }
        } catch (error) {
            console.error('Erro ao carregar produtos sem estoque:', error);
        }
    },

    openAjuste(item) {
        this.selectedEstoque = JSON.parse(JSON.stringify(item));
        this.quantidadeAjuste = 1;
        this.justificativa = 'Entrada de Lote';
        this.drawerOpen = true;
    },

    openCriarEstoque(produto) {
        this.selectedProdutoNovo = JSON.parse(JSON.stringify(produto));
        this.quantidadeInicial = 0;
        this.drawerNovoOpen = true;
    },

    // PUT /api/estoque/{id}
    async processarAjuste() {
        const ehSaida = this.justificativa === 'Saída por Quebra/Avaria';
        const quantidadeAtual = parseInt(this.selectedEstoque.quantidade || 0);
        
        if (ehSaida && this.quantidadeAjuste > quantidadeAtual) {
            Swal.fire({
                title: 'Erro de Validação!',
                text: 'A quantidade de saída não pode ser maior do que o estoque disponível.',
                icon: 'error',
                confirmButtonColor: '#0F172A'
            });
            return;
        }

        let novaQuantidade = ehSaida ? (quantidadeAtual - this.quantidadeAjuste) : (quantidadeAtual + this.quantidadeAjuste);

        this.loading = true;
        try {
            await axios.put(`/api/estoque/${this.selectedEstoque.id}`, {
                quantidade: novaQuantidade,
                produto_id: this.selectedEstoque.produto_id,
                justificativa: this.justificativa,
                quantidade_movimentada: this.quantidadeAjuste,
                tipo_movimentacao: ehSaida ? 'saida' : 'entrada'
            });

            this.drawerOpen = false;
            
            Swal.fire({
                title: 'Movimentação Gravada!',
                text: 'O estoque foi atualizado com sucesso.',
                icon: 'success',
                confirmButtonColor: '#0F172A'
            });

            this.carregarEstoque();

        } catch (error) {
            Swal.fire('Erro no Servidor', 'Falha ao salvar a movimentação.', 'error');
        } finally {
            this.loading = false;
        }
    },

    // POST /api/estoque
    async salvarNovoEstoque() {
        if (this.quantidadeInicial < 0) {
            Swal.fire('Erro!', 'A quantidade inicial não pode ser negativa.', 'error');
            return;
        }

        this.loading = true;
        try {
            await axios.post('/api/estoque', {
                produto_id: this.selectedProdutoNovo.id,
                quantidade: this.quantidadeInicial
            });

            this.drawerNovoOpen = false;

            Swal.fire({
                title: 'Estoque Inicial Definido!',
                text: 'O produto agora faz parte da volumetria global.',
                icon: 'success',
                confirmButtonColor: '#0F172A'
            });

            // Recarrega ambas as listas para atualizar a interface
            this.carregarEstoque();
            this.carregarProdutosSemEstoque();

        } catch (error) {
            console.error(error);
            Swal.fire('Erro!', 'Não foi possível definir o estoque inicial.', 'error');
        } finally {
            this.loading = false;
        }
    },

    calcularStatus(item) {
        const qtd = parseInt(item.quantidade || 0);
        const min = parseInt(item.estoque_minimo || 5);
        if (qtd <= 0) return 'Esgotado';
        if (qtd <= min) return 'Crítico';
        return 'Normal';
    },

    get totalEstocado() {
        return this.produtos.reduce((sum, p) => sum + parseInt(p.quantidade || 0), 0);
    },

    get alertasCriticos() {
        return this.produtos.filter(p => parseInt(p.quantidade || 0) <= parseInt(p.estoque_minimo || 5)).length;
    }
}" class="space-y-8 relative">

    <div x-show="loading" class="fixed top-4 right-4 z-50 bg-slate-900 text-white px-4 py-2 rounded-lg text-xs font-mono flex items-center gap-2 shadow-lg animate-pulse">
        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        Sincronizando com a API...
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in">
        <div class="bg-slate-50 border border-slate-200/60 rounded-2xl p-6 flex items-center justify-between transition-all hover:shadow-sm">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Estocado</span>
                <h4 class="text-2xl font-bold text-slate-900 mt-1" x-text="totalEstocado + ' Unidades'">0 Unidades</h4>
                <p class="text-[11px] text-slate-400 mt-0.5">Soma volumétrica total em tempo real</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-700 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 11m8 4V5M4 11v10l8 4" /></svg>
            </div>
        </div>

        <div class="bg-slate-50 border border-slate-200/60 rounded-2xl p-6 flex items-center justify-between transition-all hover:shadow-sm">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Atenção Crítica</span>
                <h4 class="text-2xl font-bold text-slate-900 mt-1" x-text="alertasCriticos + ' Alertas'">0 Alertas</h4>
                <p class="text-[11px] text-red-600 font-medium mt-0.5 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span> Abaixo do nível de segurança
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-red-500 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
        </div>

        <div class="bg-slate-50 border border-slate-200/60 rounded-2xl p-6 flex items-center justify-between transition-all hover:shadow-sm">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Aguardando Estoque</span>
                <h4 class="text-2xl font-bold text-slate-900 mt-1" x-text="produtosSemEstoque.length + ' Itens'">0 Itens</h4>
                <p class="text-[11px] text-amber-600 font-medium mt-0.5">Produtos criados sem saldo definido</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-amber-500 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2 border-b border-slate-100">
        <div class="flex p-1 bg-slate-100 rounded-xl max-w-2xl w-full sm:w-auto">
            <button @click="currentTab = 'saldo'" :class="currentTab === 'saldo' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-500 font-medium hover:text-slate-800'" class="flex-1 sm:flex-none px-4 py-2 text-xs rounded-lg transition-all duration-200 uppercase tracking-wider">
                Volumetria & Saldo Atual
            </button>
            <button @click="currentTab = 'pendentes'" :class="currentTab === 'pendentes' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-500 font-medium hover:text-slate-800'" class="flex-1 sm:flex-none px-4 py-2 text-xs rounded-lg transition-all duration-200 uppercase tracking-wider relative">
                Pendentes de Estoque
                <span x-show="produtosSemEstoque.length > 0" class="absolute -top-1 -right-1 bg-amber-500 text-white text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-black animate-bounce" x-text="produtosSemEstoque.length"></span>
            </button>
            <button @click="currentTab = 'historico'" :class="currentTab === 'historico' ? 'bg-white text-slate-900 shadow-sm font-bold' : 'text-slate-500 font-medium hover:text-slate-800'" class="flex-1 sm:flex-none px-4 py-2 text-xs rounded-lg transition-all duration-200 uppercase tracking-wider">
                Livro de Movimentações
            </button>
        </div>
    </div>

    <div x-show="currentTab === 'saldo'" x-transition:enter="transition ease-out duration-300" class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm">
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
                                <p class="font-bold text-slate-900" x-text="prod.produto ? prod.produto.nome : 'Sem Produto Vinculado'"></p>
                                <span class="text-[10px] font-mono text-slate-400 uppercase block tracking-wider" x-text="prod.produto ? prod.produto.sku : 'SEM SKU'"></span>
                            </td>
                            <td class="py-4 px-6 text-slate-500" x-text="prod.produto && prod.produto.categoria ? prod.produto.categoria.nome : 'Geral'"></td>
                            <td class="py-4 px-6">
                                <span class="text-sm font-extrabold text-slate-900" x-text="prod.quantidade"></span>
                                <span class="text-[10px] text-slate-400 font-light" x-text="'/ min ' + (prod.estoque_minimo || 5)"></span>
                            </td>
                            <td class="py-4 px-6">
                                <span :class="{
                                    'bg-emerald-50 text-emerald-700 border-emerald-200/50': calcularStatus(prod) === 'Normal',
                                    'bg-amber-50 text-amber-700 border-amber-200/50 animate-pulse': calcularStatus(prod) === 'Crítico',
                                    'bg-rose-50 text-rose-700 border-rose-200/50': calcularStatus(prod) === 'Esgotado'
                                }" class="px-2.5 py-1 rounded-md text-[9px] font-extrabold uppercase tracking-widest border" x-text="calcularStatus(prod)"></span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <button @click="openAjuste(prod)" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-lg transition-colors text-[10px] uppercase font-bold tracking-wider shadow-sm active:scale-95 duration-150">
                                    Ajustar Lote
                                </button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="produtos.length === 0 && !loading">
                        <td colspan="5" class="py-8 text-center text-slate-400 italic">
                            Nenhum registro de estoque localizado ou pendente de sincronização.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="currentTab === 'pendentes'" x-transition:enter="transition ease-out duration-300" class="bg-white border border-slate-200 rounded-[2rem] overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/60 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        <th class="py-4 px-6 font-semibold">Produto Sem Estoque</th>
                        <th class="py-4 px-6 font-semibold">Preço Base</th>
                        <th class="py-4 px-6 font-semibold">Status de Catálogo</th>
                        <th class="py-4 px-6 font-semibold text-right">Ação</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-700">
                    <template x-for="item in produtosSemEstoque" :key="item.id">
                        <tr class="hover:bg-amber-50/20 transition-colors group">
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-900" x-text="item.nome"></p>
                                <span class="text-[10px] font-mono text-slate-400 uppercase block tracking-wider" x-text="item.sku || 'SEM SKU DEVIDO'"></span>
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-mono" x-text="'R$ ' + item.preco"></td>
                            <td class="py-4 px-6">
                                <span class="bg-amber-50 text-amber-700 border-amber-200/50 px-2.5 py-1 rounded-md text-[9px] font-extrabold uppercase tracking-widest border">
                                    Sem Estoque Inicial
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <button @click="openCriarEstoque(item)" class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-600 hover:bg-amber-500 text-white rounded-lg transition-colors text-[10px] uppercase font-bold tracking-wider shadow-sm active:scale-95 duration-150">
                                    Definir Estoque
                                </button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="produtosSemEstoque.length === 0 && !loading">
                        <td colspan="4" class="py-12 text-center text-emerald-600 font-medium italic">
                            🎉 Excelente! Todos os produtos do sistema possuem estoque inicial parametrizado.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="drawerOpen" class="fixed inset-0 overflow-hidden z-50 shadow-2xl" x-cloak>
        <div class="absolute inset-0 overflow-hidden">
            <div x-show="drawerOpen" @click="drawerOpen = false" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div x-show="drawerOpen" class="pointer-events-auto w-screen max-w-md bg-white p-8 flex flex-col justify-between shadow-2xl md:rounded-l-[2.5rem]">
                    <div class="space-y-6">
                        <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                            <div>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Painel de Ajuste</span>
                                <h2 class="text-lg font-bold text-slate-900 tracking-tight">Lançar Movimentação</h2>
                            </div>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200/50">
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Produto Selecionado</span>
                            <h4 class="text-sm font-bold text-slate-900 mt-0.5" x-text="selectedEstoque.produto ? selectedEstoque.produto.nome : ''"></h4>
                            <div class="flex items-center gap-4 mt-2 text-[11px] font-medium text-slate-500">
                                <span>SKU: <strong class="text-slate-700" x-text="selectedEstoque.produto ? selectedEstoque.produto.sku : 'N/A'"></strong></span>
                                <span>Saldo Físico: <strong class="text-slate-900 font-extrabold" x-text="selectedEstoque.quantidade"></strong></span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">Natureza da Operação</label>
                                <select x-model="justificativa" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 font-medium">
                                    <option value="Entrada de Lote">Entrada - Recebimento de Lote</option>
                                    <option value="Ajuste de Balanço">Entrada - Correção de Inventário</option>
                                    <option value="Saída por Quebra/Avaria">Saída - Produto Danificado</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">Quantidade do Ajuste</label>
                                <div class="flex items-center gap-3">
                                    <button @click="if(quantidadeAjuste > 1) quantidadeAjuste--" class="w-10 h-10 border border-slate-200 bg-slate-50 rounded-xl flex items-center justify-center font-bold text-slate-700">-</button>
                                    <input type="number" x-model.number="quantidadeAjuste" min="1" class="flex-1 h-10 bg-slate-50 border border-slate-200 rounded-xl text-center text-sm font-extrabold text-slate-900" />
                                    <button @click="quantidadeAjuste++" class="w-10 h-10 border border-slate-200 bg-slate-50 rounded-xl flex items-center justify-center font-bold text-slate-700">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
                        <button @click="drawerOpen = false" class="flex-1 py-3 bg-slate-100 text-slate-700 font-bold text-xs rounded-xl uppercase tracking-wider">Cancelar</button>
                        <button @click="processarAjuste()" class="flex-1 py-3 bg-slate-900 text-white font-bold text-xs rounded-xl uppercase tracking-wider">Confirmar Lançamento</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div x-show="drawerNovoOpen" class="fixed inset-0 overflow-hidden z-50 shadow-2xl" x-cloak>
        <div class="absolute inset-0 overflow-hidden">
            <div x-show="drawerNovoOpen" @click="drawerNovoOpen = false" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div x-show="drawerNovoOpen" class="pointer-events-auto w-screen max-w-md bg-white p-8 flex flex-col justify-between shadow-2xl md:rounded-l-[2.5rem]">
                    <div class="space-y-6">
                        <div class="flex items-start justify-between pb-4 border-b border-slate-100">
                            <div>
                                <span class="text-[9px] font-bold text-amber-500 uppercase tracking-widest">Ativação de Produto</span>
                                <h2 class="text-lg font-bold text-slate-900 tracking-tight">Definir Estoque Inicial</h2>
                            </div>
                        </div>
                        <div class="p-4 bg-amber-50/40 rounded-2xl border border-amber-200/40">
                            <span class="text-[9px] font-bold text-amber-600 uppercase tracking-wider block">Produto Sem Vínculo</span>
                            <h4 class="text-sm font-bold text-slate-900 mt-0.5" x-text="selectedProdutoNovo.nome"></h4>
                            <div class="flex items-center gap-4 mt-2 text-[11px] font-medium text-slate-500">
                                <span>SKU: <strong class="text-slate-700" x-text="selectedProdutoNovo.sku || 'N/A'"></strong></span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">Quantidade em Unidades</label>
                                <div class="flex items-center gap-3">
                                    <button @click="if(quantidadeInicial > 0) quantidadeInicial--" class="w-10 h-10 border border-slate-200 bg-slate-50 rounded-xl flex items-center justify-center font-bold text-slate-700">-</button>
                                    <input type="number" x-model.number="quantidadeInicial" min="0" class="flex-1 h-10 bg-slate-50 border border-slate-200 rounded-xl text-center text-sm font-extrabold text-slate-900" />
                                    <button @click="quantidadeInicial++" class="w-10 h-10 border border-slate-200 bg-slate-50 rounded-xl flex items-center justify-center font-bold text-slate-700">+</button>
                                </div>
                                <span class="text-[10px] text-slate-400 mt-1 block">Você pode iniciar o produto com 0 unidades caso queira apenas registrá-lo.</span>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
                        <button @click="drawerNovoOpen = false" class="flex-1 py-3 bg-slate-100 text-slate-700 font-bold text-xs rounded-xl uppercase tracking-wider">Voltar</button>
                        <button @click="salvarNovoEstoque()" class="flex-1 py-3 bg-amber-600 hover:bg-amber-500 text-white font-bold text-xs rounded-xl uppercase tracking-wider">Ativar Estoque</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
