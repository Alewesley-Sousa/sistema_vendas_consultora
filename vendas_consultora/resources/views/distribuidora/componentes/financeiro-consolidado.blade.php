<div class="p-6 space-y-6">
    <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Fluxo de Caixa Consolidado Operacional</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Faturamento Confirmado</p>
            <p class="text-base font-extrabold text-slate-900 mt-1" x-text="'R$ ' + (dados.financeiro_consolidado.resumo_geral?.faturamento_total || '0,00')"></p>
        </div>
        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Custos Comissões</p>
            <p class="text-base font-extrabold text-rose-600 mt-1" x-text="'R$ ' + (dados.financeiro_consolidado.resumo_geral?.comissoes_totais || '0,00')"></p>
        </div>
        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Saques Efetivados</p>
            <p class="text-base font-extrabold text-rose-600 mt-1" x-text="'R$ ' + (dados.financeiro_consolidado.resumo_geral?.saques_totais || '0,00')"></p>
        </div>
        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Resultado Líquido</p>
            <p class="text-base font-extrabold text-emerald-600 mt-1" x-text="'R$ ' + (dados.financeiro_consolidado.resumo_geral?.lucro_acumulado || '0,00')"></p>
        </div>
    </div>

    <div class="overflow-x-auto pt-4">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-widest bg-slate-50">
                    <th class="py-3 px-4">Mês</th>
                    <th class="py-3 px-4">Faturamento Bruto</th>
                    <th class="py-3 px-4">Custo Operacional</th>
                    <th class="py-3 px-4">Lucro Líquido</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="item in dados.financeiro_consolidado.listagem_mensal" :key="item.mes">
                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-all font-medium text-slate-600">
                        <td class="py-3.5 px-4 font-semibold text-slate-900" x-text="item.mes"></td>
                        <td class="py-3.5 px-4 text-emerald-600 font-semibold" x-text="'R$ ' + item.faturamento_bruto"></td>
                        <td class="py-3.5 px-4 text-rose-500" x-text="'R$ ' + (parseFloat(item.custo_comissoes) + parseFloat(item.saídas_saques))"></td>
                        <td class="py-3.5 px-4 font-bold text-slate-900" x-text="'R$ ' + item.lucro_operacional"></td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
