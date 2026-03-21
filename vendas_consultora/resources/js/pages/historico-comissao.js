import { HistoricoComissaoService } from '../api/historicoComissao';
import { UIService } from '../service/uiService';

export function initHistoricoComissao() {
    const tabelaCorpo = document.getElementById('tabela-comissao-corpo');
    const paginacaoContainer = document.getElementById('paginacao-historico');
    const statusBadge = document.getElementById('status-badge');
    
    // Seletores para ordenação
    const sortData = document.getElementById('sort-data');
    const sortValor = document.getElementById('sort-valor');

    if (!tabelaCorpo) return;

    let estado = {
        ordenar_por: 'data_movimentacao',
        direcao: 'desc',
        page: 1
    };

    // --- LÓGICA DE ORDENAÇÃO ---
    function alternarOrdenacao(coluna) {
        if (estado.ordenar_por === coluna) {
            estado.direcao = estado.direcao === 'asc' ? 'desc' : 'asc';
        } else {
            estado.ordenar_por = coluna;
            estado.direcao = 'desc';
        }
        carregarDados(1); 
    }

    function atualizarIconesOrdenacao() {
        document.querySelectorAll('.sort-icon').forEach(el => el.innerText = '');
        const idAtivo = estado.ordenar_por === 'data_movimentacao' ? 'sort-data' : 'sort-valor';
        const icone = estado.direcao === 'asc' ? ' ▲' : ' ▼';
        const el = document.getElementById(idAtivo);
        if (el) el.querySelector('.sort-icon').innerText = icone;
    }

    // Eventos de clique nos cabeçalhos
    sortData?.addEventListener('click', () => alternarOrdenacao('data_movimentacao'));
    sortValor?.addEventListener('click', () => alternarOrdenacao('valor'));


    // --- CARREGAMENTO DE DADOS ---
    async function carregarDados(pagina = 1) {
        estado.page = pagina;
        UIService.show();
        statusBadge?.classList.remove('hidden');
        atualizarIconesOrdenacao();

        try {
            const response = await HistoricoComissaoService.getHistorico(estado);
            
            if (response.status === 'success') {
                renderizarTabela(response.data.data);
                renderizarPaginacao(response.data);
            }
        } catch (err) {
            console.error("Erro:", err);
            tabelaCorpo.innerHTML = `
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-rose-500 font-semibold bg-rose-50">
                        Erro ao carregar histórico. Verifique sua conexão.
                    </td>
                </tr>`;
        } finally {
            UIService.hide();
            statusBadge?.classList.add('hidden');
        }
    }

    // --- RENDERIZAÇÃO ---
    function renderizarTabela(registros) {
if (registros.length === 0) {
        tabelaCorpo.innerHTML = '<tr><td colspan="5" class="px-6 py-12 text-center text-slate-500 italic">Nenhuma comissão encontrada.</td></tr>';
        return;
    }

    tabelaCorpo.innerHTML = registros.map(item => `
        <tr class="hover:bg-slate-50/80 transition-colors border-b border-slate-100 last:border-0">
            <td class="px-6 py-4 font-medium text-slate-700 whitespace-nowrap">
                ${new Date(item.data_movimentacao).toLocaleDateString('pt-BR')}
            </td>
            <td class="px-6 py-4 text-slate-500">
                <div class="text-xs text-slate-400 uppercase font-bold">Pedido</div>
                #${item.pedido_id}
            </td>
            <td class="px-6 py-4 font-bold ${parseFloat(item.valor) > 0 ? 'text-emerald-600' : 'text-rose-600'}">
                R$ ${parseFloat(item.valor).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}
            </td>
            <td class="px-6 py-4 space-y-1">
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Origem</div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                    ${item.tipo_comissao?.nome || 'N/A'}
                </span>
            </td>
            <td class="px-6 py-4">
                 <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Movimentação</div>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold ${item.tipo_movimentacao?.nome.toLowerCase().includes('entrada') ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-amber-50 text-amber-700 border border-amber-100'}">
                    ${item.tipo_movimentacao?.nome || 'Geral'}
                </span>
            </td>
        </tr>
    `).join('');
    }

    function renderizarPaginacao(paginator) {
        if (!paginacaoContainer) return;
        
        let html = `
            <button class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all" 
                    ${!paginator.prev_page_url ? 'disabled' : ''} id="btn-prev">
                Anterior
            </button>
            <span class="text-sm font-semibold text-slate-700">
                ${paginator.current_page} <span class="text-slate-400 font-normal">de</span> ${paginator.last_page}
            </span>
            <button class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all" 
                    ${!paginator.next_page_url ? 'disabled' : ''} id="btn-next">
                Próximo
            </button>
        `;
        
        paginacaoContainer.innerHTML = html;

        document.getElementById('btn-prev')?.addEventListener('click', () => carregarDados(paginator.current_page - 1));
        document.getElementById('btn-next')?.addEventListener('click', () => carregarDados(paginator.current_page + 1));
    }

    // Inicialização
    carregarDados();
}