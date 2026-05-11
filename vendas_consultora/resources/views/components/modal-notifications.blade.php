<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<div 
    x-data="{ 
        show: false, 
        loading: true,
        preCadastrosCount: 0,
        init() {
            this.fetchNotifications();
        },
        fetchNotifications() {
            this.loading = true;
            
            axios.get('/api/usuario/pre-cadastros')
                .then(response => {
                    /** 
                     * AJUSTE AQUI:
                     * response.data -> é o objeto completo da resposta (JSON)
                     * response.data.data -> é o array de consultoras que você enviou
                     */
                    const registros = response.data.data;
                    this.preCadastrosCount = Array.isArray(registros) ? registros.length : 0;
                })
                .catch(error => {
                    console.error('Erro ao buscar pré-cadastros:', error);
                    this.preCadastrosCount = 0;
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }" 
    @toggle-notifications.window="show = !show; if(show) fetchNotifications();"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center p-4"
>
    <!-- Overlay -->
    <div 
        x-show="show" 
        x-transition:opacity
        @click="show = false" 
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-md"
    ></div>

    <!-- Corpo do Modal -->
    <div 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        class="relative w-full max-w-lg bg-[#111827] rounded-[2.5rem] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.5)] border border-white/10 overflow-hidden"
    >
        <!-- Header -->
        <div class="px-8 pt-8 pb-6 border-b border-white/5 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-white tracking-tight">Notificações</h3>
                <p class="text-slate-500 text-[10px] uppercase tracking-widest mt-1 font-bold">Monitoramento em Tempo Real</p>
            </div>
            <button @click="show = false" class="p-2 hover:bg-white/5 rounded-full text-slate-400 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        <!-- Lista de Notificações -->
        <div class="max-h-[50vh] overflow-y-auto custom-scrollbar p-6 space-y-3">
            
            <!-- Skeleton Loading -->
            <template x-if="loading">
                <div class="space-y-3">
                    <div class="animate-pulse flex space-x-4 p-4 bg-white/5 rounded-3xl">
                        <div class="rounded-2xl bg-white/10 h-10 w-10"></div>
                        <div class="flex-1 space-y-2 py-1">
                            <div class="h-2 bg-white/10 rounded w-3/4"></div>
                            <div class="h-2 bg-white/10 rounded w-1/2"></div>
                        </div>
                    </div>
                </div>
            </template>

            <template x-if="!loading">
                <div>
                    <!-- Notificação de Pré-Cadastros -->
                    <template x-if="preCadastrosCount > 0">
                        <div class="group flex items-start gap-4 p-5 rounded-[2rem] bg-gradient-to-br from-blue-500/10 to-transparent border border-blue-500/20 hover:border-blue-500/40 transition-all cursor-pointer">
                            <div class="w-12 h-12 rounded-2xl bg-blue-500/20 flex items-center justify-center text-blue-400 shrink-0 shadow-[0_0_15px_rgba(59,130,246,0.1)]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <p class="text-sm font-bold text-blue-100 tracking-tight">Novos Pré-Cadastros</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-black bg-blue-500 text-white uppercase tracking-tighter">Pendente</span>
                                </div>
                                <p class="text-[12px] text-slate-400 mt-1 leading-snug">
                                    Há <span class="text-blue-400 font-extrabold" x-text="preCadastrosCount"></span> solicitações de novas consultoras aguardando análise.
                                </p>
                            </div>
                        </div>
                    </template>

                    <!-- Estado Vazio -->
                    <template x-if="preCadastrosCount === 0">
                        <div class="py-12 text-center">
                            <div class="w-20 h-20 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/5">
                                <svg class="w-10 h-10 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <p class="text-slate-300 text-sm font-semibold">Sem pendências</p>
                            <p class="text-slate-500 text-[10px] uppercase mt-1 tracking-widest">Aguardando novas interações</p>
                        </div>
                    </template>
                </div>
            </template>

        </div>

        <!-- Footer -->
        <div class="p-6 bg-white/[0.02] border-t border-white/5">
            <a href="/usuario/pre-cadastros" class="flex items-center justify-center gap-2 w-full py-4 rounded-2xl bg-white/5 hover:bg-white/10 text-[11px] font-bold text-white uppercase tracking-[0.2em] transition-all group">
                <span>Painel de Aprovações</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </div>
</div>
