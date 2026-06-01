<template>
  <div>
    <!-- AJUSTADO: bottom-24 no mobile para subir e não bater no nav bottom; md:bottom-10 no desktop -->
    <button 
      v-if="!cartOpen"
      @click="$emit('update:cartOpen', true)" 
      class="fixed bottom-24 right-6 md:bottom-10 md:right-10 bg-[#2C3E50] dark:bg-slate-950 hover:bg-[#E67E73] dark:hover:bg-[#E67E73] text-white p-4 md:p-5 rounded-full shadow-[0_8px_30px_rgba(44,62,80,0.35)] dark:shadow-[0_8px_30px_rgba(0,0,0,0.5)] z-[60] transition-all duration-300 hover:scale-105 active:scale-95"
      title="Ver sacola de compras"
    >
      <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <span 
        v-if="carrinho.length > 0"
        class="absolute -top-1 -right-1 bg-[#E67E73] text-white text-[10px] font-black w-6 h-6 flex items-center justify-center rounded-full border-2 border-white dark:border-slate-950 animate-fadeIn"
      >
        {{ carrinho.reduce((s, i) => s + i.qtd, 0) }}
      </span>
    </button>

    <!-- BACKDROP MULTI-TOM -->
    <div 
      v-if="cartOpen" 
      @click="$emit('update:cartOpen', false)" 
      class="fixed inset-0 bg-[#2C3E50]/50 dark:bg-black/60 backdrop-blur-sm z-[70] transition-opacity duration-300"
    ></div>
    
    <transition
      enter-active-class="transition ease-out duration-300 transform"
      enter-from-class="translate-x-full"
      enter-to-class="translate-x-0"
      leave-active-class="transition ease-in duration-200 transform"
      leave-from-class="translate-x-0"
      leave-to-class="translate-x-full"
    >
      <!-- CONTAINER DA GAVETA LATERAL -->
      <div v-if="cartOpen" class="fixed top-0 right-0 h-full w-full max-w-md bg-white dark:bg-slate-900 border-l border-transparent dark:border-slate-800 shadow-2xl z-[80] p-5 md:p-6 flex flex-col justify-between">
        
        <!-- HEADER DO CARRINHO -->
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-slate-800/60 mb-4">
          <div class="flex items-center gap-2">
            <h2 class="text-xl font-serif font-black text-[#2C3E50] dark:text-slate-100">Sua Sacola</h2>
            <span class="text-xs bg-gray-100 dark:bg-slate-800 text-[#2C3E50] dark:text-slate-300 font-black px-2.5 py-1 rounded-full">
              {{ carrinho.length }} {{ carrinho.length === 1 ? 'item' : 'itens' }}
            </span>
          </div>
          <button 
            @click="$emit('update:cartOpen', false)" 
            class="p-2 text-gray-400 hover:text-[#2C3E50] dark:hover:text-white hover:bg-gray-50 dark:hover:bg-slate-800 rounded-xl transition-all"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
        </div>
        
        <!-- ÁREA DOS PRODUTOS -->
        <div class="flex-1 overflow-y-auto pr-1 space-y-3">
          
          <!-- ESTADO VAZIO -->
          <div v-if="carrinho.length === 0" class="h-full flex flex-col items-center justify-center text-center p-6 space-y-4">
            <div class="w-16 h-16 bg-gray-50 dark:bg-slate-950 text-gray-300 dark:text-slate-700 rounded-full flex items-center justify-center">
              <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <div>
              <h4 class="text-sm font-black text-[#2C3E50] dark:text-slate-200 uppercase tracking-wider">Sua sacola está vazia</h4>
              <p class="text-xs text-gray-400 dark:text-slate-500 mt-1 max-w-[240px]">Explore nossos catálogos exclusivos e adicione produtos para começar.</p>
            </div>
            <button 
              @click="$emit('update:cartOpen', false)" 
              class="px-5 py-2.5 bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 text-[#2C3E50] dark:text-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest transition-colors"
            >
              Continuar Navegando
            </button>
          </div>

          <!-- FILAS DE ITEMS -->
          <div 
            v-else
            v-for="item in carrinho" 
            :key="item.id" 
            class="flex gap-3 bg-gray-50 dark:bg-slate-950 p-3.5 rounded-2xl border border-gray-100 dark:border-slate-800/40 relative group transition-all hover:bg-gray-50/80 dark:hover:bg-slate-950/60"
          >
            <div class="w-16 h-16 bg-white dark:bg-slate-900 rounded-xl border border-gray-100 dark:border-slate-800/60 flex items-center justify-center text-gray-300 dark:text-slate-700 flex-shrink-0 overflow-hidden">
              <img v-if="item.img" :src="item.img" class="w-full h-full object-cover" :alt="item.nome">
              <svg v-else class="w-6 h-6 stroke-[1.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>

            <div class="flex flex-col justify-between flex-1 min-w-0">
              <div>
                <div class="flex justify-between items-start gap-2">
                  <h4 class="font-bold text-xs text-[#2C3E50] dark:text-slate-200 line-clamp-2 pr-4 leading-tight">
                    {{ item.nome }}
                  </h4>
                  <button 
                    @click="$emit('alterar-qtd', item.id, -item.qtd)" 
                    class="absolute top-3 right-3 text-gray-300 dark:text-slate-600 hover:text-red-500 dark:hover:text-rose-400 transition-colors"
                    title="Remover item"
                  >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-11v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                  </button>
                </div>
                <p class="text-[10px] text-gray-400 dark:text-slate-500 mt-0.5">Un: {{ formatarMoeda(item.preco) }}</p>
              </div>

              <div class="flex items-center justify-between mt-2">
                <!-- SELETOR QTD -->
                <div class="flex items-center border border-gray-200/60 dark:border-slate-800 rounded-xl bg-white dark:bg-slate-900 overflow-hidden p-0.5 shadow-sm">
                  <button 
                    @click="$emit('alterar-qtd', item.id, -1)" 
                    class="w-7 h-7 flex items-center justify-center bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 text-[#2C3E50] dark:text-slate-200 font-black text-xs active:scale-90 transition-all rounded-lg"
                  >
                    —
                  </button>
                  <span class="px-3 text-xs font-black text-[#2C3E50] dark:text-slate-200 min-w-[24px] text-center">{{ item.qtd }}</span>
                  <button 
                    @click="$emit('alterar-qtd', item.id, 1)" 
                    class="w-7 h-7 flex items-center justify-center bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 text-[#2C3E50] dark:text-slate-200 font-black text-xs active:scale-90 transition-all rounded-lg"
                  >
                    +
                  </button>
                </div>
                <span class="text-xs font-black text-[#2C3E50] dark:text-slate-200">
                  {{ formatarMoeda(item.preco * item.qtd) }}
                </span>
              </div>
            </div>

          </div>
        </div>

        <!-- RODAPÉ FIXO -->
        <div v-if="carrinho.length > 0" class="border-t border-gray-100 dark:border-slate-800/60 pt-4 mt-4 bg-white dark:bg-slate-900">
          <div class="space-y-1.5 mb-4">
            <div class="flex justify-between text-xs text-gray-400 dark:text-slate-500 font-bold">
              <span>Subtotal dos itens</span>
              <span>{{ formatarMoeda(totalCarrinho) }}</span>
            </div>
            <div class="flex justify-between items-baseline">
              <span class="font-black text-sm text-[#2C3E50] dark:text-slate-300 uppercase tracking-wider">Total Estimado</span>
              <span class="text-2xl font-black text-[#E67E73] tracking-tight">{{ formatarMoeda(totalCarrinho) }}</span>
            </div>
          </div>
          
          <button 
            @click="$emit('abrir-checkout')" 
            class="w-full bg-[#E67E73] text-white py-4 rounded-2xl font-black uppercase text-xs tracking-widest shadow-lg shadow-[#E67E73]/10 dark:shadow-none hover:bg-[#2C3E50] dark:hover:bg-slate-950 transition-colors duration-300"
          >
            Proceder para o Checkout
          </button>
        </div>

      </div>
    </transition>
  </div>
</template>

<script setup>
defineProps({
  carrinho: Array,
  cartOpen: Boolean,
  totalCarrinho: Number
})
defineEmits(['update:cartOpen', 'alterar-qtd', 'abrir-checkout'])

const formatarMoeda = (valor) => {
  return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor || 0)
}
</script>

<style scoped>
.animate-fadeIn {
  animation: fadeIn 0.3s ease-out forwards;
}
@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.9); }
  to { opacity: 1; transform: scale(1); }
}
</style>