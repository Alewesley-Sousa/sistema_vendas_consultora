<div class="p-6 space-y-8 bg-white rounded-2xl shadow-sm border border-slate-100">
    <!-- Cabeçalho -->
    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
        <div>
            <h3 class="text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                <span class="text-xl">🏆</span> Ranking de Desempenho
            </h3>
            <p class="text-sm text-slate-500 mt-0.5">As consultoras que mais se destacaram no período.</p>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-indigo-700 bg-indigo-50 rounded-full border border-indigo-100">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
            Atualizado em tempo real
        </span>
    </div>

    <!-- PÓDIO: Destaque para o Top 3 (Exibido apenas se houver dados) -->
    <template x-if="dados.ranking_consultoras && dados.ranking_consultoras.length > 0">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end pt-4">
            
            <!-- 2º Lugar (Aparece primeiro no grid do desktop para efeito visual de pódio) -->
            <template x-if="dados.ranking_consultoras[1]">
                <div class="bg-gradient-to-b from-slate-50 to-white border border-slate-200/60 rounded-xl p-5 text-center shadow-sm order-2 md:order-1 relative overflow-hidden md:h-44 flex flex-col justify-center">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-slate-400"></div>
                    <div class="w-10 h-10 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center font-black mx-auto text-lg shadow-inner border border-slate-200">2</div>
                    <h4 class="font-bold text-slate-800 mt-3 truncate" x-text="dados.ranking_consultoras[1].nome"></h4>
                    <p class="text-xs text-slate-400" x-text="dados.ranking_consultoras[1].telefone || 'Sem telefone'"></p>
                    <p class="text-lg font-black text-slate-700 mt-2" x-text="'R$ ' + parseFloat(dados.ranking_consultoras[1].total).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></p>
                </div>
            </template>

            <!-- 1º Lugar (O maior card, no centro) -->
            <template x-if="dados.ranking_consultoras[0]">
                <div class="bg-gradient-to-b from-amber-50/60 to-white border-2 border-amber-200 rounded-2xl p-6 text-center shadow-md order-1 md:order-2 relative overflow-hidden md:h-52 flex flex-col justify-center transform hover:scale-[1.02] transition-all">
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-amber-400 to-yellow-500"></div>
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-yellow-500 text-white rounded-full flex items-center justify-center font-black mx-auto text-2xl shadow-md border-4 border-white">🥇</div>
                    <h4 class="font-black text-slate-900 mt-3 text-lg truncate" x-text="dados.ranking_consultoras[0].nome"></h4>
                    <p class="text-xs text-amber-700 font-medium bg-amber-100/60 px-2 py-0.5 rounded-full inline-block mx-auto mt-0.5" x-text="dados.ranking_consultoras[0].telefone || 'Sem telefone'"></p>
                    <p class="text-2xl font-black text-amber-600 mt-3 tracking-tight" x-text="'R$ ' + parseFloat(dados.ranking_consultoras[0].total).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></p>
                </div>
            </template>

            <!-- 3º Lugar -->
            <template x-if="dados.ranking_consultoras[2]">
                <div class="bg-gradient-to-b from-orange-50/30 to-white border border-orange-200/60 rounded-xl p-5 text-center shadow-sm order-3 relative overflow-hidden md:h-40 flex flex-col justify-center">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-orange-300"></div>
                    <div class="w-10 h-10 bg-orange-50 text-orange-700 rounded-full flex items-center justify-center font-black mx-auto text-lg shadow-inner border border-orange-100">3</div>
                    <h4 class="font-bold text-slate-800 mt-3 truncate" x-text="dados.ranking_consultoras[2].nome"></h4>
                    <p class="text-xs text-slate-400" x-text="dados.ranking_consultoras[2].telefone || 'Sem telefone'"></p>
                    <p class="text-lg font-black text-orange-800 mt-2" x-text="'R$ ' + parseFloat(dados.ranking_consultoras[2].total).toLocaleString('pt-BR', {minimumFractionDigits: 2})"></p>
                </div>
            </template>

        </div>
    </template>

    <!-- TABELA COMPLETA (Do 4º lugar em diante ou lista geral com scroll moderno) -->
    <div class="overflow-hidden border border-slate-100 rounded-xl shadow-sm bg-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-wider">
                        <th class="py-4 px-5 text-center w-20">Posição</th>
                        <th class="py-4 px-5">Consultora</th>
                        <th class="py-4 px-5">Contato</th>
                        <th class="py-4 px-5 text-right">Volume de Vendas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm text-slate-600">
                    <template x-for="(item, index) in dados.ranking_consultoras" :key="item.id">
                        <tr class="hover:bg-slate-50/40 transition-colors group">
                            <!-- Posição com Badges Customizados -->
                            <td class="py-4 px-5 text-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full font-bold text-xs"
                                      :class="{
                                          'bg-amber-100 text-amber-800 font-black': index === 0,
                                          'bg-slate-200 text-slate-800 font-black': index === 1,
                                          'bg-orange-100 text-orange-800 font-black': index === 2,
                                          'bg-slate-50 text-slate-500 font-semibold border border-slate-100': index > 2
                                      }"
                                      x-text="(index + 1) + 'º'">
                                </span>
                            </td>
                            
                            <!-- Nome com iniciais/avatar simulado -->
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 font-bold text-xs text-slate-600 flex items-center justify-center uppercase group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-colors" 
                                         x-text="item.nome.substring(0, 2)">
                                    </div>
                                    <div class="font-semibold text-slate-900" x-text="item.nome"></div>
                                </div>
                            </td>
                            
                            <!-- Telefone Formatado de forma discreta -->
                            <td class="py-4 px-5 text-slate-500 font-medium">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span x-text="item.telefone || 'Não informado'"></span>
                                </span>
                            </td>
                            
                            <!-- Volume Financeiro Formatado em Reais -->
                            <td class="py-4 px-5 text-right font-bold text-slate-900 tabular-nums">
                                <span class="text-xs font-normal text-slate-400 mr-0.5">R$</span>
                                <span x-text="parseFloat(item.total).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>