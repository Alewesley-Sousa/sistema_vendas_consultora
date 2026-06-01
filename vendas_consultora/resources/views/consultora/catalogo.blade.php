@extends('layouts.app')

@section('title', 'Catálogos - Glow Cosmetics')

@section('content')

{{-- Importando SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div x-data="catalogoStore()" class="pb-32">

    {{-- HEADER LUXURY --}}
    <div class="relative bg-[#2C3E50] text-white p-8 rounded-[2.5rem] shadow-2xl overflow-hidden mb-8 border border-white/5">
        <div class="absolute -top-12 -right-12 w-48 h-48 bg-[#FF7665] opacity-10 rounded-full blur-3xl"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="border-l-4 border-[#FFD700] pl-5 py-1">
                <h1 class="text-3xl font-serif font-black tracking-tighter">
                    Catálogos <span class="text-[#FFD700] italic text-2xl ml-2">Exclusivos</span>
                </h1>
                <p class="text-[10px] uppercase tracking-[0.3em] text-gray-400 mt-1 font-bold">Glow Cosmetics Business</p>
            </div>
            
            {{-- Busca de Catálogos --}}
            <div class="relative w-full md:w-80" x-show="view === 'grid'">
                <input type="text" x-model="search" @input="currentPage = 1" placeholder="Buscar coleção..." 
                       class="w-full bg-white/10 border border-white/20 rounded-2xl py-3.5 px-12 text-sm text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#FFD700]">
                <svg class="w-5 h-5 absolute left-4 top-3.5 text-[#FFD700]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2.5" stroke-linecap="round" />
                </svg>
            </div>

            {{-- Filtros de Produtos --}}
            <div class="flex flex-col md:flex-row gap-4" x-show="view === 'detalhes'">
                <div class="relative w-full md:w-64">
                    <input type="text" x-model="searchProd" @input="currentProdPage = 1" placeholder="Buscar produto..." 
                           class="w-full bg-white/10 border border-white/20 rounded-2xl py-2 px-10 text-sm text-white focus:outline-none focus:ring-2 focus:ring-[#FFD700]">
                    <svg class="w-4 h-4 absolute left-4 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </div>
                <select x-model="sortBy" class="bg-[#2C3E50] border border-white/20 rounded-2xl py-2 px-4 text-xs font-bold text-white focus:outline-none focus:ring-2 focus:ring-[#FFD700]">
                    <option value="nome_asc">Nome (A-Z)</option>
                    <option value="nome_desc">Nome (Z-A)</option>
                    <option value="preco_asc">Menor Preço</option>
                    <option value="preco_desc">Maior Preço</option>
                </select>
            </div>
        </div>
    </div>

    {{-- COMPONENTES --}}
    <x-catalogo.grid />
    <x-catalogo.produtos />
    <x-catalogo.carrinho-lateral />
    <x-catalogo.modal-checkout />

</div>

<script>
    function catalogoStore() {
        return {
            view: 'grid',
            loading: false,
            validating: false,
            cartOpen: false,
            checkoutModal: false,
            search: '',
            searchProd: '',
            sortBy: 'nome_asc',
            currentPage: 1,
            currentProdPage: 1,
            perPage: 6,
            selectedCatalogo: null,
            carrinho: [],
            catalogos: [],
            checkoutData: {
                cpf: '',
                nome: '',
                cliente_id: null,
                verificado: false,
                pagamento: 'pix',
                subMetodo: '',
                parcelas: 1
            },

            init() {
                this.fetchCatalogos();
            },

            // MÉTODO DE MÁSCARA DE CPF
            formatarCPF(e) {
                let v = e.target.value.replace(/\D/g, ''); 
                if (v.length > 11) v = v.slice(0, 11);
                
                if (v.length > 9) {
                    v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
                } else if (v.length > 6) {
                    v = v.replace(/(\d{3})(\d{3})(\d{3})/, "$1.$2.$3");
                } else if (v.length > 3) {
                    v = v.replace(/(\d{3})(\d{3})/, "$1.$2");
                }
                this.checkoutData.cpf = v;
            },

            async fetchCatalogos() {
                this.loading = true;
                try {
                    const response = await fetch('/api/catalogos');
                    const result = await response.json();
                    const dataRaw = result.data || result;
                    const hoje = new Date();
                    if (Array.isArray(dataRaw)) {
                        this.catalogos = dataRaw.filter(cat => cat.tipo_catalogo_id !== 1).map(cat => {
                            const dataFim = new Date(cat.data_encerramento);
                            return {
                                id: cat.id,
                                titulo: cat.nome,
                                validade: dataFim.toLocaleDateString('pt-BR'),
                                encerrado: dataFim < hoje,
                                descricao: cat.descricao,
                                img: cat.imagem_url || null,
                                produtos: []
                            };
                        });
                    }
                } catch (e) {
                    console.error('Erro catálogos:', e);
                } finally {
                    this.loading = false;
                }
            },

            async verificarCliente() {
                let cleanCPF = this.checkoutData.cpf.replace(/\D/g, '');
                if (cleanCPF.length < 11) {
                    return Swal.fire('Ops!', 'O CPF deve ter 11 dígitos.', 'warning');
                }

                this.validating = true;
                try {
                    const response = await fetch(`/api/cliente/${cleanCPF}`);
                    const result = await response.json();

                    if (response.ok && (result.data || result.id)) {
                        const cliente = result.data || result;
                        this.checkoutData.nome = cliente.nome;
                        this.checkoutData.cliente_id = cliente.id;
                        this.checkoutData.verificado = true;
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Cliente Identificado',
                            text: `Cliente: ${cliente.nome}`,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        throw new Error();
                    }
                } catch (e) {
                    this.checkoutData.verificado = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Cliente não encontrado',
                        text: 'Verifique o CPF ou cadastre um novo cliente.',
                        confirmButtonColor: '#2C3E50'
                    });
                } finally {
                    this.validating = false;
                }
            },

            limparCliente() {
                this.checkoutData.cpf = '';
                this.checkoutData.nome = '';
                this.checkoutData.verificado = false;
                this.checkoutData.cliente_id = null;
            },

            async abrirCatalogo(cat) {
                if (cat.encerrado) return;
                this.selectedCatalogo = cat;
                this.loading = true;
                this.view = 'detalhes';
                try {
                    const response = await fetch(`/api/catalogos/${cat.id}/itens`);
                    const result = await response.json();
                    const itensRaw = result.data || result;
                    if (Array.isArray(itensRaw)) {
                        this.selectedCatalogo.produtos = itensRaw.map(item => {
                            let rawImg = item.produto.imagem_url;
                            let finalImg = null;

                            if (rawImg) {
                                if (rawImg.startsWith('http://') || rawImg.startsWith('https://') || rawImg.startsWith('/')) {
                                    finalImg = rawImg;
                                } else {
                                    finalImg = `{{ asset('storage') }}/${rawImg}`;
                                }
                            }

                            return {
                                id: item.id,
                                nome: item.produto.nome,
                                preco: parseFloat(item.produto.preco_final),
                                img: finalImg,
                                estoque: item.estoque_disponivel,
                                status: item.status.nome
                            };
                        });
                    }
                } finally {
                    this.loading = false;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            },

            // FILTROS
            get filteredCatalogos() {
                return this.catalogos.filter(i => i.titulo.toLowerCase().includes(this.search.toLowerCase()));
            },

            get paginatedCatalogos() {
                return this.filteredCatalogos.slice((this.currentPage - 1) * this.perPage, this.currentPage * this.perPage);
            },

            get filteredProdutos() {
                if (!this.selectedCatalogo) return [];
                let prods = this.selectedCatalogo.produtos.filter(p => p.nome.toLowerCase().includes(this.searchProd.toLowerCase()));
                return prods.sort((a, b) => {
                    if (this.sortBy === 'nome_asc') return a.nome.localeCompare(b.nome);
                    if (this.sortBy === 'nome_desc') return b.nome.localeCompare(a.nome);
                    if (this.sortBy === 'preco_asc') return a.preco - b.preco;
                    if (this.sortBy === 'preco_desc') return b.preco - a.preco;
                    return 0;
                });
            },

            get paginatedProdutos() {
                return this.filteredProdutos.slice((this.currentProdPage - 1) * this.perPage, this.currentProdPage * this.perPage);
            },

            get totalCarrinho() {
                return this.carrinho.reduce((sum, item) => sum + (item.preco * item.qtd), 0);
            },

            adicionar(prod) {
                let item = this.carrinho.find(i => i.id === prod.id);
                if (item) item.qtd++;
                else this.carrinho.push({ ...prod, qtd: 1 });
            },

            alterarQtd(id, delta) {
                let item = this.carrinho.find(i => i.id === id);
                if (item) {
                    item.qtd += delta;
                    if (item.qtd <= 0) this.carrinho = this.carrinho.filter(i => i.id !== id);
                }
            },

            async finalizarVenda() {
                if (!this.checkoutData.verificado) return Swal.fire('Aviso', 'Valide o CPF primeiro.', 'warning');
                if (this.carrinho.length === 0) return Swal.fire('Aviso', 'Carrinho vazio.', 'info');

                this.loading = true;

                let metPag = this.checkoutData.pagamento;
                if (metPag === 'cartao') metPag = this.checkoutData.subMetodo;

                if (!metPag || metPag === 'cartao') {
                    this.loading = false;
                    return Swal.fire('Pagamento', 'Selecione Crédito ou Débito.', 'warning');
                }

                const payload = {
                    "cliente_id": this.checkoutData.cliente_id,
                    "status_id": 1,
                    "tipo_pagamento": metPag,
                    "itens": this.carrinho.map(item => ({
                        "item_catalogo_id": item.id,
                        "quantidade": item.qtd,
                        "preco_unitario": item.preco
                    }))
                };

                try {
                    const csrf = document.querySelector('meta[name=csrf-token]')?.content;
                    const response = await fetch('/api/pedido', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify(payload)
                    });

                    const res = await response.json();

                    if (response.ok && res.status === 'success') {
                        const linkPedido = res.data.link_cliente;
                        const textoWhats = encodeURIComponent(`Olá, ${this.checkoutData.nome}! Seu pedido na Glow Cosmetics foi realizado com sucesso. ✨\n\nConfira os detalhes aqui: ${linkPedido}`);
                        const linkWhats = `https://api.whatsapp.com/send?text=${textoWhats}`;

                        Swal.fire({
                            title: '✨ Pedido Realizado!',
                            html: `
                                <div class="text-left space-y-4">
                                    <p>Pedido <b>#${res.data.id}</b> gerado para ${this.checkoutData.nome}.</p>
                                    <div class="p-3 bg-gray-50 rounded-lg border border-dashed text-xs break-all font-mono">
                                        ${linkPedido}
                                    </div>
                                    <div class="grid grid-cols-1 gap-2">
                                        <button onclick="window.open('${linkWhats}', '_blank')" 
                                                class="w-full bg-[#25D366] text-white py-3 rounded-xl font-bold flex items-center justify-center gap-2 hover:opacity-90 transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.938 3.659 1.434 5.63 1.434h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                            Enviar via WhatsApp
                                        </button>
                                        <button onclick="navigator.clipboard.writeText('${linkPedido}'); Swal.showValidationMessage('Link Copiado!')" 
                                                class="w-full bg-[#FF7665] text-white py-3 rounded-xl font-bold flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" stroke-width="2"/></svg>
                                            Copiar Link apenas
                                        </button>
                                    </div>
                                </div>
                            `,
                            icon: 'success',
                            confirmButtonText: 'Concluir Venda',
                            confirmButtonColor: '#2C3E50'
                        }).then(() => {
                            this.carrinho = [];
                            location.reload();
                        });
                    } else {
                        throw new Error(res.mensagem || 'Erro desconhecido');
                    }

                } catch (e) {
                    Swal.fire('Erro', e.message, 'error');
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@900&family=Poppins:wght@400;700;900&display=swap');
    .font-serif { font-family: 'Playfair Display', serif; }
    body { font-family: 'Poppins', sans-serif; background-color: #FFF9F9 !important; }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #FF7665; border-radius: 10px; }
</style>
@endsection

