<script setup>
import { ref, computed, onMounted } from 'vue'
import { Head, usePage, Link } from '@inertiajs/vue3'
import axios from 'axios'
import MembroItem from './Partials/MembroItem.vue'

// Estado reativo local
const estruturaArvore = ref([])
const totalNaRede = ref(0)
const carregando = ref(true)

const view = ref('list') 
const filtroDiretaId = ref(null)
const esMobile = ref(false)

// Dados do usuário logado via Inertia
const usuarioLogado = computed(() => usePage().props.auth?.user)
const ehLider = computed(() => usuarioLogado.value?.cargo === 'lider')

onMounted(async () => {
  esMobile.value = window.innerWidth < 768
  view.value = esMobile.value ? 'list' : 'tree'
  await carregarDadosDaRede()
})

const carregarDadosDaRede = async () => {
  try {
    carregando.value = true
    const response = await axios.get('/api/relatorios/crescimento-rede')
    
    if (response.data && response.data.status === 'success') {
      estruturaArvore.value = response.data.dados.estrutura_arvore || []
      totalNaRede.value = response.data.dados.resumo.total_na_rede || 0
    }
  } catch (error) {
    console.error("Erro ao carregar dados da rede via API:", error)
  } finally {
    carregando.value = false
  }
}

const trocarParaArvore = () => {
  if (esMobile.value) return
  view.value = 'tree'
}

const filtrarNivel2 = computed(() => {
  let nivel2 = []
  if (!estruturaArvore.value[0] || !estruturaArvore.value[0].subordinados) return nivel2

  estruturaArvore.value[0].subordinados.forEach(direta => {
    if (!filtroDiretaId.value || filtroDiretaId.value === direta.id) {
      if (direta.subordinados) {
        direta.subordinados.forEach(indireta => {
          nivel2.push({ ...indireta, indicadaPor: direta.nome })
        })
      }
    }
  })
  return nivel2
})

const voltar = () => {
  window.history.back()
}
</script>

<template>
  <Head title="Minha Rede - GlowBiz" />

  <div class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased font-sans pb-12 transition-colors duration-300">
    
    <nav class="bg-[#2C3E50] dark:bg-slate-950 text-white p-4 shadow-xl flex justify-between items-center px-4 md:px-8 border-b border-[#FFD700]/30 sticky top-0 z-50 transition-colors duration-300">
      <div class="flex items-center gap-2 md:gap-3">
        <span class="text-xl md:text-2xl font-black tracking-widest uppercase font-serif">
          Glow<span class="text-[#FFD700] lowercase italic font-light text-sm ml-0.5">biz</span>
        </span>
        <span class="hidden md:block text-slate-500 dark:text-slate-600 font-light ml-4">|</span>
        <span class="hidden md:block ml-4 text-sm font-medium text-slate-300 dark:text-slate-400">Minha Rede</span>
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

    <div class="p-4 md:p-8 max-w-[1400px] mx-auto">
      
      <div class="flex flex-col lg:flex-row justify-between items-start lg:items-end mb-8 md:mb-12 gap-6">
        <div>
          <h2 class="text-2xl md:text-3xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">
            {{ view === 'tree' ? 'Organograma de Rede' : 'Hierarquia de Indicações' }}
          </h2>
          <p class="text-slate-500 dark:text-slate-400 mt-1 font-medium text-sm md:text-base">
            Visualize a estrutura e as indicações da sua rede de consultoras.
          </p>
        </div>
        
        <div class="flex flex-col sm:flex-row items-stretch sm:items-end gap-4 w-full lg:w-auto justify-end">
          
          <div v-if="ehLider" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <Link 
              href="/metas/configuracao-equipe" 
              class="flex items-center justify-center gap-2 bg-white dark:bg-slate-900 border-2 border-[#FFD700] text-slate-800 dark:text-slate-200 px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all shadow-md group whitespace-nowrap"
            >
              <svg class="w-4 h-4 text-[#FFD700] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
              </svg>
              Definir Metas
            </Link>

            <Link 
              href="/relatorios/desempenho-equipe" 
              class="flex items-center justify-center gap-2 bg-[#2C3E50] dark:bg-slate-900 text-white px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-[#1a252f] dark:hover:bg-slate-800 transition-all shadow-md border-b-2 border-[#FFD700] group whitespace-nowrap"
            >
              <svg class="w-4 h-4 text-[#FFD700] group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
              </svg>
              Análise de Desempenho
            </Link>
          </div>

          <div class="inline-flex p-1 bg-slate-200/60 dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-inner">
            <button 
              @click="trocarParaArvore" 
              :disabled="esMobile"
              :class="[
                view === 'tree' ? 'bg-[#2C3E50] dark:bg-[#FFD700] text-white dark:text-slate-950 shadow-md font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white',
                esMobile ? 'opacity-30 cursor-not-allowed' : ''
              ]"
              class="px-4 py-2 rounded-lg text-xs font-semibold tracking-wide transition-all flex items-center justify-center gap-2"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
              </svg>
              Árvore <span v-if="esMobile" class="text-[9px] font-normal opacity-60">(PC)</span>
            </button>
            <button 
              @click="view = 'list'" 
              :class="view === 'list' ? 'bg-[#2C3E50] dark:bg-[#FFD700] text-white dark:text-slate-950 shadow-md font-bold' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
              class="px-4 py-2 rounded-lg text-xs font-semibold tracking-wide transition-all flex items-center justify-center gap-2"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
              </svg>
              Lista
            </button>
          </div>

          <div class="text-right min-w-[100px]">
            <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest">Total na Rede</p>
            <p class="text-2xl font-bold text-[#2C3E50] dark:text-[#FFD700] mt-0.5">
              <span v-if="carregando" class="text-sm text-slate-400 font-normal">...</span>
              <span v-else class="bg-amber-100 dark:bg-amber-500/10 text-[#2C3E50] dark:text-[#FFD700] px-3 py-0.5 rounded-full text-xl font-extrabold border border-amber-200/60 dark:border-amber-500/20 shadow-sm">{{ totalNaRede }}</span>
            </p>
          </div>
        </div>
      </div>

      <div v-if="carregando" class="flex flex-col items-center justify-center py-20 gap-3">
        <div class="w-10 h-10 border-4 border-slate-200 dark:border-slate-800 border-t-[#FFD700] rounded-full animate-spin"></div>
        <p class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-widest">Buscando estrutura de rede...</p>
      </div>

      <div v-else>
        <div 
          v-show="view === 'tree'" 
          class="hidden md:block custom-scroll overflow-x-auto rounded-3xl border border-slate-200 dark:border-slate-800/80 shadow-inner pb-16 pt-8 px-6 bg-slate-50 dark:bg-slate-950 bg-[radial-gradient(#cbd5e1_1.2px,transparent_1.2px)] dark:bg-[radial-gradient(#1e293b_1.2px,transparent_1.2px)] bg-[size:20px_20px] transition-colors duration-300"
        >
          <div class="tree min-w-max flex justify-center scale-95 origin-top transition-transform duration-500">
            <ul v-if="estruturaArvore && estruturaArvore.length > 0">
              <MembroItem 
                v-for="membro in estruturaArvore" 
                :key="membro.id" 
                :membro="membro" 
                :nivel="0" 
              />
            </ul>
          </div>
        </div>

        <div v-show="view === 'list'" class="space-y-8 md:space-y-12">
          
          <section>
            <div class="flex items-center gap-3 mb-6">
              <span class="bg-gradient-to-r from-[#2C3E50] to-[#34495E] dark:from-slate-800 dark:to-slate-900 text-[#FFD700] w-6 h-6 flex items-center justify-center rounded-md text-xs font-bold shadow-sm border dark:border-slate-700/80">1</span>
              <h3 class="text-xs md:text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Nível 1 - Diretas</h3>
              <div class="h-px bg-slate-200 dark:bg-slate-800 flex-grow"></div>
              <button 
                v-if="filtroDiretaId" 
                @click="filtroDiretaId = null" 
                class="text-[10px] bg-amber-50 dark:bg-amber-950/40 hover:bg-amber-100 dark:hover:bg-amber-900/40 text-amber-700 dark:text-amber-400 px-3 py-1 rounded-full font-bold border border-amber-200 dark:border-amber-800/60 transition-all uppercase tracking-wider"
              >
                Limpar Filtro
              </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
              <div 
                v-for="direta in (estruturaArvore[0]?.subordinados || [])" 
                :key="direta.id"
                @click="filtroDiretaId = direta.id" 
                :class="filtroDiretaId === direta.id 
                  ? 'bg-gradient-to-br from-[#2C3E50] to-[#1A252F] dark:from-slate-800 dark:to-slate-900 border-[#FFD700] ring-4 ring-[#FFD700]/20 text-white shadow-xl' 
                  : 'border-slate-200/80 dark:border-slate-800/80 bg-white dark:bg-slate-900 shadow-sm hover:border-slate-300 dark:hover:border-slate-700 text-slate-800 dark:text-slate-200'"
                class="p-4 md:p-5 rounded-3xl border transition-all duration-300 cursor-pointer group flex items-center justify-between hover:shadow-md hover:-translate-y-0.5"
              >
                <div class="flex items-center gap-3 md:gap-4">
                  <img 
                    :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(direta.nome)}&background=${filtroDiretaId === direta.id ? '2C3E50' : 'f1f5f9'}&color=${filtroDiretaId === direta.id ? 'FFD700' : '2C3E50'}&bold=true`" 
                    :class="filtroDiretaId === direta.id ? 'border-amber-400/40' : 'border-slate-200 dark:border-slate-700'"
                    class="w-10 h-10 md:w-12 md:h-12 rounded-2xl border object-cover shadow-sm transition-colors duration-300"
                    alt="Avatar"
                  >
                  <div>
                    <h4 class="text-sm font-bold transition-colors duration-300" :class="filtroDiretaId === direta.id ? 'text-white' : 'text-slate-800 dark:text-slate-200'">
                      {{ direta.nome }}
                    </h4>
                    <p class="text-[11px] font-medium tracking-wide mt-0.5 transition-colors duration-300" :class="filtroDiretaId === direta.id ? 'text-amber-300/80' : 'text-slate-400 dark:text-slate-500'">
                      {{ direta.subordinados?.length || 0 }} Consultoras N2
                    </p>
                  </div>
                </div>
                <svg :class="filtroDiretaId === direta.id ? 'text-[#FFD700] rotate-90 scale-110' : 'text-slate-300 dark:text-slate-700 group-hover:text-slate-400 dark:group-hover:text-slate-500'" class="w-4 h-4 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
              </div>
            </div>
          </section>

          <section>
            <div class="flex items-center gap-3 mb-6">
              <span class="bg-gradient-to-r from-slate-200 to-slate-300 dark:from-slate-800 dark:to-slate-900 text-slate-600 dark:text-slate-400 w-6 h-6 flex items-center justify-center rounded-md text-xs font-bold border border-slate-300/60 dark:border-slate-700/60 shadow-sm">2</span>
              <h3 class="text-xs md:text-sm font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Nível 2 - Equipe</h3>
            </div>

            <div v-if="filtrarNivel2.length > 0" class="hidden md:block bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/70 dark:border-slate-800/70 shadow-lg overflow-hidden">
              <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-950/40 border-b border-slate-200/60 dark:border-slate-800/60">
                  <tr>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Consultora</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Indicada por</th>
                    <th class="px-8 py-5 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">Status</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                  <tr v-for="indireta in filtrarNivel2" :key="indireta.id" class="hover:bg-slate-50/80 dark:hover:bg-slate-950/20 transition-colors">
                    <td class="px-8 py-5">
                      <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-950/50 flex items-center justify-center text-[11px] font-bold text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-800">
                          {{ indireta.nome.substring(0,2).toUpperCase() }}
                        </div>
                        <div>
                          <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 block">{{ indireta.nome }}</span>
                          <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono">ID: #{{ indireta.id }}</span>
                        </div>
                      </div>
                    </td>
                    <td class="px-8 py-5 text-xs font-medium text-slate-500 dark:text-slate-400">{{ indireta.indicadaPor }}</td>
                    <td class="px-8 py-5 text-center">
                      <span class="text-[10px] font-semibold bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 px-3 py-1 rounded-full uppercase tracking-wider border border-emerald-200/40 dark:border-emerald-800/40 shadow-sm">Ativa</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div v-if="filtrarNivel2.length > 0" class="md:hidden space-y-3">
              <div v-for="indireta in filtrarNivel2" :key="indireta.id" class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
                <div class="flex justify-between items-center mb-2">
                  <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ indireta.nome }}</span>
                  <span class="text-[9px] font-bold bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 px-2 py-0.5 rounded uppercase tracking-wider border border-emerald-100 dark:border-emerald-800/40">Ativa</span>
                </div>
                <div class="flex justify-between items-center text-[11px]">
                  <span class="text-slate-400 dark:text-slate-500 font-medium">Indicada por:</span>
                  <span class="text-slate-600 dark:text-slate-300 font-semibold">{{ indireta.indicadaPor }}</span>
                </div>
              </div>
            </div>
            
            <div v-else class="text-center py-12 text-slate-400 dark:text-slate-500 text-xs italic bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800">
              Nenhuma consultora indireta encontrada para o filtro selecionado.
            </div>
          </section>
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

/* MODIFICAÇÃO AQUI: .tree-viewport removido daqui pois está 100% inline no Tailwind agora */

:deep(.tree) * {
  box-sizing: border-box;
}

:deep(.tree) ul {
  padding-top: 35px; 
  position: relative;
  display: flex !important;
  flex-direction: row !important;
  justify-content: center;
  align-items: flex-start;
  padding-left: 0;
  margin: 0;
  transition: all 0.5s;
}

:deep(.tree) li {
  text-align: center;
  list-style-type: none;
  position: relative;
  padding: 35px 14px 0 14px;
  transition: all 0.5s;
  display: block !important;
  flex: 0 1 auto !important;
}

:deep(.tree) li::before, :deep(.tree) li::after {
  content: '';
  position: absolute; 
  top: 0; 
  right: 50%;
  border-top: 2px solid #94a3b8;
  width: 50%; 
  height: 35px;
}
:global(.dark) :deep(.tree) li::before, :global(.dark) :deep(.tree) li::after {
  border-top-color: #334155;
}

:deep(.tree) li::after {
  right: auto; 
  left: 50%;
  border-left: 2px solid #94a3b8;
}
:global(.dark) :deep(.tree) li::after {
  border-left-color: #334155;
}

:deep(.tree) li:only-child::after, :deep(.tree) li:only-child::before {
  display: none;
}

:deep(.tree) li:only-child { 
  padding-top: 0;
}

:deep(.tree) li:first-child::before, :deep(.tree) li:last-child::after {
  border: 0 none;
}

:deep(.tree) li:last-child::before {
  border-right: 2px solid #94a3b8;
  border-radius: 0 16px 0 0;
}
:global(.dark) :deep(.tree) li:last-child::before {
  border-right-color: #334155;
}

:deep(.tree) li:first-child::after {
  border-radius: 16px 0 0 0;
}

:deep(.tree) ul ul::before {
  content: '';
  position: absolute; 
  top: 0; 
  left: 50%;
  border-left: 2px solid #94a3b8;
  width: 0; 
  height: 35px;
}
:global(.dark) :deep(.tree) ul ul::before {
  border-left-color: #334155;
}

.custom-scroll::-webkit-scrollbar { 
  height: 8px; 
}
.custom-scroll::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 10px;
}
:global(.dark) .custom-scroll::-webkit-scrollbar-track {
  background: #0f172a;
}

.custom-scroll::-webkit-scrollbar-thumb { 
  background: #cbd5e1; 
  border-radius: 10px; 
}
:global(.dark) .custom-scroll::-webkit-scrollbar-thumb {
  background: #334155;
}

.custom-scroll::-webkit-scrollbar-thumb:hover {
  background: #2C3E50;
}
:global(.dark) .custom-scroll::-webkit-scrollbar-thumb:hover {
  background: #FFD700;
}
</style>