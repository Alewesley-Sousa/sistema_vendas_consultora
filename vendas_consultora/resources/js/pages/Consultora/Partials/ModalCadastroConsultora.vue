<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import Swal from 'sweetalert2'
import { usePage, router } from '@inertiajs/vue3'

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['close'])

const step = ref(1)
const loading = ref(false)

const formData = ref({
  nome: '',
  cpf: '',
  telefone: '',
  cep: '',
  email: '',
  senha: '',
  status_id: 3, 
  cargo: 'consultora'
})

const userLogado = usePage().props.auth?.user?.nome || 'Nenhum'

watch(() => props.show, (newVal) => {
  if (!newVal) {
    resetForm()
  }
})

const mascaraCPF = (e) => {
  let v = e.target.value.replace(/\D/g, '').slice(0, 11)
  if (v.length > 9) v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4")
  else if (v.length > 6) v = v.replace(/(\d{3})(\d{3})(\d{3})/, "$1.$2.$3")
  else if (v.length > 3) v = v.replace(/(\d{3})(\d{3})/, "$1.$2")
  formData.value.cpf = v
}

const mascaraCEP = (e) => {
  let v = e.target.value.replace(/\D/g, '').slice(0, 8)
  if (v.length > 5) v = v.replace(/(\d{5})(\d{3})/, "$1-$2")
  formData.value.cep = v
}

const mascaraTelefone = (e) => {
  let v = e.target.value.replace(/\D/g, '').slice(0, 11)
  if (v.length > 10) v = v.replace(/^(\d{2})(\d{5})(\d{4})/, "($1) $2-$3")
  else if (v.length > 2) v = v.replace(/^(\d{2})(\d{0,5})/, "($1) $2")
  formData.value.telefone = v
}

const fecharModal = () => {
  emit('close')
}

const submitForm = async () => {
  if (loading.value) return
  loading.value = true
  
  const cleanData = {
    nome: String(formData.value.nome).trim(),
    cpf: String(formData.value.cpf).replace(/\D/g, ''),
    telefone: String(formData.value.telefone).replace(/\D/g, ''),
    cep: String(formData.value.cep).replace(/\D/g, ''),
    email: String(formData.value.email).trim(),
    senha: String(formData.value.senha),
    status_id: 3,
    cargo: 'consultora'
  }
  
  try {
    const token = localStorage.getItem('auth_token')
    
    const response = await axios.post('/api/usuarios', cleanData, {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    
    if (response.data && (response.status === 200 || response.data.status === 'success')) {
      loading.value = false
      
      await Swal.fire({
        title: 'Tudo pronto!',
        text: response.data.mensagem || 'Pré-cadastro realizado com sucesso.',
        icon: 'success',
        confirmButtonColor: '#2C3E50'
      })
      
      fecharModal()
      router.reload({ preserveScroll: true })
    }
  } catch (e) {
    loading.value = false
    console.error("Erro capturado na requisição:", e)
    let mensagemErro = 'Erro interno ao processar cadastro.'
    if (e.response) {
      if (e.response.status === 422 && e.response.data.errors) {
        mensagemErro = Object.values(e.response.data.errors).flat().join('<br>')
      } else if (e.response.data && e.response.data.mensagem) {
        mensagemErro = e.response.data.mensagem
      }
    } else if (e.message) {
      mensagemErro = e.message
    }
    
    Swal.fire({ 
      title: 'Não foi possível cadastrar', 
      html: mensagemErro, 
      icon: 'error', 
      confirmButtonColor: '#FF7665' 
    })
  }
}

const resetForm = () => {
  step.value = 1
  formData.value = { nome: '', cpf: '', telefone: '', cep: '', email: '', senha: '', status_id: 3, cargo: 'consultora' }
}
</script>

<template>
  <Transition name="fade">
    <div v-if="show" class="fixed inset-0 z-[100] overflow-y-auto">
      
      <div class="fixed inset-0 bg-[#2C3E50]/80 dark:bg-black/75 backdrop-blur-sm transition-opacity" @click="fecharModal"></div>

      <div class="relative min-h-screen flex items-center justify-center p-4">
        
        <Transition name="scale">
          <div v-if="show" class="bg-white dark:bg-slate-900 w-full max-w-2xl rounded-[3rem] shadow-2xl dark:shadow-[0_30px_70px_rgba(0,0,0,0.5)] border border-transparent dark:border-slate-800/60 overflow-hidden relative z-10">
              
            <div class="bg-[#2C3E50] dark:bg-slate-950 p-8 text-white relative">
              <button @click="fecharModal" class="absolute top-6 right-6 text-white/50 hover:text-white transition-transform hover:rotate-90 duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
              </button>
              <div class="border-l-4 border-[#FF7665] pl-4">
                <h2 class="text-2xl font-serif font-bold tracking-tight">Nova Consultora</h2>
                <p class="text-xs uppercase tracking-widest text-[#FF7665] font-bold">Passo {{ step }} de 3</p>
              </div>

              <div class="flex gap-2 mt-6">
                <div v-for="i in 3" :key="i"
                     class="h-1.5 flex-1 rounded-full transition-all duration-700" 
                     :class="step >= i ? 'bg-[#FF7665] shadow-[0_0_10px_#FF7665]' : 'bg-white/10 dark:bg-slate-800'"
                ></div>
              </div>
            </div>

            <div class="p-10">
              <form @submit.prevent="submitForm">
                
                <Transition name="slide-fade" mode="out-in">
                  
                  <div v-if="step === 1" key="step1">
                    <h3 class="text-lg font-bold text-[#2C3E50] dark:text-slate-200 mb-6 flex items-center gap-2">
                      <span class="bg-[#FFF9F9] dark:bg-slate-950 text-[#FF7665] w-8 h-8 rounded-lg flex items-center justify-center shadow-sm border border-transparent dark:border-slate-800/40">01</span>
                      Informações Pessoais
                    </h3>
                    <div class="space-y-4">
                      <div class="group">
                        <label class="block text-[10px] uppercase font-black text-gray-400 dark:text-slate-500 mb-1 ml-2 transition-colors group-focus-within:text-[#FF7665]">Nome Completo</label>
                        <input type="text" v-model="formData.nome" class="w-full bg-gray-50 dark:bg-slate-950 border-none rounded-2xl p-4 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-[#FF7665]/20 text-sm transition-all placeholder-gray-300 dark:placeholder-slate-700" placeholder="Ex: Maria Silva">
                      </div>
                      <div class="grid grid-cols-2 gap-4">
                        <div>
                          <label class="block text-[10px] uppercase font-black text-gray-400 dark:text-slate-500 mb-1 ml-2">CPF (11 números)</label>
                          <input type="text" :value="formData.cpf" @input="mascaraCPF" class="w-full bg-gray-50 dark:bg-slate-950 border-none rounded-2xl p-4 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-[#FF7665]/20 text-sm transition-all placeholder-gray-300 dark:placeholder-slate-700" placeholder="000.000.000-00">
                        </div>
                        <div>
                          <label class="block text-[10px] uppercase font-black text-gray-400 dark:text-slate-500 mb-1 ml-2">WhatsApp</label>
                          <input type="text" :value="formData.telefone" @input="mascaraTelefone" class="w-full bg-gray-50 dark:bg-slate-950 border-none rounded-2xl p-4 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-[#FF7665]/20 text-sm transition-all placeholder-gray-300 dark:placeholder-slate-700" placeholder="(85) 9 0000-0000">
                        </div>
                      </div>
                      <div>
                        <label class="block text-[10px] uppercase font-black text-gray-400 dark:text-slate-500 mb-1 ml-2">CEP (8 números)</label>
                        <input type="text" :value="formData.cep" @input="mascaraCEP" class="w-full bg-gray-50 dark:bg-slate-950 border-none rounded-2xl p-4 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-[#FF7665]/20 text-sm transition-all placeholder-gray-300 dark:placeholder-slate-700" placeholder="00000-000">
                      </div>
                    </div>
                  </div>

                  <div v-else-if="step === 2" key="step2">
                    <h3 class="text-lg font-bold text-[#2C3E50] dark:text-slate-200 mb-6 flex items-center gap-2">
                      <span class="bg-[#FFF9F9] dark:bg-slate-950 text-[#FF7665] w-8 h-8 rounded-lg flex items-center justify-center shadow-sm border border-transparent dark:border-slate-800/40">02</span>
                      Dados de Acesso
                    </h3>
                    <div class="space-y-4">
                      <div>
                        <label class="block text-[10px] uppercase font-black text-gray-400 dark:text-slate-500 mb-1 ml-2">E-mail Profissional</label>
                        <input type="email" v-model="formData.email" class="w-full bg-gray-50 dark:bg-slate-950 border-none rounded-2xl p-4 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-[#FF7665]/20 text-sm transition-all placeholder-gray-300 dark:placeholder-slate-700" placeholder="consultora@glow.com">
                      </div>
                      <div>
                        <label class="block text-[10px] uppercase font-black text-gray-400 dark:text-slate-500 mb-1 ml-2">Senha Inicial</label>
                        <input type="password" v-model="formData.senha" class="w-full bg-gray-50 dark:bg-slate-950 border-none rounded-2xl p-4 text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-[#FF7665]/20 text-sm transition-all placeholder-gray-300 dark:placeholder-slate-700" placeholder="••••••••">
                      </div>
                    </div>
                  </div>

                  <div v-else-if="step === 3" key="step3">
                    <h3 class="text-lg font-bold text-[#2C3E50] dark:text-slate-200 mb-6 flex items-center gap-2">
                      <span class="bg-[#FFF9F9] dark:bg-slate-950 text-[#FF7665] w-8 h-8 rounded-lg flex items-center justify-center shadow-sm border border-transparent dark:border-slate-800/40">03</span>
                      Finalizar Pré-Cadastro
                    </h3>
                    <div class="p-6 bg-[#FFF9F9] dark:bg-slate-950 rounded-[2rem] border border-[#FF7665]/10 dark:border-[#FF7665]/5 mb-6 hover:shadow-inner transition-all">
                      <div class="flex items-center gap-4 mb-4">
                        <div class="bg-[#FF7665] text-white p-3 rounded-xl">
                          <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                          </svg>
                        </div>
                        <div>
                          <h4 class="font-bold text-[#2C3E50] dark:text-slate-200 text-sm">Quase lá!</h4>
                          <p class="text-[10px] text-gray-500 uppercase tracking-tighter">O cadastro ficará pendente de aprovação.</p>
                        </div>
                      </div>
                      <div class="space-y-2 border-t border-gray-100 dark:border-slate-800/40 pt-4">
                        <p class="text-xs text-gray-600 dark:text-slate-400"><strong>Nome:</strong> <span class="text-[#2C3E50] dark:text-slate-200 font-medium">{{ formData.nome || '-' }}</span></p>
                        <p class="text-xs text-gray-600 dark:text-slate-400"><strong>WhatsApp:</strong> <span class="text-[#2C3E50] dark:text-slate-200 font-medium">{{ formData.telefone || '-' }}</span></p>
                        <p class="text-xs text-gray-600 dark:text-slate-400"><strong>Indicada por:</strong> <span class="text-[#2C3E50] dark:text-slate-200 font-medium">{{ userLogado }}</span></p>
                        <p class="text-xs text-gray-600 dark:text-slate-400"><strong>Status:</strong> <span class="text-[#FF7665] font-bold">Aguardando Aprovação</span></p>
                      </div>
                    </div>
                  </div>
                </Transition>

                <div class="flex justify-between mt-10">
                  <button type="button" v-if="step > 1" @click="step--" class="px-8 py-4 text-xs font-bold text-gray-400 hover:text-[#2C3E50] dark:hover:text-white uppercase tracking-widest transition-all transform hover:-translate-x-1">
                    Voltar
                  </button>
                  <div class="flex-1"></div>
                  
                  <button type="button" v-if="step < 3" @click="step++" 
                          class="bg-[#2C3E50] dark:bg-slate-950 text-white px-10 py-4 rounded-2xl shadow-xl font-bold text-xs uppercase tracking-widest hover:bg-[#1a252f] dark:hover:bg-black transition-all transform hover:scale-105 active:scale-95">
                    Próximo Passo
                  </button>

                  <button type="submit" v-if="step === 3" :disabled="loading" 
                          class="bg-[#FF7665] text-white px-10 py-4 rounded-2xl shadow-lg shadow-[#FF7665]/30 dark:shadow-none font-bold text-xs uppercase tracking-widest hover:bg-[#ff6450] transition-all transform hover:scale-105 active:scale-95 disabled:opacity-50 disabled:scale-100">
                    <span v-if="!loading">Concluir Pré-Cadastro</span>
                    <span v-else class="flex items-center gap-2">
                      <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                      </svg>
                      Processando...
                    </span>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </Transition>

      </div>
    </div>
  </Transition>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

.scale-enter-active {
  transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.scale-leave-active {
  transition: all 0.25s ease-in;
}
.scale-enter-from {
  opacity: 0;
  transform: scale(0.9) translateY(15px);
}
.scale-leave-to {
  opacity: 0;
  transform: scale(0.95);
}

.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}
.slide-fade-leave-active {
  transition: all 0.2s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter-from {
  transform: translateX(20px);
  opacity: 0;
}
.slide-fade-leave-to {
  transform: translateX(-20px);
  opacity: 0;
}
</style>