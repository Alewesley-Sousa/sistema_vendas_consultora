<template>
  <AppLayout>
    <div class="relative min-h-screen font-sans antialiased text-[#2C3E50] dark:text-slate-100 pb-12">
      
      <header ref="headerSection" class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
          <h1 class="text-4xl font-serif font-medium text-[#2C3E50] dark:text-white">
            Bem-vinda de volta, <span class="text-[#E67E73] font-bold">{{ primeiroNome }}.</span>
          </h1>
        </div>

        <div class="flex gap-4">
          <button 
            @click="modalCadastroAberto = true" 
            class="flex items-center gap-3 bg-white dark:bg-slate-900 text-[#2C3E50] dark:text-white border border-gray-200 dark:border-slate-800 px-6 py-4 rounded-2xl shadow-sm hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-all font-bold uppercase text-xs tracking-wider focus:outline-none"
          >
            <svg class="w-5 h-5 text-gray-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Cadastrar Consultora
          </button>

          <Link 
            href="/catalogo" 
            class="flex items-center gap-3 bg-[#FF7665] text-white px-6 py-4 rounded-2xl shadow-lg shadow-[#FF7665]/30 dark:shadow-none hover:bg-[#ff6450] transition-all font-bold uppercase text-xs tracking-wider"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            Novo Pedido
          </Link>
        </div>
      </header>

      <div ref="cardsGrid" class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-4">
        
        <div class="dashboard-card bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-800/80 relative overflow-hidden group">
          <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:scale-110 transition-transform">
            <svg class="w-24 h-24 text-[#E67E73]" fill="currentColor" viewBox="0 0 20 20">
              <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
              <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path>
            </svg>
          </div>
          <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-4">Financeiro Disponível</p>
          <h3 class="text-gray-600 dark:text-slate-300 text-3xl font-light">
            Saldo de Comissão: <span class="text-[#E67E73] font-bold">{{ formatarMoeda(comissao) }}</span>
          </h3>
          <div class="mt-8">
            <Link href="/comissao/historico" class="text-[#E67E73] font-bold text-sm underline underline-offset-4 hover:text-[#2C3E50] dark:hover:text-white transition-colors italic">
              Ver Histórico
            </Link>
          </div>
        </div>

        <div class="dashboard-card bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-800/80 relative">
          <div class="flex justify-between items-start mb-4">
            <div>
              <p class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-2">Produtividade Mensal</p>
              <h3 class="text-gray-600 dark:text-slate-300 text-3xl font-light">
                Meta Mensal: <span class="text-[#2C3E50] dark:text-white font-bold">{{ formatarMoeda(metaTotal) }}</span>
              </h3>
            </div>
            <span class="bg-[#FFF9E5] dark:bg-amber-950/30 text-[#D4AF37] px-4 py-2 rounded-xl font-bold text-lg border border-transparent dark:border-amber-900/30">
              {{ Math.round(metaPercentual) }}%
            </span>
          </div>

          <div class="mt-8">
            <div class="flex justify-between text-xs font-bold mb-2 uppercase tracking-tighter">
              <span class="text-gray-400 dark:text-slate-500 font-serif italic">{{ formatarMoeda(metaAtingida) }} atingidos</span>
              <span class="text-gray-400 dark:text-slate-500 font-serif italic">{{ metaPercentual >= 100 ? 'Meta batida!' : 'Faltam ' + formatarMoeda(metaRestante) }}</span>
            </div>
            <div class="w-full bg-gray-100 dark:bg-slate-950 rounded-full h-4 overflow-hidden">
              <div 
                ref="barraMeta" 
                class="bg-gradient-to-r from-[#FF7665] to-[#ffb3a9] dark:to-[#ff9385] h-full rounded-full transition-all duration-1000" 
                style="width: 0%"
              ></div>
            </div>
            <p class="text-[11px] text-gray-400 dark:text-slate-500 mt-4 italic">Dados atualizados em tempo real.</p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">
        
        <div ref="networkBanner" class="relative h-72 rounded-[2.5rem] overflow-hidden group shadow-xl opacity-0 transform translate-y-4">
          <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=1000" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Equipe Glow">
          <div class="absolute inset-0 bg-gradient-to-r from-[#8B2E2E]/90 to-transparent flex flex-col justify-center px-12">
            <span class="bg-[#FF7665] text-white text-[10px] font-bold px-3 py-1 rounded-full w-fit mb-4 uppercase tracking-widest">Minhas indicações</span>
            <h2 class="text-4xl font-serif text-white mb-6">Expansão de<br><span class="font-bold italic">Árvore de Rede</span></h2>
            <Link href="/rede/arvore" class="bg-white dark:bg-slate-900 text-[#2C3E50] dark:text-white px-8 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-[#FFD700] dark:hover:bg-amber-500 dark:hover:text-slate-950 transition-all w-fit flex items-center gap-2 group border border-transparent dark:border-slate-800">
              Visualizar Organização
              <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </Link>
          </div>
        </div>

        <div ref="dynamicSection" class="opacity-0 transform translate-y-4">
          
          <div v-if="ehLider" class="relative h-72 rounded-[2.5rem] overflow-hidden group shadow-xl border border-white/20 dark:border-slate-800/60">
            <img src="https://images.unsplash.com/photo-1556742044-3c52d6e88c62?auto=format&fit=crop&q=80&w=1000" 
                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" 
                 alt="Pedidos Equipe">
            
            <div class="absolute inset-0 bg-gradient-to-l from-[#2C3E50]/80 via-[#2C3E50]/40 to-transparent dark:from-slate-950/90 dark:via-slate-950/50"></div>

            <div class="absolute inset-0 flex flex-col justify-center items-end px-12 text-right">
              <div class="backdrop-blur-md bg-white/10 dark:bg-slate-900/40 p-6 rounded-[2rem] border border-white/20 dark:border-slate-800 shadow-2xl transform group-hover:-translate-y-2 transition-transform duration-500">
                <div class="flex items-center justify-end gap-3 mb-3">
                  <span class="text-white text-[9px] font-black uppercase tracking-[0.3em]">Monitoramento</span>
                  <div class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#FF7665] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#FF7665]"></span>
                  </div>
                </div>

                <h2 class="text-3xl font-serif text-white mb-2">Pedidos da <span class="font-bold italic text-[#FF7665]">Equipe</span></h2>
                <p class="text-gray-200 dark:text-slate-300 text-[11px] mb-4 font-light max-w-[200px] ml-auto leading-tight">
                  Acompanhe em tempo real as vendas e o desempenho do seu time.
                </p>

                <Link href="/pedidos/equipe" class="inline-flex items-center gap-3 bg-[#FF7665] text-white px-6 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-[#ff6450] transition-all group/btn">
                  <svg class="w-4 h-4 text-white group-hover/btn:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                  </svg>
                  Ver Pedidos
                </Link>
              </div>
            </div>
          </div>

          <div v-else class="h-full">
            <div v-if="loadingUpgrade" class="h-full min-h-[18rem] bg-gray-50 dark:bg-slate-900 rounded-[2.5rem] animate-pulse flex items-center justify-center border border-dashed border-gray-200 dark:border-slate-800">
              <span class="text-gray-400 dark:text-slate-500 font-serif italic">Analisando sua evolução de carreira...</span>
            </div>

            <div v-else-if="erroUpgrade" class="bg-red-50 dark:bg-red-950/20 border border-red-100 dark:border-red-900/30 p-8 rounded-[2.5rem] h-full flex flex-col items-center justify-center text-center gap-4 shadow-sm">
              <p class="font-bold text-red-700 dark:text-red-400">Não conseguimos analisar sua evolução de carreira neste momento.</p>
              <button @click="checarStatusUpgrade" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl text-xs font-bold uppercase transition-colors shadow-lg">Atualizar Painel</button>
            </div>

            <div 
              v-else 
              :class="statusUpgrade.atende_requisitos ? 'bg-gradient-to-br from-[#2C3E50] to-[#1a252f] dark:from-slate-950 dark:to-slate-900 text-white shadow-[#2C3E50]/30 shadow-2xl' : 'bg-white dark:bg-slate-900 border-gray-100 dark:border-slate-800/80'"
              class="relative overflow-hidden p-8 rounded-[2.5rem] border h-full transition-all duration-700 transform hover:scale-[1.01] flex flex-col justify-center"
            >
              <div v-show="statusUpgrade.atende_requisitos" class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-20"></div>

              <div class="relative z-10 flex flex-col xl:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-6 flex-1 w-full">
                  <div :class="statusUpgrade.atende_requisitos ? 'bg-[#FF7665] rotate-12 scale-110' : 'bg-[#FFF9F9] dark:bg-slate-950'" class="w-16 h-16 rounded-[2rem] flex items-center justify-center transition-all duration-500 shadow-inner flex-shrink-0 border border-transparent dark:border-slate-800/50">
                    <svg v-if="!statusUpgrade.atende_requisitos" class="w-8 h-8 text-[#FF7665]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <svg v-else class="w-8 h-8 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                  </div>

                  <div class="w-full">
                    <h4 class="text-lg font-serif font-bold" :class="statusUpgrade.atende_requisitos ? 'text-white' : 'text-[#2C3E50] dark:text-white'">
                      {{ statusUpgrade.atende_requisitos ? 'Evolução de Carreira Disponível!' : 'Próximo Passo: Líder Glow' }}
                    </h4>
                    <p class="text-xs mt-0.5" :class="statusUpgrade.atende_requisitos ? 'text-gray-300' : 'text-gray-500 dark:text-slate-400'">
                      {{ statusUpgrade.mensagem }}
                    </p>

                    <div v-if="!statusUpgrade.atende_requisitos" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                      <div>
                        <div class="flex justify-between text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase mb-1">
                          <span>Vendas</span>
                          <span>{{ formatarMoeda(statusUpgrade.dados.total_vendas) }} / 5k</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-slate-950 h-1.5 rounded-full overflow-hidden">
                          <div class="bg-[#FF7665] h-full transition-all duration-1000" :style="`width: ${porcentagemVendas}%`"></div>
                        </div>
                      </div>
                      <div>
                        <div class="flex justify-between text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase mb-1">
                          <span>Ativas</span>
                          <span>{{ statusUpgrade.dados.consultoras_ativas }} / 3</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-slate-950 h-1.5 rounded-full overflow-hidden">
                          <div class="bg-[#2C3E50] dark:bg-slate-700 h-full transition-all duration-1000" :style="`width: ${porcentagemConsultoras}%`"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div v-if="statusUpgrade.atende_requisitos" class="w-full xl:w-auto">
                  <button 
                    @click="solicitarUpgrade" 
                    class="w-full xl:w-auto bg-[#FF7665] text-white px-6 py-4 rounded-xl font-black uppercase text-xs tracking-wider shadow-xl hover:bg-white hover:text-[#FF7665] transition-all duration-300 transform hover:scale-105 active:scale-95"
                  >
                    Tornar-me Líder
                  </button>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <ModalCadastroConsultora 
        :show="modalCadastroAberto" 
        @close="modalCadastroAberto = false"
      />

    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { usePage, router, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import ModalCadastroConsultora from '@/Pages/Consultora/Partials/ModalCadastroConsultora.vue'
import axios from 'axios'
import Swal from 'sweetalert2'
import { gsap } from 'gsap'

const modalCadastroAberto = ref(false)
const comissao = ref(0)
const metaTotal = ref(0)
const metaPercentual = ref(0)

const headerSection = ref(null)
const cardsGrid = ref(null)
const barraMeta = ref(null)
const networkBanner = ref(null)
const dynamicSection = ref(null)

const loadingUpgrade = ref(true)
const erroUpgrade = ref(false)
const statusUpgrade = ref({
  atende_requisitos: false,
  mensagem: '',
  dados: { total_vendas: 0, consultoras_ativas: 0 }
})

// Pega os dados do usuário autenticado enviados globalmente via Inertia middleware
const usuarioLogado = computed(() => usePage().props.auth?.user)

// Identifica se é líder (ajuste 'cargo' ou 'role' baseado no seu banco de dados)
const ehLider = computed(() => usuarioLogado.value?.cargo === 'lider')

const primeiroNome = computed(() => {
  const nomeCompleto = usuarioLogado.value?.nome || 'Consultora'
  return nomeCompleto.split(' ')[0]
})

const metaAtingida = computed(() => (metaTotal.value * metaPercentual.value) / 100)
const metaRestante = computed(() => Math.max(metaTotal.value - metaAtingida.value, 0))

const porcentagemVendas = computed(() => Math.min((parseFloat(statusUpgrade.value.dados.total_vendas) / 5000) * 100, 100))
const porcentagemConsultoras = computed(() => Math.min((parseInt(statusUpgrade.value.dados.consultoras_ativas) / 3) * 100, 100))

const formatarMoeda = (valor) => {
  return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor || 0)
}

const carregarDadosDaApi = async () => {
  axios.get('/api/comissao')
    .then(r => {
      if (r.data.status === 'sucesso') comissao.value = parseFloat(r.data.data) || 0
    })
    .catch(err => console.error("Erro Comissão:", err))

  try {
    const [resMeta, resProgresso] = await Promise.all([
      axios.get('/api/meta').catch(() => ({ data: { data: 0 } })),
      axios.get('/api/meta/progresso').catch(() => ({ data: { data: 0 } }))
    ])

    metaTotal.value = parseFloat(resMeta.data.data) || 0
    metaPercentual.value = parseFloat(resProgresso.data.data) || 0

    gsap.to(barraMeta.value, {
      width: `${metaPercentual.value > 100 ? 100 : metaPercentual.value}%`,
      duration: 1.2,
      ease: 'power3.out'
    })
  } catch (error) {
    console.error("Erro ao carregar metas da API:", error)
  }
}

const checarStatusUpgrade = async () => {
  if (ehLider.value) {
    loadingUpgrade.value = false
    return
  }
  
  loadingUpgrade.value = true
  erroUpgrade.value = false
  try {
    const response = await axios.get('/lider/upgrade')
    statusUpgrade.value = {
      atende_requisitos: response.data.atende_requisitos,
      mensagem: response.data.mensagem,
      dados: response.data.dados || { total_vendas: 0, consultoras_ativas: 0 }
    }
  } catch (e) {
    erroUpgrade.value = true
  } finally {
    loadingUpgrade.value = false
  }
}

const solicitarUpgrade = async () => {
  const result = await Swal.fire({
    title: 'Confirmar Upgrade?',
    text: "Sua jornada como Líder Glow começa agora!",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#FF7665',
    confirmButtonText: 'QUERO SER LÍDER!',
    cancelButtonText: 'Ainda não'
  })

  if (result.isConfirmed) {
    try {
      const response = await axios.get('/lider/mudarCargo')
      if (response.data.status === 'success' || response.data.status === 'sucesso') {
        await Swal.fire({
          title: 'Parabéns!',
          text: response.data.mensagem || 'Seu upgrade para Líder foi realizado.',
          icon: 'success',
          confirmButtonColor: '#2C3E50'
        })
        router.reload()
      } else {
        Swal.fire('Ops!', response.data.mensagem || 'Não foi possível processar o upgrade.', 'error')
      }
    } catch (e) {
      console.error(e)
      Swal.fire('Erro!', 'Não foi possível processar seu upgrade agora.', 'error')
    }
  }
}

onMounted(() => {
  carregarDadosDaApi()
  checarStatusUpgrade()

  const tl = gsap.timeline()
  tl.from(headerSection.value, { opacity: 0, y: -30, duration: 0.6, ease: 'power3.out' })
  tl.from('.dashboard-card', { opacity: 0, y: 40, stagger: 0.15, duration: 0.7, ease: 'power2.out' }, '-=0.3')
  tl.to([networkBanner.value, dynamicSection.value], { opacity: 1, y: 0, duration: 0.6, stagger: 0.15, ease: 'power2.out' }, '-=0.5')
})
</script>