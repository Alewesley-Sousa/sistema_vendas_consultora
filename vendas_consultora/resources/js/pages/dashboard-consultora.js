// resources/js/pages/dashboard-consultora.js
import { DashboardService } from '../api/dashboard';

export function initDashboardConsultora() {
    // Registra direto no objeto Alpine que já está no window
    window.Alpine.data('dashboardComponent', () => ({
        progresso: 0,
        comissaoTotal: 0,
        metaTotal: 0,
        faltaParaMeta: 0,

        async fetchData() {
            try {
                const data = await DashboardService.getStats();
                this.comissaoTotal = data.comissao;
                this.metaTotal = data.meta;
                this.progresso = data.progresso;
                this.faltaParaMeta = Math.max(0, this.metaTotal * (1 - this.progresso));
            } catch (error) {
                console.error("Erro ao carregar Dashboard:", error);
            }
        },

        formatCurrency(value) {
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency', currency: 'BRL'
            }).format(value || 0);
        }
    }));
}