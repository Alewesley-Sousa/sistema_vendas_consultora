<div class="p-6 space-y-6" x-data="{ 
    // Exemplo de como os seus dados devem ser mapeados após a requisição:
    // resultado: { status: 'success', data: { status: 'success', dados: { ... } } }
    // Para este componente, vamos assumir que você definiu: dados: resultado.data.dados
    dados: null 
}">

    <template x-if="dados && dados.resumo">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block mb-1">Faturamento Total Alvo (Metas)</span>
                <span class="text-xl font-bold text-slate-800" x-text="'R$ ' + Number(dados.resumo.faturamento_total_metas).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
            </div>
            <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block mb-1">Vendas Totais Realizadas</span>
                <span class="text-xl font-bold text-emerald-600" x-text="'R$ ' + Number(dados.resumo.vendas_totais_realizadas).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
            </div>
            <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                <span class="text-xxs font-bold text-slate-400 uppercase tracking-wider block mb-1">Atingimento Coletivo</span>
                <span class="text-xl font-bold text-indigo-600" x-text="dados.resumo.percentual_coletivo + '%'"></span>
            </div>
        </div>
    </template>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Atingimento de Metas e Escalonamento</h3>
        <template x-if="dados && dados.regra_aplicada">
            <span class="text-xs font-semibold bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-full w-fit" x-text="dados.regra_aplicada"></span>
        </template>
    </div>

    <div class="overflow-x-auto border border-slate-100 rounded-xl">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-widest bg-slate-50/70">
                    <th class="py-3 px-4">Profissional</th>
                    <th class="py-3 px-4">Data Referência</th>
                    <th class="py-3 px-4 text-right">Valor Meta</th>
                    <th class="py-3 px-4 text-right">Realizado</th>
                    <th class="py-3 px-4 text-center">Progresso</th>
                    <th class="py-3 px-4 text-right">Bônus Gerado</th>
                </tr>
            </thead>
            <tbody>
                <template x-if="!dados || !dados.metas || dados.metas.length === 0">
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400 font-medium">
                            Nenhuma meta ou informação encontrada.
                        </td>
                    </tr>
                </template>

                <template x-if="dados && dados.metas" x-for="item in dados.metas" :key="item.id">
                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-all font-medium text-slate-600">
                        <td class="py-3.5 px-4 font-semibold text-slate-900" x-text="item.nome"></td>
                        
                        <td class="py-3.5 px-4 text-slate-400" x-text="new Date(item.data_referencia).toLocaleDateString('pt-BR', {month: '2-digit', year: 'numeric'})"></td>
                        
                        <td class="py-3.5 px-4 text-right font-semibold text-slate-700" x-text="'R$ ' + Number(item.valor_meta).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></td>
                        
                        <td class="py-3.5 px-4 text-right font-bold text-slate-900" x-text="'R$ ' + Number(item.vendas_realizadas).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></td>
                        
                        <td class="py-3.5 px-4 text-center font-bold" 
                            :class="item.percentual_atingimento >= 100 ? 'text-emerald-600' : (item.percentual_atingimento > 0 ? 'text-amber-600' : 'text-slate-400')"
                            x-text="Number(item.percentual_atingimento).toFixed(2) + '%'">
                        </td>
                        
                        <td class="py-3.5 px-4 text-right font-bold text-indigo-600" x-text="'R$ ' + Number(item.bonificacao).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>