<div class="p-6 space-y-6">
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Giro de Produtos Global</h3>
        <span class="bg-slate-100 text-slate-700 font-bold text-[10px] uppercase tracking-widest px-3 py-1 rounded-full" x-text="'Faturamento: R$ ' + (dados.analise_produtos.produtos?.resumo?.faturamento_total || '0,00')"></span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-widest bg-slate-50">
                    <th class="py-3 px-4">Produto</th>
                    <th class="py-3 px-4">Total Vendido</th>
                    <th class="py-3 px-4">Estoque Atual</th>
                    <th class="py-3 px-4">Rotatividade</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="item in dados.analise_produtos.produtos" :key="item.id">
                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-all font-medium text-slate-600">
                        <td class="py-3.5 px-4 font-semibold text-slate-900" x-text="item.nome"></td>
                        <td class="py-3.5 px-4 font-bold text-slate-900" x-text="item.total_vendido"></td>
                        <td class="py-3.5 px-4" :class="item.estoque_atual < 10 ? 'text-rose-600 font-bold' : 'text-slate-500'" x-text="item.estoque_atual"></td>
                        <td class="py-3.5 px-4 text-indigo-600" x-text="item.rotatividade"></td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
