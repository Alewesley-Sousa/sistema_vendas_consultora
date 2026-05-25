<div class="p-6 space-y-8">
    <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">KPIs de Desempenho da Rede</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Vendas Atuais</p>
            <p class="text-2xl font-extrabold text-slate-900 mt-2" x-text="'R$ ' + (dados.desempenho_rede.resumo.vendas_atuais || '0,00')"></p>
        </div>
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Membros na Rede</p>
            <p class="text-2xl font-extrabold text-slate-900 mt-2" x-text="dados.desempenho_rede.rede.total_membros || 0"></p>
        </div>
        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Atingimento de Meta Coletiva</p>
            <p class="text-2xl font-extrabold text-emerald-600 mt-2" x-text="(dados.desempenho_rede.resumo.atingimento_meta_percent || 0) + '%'"></p>
        </div>
    </div>
</div>
