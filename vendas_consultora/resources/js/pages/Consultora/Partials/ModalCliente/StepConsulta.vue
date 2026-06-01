<template>
  <div class="text-center">
    <div class="mx-auto mb-4 h-1 w-20 rounded-full bg-gradient-to-r from-[#2C3E50] to-[#FFD700] dark:from-slate-700 dark:to-[#FFD700]"></div>
    <h3 class="mb-6 text-xl font-bold text-[#2C3E50] dark:text-slate-100 transition-colors">Identificação do Cliente</h3>

    <input
      type="text"
      :value="modelValue"
      @input="onInput"
      @keydown.enter.prevent="submit"
      maxlength="14"
      placeholder="000.000.000-00"
      class="mb-6 w-full rounded-2xl border-2 border-slate-100 bg-slate-50/50 dark:border-slate-800/80 dark:bg-slate-900/50 px-6 py-5 text-center text-2xl font-bold tracking-widest text-[#2C3E50] dark:text-slate-100 outline-none transition-all focus:border-[#2C3E50] dark:focus:border-[#FFD700] focus:bg-white dark:focus:bg-slate-950 focus:shadow-inner"
    />

    <button
      type="button"
      @click="submit"
      :disabled="modelValue.length < 14 || loading"
      class="flex w-full items-center justify-center gap-3 rounded-2xl bg-[#2C3E50] dark:bg-slate-900 py-4 font-bold uppercase tracking-[0.2em] text-[#FFD700] shadow-lg dark:shadow-black/20 border-b-2 border-transparent dark:border-[#FFD700]/20 transition-all hover:-translate-y-1 hover:shadow-[#2C3E50]/20 dark:hover:shadow-black/40 disabled:cursor-not-allowed disabled:opacity-30 text-sm"
    >
      <span v-if="!loading">Confirmar Consulta</span>
      <svg v-else class="h-5 w-5 animate-spin text-[#FFD700]" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
    </button>
  </div>
</template>

<script setup>
const props = defineProps({
  modelValue: String,
  loading: Boolean
})
const emit = defineEmits(['update:modelValue', 'consultar'])

const onInput = (e) => {
  emit('update:modelValue', e.target.value)
}

const submit = () => {
  if (props.modelValue.length === 14 && !props.loading) {
    emit('consultar')
  }
}
</script>