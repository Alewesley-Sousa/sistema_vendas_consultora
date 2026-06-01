<template>
  <section class="bg-white dark:bg-slate-900 p-4 rounded-xl shadow-sm flex flex-col md:flex-row gap-4 items-center border border-slate-200/60 dark:border-slate-800/80 transition-colors">
    <div class="w-full md:flex-1 relative">
      <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 text-lg">search</span>
      <input 
        :value="search" 
        @input="$emit('update:search', $event.target.value)" 
        type="text" 
        placeholder="Buscar por nome, descrição ou SKU..."
        class="w-full pl-11 pr-4 py-2.5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg text-sm text-slate-900 dark:text-slate-100 focus:border-slate-400 dark:focus:border-slate-600 focus:ring-0 transition-all outline-none placeholder-slate-400 dark:placeholder-slate-500"
      />
    </div>

    <div class="w-full md:w-auto relative class-dropdown-container">
      <button 
        @click="$emit('toggle-dropdown')"
        type="button" 
        class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg px-4 py-2.5 text-sm text-slate-800 dark:text-slate-200 focus:border-slate-400 dark:focus:border-slate-600 focus:ring-0 outline-none min-w-[180px] flex items-center justify-between gap-2 transition-colors"
      >
        <span class="truncate">{{ categoryFilter === 'all' ? 'Categoria' : categoryFilter }}</span>
        <span class="material-symbols-outlined text-slate-400 text-sm transition-transform duration-200" :class="{'rotate-180': dropdownOpen}">keyboard_arrow_down</span>
      </button>
      
      <ul 
        v-if="dropdownOpen"
        class="absolute left-0 mt-2 w-full z-30 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-xl py-1 max-h-60 overflow-y-auto font-medium"
      >
        <li @click="$emit('select-category', 'all')" class="px-4 py-2 text-sm text-slate-600 dark:text-slate-300 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors">
          Todas as Categorias
        </li>
        <li 
          v-for="categoria in categorias" 
          :key="categoria.id"
          @click="$emit('select-category', categoria.nome)" 
          class="px-4 py-2 text-sm text-slate-600 dark:text-slate-300 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-colors"
        >
          {{ categoria.nome }}
        </li>
      </ul>
    </div>

    <button 
      v-if="search !== '' || categoryFilter !== 'all'"
      @click="$emit('clear')"
      class="text-slate-400 dark:text-slate-500 hover:text-rose-500 dark:hover:text-rose-400 font-['JetBrains_Mono'] text-xs transition-colors px-2 flex items-center gap-1"
    >
      <span class="material-symbols-outlined text-xs">close</span> Limpar Filtros
    </button>

    <div class="w-full md:w-auto md:ml-auto">
      <button 
        @click="$emit('open-create')" 
        class="w-full md:w-auto bg-slate-900 hover:bg-slate-800 dark:bg-slate-100 dark:hover:bg-white text-white dark:text-slate-900 px-5 py-2.5 rounded-lg flex items-center justify-center gap-2 font-['JetBrains_Mono'] text-xs transition-all active:scale-95 shadow-sm uppercase tracking-wider font-bold"
      >
        <span class="material-symbols-outlined text-sm">add</span> Novo Produto
      </button>
    </div>
  </section>
</template>

<script setup>
defineProps({
  search: String,
  categoryFilter: String,
  dropdownOpen: Boolean,
  categorias: Array
});
defineEmits(['update:search', 'toggle-dropdown', 'select-category', 'clear', 'open-create']);
</script>