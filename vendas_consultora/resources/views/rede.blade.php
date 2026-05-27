<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmetique Pro - Minha Rede</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #1e293b;
            --accent: #d4af37;
        }

        body { background-color: #f8fafc; overflow-x: hidden; }

        /* Estilos do Gráfico (Árvore) */
        .tree ul { padding-top: 30px; position: relative; display: flex; justify-content: center; transition: all 0.5s; }
        .tree li { float: left; text-align: center; list-style-type: none; position: relative; padding: 30px 10px 0 10px; transition: all 0.5s; }
        .tree li::before, .tree li::after { content: ''; position: absolute; top: 0; right: 50%; border-top: 2px solid #cbd5e1; width: 50%; height: 30px; }
        .tree li::after { right: auto; left: 50%; border-left: 2px solid #cbd5e1; width: 50%; height: 30px; }
        .tree li:only-child::after, .tree li:only-child::before { display: none; }
        .tree li:only-child { padding-top: 0; }
        .tree li:first-child::before, .tree li:last-child::after { border: 0 none; }
        .tree li:last-child::before { border-right: 2px solid #cbd5e1; border-radius: 0 8px 0 0; }
        .tree li:first-child::after { border-radius: 8px 0 0 0; }
        .tree ul ul::before { content: ''; position: absolute; top: 0; left: 50%; border-left: 2px solid #cbd5e1; width: 0; height: 30px; }

        .custom-scroll::-webkit-scrollbar { height: 6px; }
        .custom-scroll::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="font-sans antialiased text-slate-900">

<div x-data="redeApp()" x-init="carregarRede()" class="min-h-screen">
    
    <nav class="bg-[#1e293b] text-white p-4 shadow-xl flex justify-between items-center px-4 md:px-8 border-b border-[#d4af37]/30 sticky top-0 z-50">
        <div class="flex items-center gap-2 md:gap-3">
            <span class="text-[#d4af37] font-serif text-xl md:text-2xl font-bold tracking-tight">Cosmetique Pro</span>
            <span class="hidden md:block text-slate-400 font-light ml-4">|</span>
            <span class="hidden md:block ml-4 text-sm font-medium text-slate-300">Minha Rede</span>
        </div>
        <button onclick="history.back()" class="group flex items-center gap-2 bg-slate-800/50 hover:bg-slate-700 border border-slate-600 px-4 py-2 rounded-full transition-all text-xs md:text-sm font-bold uppercase tracking-widest text-white">
            <svg class="w-4 h-4 text-[#d4af37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Voltar
        </button>
    </nav>

    <div class="p-4 md:p-8 max-w-[1400px] mx-auto">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 md:mb-12 gap-6">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight" x-text="view === 'tree' ? 'Organograma de Rede' : 'Hierarquia de Indicações'"></h2>
                <p class="text-slate-500 mt-1 font-medium text-sm md:text-base">Visualize a estrutura e as indicações da sua rede.</p>
            </div>
            
            <div class="flex flex-col items-end gap-4 w-full md:w-auto">
                <div class="inline-flex p-1 bg-slate-200/50 rounded-xl border border-slate-200 w-full md:w-auto">
                    <button @click="trocarParaArvore()" 
                        :class="view === 'tree' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500 hover:text-slate-700'"
                        class="flex-1 md:flex-none px-4 py-2 rounded-lg text-[10px] md:text-xs font-bold uppercase tracking-wider transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Árvore
                    </button>
                    <button @click="view = 'list'" 
                        :class="view === 'list' ? 'bg-white shadow-sm text-slate-900' : 'text-slate-500 hover:text-slate-700'"
                        class="flex-1 md:flex-none px-4 py-2 rounded-lg text-[10px] md:text-xs font-bold uppercase tracking-wider transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Lista
                    </button>
                </div>

                <div class="text-right">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Total na Rede</p>
                    <p class="text-2xl font-black text-slate-700" x-text="redeTotal"></p>
                </div>
            </div>
        </div>

        <div x-show="view === 'tree'" x-transition class="hidden md:block tree-container custom-scroll overflow-x-auto pb-20 px-4">
            <div class="tree min-w-max flex justify-center scale-95 origin-top transition-transform duration-500">
                <template x-if="rede && rede.length > 0">
                    <ul>
                        <template x-for="membro in rede" :key="membro.id">
                            <li x-html="renderizarPremium(membro, 0)"></li>
                        </template>
                    </ul>
                </template>
            </div>
        </div>

        <div x-show="view === 'list'" x-transition class="space-y-8 md:space-y-12">
            
            <section>
                <div class="flex items-center gap-3 mb-6">
                    <span class="bg-[#1e293b] text-white w-6 h-6 flex items-center justify-center rounded-md text-xs font-bold">1</span>
                    <h3 class="text-xs md:text-sm font-black text-slate-800 uppercase tracking-widest">Nível 1 - Diretas</h3>
                    <div class="h-px bg-slate-200 flex-grow"></div>
                    <template x-if="filtroDiretaId">
                        <button @click="filtroDiretaId = null" class="text-[10px] bg-red-50 text-red-600 px-3 py-1 rounded-full font-bold border border-red-100 hover:bg-red-100 transition-all uppercase">
                            Limpar
                        </button>
                    </template>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                    <template x-for="direta in rede[0]?.subordinados" :key="direta.id">
                        <div @click="filtroDiretaId = direta.id" 
                             :class="filtroDiretaId === direta.id ? 'border-[#d4af37] ring-4 ring-[#d4af37]/10 bg-slate-50' : 'border-slate-100 bg-white'"
                             class="p-4 md:p-5 rounded-3xl border transition-all cursor-pointer group shadow-sm flex items-center justify-between">
                            <div class="flex items-center gap-3 md:gap-4">
                                <img :src="'https://ui-avatars.com/api/?name='+direta.nome+'&background=f1f5f9&color=1e293b&bold=true'" class="w-10 h-10 md:w-14 md:h-14 rounded-2xl border border-slate-200">
                                <div>
                                    <h4 class="text-xs md:text-sm font-black text-slate-800 uppercase" x-text="direta.nome"></h4>
                                    <p class="text-[9px] md:text-[10px] text-slate-400 font-bold uppercase tracking-tighter" x-text="direta.subordinados?.length + ' Consultoras N2'"></p>
                                </div>
                            </div>
                            <svg :class="filtroDiretaId === direta.id ? 'text-[#d4af37]' : 'text-slate-200'" class="w-5 h-5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </template>
                </div>
            </section>

            <section>
                <div class="flex items-center gap-3 mb-6">
                    <span class="bg-slate-200 text-slate-600 w-6 h-6 flex items-center justify-center rounded-md text-xs font-bold border border-slate-300">2</span>
                    <h3 class="text-xs md:text-sm font-black text-slate-800 uppercase tracking-widest">Nível 2 - Equipe</h3>
                </div>

                <div class="hidden md:block bg-white rounded-3xl border border-slate-100 shadow-xl overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Consultora</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Indicada por</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <template x-for="indireta in filtrarNivel2()" :key="indireta.id">
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-[10px] font-black text-slate-400 border border-slate-100" x-text="indireta.nome.substring(0,2).toUpperCase()"></div>
                                            <div>
                                                <span class="text-sm font-bold text-slate-700 block" x-text="indireta.nome"></span>
                                                <span class="text-[9px] text-slate-400 font-mono">ID: #<span x-text="indireta.id"></span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-xs font-bold text-slate-500" x-text="indireta.indicadaPor"></td>
                                    <td class="px-8 py-5 text-center">
                                        <span class="text-[9px] font-black bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full uppercase">Ativa</span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden space-y-3">
                    <template x-for="indireta in filtrarNivel2()" :key="indireta.id">
                        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-black text-slate-800 uppercase" x-text="indireta.nome"></span>
                                <span class="text-[8px] font-black bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded uppercase">Ativa</span>
                            </div>
                            <div class="flex justify-between items-center text-[10px]">
                                <span class="text-slate-400 font-bold uppercase tracking-tighter">Indicada por:</span>
                                <span class="text-slate-700 font-bold" x-text="indireta.indicadaPor"></span>
                            </div>
                        </div>
                    </template>
                </div>
                
                <template x-if="filtrarNivel2().length === 0">
                    <div class="text-center py-10 text-slate-400 text-xs italic">Nenhuma consultora encontrada.</div>
                </template>
            </section>
        </div>
    </div>

    <div x-show="mostrarAlerta" x-transition class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm">
        <div @click.away="mostrarAlerta = false" class="bg-white p-8 rounded-3xl shadow-2xl max-w-sm w-full text-center">
            <div class="w-16 h-16 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-xl font-black text-slate-800 mb-2 uppercase">Versão Desktop</h3>
            <p class="text-slate-500 text-sm mb-6 font-medium">A visualização em Árvore está disponível apenas em computadores para garantir a melhor experiência.</p>
            <button @click="mostrarAlerta = false" class="w-full bg-[#1e293b] text-white py-3 rounded-xl font-bold uppercase text-xs tracking-widest shadow-lg active:scale-95 transition-all">Entendi</button>
        </div>
    </div>

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
                const token = localStorage.getItem('token');
                const response = await fetch('/api/relatorios/crescimento-rede', {
                    headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
                });
                const res = await response.json();
                if (res.status === 'success') {
                    this.rede = res.dados.estrutura_arvore || [];
                    this.redeTotal = res.dados.resumo.total_na_rede || 0;
                }
            } catch (e) { console.error("Erro ao carregar dados."); }
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
                            nivel2.push({ ...indireta, indicadaPor: direta.nome });
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
            const tagNivel = nivel === 1 ? '<span class="text-[9px] font-bold bg-[#d4af37]/10 text-[#d4af37] px-2 py-0.5 rounded-md mt-2 inline-block uppercase">Nível 1 - Direta</span>' : 
                             nivel === 2 ? '<span class="text-[9px] font-bold bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md mt-2 inline-block uppercase">Nível 2 - Indireta</span>' : '';

            return `
                <div class="inline-block">
                    <div class="bg-white ${bordaCard} rounded-[1.5rem] min-w-[210px] overflow-hidden transition-all duration-500 group">
                        <div class="${bgHeader} p-6 flex flex-col items-center">
                            <div class="relative mb-4">
                                <div class="w-14 h-14 rounded-2xl bg-white p-1 ring-2 ring-slate-100 overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name=${membro.nome}&background=f8fafc&color=1e293b&bold=true" class="w-full h-full rounded-xl object-cover">
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
</body>
</html>