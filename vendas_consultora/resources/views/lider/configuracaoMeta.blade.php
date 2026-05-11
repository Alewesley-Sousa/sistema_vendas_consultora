@extends('layouts.app')

@section('content')
{{-- Estilos Customizados --}}
<style>
    :root {
        --azul-petroleo: #083344;
        --azul-claro: #0e7490;
        --dourado: #d4af37;
        --texto-escuro: #020617;
    }
    [x-cloak] { display: none !important; }
    
    .fade-in-up { animation: fadeInUp 0.4s ease-out forwards; }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .selected-row {
        background-color: rgba(14, 116, 144, 0.08) !important;
        border-left: 4px solid var(--dourado) !important;
    }

    /* Animação do Foguete (Figura Inanimada) */
    .rocket-float {
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(5deg); }
        50% { transform: translateY(-15px) rotate(10deg); }
    }

    .stars-blink { animation: blink 2s infinite; }
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.3; }
    }

    /* Animação do Toast */
    .toast-enter { animation: slideInRight 0.4s cubic-bezier(0.18, 0.89, 0.32, 1.28); }
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
</style>

<div x-data="configMetasApp()" x-init="init()" class="p-4 md:p-8 max-w-[1000px] mx-auto min-h-screen bg-slate-50 relative">
    
    {{-- Toast de Sucesso --}}
    <template x-if="notificacao.show">
        <div class="fixed top-5 right-5 z-[100] toast-enter">
            <div class="bg-[var(--azul-petroleo)] border-l-4 border-[var(--dourado)] text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4">
                <div class="bg-[var(--dourado)] rounded-full p-1">
                    <svg class="w-4 h-4 text-[var(--azul-petroleo)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-[var(--dourado)]">Sucesso</p>
                    <p class="text-xs font-bold" x-text="notificacao.message"></p>
                </div>
            </div>
        </div>
    </template>

    {{-- Header --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 fade-in-up">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="h-6 w-1.5 bg-[var(--dourado)] rounded-full"></div>
                <span class="text-[11px] font-black text-[var(--azul-claro)] uppercase tracking-[0.4em]">Target Management</span>
            </div>
            <h2 class="text-4xl font-black text-[var(--azul-petroleo)] tracking-tighter">Planejar <span class="text-[var(--azul-claro)]">Metas</span></h2>
        </div>

        <div class="relative group w-full md:w-80">
            <input type="text" x-model="search" @input.debounce.500ms="init(1)" placeholder="Buscar consultora..." 
                   class="w-full bg-white border-2 border-slate-200 rounded-2xl py-3.5 pl-5 pr-12 font-bold text-sm text-[var(--azul-petroleo)] outline-none focus:border-[var(--azul-claro)] transition-all shadow-sm">
            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-[var(--azul-claro)] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    {{-- Lista de Consultoras --}}
    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-100 overflow-hidden fade-in-up">
        <div x-show="!loadingGeral && consultoras.length > 0">
            <div class="max-h-[400px] overflow-y-auto">
                <template x-for="c in consultoras" :key="c.id">
                    <div @click="selectConsultora(c)" 
                         class="grid grid-cols-12 px-8 py-5 items-center cursor-pointer hover:bg-slate-50 transition-all border-b border-slate-50"
                         :class="String(selectedConsultora?.id) === String(c.id) ? 'selected-row' : ''">
                        
                        <div class="col-span-10 flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-xs"
                                 :class="String(selectedConsultora?.id) === String(c.id) ? 'bg-[var(--dourado)] text-white' : 'bg-slate-100 text-slate-400'" 
                                 x-text="c.nome.substring(0,2).toUpperCase()"></div>
                            <div>
                                <h4 class="font-black text-[var(--texto-escuro)] uppercase text-xs" x-text="c.nome"></h4>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter" x-text="'ID: #' + c.id"></p>
                            </div>
                        </div>
                        <div class="col-span-2 text-right">
                            <span class="text-[9px] font-black px-3 py-1 rounded-full bg-amber-100 text-amber-600 uppercase tracking-widest">Pendente</span>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- MENSAGEM POSITIVA / EMPTY STATE --}}
        <div x-show="!loadingGeral && consultoras.length === 0" x-cloak class="p-16 flex flex-col items-center justify-center text-center">
            <div class="relative mb-8">
                <div class="absolute -top-4 -left-8 text-yellow-300 stars-blink">✦</div>
                <div class="absolute top-10 -right-10 text-yellow-200 stars-blink" style="animation-delay: 0.5s">✦</div>
                <div class="absolute -bottom-2 right-4 text-yellow-400 stars-blink" style="animation-delay: 1s">✦</div>
                
                <div class="rocket-float text-[var(--azul-claro)]">
                    <svg class="w-24 h-24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.71.73-1.35.73-1.35s-.64.02-1.35.73c-1.26 1.5-5 2-5 2s.5-3.74 2-5c.71-.71 1.35-.73 1.35-.73s-.02.64-.73 1.35Z"/>
                        <path d="M15 7s-1.5-1.5-3-1.5-4.5 1.5-4.5 1.5l1.5 6h6L15 7Z"/>
                        <path d="m11 13 1.5 1.5"/>
                        <path d="M17.5 4.5c2.1-2.1 4.9-1.4 4.9-1.4s.7 2.8-1.4 4.9c-2.1 2.1-4.9 1.4-4.9 1.4s-.7-2.8 1.4-4.9Z"/>
                        <path d="M12 9h4"/>
                    </svg>
                </div>
            </div>
            
            <h3 class="text-2xl font-black text-[var(--azul-petroleo)] uppercase tracking-tighter mb-2">Tudo em dia, Líder!</h3>
            <p class="max-w-xs text-slate-400 font-bold text-xs leading-relaxed uppercase">Sua rede está 100% planejada para este período. Você está no comando do sucesso!</p>
            
            <button @click="init(1)" class="mt-8 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">
                Verificar novamente
            </button>
        </div>

        {{-- Loading Geral --}}
        <div x-show="loadingGeral" class="p-20 flex flex-col items-center">
            <div class="w-8 h-8 border-4 border-slate-100 border-t-[var(--azul-claro)] rounded-full animate-spin"></div>
        </div>
    </div>

    {{-- Paginação --}}
    <div x-show="pagination.last_page > 1 && consultoras.length > 0" class="mt-6 mb-10 flex items-center justify-center gap-4">
        <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1" class="p-2 bg-white border border-slate-200 rounded-xl disabled:opacity-30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest" x-text="pagination.current_page + ' / ' + pagination.last_page"></span>
        <button @click="changePage(pagination.current_page + 1)" :disabled="pagination.current_page === pagination.last_page" class="p-2 bg-white border border-slate-200 rounded-xl disabled:opacity-30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>

    {{-- Formulário de Meta --}}
    <div x-show="selectedConsultora" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-8"
         class="mt-12 bg-[var(--azul-petroleo)] rounded-[2.5rem] p-8 shadow-2xl relative border border-white/5">
        
        <div class="flex justify-between items-start mb-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[var(--dourado)] rounded-xl flex items-center justify-center text-[var(--azul-petroleo)] font-black" x-text="selectedConsultora?.nome.substring(0,2).toUpperCase()"></div>
                <div>
                    <p class="text-[var(--dourado)] font-black text-[10px] uppercase tracking-widest">Atribuindo valor à rede</p>
                    <h3 class="text-white font-black text-2xl tracking-tight" x-text="selectedConsultora?.nome"></h3>
                </div>
            </div>
            <button @click="selectedConsultora = null" class="text-white/20 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="md:col-span-2">
                <label class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-2 block">Volume de Investimento</label>
                <div class="relative">
                    <span class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-[var(--dourado)] text-lg">R$</span>
                    <input type="text" 
                           x-model="displayValor"
                           @input="formatarMoeda($event.target.value)"
                           class="w-full bg-white/5 border border-white/10 rounded-2xl py-5 pl-14 pr-6 font-black text-white text-2xl focus:border-[var(--dourado)] outline-none transition-all"
                           placeholder="0,00">
                </div>
            </div>

            <div class="md:col-span-1">
                <label class="text-[10px] font-black text-white/40 uppercase tracking-[0.2em] mb-2 block">Vigência</label>
                <select x-model="selectedConsultora.novaMeta.mes" class="w-full bg-white/5 border border-white/10 rounded-xl p-5 font-black text-white text-sm outline-none">
                    <template x-for="m in 12">
                        <option :value="m" x-text="m.toString().padStart(2, '0')" class="bg-[var(--azul-petroleo)]"></option>
                    </template>
                </select>
            </div>

            <div class="md:col-span-1 flex items-end">
                <button @click="salvarMeta(selectedConsultora)" :disabled="loadingId === selectedConsultora?.id"
                        class="w-full bg-[var(--dourado)] text-[var(--azul-petroleo)] py-5 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:brightness-110 active:scale-95 disabled:opacity-50 transition-all shadow-lg shadow-yellow-600/10">
                    <span x-show="loadingId !== selectedConsultora?.id">Salvar Objetivo</span>
                    <div x-show="loadingId === selectedConsultora?.id" class="w-5 h-5 border-2 border-[var(--azul-petroleo)] border-t-transparent rounded-full animate-spin mx-auto"></div>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function configMetasApp() {
    return {
        consultoras: [],
        search: '',
        selectedConsultora: null,
        displayValor: '',
        loadingGeral: false,
        loadingId: null,
        pagination: { current_page: 1, last_page: 1 },
        notificacao: { show: false, message: '' },

        async init(page = 1) {
            this.loadingGeral = true;
            try {
                const url = `/api/meta/pendentes?page=${page}&search=${encodeURIComponent(this.search)}`;
                const response = await fetch(url);
                const res = await response.json();
                
                if (res.status === 'success') {
                    this.consultoras = res.data.data.map(c => ({
                        ...c,
                        novaMeta: {
                            valor: 0,
                            mes: new Date().getMonth() + 1,
                            ano: new Date().getFullYear()
                        }
                    }));
                    this.pagination = { 
                        current_page: res.data.current_page, 
                        last_page: res.data.last_page 
                    };
                }
            } catch (e) { console.error(e); } finally { this.loadingGeral = false; }
        },

        formatarMoeda(valor) {
            let v = valor.replace(/\D/g, '');
            v = (v / 100).toFixed(2) + '';
            let partes = v.split('.');
            partes[0] = partes[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            this.displayValor = partes.join(',');
            if (this.selectedConsultora) {
                this.selectedConsultora.novaMeta.valor = parseFloat(v);
            }
        },

        selectConsultora(c) {
            if(String(this.selectedConsultora?.id) === String(c.id)) {
                this.selectedConsultora = null;
            } else {
                this.selectedConsultora = c;
                this.displayValor = '';
                setTimeout(() => { window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' }); }, 100);
            }
        },

        changePage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.selectedConsultora = null;
                this.init(page);
            }
        },

        async salvarMeta(consultora) {
            if (!consultora.novaMeta.valor || consultora.novaMeta.valor <= 0) {
                alert("Insira um valor válido.");
                return;
            }

            this.loadingId = consultora.id;
            const dataRef = `${consultora.novaMeta.ano}-${String(consultora.novaMeta.mes).padStart(2, '0')}-01`;

            try {
                const response = await fetch(`/api/meta/atribuir/${consultora.id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        valor_meta: consultora.novaMeta.valor,
                        data_referencia: dataRef
                    })
                });

                const res = await response.json();
                
                if (res.status === 'success' || res.status === 'sucesso') {
                    this.notificacao = { show: true, message: res.mensagem };
                    setTimeout(() => { this.notificacao.show = false; }, 3500);

                    this.consultoras = this.consultoras.filter(u => String(u.id) !== String(consultora.id));
                    this.selectedConsultora = null;
                    this.displayValor = '';

                    if (this.consultoras.length === 0) this.init(this.pagination.current_page);
                } else {
                    alert(res.mensagem || "Erro ao salvar.");
                }
            } catch (e) {
                alert("Erro de conexão.");
            } finally {
                this.loadingId = null;
            }
        }
    }
}
</script>
@endsection
