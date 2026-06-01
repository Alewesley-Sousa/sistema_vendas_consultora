<template>
  <div class="space-y-4">
    <div class="relative">
      <label class="mb-1 ml-2 block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-slate-500">Nome Completo</label>
      <input
        type="text"
        v-model="form.nome"
        class="w-full rounded-2xl border-2 px-5 py-3 font-semibold text-[#2C3E50] dark:text-slate-100 outline-none transition-all focus:bg-white dark:focus:bg-slate-950 focus:border-[#2C3E50] dark:focus:border-[#FFD700]"
        :class="errors.nome 
          ? 'border-red-300 bg-red-50/40 dark:border-red-900/50 dark:bg-red-950/20' 
          : 'border-slate-100 bg-slate-50/50 dark:border-slate-800/80 dark:bg-slate-900/50'"
      />
      <p v-if="errors.nome" class="mt-1 ml-2 text-[10px] font-bold text-red-500 dark:text-red-400">{{ errors.nome[0] }}</p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
      <div>
        <label class="mb-1 ml-2 block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-slate-500">CPF</label>
        <input
          type="text"
          v-model="form.cpf"
          maxlength="14"
          placeholder="000.000.000-00"
          class="w-full rounded-2xl border-2 px-5 py-3 font-semibold text-[#2C3E50] dark:text-slate-100 outline-none transition-all focus:border-[#2C3E50] dark:focus:border-[#FFD700] focus:bg-white dark:focus:bg-slate-950 default-placeholder"
          :class="errors.cpf 
            ? 'border-red-300 bg-red-50/40 dark:border-red-900/50 dark:bg-red-950/20' 
            : 'border-slate-100 bg-slate-50/50 dark:border-slate-800/80 dark:bg-slate-900/50'"
        />
        <p v-if="errors.cpf" class="mt-1 ml-2 text-[10px] font-bold text-red-500 dark:text-red-400">{{ errors.cpf[0] }}</p>
      </div>

      <div>
        <label class="mb-1 ml-2 block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-slate-500">Telefone</label>
        <input
          type="text"
          v-model="form.telefone"
          maxlength="15"
          placeholder="(00) 00000-0000"
          class="w-full rounded-2xl border-2 border-slate-100 bg-slate-50/50 dark:border-slate-800/80 dark:bg-slate-900/50 px-5 py-3 font-semibold text-[#2C3E50] dark:text-slate-100 outline-none transition-all focus:border-[#2C3E50] dark:focus:border-[#FFD700] focus:bg-white dark:focus:bg-slate-950"
        />
      </div>
    </div>

    <div>
      <label class="mb-1 ml-2 block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-slate-500">E-mail</label>
      <input
        type="email"
        v-model="form.email"
        class="w-full rounded-2xl border-2 px-5 py-3 font-semibold text-[#2C3E50] dark:text-slate-100 outline-none transition-all focus:border-[#2C3E50] dark:focus:border-[#FFD700] focus:bg-white dark:focus:bg-slate-950"
        :class="errors.email 
          ? 'border-red-300 bg-red-50/40 dark:border-red-900/50 dark:bg-red-950/20' 
          : 'border-slate-100 bg-slate-50/50 dark:border-slate-800/80 dark:bg-slate-900/50'"
      />
      <p v-if="errors.email" class="mt-1 ml-2 text-[10px] font-bold text-red-500 dark:text-red-400">{{ errors.email[0] }}</p>
    </div>

    <div>
      <label class="mb-1 ml-2 block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 dark:text-slate-500">CEP</label>
      <input
        type="text"
        v-model="form.cep"
        maxlength="9"
        placeholder="00000-000"
        class="w-full rounded-2xl border-2 border-slate-100 bg-slate-50/50 dark:border-slate-800/80 dark:bg-slate-900/50 px-5 py-3 font-semibold text-[#2C3E50] dark:text-slate-100 outline-none transition-all focus:border-[#2C3E50] dark:focus:border-[#FFD700] focus:bg-white dark:focus:bg-slate-950"
      />
    </div>

    <button
      type="button"
      @click="$emit('cadastrar')"
      :disabled="loading"
      class="mt-2 flex w-full items-center justify-center gap-3 rounded-[1.5rem] bg-[#2C3E50] dark:bg-slate-900 py-4 font-bold uppercase tracking-[0.2em] text-[#FFD700] shadow-xl dark:shadow-black/20 border-b-2 border-transparent dark:border-[#FFD700]/30 transition-all hover:-translate-y-1 active:scale-95 disabled:cursor-not-allowed disabled:opacity-40 text-sm"
    >
      <span v-if="!loading">Finalizar Cadastro</span>
      <svg v-else class="h-5 w-5 animate-spin text-[#FFD700]" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
    </button>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  modelValue: Object,
  errors: Object,
  loading: Boolean
})
const emit = defineEmits(['update:modelValue', 'cadastrar'])

const form = computed({
  get: () => props.modelValue,
  set: (val) => emit('update:modelValue', val)
})
</script>