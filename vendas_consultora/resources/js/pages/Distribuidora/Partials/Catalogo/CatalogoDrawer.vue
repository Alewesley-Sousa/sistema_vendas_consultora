<template>
  <Transition
    enter-active-class="transition ease-in-out duration-500"
    enter-from-class="translate-x-full"
    enter-to-class="translate-x-0"
    leave-active-class="transition ease-in-out duration-400"
    leave-from-class="translate-x-0"
    leave-to-class="translate-x-full"
  >
    <div
      v-if="modelValue"
      class="fixed inset-0 overflow-hidden z-50 shadow-2xl"
    >
      <div class="absolute inset-0 overflow-hidden">
        <div
          @click="close"
          class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
        />

        <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
          <div
            class="pointer-events-auto w-screen max-w-xl bg-white border-l border-slate-200 p-8 flex flex-col justify-between shadow-[0_0_60px_-15px_rgba(0,0,0,0.15)] md:rounded-l-[2.5rem]"
          >
            <div class="flex-1 overflow-y-auto pr-2">
              <div class="flex items-start justify-between pb-6 border-b border-slate-100">
                <div>
                  <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">
                    Painel Relacional
                  </span>

                  <h2 class="text-xl font-bold text-slate-900 tracking-tight">
                    {{ catalogo.nome }}
                  </h2>

                  <p class="text-xs text-slate-400 mt-0.5">
                    Gerenciamento dinâmico de vitrines
                  </p>
                </div>

                <button
                  @click="close"
                  class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-xl"
                >
                  ✕
                </button>
              </div>

              <div
                class="my-6 p-4 bg-slate-50 border border-slate-200/60 rounded-2xl flex items-end justify-between gap-4"
              >
                <div class="flex-1 relative">
                  <span
                    class="text-[9px] font-bold text-slate-500 uppercase tracking-tight block mb-1"
                  >
                    Adicionar Produto ao Ciclo
                  </span>

                  <input
                    v-model="buscaProduto"
                    @focus="selectOpen = true"
                    type="text"
                    placeholder="Pesquise um cosmético..."
                    class="w-full bg-white border border-slate-200 rounded-xl pl-3 pr-10 py-2 text-xs font-medium focus:outline-none focus:border-slate-400 text-slate-700 shadow-sm"
                  />

                  <div
                    v-if="selectOpen"
                    class="absolute z-50 mt-1 w-full bg-white border border-slate-200 rounded-xl shadow-lg max-h-48 overflow-y-auto"
                  >
                    <button
                      v-for="prod in produtosFiltrados"
                      :key="prod.id"
                      type="button"
                      @click="selecionarProduto(prod)"
                      class="w-full text-left px-3 py-2 text-xs hover:bg-slate-50 font-medium text-slate-700 border-b border-slate-100 flex items-center justify-between"
                    >
                      <span>{{ prod.nome }}</span>
                      <span class="text-[9px] font-mono text-slate-400">
                        ID: {{ prod.id }}
                      </span>
                    </button>

                    <div
                      v-if="!produtosFiltrados.length"
                      class="p-3 text-center text-xs text-slate-400"
                    >
                      Nenhum cosmético encontrado...
                    </div>
                  </div>
                </div>

                <button
                  @click="emitAdd"
                  class="h-9 px-4 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition-all"
                >
                  Inserir
                </button>
              </div>

              <div class="space-y-4">
                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">
                  Produtos já Vinculados
                </h4>

                <div
                  v-for="item in catalogo.itens"
                  :key="item.id"
                  class="p-4 border border-slate-200 rounded-2xl bg-white space-y-3"
                >
                  <div class="flex items-center justify-between">
                    <p class="text-xs font-bold text-slate-900">
                      {{ item.produto }}
                    </p>

                    <button
                      @click="$emit('remove-item', item.id)"
                      class="text-slate-400 hover:text-red-500"
                    >
                      ✕
                    </button>
                  </div>

                  <div class="grid grid-cols-2 gap-3">
                    <div>
                      <label
                        class="text-[9px] font-bold text-slate-400 uppercase block mb-1"
                      >
                        Pontos
                      </label>

                      <input
                        v-model.number="item.pontos"
                        type="number"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-xs font-bold"
                      />
                    </div>

                    <div>
                      <label
                        class="text-[9px] font-bold text-slate-400 uppercase block mb-1"
                      >
                        Estoque
                      </label>

                      <input
                        v-model.number="item.estoque"
                        type="number"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5 text-xs font-bold"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center gap-3">
              <button
                @click="close"
                class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl"
              >
                Voltar
              </button>

              <button
                @click="$emit('save')"
                class="flex-1 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl"
              >
                Salvar Alterações
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  modelValue: Boolean,
  catalogo: {
    type: Object,
    required: true
  },
  produtos: {
    type: Array,
    default: () => []
  }
})

const emit = defineEmits([
  'update:modelValue',
  'add-item',
  'remove-item',
  'save'
])

const buscaProduto = ref('')
const selectOpen = ref(false)
const produtoSelecionado = ref(null)

const produtosFiltrados = computed(() => {
  if (!buscaProduto.value) return props.produtos

  return props.produtos.filter(p =>
    p.nome
      .toLowerCase()
      .includes(buscaProduto.value.toLowerCase())
  )
})

function selecionarProduto(produto) {
  produtoSelecionado.value = produto.id
  buscaProduto.value = produto.nome
  selectOpen.value = false
}

function emitAdd() {
  if (!produtoSelecionado.value) return

  emit('add-item', produtoSelecionado.value)

  produtoSelecionado.value = null
  buscaProduto.value = ''
}

function close() {
  emit('update:modelValue', false)
}
</script>