import { HistoricoComissaoService } from '../api/historicoComissao';
import { UIService } from '../service/uiService';

export function initHistoricoComissao() {
    const tabelaCorpo = document.getElementById('tabela-comissao-corpo');
    const paginacaoContainer = document.getElementById('paginacao-historico');
    
    if (!tabelaCorpo) return;

    let estado = {
        ordenar_por: 'data_movimentacao',
        direcao: 'desc',
        page: 1
    };

    async function carregarDados(pagina = 1) {
        estado.page = pagina;
        UIService.show();

        try {
            const response = await HistoricoComissaoService.getHistorico(estado);
            
            if (response.status === 'success') {
                renderizarTabela(response.data.data);
                renderizarPaginacao(response.data);
            }
        } catch (err) {
            console.error("Erro:", err);
            tabelaCorpo.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Erro ao carregar histórico.</td></tr>';
        } finally {
            UIService.hide();
        }
    }

    function renderizarTabela(registros) {
        if (registros.length === 0) {
            tabelaCorpo.innerHTML = '<tr><td colspan="4" class="text-center">Nenhuma comissão encontrada.</td></tr>';
            return;
        }

        tabelaCorpo.innerHTML = registros.map(item => `
            <tr>
                <td>${new Date(item.data_movimentacao).toLocaleDateString('pt-BR')}</td>
                <td>Pedido #${item.pedido_id}</td>
                <td class="fw-bold ${item.valor > 0 ? 'text-success' : 'text-danger'}">
                    R$ ${parseFloat(item.valor).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}
                </td>
                <td><span class="badge bg-info">Tipo ${item.tipo_comissao_id}</span></td>
            </tr>
        `).join('');
    }

    function renderizarPaginacao(paginator) {
        if (!paginacaoContainer) return;
        
        let html = `
            <button class="btn btn-sm btn-outline-primary" ${!paginator.prev_page_url ? 'disabled' : ''} id="btn-prev">Anterior</button>
            <span class="mx-2">Página ${paginator.current_page} de ${paginator.last_page}</span>
            <button class="btn btn-sm btn-outline-primary" ${!paginator.next_page_url ? 'disabled' : ''} id="btn-next">Próximo</button>
        `;
        
        paginacaoContainer.innerHTML = html;

        document.getElementById('btn-prev')?.addEventListener('click', () => carregarDados(paginator.current_page - 1));
        document.getElementById('btn-next')?.addEventListener('click', () => carregarDados(paginator.current_page + 1));
    }

    // Inicialização
    carregarDados();
}