<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<div 
    x-data="{ 
        show: false, 
        loading: true,
        preCadastrosCount: 0,
        saquesCount: 0, 
        
        init() {
            this.fetchNotifications();
        },
        
        fetchNotifications() {
            this.loading = true;
            
            // Reunião das duas APIs reais que alimentam a listagem
            Promise.all([
                axios.get('/api/usuario/pre-cadastros'),
                axios.get('/api/comissao/pendentes')
            ])
            .then(([resPreCadastros, resSaques]) => {
                // Tratamento dos Pré-Cadastros
                const cadastros = resPreCadastros.data.data;
                this.preCadastrosCount = Array.isArray(cadastros) ? cadastros.length : 0;
                
                // Tratamento dos Saques Pendentes
                const saques = resSaques.data.data;
                this.saquesCount = Array.isArray(saques) ? saques.length : 0;
            })
            .catch(error => {
                console.error('Erro ao sincronizar notificações globais:', error);
                this.preCadastrosCount = 0;
                this.saquesCount = 0;
            })
            .finally(() => {
                this.loading = false;
            });
        },
        
        // Retorna verdadeiro se existir qualquer tipo de notificação ativa no sistema
        hasNotifications() {
            return this.preCadastrosCount > 0 || this.saquesCount > 0;
        }
    }" 
    @toggle-notifications.window="show = !show; if(show) fetchNotifications();"
    x-show="show"
    x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center p-4"
>
    <div 
        x-show="show" 
        x-transition:opacity
        @click="show = false" 
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-md"
    ></div>

    <div 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        class="relative w-full max-w-lg bg-[#111827] rounded-[2.5rem] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.5)] border border-white/10 overflow-hidden"
    >
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

        <div class="max-h-[50vh] overflow-y-auto custom-scrollbar p-6 space-y-3">
            
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
                <div class="space-y-3">
                    
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

                    <template x-if="saquesCount > 0">
                        <div class="group flex items-start gap-4 p-5 rounded-[2rem] bg-gradient-to-br from-amber-500/10 to-transparent border border-amber-500/20 hover:border-amber-500/40 transition-all cursor-pointer">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500/20 flex items-center justify-center text-amber-400 shrink-0 shadow-[0_0_15px_rgba(245,158,11,0.1)]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <p class="text-sm font-bold text-amber-100 tracking-tight">Saques Solicitados</p>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-black bg-amber-500 text-black uppercase tracking-tighter">Ação Requerida</span>
                                </div>
                                <p class="text-[12px] text-slate-400 mt-1 leading-snug">
                                    Existem <span class="text-amber-400 font-extrabold" x-text="saquesCount"></span> requisições de saques de comissão aguardando auditoria.
                                </p>
                            </div>
                        </div>
                    </template>

                    <template x-if="!hasNotifications()">
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
    </div>
</div>
