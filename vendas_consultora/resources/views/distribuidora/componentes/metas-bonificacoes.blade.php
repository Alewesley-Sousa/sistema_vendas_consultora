<div class="p-6 space-y-6" 
     x-data="{ 
        dados: null,
        loading: true,
        erro: false,

        init() {
            // Consome a rota do Laravel usando Axios
            axios.get('/api/relatorios/metas-bonificacoes')
                .then(response => {
                    // Mapeia exatamente a estrutura aninhada que sua API retorna: response.data.data.dados
                    if (response.data && response.data.data && response.data.data.dados) {
                        this.dados = response.data.data.dados;
                    } else {
                        this.erro = true;
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar metas:', error);
                    this.erro = true;
                })
                .finally(() => {
                    this.loading = false;
                });
        }
     }">

    <template x-if="loading">
        <div class="flex items-center justify-center py-12">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
            <span class="ml-3 text-sm font-medium text-slate-500">Buscando metas da equipe...</span>
        </div>
    </template>

    <template x-if="erro && !loading">
        <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl text-rose-700 text-sm font-medium text-center">
            ⚠️ Não foi possível carregar os dados de metas e bonificações. Verifique a API.
        </div>
    </template>

    <template x-if="!loading && !erro && dados">
        <div class="space-y-6">
            
            <template x-if="dados.resumo">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Faturamento Total Alvo (Metas)</span>
                        <span class="text-xl font-extrabold text-slate-800" x-text="'R$ ' + Number(dados.resumo.faturamento_total_metas).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                    </div>
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Vendas Totais Realizadas</span>
                        <span class="text-xl font-extrabold text-emerald-600" x-text="'R$ ' + Number(dados.resumo.vendas_totais_realizadas).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                    </div>
                    <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Atingimento Coletivo</span>
                        <span class="text-xl font-extrabold text-indigo-600" x-text="Number(dados.resumo.percentual_coletivo).toFixed(2) + '%'"></span>
                    </div>
                </div>
            </template>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pt-2">
                <h3 class="text-base font-bold text-slate-800 uppercase tracking-wider">Atingimento de Metas e Escalonamento</h3>
                <template x-if="dados.regra_aplicada">
                    <span class="text-xs font-bold bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full w-fit border border-indigo-100" x-text="dados.regra_aplicada"></span>
                </template>
            </div>

            <div class="overflow-x-auto border border-slate-100 rounded-xl bg-white shadow-sm">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-widest bg-slate-50/80">
                            <th class="py-3 px-4">Profissional</th>
                            <th class="py-3 px-4">Data Referência</th>
                            <th class="py-3 px-4 text-right">Valor Meta</th>
                            <th class="py-3 px-4 text-right">Realizado</th>
                            <th class="py-3 px-4 text-center w-48">Progresso</th>
                            <th class="py-3 px-4 text-right">Bônus Gerado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-if="!dados.metas || dados.metas.length === 0">
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 font-medium">
                                    Nenhuma meta ou informação encontrada para o período.
                                </td>
                            </tr>
                        </template>

                        <template x-if="dados.metas" x-for="item in dados.metas" :key="item.id">
                            <tr class="border-b border-slate-100 hover:bg-slate-50/40 transition-all font-medium text-slate-600">
                                <td class="py-3.5 px-4 font-semibold text-slate-900" x-text="item.nome"></td>
                                
                                <td class="py-3.5 px-4 text-slate-400" x-text="new Date(item.data_referencia).toLocaleDateString('pt-BR', {month: '2-digit', year: 'numeric'})"></td>
                                
                                <td class="py-3.5 px-4 text-right font-semibold text-slate-700" x-text="'R$ ' + Number(item.valor_meta).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></td>
                                
                                <td class="py-3.5 px-4 text-right font-bold text-slate-900" x-text="'R$ ' + Number(item.vendas_realizadas).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></td>
                                
                                <td class="py-3.5 px-4 text-center">
                                    <div class="flex flex-col items-center justify-center gap-1">
                                        <span class="text-[11px] font-bold" 
                                              :class="item.percentual_atingimento >= 100 ? 'text-emerald-600' : (item.percentual_atingimento > 0 ? 'text-blue-600' : 'text-slate-400')"
                                              x-text="Number(item.percentual_atingimento).toFixed(1) + '%'">
                                        </span>
                                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden max-w-[140px]">
                                            <div class="h-full rounded-full transition-all duration-500"
                                                 :style="'width: ' + Math.min(item.percentual_atingimento, 100) + '%'"
                                                 :class="item.percentual_atingimento >= 100 ? 'bg-emerald-500' : (item.percentual_atingimento > 0 ? 'bg-blue-500' : 'bg-slate-300')">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="py-3.5 px-4 text-right font-bold"
                                    :class="item.bonificacao > 0 ? 'text-indigo-600' : 'text-slate-400'"
                                    x-text="'R$ ' + Number(item.bonificacao).toLocaleString('pt-BR', {minimumFractionDigits: 2})">
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </template>
</div>
