<script setup>
import { ref, watch, onMounted, computed } from 'vue'
import { Head, router } from '@inertiajs/vue3' 
import axios from 'axios'

// Estados Reativos Centralizados
const consultoras = ref([])
const search = ref('')
const selectedConsultora = ref(null)
const displayValor = ref('')
const loadingGeral = ref(false)
const loadingId = ref(null)

const pagination = ref({ current_page: 1, last_page: 1 })
const notificacao = ref({ show: false, message: '', type: 'success' })

const anoAtual = new Date().getFullYear()
const anosDisponiveis = [anoAtual, anoAtual + 1]
const mesesLabels = ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']

// Estado do Modo Escuro
const isDark = ref(false)

const alternarModoEscuro = () => {
  isDark.value = !isDark.value
  if (isDark.value) {
    document.documentElement.classList.add('dark')
    localStorage.setItem('theme', 'dark')
  } else {
    document.documentElement.classList.remove('dark')
    localStorage.setItem('theme', 'light')
  }
}

// Estados para o Modo de Seleção
const modoSelecao = ref(false)
const selecionadasIds = ref([])
const metaMassa = ref({ valor: 0, mes: new Date().getMonth() + 1, ano: anoAtual })
const displayValorMassa = ref('')

// Estado para o Alerta de Feedback de Progresso (Foreach Rota)
const processamentoLote = ref({
  ativo: false,
  atual: 0,
  total: 0
})

const voltarPagina = () => {
  window.history.back()
}

const dispararNotificacao = (message, type = 'success') => {
  notificacao.value = { show: true, message, type }
  setTimeout(() => notificacao.value.show = false, 4000)
}

const buscarPendentes = async (page = 1) => {
  loadingGeral.value = true
  try {
    const response = await axios.get('/api/meta/pendentes', { params: { page, search: search.value } })
    
    console.log("====================================")
    console.log("1. Retorno Bruto da API (response.data):", response.data)

    const resultado = response.data?.status === 'success' ? response.data : response.data?.original;
    
    console.log("2. Resultado após a Blindagem:", resultado)

    if (resultado?.status === 'success' && resultado?.data?.data) {
      consultoras.value = resultado.data.data.map(c => ({
        ...c,
        novaMeta: { valor: 0, mes: new Date().getMonth() + 1, ano: anoAtual }
      }))

      console.log("3. Array 'consultoras' mapeado e pronto (reativo):", consultoras.value)
      console.log("====================================")

      pagination.value = { 
        current_page: resultado.data.current_page, 
        last_page: resultado.data.last_page 
      }
    } else {
      console.warn("A API respondeu, mas a estrutura de dados não é a esperada ou está vazia.")
      consultoras.value = []
    }
  } catch (error) {
    console.error("Erro na requisição de pendentes:", error)
    dispararNotificacao("Não foi possível carregar a listagem.", "error")
  } finally {
    loadingGeral.value = false
  }
}

let debounceTimer
watch(search, () => {
  clearTimeout(debounceTimer)
  debounceTimer = setTimeout(() => buscarPendentes(1), 400)
})

const formatarMoeda = (val, isMassa = false) => {
  const apenasNumeros = val.replace(/\D/g, '')
  if (!apenasNumeros) {
    if (isMassa) { displayValorMassa.value = ''; metaMassa.value.valor = 0 }
    else { displayValor.value = ''; if (selectedConsultora.value) selectedConsultora.value.novaMeta.valor = 0 }
    return
  }
  
  const numeroFlutuante = parseFloat(apenasNumeros) / 100
  const valorFormatado = new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2 }).format(numeroFlutuante)
  
  if (isMassa) {
    displayValorMassa.value = valorFormatado
    metaMassa.value.valor = numeroFlutuante
  } else {
    displayValor.value = valorFormatado
    if (selectedConsultora.value) selectedConsultora.value.novaMeta.valor = numeroFlutuante
  }
}

const lidarComCliqueLinha = (c) => {
  if (modoSelecao.value) {
    alternarSelecao(c.id)
  } else {
    selecionarConsultora(c)
  }
}

const selecionarConsultora = (c) => {
  if (selectedConsultora.value?.id === c.id) {
    selectedConsultora.value = null
  } else {
    selectedConsultora.value = c
    displayValor.value = c.novaMeta.valor > 0 ? c.novaMeta.valor.toLocaleString('pt-BR', { minimumFractionDigits: 2 }) : ''
  }
}

const alternarSelecao = (id) => {
  const index = selecionadasIds.value.indexOf(id)
  if (index > -1) {
    selecionadasIds.value.splice(index, 1)
  } else {
    selecionadasIds.value.push(id)
  }
}

const alternarTodosDaPagina = () => {
  const todosIdsPagina = consultoras.value.map(c => c.id)
  const todosSelecionados = todosIdsPagina.every(id => selecionadasIds.value.includes(id))

  if (todosSelecionados) {
    selecionadasIds.value = selecionadasIds.value.filter(id => !todosIdsPagina.includes(id))
  } else {
    todosIdsPagina.forEach(id => {
      if (!selecionadasIds.value.includes(id)) selecionadasIds.value.push(id)
    })
  }
}

const todosDaPaginaEstaoSelecionados = computed(() => {
  if (!consultoras.value.length) return false
  return consultoras.value.map(c => c.id).every(id => selecionadasIds.value.includes(id))
})

const activarModoSelecao = () => {
  console.log("Botão de Seleção Múltipla Clicado! Estado anterior de modoSelecao:", modoSelecao.value)
  selectedConsultora.value = null
  modoSelecao.value = !modoSelecao.value
  if (!modoSelecao.value) selecionadasIds.value = []
  console.log("Novo estado de modoSelecao:", modoSelecao.value)
}

const mudarPagina = (page) => {
  if (page >= 1 && page <= pagination.value.last_page) {
    selectedConsultora.value = null
    buscarPendentes(page)
  }
}

const salvarMeta = async (consultora) => {
  if (!consultora.novaMeta.valor) return dispararNotificacao("Por favor, digite um valor maior que R$ 0,00.", "error")

  loadingId.value = consultora.id
  const dataRef = `${consultora.novaMeta.ano}-${String(consultora.novaMeta.mes).padStart(2, '0')}`

  try {
    const { data } = await axios.post(`/api/meta/atribuir/${consultora.id}`, {
      valor_meta: consultora.novaMeta.valor,
      data_referencia: dataRef
    })

    if (['success', 'sucesso'].includes(data?.status)) {
      dispararNotificacao(data.mensagem || `Meta de ${consultora.nome} definida!`)
      
      const index = consultoras.value.findIndex(u => u.id === consultora.id)
      if (index !== -1) {
        consultoras.value[index].status_meta = 'Definida'
      }

      selectedConsultora.value = displayValor.value = null
    }
  } catch (error) {
    dispararNotificacao(error.response?.data?.mensagem || "Falha ao salvar o objetivo.", "error")
  } finally {
    loadingId.value = null
  }
}

const dispararProcessamentoEmLote = async () => {
  if (!metaMassa.value.valor) return dispararNotificacao("Defina um valor válido para o grupo selecionado.", "error")
  if (selecionadasIds.value.length === 0) return dispararNotificacao("Selecione ao menos uma consultora.", "error")

  const totalParaProcessar = selecionadasIds.value.length
  const dataRef = `${metaMassa.value.ano}-${String(metaMassa.value.mes).padStart(2, '0')}`

  processamentoLote.value = { ativo: true, atual: 0, total: totalParaProcessar }

  for (const id of selecionadasIds.value) {
    try {
      await axios.post(`/api/meta/atribuir/${id}`, {
        valor_meta: metaMassa.value.valor,
        data_referencia: dataRef
      })
    } catch (e) {
      console.error(`Erro ao salvar ID: ${id}`, e.response?.data || e.message)
    }
    processamentoLote.value.atual++
  }

  setTimeout(() => {
    processamentoLote.value.ativo = false
    dispararNotificacao(`Metas aplicadas com sucesso para ${totalParaProcessar} consultoras!`)
    modoSelecao.value = false
    selecionadasIds.value = []
    buscarPendentes(pagination.value.current_page)
  }, 600)
}

onMounted(() => {
  buscarPendentes()
  // Recupera o tema salvo ou respeita a preferência do sistema operacional
  const savedTheme = localStorage.getItem('theme')
  if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    isDark.value = true
    document.documentElement.classList.add('dark')
  }
})
</script>


<template>
  <Head title="Definir Metas da Rede - GlowBiz" />

  <div class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased font-sans pb-16 relative transition-colors duration-300">
    
    <Transition name="fade">
      <div v-if="processamentoLote.ativo" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-[200] flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-8 max-w-sm w-full text-center shadow-2xl border border-slate-100 dark:border-slate-800 flex flex-col items-center">
          <div class="relative flex items-center justify-center mb-5">
            <div class="w-16 h-16 border-4 border-slate-100 dark:border-slate-800 border-t-blue-600 rounded-full animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center text-xs font-black text-slate-700 dark:text-slate-300">
              {{ Math.round((processamentoLote.atual / processamentoLote.total) * 100) }}%
            </div>
          </div>
          <h3 class="text-base font-bold text-slate-800 dark:text-slate-200 tracking-tight">Salvando Metas de Rede</h3>
          <p class="text-xs text-slate-400 dark:text-slate-500 mt-1 mb-4">Por favor, não feche a página até concluir o envio.</p>
          <div class="bg-slate-50 dark:bg-slate-950 px-4 py-2 rounded-xl border border-slate-100 dark:border-slate-800 text-xs font-bold text-slate-600 dark:text-slate-400 font-mono">
            Adicionados: {{ processamentoLote.atual }} / {{ processamentoLote.total }}
          </div>
        </div>
      </div>
    </Transition>

    <Transition name="toast">
      <div v-if="notificacao.show" class="fixed top-6 right-6 z-[100] max-w-md pointer-events-auto">
        <div 
          class="px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 border-l-4 transition-all"
          :class="notificacao.type === 'success' ? 'bg-slate-900 dark:bg-slate-800 border-[#FFD700] text-white' : 'bg-rose-950 border-rose-500 text-rose-100'"
        >
          <div class="rounded-full p-1.5 shrink-0" :class="notificacao.type === 'success' ? 'bg-[#FFD700]' : 'bg-rose-500'">
            <svg class="w-4 h-4" :class="notificacao.type === 'success' ? 'text-slate-900' : 'text-white'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path v-if="notificacao.type === 'success'" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </div>
          <div>
            <p class="text-[10px] font-bold uppercase tracking-widest opacity-60">{{ notificacao.type === 'success' ? 'Sucesso' : 'Atenção' }}</p>
            <p class="text-xs font-bold">{{ notificacao.message }}</p>
          </div>
        </div>
      </div>
    </Transition>

    <nav class="bg-[#2C3E50] dark:bg-slate-900 text-white p-4 shadow-md flex justify-between items-center px-4 md:px-8 border-b border-[#FFD700]/10 sticky top-0 z-50 transition-colors duration-300">
      <div class="flex items-center gap-3">
        <span class="text-xl md:text-2xl font-black tracking-widest uppercase font-serif">Glow<span class="text-[#FFD700] lowercase italic font-light text-sm ml-0.5">biz</span></span>
        <span class="hidden sm:block text-slate-500 dark:text-slate-600 font-light ml-2">|</span>
        <span class="hidden sm:block text-xs font-bold uppercase tracking-widest text-slate-300 dark:text-slate-400">Gestão de Performance</span>
      </div>
      <div class="flex items-center gap-3">
        <button @click="alternarModoEscuro" class="p-2 bg-slate-800/40 hover:bg-slate-700/60 border border-slate-600 rounded-xl transition-all text-[#FFD700]" title="Alternar Tema">
          <svg v-if="isDark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M16.243 17.657l.707.707M7.757 6.343l.707-.707M14.142 14.142a5 5 0 11-7.071-7.071 5 5 0 017.071 7.071z"/></svg>
          <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
        </button>

        <button @click="voltarPagina" class="flex items-center gap-2 bg-slate-800/40 hover:bg-slate-700/60 border border-slate-600 px-4 py-2 rounded-xl transition-all text-xs font-bold uppercase tracking-widest">
          <svg class="w-4 h-4 text-[#FFD700]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
          Voltar
        </button>
      </div>
    </nav>

    <div class="p-4 md:p-8 max-w-[1100px] mx-auto">
      
      <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
          <div class="flex items-center gap-2.5 mb-1.5">
            <div class="h-4 w-1 bg-[#2C3E50] dark:bg-[#FFD700] rounded-full"></div>
            <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Planejamento de Vendas</span>
          </div>
          <h2 class="text-3xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">Estipular Metas de Rede</h2>
        </div>

        <div class="relative w-full md:w-80 group">
          <input type="text" v-model="search" placeholder="Buscar por consultora..." class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl py-3 pl-5 pr-12 font-semibold text-sm text-slate-800 dark:text-slate-200 outline-none focus:border-slate-400 dark:focus:border-slate-600 transition-all shadow-sm">
          <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center gap-1.5">
            <button v-if="search" @click="search = ''" class="text-slate-400 hover:text-rose-500 p-0.5 rounded transition-colors">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden transition-all duration-300" :class="selectedConsultora || modoSelecao ? 'lg:col-span-6' : 'lg:col-span-12'">
          
          <div class="p-4 bg-slate-50/50 dark:bg-slate-950/40 border-b border-slate-100 dark:border-slate-800/60 flex justify-between items-center">
            <div class="flex items-center gap-2">
              <input 
                type="checkbox" 
                v-if="modoSelecao" 
                :checked="todosDaPaginaEstaoSelecionados" 
                @change="alternarTodosDaPagina"
                class="w-4 h-4 accent-blue-600 dark:accent-[#FFD700] rounded cursor-pointer"
              >
              <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                {{ modoSelecao ? `${selecionadasIds.length} selecionadas no total` : 'Integrantes da Equipe' }}
              </span>
            </div>
            
            <button 
              @click="activarModoSelecao" 
              type="button"
              class="text-xs font-bold flex items-center gap-1.5 transition-colors p-2 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700"
              :class="modoSelecao ? 'text-rose-600 dark:text-rose-400' : 'text-blue-600 dark:text-[#FFD700]'"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
              {{ modoSelecao ? 'Cancelar Seleção' : 'Selecionar Múltiplos' }}
            </button>
          </div>

          <div v-if="!loadingGeral && consultoras.length > 0">
            <div class="max-h-[500px] overflow-y-auto custom-scroll divide-y divide-slate-100 dark:divide-slate-800/60">
              <div 
                v-for="c in consultoras" :key="c.id" @click="lidarComCliqueLinha(c)" 
                class="grid grid-cols-12 px-6 py-4 items-center cursor-pointer hover:bg-slate-50/60 dark:hover:bg-slate-950/40 transition-all border-l-4"
                :class="selectedConsultora?.id === c.id || selecionadasIds.includes(c.id) ? 'bg-slate-50 dark:bg-slate-800/40 border-l-slate-700 dark:border-l-[#FFD700] selected-shadow' : 'border-l-transparent'"
              >
                <div v-if="modoSelecao" class="col-span-1 flex items-center justify-center" @click.stop>
                  <input 
                    type="checkbox" 
                    :id="'check-' + c.id"
                    :value="c.id" 
                    v-model="selecionadasIds" 
                    @click.stop
                    class="w-4 h-4 accent-slate-800 dark:accent-[#FFD700] rounded cursor-pointer z-10"
                  >
                </div>

                <div :class="modoSelecao ? 'col-span-8' : 'col-span-9'" class="flex items-center gap-4">
                  <img :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(c.nome)}&background=2C3E50&color=FFD700&bold=true`" class="w-9 h-9 rounded-xl border border-slate-100 dark:border-slate-800 object-cover shadow-sm shrink-0" alt="Consultora">
                  <div class="truncate">
                    <h4 class="font-bold text-slate-700 dark:text-slate-300 text-sm tracking-tight truncate">{{ c.nome }}</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-mono">ID: #{{ c.id }}</p>
                  </div>
                </div>
                
                <div class="col-span-3 text-right">
                  <span 
                    class="text-[9px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider border transition-colors"
                    :class="c.status_meta === 'Pendente' 
                      ? 'bg-amber-50 dark:bg-amber-950/30 text-amber-700 dark:text-amber-400 border-amber-200/40 dark:border-amber-900/50' 
                      : 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-700 dark:text-emerald-400 border-emerald-200/40 dark:border-emerald-900/50'"
                  >
                    {{ c.status_meta || 'Pendente' }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <div v-if="!loadingGeral && consultoras.length === 0" class="p-14 text-center">
            <div class="relative mb-4 flex justify-center text-slate-300 dark:text-slate-700">
              <svg class="w-16 h-16 rocket-float" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.71.73-1.35.73-1.35s-.64.02-1.35.73c-1.26 1.5-5 2-5 2s.5-3.74 2-5c.71-.71 1.35-.73 1.35-.73s-.02.64-.73 1.35Z"/><path d="M15 7s-1.5-1.5-3-1.5-4.5 1.5-4.5 1.5l1.5 6h6L15 7Z"/>
              </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-700 dark:text-slate-300 uppercase tracking-tight mb-1">{{ search ? 'Nenhuma consultora encontrada' : 'Nenhuma consultora na equipe' }}</h3>
            <p class="max-w-xs mx-auto text-slate-400 dark:text-slate-500 font-medium text-xs leading-relaxed">{{ search ? 'Revise os termos digitados ou limpe o campo de busca.' : 'Não existem consultoras vinculadas diretamente a você neste momento.' }}</p>
            <button @click="search ? search = '' : buscarPendentes(1)" class="mt-4 px-4 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all">{{ search ? 'Limpar Filtro' : 'Atualizar Lista' }}</button>
          </div>

          <div v-if="loadingGeral" class="p-20 flex flex-col items-center justify-center">
            <div class="w-8 h-8 border-4 border-slate-200 dark:border-slate-800 border-t-slate-700 dark:border-t-slate-400 rounded-full animate-spin"></div>
          </div>
        </div>

        <div class="lg:col-span-6 w-full sticky top-24">
          <Transition name="form-fade" mode="out-in">
            
            <div v-if="selectedConsultora" class="bg-white dark:bg-slate-900 rounded-2xl p-6 md:p-8 shadow-sm border border-slate-200 dark:border-slate-800 relative text-slate-800 dark:text-slate-200">
              <div class="flex justify-between items-start mb-6">
                <div class="flex items-center gap-3.5">
                  <img :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(selectedConsultora.nome)}&background=2C3E50&color=FFD700&bold=true`" class="w-11 h-11 rounded-xl object-cover shadow-inner shrink-0" alt="Selecionada">
                  <div>
                    <span class="text-slate-400 dark:text-slate-500 font-bold text-[9px] uppercase tracking-wider block mb-0.5">Definição de Objetivo</span>
                    <h3 class="font-bold text-lg text-slate-800 dark:text-slate-100 tracking-tight leading-tight max-w-[200px] md:max-w-xs truncate">{{ selectedConsultora.nome }}</h3>
                  </div>
                </div>
                <button @click="selectedConsultora = null" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 bg-slate-50 dark:bg-slate-950 p-2 rounded-xl transition-all">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
              </div>

              <div class="space-y-5">
                <div>
                  <label class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 block">Volume de Vendas Target</label>
                  <div class="relative">
                    <span class="absolute left-5 top-1/2 -translate-y-1/2 font-bold text-slate-400 dark:text-slate-500 text-lg select-none">R$</span>
                    <input type="text" :value="displayValor" @input="formatarMoeda($event.target.value)" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 focus:border-slate-400 dark:focus:border-slate-600 rounded-xl py-3.5 pl-14 pr-6 font-black text-slate-800 dark:text-slate-100 text-2xl outline-none transition-all" placeholder="0,00">
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 block">Mês de Vigência</label>
                    <select v-model="selectedConsultora.novaMeta.mes" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 focus:border-slate-400 dark:focus:border-slate-600 rounded-xl p-3.5 font-bold text-slate-700 dark:text-slate-300 text-sm outline-none transition-all h-[50px]">
                      <option v-for="m in 12" :key="m" :value="m" class="dark:bg-slate-900">{{ m.toString().padStart(2, '0') }} - {{ mesesLabels[m-1] }}</option>
                    </select>
                  </div>

                  <div>
                    <label class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2 block">Ano Vigência</label>
                    <select v-model="selectedConsultora.novaMeta.ano" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 focus:border-slate-400 dark:focus:border-slate-600 rounded-xl p-3.5 font-bold text-slate-700 dark:text-slate-300 text-sm outline-none transition-all h-[50px]">
                      <option v-for="ano in anosDisponiveis" :key="ano" :value="ano" class="dark:bg-slate-900">{{ ano }}</option>
                    </select>
                  </div>
                </div>

                <div class="pt-2">
                  <button @click="salvarMeta(selectedConsultora)" :disabled="loadingId === selectedConsultora.id" class="w-full bg-[#2C3E50] hover:bg-[#1a252f] dark:bg-slate-800 dark:hover:bg-slate-700 text-white py-3.5 rounded-xl font-bold text-xs uppercase tracking-widest transition-all shadow-sm">
                    <span v-if="loadingId !== selectedConsultora.id">
                      {{ selectedConsultora.status_meta === 'Definida' ? 'Atualizar Objetivo' : 'Confirmar Objetivo' }}
                    </span>
                    <div v-else class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin mx-auto"></div>
                  </button>
                </div>
              </div>
            </div>

            <div v-else-if="modoSelecao" class="bg-gradient-to-br from-slate-900 to-slate-800 dark:from-slate-950 dark:to-slate-900 rounded-2xl p-6 md:p-8 shadow-xl border dark:border-slate-800 text-white">
              <div class="flex justify-between items-start mb-6">
                <div>
                  <span class="text-[#FFD700] font-bold text-[9px] uppercase tracking-wider block mb-0.5">Atribuição de Lote Personalizado</span>
                  <h3 class="font-bold text-lg tracking-tight leading-tight">Definir Selecionadas</h3>
                  <p class="text-[11px] text-slate-400 mt-1">Insira a meta para os <span class="text-[#FFD700] font-black">{{ selecionadasIds.length }}</span> perfis que você marcou.</p>
                </div>
              </div>

              <div class="space-y-5">
                <div>
                  <label class="text-[11px] font-bold text-slate-300 uppercase tracking-wider mb-2 block">Valor Unitário das Metas</label>
                  <div class="relative">
                    <span class="absolute left-5 top-1/2 -translate-y-1/2 font-bold text-slate-500 text-lg select-none">R$</span>
                    <input type="text" :value="displayValorMassa" @input="formatarMoeda($event.target.value, true)" class="w-full bg-slate-950 border border-slate-700 focus:border-[#FFD700] rounded-xl py-3.5 pl-14 pr-6 font-black text-white text-2xl outline-none transition-all" placeholder="0,00">
                  </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="text-[11px] font-bold text-slate-300 uppercase tracking-wider mb-2 block">Mês Vigência</label>
                    <select v-model="metaMassa.mes" class="w-full bg-slate-950 border border-slate-700 focus:border-[#FFD700] rounded-xl p-3.5 font-bold text-slate-200 text-sm outline-none transition-all h-[50px]">
                      <option v-for="m in 12" :key="m" :value="m" class="bg-slate-900">{{ m.toString().padStart(2, '0') }} - {{ mesesLabels[m-1] }}</option>
                    </select>
                  </div>

                  <div>
                    <label class="text-[11px] font-bold text-slate-300 uppercase tracking-wider mb-2 block">Ano Vigência</label>
                    <select v-model="metaMassa.ano" class="w-full bg-slate-950 border border-slate-700 focus:border-[#FFD700] rounded-xl p-3.5 font-bold text-slate-200 text-sm outline-none transition-all h-[50px]">
                      <option v-for="ano in anosDisponiveis" :key="ano" :value="ano" class="bg-slate-900">{{ ano }}</option>
                    </select>
                  </div>
                </div>

                <div class="pt-2">
                  <button 
                    @click="dispararProcessamentoEmLote" 
                    :disabled="selecionadasIds.length === 0"
                    class="w-full bg-[#FFD700] hover:bg-[#ffe02e] disabled:bg-slate-700 disabled:text-slate-400 text-slate-900 py-3.5 rounded-xl font-bold text-xs uppercase tracking-widest transition-all shadow-md"
                  >
                    Salvar para as {{ selecionadasIds.length }} Selecionadas
                  </button>
                </div>
              </div>
            </div>

          </Transition>
        </div>

      </div>

      <div v-if="pagination.last_page > 1 && consultoras.length > 0 && !selectedConsultora" class="mt-8 flex items-center justify-center gap-4">
        <button @click="mudarPagina(pagination.current_page - 1)" :disabled="pagination.current_page === 1" class="p-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm disabled:opacity-30 transition-all">
          <svg class="w-4 h-4 text-slate-700 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Página {{ pagination.current_page }} de {{ pagination.last_page }}</span>
        <button @click="mudarPagina(pagination.current_page + 1)" :disabled="pagination.current_page === pagination.last_page" class="p-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-sm disabled:opacity-30 transition-all">
          <svg class="w-4 h-4 text-slate-700 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
        </button>
      </div>
      
    </div>
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@900&display=swap');

.font-serif { font-family: 'Playfair Display', serif; }
.selected-shadow { box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.01); }
.rocket-float { animation: float 4s ease-in-out infinite; }

@keyframes float {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-6px); }
}

.toast-enter-active { animation: slideInRight 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
.toast-leave-active { transition: opacity 0.2s ease; }
.toast-leave-to { opacity: 0; }

@keyframes slideInRight {
  from { transform: translateX(20px); opacity: 0; }
  to { transform: translateX(0); opacity: 1; }
}

.form-fade-enter-active, .form-fade-leave-active { transition: all 0.2s ease-in-out; }
.form-fade-enter-from, .form-fade-leave-to { opacity: 0; transform: translateY(8px); }

.fade-enter-active, .fade-leave-active { transition: opacity 0.25s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }

.custom-scroll::-webkit-scrollbar { width: 4px; }
.custom-scroll::-webkit-scrollbar-track { background: transparent; }
.custom-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
.dark .custom-scroll::-webkit-scrollbar-thumb { background: #334155; }
.custom-scroll::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
.dark .custom-scroll::-webkit-scrollbar-thumb:hover { background: #475569; }
</style>