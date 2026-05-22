@extends('layouts.appAdmin')

@section('title', 'Glow | Gerenciar Catálogos')

@section('header', 'Gestão de Catálogos & Campanhas')

@section('content')
<div x-data="{ 
    modalOpen: false, 
    drawerOpen: false,
    selectedCatalogo: {nome: '', itens: []},
    catalogos: [
        {
            id: 1,
            nome: 'Campanha de Outono - Glow Premium',
            tipo: 'Venda Direta',
            status: 'Ativo',
            descricao: 'Focado em fragrâncias marcantes e hidratação profunda para o clima ameno.',
            publicacao: '2026-03-01 00:00',
            encerramento: '2026-03-31 23:59',
            progresso: 65,
            itens_count: 24,
            itens: [
                { id: 101, produto: 'Batom Matte Velvet Glow', pontos: 15, estoque: 150, status: 'Disponível' },
                { id: 102, produto: 'Sérum Facial Ácido Hialurônico', pontos: 40, estoque: 80, status: 'Disponível' },
                { id: 103, produto: 'Perfume Luxury Gold Edição Limitada', pontos: 120, estoque: 30, status: 'Esgotado' }
            ]
        },
        {
            id: 2,
            nome: 'Ciclo de Renovação Skincare Pro',
            tipo: 'Gamificação & Resgate',
            status: 'Inativo',
            descricao: 'Lançamento da linha Pro-Aging com foco em recrutamento de novas consultoras.',
            publicacao: '2026-04-01 00:00',
            encerramento: '2026-04-30 23:59',
            progresso: 0,
            itens_count: 12,
            itens: [
                { id: 104, produto: 'Gel de Limpeza Facial Purificante', pontos: 20, estoque: 200, status: 'Disponível' },
                { id: 105, produto: 'Protetor Solar Fluido FPS 60', pontos: 35, estoque: 120, status: 'Disponível' }
            ]
        }
    ],
    openDrawer(catalogo) {
        this.selectedCatalogo = catalogo;
        this.drawerOpen = true;
    }
}" x-init="document.body.classList.add('ready')" class="space-y-8 relative">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in">
        <div class="bg-slate-50 border border-slate-200/60 rounded-2xl p-6 flex items-center justify-between transition-all hover:shadow-sm">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ciclos Ativos</span>
                <h4 class="text-2xl font-bold text-slate-900 mt-1">01 Ativo</h4>
                <p class="text-[11px] text-emerald-600 font-medium mt-0.5 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Campanha de Outono rodando
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-700 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>

        <div class="bg-slate-50 border border-slate-200/60 rounded-2xl p-6 flex items-center justify-between transition-all hover:shadow-sm">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Produtos em Vitrines</span>
                <h4 class="text-2xl font-bold text-slate-900 mt-1">36 Cosméticos</h4>
                <p class="text-[11px] text-slate-400 mt-0.5">Distribuídos entre as campanhas</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-700 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 11m8 4V5M4 11v10l8 4" /></svg>
            </div>
        </div>

        <div class="bg-slate-50 border border-slate-200/60 rounded-2xl p-6 flex items-center justify-between transition-all hover:shadow-sm">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Média de Recompensa</span>
                <h4 class="text-2xl font-bold text-slate-900 mt-1">48 Pts médios</h4>
                <p class="text-[11px] text-indigo-600 font-medium mt-0.5">Acelera o plano de carreira</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-700 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pt-4 border-t border-slate-100">
        <div>
            <h3 class="text-lg font-bold text-slate-900 tracking-tight">Lista de Campanhas</h3>
            <p class="text-xs text-slate-400">Gerencie os ciclos cronológicos e vincule produtos exclusivos para as consultoras.</p>
        </div>
        <button @click="modalOpen = true" class="group flex items-center gap-2 px-4 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl transition-all shadow-sm active:scale-95 duration-150 text-xs font-semibold uppercase tracking-wider">
            <svg class="w-4 h-4 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            Nova Campanha
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="(cat, index) in catalogos" :key="cat.id">
            <div 
                class="bg-white border border-slate-200 rounded-[1.8rem] p-6 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.05)] hover:border-slate-300 relative group"
                :style="'animation: fadeInUp 0.5s ease both; animation-delay: ' + (index * 150) + 'ms;'"
            >
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span :class="cat.status === 'Ativo' ? 'bg-emerald-50 text-emerald-700 border-emerald-200/50' : 'bg-slate-100 text-slate-500 border-slate-200'" class="px-2.5 py-1 rounded-md text-[9px] font-extrabold uppercase tracking-widest border">
                            <span x-show="cat.status === 'Ativo'" class="inline-block w-1 h-1 bg-emerald-500 rounded-full mr-1 animate-pulse"></span>
                            <span x-text="cat.status"></span>
                        </span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter" x-text="cat.tipo"></span>
                    </div>

                    <h4 class="text-base font-bold text-slate-900 tracking-tight group-hover:text-black transition-colors" x-text="cat.nome"></h4>
                    <p class="text-xs text-slate-400 mt-2 line-clamp-2 leading-relaxed font-light" x-text="cat.descricao"></p>

                    <div class="mt-6 space-y-2">
                        <div class="flex items-center justify-between text-[10px] font-semibold text-slate-400">
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                Vigência do Ciclo
                            </span>
                            <span x-text="cat.status === 'Ativo' ? cat.progresso + '%' : 'Aguardando'"></span>
                        </div>
                        <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div :class="cat.status === 'Ativo' ? 'bg-slate-900' : 'bg-slate-300'" class="h-full rounded-full transition-all duration-1000" :style="'width: ' + cat.progresso + '%'"></div>
                        </div>
                        <div class="flex items-center justify-between text-[9px] text-slate-400 pt-1 font-mono">
                            <span x-text="'Início: ' + cat.publicacao"></span>
                            <span x-text="'Fim: ' + cat.encerramento"></span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] font-bold text-slate-500 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        <span class="text-slate-800 font-extrabold" x-text="cat.itens_count"></span> Itens vinculados
                    </span>

                    <button @click="openDrawer(cat)" class="text-[11px] font-bold text-slate-900 hover:text-black flex items-center gap-1 group/btn transition-colors">
                        Gerenciar Vitrine
                        <svg class="w-3 h-3 group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>
            </div>
        </template>
    </div>

    <div x-show="drawerOpen" class="fixed inset-0 overflow-hidden z-50 shadow-2xl" x-cloak>
        <div class="absolute inset-0 overflow-hidden">
            <div x-show="drawerOpen" 
                 x-transition:enter="ease-in-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 @click="drawerOpen = false"
                 class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity"></div>

            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div x-show="drawerOpen"
                     x-transition:enter="transform transition ease-in-out duration-400 sm:duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-400 sm:duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                     class="pointer-events-auto w-screen max-w-xl bg-white border-l border-slate-200 p-8 flex flex-col justify-between shadow-[0_0_60px_-15px_rgba(0,0,0,0.15)] md:rounded-l-[2.5rem]">
                    
                    <div class="flex-1 overflow-y-auto custom-scrollbar pr-2">
                        <div class="flex items-start justify-between pb-6 border-b border-slate-100">
                            <div>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Painel Relacional</span>
                                <h2 class="text-xl font-bold text-slate-900 tracking-tight" x-text="selectedCatalogo.nome"></h2>
                                <p class="text-xs text-slate-400 mt-0.5">Gerenciamento dinâmico de regras e vitrines (`itens_catalogo`)</p>
                            </div>
                            <button @click="drawerOpen = false" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l18 18" /></svg>
                            </button>
                        </div>

                        <div class="my-6 p-4 bg-slate-50 border border-slate-200/60 rounded-2xl flex items-center justify-between gap-4">
                            <div class="flex-1">
                                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-tight block mb-1">Adicionar Produto ao Ciclo</span>
                                <select class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium focus:outline-none focus:border-slate-400 text-slate-700">
                                    <option value="">Selecione um cosmético do inventário...</option>
                                    <option value="1">Batom Líquido Matte Intenso</option>
                                    <option value="2">Iluminador Stick Rose Gold</option>
                                </select>
                            </div>
                            <button class="h-9 px-4 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl self-end transition-all active:scale-95 flex items-center justify-center">
                                Inserir
                            </button>
                        </div>

                        <div class="space-y-4">
                            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Produtos já Vinculados</h4>
                            
                            <template x-for="item in selectedCatalogo.itens" :key="item.id">
                                <div class="p-4 border border-slate-200 rounded-2xl bg-white hover:border-slate-300 transition-colors space-y-3">
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs font-bold text-slate-900" x-text="item.produto"></p>
                                        <button class="text-slate-400 hover:text-red-500 transition-colors p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="text-[9px] font-bold text-slate-400 uppercase tracking-wide block mb-1">Pontos Recompensa</label>
                                            <div class="relative">
                                                <input type="number" :value="item.pontos" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-xs font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-slate-400" />
                                                <span class="absolute right-3 top-2 text-[9px] font-bold text-slate-400 uppercase">Pts</span>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="text-[9px] font-bold text-slate-400 uppercase tracking-wide block mb-1">Estoque na Vitrine</label>
                                            <input type="number" :value="item.estoque" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-xs font-bold text-slate-800 focus:outline-none focus:bg-white focus:border-slate-400" />
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
                        <button @click="drawerOpen = false" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-colors">
                            Voltar
                        </button>
                        <button @click="drawerOpen = false; Swal.fire({title: 'Sucesso!', text: 'Vitrine de itens atualizada com segurança.', icon: 'success', confirmButtonColor: '#0F172A'})" class="flex-1 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition-all shadow-sm">
                            Salvar Alterações
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div x-show="modalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="modalOpen" 
                 x-transition:opacity class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" @click="modalOpen = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="modalOpen"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                 class="inline-block align-middle bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200 p-8 space-y-6">
                
                <div>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Painel Global</span>
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight">Criar Nova Campanha</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Defina os parâmetros do ciclo macro que ditarão as regras de venda da vitrine digital.</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">Nome da Campanha / Catálogo</label>
                        <input type="text" placeholder="Ex: Ciclo 03/2026 - Especial Dia das Mães" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs focus:outline-none focus:bg-white focus:border-slate-400 text-slate-800 font-medium" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">Tipo de Catálogo</label>
                            <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs focus:outline-none focus:bg-white focus:border-slate-400 text-slate-700 font-medium">
                                <option value="1">Venda Direta Tradicional</option>
                                <option value="2">Resgate de Pontos</option>
                                <option value="3">Misto / Promocional</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">Status Inicial</label>
                            <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs focus:outline-none focus:bg-white focus:border-slate-400 text-slate-700 font-medium">
                                <option value="1">Ativo (Publicado)</option>
                                <option value="2">Inativo (Rascunho)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">Descrição Comercial</label>
                        <textarea rows="3" placeholder="Insira os detalhes e objetivos desta campanha para as consultoras..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-xs focus:outline-none focus:bg-white focus:border-slate-400 text-slate-800 font-light leading-relaxed"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">Data de Publicação</label>
                            <input type="datetime-local" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs focus:outline-none focus:bg-white focus:border-slate-400 text-slate-700" />
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">Data de Encerramento</label>
                            <input type="datetime-local" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs focus:outline-none focus:bg-white focus:border-slate-400 text-slate-700" />
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                    <button @click="modalOpen = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl transition-colors">
                        Cancelar
                    </button>
                    <button @click="modalOpen = false; Swal.fire({title: 'Excelente!', text: 'Novo ciclo cadastrado no banco de dados.', icon: 'success', confirmButtonColor: '#0F172A'})" class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl transition-all shadow-sm">
                        Gravar Campanha
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(18px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both;
    }
</style>
@endsection
