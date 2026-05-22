@extends('layouts.appAdmin')

@section('title', 'Glow | Gerenciar Produtos')

@section('header', 'Gerenciamento de Produtos')

@section('content')
<div x-data="{ 
    search: '', 
    categoryFilter: 'all', 
    statusFilter: 'all',
    openCreateModal: false,
    openEditModal: false,
    editData: { id: null, nome: '', categoria: '', preco_base: '', estoque_atual: '', status: 'ativo', preco_promocional: '', promocao_inicio: '', promocao_fim: '' }
}" class="space-y-8">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 11m8 4V5M4 11v10l8 4"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total de Itens</p>
                <h4 class="text-xl font-bold text-slate-900 tracking-tight">48 Produtos</h4>
            </div>
        </div>

        <div class="p-4 bg-amber-50 border border-amber-100 rounded-2xl flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-500 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">Estoque Baixo</p>
                <h4 class="text-xl font-bold text-amber-700 tracking-tight">3 Alertas</h4>
            </div>
        </div>

        <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Em Promoção</p>
                <h4 class="text-xl font-bold text-emerald-700 tracking-tight">1 Ativo</h4>
            </div>
        </div>

        <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-slate-400 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" /></svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Itens Inativos</p>
                <h4 class="text-xl font-bold text-slate-700 tracking-tight">2 Arquivados</h4>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-2">
        <div class="flex flex-1 flex-col sm:flex-row gap-3">
            <div class="relative flex-1 max-w-md">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input x-model="search" type="text" placeholder="Buscar por código ou nome do cosmético..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium placeholder-slate-400 focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-400 transition-all shadow-sm">
            </div>

            <select x-model="categoryFilter" class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:border-slate-400 shadow-sm">
                <option value="all">Todas as Categorias</option>
                <option value="Maquiagem">Maquiagem</option>
                <option value="Skincare">Skincare</option>
                <option value="Fragrâncias">Fragrâncias</option>
            </select>

            <select x-model="statusFilter" class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:border-slate-400 shadow-sm">
                <option value="all">Todos os Status</option>
                <option value="ativo">Ativos</option>
                <option value="inativo">Inativos</option>
            </select>
        </div>

        <button @click="openCreateModal = true" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-md transition-all shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Novo Produto
        </button>
    </div>

    <div class="overflow-x-auto bg-white rounded-2xl border border-slate-200 shadow-sm mt-4">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/75 border-b border-slate-200 text-[10px] font-bold text-slate-500 uppercase tracking-[0.1em]">
                    <th class="py-4 px-6">Produto</th>
                    <th class="py-4 px-4">Categoria</th>
                    <th class="py-4 px-4 text-right">Preço Base</th>
                    <th class="py-4 px-4 text-center">Estoque</th>
                    <th class="py-4 px-4 text-center">Status</th>
                    <th class="py-4 px-6 text-center">Ações</th>
                </tr>
            </thead>
            <tbody class="text-xs divide-y divide-slate-100 font-medium text-slate-700">
                
                <tr x-show="(search === '' || 'batom matte velvet'.includes(search.toLowerCase())) && (categoryFilter === 'all' || categoryFilter === 'Maquiagem') && (statusFilter === 'all' || statusFilter === 'ativo')" class="hover:bg-slate-50/50 transition-colors">
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-[10px] text-slate-400">GLOW</div>
                            <div>
                                <p class="font-bold text-slate-900">Batom Matte Velvet - Red Luxury</p>
                                <p class="text-[10px] text-slate-400">SKU: GLW-BTM-001</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4 text-slate-500">Maquiagem</td>
                    <td class="py-4 px-4 text-right font-semibold text-slate-900">R$ 49,90</td>
                    <td class="py-4 px-4 text-center">
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 font-bold rounded-lg text-[10px]">420 unid</span>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-[9px] font-bold uppercase tracking-wider rounded-full">Ativo</span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button @click="editData = { id: 1, nome: 'Batom Matte Velvet - Red Luxury', categoria: 'Maquiagem', preco_base: '49.90', estoque_atual: '420', status: 'ativo', preco_promocional: '', promocao_inicio: '', promocao_fim: '' }; openEditModal = true" class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-black transition-all" title="Editar"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                            <button onclick="confirmInactivate('Batom Matte Velvet')" class="p-1.5 hover:bg-red-50 rounded-lg text-slate-400 hover:text-red-600 transition-all" title="Inativar"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg></button>
                        </div>
                    </td>
                </tr>

                <tr x-show="(search === '' || 'sérum facial ácido hialurônico'.includes(search.toLowerCase())) && (categoryFilter === 'all' || categoryFilter === 'Skincare') && (statusFilter === 'all' || statusFilter === 'ativo')" class="hover:bg-slate-50/50 transition-colors">
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-[10px] text-slate-400">GLOW</div>
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <p class="font-bold text-slate-900">Sérum Facial Ácido Hialurônico 30ml</p>
                                    <span class="px-1.5 py-0.5 bg-rose-100 text-rose-700 text-[8px] font-extrabold uppercase tracking-wide rounded">Promoção</span>
                                </div>
                                <p class="text-[10px] text-slate-400">SKU: GLW-SKN-012</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4 text-slate-500">Skincare</td>
                    <td class="py-4 px-4 text-right font-semibold">
                        <span class="line-through text-slate-400 text-[10px] block">R$ 89,90</span>
                        <span class="text-rose-600 font-bold">R$ 69,90</span>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <span class="px-2.5 py-1 bg-amber-50 text-amber-700 font-bold rounded-lg text-[10px] flex flex-col items-center max-w-[70px] mx-auto border border-amber-200">
                            12 unid
                            <span class="text-[7px] uppercase font-bold tracking-tighter text-amber-500">Crítico</span>
                        </span>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-100 text-emerald-800 text-[9px] font-bold uppercase tracking-wider rounded-full">Ativo</span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button @click="editData = { id: 2, nome: 'Sérum Facial Ácido Hialurônico 30ml', categoria: 'Skincare', preco_base: '89.90', estoque_atual: '12', status: 'ativo', preco_promocional: '69.90', promocao_inicio: '2026-05-01T00:00', promocao_fim: '2026-05-31T23:59' }; openEditModal = true" class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-black transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                            <button onclick="confirmInactivate('Sérum Facial')" class="p-1.5 hover:bg-red-50 rounded-lg text-slate-400 hover:text-red-600 transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg></button>
                        </div>
                    </td>
                </tr>

                <tr x-show="(search === '' || 'perfume obsession gold'.includes(search.toLowerCase())) && (categoryFilter === 'all' || categoryFilter === 'Fragrâncias') && (statusFilter === 'all' || statusFilter === 'inativo')" class="bg-slate-50/40 text-slate-400 hover:bg-slate-50 transition-colors">
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-3 opacity-60">
                            <div class="w-9 h-9 rounded-lg bg-slate-200 border border-slate-300 flex items-center justify-center font-bold text-[10px] text-slate-400">GLOW</div>
                            <div>
                                <p class="font-bold text-slate-700 line-through">Perfume Obsession Gold Éclat 100ml</p>
                                <p class="text-[10px]">SKU: GLW-FRG-089</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4">Fragrâncias</td>
                    <td class="py-4 px-4 text-right">R$ 189,90</td>
                    <td class="py-4 px-4 text-center">
                        <span class="px-2 py-0.5 bg-slate-200 text-slate-500 rounded font-bold text-[10px]">0 unidades</span>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-slate-200 text-slate-600 text-[9px] font-bold uppercase tracking-wider rounded-full">Inativo</span>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button @click="editData = { id: 3, nome: 'Perfume Obsession Gold Éclat 100ml', categoria: 'Fragrâncias', preco_base: '189.90', estoque_atual: '0', status: 'inativo', preco_promocional: '', promocao_inicio: '', promocao_fim: '' }; openEditModal = true" class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-black transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                            <button onclick="Swal.fire('Ativado!', 'O produto voltou ao catálogo ativo.', 'success')" class="p-1.5 hover:bg-emerald-50 rounded-lg text-emerald-600 transition-all" title="Reativar"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></button>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <div x-show="openCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div @click="openCreateModal = false" class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity"></div>
            
            <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200">
                <div class="bg-white p-6 sm:p-8">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                        <div>
                            <h3 class="text-base font-bold text-slate-900 uppercase tracking-wide">Novo Cosmético</h3>
                            <p class="text-[11px] text-slate-400 mt-0.5">Cadastre o produto definindo preço base e estoque inicial.</p>
                        </div>
                        <button @click="openCreateModal = false" class="text-slate-400 hover:text-black"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>

                    <form @submit.prevent="openCreateModal = false; Swal.fire('Sucesso!', 'Produto adicionado com sucesso.', 'success')" class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Nome do Produto</label>
                                <input type="text" required placeholder="Ex: Protetor Solar Fluido FPS 60" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Categoria</label>
                                <select class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                                    <option>Maquiagem</option>
                                    <option>Skincare</option>
                                    <option>Fragrâncias</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Quantidade Inicial de Estoque</label>
                                <input type="number" required placeholder="0" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Preço de Venda Base</label>
                                <input type="text" required placeholder="R$ 0,00" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Status Inicial</label>
                                <select class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                                    <option value="ativo">Disponível para venda</option>
                                    <option value="inativo">Inativo / Oculto</option>
                                </select>
                            </div>
                        </div>

                        <div class="p-4 bg-rose-50/50 rounded-xl border border-rose-100/80 mt-2">
                            <h4 class="text-[11px] font-bold text-rose-800 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5a2 2 0 10-2 2h2zm0 0h4m-4 0H8m12 3a2 2 0 100-4H4a2 2 0 100 4h16z"/></svg>
                                Agendar Promoção (Opcional)
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-[9px] font-bold text-slate-500 uppercase tracking-tighter mb-1.5">Preço Promocional</label>
                                    <input type="text" placeholder="R$ 0,00" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-bold text-slate-500 uppercase tracking-tighter mb-1.5">Data Inicial</label>
                                    <input type="datetime-local" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-bold text-slate-500 uppercase tracking-tighter mb-1.5">Data Final</label>
                                    <input type="datetime-local" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" @click="openCreateModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold uppercase rounded-lg transition-all">Cancelar</button>
                            <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold uppercase tracking-wide rounded-lg transition-all shadow">Salvar Produto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div x-show="openEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div @click="openEditModal = false" class="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity"></div>
            
            <div class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200">
                <div class="bg-white p-6 sm:p-8">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                        <div>
                            <h3 class="text-base font-bold text-slate-900 uppercase tracking-wide">Editar Informações</h3>
                            <p class="text-[11px] text-slate-400 mt-0.5">Modifique os dados do produto selecionado.</p>
                        </div>
                        <button @click="openEditModal = false" class="text-slate-400 hover:text-black"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>

                    <form @submit.prevent="openEditModal = false; Swal.fire('Atualizado!', 'As alterações foram salvas.', 'success')" class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Nome do Produto</label>
                                <input type="text" required x-model="editData.nome" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Categoria</label>
                                <select x-model="editData.categoria" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                                    <option value="Maquiagem">Maquiagem</option>
                                    <option value="Skincare">Skincare</option>
                                    <option value="Fragrâncias">Fragrâncias</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Saldo Atual em Estoque</label>
                                <input type="number" required x-model="editData.estoque_atual" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Preço de Venda Base</label>
                                <input type="text" required x-model="editData.preco_base" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Disponibilidade / Status</label>
                                <select x-model="editData.status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                                    <option value="ativo">Ativo (Disponível no catálogo)</option>
                                    <option value="inativo">Inativo (Indisponível)</option>
                                </select>
                            </div>
                        </div>

                        <div class="p-4 bg-rose-50/50 rounded-xl border border-rose-100/80 mt-2">
                            <h4 class="text-[11px] font-bold text-rose-800 uppercase tracking-wider mb-3 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5a2 2 0 10-2 2h2zm0 0h4m-4 0H8m12 3a2 2 0 100-4H4a2 2 0 100 4h16z"/></svg>
                                Ajustar Promoção Vigente
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-[9px] font-bold text-slate-500 uppercase tracking-tighter mb-1.5">Preço Promocional</label>
                                    <input type="text" x-model="editData.preco_promocional" placeholder="Ex: 59.90" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-bold text-slate-500 uppercase tracking-tighter mb-1.5">Início</label>
                                    <input type="datetime-local" x-model="editData.promocao_inicio" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-bold text-slate-500 uppercase tracking-tighter mb-1.5">Término</label>
                                    <input type="datetime-local" x-model="editData.promocao_fim" class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-semibold focus:outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold uppercase rounded-lg transition-all">Cancelar</button>
                            <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold uppercase tracking-wide rounded-lg transition-all shadow">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function confirmInactivate(productName) {
        Swal.fire({
            title: 'Inativar Produto?',
            text: `O item "${productName}" sairá do catálogo ativo e as consultoras não poderão adicioná-lo a novos pedidos.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0F172A',
            cancelButtonColor: '#E2E8F0',
            confirmButtonText: 'Sim, inativar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Inativado!',
                    'O produto foi alterado para inativo no sistema.',
                    'success'
                )
            }
        })
    }
</script>
@endsection
