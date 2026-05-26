<div class="p-6 space-y-8 bg-white rounded-2xl shadow-sm border border-slate-100">
    
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-5">
        <div>
            <h3 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <span>📦</span> Giro de Produtos Global
            </h3>
            <p class="text-sm text-slate-500 mt-0.5">Visão estratégica de rotatividade, vendas e criticidade de estoque.</p>
        </div>
        <div>
            <span class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-black text-emerald-700 bg-emerald-50 rounded-xl border border-emerald-100 shadow-sm">
                Faturamento Total: R$ 
                <span x-text="dados.analise_produtos?.dados?.resumo?.faturamento_total ? parseFloat(dados.analise_produtos.dados.resumo.faturamento_total).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) : '0,00'"></span>
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-slate-50/60 border border-slate-100 p-4 rounded-xl flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center text-lg shadow-sm">📊</div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Produtos Analisados</p>
                <h4 class="text-xl font-black text-slate-800 tracking-tight mt-0.5" x-text="dados.analise_produtos?.dados?.resumo?.total_produtos_analisados || '0'"></h4>
            </div>
        </div>

        <div class="bg-slate-50/60 border border-slate-100 p-4 rounded-xl flex items-center gap-4">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-lg shadow-sm border"
                 :class="dados.analise_produtos?.dados?.resumo?.produtos_estoque_critico > 0 ? 'bg-rose-50 border-rose-100' : 'bg-slate-50 border-slate-100'">
                 ⚠️
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Estoque Crítico (≤ 10)</p>
                <h4 class="text-xl font-black tracking-tight mt-0.5" 
                    :class="dados.analise_produtos?.dados?.resumo?.produtos_estoque_critico > 0 ? 'text-rose-600' : 'text-slate-800'"
                    x-text="dados.analise_produtos?.dados?.resumo?.produtos_estoque_critico ?? '0'"></h4>
            </div>
        </div>

        <div class="bg-slate-50/60 border border-slate-100 p-4 rounded-xl flex items-center gap-4 sm:col-span-2 lg:col-span-1">
            <div class="w-10 h-10 rounded-lg bg-amber-50 border border-amber-100 flex items-center justify-center text-lg shadow-sm">💡</div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rotatividade</p>
                <p class="text-xs text-slate-500 font-medium leading-relaxed mt-0.5">Calculada com base na razão (Total Vendido / Estoque Atual).</p>
            </div>
        </div>
    </div>

    <div class="overflow-hidden border border-slate-100 rounded-xl shadow-sm bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-wider">
                        <th class="py-4 px-5">Produto</th>
                        <th class="py-4 px-5 text-center w-36">Total Vendido</th>
                        <th class="py-4 px-5 text-center w-36">Preço Médio</th>
                        <th class="py-4 px-5 text-center w-36">Faturamento total</th>
                        <th class="py-4 px-5 text-center w-36">Estoque Atual</th>
                        <th class="py-4 px-5 text-right w-36">Rotatividade</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm text-slate-600">
                    
                    <template x-if="!dados.analise_produtos?.dados?.produtos || dados.analise_produtos.dados.produtos.length === 0">
                        <tr>
                            <td colspan="6" class="py-12 text-center text-sm text-slate-400 font-medium bg-slate-50/20">
                                Nenhum produto movimentado no período selecionado.
                            </td>
                        </tr>
                    </template>

                    <template x-if="dados.analise_produtos?.dados?.produtos">
                        <template x-for="item in dados.analise_produtos.dados.produtos" :key="item.id">
                            <tr class="hover:bg-slate-50/40 transition-colors group">
                                
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-7 h-7 rounded-md bg-slate-100 text-slate-500 text-xs font-bold flex items-center justify-center uppercase group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors" x-text="item.nome.substring(0, 1)"></div>
                                        <div class="font-bold text-slate-900" x-text="item.nome"></div>
                                    </div>
                                </td>
                                
                                <td class="py-4 px-5 text-center font-semibold text-slate-800 tabular-nums" x-text="item.total_vendido"></td>
                                
                                <td class="py-4 px-5 text-center text-slate-500 tabular-nums" x-text="'R$ ' + parseFloat(item.preco_medio).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></td>

                                <td class="py-4 px-5 text-center font-bold text-slate-900 tabular-nums" x-text="'R$ ' + parseFloat(item.faturamento).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></td>
                                
                                <td class="py-4 px-5 text-center font-medium tabular-nums">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold"
                                          :class="item.estoque_atual <= 10 ? 'bg-rose-50 text-rose-700 border border-rose-100' : 'bg-slate-100 text-slate-700'">
                                        <span x-text="item.estoque_atual"></span>
                                        <template x-if="item.estoque_atual <= 10">
                                            <span class="ml-1 text-[10px] uppercase font-black tracking-wider">Crítico</span>
                                        </template>
                                    </span>
                                </td>
                                
                                <td class="py-4 px-5 text-right font-black text-indigo-600 tabular-nums">
                                    <span x-text="parseFloat(item.rotatividade).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></span>
                                    <span class="text-[10px] font-bold text-indigo-400 ml-0.5">x</span>
                                </td>

                            </tr>
                        </template>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>