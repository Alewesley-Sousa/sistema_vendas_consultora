<div class="p-6 space-y-6 bg-white rounded-2xl border border-slate-100 shadow-sm" 
     x-data="comissoesDetalhadasComponent()" 
     x-init="init()">
    
    <div class="flex items-center justify-between border-b border-slate-100 pb-5">
        <div>
            <h3 class="text-base font-semibold text-slate-900 tracking-tight">Consolidado Financeiro de Comissões</h3>
            <p class="text-xs text-slate-400 mt-0.5">Visão macro de faturamento, quebras de estorno e saques efetivados.</p>
        </div>
        <span class="text-[10px] bg-slate-100 text-slate-600 font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-slate-200">
            Visão Distribuidora
        </span>
    </div>

    <template x-if="dados.comissoes_detalhadas && dados.comissoes_detalhadas.length > 0">
        <div class="p-4 bg-slate-800/95 rounded-xl border border-slate-700/60 shadow-[0_4px_25px_-5px_rgba(99,102,241,0.15)] ring-1 ring-indigo-500/10">
            <div x-ref="chartContainer" class="w-full"></div>
        </div>
    </template>

    <div class="overflow-x-auto rounded-xl border border-slate-100/80 shadow-sm bg-white">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 font-semibold tracking-wider bg-slate-50/70">
                    <th class="py-3.5 px-4">Período</th>
                    <th class="py-3.5 px-4 text-center">Qtd Vendas</th>
                    <th class="py-3.5 px-4 text-right">Faturamento Bruto</th>
                    <th class="py-3.5 px-4 text-right">Total Estornos</th>
                    <th class="py-3.5 px-4 text-right">Total Saques</th>
                    <th class="py-3.5 px-4 text-right">Saldo Líquido</th>
                </tr>
            </thead>
            <tbody>
                <template x-if="!dados.comissoes_detalhadas || dados.comissoes_detalhadas.length === 0">
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400 font-medium tracking-wide">
                            Nenhuma movimentação encontrada para o filtro selecionado.
                        </td>
                    </tr>
                </template>

                <template x-for="item in dados.comissoes_detalhadas" :key="item.periodo">
                    <tr class="border-b border-slate-50 hover:bg-slate-50/40 transition-colors font-medium text-slate-600">
                        <td class="py-3.5 px-4 font-semibold text-slate-900" x-text="formatarPeriodo(item.periodo)"></td>
                        <td class="py-3.5 px-4 text-center font-mono text-slate-500 text-[13px]" x-text="item.total_vendas_qtd"></td>
                        <td class="py-3.5 px-4 text-right text-slate-700 font-semibold text-[13px]" x-text="formatarMoeda(item.faturamento_bruto)"></td>
                        <td class="py-3.5 px-4 text-right text-rose-600 font-medium text-[13px]" x-text="formatarMoeda(item.total_estornos)"></td>
                        <td class="py-3.5 px-4 text-right text-amber-600 font-medium text-[13px]" x-text="formatarMoeda(item.total_saques)"></td>
                        <td class="py-3.5 px-4 text-right font-bold text-[13px]" 
                            :class="item.saldo_liquido >= 0 ? 'text-emerald-600' : 'text-rose-700'"
                            x-text="formatarMoeda(item.saldo_liquido)">
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>

<script>
function comissoesDetalhadasComponent() {
    return {
        chart: null,
        init() {
            this.$watch('dados.comissoes_detalhadas', value => {
                this.$nextTick(() => {
                    this.initChart();
                });
            });
        },
        formatarMoeda(valor) {
            return 'R$ ' + Number(valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        },
        formatarPeriodo(mesAno) {
            if(!mesAno) return '';
            const [ano, mes] = mesAno.split('-');
            const meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
            return meses[parseInt(mes) - 1] + '/' + ano;
        },
        initChart() {
            if (!this.dados.comissoes_detalhadas || this.dados.comissoes_detalhadas.length === 0) return;

            // Inverte a ordem para exibir cronologicamente da esquerda para a direita (passado -> presente)
            const dadosOrdenados = [...this.dados.comissoes_detalhadas].reverse();
            
            const categorias = dadosOrdenados.map(item => this.formatarPeriodo(item.periodo));
            const brutos = dadosOrdenados.map(item => item.faturamento_bruto);
            const estornos = dadosOrdenados.map(item => Math.abs(item.total_estornos)); // Transforma em positivo para visualização paralela limpa
            const saques = dadosOrdenados.map(item => item.total_saques);
            const liquidos = dadosOrdenados.map(item => item.saldo_liquido);

            const options = {
                chart: {
                    type: 'line', // Tipo misto (barras e linha)
                    height: 280,
                    toolbar: { show: false },
                    fontFamily: 'Inter, system-ui, sans-serif',
                    parentHeightOffset: 0,
                    animations: {
                        enabled: true,
                        easing: 'linear',
                        speed: 600
                    }
                },
                // Mapeamento estratégico dos dados em série mista
                series: [
                    { name: 'Faturamento Bruto', type: 'column', data: brutos },
                    { name: 'Retenção por Estornos', type: 'column', data: estornos },
                    { name: 'Total de Saques', type: 'column', data: saques },
                    { name: 'Saldo Líquido Real', type: 'line', data: liquidos }
                ],
                // Cores associadas às colunas correspondentes (Bruto, Estorno, Saque, Linha Líquida)
                colors: ['#818cf8', '#f87171', '#fb923c', '#34d399'], 
                stroke: {
                    width: [0, 0, 0, 4], // Apenas a última série (Saldo Líquido) ganha borda visível
                    curve: 'smooth'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '45%',
                        borderRadius: 3,
                        borderRadiusApplication: 'end'
                    }
                },
                dataLabels: { enabled: false },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                    labels: { colors: '#94a3b8' },
                    markers: { radius: 12 }
                },
                xaxis: {
                    categories: categorias,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        style: { colors: '#94a3b8', fontSize: '11px' }
                    }
                },
                yaxis: {
                    tickAmount: 4,
                    labels: {
                        style: { colors: '#94a3b8', fontSize: '11px' },
                        formatter: (value) => 'R$ ' + Math.round(value).toLocaleString('pt-BR')
                    }
                },
                grid: {
                    show: true,
                    borderColor: '#334155',
                    strokeDashArray: 4,
                    position: 'back',
                    xaxis: { lines: { show: false } },
                    yaxis: { lines: { show: true } },
                    padding: { top: 10, right: 10, bottom: 0, left: 10 }
                },
                tooltip: {
                    theme: 'dark',
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: (value) => 'R$ ' + value.toLocaleString('pt-BR', { minimumFractionDigits: 2 })
                    }
                }
            };

            if (this.chart) this.chart.destroy();
            this.chart = new ApexCharts(this.$refs.chartContainer, options);
            this.chart.render();
        }
    };
}
</script>
