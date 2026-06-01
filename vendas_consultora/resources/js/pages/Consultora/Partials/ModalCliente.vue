<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'

// Sub-componentes
import StepMenu from './ModalCliente/StepMenu.vue'
import StepConsulta from './ModalCliente/StepConsulta.vue'
import StepCadastro from './ModalCliente/StepCadastro.vue'
import StepResultado from './ModalCliente/StepResultado.vue'
import StepErro from './ModalCliente/StepErro.vue'

const open = ref(false)
const step = ref('menu') // menu, form, cadastro, resultado, erro
const loading = ref(false)
const clienteData = ref(null)
const errors = ref({})

const token = localStorage.getItem('auth_token')
const cpfConsulta = ref('')
const novoCliente = ref({ nome: '', email: '', telefone: '', cep: '', cpf: '' })

// Listeners Globais
onMounted(() => {
  window.addEventListener('open-modal-cliente', () => {
    resetModal()
    open.value = true
    document.body.classList.add('overflow-hidden')
  })
})

watch(open, (newValue) => {
  if (!newValue) document.body.classList.remove('overflow-hidden')
})

// Observadores de Máscara em Tempo Real
watch(cpfConsulta, (v) => {
  let clean = v.replace(/\D/g, '').slice(0, 11)
  if (clean.length > 9) cpfConsulta.value = clean.replace(/^(\d{3})(\d{3})(\d{3})(\d{0,2})/, '$1.$2.$3-$4')
  else if (clean.length > 6) cpfConsulta.value = clean.replace(/^(\d{3})(\d{3})(\d{0,3})/, '$1.$2.$3')
  else if (clean.length > 3) cpfConsulta.value = clean.replace(/^(\d{3})(\d{0,3})/, '$1.$2')
})

watch(() => novoCliente.value.cpf, (v) => {
  let clean = v.replace(/\D/g, '').slice(0, 11)
  if (clean.length > 9) novoCliente.value.cpf = clean.replace(/^(\d{3})(\d{3})(\d{3})(\d{0,2})/, '$1.$2.$3-$4')
  else if (clean.length > 6) novoCliente.value.cpf = clean.replace(/^(\d{3})(\d{3})(\d{0,3})/, '$1.$2.$3')
  else if (clean.length > 3) novoCliente.value.cpf = clean.replace(/^(\d{3})(\d{0,3})/, '$1.$2')
})

watch(() => novoCliente.value.telefone, (v) => {
  let clean = v.replace(/\D/g, '').slice(0, 11)
  if (clean.length > 10) novoCliente.value.telefone = clean.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3')
  else if (clean.length > 5) novoCliente.value.telefone = clean.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3')
  else if (clean.length > 2) novoCliente.value.telefone = clean.replace(/^(\d{2})(\d{0,5})/, '($1) $2')
})

watch(() => novoCliente.value.cep, (v) => {
  let clean = v.replace(/\D/g, '').slice(0, 8)
  novoCliente.value.cep = clean.replace(/^(\d{5})(\d{3})/, '$1-$2')
})

// Validação e Métodos API
const isCPFValido = (cpf) => {
  cpf = cpf.replace(/\D/g, '')
  if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false
  let soma = 0, resto
  for (let i = 1; i <= 9; i++) soma += parseInt(cpf.substring(i - 1, i)) * (11 - i)
  resto = (soma * 10) % 11
  if (resto === 10 || resto === 11) resto = 0
  if (resto !== parseInt(cpf.substring(9, 10))) return false
  soma = 0
  for (let i = 1; i <= 10; i++) soma += parseInt(cpf.substring(i - 1, i)) * (12 - i)
  resto = (soma * 10) % 11
  if (resto === 10 || resto === 11) resto = 0
  return resto === parseInt(cpf.substring(10, 11))
}

const consultar = async () => {
  let cleanCPF = cpfConsulta.value.replace(/\D/g, '')
  loading.value = true
  errors.value = {}
  try {
    const res = await axios.get(`/api/cliente/${cleanCPF}`, {
      headers: token ? { 'Authorization': `Bearer ${token}` } : {}
    })
    if (res.data && (res.data.status === 'success' || res.data.data)) {
      clienteData.value = res.data.data || res.data
      step.value = 'resultado'
      cpfConsulta.value = ''
    } else {
      errors.value.message = 'Comprador não localizado no banco de dados da GlowBiz.'
      step.value = 'erro'
    }
  } catch (err) {
    errors.value.message = err.response?.data?.message || 'Falha técnica ao consultar o cliente externo.'
    step.value = 'erro'
  } finally { layer() }
}

const cadastrar = async () => {
  errors.value = {}
  if (!novoCliente.value.nome?.trim()) errors.value.nome = ['O nome é obrigatório']
  if (novoCliente.value.cpf.length < 14) errors.value.cpf = ['CPF incompleto']
  else if (!isCPFValido(novoCliente.value.cpf)) errors.value.cpf = ['Este CPF é inválido!']
  if (!novoCliente.value.email?.includes('@')) errors.value.email = ['E-mail inválido']

  if (Object.keys(errors.value).length > 0) return

  loading.value = true
  const payload = {
    ...novoCliente.value,
    cpf: novoCliente.value.cpf.replace(/\D/g, ''),
    cep: novoCliente.value.cep.replace(/\D/g, ''),
    telefone: novoCliente.value.telefone.replace(/\D/g, '')
  }

  try {
    const res = await axios.post('/api/cliente', payload, {
      headers: token ? { 'Authorization': `Bearer ${token}` } : {}
    })
    if (res.data) {
      clienteData.value = res.data.data || res.data
      step.value = 'resultado'
      resetFormulario()
    }
  } catch (err) {
    if (err.response?.status === 422) errors.value = err.response.data.errors || {}
    else {
      errors.value.message = err.response?.data?.message || 'Não conseguimos salvar o cliente devido a uma falha interna.'
      step.value = 'erro'
    }
  } finally { layer() }
}

const layer = () => loading.value = false
const resetFormulario = () => {
  novoCliente.value = { nome: '', email: '', telefone: '', cep: '', cpf: '' }
  cpfConsulta.value = ''
  errors.value = {}
}
const resetModal = () => { step.value = 'menu'; resetFormulario(); loading.value = false; clienteData.value = null }
const closeModal = () => { open.value = false; resetModal() }
</script>

<template>
  <Transition name="fade-modal">
    <div v-if="open" class="fixed inset-0 z-[100] flex items-center justify-center p-4" role="dialog" aria-modal="true">
      <div class="fixed inset-0 bg-[#0F1722]/70 dark:bg-black/80 backdrop-blur-md" @click="closeModal"></div>

      <div class="relative z-10 w-full max-w-2xl overflow-hidden rounded-[2.5rem] border border-white/20 dark:border-white/10 bg-white dark:bg-slate-900 shadow-[0_30px_70px_rgba(0,0,0,0.35)] dark:shadow-[0_30px_70px_rgba(0,0,0,0.6)] transform transition-all">
        
        <div class="relative overflow-hidden bg-[#2C3E50] dark:bg-slate-950 px-8 py-7 sm:px-10">
          <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/5 blur-[40px]"></div>
          <div class="absolute -bottom-12 left-1/2 h-36 w-36 -translate-x-1/2 rounded-full bg-[#FFD700]/10 blur-[50px]"></div>
          <div class="relative z-10 flex items-start justify-between gap-4">
            <div>
              <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-[#FFD700]/30 bg-[#FFD700]/10 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.25em] text-[#FFD700]">
                <span class="h-2 w-2 rounded-full bg-[#FFD700]"></span> Glow Database
              </div>
              <h2 class="text-2xl font-bold tracking-wide text-white">
                {{ step === 'menu' ? 'Gestão de Clientes' : step === 'cadastro' ? 'Novo Cadastro' : step === 'form' ? 'Identificação do Cliente' : step === 'resultado' ? 'Dossiê do Cliente' : 'Atenção' }}
              </h2>
              <p class="mt-1 text-sm text-white/70">Consulte ou registre compradores finais no sistema</p>
            </div>
            <button type="button" @click="closeModal" class="rounded-2xl bg-white/10 p-3 text-white/80 transition hover:bg-white/20 hover:text-white">
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>
        </div>

        <div class="max-h-[70vh] overflow-y-auto bg-white dark:bg-slate-900 px-6 py-6 sm:px-8 sm:py-8">
          <Transition name="step-slide" mode="out-in">
            <StepMenu v-if="step === 'menu'" :key="'menu'" @change-step="step = $event" />
            <StepConsulta v-else-if="step === 'form'" :key="'form'" v-model="cpfConsulta" :loading="loading" @consultar="consultar" />
            <StepCadastro v-else-if="step === 'cadastro'" :key="'cadastro'" v-model="novoCliente" :errors="errors" :loading="loading" @cadastrar="cadastrar" />
            <StepResultado v-else-if="step === 'resultado' && clienteData" :key="'resultado'" :data="clienteData" @back-menu="step = 'menu'" />
            <StepErro v-else-if="step === 'erro'" :key="'erro'" :message="errors.message" @change-step="step = $event" />
          </Transition>
        </div>

        <div class="flex items-center justify-between border-t border-slate-100 dark:border-slate-800/60 bg-slate-50 dark:bg-slate-950 px-6 py-5 sm:px-8">
          <button type="button" v-if="step !== 'menu'" @click="step = 'menu'" class="group flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-[#2C3E50] dark:text-slate-300 transition-colors hover:text-amber-500 dark:hover:text-amber-400">
            <svg class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg> Início
          </button>
          <button type="button" @click="closeModal" class="ml-auto flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500 transition-all hover:text-rose-500 dark:hover:text-rose-400">Fechar Janela</button>
        </div>

      </div>
    </div>
  </Transition>
</template>

<style scoped>
/* --- Transição do Modal em si --- */
.fade-modal-enter-active, .fade-modal-leave-active { transition: opacity 0.3s ease; }
.fade-modal-enter-from, .fade-modal-leave-to { opacity: 0; }
.fade-modal-enter-active .relative.z-10 { animation: modalScaleUp 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
.fade-modal-leave-active .relative.z-10 { animation: modalScaleDown 0.3s cubic-bezier(0.16, 1, 0.3, 1); }

@keyframes modalScaleUp { from { opacity: 0; transform: scale(0.95) translateY(15px); } to { opacity: 1; transform: scale(1) translateY(0); } }
@keyframes modalScaleDown { from { opacity: 1; transform: scale(1) translateY(0); } to { opacity: 0; transform: scale(0.95) translateY(15px); } }

/* --- TRANSIÇÃO CINEMÁTICA DOS PASSOS INTERNOS --- */
.step-slide-enter-active,
.step-slide-leave-active {
  transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.step-slide-leave-to {
  opacity: 0;
  transform: translateX(-16px) scale(0.98);
}

.step-slide-enter-from {
  opacity: 0;
  transform: translateX(30px) scale(0.99);
}
</style>