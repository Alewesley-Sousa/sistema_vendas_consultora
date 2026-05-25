<div class="p-6 space-y-6">
    <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Top Rankings</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-widest bg-slate-50">
                    <th class="py-3 px-4">Posição</th>
                    <th class="py-3 px-4">Nome</th>
                    <th class="py-3 px-4">Telefone</th>
                    <th class="py-3 px-4">Volume</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item, index) in dados.ranking_consultoras" :key="item.id">
                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-all font-medium text-slate-600">
                        <td class="py-3.5 px-4 font-bold text-slate-900" x-text="(index + 1) + 'º'"></td>
                        <td class="py-3.5 px-4 font-semibold text-slate-900" x-text="item.nome"></td>
                        <td class="py-3.5 px-4 text-slate-400" x-text="item.telefone || 'Não informado'"></td>
                        <td class="py-3.5 px-4 font-bold text-slate-900" x-text="item.total"></td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
