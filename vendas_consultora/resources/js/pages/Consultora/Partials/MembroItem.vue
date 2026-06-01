<script setup>
import { computed } from 'vue'

const props = defineProps({
  membro: {
    type: Object,
    required: true
  },
  nivel: {
    type: Number,
    required: true
  }
})

// AJUSTADO: Suporte a bordas e sombras do modo escuro dinâmico
const bordaCard = computed(() => {
  return props.nivel === 0 
    ? 'border-[#FFD700] border-2 shadow-2xl shadow-[#FFD700]/10' 
    : 'border-slate-200 dark:border-slate-800/80 shadow-xl dark:shadow-[0_10px_30px_rgba(0,0,0,0.3)]'
})

// AJUSTADO: Fundo dinâmico adaptado para dark mode
const bgHeader = computed(() => {
  return props.nivel === 0 ? 'bg-slate-50/50 dark:bg-slate-950/40' : 'bg-white dark:bg-slate-900'
})

// AJUSTADO: Avatar com cores que contrastam bem no dark mode
const urlAvatar = computed(() => {
  return `https://ui-avatars.com/api/?name=${encodeURIComponent(props.membro.nome)}&background=2C3E50&color=ffffff&bold=true`
})
</script>

<template>
  <li>
    <div class="inline-block">
      <div 
        :class="bordaCard"
        class="bg-white dark:bg-slate-900 rounded-[1.5rem] min-w-[210px] overflow-hidden transition-all duration-500 group"
      >
        <div :class="bgHeader" class="p-6 flex flex-col items-center">
          <div class="relative mb-4">
            <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-800 p-1 ring-2 ring-slate-100 dark:ring-slate-800/60 overflow-hidden">
              <img :src="urlAvatar" class="w-full h-full rounded-xl object-cover" alt="Avatar">
            </div>
            <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white dark:border-slate-900 rounded-full"></div>
          </div>

          <h4 class="text-sm font-black text-slate-800 dark:text-slate-200 uppercase tracking-tight">
            {{ membro.nome }} {{ nivel === 0 ? '(VOCÊ)' : '' }}
          </h4>
          <p class="text-[10px] text-slate-400 dark:text-slate-500 font-mono">ID: #{{ membro.id }}</p>

          <span 
            v-if="nivel === 1" 
            class="text-[9px] font-bold bg-[#FFD700]/10 dark:bg-[#FFD700]/5 text-[#CCAA00] px-2 py-0.5 rounded-md mt-2 inline-block uppercase"
          >
            Nível 1 - Direta
          </span>
          <span 
            v-else-if="nivel === 2" 
            class="text-[9px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 px-2 py-0.5 rounded-md mt-2 inline-block uppercase"
          >
            Nível 2 - Indireta
          </span>
        </div>
      </div>
    </div>

    <ul v-if="nivel < 2 && membro.subordinados && membro.subordinados.length > 0">
      <MembroItem 
        v-for="filho in membro.subordinados" 
        :key="filho.id" 
        :membro="filho" 
        :nivel="nivel + 1" 
      />
    </ul>
  </li>
</template>

<script>
export default {
  name: 'MembroItem'
}
</script>