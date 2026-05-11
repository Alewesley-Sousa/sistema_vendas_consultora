<div x-show="modalAberto" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
    <div x-show="modalAberto" x-transition.opacity @click="fecharModal()" class="absolute inset-0 bg-[#2C3E50]/60 backdrop-blur-sm"></div>

    <div x-show="modalAberto" x-transition.scale.95 
         class="relative bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
        
        <div class="bg-[#F8FAFC] px-10 py-8 border-b border-gray-100 flex justify-between items-center shrink-0">
            <div>
                <p class="text-[10px] font-black text-[#E67E73] uppercase tracking-[0.2em] mb-1" x-text="modo === 'visualizar' ? 'Resumo do Pedido' : 'Editando Itens'"></p>
                <h2 class="text-3xl font-serif text-[#2C3E50]" x-text="'Pedido #' + pedidoEditavel?.id"></h2>
            </div>
            <button @click="fecharModal()" class="text-gray-300 hover:text-[#2C3E50] transition-colors">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-10 overflow-y-auto custom-scrollbar flex-grow">
            
            <div x-show="modo === 'visualizar'" class="fade-in">
                <div class="grid grid-cols-2 gap-8 mb-10">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Consultora</label>
                        <p class="text-sm font-bold text-[#2C3E50] uppercase" x-text="pedidoEditavel?.nome"></p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Cliente</label>
                        <p class="text-sm font-bold text-[#2C3E50] uppercase" x-text="pedidoEditavel?.cliente"></p>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 mb-8 max-h-64 overflow-y-auto custom-scrollbar border border-gray-100">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-gray-100">
                            <template x-for="item in pedidoEditavel?.itens">
                                <tr>
                                    <td class="py-4 text-xs font-bold text-[#2C3E50]" x-text="item.produto"></td>
                                    <td class="py-4 text-xs font-medium text-gray-500 text-center" x-text="item.qtd + 'x'"></td>
                                    <td class="py-4 text-xs font-bold text-[#2C3E50] text-right" x-text="formatarMoeda(item.preco * item.qtd)"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="flex justify-between items-end border-t border-gray-100 pt-8">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Pagamento</label>
                        <span class="bg-[#FFF9E5] text-[#D4AF37] px-3 py-1 rounded-lg text-[10px] font-black uppercase" x-text="pedidoEditavel?.pagamento"></span>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total</p>
                        <p class="text-4xl font-serif text-[#E67E73]" x-text="formatarMoeda(calcularTotal())"></p>
                    </div>
                </div>
            </div>

            <div x-show="modo === 'editar'" class="fade-in">
                <h3 class="text-xs font-black uppercase tracking-widest text-[#2C3E50] mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Adicionar Novo Item
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="relative" x-data="{ open: false }">
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 block">Catálogo</label>
                        <button @click="open = !open" type="button" class="w-full bg-white border border-gray-100 p-4 rounded-xl text-left text-xs font-bold text-[#2C3E50] flex justify-between items-center transition-all focus:ring-2 focus:ring-[#FF7665]/20">
                            <span x-text="novoItem.catalogo || 'Selecione...'"></span>
                            <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute z-20 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl p-2 max-h-40 overflow-y-auto custom-scrollbar">
                            <template x-for="cat in catalogos">
                                <button @click="novoItem.catalogo = cat; open = false" type="button" class="w-full text-left p-3 text-xs font-bold hover:bg-[#FFF3F1] hover:text-[#E67E73] rounded-lg transition-colors" x-text="cat"></button>
                            </template>
                        </div>
                    </div>

                    <div class="relative" x-data="{ open: false }">
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 block">Item do Catálogo</label>
                        <button @click="open = !open" type="button" class="w-full bg-white border border-gray-100 p-4 rounded-xl text-left text-xs font-bold text-[#2C3E50] flex justify-between items-center transition-all focus:ring-2 focus:ring-[#FF7665]/20">
                            <span x-text="novoItem.produto?.nome || 'Selecione o produto...'"></span>
                            <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="absolute z-20 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-xl p-2 max-h-40 overflow-y-auto custom-scrollbar">
                            <template x-for="prod in produtosExemplo">
                                <button @click="novoItem.produto = prod; open = false" type="button" class="w-full text-left p-3 text-xs font-bold hover:bg-[#FFF3F1] hover:text-[#E67E73] rounded-lg transition-colors flex justify-between">
                                    <span x-text="prod.nome"></span>
                                    <span class="text-gray-400" x-text="formatarMoeda(prod.preco)"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="flex items-end gap-4 mb-8">
                    <div class="w-24">
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2 block">Qtd</label>
                        <input type="number" x-model="novoItem.qtd" min="1" class="w-full bg-white border border-gray-100 p-4 rounded-xl text-xs font-bold text-[#2C3E50] outline-none">
                    </div>
                    <button @click="adicionarItem()" type="button" class="flex-1 bg-[#E67E73] text-white py-4 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#2C3E50] transition-all">Confirmar e Adicionar</button>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-4">Itens no Pedido Atual</label>
                    <div class="space-y-3 max-h-48 overflow-y-auto custom-scrollbar pr-2">
                        <template x-for="(item, index) in pedidoEditavel?.itens">
                            <div class="flex justify-between items-center bg-gray-50 p-4 rounded-2xl group/item">
                                <div>
                                    <p class="text-xs font-bold text-[#2C3E50]" x-text="item.produto"></p>
                                    <p class="text-[10px] text-gray-400 font-medium" x-text="item.qtd + ' un. x ' + formatarMoeda(item.preco)"></p>
                                </div>
                                <button @click="removerItem(index)" type="button" class="text-gray-300 hover:text-red-500 transition-colors p-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-10 py-8 bg-white border-t border-gray-100 shrink-0">
            <div class="flex gap-4 w-full">
                <div x-show="modo === 'visualizar'" class="flex gap-4 w-full">
                    <button @click="confirmacaoAberta = true" type="button" class="flex-1 border border-red-100 text-red-400 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-50 transition-all">
                        Cancelar Pedido
                    </button>
                </div>
                
                <div x-show="modo === 'editar'" class="flex gap-4 w-full">
                    <button @click="modo = 'visualizar'" type="button" class="flex-1 bg-gray-100 text-gray-400 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-200 transition-all">
                        Voltar
                    </button>
                    <button @click="salvarEdicao()" type="button" class="flex-2 bg-[#2C3E50] text-white px-12 py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-[#E67E73] transition-all shadow-lg">
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div x-show="confirmacaoAberta" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div x-show="confirmacaoAberta" x-transition.opacity @click="confirmacaoAberta = false" class="absolute inset-0 bg-[#2C3E50]/80 backdrop-blur-md"></div>
    <div x-show="confirmacaoAberta" x-transition.scale.90 class="relative bg-white w-full max-w-sm rounded-[2rem] shadow-2xl p-10 text-center">
        <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <h3 class="text-2xl font-serif text-[#2C3E50] mb-2">Confirmar?</h3>
        <p class="text-gray-400 text-sm mb-8">Esta ação removerá o pedido permanentemente.</p>
        <div class="flex flex-col gap-3">
            <button @click="confirmarCancelamento()" type="button" class="w-full bg-red-500 text-white py-4 rounded-xl text-[10px] font-black uppercase">Sim, Cancelar</button>
            <button @click="confirmacaoAberta = false" type="button" class="w-full bg-gray-50 text-gray-400 py-4 rounded-xl text-[10px] font-black uppercase">Manter</button>
        </div>
    </div>
</div>
