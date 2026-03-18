// resources/js/pages/dashboard.js
import { DashboardConsultoraService } from '../api/dashboardConsultora';

export function initDashboardConsultora() {
    const comissaoSpan = document.getElementById('comissao');
    const metaSpan = document.getElementById('meta');
    const erroP = document.getElementById('erro');

    if (!comissaoSpan) return; // Só roda se estiver na página certa

    async function carregarDados() {
        try {
            // Buscamos os dados em paralelo (mais rápido)
            const [metaRes, comissaoRes] = await Promise.all([
                DashboardConsultoraService.getMeta(),
                DashboardConsultoraService.getComissao()
            ]);

            // Atualiza o HTML
            // Note que seu controller envia dentro de 'data'
            metaSpan.innerText = `R$ ${metaRes.data}`; 
            comissaoSpan.innerText = `R$ ${comissaoRes.data}`;

        } catch (err) {
            erroP.innerText = "Erro ao carregar dados do dashboard.";
            console.error(err);
        }
    }

    carregarDados();
}