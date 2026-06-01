<script setup>
import { ref, computed, watch, onMounted, nextTick } from 'vue'
import { Head, usePage } from '@inertiajs/vue3'
import axios from 'axios'
import Sidebar from '@/Components/Sidebar.vue'

// --- ESTADO DO LAYOUT ---
const sidebarCollapsed = ref(false)

// --- ESTADO REATIVO DOS PEDIDOS ---
const search = ref('')
const pedidos = ref([])
const notificacoes = ref([])
const paginaAtual = ref(1)
const itensPorPagina = ref(5) 

const modalAberto = ref(false)
const confirmacaoAberta = ref(false)
const modo = ref('visualizar') 
const pedidoEditavel = ref(null)

const catalogos = ref(['Glow Outono/Inverno', 'Skincare Pro', 'Perfumaria'])
const loading = ref(false)

// --- ESTADO DO SWIPE MOBILE LUXUOSO ---
const swipeTrack = ref(null)
const swipeStartX = ref(0)
const swipeTranslateX = ref(0)
const isSwiping = ref(false)
const swipeCompleted = ref(false)
const maxSwipeDistance = ref(200)

// --- METADADOS DO INERTIA ---
const csrfToken = computed(() => usePage().props.csrf_token)

// --- GETTERS COMPUTED ---
const pedidosFiltrados = computed(() => {
  if (!search.value) return pedidos.value
  const termo = search.value.toLowerCase()
  return pedidos.value.filter(p => 
    p.id.toString().includes(termo) || 
    (p.nome && p.nome.toLowerCase().includes(termo))
  )
})

const totalPaginas = computed(() => {
  return Math.ceil(pedidosFiltrados.value.length / itensPorPagina.value) || 1
})

const pedidosPaginados = computed(() => {
  const inicio = (paginaAtual.value - 1) * itensPorPagina.value
  return pedidosFiltrados.value.slice(inicio, itensPorPagina.value + inicio)
})

watch(search, () => {
  paginaAtual.value = 1
})

// --- MÉTODOS DE TOUCH AVANÇADOS (SWIPE TO CANCEL) ---
const calcularDistanciaMaxima = () => {
  if (swipeTrack.value) {
    maxSwipeDistance.value = swipeTrack.value.clientWidth - 56
  }
}

const onTouchStart = (e) => {
  if (swipeCompleted.value) return
  calcularDistanciaMaxima()
  swipeStartX.value = e.touches[0].clientX
  isSwiping.value = true
}

const onTouchMove = (e) => {
  if (!isSwiping.value || swipeCompleted.value) return
  const currentX = e.touches[0].clientX
  const diff = currentX - swipeStartX.value
  
  if (diff >= 0 && diff <= maxSwipeDistance.value) {
    swipeTranslateX.value = diff
  }
}

const onTouchEnd = () => {
  if (!isSwiping.value) return
  isSwiping.value = false
  
  if (swipeTranslateX.value >= maxSwipeDistance.value * 0.80) {
    swipeTranslateX.value = maxSwipeDistance.value
    swipeCompleted.value = true
    confirmarCancelamento()
  } else {
    swipeTranslateX.value = 0
  }
}

const textOpacity = computed(() => {
  return Math.max(1 - (swipeTranslateX.value / (maxSwipeDistance.value * 0.5)), 0)
})

// --- MÉTODOS DE NEGÓCIO ---
const buscarPedidos = async () => {
  loading.value = true
  try {
    const response = await axios.get('/api/lider/equipe/pedidos')
    pedidos.value = response.data
  } catch (error) {
    notificar('Erro', 'Falha ao carregar a rede de pedidos.', 'erro')
  } finally {
    loading.value = false
  }
}

const abrirDetalhes = async (pedidoSimplificado) => {
  swipeTranslateX.value = 0
  swipeCompleted.value = false
  
  try {
    const response = await axios.get(`/api/pedido/${pedidoSimplificado.id}`)
    const dados = response.data?.data

    if (dados) {
      pedidoEditavel.value = {
        id: dados.id,
        nome: dados.consultora?.nome || pedidoSimplificado.nome || 'Consultora Não Informada', 
        cliente: dados.clientes?.nome || 'Cliente Não Informado', 
        pagamento: dados.tipo_pagamento || 'Não definido',
        status_nome: dados.status?.nome || pedidoSimplificado.status || 'Pendente',
        status_id: dados.status_id || null,
        itens: dados.itens_pedidos ? dados.itens_pedidos.map(item => ({
          id: item.id || null,
          item_catalogo_id: item.item_catalogo_id || null,
          produto: item.item_catalogo?.produto?.nome || 'Produto Indisponível',
          qtd: parseInt(item.quantidade || 1),
          preco: parseFloat(item.preco_unitario || 0)
        })) : []
      }

      modo.value = 'visualizar'
      modalAberto.value = true
      
      nextTick(() => {
        calcularDistanciaMaxima()
      })
    } else {
      notificar('Erro', 'Formato de resposta do servidor inválido.', 'erro')
    }
  } catch (error) {
    console.error("Erro ao detalhar pedido:", error)
    notificar('Erro', 'Não foi possível carregar os itens.', 'erro')
  }
}

const confirmarCancelamento = async () => {
  try {
    const response = await axios.delete(`/api/pedido/${pedidoEditavel.value.id}`)
    const result = response.data

    if (result.status === 'sucesso') {
      pedidos.value = pedidos.value.filter(p => p.id !== pedidoEditavel.value.id)
      notificar('Sucesso', result.mensagem, 'sucesso')
      fecharModal()
    } else {
      let msgFormatada = (result.mensagem || '').replace('erro ao cancelar: ', '')
      let titulo = msgFormatada.includes('ja foi cancelado') ? 'Aviso de Status' : 'Bloqueio'
      
      notificar(titulo, msgFormatada, 'erro')
      confirmacaoAberta.value = false
      swipeTranslateX.value = 0
      swipeCompleted.value = false
    }
  } catch (error) {
    notificar('Erro Crítico', 'Não foi possível se comunicar com o servidor.', 'erro')
    swipeTranslateX.value = 0
    swipeCompleted.value = false
  }
}

const salvarEdicao = async () => {
  try {
    const payload = {
      itens: pedidoEditavel.value.itens.map(i => ({
        item_catalogo_id: i.item_catalogo_id,
        quantidade: i.qtd,
        preco_unitario: i.preco
      })),
      valor_total: calcularTotal()
    }

    const response = await axios.put(`/api/pedido/${pedidoEditavel.value.id}`, payload)

    if (response.status === 200) {
      await buscarPedidos()
      notificar('Salvo!', 'Pedido updated com sucesso.')
      fecharModal()
    }
  } catch (error) {
    notificar('Erro', error.response?.data?.mensagem || 'Erro ao salvar alterações.', 'erro')
  }
}

const notificar = (titulo, message, tipo = 'sucesso') => {
  const id = Date.now()
  notificacoes.value.push({ id, titulo, mensagem: message, tipo })
  setTimeout(() => {
    notificacoes.value = notificacoes.value.filter(n => n.id !== id)
  }, 4000)
}

const fecharModal = () => {
  modalAberto.value = false
  confirmacaoAberta.value = false
  pedidoEditavel.value = null
  modo.value = 'visualizar'
}

const formatarMoeda = (valor) => {
  return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor)
}

const calcularTotal = () => {
  return pedidoEditavel.value ? pedidoEditavel.value.itens.reduce((sum, i) => sum + (i.preco * i.qtd), 0) : 0
}

const obterIniciais = (nome) => {
  if (!nome) return 'CS'
  return nome.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase()
}

const statusEstilos = (status) => {
  const s = typeof status === 'string' ? status.toLowerCase() : ''
  if (s.includes('cancel')) return 'bg-red-50 text-red-600 border-red-100 dark:bg-red-950/30 dark:text-red-400 dark:border-red-900/50'
  if (s.includes('pago') || s.includes('enviado') || s.includes('entregue')) return 'bg-emerald-50 text-emerald-600 border-emerald-100 dark:bg-emerald-950/30 dark:text-emerald-400 dark:border-emerald-900/50'
  return 'bg-amber-50 text-amber-600 border-amber-100 dark:bg-amber-950/30 dark:text-amber-400 dark:border-amber-900/50'
}

const removerItem = (index) => {
  pedidoEditavel.value.itens.splice(index, 1)
}

const paginaAnterior = () => { if (paginaAtual.value > 1) paginaAtual.value-- }
const proximaPagina = () => { if (paginaAtual.value < totalPaginas.value) paginaAtual.value++ }

onMounted(() => {
  buscarPedidos()
})
</script>

<template>
  <Head title="Pedidos da Equipe - Glow Cosmetics" />

  <div class="relative min-h-screen bg-gradient-to-br from-[#FFF8FA] to-[#FFF1F4] dark:from-slate-900 dark:to-slate-950 font-sans text-[#2C3E50] dark:text-slate-100 antialiased transition-colors duration-300">
    
    <div class="flex min-h-screen">
      <Sidebar :collapsed="sidebarCollapsed" @toggle="sidebarCollapsed = !sidebarCollapsed" />

      <main 
        class="flex-1 p-4 pb-28 transition-all duration-300 md:p-8"
        :class="sidebarCollapsed ? 'md:ml-24' : 'md:ml-[18rem]'"
      >
        
        <!-- Notificações Toast -->
        <div aria-live="assertive" class="fixed inset-0 flex items-start px-4 py-6 pointer-events-none sm:p-6 sm:items-start z-[100]">
          <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
            <transition-group name="fade">
              <div v-for="notificacao in notificacoes" :key="notificacao.id"
                   class="max-w-sm w-full bg-white/95 dark:bg-slate-900/95 backdrop-blur shadow-2xl rounded-2xl pointer-events-auto border-l-4 p-4 transition-all duration-300 ring-1 ring-black/5 dark:ring-slate-800"
                   :class="notificacao.tipo === 'erro' ? 'border-red-500' : 'border-emerald-500'">
                <div class="flex items-start">
                  <div class="ml-1 w-0 flex-1">
                    <p class="text-sm font-bold text-gray-950 dark:text-white">{{ notificacao.titulo }}</p>
                    <p class="mt-0.5 text-xs text-gray-500 dark:text-slate-400">{{ notificacao.mensagem }}</p>
                  </div>
                </div>
              </div>
            </transition-group>
          </div>
        </div>

        <div class="max-w-6xl mx-auto">
          
          <header class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
              <h1 class="text-3xl font-extrabold tracking-tight font-serif text-[#2C3E50] dark:text-white">Gestão de Pedidos</h1>
              <p class="text-sm text-gray-500 dark:text-slate-400 font-medium mt-1">Gerencie as requisições e a produtividade das consultoras da sua rede.</p>
            </div>
            <div class="relative w-full sm:max-w-xs">
              <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400 dark:text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
              </span>
              <input 
                v-model="search"
                type="text" 
                placeholder="Buscar por Consultora ou ID..." 
                class="w-full pl-10 pr-4 py-3 bg-white dark:bg-slate-950 border border-gray-200 dark:border-slate-800 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-[#E67E73]/30 dark:focus:ring-amber-500/30 focus:border-[#E67E73] dark:focus:border-amber-500 text-sm text-slate-800 dark:text-slate-200 transition-all placeholder:text-gray-400 dark:placeholder:text-slate-600"
              >
            </div>
          </header>

          <!-- Loading State -->
          <div v-if="loading" class="flex flex-col items-center justify-center py-24 bg-white dark:bg-slate-950 rounded-3xl border border-pink-100/50 dark:border-slate-800 shadow-sm">
            <div class="w-10 h-10 border-4 border-slate-100 dark:border-slate-900 border-t-[#E67E73] dark:border-t-amber-500 rounded-full animate-spin mb-4"></div>
            <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-widest">Sincronizando com a rede Glow...</p>
          </div>

          <div v-else>
            
            <!-- Desktop Table View -->
            <div class="hidden md:block bg-white dark:bg-slate-950 rounded-3xl border border-pink-100/60 dark:border-slate-800 shadow-sm overflow-hidden">
              <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                  <thead>
                    <tr class="bg-slate-50/70 dark:bg-slate-900/40 border-b border-gray-100 dark:border-slate-800/80">
                      <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-slate-500">ID Pedido</th>
                      <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-slate-500">Consultora</th>
                      <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-slate-500">Status</th>
                      <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-slate-500 text-right">Ações</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-50 dark:divide-slate-900">
                    <tr v-for="pedido in pedidosPaginados" :key="pedido.id" class="hover:bg-[#FFFDFE]/60 dark:hover:bg-slate-900/30 transition-colors">
                      <td class="px-6 py-4 font-mono text-xs font-bold text-gray-400 dark:text-slate-500">#{{ pedido.id }}</td>
                      <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                          <div class="w-8 h-8 rounded-full bg-[#E67E73]/10 dark:bg-[#E67E73]/20 text-[#E67E73] dark:text-orange-400 flex items-center justify-center font-bold text-xs">
                            {{ obterIniciais(pedido.nome) }}
                          </div>
                          <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ pedido.nome || 'Consultora Desconhecida' }}</span>
                        </div>
                      </td>
                      <td class="px-6 py-4">
                        <span class="inline-flex px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-xl border" :class="statusEstilos(pedido.status)">
                          {{ pedido.status || 'Pendente' }}
                        </span>
                      </td>
                      <td class="px-6 py-4 text-right">
                        <button 
                          @click="abrirDetalhes(pedido)"
                          class="px-4 py-2 bg-[#2C3E50] dark:bg-slate-900 text-white text-[10px] font-bold uppercase tracking-widest rounded-xl hover:bg-[#1a252f] dark:hover:bg-slate-800 border dark:border-slate-700 shadow-sm transition-all active:scale-95"
                        >
                          Ver Detalhes
                        </button>
                      </td>
                    </tr>
                    <tr v-if="pedidosFiltrados.length === 0">
                      <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-400 dark:text-slate-500 italic">
                        Nenhum pedido localizado nesta listagem.
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Mobile Card View -->
            <div class="block md:hidden space-y-4">
              <div 
                v-for="pedido in pedidosPaginados" 
                :key="pedido.id"
                class="bg-white dark:bg-slate-950 rounded-2xl p-5 border border-pink-100/50 dark:border-slate-800 shadow-sm flex flex-col gap-4 relative overflow-hidden"
              >
                <div class="flex items-center justify-between">
                  <span class="font-mono text-xs font-bold text-gray-400 dark:text-slate-500">#{{ pedido.id }}</span>
                  <span class="inline-flex px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-lg border" :class="statusEstilos(pedido.status)">
                    {{ pedido.status || 'Pendente' }}
                  </span>
                </div>
                
                <div class="flex items-center gap-3 bg-slate-50/60 dark:bg-slate-900/60 p-2 rounded-xl">
                  <div class="w-9 h-9 rounded-full bg-[#E67E73]/10 dark:bg-[#E67E73]/20 text-[#E67E73] dark:text-orange-400 flex items-center justify-center font-bold text-xs shrink-0">
                    {{ obterIniciais(pedido.nome) }}
                  </div>
                  <div>
                    <span class="text-[10px] text-gray-400 dark:text-slate-500 block font-bold uppercase tracking-wide">Consultora</span>
                    <span class="text-sm font-bold text-slate-800 dark:text-slate-200 line-clamp-1">{{ pedido.nome || 'Desconhecida' }}</span>
                  </div>
                </div>

                <button 
                  @click="abrirDetalhes(pedido)"
                  class="w-full py-3 bg-[#2C3E50] dark:bg-slate-900 text-white text-center text-xs font-bold uppercase tracking-widest rounded-xl border dark:border-slate-700 transition-all active:bg-[#1a252f] dark:active:bg-slate-800"
                >
                  Analisar Pedido
                </button>
              </div>

              <div v-if="pedidosFiltrados.length === 0" class="text-center bg-white dark:bg-slate-950 rounded-2xl p-10 border border-gray-100 dark:border-slate-800 text-sm text-gray-400 dark:text-slate-500 italic">
                Nenhum pedido localizado.
              </div>
            </div>

            <!-- Paginação -->
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4" v-if="totalPaginas > 1">
              <p class="text-xs text-gray-400 dark:text-slate-500 font-medium order-2 sm:order-1">
                Exibindo página <span class="text-slate-700 dark:text-slate-300 font-bold">{{ paginaAtual }}</span> de <span class="text-slate-700 dark:text-slate-300 font-bold">{{ totalPaginas }}</span>
              </p>
              <div class="flex items-center gap-1 order-1 sm:order-2 w-full sm:w-auto justify-center">
                <button @click="paginaAnterior" :disabled="paginaAtual === 1" 
                        class="p-2.5 bg-white dark:bg-slate-950 border dark:border-slate-800 rounded-xl shadow-sm text-gray-500 dark:text-slate-400 disabled:opacity-30 transition-all hover:bg-gray-50 dark:hover:bg-slate-900">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                
                <button v-for="p in totalPaginas" :key="p" @click="paginaAtual = p" 
                        class="w-9 h-9 rounded-xl text-xs font-bold transition-all shadow-sm animate-none"
                        :class="paginaAtual === p ? 'bg-[#2C3E50] dark:bg-slate-800 text-white' : 'bg-white dark:bg-slate-950 border dark:border-slate-800 text-gray-400 dark:text-slate-500 hover:bg-gray-50 dark:hover:bg-slate-900'">
                  {{ p }}
                </button>

                <button @click="proximaPagina" :disabled="paginaAtual === totalPaginas" 
                        class="p-2.5 bg-white dark:bg-slate-950 border dark:border-slate-800 rounded-xl shadow-sm text-gray-500 dark:text-slate-400 disabled:opacity-30 transition-all hover:bg-gray-50 dark:hover:bg-slate-900">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
              </div>
            </div>
          </div>

          <div class="mt-12 flex justify-between items-center text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-slate-600">
            <span>Glow Cosmetics &copy; 2026</span>
            <span>{{ pedidosFiltrados.length }} Consultas encontradas</span>
          </div>

        </div>
      </main>
    </div>

    <!-- Modal Detalhar Pedido -->
    <div v-if="modalAberto" class="fixed inset-0 bg-slate-900/60 dark:bg-slate-950/80 backdrop-blur-sm flex items-end sm:items-center justify-center p-0 sm:p-4 z-50 fade-in">
      <div class="bg-white dark:bg-slate-950 rounded-t-3xl sm:rounded-3xl w-full max-w-2xl border dark:border-slate-800 shadow-2xl flex flex-col overflow-hidden max-h-[92vh] sm:max-h-[85vh]">
        
        <div class="p-6 bg-slate-50 dark:bg-slate-900 border-b border-gray-100 dark:border-slate-800 flex justify-between items-center shrink-0">
          <div>
            <div class="flex items-center gap-2">
              <h3 class="text-lg font-bold text-[#2C3E50] dark:text-white">Pedido #{{ pedidoEditavel?.id }}</h3>
              <span class="px-2 py-0.5 text-[9px] bg-[#E67E73]/10 text-[#E67E73] font-bold rounded-md uppercase">Rede</span>
            </div>
            <p class="text-xs text-gray-500 dark:text-slate-400 font-medium mt-0.5">Consultora: <span class="text-slate-800 dark:text-slate-200 font-bold">{{ pedidoEditavel?.nome }}</span></p>
          </div>
          <button @click="fecharModal" class="text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 font-medium text-2xl w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">&times;</button>
        </div>

        <div class="p-6 overflow-y-auto space-y-6 custom-scrollbar flex-1">
          <div class="grid grid-cols-2 gap-4 text-xs bg-slate-50/80 dark:bg-slate-900/50 p-4 rounded-2xl border border-gray-100 dark:border-slate-800">
            <div>
              <span class="text-gray-400 dark:text-slate-500 font-bold block uppercase tracking-wide">Cliente Final</span>
              <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 block mt-1">{{ pedidoEditavel?.cliente }}</span>
            </div>
            <div>
              <span class="text-gray-400 dark:text-slate-500 font-bold block uppercase tracking-wide">Método de Pagamento</span>
              <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 block mt-1">{{ pedidoEditavel?.pagamento }}</span>
            </div>
          </div>

          <div>
            <span class="text-gray-400 dark:text-slate-500 font-bold text-xs block uppercase tracking-wide mb-3">Produtos Solicitados</span>
            <div class="border border-gray-100 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
              <table class="w-full text-left border-collapse text-xs">
                <thead class="bg-slate-50 dark:bg-slate-900/50">
                  <tr>
                    <th class="p-3 text-gray-400 dark:text-slate-500 uppercase font-bold">Produto</th>
                    <th class="p-3 text-gray-400 dark:text-slate-500 uppercase font-bold text-center w-24">Qtd</th>
                    <th class="p-3 text-gray-400 dark:text-slate-500 uppercase font-bold text-right">Total</th>
                    <th v-if="modo === 'editar'" class="p-3 text-center w-12"></th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-900">
                  <tr v-for="(item, idx) in pedidoEditavel?.itens" :key="idx" class="bg-white dark:bg-slate-950 hover:bg-slate-50/50 dark:hover:bg-slate-900/30">
                    <td class="p-3 font-semibold text-slate-700 dark:text-slate-300">{{ item.produto }}</td>
                    <td class="p-3 text-center">
                      <input v-if="modo === 'editar'" type="number" v-model.number="item.qtd" class="w-16 text-center bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-xl p-1 font-bold focus:ring-2 focus:ring-[#E67E73]/30 dark:focus:ring-amber-500/30 focus:border-[#E67E73] dark:focus:border-amber-500 text-slate-800 dark:text-slate-200 outline-none" min="1" />
                      <span v-else class="font-bold text-slate-600 dark:text-slate-400">{{ item.qtd }} uni</span>
                    </td>
                    <td class="p-3 text-right font-mono font-bold text-slate-700 dark:text-slate-300">{{ formatarMoeda(item.preco * item.qtd) }}</td>
                    <td v-if="modo === 'editar'" class="p-3 text-center">
                      <button @click="removerItem(idx)" class="text-red-400 hover:text-red-600 font-bold text-lg p-1">&times;</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            
            <div class="mt-4 flex justify-between items-center bg-gradient-to-r from-[#2C3E50] to-[#1A252F] dark:from-slate-900 dark:to-slate-950 border dark:border-slate-800 p-4 rounded-2xl text-white shadow-md">
              <span class="text-xs font-bold uppercase tracking-wider opacity-80">Valor Bruto Total</span>
              <span class="text-xl font-bold font-mono text-[#FFD700] dark:text-amber-400">{{ formatarMoeda(calcularTotal()) }}</span>
            </div>
          </div>
        </div>

        <div class="p-5 bg-slate-50 dark:bg-slate-900 border-t border-gray-100 dark:border-slate-800 flex flex-col gap-4 shrink-0">
          
          <!-- Swipe To Cancel (Mobile) -->
          <div 
            v-if="modo === 'visualizar'" 
            ref="swipeTrack"
            class="block sm:hidden relative w-full bg-slate-900/5 dark:bg-slate-950/50 rounded-2xl h-14 overflow-hidden border border-black/5 dark:border-slate-800 shadow-inner select-none backdrop-blur-sm"
          >
            <div 
              class="absolute inset-0 flex items-center justify-center text-xs font-bold uppercase tracking-widest text-red-900/60 dark:text-red-400/60 pointer-events-none"
              :style="{ opacity: textOpacity }"
            >
              <span class="inline-block animate-shimmer bg-gradient-to-r from-red-700 via-rose-500 to-red-700 dark:from-red-500 dark:via-rose-400 dark:to-red-500 bg-[length:200%_auto] bg-clip-text text-transparent">
                Deslize para Cancelar
              </span>
            </div>

            <div 
              class="absolute left-0 top-0 bottom-0 bg-gradient-to-r from-red-500 to-rose-500 pointer-events-none flex items-center justify-end pr-4 rounded-l-2xl"
              :class="{ 'transition-all duration-300 ease-out-elastic': !isSwiping }"
              :style="{ width: `${swipeTranslateX + 52}px` }"
            ></div>

            <div 
              @touchstart="onTouchStart"
              @touchmove="onTouchMove"
              @touchend="onTouchEnd"
              class="absolute top-1 bottom-1 left-1 bg-white dark:bg-slate-900 rounded-xl shadow-md flex items-center justify-center cursor-grab active:cursor-grabbing w-12 border border-gray-100 dark:border-slate-800"
              :class="{ 'transition-transform duration-300 ease-out-elastic': !isSwiping }"
              :style="{ transform: `translateX(${swipeTranslateX}px)` }"
            >
              <div class="w-full h-full flex items-center justify-center rounded-xl bg-gradient-to-b from-white to-slate-50 dark:from-slate-900 dark:to-slate-950">
                <svg v-if="!swipeCompleted" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" /></svg>
                <div v-else class="w-4 h-4 border-2 border-slate-200 dark:border-slate-700 border-t-rose-600 rounded-full animate-spin"></div>
              </div>
            </div>
          </div>

          <div class="flex justify-between items-center w-full">
            <div>
              <button 
                v-if="modo === 'visualizar'" 
                @click="confirmacaoAberta = true" 
                class="hidden sm:block bg-red-50 dark:bg-red-950/30 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/40 border dark:border-red-900/40 px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all active:scale-95"
              >
                Cancelar Pedido
              </button>
            </div>
            
            <div class="flex gap-2 w-full sm:w-auto justify-end">
              <button 
                v-if="modo === 'visualizar'" 
                @click="modo = 'editar'" 
                class="flex-1 sm:flex-initial bg-white dark:bg-slate-950 border border-gray-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-900 px-5 py-3 sm:py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-sm active:scale-95"
              >
                Editar Itens
              </button>
              
              <button 
                v-if="modo === 'editar'" 
                @click="salvarEdicao" 
                class="flex-1 sm:flex-initial bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 sm:py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-sm active:scale-95"
              >
                Salvar Alterações
              </button>
              
              <button 
                @click="fecharModal" 
                class="flex-1 sm:flex-initial bg-gray-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-gray-300 dark:hover:bg-slate-700 px-5 py-3 sm:py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all active:scale-95"
              >
                {{ modo === 'editar' ? 'Voltar' : 'Fechar' }}
              </button>
            </div>
          </div>

        </div>

      </div>
    </div>

    <!-- Modal de Confirmação (Desktop) -->
    <div v-if="confirmacaoAberta" class="fixed inset-0 bg-slate-900/40 dark:bg-slate-950/60 backdrop-blur-sm flex items-center justify-center p-4 z-[60] fade-in">
      <div class="bg-white dark:bg-slate-950 p-6 rounded-3xl max-w-sm w-full shadow-2xl text-center space-y-4 border border-gray-100 dark:border-slate-800">
        <h4 class="text-base font-bold text-slate-800 dark:text-slate-200">Confirmar Cancelamento?</h4>
        <p class="text-xs text-gray-400 dark:text-slate-500 font-medium">Esta ação executará o estorno financeiro e as regras de pontuação da consultora.</p>
        <div class="flex justify-center gap-2 pt-2">
          <button @click="confirmarCancelamento" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all active:scale-95">
            Sim, Cancelar
          </button>
          <button @click="confirmacaoAberta = false" class="bg-gray-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-gray-200 dark:hover:bg-slate-700 px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider transition-all active:scale-95">
            Voltar
          </button>
        </div>
      </div>
    </div>

  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

.font-serif {
  font-family: 'Playfair Display', serif;
}
.font-sans {
  font-family: 'Plus Jakarta Sans', sans-serif;
}

.fade-in {
  animation: fadeIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(8px); }
  to { opacity: 1; transform: translateY(0); }
}

.fade-enter-active, .fade-leave-active {
  transition: all 0.25s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
  transform: translateY(-8px);
}

.ease-out-elastic {
  transition-timing-function: cubic-bezier(0.25, 1.3, 0.5, 1);
}

@keyframes shimmer {
  to { background-position: 200% center; }
}
.animate-shimmer {
  animation: shimmer 3s linear infinite;
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
}

.custom-scrollbar::-webkit-scrollbar {
  height: 5px;
  width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #E67E73;
  border-radius: 10px;
}
.dark .custom-scrollbar::-webkit-scrollbar-thumb {
  background: #334155;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: #f8fafc;
}
.dark .custom-scrollbar::-webkit-scrollbar-track {
  background: #0f172a;
}
</style>