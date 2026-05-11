{{-- Este componente serve apenas como referência visual ou template para o JS --}}
<div class="inline-block">
    <div :class="nivel === 0 ? 'border-[#d4af37] border-2 shadow-2xl' : 'border-slate-200 shadow-xl'" 
         class="bg-white rounded-[1.5rem] min-w-[210px] overflow-hidden transition-all duration-500 group">
        <div :class="nivel === 0 ? 'bg-slate-50/50' : 'bg-white'" class="p-6 flex flex-col items-center">
            <div class="relative mb-4">
                <div class="w-14 h-14 rounded-2xl bg-white p-1 ring-2 ring-slate-100 overflow-hidden">
                    <img :src="'https://ui-avatars.com/api/?name='+membro.nome+'&background=f8fafc&color=1e293b&bold=true'" class="w-full h-full rounded-xl object-cover">
                </div>
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></div>
            </div>
            <h4 class="text-sm font-black text-slate-800 uppercase tracking-tight" x-text="membro.nome + (nivel === 0 ? ' (VOCÊ)' : '')"></h4>
            <p class="text-[10px] text-slate-400 font-mono" x-text="'ID: #' + membro.id"></p>
            
            <template x-if="nivel === 1">
                <span class="text-[9px] font-bold bg-[#d4af37]/10 text-[#d4af37] px-2 py-0.5 rounded-md mt-2 inline-block uppercase">Nível 1 - Direta</span>
            </template>
            <template x-if="nivel === 2">
                <span class="text-[9px] font-bold bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md mt-2 inline-block uppercase">Nível 2 - Indireta</span>
            </template>
        </div>
    </div>
</div>
