@extends('layouts.appAdmin')

@section('title', 'Gerenciamento de Categorias | Glow Executive')

@section('header', 'Categorias de Produtos')

@section('content')
<div x-data="{ 
    loading: false,
    submitting: false,
    modalOpen: false,
    lista: [],
    form: { nome: '', descricao: '' },

    init() {
        this.listarCategorias();
    },

    getHeaders() {
        const token = localStorage.getItem('auth_token');
        let headers = { 'Accept': 'application/json' };
        if (token) {
            headers['Authorization'] = `Bearer ${token}`;
        }
        return headers;
    },

    abrirModalCadastro() {
        this.form = { nome: '', descricao: '' };
        this.modalOpen = true;
    },

    // GET /api/categoria
    async listarCategorias() {
        this.loading = true;
        try {
            const r = await axios.get('/api/categoria', { headers: this.getHeaders() });
            
            // Tratamento flexível de resposta igual ao seu exemplo de estoque
            if (r.data && r.data.status === 'success') {
                this.lista = r.data.data;
            } else if (Array.isArray(r.data)) {
                this.lista = r.data;
            } else {
                this.lista = [];
            }
        } catch (e) {
            console.error('Erro ao buscar categorias:', e);
            Swal.fire({
                title: 'Erro!',
                text: 'Não foi possível carregar as categorias.',
                icon: 'error',
                confirmButtonColor: '#0F172A'
            });
        } finally {
            this.loading = false;
        }
    },

    // POST /api/categoria
    async salvarCategoria() {
        if (!this.form.nome.trim() || !this.form.descricao.trim()) return;
        this.submitting = true;
        
        try {
            const r = await axios.post('/api/categoria', this.form, { headers: this.getHeaders() });
            
            if (r.data && (r.data.status === 'success' || r.status === 201)) {
                this.modalOpen = false;
                await Swal.fire({ 
                    title: 'Sucesso!', 
                    text: r.data.mensagem || 'Categoria cadastrada com sucesso.', 
                    icon: 'success', 
                    confirmButtonColor: '#0F172A' 
                });
                this.listarCategorias();
            }
        } catch (e) {
            let msg = 'Erro interno ao salvar registro.';
            if (e.response?.status === 422) {
                msg = Object.values(e.response.data.errors).flat().join('<br>');
            } else if (e.response?.data?.mensagem) {
                msg = e.response.data.mensagem;
            }
            Swal.fire({ title: 'Ops!', html: msg, icon: 'error', confirmButtonColor: '#0F172A' });
        } finally {
            this.submitting = false;
        }
    },

    // DELETE /api/categoria/{id}
    async removerCategoria(id) {
        const conf = await Swal.fire({
            title: 'Remover Categoria?',
            text: 'Esta ação é irreversível e afetará os produtos vinculados!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#64748B',
            confirmButtonText: 'Sim, deletar',
            cancelButtonText: 'Cancelar'
        });

        if (!conf.isConfirmed) return;

        try {
            const r = await axios.delete(`/api/categoria/${id}`, { headers: this.getHeaders() });

            if (r.data && (r.data.status === 'success' || r.status === 200)) {
                Swal.fire({ 
                    title: 'Sucesso!', 
                    text: r.data.mensagem || 'Categoria removida com sucesso.', 
                    icon: 'success', 
                    confirmButtonColor: '#0F172A' 
                });
                this.listarCategorias();
            }
        } catch (e) {
            let msg = e.response?.data?.mensagem || 'Não foi possível completar a exclusão.';
            Swal.fire({ title: 'Falha no Servidor', text: msg, icon: 'error', confirmButtonColor: '#0F172A' });
        }
    }
}" class="space-y-6 relative">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-6">
        <div>
            <h3 class="text-lg font-bold text-[#0F172A]">Estrutura de Organização</h3>
            <p class="text-xs text-slate-400">Gerencie divisões do catálogo da distribuidora</p>
        </div>
        <button @click="abrirModalCadastro()" 
                class="flex items-center gap-2 bg-[#0F172A] text-white px-5 py-3 rounded-xl shadow-sm hover:bg-black transition-all font-bold uppercase text-[10px] tracking-wider">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Nova Categoria
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/60 overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200/60 text-[10px] uppercase font-bold text-slate-400 tracking-wider">
                    <th class="py-4 px-6 w-20">ID</th>
                    <th class="py-4 px-6">Nome da Categoria</th>
                    <th class="py-4 px-6">Descrição</th>
                    <th class="py-4 px-6 text-center w-32">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                
                <tr x-show="loading">
                    <td colspan="4" class="py-8 text-center text-slate-400 italic">
                        Carregando categorias em tempo real...
                    </td>
                </tr>

                <tr x-show="!loading && lista.length === 0">
                    <td colspan="4" class="py-8 text-center text-slate-400 italic">
                        Nenhuma categoria cadastrada no sistema.
                    </td>
                </tr>

                <template x-if="!loading && lista.length > 0">
                    <template x-for="item in lista" :key="item.id">
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-4 px-6 font-mono font-bold text-slate-400" x-text="'#' + item.id"></td>
                            <td class="py-4 px-6 font-semibold text-slate-800" x-text="item.nome"></td>
                            <td class="py-4 px-6 text-slate-500 max-w-md truncate" x-text="item.descricao"></td>
                            <td class="py-4 px-6 text-center">
                                <button @click="removerCategoria(item.id)" 
                                        class="p-2 text-slate-400 hover:text-red-600 rounded-xl hover:bg-red-50 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                </template>

            </tbody>
        </table>
    </div>

    <div x-show="modalOpen" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition
         x-cloak>
        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden border border-slate-100"
             @click.away="modalOpen = false">
            
            <div class="bg-[#0F172A] p-6 text-white flex justify-between items-center">
                <h4 class="font-bold text-sm uppercase tracking-wider">Criar Nova Categoria</h4>
                <button @click="modalOpen = false" class="text-white/60 hover:text-white text-xl leading-none">&times;</button>
            </div>

            <form @submit.prevent="salvarCategoria" class="p-6 space-y-4">
                <div>
                    <label class="block text-[10px] uppercase font-bold text-slate-400 mb-1">Nome</label>
                    <input type="text" x-model="form.nome" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-black/5" placeholder="Ex: Batons, Perfumes">
                </div>
                <div>
                    <label class="block text-[10px] uppercase font-bold text-slate-400 mb-1">Descrição</label>
                    <textarea x-model="form.descricao" required rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-black/5" placeholder="Breve resumo da categoria..."></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 text-xs font-bold text-slate-400 uppercase hover:text-slate-600">Cancelar</button>
                    <button type="submit" :disabled="submitting" class="bg-[#0F172A] text-white px-5 py-2 rounded-xl text-xs font-bold uppercase hover:bg-black disabled:opacity-50">
                        <span x-show="!submitting">Salvar</span>
                        <span x-show="submitting">Processando...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    // Configurações Globais do Axios para conversar com a API do Laravel
    axios.defaults.withCredentials = true;
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (csrfToken) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
    }
</script>
@endpush