<template>
  <div v-if="modelValue" class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] w-full max-w-lg overflow-hidden shadow-2xl border border-gray-100 dark:border-slate-800/60 animate-fadeIn">
      
      <div class="bg-[#2C3E50] dark:bg-slate-950 text-white p-6 relative">
        <h3 class="text-xl font-serif font-black tracking-tight">Finalizar Atendimento</h3>
        <p class="text-[10px] uppercase tracking-wider text-gray-400 dark:text-slate-500 mt-1 font-bold">Checkout e faturamento</p>
        <button @click="$emit('update:modelValue', false)" class="absolute right-6 top-6 text-gray-400 hover:text-white transition-colors">✕</button>
      </div>

      <div class="p-6 space-y-6">
        <div class="space-y-3">
          <label class="text-xs font-black uppercase text-[#2C3E50] dark:text-slate-400 tracking-wider block">CPF do Cliente</label>
          <div class="flex gap-2">
            <div class="relative flex-1">
              <input 
                type="text" 
                :value="checkoutData.cpf"
                @input="atualizarEFormatarCPF"
                :disabled="checkoutData.verificado"
                placeholder="000.000.000-00" 
                class="w-full bg-gray-50 dark:bg-slate-950 border border-gray-200 dark:border-slate-800 rounded-xl py-3 px-4 text-sm font-bold text-[#2C3E50] dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#2C3E50] dark:focus:ring-slate-700 disabled:bg-gray-100 dark:disabled:bg-slate-800 disabled:cursor-not-allowed"
              >
            </div>
            
            <button 
              v-if="!checkoutData.verificado"
              @click="dispararVerificacao"
              :disabled="validating"
              class="bg-[#2C3E50] dark:bg-slate-950 hover:bg-[#E67E73] text-white font-bold text-xs uppercase tracking-widest px-6 rounded-xl transition-colors disabled:opacity-50"
            >
              {{ validating ? 'Buscando...' : 'Verificar' }}
            </button>
            <button 
              v-else
              @click="$emit('limpar-cliente')"
              class="bg-red-50 dark:bg-rose-950/20 text-red-500 dark:text-rose-400 font-bold text-xs uppercase tracking-widest px-6 rounded-xl transition-colors"
            >
              Alterar
            </button>
          </div>

          <div v-if="checkoutData.verificado" class="p-3 bg-green-50 dark:bg-emerald-950/20 border border-green-200 dark:border-emerald-800/40 text-green-800 dark:text-emerald-300 rounded-xl flex items-center justify-between animate-fadeIn">
            <div class="text-xs">
              <p class="font-medium uppercase tracking-wider text-green-600 dark:text-emerald-400 text-[9px] font-black">Cliente Selecionado</p>
              <p class="font-black text-sm mt-0.5">{{ checkoutData.nome }}</p>
            </div>
            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
          </div>
        </div>

        <div class="space-y-3 border-t border-gray-100 dark:border-slate-800/40 pt-4">
          <label class="text-xs font-black uppercase text-[#2C3E50] dark:text-slate-400 tracking-wider block">Forma de Pagamento</label>
          <div class="grid grid-cols-2 gap-3">
            <button 
              @click="checkoutData.pagamento = 'pix'"
              :class="checkoutData.pagamento === 'pix' ? 'border-2 border-[#2C3E50] dark:border-slate-400 bg-gray-50 dark:bg-slate-950' : 'border border-gray-200 dark:border-slate-800'"
              class="p-4 rounded-2xl flex flex-col items-center justify-center gap-2 transition-all group"
            >
              <span class="font-black text-xs text-[#2C3E50] dark:text-slate-200 uppercase tracking-wide">PIX à vista</span>
            </button>
            <button 
              @click="checkoutData.pagamento = 'cartao'"
              :class="checkoutData.pagamento === 'cartao' ? 'border-2 border-[#2C3E50] dark:border-slate-400 bg-gray-50 dark:bg-slate-950' : 'border border-gray-200 dark:border-slate-800'"
              class="p-4 rounded-2xl flex flex-col items-center justify-center gap-2 transition-all group"
            >
              <span class="font-black text-xs text-[#2C3E50] dark:text-slate-200 uppercase tracking-wide">Cartão Maquininha</span>
            </button>
          </div>

          <div v-if="checkoutData.pagamento === 'cartao'" class="grid grid-cols-2 gap-2 mt-2 pt-2 animate-fadeIn">
            <button 
              @click="checkoutData.subMetodo = 'credito'"
              :class="checkoutData.subMetodo === 'credito' ? 'bg-[#2C3E50] dark:bg-slate-200 text-white dark:text-slate-900' : 'bg-gray-100 dark:bg-slate-800 text-[#2C3E50] dark:text-slate-300'"
              class="py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider"
            >
              Crédito
            </button>
            <button 
              @click="checkoutData.subMetodo = 'debito'"
              :class="checkoutData.subMetodo === 'debito' ? 'bg-[#2C3E50] dark:bg-slate-200 text-white dark:text-slate-900' : 'bg-gray-100 dark:bg-slate-800 text-[#2C3E50] dark:text-slate-300'"
              class="py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider"
            >
              Débito
            </button>
          </div>
        </div>

        <div class="p-4 bg-gray-50 dark:bg-slate-950 rounded-2xl flex justify-between items-center border border-gray-100 dark:border-slate-800/40">
          <span class="text-xs uppercase font-black tracking-widest text-gray-400 dark:text-slate-500">Total Geral</span>
          <span class="text-xl font-black text-[#2C3E50] dark:text-slate-200">{{ formatarMoeda(totalCarrinho) }}</span>
        </div>
      </div>

      <div class="p-6 bg-gray-50 dark:bg-slate-950 border-t border-gray-100 dark:border-slate-800/60 flex gap-3">
        <button 
          @click="$emit('update:modelValue', false)"
          class="flex-1 py-3.5 border border-gray-200 dark:border-slate-800 text-gray-500 dark:text-slate-400 rounded-xl font-black text-xs uppercase tracking-widest bg-white dark:bg-slate-900 hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors"
        >
          Cancelar
        </button>
        <button 
          @click="$emit('finalizar-venda')"
          :disabled="!checkoutData.verificado || carrinho.length === 0"
          :class="(!checkoutData.verificado || carrinho.length === 0) ? 'bg-gray-300 dark:bg-slate-800 cursor-not-allowed text-gray-400 dark:text-slate-600' : 'bg-[#2C3E50] dark:bg-slate-200 hover:bg-[#E67E73] dark:hover:bg-slate-100 text-white dark:text-slate-900'"
          class="flex-1 py-3.5 rounded-xl font-black text-xs uppercase tracking-widest transition-colors shadow-lg shadow-gray-100 dark:shadow-none"
        >
          Fechar Venda
        </button>
      </div>

    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  modelValue: Boolean,
  carrinho: Array,
  totalCarrinho: Number,
  checkoutData: Object,
  validating: Boolean
})

const emit = defineEmits(['update:modelValue', 'verificar-cpf', 'limpar-cliente', 'finalizar-venda'])

const atualizarEFormatarCPF = (e) => {
  let v = e.target.value.replace(/\D/g, '')
  if (v.length > 11) v = v.slice(0, 11)
  
  if (v.length > 9) {
    v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4")
  } else if (v.length > 6) {
    v = v.replace(/(\d{3})(\d{3})(\d{3})/, "$1.$2.$3")
  } else if (v.length > 3) {
    v = v.replace(/(\d{3})(\d{3})/, "$1.$2")
  }
  props.checkoutData.cpf = v
}

const dispararVerificacao = () => {
  const cleanCPF = props.checkoutData.cpf.replace(/\D/g, '')
  emit('verificar-cpf', cleanCPF)
}

const formatarMoeda = (valor) => {
  return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor || 0)
}
</script>