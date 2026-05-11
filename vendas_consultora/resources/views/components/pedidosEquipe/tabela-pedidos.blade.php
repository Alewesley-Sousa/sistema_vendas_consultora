<div class="glass-card rounded-[2.5rem] shadow-2xl shadow-gray-200/50 overflow-hidden fade-in">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Data</th>
                    <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">ID Pedido</th>
                    <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Consultora</th>
                    <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Status</th>
                    <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-right text-gray-400">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <template x-for="pedido in pedidosPaginados" :key="pedido.id">
                    <tr class="hover:bg-white transition-colors group">
                        <td class="px-8 py-6 text-sm font-semibold text-gray-500" x-text="pedido.data"></td>
                        
                        <td class="px-8 py-6">
                            <span class="bg-gray-100 text-[#2C3E50] px-3 py-1 rounded-lg text-xs font-bold tracking-tighter" x-text="'#' + pedido.id"></span>
                        </td>
                        
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#FFF3F1] flex items-center justify-center text-[#E67E73] font-bold text-[10px]" 
                                     x-text="pedido.nome.substring(0,2).toUpperCase()"></div>
                                <span class="text-sm font-bold text-[#2C3E50] uppercase tracking-tight" x-text="pedido.nome"></span>
                            </div>
                        </td>

                        <td class="px-8 py-6">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border"
                                  :class="{
                                      'bg-green-50 text-green-600 border-green-100': pedido.status === 'Entregue' || pedido.status === 'Pago',
                                      'bg-amber-50 text-amber-600 border-amber-100': pedido.status === 'Pendente' || pedido.status === 'Aguardando',
                                      'bg-red-50 text-red-600 border-red-100': pedido.status === 'Cancelado' || pedido.status === 'Recusado',
                                      'bg-blue-50 text-blue-600 border-blue-100': !['Entregue', 'Pago', 'Pendente', 'Aguardando', 'Cancelado', 'Recusado'].includes(pedido.status)
                                  }"
                                  x-text="pedido.status">
                            </span>
                        </td>

                        <td class="px-8 py-6 text-right">
                            <button @click="abrirDetalhes(pedido)" class="bg-[#2C3E50] text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#E67E73] transition-all shadow-md flex items-center gap-2 ml-auto">
                                Detalhes
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
