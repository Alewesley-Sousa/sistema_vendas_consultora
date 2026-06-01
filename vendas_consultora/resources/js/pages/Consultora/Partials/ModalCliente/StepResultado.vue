<template>
  <div class="space-y-6 animate-fade-in text-slate-800 dark:text-slate-200 transition-colors duration-300">
    
    <div class="flex items-center gap-3 bg-gradient-to-r from-emerald-500/10 to-teal-500/5 dark:from-emerald-500/5 dark:to-teal-500/5 border border-emerald-500/20 dark:border-emerald-500/30 p-4 rounded-3xl text-emerald-900 dark:text-emerald-400 shadow-sm animate-pulse-once">
      <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-lg shadow-emerald-600/20">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
        </svg>
      </div>
      <div>
        <h5 class="text-xs font-black uppercase tracking-[0.15em] text-emerald-700 dark:text-emerald-400">Dossiê Carregado</h5>
        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">As informações foram sincronizadas com o banco Glow Database.</p>
      </div>
    </div>

    <div class="relative overflow-hidden bg-gradient-to-br from-[#2C3E50] to-[#1A252F] p-6 rounded-[2rem] border border-white/10 dark:border-slate-800 shadow-xl shadow-slate-900/10 text-white">
      <div class="absolute -right-6 -bottom-6 h-24 w-24 rounded-full bg-[#FFD700]/10 blur-xl"></div>
      <div class="absolute right-4 top-4 text-xs font-black uppercase tracking-[0.2em] text-[#FFD700]/40">
        Premium Profile
      </div>

      <div class="relative z-10 flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
        <div class="relative flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-2xl bg-white/10 font-bold text-2xl text-[#FFD700] border border-[#FFD700]/30 shadow-inner">
          {{ data.nome?.charAt(0).toUpperCase() }}
          <span class="absolute -bottom-1 -right-1 flex h-4 w-4 rounded-full bg-emerald-500 border-2 border-[#2C3E50] dark:border-[#1A252F]" title="Cliente Ativo"></span>
        </div>
        
        <div>
          <h4 class="text-xl font-extrabold tracking-wide text-white leading-tight">{{ data.nome }}</h4>
          <div class="mt-1.5 flex flex-wrap items-center justify-center sm:justify-start gap-2">
            <span class="inline-flex items-center rounded-lg bg-white/5 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white/70 border border-white/10">
              ID: #{{ data.id }}
            </span>
            <span class="inline-flex items-center rounded-lg bg-[#FFD700]/10 px-2.5 py-0.5 text-[10px] font-bold uppercase tracking-wider text-[#FFD700] border border-[#FFD700]/20">
              ✨ Comprador Direto
            </span>
          </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      
      <div class="group flex items-center gap-3.5 bg-slate-50 dark:bg-slate-900/50 hover:bg-slate-100/70 dark:hover:bg-slate-900 border border-slate-100 dark:border-slate-800/60 p-4 rounded-2xl transition-all">
        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-white dark:bg-slate-950 text-[#2C3E50] border border-slate-200/60 dark:border-slate-800 shadow-sm group-hover:border-[#2C3E50]/20 dark:group-hover:border-slate-700 transition-colors">
          <span class="text-sm font-bold">💳</span>
        </div>
        <div>
          <span class="block text-[9px] uppercase font-bold tracking-widest text-slate-400 dark:text-slate-500">Documento CPF</span>
          <span class="text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">{{ maskCPF(data.cpf) }}</span>
        </div>
      </div>

      <div class="group flex items-center gap-3.5 bg-slate-50 dark:bg-slate-900/50 hover:bg-slate-100/70 dark:hover:bg-slate-900 border border-slate-100 dark:border-slate-800/60 p-4 rounded-2xl transition-all">
        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-white dark:bg-slate-950 text-[#2C3E50] border border-slate-200/60 dark:border-slate-800 shadow-sm group-hover:border-[#2C3E50]/20 dark:group-hover:border-slate-700 transition-colors">
          <span class="text-sm font-bold">📱</span>
        </div>
        <div>
          <span class="block text-[9px] uppercase font-bold tracking-widest text-slate-400 dark:text-slate-500">Telefone Celular</span>
          <span class="text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">{{ maskTelefone(data.telefone) }}</span>
        </div>
      </div>

      <div class="group flex items-center gap-3.5 bg-slate-50 dark:bg-slate-900/50 hover:bg-slate-100/70 dark:hover:bg-slate-900 border border-slate-100 dark:border-slate-800/60 p-4 rounded-2xl sm:col-span-2 transition-all">
        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-white dark:bg-slate-950 text-[#2C3E50] border border-slate-200/60 dark:border-slate-800 shadow-sm group-hover:border-[#2C3E50]/20 dark:group-hover:border-slate-700 transition-colors">
          <span class="text-sm font-bold">✉️</span>
        </div>
        <div class="overflow-hidden">
          <span class="block text-[9px] uppercase font-bold tracking-widest text-slate-400 dark:text-slate-500">Endereço de E-mail</span>
          <span class="text-sm font-bold text-slate-700 dark:text-slate-300 break-all">{{ data.email }}</span>
        </div>
      </div>

      <div v-if="data.cep" class="group flex items-center gap-3.5 bg-slate-50 dark:bg-slate-900/50 hover:bg-slate-100/70 dark:hover:bg-slate-900 border border-slate-100 dark:border-slate-800/60 p-4 rounded-2xl sm:col-span-2 transition-all">
        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-white dark:bg-slate-950 text-[#2C3E50] border border-slate-200/60 dark:border-slate-800 shadow-sm group-hover:border-[#2C3E50]/20 dark:group-hover:border-slate-700 transition-colors">
          <span class="text-sm font-bold">📍</span>
        </div>
        <div>
          <span class="block text-[9px] uppercase font-bold tracking-widest text-slate-400 dark:text-slate-500">Localidade CEP</span>
          <span class="text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">{{ data.cep }}</span>
        </div>
      </div>

    </div>

    <button 
      type="button" 
      @click="$emit('back-menu')" 
      class="w-full py-4 bg-slate-100 dark:bg-slate-900/40 hover:bg-[#2C3E50]/5 dark:hover:bg-slate-800/60 hover:text-[#2C3E50] dark:hover:text-[#FFD700] text-slate-500 dark:text-slate-400 rounded-2xl text-xs font-black uppercase tracking-[0.2em] border border-transparent dark:border-slate-800/80 transition-all active:scale-[0.99]"
    >
      Voltar ao Menu Principal
    </button>
  </div>
</template>

<script setup>
defineProps({
  data: Object
})
defineEmits(['back-menu'])

const maskCPF = (value) => {
  if (!value) return 'N/A'
  return value.replace(/\D/g, '').replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4')
}

const maskTelefone = (value) => {
  if (!value) return 'N/A'
  let clean = value.replace(/\D/g, '')
  if (clean.length === 11) return clean.replace(/^(\d{2})(\d{5})(\d{4})/, '($1) $2-$3')
  return clean.replace(/^(\d{2})(\d{4})(\d{4})/, '($1) $2-$3')
}
</script>

<style scoped>
@keyframes pulseOnce {
  0% { transform: scale(1); }
  50% { transform: scale(1.01); }
  100% { transform: scale(1); }
}
.animate-pulse-once {
  animation: pulseOnce 0.35s ease-out;
}
</style>