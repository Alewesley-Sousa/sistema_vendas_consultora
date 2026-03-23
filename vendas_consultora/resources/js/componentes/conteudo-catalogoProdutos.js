export const ComponentesCatalogo = {
    renderLista(catalogos) {
        return `
            <div class="mb-10 text-center md:text-left">
                <span class="text-indigo-600 font-black text-xs uppercase tracking-[0.2em]">Dashboard</span>
                <h1 class="text-4xl font-black text-slate-900 mt-2 tracking-tight">Catálogos de Venda</h1>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                ${catalogos.map(cat => `
                    <div onclick="window.appCatalogo.abrirDetalhes(${cat.id}, '${cat.nome}')" 
                         class="group relative bg-white p-1 rounded-[2.5rem] transition-all duration-500 hover:-translate-y-2 cursor-pointer">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-[2.5rem] opacity-0 group-hover:opacity-100 transition-opacity blur-xl"></div>
                        <div class="relative bg-white border border-slate-100 p-8 rounded-[2.4rem] h-full shadow-sm group-hover:shadow-2xl transition-all">
                            <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500">
                                <i class="fas fa-folder-open text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-black text-slate-800 group-hover:text-indigo-600 transition-colors">${cat.nome}</h3>
                            <p class="text-slate-500 mt-3 text-sm leading-relaxed">${cat.descricao || 'Explore os produtos exclusivos deste catálogo.'}</p>
                            <div class="mt-8 flex items-center text-indigo-600 font-bold text-xs uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-all translate-x-[-10px] group-hover:translate-x-0">
                                Ver produtos <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>`;
    },

    renderItens(nomeCatalogo, itens) {
        return `
            <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <button onclick="window.appCatalogo.voltar()" class="group w-14 h-14 flex items-center justify-center bg-white border border-slate-100 rounded-2xl shadow-sm hover:bg-slate-900 hover:text-white transition-all">
                        <i class="fas fa-chevron-left group-hover:-translate-x-1 transition-transform"></i>
                    </button>
                    <div>
                        <span class="text-indigo-600 font-black text-xs uppercase tracking-widest">Catálogo Selecionado</span>
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight">${nomeCatalogo}</h1>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                ${itens.map(item => `
                    <div class="bg-white rounded-[2rem] border border-slate-100 p-4 shadow-sm hover:shadow-xl transition-all duration-500 group">
                        <div class="relative h-56 overflow-hidden bg-slate-50 rounded-[1.5rem] mb-5">
                            <img src="${item.produto.imagem_url}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                        <div class="px-2">
                            <h3 class="font-bold text-slate-800 text-base mb-2 h-12 line-clamp-2 leading-snug">${item.produto.nome}</h3>
                            <div class="flex items-end justify-between mb-5">
                                <div>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Preço Unitário</span>
                                    <div class="text-2xl font-black text-indigo-600 italic">R$ ${parseFloat(item.preco).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</div>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <input type="number" id="qtd-${item.id}" value="1" min="1" 
                                       class="w-16 py-3 bg-slate-50 border-none rounded-2xl text-center font-black text-slate-700 focus:ring-2 focus:ring-indigo-500 transition-all">
                                <button onclick="window.appCatalogo.addCarrinho(${item.id}, '${item.produto.nome}', ${item.preco})" 
                                        class="flex-1 bg-slate-900 hover:bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all active:scale-95 shadow-lg shadow-slate-200 hover:shadow-indigo-200">
                                    Adicionar
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('')}
            </div>`;
    },

    renderPaginacao(paginator, funcao, id = null, nome = '') {
        if (paginator.last_page <= 1) return '';
        const paramsExtra = id ? `${id}, '${nome}', ` : '';
        
        return `
            <div class="flex justify-center items-center gap-6 mt-16">
                <button ${paginator.prev_page_url ? '' : 'disabled'} 
                        onclick="window.appCatalogo.${funcao}(${paramsExtra}${paginator.current_page - 1})" 
                        class="w-12 h-12 flex items-center justify-center bg-white border border-slate-100 rounded-xl disabled:opacity-30 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div class="text-sm font-black text-slate-400 uppercase tracking-widest">
                    Página <span class="text-slate-900">${paginator.current_page}</span> de ${paginator.last_page}
                </div>
                <button ${paginator.next_page_url ? '' : 'disabled'} 
                        onclick="window.appCatalogo.${funcao}(${paramsExtra}${paginator.current_page + 1})" 
                        class="w-12 h-12 flex items-center justify-center bg-white border border-slate-100 rounded-xl disabled:opacity-30 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>`;
    }
};