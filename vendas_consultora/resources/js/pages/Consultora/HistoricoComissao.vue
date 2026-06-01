<script setup>
import { ref, onMounted, watch } from 'vue'
import { Head } from '@inertiajs/vue3'
import axios from 'axios'

// Estado reativo
const transacoes = ref([])
const saldoTotal = ref(0)
const valorMinimoSaque = ref(50.00) // Configuração de valor mínimo de saque exigido pela regra de negócio
const loading = ref(false)
const loadingSaque = ref(false)
const showModal = ref(false)
const toasts = ref([])

// Listagens dinâmicas para remover o hardcoding do template
const origensDisponiveis = ref([])
const movimentacoesDisponiveis = ref([])

const filtros = ref({
  data_inicio: '',
  data_fim: '',
  tipo: '',
  tipo_comissao_id: ''
})

const pagination = ref({})

// Inicialização
onMounted(() => {
  fetchSaldo()
  fetchFiltrosAuxiliares()
  fetchData()
})

// Observador inteligente (Watch) com gatilho automático para os filtros
watch(
  () => [filtros.value.data_inicio, filtros.value.data_fim, filtros.value.tipo, filtros.value.tipo_comissao_id],
  () => {
    fetchData(1)
  }
)

// Sistema de Toast Notificação Melhorado
const addToast = (message, type = 'success') => {
  const id = Date.now()
  const autoClose = type === 'success'
  
  toasts.value.push({ id, message, type, show: true })
  
  if (autoClose) {
    setTimeout(() => {
      closeToast(id)
    }, 5000)
  }
}

const closeToast = (id) => {
  const index = toasts.value.findIndex(t => t.id === id)
  if (index > -1) toasts.value[index].show = false
}

// Busca as origens e tipos de movimentações dinamicamente
const fetchFiltrosAuxiliares = async () => {
  try {
    const [resOrigens, resMovimentacoes] = await Promise.all([
      axios.get('/api/comissao/origens').catch(() => ({ data: { data: [{ id: 1, nome: 'Venda Direta' }, { id: 2, nome: 'Nível 1' }, { id: 3, nome: 'Nível 2' }] } })),
      axios.get('/api/comissao/movimentacoes').catch(() => ({ data: { data: [{ id: 1, nome: 'Venda (Entrada)' }, { id: 2, nome: 'Estorno (Saída)' }, { id: 3, nome: 'Saque (Retirada)' }] } }))
    ])
    origensDisponiveis.value = resOrigens.data.data || []
    movimentacoesDisponiveis.value = resMovimentacoes.data.data || []
  } catch (error) {
    console.error("Erro ao carregar filtros auxiliares:", error)
  }
}

// Busca o Saldo Líquido Disponível
const fetchSaldo = async () => {
  try {
    const response = await axios.get('/api/comissao')
    if (response.data && response.data.status === 'sucesso') {
      saldoTotal.value = parseFloat(response.data.data) || 0
    }
  } catch (error) {
    console.error("Erro ao buscar saldo:", error)
  }
}

// Busca o histórico de transações com filtros e paginação
const fetchData = async (page = 1) => {
  loading.value = true
  try {
    const params = {
      page,
      ...(filtros.value.data_inicio && { data_inicio: filtros.value.data_inicio }),
      ...(filtros.value.data_fim && { data_fim: filtros.value.data_fim }),
      ...(filtros.value.tipo && { tipo: filtros.value.tipo }),
      ...(filtros.value.tipo_comissao_id && { tipo_comissao_id: filtros.value.tipo_comissao_id })
    }

    const response = await axios.get('/api/comissao/historico', { params })

    if (response.data && response.data.status === 'success') {
      transacoes.value = response.data.data.historico.data || []
      pagination.value = response.data.data.historico || {}
    }
  } catch (error) {
    addToast("Erro ao carregar dados do histórico", "error")
  } finally {
    loading.value = false
  }
}

const abrirModalSaque = () => {
  if (saldoTotal.value < valorMinimoSaque.value) return
  showModal.value = true
}

// Executa a requisição de Saque
const confirmarSaqueReal = async () => {
  showModal.value = false
  loadingSaque.value = true
  try {
    const response = await axios.get('/api/comissao/solicitar')
    
    if (response.data && response.data.status === 'success') {
      addToast(response.data.message || "Saque solicitado com sucesso!", 'success')
      await fetchSaldo()
      await fetchData(1)
    } else {
      addToast(response.data.message || "Erro ao solicitar saque", 'error')
    }
  } catch (error) {
    const mensagemDoServidor = error.response?.data?.message || "Erro de conexão com o servidor"
    addToast(mensagemDoServidor, "error")
  } finally {
    loadingSaque.value = false
  }
}

const formatCurrency = (value) => {
  return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value || 0)
}

const formatDate = (dateString) => {
  return dateString ? new Date(dateString).toLocaleDateString('pt-BR') : '-'
}

// Retorna as classes de cores dependendo do status dinâmico (Adaptado para dark mode)
const statusStyleClass = (statusIdOrNome) => {
  const status = String(statusIdOrNome).toLowerCase()
  if (status.includes('pago') || status.includes('processado') || status === '1') {
    return 'bg-emerald-50 dynamic-text-emerald dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border-emerald-200/60 dark:border-emerald-800/40'
  }
  if (status.includes('pendente') || status.includes('analise') || status === '2') {
    return 'bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 border-amber-200/60 dark:border-amber-800/40'
  }
  return 'bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 border-rose-200/60 dark:border-rose-800/40'
}

const changePage = (url) => {
  if (url) {
    const page = new URL(url).searchParams.get('page')
    fetchData(page).then(() => {
      window.scrollTo({ top: 0, behavior: 'smooth' })
    })
  }
}

const cleanPaginationLabel = (label) => {
  if (label.includes('Previous')) return '‹'
  if (label.includes('Next')) return '›'
  return label
}

const limparFiltros = () => {
  filtros.value = { data_inicio: '', data_fim: '', tipo: '', tipo_comissao_id: '' }
}

const voltar = () => {
  window.history.back()
}
</script>

<template>
  <Head title="Histórico de Comissões - GlowBiz" />

  <div class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased font-sans pb-12 transition-colors duration-300">
    
    <!-- Sistema de Toasts -->
    <div class="fixed top-5 right-5 z-[120] space-y-3 pointer-events-none">
      <TransitionGroup name="toast">
        <div v-for="toast in toasts" :key="toast.id">
          <div v-if="toast.show" 
            :class="toast.type === 'success' ? 'bg-emerald-600' : 'bg-rose-600'"
            class="text-white px-5 py-4 rounded-2xl shadow-2xl flex items-center justify-between gap-4 min-w-[320px] max-w-md pointer-events-auto border border-white/10"
          >
            <div class="flex items-center gap-3">
              <span class="text-lg flex-shrink-0">{{ toast.type === 'success' ? '✅' : '❌' }}</span>
              <span class="font-medium text-sm leading-snug">{{ toast.message }}</span>
            </div>
            <button @click="closeToast(toast.id)" class="text-white/70 hover:text-white text-xs font-bold transition-colors p-1 bg-white/10 rounded-lg hover:bg-white/20">
              ✕
            </button>
          </div>
        </div>
      </TransitionGroup>
    </div>

    <!-- Modal de Confirmação de Saque -->
    <Transition name="modal">
      <div v-if="showModal" class="fixed inset-0 z-[110] overflow-y-auto">
        <div class="fixed inset-0 bg-slate-900/40 dark:bg-black/60 backdrop-blur-sm transition-opacity" @click="showModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
          <div class="relative bg-white dark:bg-slate-900 rounded-3xl shadow-2xl p-8 max-w-sm w-full text-center space-y-6 transform transition-all border border-slate-100 dark:border-slate-800">
            <div class="w-20 h-20 bg-amber-50 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 rounded-full flex items-center justify-center mx-auto text-4xl border border-amber-200/50 dark:border-amber-800/40 shadow-inner">💰</div>
            <div>
              <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Confirmar Saque?</h3>
              <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm leading-relaxed">
                Você deseja solicitar o saque total do seu saldo disponível?<br>
                <span class="font-extrabold text-[#2C3E50] dark:text-[#FFD700] text-xl block mt-2 bg-amber-100/60 dark:bg-amber-500/10 py-2 rounded-xl border border-amber-200/40 dark:border-amber-500/20">
                  {{ formatCurrency(saldoTotal) }}
                </span>
              </p>
            </div>
            <div class="flex gap-3 pt-2">
              <button :disabled="loadingSaque" @click="showModal = false" class="flex-1 px-6 py-3 rounded-xl font-bold text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-sm disabled:opacity-50">Cancelar</button>
              <button :disabled="loadingSaque" @click="confirmarSaqueReal" class="flex-1 px-6 py-3 rounded-xl font-bold bg-[#2C3E50] dark:bg-[#FFD700] text-white dark:text-slate-950 hover:bg-slate-800 dark:hover:bg-amber-400 dark:shadow-none shadow-lg shadow-slate-200 transition-all text-sm disabled:opacity-50">
                <span v-if="!loadingSaque">Sim, Sacar</span>
                <span v-else>Processando...</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </Transition>

    <!-- Navbar -->
    <nav class="bg-[#2C3E50] dark:bg-slate-950 text-white p-4 shadow-xl flex justify-between items-center px-4 md:px-8 border-b border-[#FFD700]/30 sticky top-0 z-50 transition-colors duration-300">
      <div class="flex items-center gap-2 md:gap-3">
        <span class="text-xl md:text-2xl font-black tracking-widest uppercase font-serif">
          Glow<span class="text-[#FFD700] lowercase italic font-light text-sm ml-0.5">biz</span>
        </span>
        <span class="hidden md:block text-slate-500 dark:text-slate-600 font-light ml-4">|</span>
        <span class="hidden md:block ml-4 text-sm font-medium text-slate-300 dark:text-slate-400">Histórico Financeiro</span>
      </div>
      <button 
        @click="voltar" 
        class="group flex items-center gap-2 bg-slate-800/50 hover:bg-slate-700 border border-slate-600 dark:border-slate-800 px-4 py-2 rounded-full transition-all text-xs md:text-sm font-bold uppercase tracking-widest text-white"
      >
        <svg class="w-4 h-4 text-[#FFD700]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Voltar
      </button>
    </nav>

    <!-- Main Content -->
    <div class="p-4 md:p-8 max-w-[1400px] mx-auto space-y-8">
      
      <!-- Cabeçalho e Painel de Saldo -->
      <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
        <div>
          <h1 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">Histórico de Comissões</h1>
          <p class="text-slate-500 dark:text-slate-400 mt-1 font-medium text-sm">Gerencie seus ganhos e acompanhe o fluxo financeiro da sua rede.</p>
        </div>
        
        <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl shadow-md border border-slate-200/60 dark:border-slate-800/60 flex flex-col sm:flex-row items-center gap-6 w-full lg:w-auto">
          <div class="text-center sm:text-left">
            <p class="text-[10px] uppercase tracking-widest text-slate-400 dark:text-slate-500 font-bold">Saldo Líquido Disponível</p>
            <p class="text-2xl md:text-3xl font-extrabold text-[#2C3E50] dark:text-[#FFD700] tracking-tight">{{ formatCurrency(saldoTotal) }}</p>
            <p class="text-[11px] text-gray-400 dark:text-slate-500 font-medium italic mt-0.5">
              Mínimo para saque: <span class="font-bold text-slate-600 dark:text-slate-400">{{ formatCurrency(valorMinimoSaque) }}</span>
            </p>
          </div>
          <button @click="abrirModalSaque" 
            :disabled="loadingSaque || saldoTotal < valorMinimoSaque"
            class="w-full sm:w-auto bg-[#2C3E50] dark:bg-[#FFD700] hover:bg-slate-800 dark:hover:bg-amber-400 text-white dark:text-slate-950 px-8 py-3.5 rounded-2xl font-bold transition-all shadow-md dark:shadow-none shadow-slate-200 disabled:opacity-40 disabled:cursor-not-allowed text-sm flex items-center justify-center gap-2"
          >
            <span v-if="!loadingSaque">Solicitar Saque</span>
            <span v-else class="flex items-center gap-2">
              <svg class="animate-spin h-4 w-4 text-white dark:text-slate-950" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
              Processando...
            </span>
          </button>
        </div>
      </div>

      <!-- Barra de Filtros -->
      <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl shadow-sm border border-slate-200/70 dark:border-slate-800/70 flex flex-col md:flex-row items-end gap-4">
        <div class="w-full md:flex-1">
          <label class="block text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 mb-1.5 tracking-wider">Período</label>
          <div class="flex items-center gap-2 border border-slate-200 dark:border-slate-700/80 rounded-xl px-3 py-2 text-sm bg-slate-50/50 dark:bg-slate-950/40">
            <input type="date" v-model="filtros.data_inicio" class="outline-none text-slate-600 dark:text-slate-300 bg-transparent w-full font-medium scheme-dark-fix" />
            <span class="text-slate-300 dark:text-slate-600 font-light">até</span>
            <input type="date" v-model="filtros.data_fim" class="outline-none text-slate-600 dark:text-slate-300 bg-transparent w-full font-medium scheme-dark-fix" />
          </div>
        </div>
        
        <div class="w-full md:w-56">
          <label class="block text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 mb-1.5 tracking-wider">Origem</label>
          <select v-model="filtros.tipo_comissao_id" class="w-full border border-slate-200 dark:border-slate-700/80 rounded-xl px-3 py-2.5 text-sm text-slate-600 dark:text-slate-300 outline-none bg-slate-50/50 dark:bg-slate-950/40 font-semibold cursor-pointer">
            <option value="" class="dark:bg-slate-900">Todas as origens</option>
            <option v-for="origem in origensDisponiveis" :key="origem.id" :value="origem.id" class="dark:bg-slate-900">
              {{ origem.nome }}
            </option>
          </select>
        </div>
        
        <div class="w-full md:w-56">
          <label class="block text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 mb-1.5 tracking-wider">Movimentação</label>
          <select v-model="filtros.tipo" class="w-full border border-slate-200 dark:border-slate-700/80 rounded-xl px-3 py-2.5 text-sm text-slate-600 dark:text-slate-300 outline-none bg-slate-50/50 dark:bg-slate-950/40 font-semibold cursor-pointer">
            <option value="" class="dark:bg-slate-900">Todos os tipos</option>
            <option v-for="mov in movimentacoesDisponiveis" :key="mov.id" :value="mov.id" class="dark:bg-slate-900">
              {{ mov.nome }}
            </option>
          </select>
        </div>
        
        <div class="flex w-full md:w-auto gap-2">
          <div v-if="loading" class="flex-1 md:flex-none flex items-center justify-center px-6 py-2.5 text-slate-400 dark:text-slate-500 text-xs font-medium italic">
            Atualizando resultados...
          </div>
          <button @click="limparFiltros" class="w-full md:w-auto bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white text-sm font-bold px-6 py-2.5 rounded-xl transition-colors">
            Limpar Filtros
          </button>
        </div>
      </div>

      <!-- Tabela / Listagem de Resultados -->
      <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-lg border border-slate-200/70 dark:border-slate-800/70 overflow-hidden relative min-h-[450px] flex flex-col">
        
        <div v-if="loading" class="absolute inset-0 bg-white/70 dark:bg-slate-900/70 backdrop-blur-[1px] flex items-center justify-center z-10">
          <div class="animate-spin rounded-full h-8 w-8 border-2 border-slate-300 dark:border-slate-700 border-t-[#2C3E50] dark:border-t-[#FFD700]"></div>
        </div>

        <div class="flex-grow">
          <!-- Visão Desktop -->
          <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-50/70 dark:bg-slate-950/40 border-b border-slate-200/60 dark:border-slate-800/60">
                  <th class="px-6 py-4 text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider">Data</th>
                  <th class="px-6 py-4 text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider">Tipo de Comissão</th>
                  <th class="px-6 py-4 text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider">Movimentação</th>
                  <th class="px-6 py-4 text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider text-right">Valor</th>
                  <th class="px-6 py-4 text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider text-center">Status</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                <tr v-for="(item, index) in transacoes" :key="item.id" 
                  class="hover:bg-slate-50/50 dark:hover:bg-slate-950/20 transition-colors animate-cascade-entry opacity-0"
                  :style="{ animationDelay: `${index * 40}ms`, animationFillMode: 'forwards' }"
                >
                  <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400 font-medium">{{ formatDate(item.data_movimentacao) }}</td>
                  <td class="px-6 py-4 text-sm font-bold text-slate-700 dark:text-slate-300">{{ item.tipo_comissao?.nome || 'N/A' }}</td>
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                      <span :class="item.tipo_movimentacao_id == 1 ? 'bg-emerald-50 text-emerald-600 border-emerald-200 dark:bg-emerald-950/30 dark:text-emerald-400 dark:border-emerald-800/40' : 'bg-rose-50 text-rose-600 border-rose-200 dark:bg-rose-950/30 dark:text-rose-400 dark:border-rose-800/40'"
                            class="w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold border"
                      >
                        {{ item.tipo_movimentacao_id == 1 ? '+' : '-' }}
                      </span>
                      <span class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wide">{{ item.tipo_movimentacao?.nome }}</span>
                    </div>
                  </td>
                  <td :class="item.tipo_movimentacao_id == 1 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'"
                      class="px-6 py-4 text-sm font-extrabold text-right"
                  >
                    {{ formatCurrency(item.valor) }}
                  </td>
                  <td class="px-6 py-4 text-center">
                    <span :class="statusStyleClass(item.status_id || item.status?.nome)" 
                          class="px-3 py-1 text-[10px] font-bold rounded-full uppercase tracking-wider border"
                    >
                      {{ item.status?.nome || item.status_formatado || 'Processado' }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Visão Mobile -->
          <div class="block md:hidden divide-y divide-slate-100 dark:divide-slate-800/60">
            <div v-for="(item, index) in transacoes" :key="item.id" 
              class="p-4 space-y-3 bg-white dark:bg-slate-900 animate-cascade-entry opacity-0"
              :style="{ animationDelay: `${index * 50}ms`, animationFillMode: 'forwards' }"
            >
              <div class="flex justify-between items-start">
                <div class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wide">{{ formatDate(item.data_movimentacao) }}</div>
                <span :class="statusStyleClass(item.status_id || item.status?.nome)" 
                      class="px-2 py-0.5 text-[9px] font-black rounded-md uppercase tracking-wider border"
                >
                  {{ item.status?.nome || item.status_formatado || 'Processado' }}
                </span>
              </div>
              <div class="flex justify-between items-center">
                <div>
                  <p class="text-xs font-extrabold text-slate-700 dark:text-slate-300 uppercase tracking-wide">{{ item.tipo_comissao?.nome || 'N/A' }}</p>
                  <div class="flex items-center gap-1.5 mt-1">
                    <span :class="item.tipo_movimentacao_id == 1 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'" class="text-xs font-bold">
                      {{ item.tipo_movimentacao_id == 1 ? '↑' : '↓' }}
                    </span>
                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">{{ item.tipo_movimentacao?.nome }}</span>
                  </div>
                </div>
                <p :class="item.tipo_movimentacao_id == 1 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'" class="text-lg font-black">
                  {{ formatCurrency(item.valor) }}
                </p>
              </div>
            </div>
          </div>

          <!-- Estado Vazio -->
          <div v-if="transacoes.length === 0 && !loading" class="flex flex-col items-center justify-center py-24 px-6 text-center">
            <span class="text-5xl mb-4">📭</span>
            <p class="text-slate-400 dark:text-slate-500 italic font-medium text-sm">Nenhum registro de comissão encontrado para os filtros atuais.</p>
          </div>
        </div>

        <!-- Rodapé de Paginação -->
        <div class="sticky bottom-0 z-20 bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 p-4 md:p-6 flex flex-col sm:flex-row justify-between items-center gap-4 shadow-[0_-4px_10px_-1px_rgba(0,0,0,0.03)] dark:shadow-none">
          <div class="text-xs text-slate-400 dark:text-slate-500 font-medium">
            <span v-if="pagination.total > 0">
              Mostrando <span class="font-bold text-slate-600 dark:text-slate-400">{{ pagination.from }}</span> até <span class="font-bold text-slate-600 dark:text-slate-400">{{ pagination.to }}</span> de <span class="font-bold text-slate-600 dark:text-slate-400">{{ pagination.total }}</span> registros
            </span>
            <span v-else>Nenhum registro para exibir</span>
          </div>
          
          <div class="flex items-center gap-1 overflow-x-auto max-w-full no-scrollbar">
            <button v-for="link in pagination.links" :key="link.label"
              @click="changePage(link.url)" 
              :disabled="!link.url || link.active"
              :class="link.active 
                ? 'bg-[#2C3E50] dark:bg-[#FFD700] text-white dark:text-slate-950 shadow-md' 
                : 'text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 border border-transparent hover:border-slate-200 dark:hover:border-slate-700'"
              class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all disabled:opacity-30 whitespace-nowrap min-w-[32px] text-center"
            >
              {{ cleanPaginationLabel(link.label) }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@900&display=swap');

.font-serif {
  font-family: 'Playfair Display', serif;
}

.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

/* Correção de cor do ícone de calendário nativo no dark mode */
.scheme-dark-fix {
  color-scheme: light;
}
:dark .scheme-dark-fix {
  color-scheme: dark;
}

@keyframes cascadeEntry {
  0% {
    opacity: 0;
    transform: translateY(-10px) scale(0.98);
  }
  100% {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

.animate-cascade-entry {
  animation: cascadeEntry 400ms cubic-bezier(0.16, 1, 0.3, 1);
}

.modal-enter-active, .modal-leave-active {
  transition: opacity 0.25s ease, transform 0.25s ease;
}
.modal-enter-from, .modal-leave-to {
  opacity: 0;
  transform: scale(0.95);
}

.toast-enter-active {
  transition: all 0.3s ease-out;
}
.toast-leave-active {
  transition: all 0.2s ease-in;
}
.toast-enter-from {
  opacity: 0;
  transform: translateX(30px);
}
.toast-leave-to {
  opacity: 0;
}
</style>