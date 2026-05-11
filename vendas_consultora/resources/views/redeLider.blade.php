@extends('layouts.app')

@section('content')
<x-rede.styles />

<style>
    /* Animação para o ícone de engrenagem/meta */
    .pulse-icon {
        animation: pulse-soft 2s infinite;
    }
    @keyframes pulse-soft {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.15); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>

<div x-data="redeApp()" x-init="carregarRede()" class="min-h-screen">
    
    {{-- Header da Rede --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 md:mb-12 gap-6">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight" x-text="view === 'tree' ? 'Organograma de Rede' : 'Hierarquia de Indicações'"></h2>
            <p class="text-slate-500 mt-1 font-medium text-sm md:text-base">Visualize a estrutura da sua rede.</p>
        </div>
        
        <div class="flex flex-col items-end gap-4 w-full md:w-auto">
            <div class="flex flex-wrap items-center justify-end gap-3 w-full md:w-auto">
                
                {{-- Botão: Definir Metas (Novo) --}}
                <a href="/metas/configuracao-equipe" 
                   class="flex items-center gap-2 bg-white border-2 border-[#d4af37] text-slate-800 px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all shadow-lg group">
                    <svg class="w-4 h-4 text-[#d4af37] pulse-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                    Definir Metas
                </a>

                {{-- Botão: Desempenho --}}
                <a href="/relatorios/desempenho-equipe" 
                   class="flex items-center gap-2 bg-slate-800 text-white px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-700 transition-all shadow-lg shadow-slate-200 border-b-2 border-[#d4af37] group">
                    <svg class="w-4 h-4 text-[#d4af37] group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Análise de Desempenho
                </a>

                <div class="inline-flex p-1 bg-slate-200/50 rounded-xl border border-slate-200">
                    <button @click="trocarParaArvore()" :class="view === 'tree' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500'" class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Árvore
                    </button>
                    <button @click="view = 'list'" :class="view === 'list' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500'" class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Lista
                    </button>
                </div>
            </div>

            <div class="text-right">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Total na Rede</p>
                <p class="text-2xl font-black text-slate-700" x-text="redeTotal"></p>
            </div>
        </div>
    </div>

    {{-- View: Árvore --}}
    <div x-show="view === 'tree'" x-transition class="hidden md:block tree-container custom-scroll overflow-x-auto pb-20">
        <div class="tree min-w-max flex justify-center scale-95 origin-top">
            <template x-if="rede.length > 0">
                <ul>
                    <template x-for="membro in rede" :key="membro.id">
                        <li x-html="renderizarPremium(membro, 0)"></li>
                    </template>
                </ul>
            </template>
        </div>
    </div>

    {{-- View: Lista --}}
    <div x-show="view === 'list'" x-transition>
        @include('components.rede.partials.lista-niveis')
    </div>

    {{-- Modal Alerta Mobile --}}
    <x-rede.modal-mobile />

</div>

<script>
function redeApp() {
    return {
        view: window.innerWidth < 768 ? 'list' : 'tree',
        rede: [],
        redeTotal: 0,
        filtroDiretaId: null,
        mostrarAlerta: false,

        async carregarRede() {
            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                const response = await fetch('/api/relatorios/crescimento-rede', {
                    headers: { 
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json' 
                    }
                });
                const res = await response.json();
                
                if (res.status === 'success') {
                    this.rede = res.dados.estrutura_arvore || [];
                    this.redeTotal = res.dados.resumo.total_na_rede || 0;
                }
            } catch (e) { 
                console.error("Erro ao carregar dados da rede:", e); 
            }
        },

        trocarParaArvore() {
            if (window.innerWidth < 768) {
                this.mostrarAlerta = true;
                return;
            }
            this.view = 'tree';
        },

        filtrarNivel2() {
            let nivel2 = [];
            if (!this.rede[0] || !this.rede[0].subordinados) return nivel2;
            
            this.rede[0].subordinados.forEach(direta => {
                if (!this.filtroDiretaId || this.filtroDiretaId === direta.id) {
                    if (direta.subordinados) {
                        direta.subordinados.forEach(indireta => {
                            nivel2.push({ 
                                ...indireta, 
                                indicadaPor: direta.nome 
                            });
                        });
                    }
                }
            });
            return nivel2;
        },

        renderizarPremium(membro, nivel) {
            let htmlFilhos = '';
            if (nivel < 2 && membro.subordinados && membro.subordinados.length > 0) {
                htmlFilhos = '<ul>';
                membro.subordinados.forEach(filho => {
                    htmlFilhos += `<li>${this.renderizarPremium(filho, nivel + 1)}</li>`;
                });
                htmlFilhos += '</ul>';
            }

            const bordaCard = nivel === 0 ? 'border-[#d4af37] border-2 shadow-2xl' : 'border-slate-200 shadow-xl';
            const bgHeader = nivel === 0 ? 'bg-slate-50/50' : 'bg-white';
            
            let tagNivel = '';
            if (nivel === 1) tagNivel = '<span class="text-[9px] font-bold bg-[#d4af37]/10 text-[#d4af37] px-2 py-0.5 rounded-md mt-2 inline-block uppercase">Nível 1 - Direta</span>';
            if (nivel === 2) tagNivel = '<span class="text-[9px] font-bold bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md mt-2 inline-block uppercase">Nível 2 - Indireta</span>';

            return `
                <div class="inline-block">
                    <div class="bg-white ${bordaCard} rounded-[1.5rem] min-w-[210px] overflow-hidden transition-all duration-500 group">
                        <div class="${bgHeader} p-6 flex flex-col items-center">
                            <div class="relative mb-4">
                                <div class="w-14 h-14 rounded-2xl bg-white p-1 ring-2 ring-slate-100 overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(membro.nome)}&background=f8fafc&color=1e293b&bold=true" class="w-full h-full rounded-xl object-cover">
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></div>
                            </div>
                            <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight">${membro.nome} ${nivel === 0 ? '(VOCÊ)' : ''}</h4>
                            <p class="text-[10px] text-slate-400 font-mono">ID: #${membro.id}</p>
                            ${tagNivel}
                        </div>
                    </div>
                    ${htmlFilhos}
                </div>
            `;
        }
    }
}
</script>
@endsection
