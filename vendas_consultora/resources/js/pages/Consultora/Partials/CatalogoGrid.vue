<template>
  <div v-if="view === 'grid' && !loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <div 
      v-for="cat in paginatedCatalogos" 
      :key="cat.id"
      :class="cat.encerrado ? 'opacity-65 grayscale bg-gray-50 dark:bg-slate-950' : 'hover:shadow-[0_20px_50px_rgba(44,62,80,0.12)] dark:hover:shadow-[0_20px_50px_rgba(0,0,0,0.4)] hover:-translate-y-1'" 
      class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-gray-100/80 dark:border-slate-800/60 overflow-hidden relative transition-all duration-500 flex flex-col group"
    >
      <div class="absolute top-4 right-4 z-20">
        <span 
          :class="cat.encerrado ? 'bg-gray-400 dark:bg-slate-700 text-white' : 'bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-sm'" 
          class="px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest"
        >
          {{ cat.encerrado ? 'Encerrado' : 'Disponível' }}
        </span>
      </div>

      <div class="aspect-[16/10] bg-gradient-to-br from-gray-50 to-gray-100 dark:from-slate-950 dark:to-slate-900 relative overflow-hidden">
        <img 
          v-if="cat.img" 
          :src="cat.img" 
          class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
        >
        <div v-else class="w-full h-full flex flex-col items-center justify-center text-gray-300 dark:text-slate-700 group-hover:text-[#FF7665]/40 transition-colors">
          <svg class="w-12 h-12 stroke-[1.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>

      <div class="p-6 flex-1 flex flex-col justify-between">
        <div>
          <h3 class="text-xl font-serif text-[#2C3E50] dark:text-slate-100 font-black group-hover:text-[#E67E73] dark:group-hover:text-[#E67E73] transition-colors duration-300">
            {{ cat.titulo }}
          </h3>
          <p class="text-gray-400 dark:text-slate-400 text-xs mt-2 line-clamp-2 leading-relaxed">
            {{ cat.descricao || 'Confira todas as novidades e ofertas exclusivas separadas para esta campanha.' }}
          </p>
        </div>

        <div class="mt-6">
          <div class="flex items-center justify-between text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-slate-500 mb-4 bg-gray-50 dark:bg-slate-950 p-2.5 rounded-xl border border-transparent dark:border-slate-800/40">
            <span>Validade</span>
            <span class="text-[#2C3E50] dark:text-slate-200 font-black">{{ cat.validade }}</span>
          </div>

          <button 
            @click="$emit('abrir-catalogo', cat)" 
            :disabled="cat.encerrado" 
            :class="cat.encerrado ? 'bg-gray-200 dark:bg-slate-800 text-gray-400 dark:text-slate-600 cursor-not-allowed shadow-none' : 'bg-[#E67E73] text-white hover:bg-[#2C3E50] dark:hover:bg-slate-950 hover:shadow-[#2C3E50]/10'" 
            class="w-full py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-[#E67E73]/10 dark:shadow-none transition-all active:scale-[0.98]"
          >
            {{ cat.encerrado ? 'Indisponível' : 'Explorar Coleção' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  view: String,
  loading: Boolean,
  paginatedCatalogos: Array
})
defineEmits(['abrir-catalogo'])
</script>