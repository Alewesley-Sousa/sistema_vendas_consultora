<div class="p-6 space-y-6">
    <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Detalhamento de Comissões</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-widest bg-slate-50">
                    <th class="py-3 px-4">Período</th>
                    <th class="py-3 px-4">Movimentação</th>
                    <th class="py-3 px-4">Líquido Recebido</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="item in dados.comissoes_detalhadas" :key="item.periodo + item.tipo_movimentacao">
                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-all font-medium">
                        <td class="py-3.5 px-4 font-semibold text-slate-900" x-text="item.periodo"></td>
                        <td class="py-3.5 px-4 text-slate-500" x-text="item.tipo_movimentacao"></td>
                        <td class="py-3.5 px-4 font-bold" :class="item.valor_liquido >= 0 ? 'text-emerald-600' : 'text-rose-600'" x-text="'R$ ' + item.valor_liquido"></td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
