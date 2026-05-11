<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos da Equipe - Glow Cosmetics</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        .font-serif { font-family: 'DM Serif Display', serif; }
        [x-cloak] { display: none !important; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .fade-in { animation: fadeIn 0.5s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E67E73; border-radius: 10px; }
    </style>
</head>
<body class="antialiased text-[#2C3E50]" 
      x-data="painelPedidos()" 
      x-init="init()">

    {{-- Notificações (Toasts) --}}
    <div aria-live="assertive" class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start z-[100]">
        <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
            <template x-for="notificacao in notificacoes" :key="notificacao.id">
                <div x-transition:enter="transform ease-out duration-300 transition"
                     class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden border-l-4"
                     :class="notificacao.tipo === 'erro' ? 'border-red-500' : 'border-green-500'">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p class="text-sm font-medium text-gray-900" x-text="notificacao.titulo"></p>
                                <p class="mt-1 text-sm text-gray-500" x-text="notificacao.mensagem"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 py-12">
        {{-- Componentes Modulares --}}
        @include('components.pedidosEquipe.header')
        
        {{-- A tabela faz o loop em 'pedidosPaginados' --}}
        @include('components.pedidosEquipe.tabela-pedidos')

        {{-- Controles de Paginação --}}
        <div class="mt-6 flex flex-col md:flex-row items-center justify-between gap-4" x-show="totalPaginas > 1">
            <p class="text-xs text-gray-400 font-medium italic">
                Mostrando página <span x-text="paginaAtual"></span> de <span x-text="totalPaginas"></span>
            </p>
            <div class="flex items-center gap-2">
                <button @click="paginaAnterior()" :disabled="paginaAtual === 1" 
                        class="px-4 py-2 bg-white rounded-xl shadow-sm text-[10px] font-black uppercase tracking-widest disabled:opacity-30 hover:text-[#E67E73] transition-all">
                    Anterior
                </button>
                
                <template x-for="p in totalPaginas" :key="p">
                    <button @click="paginaAtual = p" 
                            class="w-10 h-10 rounded-xl shadow-sm text-xs font-bold transition-all"
                            :class="paginaAtual === p ? 'bg-[#2C3E50] text-white' : 'bg-white text-gray-400 hover:bg-gray-50'"
                            x-text="p"></button>
                </template>

                <button @click="proximaPagina()" :disabled="paginaAtual === totalPaginas" 
                        class="px-4 py-2 bg-white rounded-xl shadow-sm text-[10px] font-black uppercase tracking-widest disabled:opacity-30 hover:text-[#E67E73] transition-all">
                    Próxima
                </button>
            </div>
        </div>

        @include('components.pedidosEquipe.modais-pedidos')

        <div class="mt-8 flex justify-between items-center text-[10px] font-black uppercase tracking-widest text-gray-300">
            <span>Glow Cosmetics &copy; 2026</span>
            <span x-text="'Total: ' + (pedidosFiltrados.length) + ' resultados encontrados'"></span>
        </div>
    </div>

<script>
    function painelPedidos() {
        return {
            search: '',
            pedidos: [],
            notificacoes: [],
            paginaAtual: 1,
            itensPorPagina: 4,

            modalAberto: false,
            confirmacaoAberta: false,
            modo: 'visualizar',
            pedidoEditavel: null,

            catalogos: ['Glow Outono/Inverno', 'Skincare Pro', 'Perfumaria'],
            produtosExemplo: [], 
            novoItem: { catalogo: '', produto: null, qtd: 1 },

            // Getters para filtragem e paginação
            get pedidosFiltrados() {
                if (!this.search) return this.pedidos;
                const termo = this.search.toLowerCase();
                return this.pedidos.filter(p => 
                    p.id.toString().includes(termo) || 
                    (p.consultora?.nome && p.consultora.nome.toLowerCase().includes(termo))
                );
            },

            get totalPaginas() { 
                return Math.ceil(this.pedidosFiltrados.length / this.itensPorPagina) || 1; 
            },

            get pedidosPaginados() {
                const inicio = (this.paginaAtual - 1) * this.itensPorPagina;
                return this.pedidosFiltrados.slice(inicio, inicio + this.itensPorPagina);
            },

            async init() {
                try {
                    const response = await fetch('/api/lider/equipe/pedidos', {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (!response.ok) throw new Error();
                    this.pedidos = await response.json();
                } catch (error) {
                    this.notificar('Erro', 'Falha ao carregar a rede de pedidos.', 'erro');
                }
                this.$watch('search', () => this.paginaAtual = 1);
            },

            async abrirDetalhes(pedidoSimplificado) {
                try {
                    const response = await fetch(`/api/pedido/${pedidoSimplificado.id}`, {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const result = await response.json();

                    if (result.status === 'success') {
                        let dados = result.data;
                        this.pedidoEditavel = {
                            id: dados.id,
                            nome: dados.consultora?.nome || 'Não informada', 
                            cliente: dados.clientes?.nome || 'Não informado', 
                            pagamento: dados.tipo_pagamento || 'Não definido',
                            // Capturando o nome do status retornado pela relação no Model
                            status_nome: dados.status?.nome || 'Pendente',
                            status_id: dados.status_id,
                            itens: dados.itens_pedidos.map(item => ({
                                id: item.id,
                                item_catalogo_id: item.item_catalogo_id,
                                produto: item.item_catalogo?.produto?.nome || 'Produto Indisponível',
                                qtd: item.quantidade,
                                preco: parseFloat(item.preco_unitario)
                            }))
                        };
                        this.modo = 'visualizar';
                        this.modalAberto = true;
                    } else {
                        this.notificar('Erro', result.mensagem, 'erro');
                    }
                } catch (error) {
                    this.notificar('Erro', 'Não foi possível carregar os itens.', 'erro');
                }
            },

            // --- FUNÇÃO DE CANCELAMENTO COM TRATAMENTO DE EXCEPTIONS DO SERVICE ---
            async confirmarCancelamento() {
                try {
                    const response = await fetch(`/api/pedido/${this.pedidoEditavel.id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    const result = await response.json();

                    if (result.status === 'sucesso') {
                        // Sucesso: Remove da lista e fecha tudo
                        this.pedidos = this.pedidos.filter(p => p.id !== this.pedidoEditavel.id);
                        this.notificar('Sucesso', result.mensagem, 'sucesso');
                        this.fecharModal();
                    } else {
                        // Erro de Validação/Exception do Service
                        let msgOriginal = result.mensagem || '';
                        
                        // Limpa o prefixo "erro ao cancelar: " que o catch do PHP adiciona
                        let msgFormatada = msgOriginal.replace('erro ao cancelar: ', '');

                        // Título dinâmico baseado na regra de negócio atingida
                        let titulo = 'Não permitido';
                        if (msgFormatada.includes('ja foi cancelado')) {
                            titulo = 'Aviso de Status';
                        } else if (msgFormatada.includes('náo pode ser mais cancelado')) {
                            titulo = 'Bloqueio de Cancelamento';
                        }

                        this.notificar(titulo, msgFormatada, 'erro');
                        
                        // Fecha apenas o mini-modal de confirmação, mantendo os detalhes abertos
                        this.confirmacaoAberta = false;
                    }
                } catch (error) {
                    console.error('Erro na requisição:', error);
                    this.notificar('Erro Crítico', 'Não foi possível se comunicar com o servidor.', 'erro');
                }
            },

            notificar(titulo, mensagem, tipo = 'sucesso') {
                const id = Date.now();
                this.notificacoes.push({ id, titulo, mensagem, tipo });
                setTimeout(() => {
                    this.notificacoes = this.notificacoes.filter(n => n.id !== id);
                }, 4000);
            },

            fecharModal() {
                this.modalAberto = false;
                this.confirmacaoAberta = false;
                this.pedidoEditavel = null;
                this.modo = 'visualizar';
            },

            formatarMoeda(valor) {
                return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor);
            },

            calcularTotal() {
                return this.pedidoEditavel ? this.pedidoEditavel.itens.reduce((sum, i) => sum + (i.preco * i.qtd), 0) : 0;
            },

            adicionarItem() {
                if(!this.novoItem.produto) return;
                this.pedidoEditavel.itens.push({
                    produto: this.novoItem.produto.nome,
                    qtd: parseInt(this.novoItem.qtd),
                    preco: this.novoItem.produto.preco,
                    item_catalogo_id: this.novoItem.produto.id
                });
                this.novoItem = { catalogo: '', produto: null, qtd: 1 };
            },

            removerItem(index) {
                this.pedidoEditavel.itens.splice(index, 1);
            },

            async salvarEdicao() {
                try {
                    const payload = {
                        itens: this.pedidoEditavel.itens.map(i => ({
                            item_catalogo_id: i.item_catalogo_id,
                            quantidade: i.qtd,
                            preco_unitario: i.preco
                        })),
                        valor_total: this.calcularTotal()
                    };

                    const response = await fetch(`/api/pedido/${this.pedidoEditavel.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    });

                    if (response.ok) {
                        await this.init();
                        this.notificar('Salvo!', 'Pedido atualizado com sucesso.');
                        this.fecharModal();
                    } else {
                        const errorData = await response.json();
                        this.notificar('Erro', errorData.mensagem || 'Erro ao salvar.', 'erro');
                    }
                } catch (error) {
                    this.notificar('Erro', 'Erro ao salvar alterações no banco.', 'erro');
                }
            },

            paginaAnterior() { if(this.paginaAtual > 1) this.paginaAtual--; },
            proximaPagina() { if(this.paginaAtual < this.totalPaginas) this.paginaAtual++; }
        }
    }
</script>




</body>
</html>
