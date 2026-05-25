<div class="p-6 space-y-6">
    <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Estrutura e Crescimento Operacional</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50 p-5 rounded-2xl border border-slate-100">
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total na Rede Operacional</p>
            <p class="text-xl font-extrabold text-slate-900 mt-1" x-text="dados.crescimento_rede.resumo?.total_na_rede || 0"></p>
        </div>
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Taxa de Retenção Trimestral</p>
            <p class="text-xl font-extrabold text-emerald-600 mt-1" x-text="(dados.crescimento_rede.resumo?.taxa_retencao_percentual || 0) + '%'"></p>
        </div>
    </div>

    <div class="overflow-x-auto pt-4">
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Novos Cadastros por Período</p>
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-widest bg-slate-50">
                    <th class="py-3 px-4">Mês de Referência</th>
                    <th class="py-3 px-4">Novos Membros Habilitados</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="item in dados.crescimento_rede.evolucao_mensal" :key="item.mes">
                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-all font-medium text-slate-600">
                        <td class="py-3.5 px-4 font-semibold text-slate-900" x-text="item.mes"></td>
                        <td class="py-3.5 px-4 font-bold text-slate-900" x-text="item.novos"></td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
