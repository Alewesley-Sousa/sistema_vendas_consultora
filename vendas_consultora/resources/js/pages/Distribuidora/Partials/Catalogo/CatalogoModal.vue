<template>
  <Teleport to="body">
    <Transition
      enter-active-class="ease-out duration-300"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="ease-in duration-200"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="modelValue"
        class="fixed inset-0 z-[9999] overflow-y-auto"
      >
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm" @click="close"></div>

        <div class="flex min-h-screen items-center justify-center px-4 py-8">
          <Transition
            enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0 scale-95 translate-y-2"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
          >
            <div
              v-if="modelValue"
              class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-200 dark:border-slate-800 shadow-2xl p-8 space-y-6"
            >
              <div>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">
                  Painel Global
                </span>

                <h3 class="text-xl font-bold text-slate-900 dark:text-white tracking-tight">
                  Criar Nova Campanha
                </h3>

                <p class="text-xs text-slate-400 mt-0.5">
                  Defina os parâmetros do ciclo macro da vitrine digital.
                </p>
              </div>

              <div class="space-y-4">
                <div>
                  <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">
                    Nome da Campanha / Catálogo
                  </label>

                  <input
                    v-model="localForm.nome"
                    type="text"
                    placeholder="Ex: Ciclo 03/2026 - Especial Dia das Mães"
                    class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-slate-400"
                  />
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">
                      Tipo de Catálogo
                    </label>

                    <select
                      v-model="localForm.tipo"
                      class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2.5 text-xs text-slate-700 dark:text-slate-200 focus:outline-none"
                    >
                      <option>Venda Direta Tradicional</option>
                      <option>Resgate de Pontos</option>
                      <option>Misto / Promocional</option>
                    </select>
                  </div>

                  <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">
                      Status Inicial
                    </label>

                    <select
                      v-model="localForm.status"
                      class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2.5 text-xs text-slate-700 dark:text-slate-200 focus:outline-none"
                    >
                      <option>Ativo (Publicado)</option>
                      <option>Inativo (Rascunho)</option>
                    </select>
                  </div>
                </div>

                <div>
                  <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">
                    Descrição Comercial
                  </label>

                  <textarea
                    v-model="localForm.descricao"
                    rows="3"
                    placeholder="Insira os detalhes da campanha..."
                    class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl p-4 text-xs text-slate-800 dark:text-white focus:outline-none"
                  />
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">
                      Data de Publicação
                    </label>

                    <input
                      v-model="localForm.publicacao"
                      type="datetime-local"
                      class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2.5 text-xs text-slate-700 dark:text-slate-200 focus:outline-none"
                    />
                  </div>

                  <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wide block mb-1">
                      Data de Encerramento
                    </label>

                    <input
                      v-model="localForm.encerramento"
                      type="datetime-local"
                      class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2.5 text-xs text-slate-700 dark:text-slate-200 focus:outline-none"
                    />
                  </div>
                </div>
              </div>

              <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                <button
                  @click="close"
                  class="px-5 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-semibold text-xs rounded-xl transition"
                >
                  Cancelar
                </button>

                <button
                  @click="save"
                  :disabled="!localForm.nome"
                  :class="!localForm.nome && 'opacity-50 cursor-not-allowed'"
                  class="px-5 py-2.5 bg-slate-900 dark:bg-white dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-slate-200 text-white font-semibold text-xs rounded-xl transition shadow-sm"
                >
                  Gravar Campanha
                </button>
              </div>
            </div>
          </Transition>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { reactive, watch } from 'vue'

const props = defineProps({
  modelValue: Boolean,
  form: Object
})

const emit = defineEmits([
  'update:modelValue',
  'save'
])

const localForm = reactive({
  nome: '',
  tipo: 'Venda Direta Tradicional',
  status: 'Ativo (Publicado)',
  descricao: '',
  publicacao: '',
  encerramento: ''
})

watch(
  () => props.modelValue,
  (opened) => {
    if (opened) {
      Object.assign(localForm, structuredClone(props.form))
    }
  }
)

function close() {
  emit('update:modelValue', false)
}

function save() {
  emit('save', { ...localForm })
}
</script>