<div class="p-6 space-y-6 bg-white rounded-2xl border border-slate-100 shadow-sm" 
     x-data="vendasPessoaisComponent()" 
     x-init="init()">

    <div class="flex items-center justify-between border-b border-slate-100 pb-5">
        <div>
            <h3 class="text-base font-semibold text-slate-900 tracking-tight">Histórico de Vendas Pessoais</h3>
            <p class="text-xs text-slate-400 mt-0.5">Acompanhamento de receita e volumetria por período.</p>
        </div>
        <span class="text-[10px] bg-indigo-50 text-indigo-600 font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-indigo-100/40">
            Sua Performance
        </span>
    </div>

    <template x-if="dados.vendas_pessoais && dados.vendas_pessoais.length > 0">
        <div class="p-4 bg-slate-800/95 rounded-xl border-2 border-indigo-500/30 shadow-[0_0_30px_0_rgba(99,102,241,0.45)] ring-2 ring-indigo-500/20 transition-all duration-300">
            <div x-ref="chartContainer" class="w-full"></div>
        </div>
    </template>

    <div class="overflow-x-auto rounded-xl border border-slate-100/80 shadow-sm bg-white">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 font-semibold tracking-wider bg-slate-50/50">
                    <th class="py-3.5 px-4">Período</th>
                    <th class="py-3.5 px-4 text-center">Total Pedidos</th>
                    <th class="py-3.5 px-4 text-right">Total Vendido</th>
                    <th class="py-3.5 px-4 text-right">Ticket Médio</th>
                </tr>
            </thead>
            <tbody>
                <template x-if="!dados.vendas_pessoais || dados.vendas_pessoais.length === 0">
                    <tr>
                        <td colspan="4" class="py-12 text-center text-slate-400 font-medium tracking-wide">
                            Nenhum registro de venda encontrado para este período.
                        </td>
                    </tr>
                </template>

                <template x-for="item in dados.vendas_pessoais" :key="item.periodo">
                    <tr class="border-b border-slate-50 hover:bg-slate-50/40 transition-colors font-medium text-slate-600">
                        <td class="py-3.5 px-4 font-semibold text-slate-900" x-text="formatarPeriodo(item.periodo)"></td>
                        <td class="py-3.5 px-4 text-center text-slate-600 font-mono text-[13px]" x-text="item.total_pedidos"></td>
                        <td class="py-3.5 px-4 text-right font-semibold text-slate-900 text-[13px]" x-text="formatarMoeda(item.total_vendas)"></td>
                        <td class="py-3.5 px-4 text-right font-medium text-indigo-600 text-[13px]" x-text="formatarMoeda(item.ticket_medio)"></td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>

<script>
function vendasPessoaisComponent() {
    return {
        chart: null,
        init() {
            this.$watch('dados.vendas_pessoais', value => {
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
            if (!this.dados.vendas_pessoais || this.dados.vendas_pessoais.length === 0) return;

            const dadosOrdenados = [...this.dados.vendas_pessoais].reverse();
            const categories = dadosOrdenados.map(item => this.formatarPeriodo(item.periodo));
            const valores = dadosOrdenados.map(item => item.total_vendas);

            const options = {
                chart: {
                    type: 'area',
                    height: 260,
                    toolbar: { show: false },
                    fontFamily: 'Inter, system-ui, sans-serif',
                    parentHeightOffset: 0,
                    animations: {
                        enabled: true,
                        easing: 'linear',
                        speed: 700,
                        animateGradually: { enabled: false },
                        dynamicAnimation: { enabled: true, speed: 350 }
                    }
                },
                series: [{ name: 'Faturamento', data: valores }],
                colors: ['#a5b4fc'], 
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        type: 'vertical',
                        opacityFrom: 0.35, 
                        opacityTo: 0.01, 
                        stops: [0, 95]
                    }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3.5, lineCap: 'round' },
                markers: {
                    size: 0,
                    colors: ['#a5b4fc'],
                    strokeColors: '#1e293b', 
                    strokeWidth: 2.5,
                    hover: { size: 6, sizeOffset: 3 }
                },
                xaxis: {
                    categories: categories,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { 
                        offsetY: 5,
                        style: { colors: '#94a3b8', fontSize: '11px', fontWeight: 500 } 
                    }
                },
                yaxis: {
                    tickAmount: 4,
                    labels: {
                        offsetX: -5,
                        style: { colors: '#94a3b8', fontSize: '11px', fontWeight: 500 },
                        formatter: (value) => 'R$ ' + Math.round(value).toLocaleString('pt-BR')
                    }
                },
                grid: {
                    show: true,
                    borderColor: '#334155', 
                    strokeDashArray: 5, 
                    position: 'back',
                    xaxis: { lines: { show: false } },   
                    yaxis: { lines: { show: true } },
                    padding: { top: 15, right: 15, bottom: 0, left: 15 }
                },
                tooltip: {
                    theme: 'dark',
                    shared: true,
                    intersect: false,
                    custom: function({ series, seriesIndex, dataPointIndex, w }) {
                        const valor = series[seriesIndex][dataPointIndex];
                        const periodo = w.globals.categoryLabels[dataPointIndex];
                        const valorFormatado = Number(valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        
                        return '<div class="p-3 bg-slate-900 border border-slate-700/50 rounded-xl shadow-2xl font-sans text-xs min-w-[140px]">' +
                                    '<div class="text-[10px] text-slate-400 uppercase tracking-wider font-semibold mb-1">' + periodo + '</div>' +
                                    '<div class="flex items-center justify-between gap-4">' +
                                        '<span class="text-slate-400 font-medium">Total:</span>' +
                                        '<span class="text-indigo-300 font-bold">R$ ' + valorFormatado + '</span>' +
                                    '</div>' +
                               '</div>';
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
