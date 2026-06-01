<template>
  <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 animate-fade-in">
    
    <button 
      type="button" 
      @click="$emit('change-step', 'form')" 
      class="group relative flex flex-col items-center justify-center p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800/80 hover:border-[#2C3E50]/30 dark:hover:border-slate-700 bg-gradient-to-b from-slate-50 to-slate-100/50 dark:from-slate-900 dark:to-slate-950/60 hover:from-white hover:to-slate-50/30 dark:hover:from-slate-900/80 dark:hover:to-slate-900 transition-all text-center space-y-4 shadow-sm hover:shadow-md dark:shadow-black/20 active:scale-[0.98]"
    >
      <div class="absolute inset-0 rounded-[2rem] bg-[#2C3E50]/[0.02] dark:bg-slate-800/[0.1] opacity-0 group-hover:opacity-100 transition-opacity"></div>
      
      <div class="w-16 h-16 bg-white dark:bg-slate-950 group-hover:bg-[#2C3E50] dark:group-hover:bg-[#FFD700] text-[#2C3E50] dark:group-hover:text-slate-950 rounded-2xl flex items-center justify-center text-2xl transition-all duration-300 shadow-sm group-hover:shadow-lg group-hover:shadow-[#2C3E50]/20 dark:group-hover:shadow-[#FFD700]/10 group-hover:-translate-y-1 border border-slate-100 dark:border-slate-800 group-hover:border-transparent">
        🔍
      </div>
      
      <div class="relative z-10 space-y-1">
        <h4 class="font-black text-[#2C3E50] dark:text-slate-200 text-base tracking-wide transition-colors">Consultar Comprador</h4>
        <p class="text-xs text-slate-400 dark:text-slate-500 font-medium max-w-[200px] leading-relaxed group-hover:text-slate-500 dark:group-hover:text-slate-400 transition-colors">
          Varra a base de dados inteligente filtrando pelo CPF.
        </p>
      </div>

      <span class="inline-flex items-center text-[9px] uppercase font-black tracking-widest text-[#2C3E50]/40 dark:text-slate-600 group-hover:text-[#2C3E50] dark:group-hover:text-[#FFD700] transition-colors">
        Acessar Filtros &rarr;
      </span>
    </button>

    <button 
      type="button" 
      @click="$emit('change-step', 'cadastro')" 
      class="group relative flex flex-col items-center justify-center p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800/80 hover:border-[#FFD700]/40 dark:hover:border-amber-500/30 bg-gradient-to-b from-slate-50 to-slate-100/50 dark:from-slate-900 dark:to-slate-950/60 hover:from-white hover:to-amber-50/[0.15] dark:hover:from-slate-900/80 dark:hover:to-amber-950/[0.1] transition-all text-center space-y-4 shadow-sm hover:shadow-md dark:shadow-black/20 active:scale-[0.98]"
    >
      <div class="absolute -right-4 -bottom-4 h-16 w-16 rounded-full bg-[#FFD700]/5 dark:bg-amber-500/5 blur-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
      
      <div class="w-16 h-16 bg-white dark:bg-slate-950 group-hover:bg-gradient-to-br group-hover:from-[#2C3E50] group-hover:to-[#1A252F] dark:group-hover:from-[#FFD700] dark:group-hover:to-amber-400 text-amber-500 dark:group-hover:text-slate-950 rounded-2xl flex items-center justify-center text-2xl transition-all duration-300 shadow-sm group-hover:shadow-lg group-hover:shadow-[#2C3E50]/10 dark:group-hover:shadow-amber-500/10 group-hover:-translate-y-1 border border-slate-100 dark:border-slate-800 group-hover:border-transparent">
        ✨
      </div>
      
      <div class="relative z-10 space-y-1">
        <h4 class="font-black text-[#2C3E50] dark:text-slate-200 text-base tracking-wide transition-colors">Cadastrar Novo</h4>
        <p class="text-xs text-slate-400 dark:text-slate-500 font-medium max-w-[200px] leading-relaxed group-hover:text-slate-500 dark:group-hover:text-slate-400 transition-colors">
          Insira um perfil inédito na sua carteira de consultoria.
        </p>
      </div>

      <span class="inline-flex items-center text-[9px] uppercase font-black tracking-widest text-amber-500/50 dark:text-amber-500/40 group-hover:text-amber-600 dark:group-hover:text-[#FFD700] transition-colors">
        Abrir Ficha &rarr;
      </span>
    </button>

  </div>
</template>

<script setup>
defineEmits(['change-step'])
</script>