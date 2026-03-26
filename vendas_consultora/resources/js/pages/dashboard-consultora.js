import { DashboardService } from '../api/dashboard';

export function initDashboardConsultora() {
    if (!document.querySelector('[x-data="dashboardComponent"]')) return;
    
    window.Alpine.data('dashboardComponent', () => ({
        progresso: 0,
        comissaoTotal: 0,
        metaTotal: 0,
        faltaParaMeta: 0,
        carregandoSaque: false,
        mostrarModalSaque: false, // Novo
        toasts: [], // Novo

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

        // Função para mostrar notificação bonita
                // Função para mostrar notificação bonita no topo
        notify(message, type = 'success') {
            const id = Date.now();
            this.toasts.push({ id, message, type, show: true });

            // Inicia o processo de fechamento após 4 segundos
            setTimeout(() => {
                const toast = this.toasts.find(t => t.id === id);
                if (toast) {
                    toast.show = false; // Dispara a animação de saída (fade out)
                    
                    // Remove do array após a animação acabar (300ms conforme o Blade)
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 300);
                }
            }, 4000);
        },


        // Apenas abre o modal
        async solicitarSaque() {
            if (this.comissaoTotal <= 0) {
                this.notify("Você não possui saldo para resgate.", "error");
                return;
            }
            this.mostrarModalSaque = true;
        },

        // Executa a ação real dentro do modal
        async executarSaque() {
            this.mostrarModalSaque = false;
            this.carregandoSaque = true;

            try {
                const response = await DashboardService.solicitarSaque();
                
                if (response.status === 'success') {
                    this.notify(response.message, "success");
                    await this.fetchData();
                }
            } catch (error) {
                const msg = error.response?.data?.message || "Erro ao processar saque.";
                this.notify(msg, "error");
            } finally {
                this.carregandoSaque = false;
            }
        },

        formatCurrency(value) {
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency', currency: 'BRL'
            }).format(value || 0);
        }
    }));
}
