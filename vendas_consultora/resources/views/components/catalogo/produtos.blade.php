<div x-show="view === 'detalhes' && !loading" x-transition>
    <button @click="view = 'grid'" class="mb-8 flex items-center gap-2 text-[#2C3E50] font-black text-xs uppercase hover:text-[#FF7665]">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2.5" />
        </svg> Voltar
    </button>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <template x-for="prod in paginatedProdutos" :key="prod.id">
            <div class="bg-white p-5 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-md transition-all">
                <div class="aspect-square bg-gray-50 rounded-2xl mb-4 overflow-hidden">
                    <img :src="prod.img" class="w-full h-full object-cover">
                </div>
                <h4 class="font-bold text-[#2C3E50] text-xs h-8 overflow-hidden" x-text="prod.nome"></h4>
                <p class="text-[#E67E73] font-black text-sm my-2" x-text="'R$ ' + prod.preco.toLocaleString('pt-BR', {minimumFractionDigits: 2})"></p>
                <button @click="adicionar(prod)" class="w-full bg-[#2C3E50] text-white py-2 rounded-xl text-[10px] font-black uppercase hover:bg-[#FF7665]">
                    Adicionar
                </button>
            </div>
        </template>
    </div>
</div>
