<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<div class="p-6 space-y-6" 
     x-data="{
        chart: null,
        isLucroNegativo: false,
        
        init() {
            const options = {
                chart: {
                    type: 'area', 
                    height: 280,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif'
                },
                colors: ['#3b82f6', '#10b981'], // Padrão: Azul e Verde
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 2.5 },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.25,
                        opacityTo: 0.02,
                        stops: [0, 90, 100]
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    padding: { top: 10, right: 20, bottom: 0, left: 10 }
                },
                series: [
                    { name: 'Faturamento Bruto', data: [] },
                    { name: 'Lucro Líquido', data: [] }
                ],
                xaxis: {
                    categories: [],
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { style: { colors: '#94a3b8', fontSize: '11px', fontWeight: 500 } }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#94a3b8', fontSize: '11px' },
                        formatter: function (value) {
                            return 'R$ ' + value.toLocaleString('pt-BR', { minimumFractionDigits: 0 });
                        }
                    }
                },
                tooltip: {
                    theme: 'light',
                    y: {
                        formatter: function (val) {
                            return 'R$ ' + val.toLocaleString('pt-BR', { minimumFractionDigits: 2 });
                        }
                    }
                }
            };

            this.chart = new ApexCharts(this.$refs.chartContainer, options);
            this.chart.render();

            // Roda imediatamente com o que tiver no escopo
            this.$nextTick(() => {
                if (this.dados?.financeiro_consolidado?.listagem_mensal) {
                    this.renderizarDadosGrafico(this.dados.financeiro_consolidado.listagem_mensal);
                }
            });

            // Monitora alterações futuras
            this.$watch('dados.financeiro_consolidado.listagem_mensal', value => {
                this.renderizarDadosGrafico(value);
            });
        },

        // Função auxiliar para garantir que qualquer valor vire Float limpo
        parseValor(valor) {
            if (valor === null || valor === undefined) return 0;
            if (typeof valor === 'number') return valor;
            
            let stringLimpa = valor.toString()
                .replace('R$', '')
                .replace(/\s/g, '')
                .replace(/\./g, '')
                .replace(',', '.');
                
            return parseFloat(stringLimpa) || 0;
        },

        renderizarDadosGrafico(lista) {
            if (!lista || !Array.isArray(lista) || lista.length === 0) return;
            
            // Inverte para manter a ordem cronológica correta (Passado -> Presente)
            const listaCronologica = [...lista].reverse();
            
            const meses = listaCronologica.map(item => item.mes);
            const faturamentos = listaCronologica.map(item => this.parseValor(item.faturamento_bruto));
            const lucros = listaCronologica.map(item => this.parseValor(item.lucro_operacional));

            // Verifica se o lucro do mês mais recente está abaixo de zero
            const ultimoLucro = lucros[lucros.length - 1];
            this.isLucroNegativo = ultimoLucro < 0;

            // Altera dinamicamente a cor da linha de Lucro caso esteja negativo
            const corLucro = this.isLucroNegativo ? '#e11d48' : '#10b981';

            this.chart.updateOptions({
                xaxis: { categories: meses },
                colors: ['#3b82f6', corLucro]
            });

            this.chart.updateSeries([
                { name: 'Faturamento Bruto', data: faturamentos },
                { name: 'Lucro Líquido', data: lucros }
            ]);
        }
     }">
    
    <h3 class="text-lg font-bold text-slate-800 uppercase tracking-wider">Fluxo de Caixa Consolidado Operacional</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Faturamento Confirmado</p>
            <p class="text-base font-extrabold text-slate-900 mt-1" x-text="'R$ ' + (dados.financeiro_consolidado.resumo_geral?.faturamento_total || '0,00')"></p>
        </div>
        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Custos Comissões</p>
            <p class="text-base font-extrabold text-rose-600 mt-1" x-text="'R$ ' + (dados.financeiro_consolidado.resumo_geral?.comissoes_totais || '0,00')"></p>
        </div>
        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Saques Efetivados</p>
            <p class="text-base font-extrabold text-rose-600 mt-1" x-text="'R$ ' + (dados.financeiro_consolidado.resumo_geral?.saques_totais || '0,00')"></p>
        </div>
        
        <div class="p-4 rounded-xl border transition-all duration-300"
             :class="isLucroNegativo ? 'bg-rose-50/60 border-rose-200 shadow-sm shadow-rose-100' : 'bg-slate-50 border-slate-100'">
            <p class="text-[9px] font-bold uppercase tracking-wider" 
               :class="isLucroNegativo ? 'text-rose-500 animate-pulse' : 'text-slate-400'">
               Resultado Líquido <span x-show="isLucroNegativo">⚠️ PERIGO</span>
            </p>
            <p class="text-base font-extrabold mt-1" 
               :class="isLucroNegativo ? 'text-rose-600' : 'text-emerald-600'"
               x-text="'R$ ' + (dados.financeiro_consolidado.resumo_geral?.lucro_acumulado || '0,00')"></p>
        </div>
    </div>

    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mt-4">
        <div class="flex items-center justify-between mb-4 px-2">
            <div>
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Desempenho Mensal</h4>
                <p class="text-[10px] text-slate-400 mt-0.5">Visão comparativa de entradas e margem real</p>
            </div>
            <div class="flex items-center gap-4 text-[10px] font-bold uppercase tracking-wider">
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded bg-blue-500 inline-block"></span>
                    <span class="text-slate-500">Faturamento</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <span class="w-3 h-3 rounded inline-block transition-colors duration-300" 
                          :class="isLucroNegativo ? 'bg-rose-500' : 'bg-emerald-500'"></span>
                    <span class="text-slate-500" x-text="isLucroNegativo ? 'Prejuízo' : 'Lucro'"></span>
                </div>
            </div>
        </div>
        <div x-ref="chartContainer"></div>
    </div>

    <div class="overflow-x-auto pt-4">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-widest bg-slate-50">
                    <th class="py-3 px-4">Mês</th>
                    <th class="py-3 px-4">Faturamento Bruto</th>
                    <th class="py-3 px-4">Custo Operacional</th>
                    <th class="py-3 px-4">Lucro Líquido</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="item in dados.financeiro_consolidado.listagem_mensal" :key="item.mes">
                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-all font-medium text-slate-600">
                        <td class="py-3.5 px-4 font-semibold text-slate-900" x-text="item.mes"></td>
                        <td class="py-3.5 px-4 text-emerald-600 font-semibold" x-text="'R$ ' + item.faturamento_bruto"></td>
                        <td class="py-3.5 px-4 text-rose-500" x-text="'R$ ' + (parseFloat(item.custo_comissoes || 0) + parseFloat(item.saídas_saques || 0)).toFixed(2).replace('.', ',')"></td>
                        <td class="py-3.5 px-4 font-bold" 
                            :class="parseValor(item.lucro_operacional) < 0 ? 'text-rose-600' : 'text-slate-900'"
                            x-text="'R$ ' + item.lucro_operacional"></td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
