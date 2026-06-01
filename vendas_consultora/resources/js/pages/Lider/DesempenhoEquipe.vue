<script setup>
import { ref, computed, onMounted } from 'vue'
import { Head, usePage, Link } from '@inertiajs/vue3'
import axios from 'axios'

// Estado Reativo
const equipe = ref([])
const metas = ref([])
const loading = ref(false)

const totais = ref({
  vendas: 0,
  pedidos: 0,
  ticketMedio: 0,
  qtdConsultoras: 0,
  percentualMetaGlobal: 0,
  metaTotal: 0
})

// Dados do usuário logado via Inertia
const usuarioLogado = computed(() => usePage().props.auth?.user)
const ehLider = computed(() => usuarioLogado.value?.cargo === 'lider')

// Buscar os dados das APIs
const sincronizarDados = async () => {
  loading.value = true
  try {
    const [resVendas, resMetas] = await Promise.all([
      axios.get('/api/lider/equipe/desempenho'),
      axios.get('/api/meta/historico')
    ])

    if (resVendas.data?.status === 'success' && resMetas.data?.status === 'success') {
      metas.value = resMetas.data.data
      
      equipe.value = resVendas.data.data.map(consultora => {
        const metaInfo = metas.value.find(m => m.id === consultora.id)
        
        let valorMetaBruto = metaInfo?.metas_consultora?.[0]?.valor_meta?.valor_meta ?? 0
        
        if (typeof valorMetaBruto === 'string') {
          if (valorMetaBruto.includes(',')) {
            valorMetaBruto = valorMetaBruto.replace(/\./g, '').replace(',', '.')
          }
        }

        let valorMetaFinal = parseFloat(valorMetaBruto)
        if (isNaN(valorMetaFinal)) valorMetaFinal = 0

        return {
          ...consultora,
          valor_meta: valorMetaFinal
        }
      })
      
      calcularMetricasGlobais()
    }
  } catch (error) {
    console.error("Erro na sincronização de dados da equipe:", error)
  } finally {
    loading.value = false
  }
}

const calcularMetricasGlobais = () => {
  let totalVendas = 0
  let totalPedidos = 0
  let somaMetaTotal = 0
  
  equipe.value.forEach(c => {
    totalVendas += getVendaAtual(c)
    totalPedidos += getPedidosAtual(c)
    somaMetaTotal += isNaN(c.valor_meta) ? 0 : c.valor_meta
  })

  const faturamento = isNaN(totalVendas) ? 0 : totalVendas
  const pedidosCount = isNaN(totalPedidos) ? 0 : totalPedidos
  const metaSoma = isNaN(somaMetaTotal) ? 0 : somaMetaTotal

  totais.value = {
    vendas: faturamento,
    pedidos: pedidosCount,
    ticketMedio: pedidosCount > 0 ? (faturamento / pedidosCount) : 0,
    qtdConsultoras: equipe.value.length,
    metaTotal: metaSoma,
    percentualMetaGlobal: metaSoma > 0 ? parseFloat(((faturamento / metaSoma) * 100).toFixed(1)) : 0
  }
}

// Getters Auxiliares blindados
const getVendaAtual = (c) => {
  const valor = c.TotalVendido?.[0]?.total_vendas ?? 0
  return isNaN(Number(valor)) ? 0 : Number(valor)
}

const getPedidosAtual = (c) => {
  const valor = c.TotalPedidos?.[0]?.total_pedidos ?? 0
  return isNaN(Number(valor)) ? 0 : Number(valor)
}

const getPercentMeta = (c) => {
  if (!c.valor_meta || c.valor_meta <= 0 || isNaN(c.valor_meta)) return 0
  const percent = (getVendaAtual(c) / c.valor_meta) * 100
  return isNaN(percent) ? 0 : percent
}

const formatarDinheiro = (v) => {
  const numeroValido = isNaN(Number(v)) ? 0 : Number(v)
  return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(numeroValido)
}

const voltar = () => {
  window.history.back()
}

onMounted(() => {
  sincronizarDados()
})
</script>

<template>
  <Head title="Análise de Desempenho - GlowBiz" />

  <div class="min-h-screen bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100 antialiased font-sans pb-12 transition-colors duration-300">
    
    <nav class="bg-[#2C3E50] dark:bg-slate-950 text-white p-4 shadow-xl flex justify-between items-center px-4 md:px-8 border-b border-[#FFD700]/30 dark:border-amber-500/20 sticky top-0 z-50 transition-colors">
      <div class="flex items-center gap-2 md:gap-3">
        <span class="text-xl md:text-2xl font-black tracking-widest uppercase font-serif">
          Glow<span class="text-[#FFD700] dark:text-amber-500 lowercase italic font-light text-sm ml-0.5">biz</span>
        </span>
        <span class="hidden md:block text-slate-500 dark:text-slate-600 font-light ml-4">|</span>
        <span class="hidden md:block ml-4 text-sm font-medium text-slate-300 dark:text-slate-400">Análise de Desempenho</span>
      </div>
      <button
        @click="voltar"
        class="group flex items-center gap-2 bg-slate-800/50 hover:bg-slate-700 dark:bg-slate-900 dark:hover:bg-slate-800 border border-slate-600 dark:border-slate-700 px-4 py-2 rounded-full transition-all text-xs md:text-sm font-bold uppercase tracking-widest text-white"
      >
        <svg class="w-4 h-4 text-[#FFD700] dark:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Voltar
      </button>
    </nav>

    <div class="p-4 md:p-8 max-w-[1400px] mx-auto">
      
      <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end mb-8 md:mb-12 gap-6">
        <div>
          <h2 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">
            Gestão de Desempenho
          </h2>
          <p class="text-slate-500 dark:text-slate-400 mt-1 font-medium text-sm md:text-base">
            Gestão estratégica de faturamento, metas e ranking da sua rede.
          </p>
        </div>
        
        <div class="flex flex-col sm:flex-row items-stretch sm:items-end gap-4 w-full lg:w-auto justify-end">
          <div v-if="ehLider" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <Link
              href="/metas/configuracao-equipe"
              class="flex items-center justify-center gap-2 bg-white dark:bg-slate-950 border-2 border-[#FFD700] dark:border-amber-500 text-slate-800 dark:text-slate-200 px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 dark:hover:bg-slate-900 transition-all shadow-md group whitespace-nowrap"
            >
              <svg class="w-4 h-4 text-[#FFD700] dark:text-amber-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
              </svg>
              Defir Metas
            </Link>

            <Link
              href="/rede/arvore"
              class="flex items-center justify-center gap-2 bg-[#2C3E50] dark:bg-slate-950 text-white px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-[#1a252f] dark:hover:bg-slate-900 transition-all shadow-md border-b-2 border-[#FFD700] dark:border-amber-500 group whitespace-nowrap"
            >
              <svg class="w-4 h-4 text-[#FFD700] dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
              </svg>
              Ver Organograma
            </Link>
          </div>

          <button
            @click="sincronizarDados"
            :disabled="loading"
            class="flex items-center justify-center gap-2 bg-slate-200 dark:bg-slate-800 hover:bg-slate-300/80 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-sm border border-slate-300/40 dark:border-slate-700 disabled:opacity-60"
          >
            <svg :class="{ 'animate-spin': loading }" class="w-4 h-4 text-[#2C3E50] dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Sincronizar
          </button>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 mb-12">
        
        <div class="bg-white dark:bg-slate-950 border border-slate-200/80 dark:border-slate-800 p-6 md:p-8 rounded-3xl shadow-sm flex flex-col justify-between relative overflow-hidden border-l-4 border-l-[#2C3E50] dark:border-l-amber-500">
          <div>
            <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest">Volume Faturado (Rede)</p>
            <h3 class="text-2xl md:text-3xl font-extrabold text-[#2C3E50] dark:text-white mt-2 tracking-tight">
              {{ formatarDinheiro(totais.vendas) }}
            </h3>
          </div>
          <div class="mt-4 flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400 font-bold text-xs uppercase tracking-tight">
            <span class="bg-emerald-50 dark:bg-emerald-950/30 px-2 py-0.5 rounded border border-emerald-100 dark:border-emerald-900/50">
              {{ totais.qtdConsultoras }} Ativas no ciclo
            </span>
          </div>
        </div>

        <div class="bg-white dark:bg-slate-950 border border-slate-200/80 dark:border-slate-800 p-6 md:p-8 rounded-3xl shadow-sm flex flex-col justify-between">
          <div>
            <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest">Ticket Médio Geral</p>
            <h3 class="text-2xl md:text-3xl font-extrabold text-[#2C3E50] dark:text-white mt-2 tracking-tight">
              {{ formatarDinheiro(totais.ticketMedio) }}
            </h3>
          </div>
          <p class="mt-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Qualidade média do pedido</p>
        </div>

        <div class="bg-gradient-to-br from-[#2C3E50] to-[#1A252F] dark:from-slate-950 dark:to-[#0f172a] border border-slate-700/30 dark:border-slate-800 p-6 md:p-8 rounded-3xl shadow-xl text-white relative overflow-hidden">
          <p class="text-[10px] text-amber-300/80 dark:text-amber-400/60 font-bold uppercase tracking-widest">Atingimento de Meta Equipe</p>
          <div class="flex justify-between items-end mt-2 mb-1">
            <h3 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">
              {{ totais.percentualMetaGlobal }}%
            </h3>
            <span class="text-[10px] font-bold text-amber-400 dark:text-amber-500 uppercase pb-1 tracking-wider">
              Alvo: {{ formatarDinheiro(totais.metaTotal) }}
            </span>
          </div>
          
          <div class="w-full h-2.5 bg-slate-800/80 dark:bg-slate-900 rounded-full mt-3 overflow-hidden border border-slate-700/50 dark:border-slate-800">
            <div
              class="h-full bg-gradient-to-r from-[#FFD700] to-amber-500 dark:from-amber-500 dark:to-amber-600 transition-all duration-1000"
              :style="{ width: Math.min(totais.percentualMetaGlobal, 100) + '%' }"
            ></div>
          </div>
        </div>
      </div>

      <div v-if="loading" class="flex flex-col items-center justify-center py-20 gap-3 bg-white dark:bg-slate-950 rounded-3xl border border-slate-200/70 dark:border-slate-800 shadow-sm">
        <div class="w-10 h-10 border-4 border-slate-200 dark:border-slate-800 border-t-[#FFD700] dark:border-t-amber-500 rounded-full animate-spin"></div>
        <p class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-widest">Processando dados de desempenho...</p>
      </div>

      <div v-else class="space-y-6">
        <div class="flex items-center gap-3 mb-4">
          <span class="bg-gradient-to-r from-[#2C3E50] to-[#34495E] dark:from-slate-950 dark:to-slate-800 text-[#FFD700] dark:text-amber-400 w-6 h-6 flex items-center justify-center rounded-md text-xs font-bold shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
            </svg>
          </span>
          <h3 class="text-xs md:text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Métricas e Alvos por Consultora</h3>
          <div class="h-px bg-slate-200 dark:bg-slate-800 flex-grow"></div>
        </div>

        <div class="hidden md:block bg-white dark:bg-slate-950 rounded-3xl border border-slate-200/70 dark:border-slate-800 shadow-lg overflow-hidden transition-all">
          <table class="w-full text-left border-collapse">
            <slot name="header">
              <thead class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-200/60 dark:border-slate-800">
                <tr>
                  <th class="px-8 py-5 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Consultora</th>
                  <th class="px-8 py-5 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Realizado (Mês)</th>
                  <th class="px-8 py-5 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Progresso</th>
                  <th class="px-8 py-5 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Meta Alvo</th>
                </tr>
              </thead>
            </slot>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-900">
              <tr v-for="item in equipe" :key="item.id" class="hover:bg-slate-50/80 dark:hover:bg-slate-900/30 transition-colors">
                
                <td class="px-8 py-5">
                  <div class="flex items-center gap-3">
                    <img
                      :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(item.nome)}&background=2C3E50&color=FFD700&bold=true`"
                      class="w-10 h-10 rounded-xl border border-slate-200 dark:border-slate-800 object-cover shadow-sm"
                      alt="Avatar"
                    >
                    <div>
                      <span class="text-sm font-semibold text-slate-700 dark:text-slate-200 block">{{ item.nome }}</span>
                      <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono">ID: #{{ item.id }}</span>
                    </div>
                  </div>
                </td>
                
                <td class="px-8 py-5 text-sm font-bold text-[#2C3E50] dark:text-amber-400">
                  {{ formatarDinheiro(getVendaAtual(item)) }}
                </td>
                
                <td class="px-8 py-5">
                  <div class="flex flex-col min-w-[200px]">
                    <div class="flex justify-between items-center mb-1.5">
                      <span
                        class="text-[10px] font-bold uppercase tracking-wide"
                        :class="getPercentMeta(item) >= 100 ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-500 dark:text-slate-400'"
                      >
                        {{ getPercentMeta(item).toFixed(1) }}%
                      </span>
                      <span
                        class="text-[9px] font-semibold uppercase px-2 py-0.5 rounded border tracking-wider shadow-sm"
                        :class="getPercentMeta(item) >= 100 ? 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border-emerald-100 dark:border-emerald-900/40' : 'bg-slate-50 dark:bg-slate-900 text-slate-400 dark:text-slate-500 border-slate-100 dark:border-slate-800'"
                      >
                        {{ getPercentMeta(item) >= 100 ? 'Batida!' : 'Em curso' }}
                      </span>
                    </div>
                    <div class="w-full h-2 bg-slate-100 dark:bg-slate-900 rounded-full overflow-hidden border border-slate-200/60 dark:border-slate-800">
                      <div
                        class="h-full transition-all duration-1000"
                        :class="getPercentMeta(item) >= 100 ? 'bg-emerald-500 dark:bg-emerald-400' : 'bg-[#2C3E50] dark:bg-amber-500/80'"
                        :style="{ width: Math.min(getPercentMeta(item), 100) + '%' }"
                      ></div>
                    </div>
                  </div>
                </td>
                
                <td class="px-8 py-5 text-sm font-bold text-slate-600 dark:text-slate-400 text-right">
                  {{ formatarDinheiro(item.valor_meta) }}
                </td>

              </tr>
            </tbody>
          </table>
        </div>

        <div class="md:hidden space-y-3">
          <div v-for="item in equipe" :key="item.id" class="bg-white dark:bg-slate-950 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
            <div class="flex justify-between items-center">
              <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-900 flex items-center justify-center text-[10px] font-bold text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-800">
                  {{ item.nome.substring(0,2).toUpperCase() }}
                </div>
                <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ item.nome }}</span>
              </div>
              <span
                class="text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wider border"
                :class="getPercentMeta(item) >= 100 ? 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 border-emerald-100 dark:border-emerald-900/40' : 'bg-slate-50 dark:bg-slate-900 text-slate-400 dark:text-slate-500 border-slate-100 dark:border-slate-800'"
              >
                {{ getPercentMeta(item) >= 100 ? 'Batida!' : 'Em curso' }}
              </span>
            </div>
            
            <div class="space-y-1.5 text-xs">
              <div class="flex justify-between">
                <span class="text-slate-400 dark:text-slate-500 font-medium">Realizado:</span>
                <span class="text-[#2C3E50] dark:text-amber-400 font-bold">{{ formatarDinheiro(getVendaAtual(item)) }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-slate-400 dark:text-slate-500 font-medium">Meta Alvo:</span>
                <span class="text-slate-600 dark:text-slate-400 font-semibold">{{ formatarDinheiro(item.valor_meta) }}</span>
              </div>
            </div>

            <div class="pt-1">
              <div class="w-full h-1.5 bg-slate-100 dark:bg-slate-900 rounded-full overflow-hidden border border-slate-200/60 dark:border-slate-800">
                <div
                  class="h-full"
                  :class="getPercentMeta(item) >= 100 ? 'bg-emerald-500 dark:bg-emerald-400' : 'bg-[#2C3E50] dark:bg-amber-500/80'"
                  :style="{ width: Math.min(getPercentMeta(item), 100) + '%' }"
                ></div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght=900&display=swap');

.font-serif {
  font-family: 'Playfair Display', serif;
}

.custom-scroll::-webkit-scrollbar {
  height: 8px;
}
.custom-scroll::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 10px;
}
.dark .custom-scroll::-webkit-scrollbar-track {
  background: #0f172a;
}
.custom-scroll::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 10px;
}
.dark .custom-scroll::-webkit-scrollbar-thumb {
  background: #334155;
}
.custom-scroll::-webkit-scrollbar-thumb:hover {
  background: #2C3E50;
}
.dark .custom-scroll::-webkit-scrollbar-thumb:hover {
  background: #475569;
}
</style>