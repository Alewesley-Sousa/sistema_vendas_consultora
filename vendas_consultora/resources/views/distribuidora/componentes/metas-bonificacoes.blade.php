<div class="p-6 space-y-6">
    <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Atingimento de Metas e Escalonamento</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-widest bg-slate-50">
                    <th class="py-3 px-4">Profissional</th>
                    <th class="py-3 px-4">Valor Meta</th>
                    <th class="py-3 px-4">Realizado</th>
                    <th class="py-3 px-4">Progresso</th>
                    <th class="py-3 px-4">Bônus Gerado</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="item in dados.metas_bonificacoes.metas" :key="item.id">
                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-all font-medium text-slate-600">
                        <td class="py-3.5 px-4 font-semibold text-slate-900" x-text="item.nome"></td>
                        <td class="py-3.5 px-4" x-text="'R$ ' + item.valor_meta"></td>
                        <td class="py-3.5 px-4 font-bold text-slate-900" x-text="'R$ ' + item.vendas_realizadas"></td>
                        <td class="py-3.5 px-4 text-emerald-600 font-bold" x-text="item.percentual_atingimento + '%'"></td>
                        <td class="py-3.5 px-4 text-indigo-600 font-bold" x-text="'R$ ' + item.bonificacao"></td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
