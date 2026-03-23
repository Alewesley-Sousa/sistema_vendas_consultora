import { ComponentesCatalogo } from '../componentes/conteudo-catalogoProdutos';
import { CatalogoService } from '../api/catalogo';

export function InitCatalogoProduto() {
    let state = {
        tela: 'LISTA', // 'LISTA' ou 'ITENS'
        idCatalogoAtivo: null,
        nomeCatalogoAtivo: '',
        pesquisa: '',
        carrinho: [],
        container: document.getElementById('app-catalogo'),
        inputPesquisa: document.getElementById('filtro-pesquisa')
    };

    const render = (html) => { 
        state.container.innerHTML = html;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    window.appCatalogo = {
        async inicializar() {
            this.carregarCatalogos();
        },

        async carregarCatalogos(page = 1) {
            state.tela = 'LISTA';
            render('<div class="flex flex-col items-center justify-center py-20"><i class="fas fa-circle-notch fa-spin text-4xl text-indigo-600 mb-4"></i><p class="text-slate-400 font-bold animate-pulse uppercase tracking-widest text-xs">Carregando Catálogos...</p></div>');
            
            try {
                const res = await CatalogoService.buscarCatalogos(page, state.pesquisa);
                if (res.status === 'success') {
                    let html = ComponentesCatalogo.renderLista(res.data.data);
                    html += ComponentesCatalogo.renderPaginacao(res.data, 'carregarCatalogos');
                    render(html);
                }
            } catch (error) {
                render('<div class="text-center py-20 text-red-500 font-bold">Erro ao carregar dados. Verifique a conexão.</div>');
            }
        },

        async abrirDetalhes(id, nome, page = 1) {
            // Se trocou de catálogo ou veio da lista, reseta a pesquisa local
            if (state.tela === 'LISTA' || state.idCatalogoAtivo !== id) {
                state.pesquisa = '';
                state.inputPesquisa.value = '';
                state.inputPesquisa.placeholder = `Pesquisar em ${nome}...`;
            }

            state.tela = 'ITENS';
            state.idCatalogoAtivo = id;
            state.nomeCatalogoAtivo = nome;

            render('<div class="flex flex-col items-center justify-center py-20"><i class="fas fa-circle-notch fa-spin text-4xl text-indigo-600 mb-4"></i><p class="text-slate-400 font-bold animate-pulse uppercase tracking-widest text-xs">Buscando Produtos...</p></div>');

            try {
                const res = await CatalogoService.buscarItens(id, page, state.pesquisa);
                if (res.status === 'success') {
                    let html = ComponentesCatalogo.renderItens(state.nomeCatalogoAtivo, res.data.data);
                    html += ComponentesCatalogo.renderPaginacao(res.data, 'abrirDetalhes', id, state.nomeCatalogoAtivo);
                    render(html);
                }
            } catch (error) {
                console.error(error);
            }
        },

        filtrar(valor) {
            state.pesquisa = valor;
            clearTimeout(this.timer);
            this.timer = setTimeout(() => {
                if (state.tela === 'LISTA') {
                    this.carregarCatalogos(1);
                } else {
                    this.abrirDetalhes(state.idCatalogoAtivo, state.nomeCatalogoAtivo, 1);
                }
            }, 400);
        },

        voltar() {
            state.pesquisa = '';
            state.inputPesquisa.value = '';
            state.inputPesquisa.placeholder = "Pesquisar catálogo...";
            this.carregarCatalogos(1);
        },

        addCarrinho(id, nome, preco) {
            const input = document.getElementById(`qtd-${id}`);
            const qtd = parseInt(input.value);
            if (isNaN(qtd) || qtd < 1) return;

            const index = state.carrinho.findIndex(i => i.id === id);
            if (index !== -1) {
                state.carrinho[index].qtd += qtd;
            } else {
                state.carrinho.push({ id, nome, preco, qtd });
            }

            input.value = 1;
            this.atualizarInterfaceCarrinho();
        },

        atualizarInterfaceCarrinho() {
            const resumo = document.getElementById('resumo-venda');
            const lista = document.getElementById('lista-itens');
            const totalTxt = document.getElementById('total-venda');

            if (state.carrinho.length > 0) {
                resumo.classList.remove('hidden');
                resumo.classList.add('animate-in', 'fade-in', 'slide-in-from-bottom-4', 'duration-500');
            } else {
                resumo.classList.add('hidden');
            }

            lista.innerHTML = state.carrinho.map(item => `
                <div class="flex justify-between items-center bg-white/50 backdrop-blur-sm p-4 rounded-3xl border border-slate-100 shadow-sm transition-all hover:border-indigo-200">
                    <div class="flex flex-col">
                        <span class="text-xs font-black text-slate-800 leading-tight">${item.nome}</span>
                        <span class="text-[10px] text-indigo-600 font-bold uppercase mt-1">Quantidade: ${item.qtd}</span>
                    </div>
                    <span class="font-black text-slate-900 text-sm">R$ ${(item.preco * item.qtd).toFixed(2)}</span>
                </div>
            `).join('');

            const total = state.carrinho.reduce((acc, i) => acc + (i.preco * i.qtd), 0);
            totalTxt.innerText = `R$ ${total.toLocaleString('pt-BR', {minimumFractionDigits: 2})}`;
        },

        limparCarrinho() {
            if(confirm("Deseja remover todos os itens do pedido?")) {
                state.carrinho = [];
                this.atualizarInterfaceCarrinho();
            }
        },

        finalizar() {
            console.log("Enviando pedido:", state.carrinho);
            alert("Pedido enviado com sucesso para processamento!");
            // Aqui entra seu axios.post
        }
    };

    window.appCatalogo.inicializar();
}