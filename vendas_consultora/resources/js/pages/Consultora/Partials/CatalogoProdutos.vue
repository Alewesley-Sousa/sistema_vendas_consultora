<template>
  <div v-if="view === 'detalhes' && !loading" class="animate-fadeIn">
    
    <!-- BARRA DE VOLTAR E STATUS -->
    <div class="flex items-center justify-between mb-8 px-2">
      <button 
        @click="$emit('voltar')" 
        class="group flex items-center gap-2.5 text-[#2C3E50] dark:text-slate-300 font-black text-xs uppercase tracking-widest transition-colors hover:text-[#E67E73] dark:hover:text-[#E67E73]"
      >
        <div class="p-2 bg-gray-100 dark:bg-slate-900 rounded-xl group-hover:bg-[#E67E73]/10 transition-colors border border-transparent dark:border-slate-800/40">
          <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        Voltar para Coleções
      </button>
      
      <span class="text-[11px] font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest bg-gray-50 dark:bg-slate-900 px-4 py-2 rounded-xl border border-transparent dark:border-slate-800/40">
        {{ paginatedProdutos.length }} Itens Disponíveis
      </span>
    </div>
    
    <!-- GRID DE PRODUTOS -->
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
      <div 
        v-for="prod in paginatedProdutos" 
        :key="prod.id" 
        :class="prod.estoque === 0 ? 'opacity-60' : 'hover:shadow-[0_15px_40px_rgba(44,62,80,0.08)] dark:hover:shadow-[0_15px_40px_rgba(0,0,0,0.3)] hover:-translate-y-1'"
        class="bg-white dark:bg-slate-900 p-4 md:p-5 rounded-[2rem] border border-gray-100 dark:border-slate-800/60 flex flex-col justify-between transition-all duration-300 group relative"
      >
        
        <!-- BADGES DE ESTOQUE -->
        <div class="absolute top-6 right-6 z-10">
          <span 
            v-if="prod.estoque === 0" 
            class="bg-gray-900 dark:bg-slate-950 text-white text-[8px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg"
          >
            Esgotado
          </span>
          <span 
            v-else-if="prod.estoque <= 3" 
            class="bg-amber-500 text-white text-[8px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg animate-pulse"
          >
            Apenas {{ prod.estoque }} restam!
          </span>
          <span 
            v-else 
            class="bg-gray-100 dark:bg-slate-800 text-[#2C3E50] dark:text-slate-300 text-[8px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity"
          >
            Estoque: {{ prod.estoque }}
          </span>
        </div>

        <div>
          <!-- CONTAINER DA IMAGEM -->
          <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 dark:from-slate-950 dark:to-slate-900 rounded-2xl mb-4 overflow-hidden relative flex items-center justify-center text-gray-300 dark:text-slate-700 group-hover:text-[#E67E73]/40 transition-colors">
            <img 
              v-if="prod.img" 
              :src="prod.img" 
              class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
              :alt="prod.nome"
            >
            <svg v-else class="w-10 h-10 stroke-[1.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>

          <!-- DETALHES TEXTUAIS -->
          <div class="space-y-1">
            <h4 class="font-bold text-[#2C3E50] dark:text-slate-200 text-sm leading-tight line-clamp-2 h-10 group-hover:text-[#E67E73] dark:group-hover:text-[#E67E73] transition-colors duration-300">
              {{ prod.nome }}
            </h4>
            <p class="text-[10px] uppercase tracking-wider text-gray-400 dark:text-slate-500 font-medium">Cód: #{{ prod.id }}</p>
          </div>
        </div>

        <!-- PREÇO E INTERAÇÕES COM ESTOQUE -->
        <div class="mt-4 pt-3 border-t border-gray-50 dark:border-slate-800/40">
          <div class="flex items-baseline justify-between mb-3">
            <span class="text-[9px] uppercase tracking-wider font-bold text-gray-400 dark:text-slate-500">Preço Un.</span>
            <p class="text-[#2C3E50] dark:text-slate-200 font-black text-base tracking-tight">
              {{ formatarMoeda(prod.preco) }}
            </p>
          </div>

          <div v-if="prod.estoque > 0" class="space-y-2">
            <!-- SELETOR QUANTIDADE -->
            <div class="flex items-center bg-gray-50 dark:bg-slate-950 border border-gray-100 dark:border-slate-800/60 rounded-xl p-1">
              <button 
                @click="alterarQtdLocal(prod.id, -1, prod.estoque)"
                class="w-8 h-8 flex items-center justify-center bg-white dark:bg-slate-900 hover:bg-gray-100 dark:hover:bg-slate-800 text-[#2C3E50] dark:text-slate-200 active:scale-90 rounded-lg transition-all font-black text-sm border border-transparent dark:border-slate-800/40"
              >
                —
              </button>
              
              <input 
                type="number" 
                v-model.number="quantidadesLocais[prod.id]"
                @blur="validarInput(prod.id, prod.estoque)"
                min="1" 
                :max="obterEstoqueDisponivel(prod.id, prod.estoque)"
                class="w-full bg-transparent border-0 text-center text-xs font-black text-[#2C3E50] dark:text-slate-200 focus:ring-0 p-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
              >

              <button 
                @click="alterarQtdLocal(prod.id, 1, prod.estoque)"
                class="w-8 h-8 flex items-center justify-center bg-white dark:bg-slate-900 hover:bg-gray-100 dark:hover:bg-slate-800 text-[#2C3E50] dark:text-slate-200 active:scale-90 rounded-lg transition-all font-black text-sm border border-transparent dark:border-slate-800/40"
              >
                +
              </button>
            </div>

            <!-- BOTÃO REATIVO ADICIONAR -->
            <button 
              @click="dispararAdicionar(prod)"
              :disabled="obterEstoqueDisponivel(prod.id, prod.estoque) <= 0"
              :class="obterEstoqueDisponivel(prod.id, prod.estoque) <= 0 ? 'bg-gray-300 dark:bg-slate-800 text-gray-400 dark:text-slate-600 cursor-not-allowed shadow-none' : 'bg-[#2C3E50] dark:bg-slate-950 text-white hover:bg-[#E67E73] dark:hover:bg-[#E67E73]'"
              class="w-full py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-colors duration-200 shadow-md shadow-gray-100 dark:shadow-none"
            >
              <span v-if="obterEstoqueDisponivel(prod.id, prod.estoque) <= 0">No Carrinho (Limite)</span>
              <span v-else>Adicionar {{ quantidadesLocais[prod.id] || 1 }} Item(ns)</span>
            </button>
          </div>

          <!-- ESGOTADO/INDISPONÍVEL -->
          <button 
            v-else
            disabled
            class="w-full py-3 bg-gray-100 dark:bg-slate-800 text-gray-400 dark:text-slate-600 cursor-not-allowed rounded-xl text-[10px] font-black uppercase tracking-widest"
          >
            Indisponível
          </button>
        </div>

      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, watch } from 'vue'

const props = defineProps({
  view: String,
  loading: Boolean,
  paginatedProdutos: Array,
  carrinho: {
    type: Array,
    default: () => []
  }
})

const emit = defineEmits(['voltar', 'adicionar-produto'])

const quantidadesLocais = reactive({})

watch(() => props.paginatedProdutos, (novos) => {
  if (!novos) return
  novos.forEach(p => {
    if (quantidadesLocais[p.id] === undefined) {
      quantidadesLocais[p.id] = 1
    }
  })
}, { immediate: true })

const obterEstoqueDisponivel = (prodId, estoqueTotal) => {
  const itemNoCarrinho = props.carrinho.find(i => i.id === prodId)
  const totalNoCarrinho = itemNoCarrinho ? itemNoCarrinho.qtd : 0
  return Math.max(0, estoqueTotal - totalNoCarrinho)
}

const alterarQtdLocal = (prodId, delta, estoqueTotal) => {
  const atual = quantidadesLocais[prodId] || 1
  const novaQtd = atual + delta
  const limiteMax = obterEstoqueDisponivel(prodId, estoqueTotal)

  if (novaQtd >= 1 && novaQtd <= limiteMax) {
    quantidadesLocais[prodId] = novaQtd
  }
}

const validarInput = (prodId, estoqueTotal) => {
  const valor = quantidadesLocais[prodId]
  const limiteMax = obterEstoqueDisponivel(prodId, estoqueTotal)

  if (!valor || valor < 1) {
    quantidadesLocais[prodId] = 1
  } else if (valor > limiteMax) {
    quantidadesLocais[prodId] = limiteMax || 1
  }
}

const dispararAdicionar = (prod) => {
  const limiteMax = obterEstoqueDisponivel(prod.id, prod.estoque)
  if (limiteMax <= 0) return

  validarInput(prod.id, prod.estoque)
  const qtdAAdicionar = quantidadesLocais[prod.id] || 1
  
  emit('adicionar-produto', { produto: prod, quantidade: qtdAAdicionar })
  
  quantidadesLocais[prod.id] = 1
}

const formatarMoeda = (valor) => {
  return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor || 0)
}
</script>

<style scoped>
.animate-fadeIn {
  animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(12px); }
  to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 350px) {
  .grid-cols-2 {
    grid-template-columns: repeat(1, minmax(0, 1fr));
  }
}
</style>