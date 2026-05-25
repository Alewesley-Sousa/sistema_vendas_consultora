<div class="p-6 space-y-6">
    <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Métricas de Retenção e Recorrência</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-widest bg-slate-50">
                    <th class="py-3 px-4">Mês</th>
                    <th class="py-3 px-4">Clientes Atendidos</th>
                    <th class="py-3 px-4">Faturamento</th>
                    <th class="py-3 px-4">Taxa Recorrência</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="item in dados.retencao_clientes.historico" :key="item.mes">
                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-all font-medium text-slate-600">
                        <td class="py-3.5 px-4 font-semibold text-slate-900" x-text="item.mes"></td>
                        <td class="py-3.5 px-4" x-text="item.total_clientes"></td>
                        <td class="py-3.5 px-4 font-semibold text-slate-900" x-text="'R$ ' + item.faturamento"></td>
                        <td class="py-3.5 px-4 text-emerald-600 font-bold" x-text="item.taxa_recorrencia + '%'"></td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
