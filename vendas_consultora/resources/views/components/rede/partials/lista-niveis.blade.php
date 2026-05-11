{{-- resources/views/rede/partials/lista-niveis.blade.php --}}
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
        <template x-for="direta in (rede[0]?.subordinados || [])" :key="direta.id">
            <div @click="filtroDiretaId = direta.id" 
                 :class="filtroDiretaId === direta.id ? 'border-[#d4af37] ring-4 ring-[#d4af37]/10 bg-slate-50' : 'border-slate-100 bg-white'"
                 class="p-4 md:p-5 rounded-3xl border transition-all cursor-pointer group shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3 md:gap-4">
                    <img :src="'https://ui-avatars.com/api/?name='+direta.nome+'&background=f1f5f9&color=1e293b&bold=true'" class="w-10 h-10 md:w-14 md:h-14 rounded-2xl border border-slate-200">
                    <div>
                        <h4 class="text-xs md:text-sm font-black text-slate-800 uppercase" x-text="direta.nome"></h4>
                        <p class="text-[9px] md:text-[10px] text-slate-400 font-bold uppercase tracking-tighter" x-text="(direta.subordinados?.length || 0) + ' Consultoras N2'"></p>
                    </div>
                </div>
                <svg :class="filtroDiretaId === direta.id ? 'text-[#d4af37]' : 'text-slate-200'" class="w-5 h-5 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
        </template>
    </div>
</section>

<section class="mt-12">
    <div class="flex items-center gap-3 mb-6">
        <span class="bg-slate-200 text-slate-600 w-6 h-6 flex items-center justify-center rounded-md text-xs font-bold border border-slate-300">2</span>
        <h3 class="text-xs md:text-sm font-black text-slate-800 uppercase tracking-widest">Nível 2 - Equipe</h3>
    </div>

    {{-- ... restante do código da tabela e lista mobile que estava no seu HTML original ... --}}
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
</section>
