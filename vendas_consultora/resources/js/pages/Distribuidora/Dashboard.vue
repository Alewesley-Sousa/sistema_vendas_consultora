<template>
  <AdminLayout>
    <div class="space-y-8">
      
      <!-- Estado de Carregamento -->
      <div v-if="loading" class="flex flex-col items-center justify-center py-24 space-y-4">
        <div class="animate-spin rounded-full h-9 w-9 border-b-2 border-indigo-600"></div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest animate-pulse">Sincronizando com a API Comercial...</p>
      </div>

      <!-- Estado de Erro -->
      <div v-else-if="erro" class="p-6 bg-rose-50 border border-rose-100 rounded-2xl text-rose-700 text-center font-bold uppercase tracking-wider dark:bg-rose-950/20 dark:border-rose-900/50 dark:text-rose-400">
        ⚠️ Erro de comunicação. Verifique a API.
      </div>

      <!-- Conteúdo Principal -->
      <div v-else class="space-y-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Painel Executivo</h1>
            <p class="text-slate-500 dark:text-slate-400 font-medium">Visão macro de desempenho da rede de distribuição.</p>
          </div>
          <button class="px-5 py-2.5 bg-slate-900 dark:bg-white dark:text-slate-900 text-white text-xs font-bold uppercase tracking-wider rounded-xl hover:opacity-90 transition-all shadow-lg">
            Gerar Relatório Completo
          </button>
        </div>

        <!-- Cards de KPI -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
          <KPICard title="Faturamento Alvo" :target-value="dados.resumo.faturamento_total_metas" icon="fa-sack-dollar" color="text-indigo-600 dark:text-indigo-400" />
          <KPICard title="Volume Realizado" :target-value="dados.resumo.vendas_totais_realizadas" icon="fa-chart-line" color="text-emerald-600 dark:text-emerald-400" />
          <KPICard title="Bônus a Pagar" :target-value="dados.resumo.total_bonificacoes_pagar" icon="fa-money-bill-wave" color="text-violet-600 dark:text-violet-400" />
          <KPICard title="Em Alerta" :target-value="dados.resumo.consultoras_em_alerta" icon="fa-exclamation-triangle" color="text-rose-500" :decimals="0" :prefix="''" />
        </div>

        <!-- Gráficos -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <div class="lg:col-span-2 bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6">Comparativo de Metas</h3>
            <div ref="chartBar" class="h-64"></div>
          </div>
          <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6">Status do Ecossistema</h3>
            <div ref="chartPie" class="h-64"></div>
          </div>
        </div>

        <!-- Tabela Gerencial -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm">
          <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6">Status de Alvos Recentes</h3>
          <div class="overflow-x-auto">
            <table class="w-full text-left">
              <thead>
                <tr class="text-slate-400 dark:text-slate-500 uppercase text-[10px] tracking-widest border-b border-slate-100 dark:border-slate-800">
                  <th class="p-3">Consultora</th>
                  <th class="p-3 text-right">Meta</th>
                  <th class="p-3 text-right">Realizado</th>
                  <th class="p-3 text-center">Atingimento</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                <tr v-for="item in dados.metas" :key="item.id" class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                  <td class="p-3 font-bold text-slate-900 dark:text-slate-100">{{ item.nome }}</td>
                  <td class="p-3 text-right text-slate-600 dark:text-slate-300">R$ {{ Number(item.valor_meta).toLocaleString('pt-BR') }}</td>
                  <td class="p-3 text-right font-bold text-emerald-600 dark:text-emerald-400">R$ {{ Number(item.vendas_realizadas).toLocaleString('pt-BR') }}</td>
                  <td class="p-3 text-center">
                    <span class="px-2 py-1 rounded-lg text-[10px] font-black bg-indigo-50 text-indigo-700 dark:bg-indigo-950/50 dark:text-indigo-300">
                      {{ Number(item.percentual_atingimento).toFixed(1) }}%
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue';
import axios from 'axios';
import ApexCharts from 'apexcharts';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import KPICard from '@/Pages/Distribuidora/Partials/KPICard.vue';

const dados = ref(null);
const loading = ref(true);
const erro = ref(false);
const chartBar = ref(null);
const chartPie = ref(null);

const carregarDados = async () => {
    try {
        const response = await axios.get('/api/relatorios/metas-bonificacoes');
        dados.value = response.data.data.dados;
        loading.value = false;
        
        // Aguarda o Vue injetar o HTML estruturado no DOM antes de rodar os gráficos
        await nextTick();
        renderizarGraficos();
    } catch (e) {
        erro.value = true;
        loading.value = false;
    }
};

const renderizarGraficos = () => {
    if (!chartBar.value) return; // Proteção caso o componente tenha sido desmontado
    
    const optionsBar = {
        // ... Suas opções originais do ApexCharts aqui ...
        chart: { type: 'bar', height: '100%' },
        series: [{ name: 'Meta', data: [/* dados mapeados */] }]
    };
    
    new ApexCharts(chartBar.value, optionsBar).render();
    // Replique a lógica acima para o chartPie se necessário
};

onMounted(carregarDados);
</script>