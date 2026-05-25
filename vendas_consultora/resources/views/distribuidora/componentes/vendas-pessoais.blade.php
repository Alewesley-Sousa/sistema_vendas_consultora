<div class="p-6 space-y-6" x-data="{ 
    formatarMoeda(valor) {
        return 'R$ ' + Number(valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    },
    formatarPeriodo(mesAno) {
        if(!mesAno) return '';
        const [ano, mes] = mesAno.split('-');
        const meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        return meses[parseInt(mes) - 1] + '/' + ano;
    }
}">
    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
        <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Histórico de Vendas Pessoais</h3>
        <span class="text-[10px] bg-slate-100 text-slate-600 font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
            Sua Performance
        </span>
    </div>

    <div class="overflow-x-auto rounded-xl border border-slate-100">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-widest bg-slate-50/70">
                    <th class="py-3 px-4">Período</th>
                    <th class="py-3 px-4 text-center">Total Pedidos</th>
                    <th class="py-3 px-4 text-right">Total Vendido</th>
                    <th class="py-3 px-4 text-right">Ticket Médio</th>
                </tr>
            </thead>
            <tbody>
                <template x-if="!dados.vendas_pessoais || dados.vendas_pessoais.length === 0">
                    <tr>
                        <td colspan="4" class="py-10 text-center text-slate-400 font-medium uppercase tracking-wider">
                            Nenhum registro de venda encontrado para este período.
                        </td>
                    </tr>
                </template>

                <template x-for="item in dados.vendas_pessoais" :key="item.periodo">
                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-all font-medium text-slate-600">
                        <td class="py-3.5 px-4 font-semibold text-slate-900" x-text="formatarPeriodo(item.periodo)"></td>
                        <td class="py-3.5 px-4 text-center text-slate-700 font-mono" x-text="item.total_pedidos"></td>
                        <td class="py-3.5 px-4 text-right font-bold text-slate-900" x-text="formatarMoeda(item.total_vendas)"></td>
                        <td class="py-3.5 px-4 text-right font-semibold text-emerald-600" x-text="formatarMoeda(item.ticket_medio)"></td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
