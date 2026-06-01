<template>
  <div class="py-4 text-center animate-fade-in">
    <div class="flex items-center gap-3 bg-rose-50 dark:bg-rose-950/20 border border-rose-200 dark:border-rose-900/40 p-4 rounded-2xl text-rose-800 dark:text-rose-400 text-left mb-6 shadow-sm transition-colors duration-300">
      <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-xl bg-rose-500 text-white shadow-md">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
      </div>
      <div>
        <h5 class="text-sm font-bold uppercase tracking-wider">A operação falhou!</h5>
        <p class="text-xs text-rose-600/90 dark:text-rose-400/80 font-medium">Verifique os detalhes do aviso abaixo para corrigir o problema.</p>
      </div>
    </div>

    <h3 class="mb-2 text-xl font-bold text-[#2C3E50] dark:text-slate-100 transition-colors">Não foi possível prosseguir</h3>
    
    <p class="mb-8 text-sm text-slate-500 dark:text-slate-400 px-6 max-w-md mx-auto bg-slate-50 dark:bg-slate-900/50 py-3 rounded-2xl border border-slate-100 dark:border-slate-800/60 font-medium transition-colors duration-300">
      {{ message || 'O registro não foi encontrado ou ocorreu uma falha de comunicação com o servidor.' }}
    </p>

    <div class="flex flex-col gap-3 sm:flex-row">
      <button 
        type="button" 
        @click="$emit('change-step', 'form')" 
        class="w-full rounded-2xl bg-[#2C3E50] dark:bg-slate-900 py-4 text-sm font-bold text-white transition-all hover:bg-slate-800 dark:hover:bg-slate-800 shadow-md active:scale-95 border-b-2 border-transparent dark:border-slate-700/50"
      >
        Tentar Consulta Novamente
      </button>
      
      <button 
        type="button" 
        @click="$emit('change-step', 'cadastro')" 
        class="w-full rounded-2xl border-2 border-[#2C3E50] dark:border-slate-700 py-4 text-sm font-bold text-[#2C3E50] dark:text-slate-300 transition-all hover:bg-[#2C3E50] dark:hover:bg-slate-800 hover:text-white dark:hover:text-white active:scale-95"
      >
        Ir para Novo Cadastro
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  message: String
})
defineEmits(['change-step'])
</script>