<div x-show="view === 'grid' && !loading" x-transition>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <template x-for="cat in paginatedCatalogos" :key="cat.id">
            <div :class="cat.encerrado ? 'opacity-60 grayscale' : 'hover:shadow-2xl'" 
                 class="bg-white rounded-[2rem] border border-gray-100 overflow-hidden relative transition-all duration-500">
                <div class="aspect-video bg-gray-100">
                    <img x-show="cat.img" :src="cat.img" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-serif text-[#2C3E50] font-black" x-text="cat.titulo"></h3>
                    <p class="text-[10px] font-bold uppercase mt-1 mb-6 text-gray-400" x-text="'Válido até ' + cat.validade"></p>
                    <button @click="abrirCatalogo(cat)" 
                            :disabled="cat.encerrado" 
                            :class="cat.encerrado ? 'bg-gray-300' : 'bg-[#E67E73] hover:bg-[#FF7665]'" 
                            class="w-full text-white py-4 rounded-2xl font-black text-[10px] uppercase shadow-lg transition-all">
                        Abrir
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
