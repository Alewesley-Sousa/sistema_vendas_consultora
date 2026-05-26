<div class="p-6 space-y-8 animate-fade-in">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
        <div>
            <h3 class="text-base font-bold text-slate-950 uppercase tracking-wider">KPIs de Desempenho da Rede</h3>
            <p class="text-[11px] text-slate-400 mt-1">Análise volumétrica, atingimento de metas e atividade das consultoras de sua árvore hierárquica.</p>
        </div>
        <div class="bg-slate-50 border border-slate-200/60 rounded-xl px-4 py-2 text-right">
            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Período Avaliado</span>
            <span class="text-xs font-mono text-slate-700 font-semibold" 
                  x-text="dados.desempenho_rede.periodos ? new Date(dados.desempenho_rede.periodos.atual.de).toLocaleDateString('pt-BR') + ' até ' + new Date(dados.desempenho_rede.periodos.atual.ate).toLocaleDateString('pt-BR') : 'Carregando...'">
            </span>
        </div>
    </div>
    
    <div class="bg-slate-50 border border-slate-200/60 rounded-[2rem] p-6 space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Atingimento de Meta Coletiva</span>
                <div class="flex items-baseline gap-2 mt-1">
                    <h4 class="text-3xl font-black text-slate-900" x-text="(dados.desempenho_rede.resumo.atingimento_meta_percent || 0) + '%'">0%</h4>
                    <span class="text-xs text-slate-400 font-medium" x-text="'de R$ ' + (dados.desempenho_rede.resumo.total_metas || '0,00')"></span>
                </div>
            </div>
            <div>
                <span :class="{
                    'bg-emerald-50 text-emerald-700 border-emerald-200/50': (dados.desempenho_rede.resumo.atingimento_meta_percent >= 100),
                    'bg-amber-50 text-amber-700 border-amber-200/50': (dados.desempenho_rede.resumo.atingimento_meta_percent >= 50 && dados.desempenho_rede.resumo.atingimento_meta_percent < 100),
                    'bg-rose-50 text-rose-700 border-rose-200/50': (dados.desempenho_rede.resumo.atingimento_meta_percent < 50)
                }" class="px-3 py-1.5 rounded-lg text-[10px] font-extrabold uppercase tracking-widest border" 
                   x-text="dados.desempenho_rede.resumo.atingimento_meta_percent >= 100 ? 'Meta Superada' : 'Em Evolução'">
                </span>
            </div>
        </div>
        
        <div class="w-full bg-slate-200 h-2.5 rounded-full overflow-hidden shadow-inner">
            <div :style="`width: ${Math.min(dados.desempenho_rede.resumo.atingimento_meta_percent || 0, 100)}%`"
                 :class="{
                    'bg-emerald-500': (dados.desempenho_rede.resumo.atingimento_meta_percent >= 100),
                    'bg-amber-500': (dados.desempenho_rede.resumo.atingimento_meta_percent >= 50 && dados.desempenho_rede.resumo.atingimento_meta_percent < 100),
                    'bg-rose-500': (dados.desempenho_rede.resumo.atingimento_meta_percent < 50)
                 }"
                 class="h-full rounded-full transition-all duration-1000 ease-out">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="bg-white border border-slate-200 rounded-3xl p-6 flex flex-col justify-between transition-all hover:shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Volume Total Comercializado</span>
                    <h4 class="text-2xl font-black text-slate-900 mt-2" x-text="'R$ ' + (dados.desempenho_rede.resumo.vendas_atuais ? parseFloat(dados.desempenho_rede.resumo.vendas_atuais).toLocaleString('pt-BR', {minimumFractionDigits: 2}) : '0,00')">R$ 0,00</h4>
                </div>
                <div class="flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-bold tracking-wide border"
                     :class="dados.desempenho_rede.resumo.crescimento_percent >= 0 ? 'bg-emerald-50 text-emerald-700 border-emerald-200/40' : 'bg-rose-50 text-rose-700 border-rose-200/40'">
                    <span x-text="dados.desempenho_rede.resumo.crescimento_percent >= 0 ? '▲' : '▼'"></span>
                    <span x-text="(dados.desempenho_rede.resumo.crescimento_percent || 0) + '%'"></span>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                <span>Período anterior:</span>
                <strong class="text-slate-700 font-mono" x-text="'R$ ' + (dados.desempenho_rede.resumo.vendas_anteriores ? parseFloat(dados.desempenho_rede.resumo.vendas_anteriores).toLocaleString('pt-BR', {minimumFractionDigits: 2}) : '0,00')"></strong>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-6 flex flex-col justify-between transition-all hover:shadow-sm">
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Engajamento de Consultoras</span>
                
                <div class="grid grid-cols-2 gap-4 mt-3">
                    <div class="bg-slate-50 border border-slate-100 p-3 rounded-xl">
                        <span class="text-[9px] text-slate-400 uppercase font-bold tracking-wider">Membros Totais</span>
                        <p class="text-xl font-extrabold text-slate-900 mt-0.5" x-text="dados.desempenho_rede.rede.total_membros || 0">0</p>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 p-3 rounded-xl">
                        <span class="text-[9px] text-slate-400 uppercase font-bold tracking-wider">Membros Ativos</span>
                        <p class="text-xl font-extrabold text-slate-900 mt-0.5 flex items-center gap-1.5">
                            <span x-text="dados.desempenho_rede.rede.membros_ativos || 0">0</span>
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-[11px]">
                <span class="text-slate-400">Taxa de Conversão Operacional:</span>
                <span class="font-extrabold text-slate-900" 
                      x-text="dados.desempenho_rede.rede.total_membros > 0 ? round((dados.desempenho_rede.rede.membros_ativos / dados.desempenho_rede.rede.total_membros) * 100, 1) + '%' : '0%'">
                </span>
            </div>
        </div>

    </div>
</div>
