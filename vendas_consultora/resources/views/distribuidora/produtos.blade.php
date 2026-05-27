@extends('layouts.appAdmin')

@section('title', 'Glow | Gerenciar Produtos')

@section('header', 'Gerenciamento de Produtos')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">

<div
    x-data="produtoManager()"
    x-init="init()"
    class="space-y-8"
>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 11m8 4V5M4 11v10l8 4"/>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total de Itens</p>
                <h4 class="text-xl font-bold text-slate-900 tracking-tight" x-text="`${totalProdutos} Produtos`">0 Produtos</h4>
            </div>
        </div>

        <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Em Promoção</p>
                <h4 class="text-xl font-bold text-emerald-700 tracking-tight">1 Ativo</h4>
            </div>
        </div>

        <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-slate-400 flex items-center justify-center text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Itens Inativos</p>
                <h4 class="text-xl font-bold text-slate-700 tracking-tight" x-text="`${inativosCount} Arquivados`">0 Arquivados</h4>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pt-2">
        <div class="flex flex-1 flex-col sm:flex-row gap-3">
            <div class="relative flex-1 max-w-md">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input x-model="search" @input="currentPage = 1" type="text" placeholder="Buscar por nome, descrição ou SKU..."
                       class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium placeholder-slate-400 focus:outline-none focus:border-slate-400 focus:ring-1 focus:ring-slate-400 transition-all shadow-sm">
            </div>

            <div class="relative" x-data="{ open: false, selected: 'all' }">
                <button @click="open = !open" @click.outside="open = false" type="button" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:border-slate-400 shadow-sm flex items-center justify-between gap-2 min-w-[180px]">
                    <span x-text="selected === 'all' ? 'Todas as Categorias' : selected"></span>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <ul x-show="open" 
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute left-0 mt-2 w-full z-10 bg-white border border-slate-100 rounded-xl shadow-xl py-1 max-h-60 overflow-y-auto"
                >
                    <li @click="categoryFilter = 'all'; selected = 'all'; open = false; currentPage = 1" class="px-4 py-2.5 text-xs font-semibold text-slate-700 cursor-pointer hover:bg-slate-50">Todas as Categorias</li>
                    
                    <template x-for="categoria in categorias" :key="categoria.id">
                        <li @click="categoryFilter = categoria.nome; selected = categoria.nome; open = false; currentPage = 1" 
                            class="px-4 py-2.5 text-xs font-semibold text-slate-700 cursor-pointer hover:bg-slate-50"
                            x-text="categoria.nome"></li>
                    </template>
                </ul>
            </div>

            <div class="relative" x-data="{ open: false, selected: 'all' }">
                <button @click="open = !open" @click.outside="open = false" type="button" class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:outline-none focus:border-slate-400 shadow-sm flex items-center justify-between gap-2">
                    <span x-text="selected === 'all' ? 'Todos os Status' : (selected === 'ativo' ? 'Ativos' : 'Inativos')"></span>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <ul x-show="open" 
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute left-0 mt-2 w-full z-10 bg-white border border-slate-100 rounded-xl shadow-xl py-1"
                >
                    <li @click="statusFilter = 'all'; selected = 'all'; open = false; currentPage = 1" class="px-4 py-2.5 text-xs font-semibold text-slate-700 cursor-pointer hover:bg-slate-50">Todos os Status</li>
                    <li @click="statusFilter = 'ativo'; selected = 'ativo'; open = false; currentPage = 1" class="px-4 py-2.5 text-xs font-semibold text-slate-700 cursor-pointer hover:bg-slate-50">Ativos</li>
                    <li @click="statusFilter = 'inativo'; selected = 'inativo'; open = false; currentPage = 1" class="px-4 py-2.5 text-xs font-semibold text-slate-700 cursor-pointer hover:bg-slate-50">Inativos</li>
                </ul>
            </div>
        </div>

        <button @click="abrirCreateModal()" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-md transition-all shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
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
                    <th class="py-4 px-4 text-center">Status</th>
                    <th class="py-4 px-6 text-center">Ações</th>
                </tr>
            </thead>

            <tbody class="text-xs divide-y divide-slate-100 font-medium text-slate-700">
                <template x-for="produto in paginatedProdutos" :key="produto.id">
                    <tr x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        :class="getProdutoStatus(produto) === 'inativo' ? 'bg-slate-50/40 text-slate-400 hover:bg-slate-50 transition-colors' : 'hover:bg-slate-50/50 transition-colors'"
                    >
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3" :class="getProdutoStatus(produto) === 'inativo' ? 'opacity-60' : ''">
                                <div class="w-9 h-9 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                                    <template x-if="produto.imagem_url">
                                        <img :src="resolveImageUrl(produto.imagem_url)" :alt="produto.nome" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!produto.imagem_url">
                                        <span class="font-bold text-[10px] text-slate-400 tracking-wider">GLOW</span>
                                    </template>
                                </div>

                                <div>
                                    <p class="font-bold" :class="getProdutoStatus(produto) === 'inativo' ? 'text-slate-700 line-through' : 'text-slate-900'" x-text="produto.nome"></p>
                                    <p class="text-[10px] text-slate-400" x-text="`SKU: ${getSku(produto)}`"></p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-slate-500" x-text="getCategoriaNome(produto)"></td>
                        <td class="py-4 px-4 text-right font-semibold text-slate-900" x-text="formatMoney(produto.preco)"></td>
                        <td class="py-4 px-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-full"
                                  :class="getProdutoStatus(produto) === 'ativo'
                                        ? 'bg-emerald-100 text-emerald-800'
                                        : 'bg-slate-200 text-slate-600'"
                                  x-text="getProdutoStatus(produto) === 'ativo' ? 'Ativo' : 'Inativo'"></span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button @click="editarProduto(produto)" class="p-1.5 hover:bg-slate-100 rounded-lg text-slate-500 hover:text-black transition-all" title="Editar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>

                                <template x-if="getProdutoStatus(produto) === 'ativo'">
                                    <button @click="excluirProduto(produto.id, produto.nome)" class="p-1.5 hover:bg-red-50 rounded-lg text-slate-400 hover:text-red-600 transition-all" title="Excluir">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                    </button>
                                </template>

                                <template x-if="getProdutoStatus(produto) === 'inativo'">
                                    <button @click="Swal.fire('Produto inativo', 'Este item já está inativo no catálogo.', 'info')" class="p-1.5 hover:bg-emerald-50 rounded-lg text-emerald-600 transition-all" title="Inativo">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </template>
                            </div>
                        </td>
                    </tr>
                </template>

                <tr x-show="filteredProdutos.length === 0">
                    <td colspan="5" class="py-12 px-6 text-center text-slate-400 text-sm">
                        Nenhum produto encontrado.
                    </td>
                </tr>
            </tbody>
        </table>

        <div x-show="filteredProdutos.length > 0" class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-slate-500 text-[11px] font-semibold">
            <div>
                Exibindo de <span class="text-slate-800" x-text="startRecord"></span> até <span class="text-slate-800" x-text="endRecord"></span> de <span class="text-slate-800" x-text="filteredProdutos.length"></span> resultados
            </div>
            
            <div class="flex items-center gap-1.5" x-show="totalPages > 1">
                <button 
                    @click="currentPage > 1 ? currentPage-- : null" 
                    :disabled="currentPage === 1"
                    class="p-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition-all disabled:opacity-40 disabled:hover:bg-white"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                </button>

                <template x-for="page in totalPages" :key="page">
                    <button 
                        @click="currentPage = page" 
                        x-text="page"
                        class="min-w-[28px] h-7 rounded-lg text-center transition-all border"
                        :class="currentPage === page 
                            ? 'bg-slate-900 border-slate-900 text-white font-bold' 
                            : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'"
                    ></button>
                </template>

                <button 
                    @click="currentPage < totalPages ? currentPage++ : null" 
                    :disabled="currentPage === totalPages"
                    class="p-1.5 rounded-lg border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 transition-all disabled:opacity-40 disabled:hover:bg-white"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="openCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div x-show="openCreateModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="resetForm()" class="fixed inset-0 bg-black/40 backdrop-blur-sm shadow-inner"
            ></div>

            <div x-show="openCreateModal"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200"
            >
                <div class="bg-white p-6 sm:p-8">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                        <div>
                            <h3 class="text-base font-bold text-slate-900 uppercase tracking-wide">Novo Cosmético</h3>
                            <p class="text-[11px] text-slate-400 mt-0.5">Cadastre o produto definindo nome, categoria, preço e imagem.</p>
                        </div>
                        <button @click="resetForm()" class="text-slate-400 hover:text-black">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form @submit.prevent="salvarProduto('create')" class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Nome do Produto</label>
                                <input type="text" required x-model="createData.nome" placeholder="Ex: Protetor Solar Fluido FPS 60"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Categoria</label>
                                <select x-model="createData.categoria_id" required
                                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                                    <option value="">Selecione</option>
                                    <template x-for="categoria in categorias" :key="categoria.id">
                                        <option :value="categoria.id" x-text="categoria.nome"></option>
                                    </template>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Preço de Venda Base</label>
                                <input type="text" required x-model="createData.preco" placeholder="R$ 0,00"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Descrição</label>
                                <textarea x-model="createData.descricao" rows="4" placeholder="Descrição do produto"
                                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all"></textarea>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Imagem do Produto</label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    required
                                    x-ref="createFileInput"
                                    @change="handleImageChange($event, 'create')"
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800"
                                >

                                <div class="mt-3 flex items-start gap-3">
                                    <div class="w-32 h-32 rounded-2xl border border-dashed border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center">
                                        <template x-if="createData.imagePreview">
                                            <img :src="createData.imagePreview" class="w-full h-full object-cover" alt="Prévia da imagem">
                                        </template>
                                        <template x-if="!createData.imagePreview">
                                            <div class="text-center px-3">
                                                <svg class="w-6 h-6 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <p class="mt-2 text-[10px] text-slate-400 leading-4">Prévia da imagem cortada</p>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="text-[11px] text-slate-500 leading-5">
                                        Selecione uma imagem e ajuste o recorte quadrado antes de enviar.
                                        <div class="mt-2 text-slate-400">A imagem será enviada já no formato 1:1.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Status Inicial</label>
                                <div class="flex p-1 bg-slate-100 rounded-xl">
                                    <button
                                        type="button"
                                        @click="createData.status = 'ativo'"
                                        class="flex-1 px-4 py-2 text-xs font-bold rounded-lg transition-all"
                                        :class="createData.status === 'ativo' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                                    >
                                        Ativo
                                    </button>

                                    <button
                                        type="button"
                                        @click="createData.status = 'inativo'"
                                        class="flex-1 px-4 py-2 text-xs font-bold rounded-lg transition-all"
                                        :class="createData.status === 'inativo' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                                    >
                                        Inativo
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" @click="resetForm()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold uppercase rounded-lg transition-all">Cancelar</button>
                            <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold uppercase tracking-wide rounded-lg transition-all shadow">
                                Salvar Produto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div x-show="openEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div x-show="openEditModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="resetForm()" class="fixed inset-0 bg-black/40 backdrop-blur-sm"
            ></div>

            <div x-show="openEditModal"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200"
            >
                <div class="bg-white p-6 sm:p-8">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                        <div>
                            <h3 class="text-base font-bold text-slate-900 uppercase tracking-wide">Editar Informações</h3>
                            <p class="text-[11px] text-slate-400 mt-0.5">Modifique os dados do produto selecionado.</p>
                        </div>
                        <button @click="resetForm()" class="text-slate-400 hover:text-black">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <form @submit.prevent="salvarProduto('edit')" class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Nome do Produto</label>
                                <input type="text" required x-model="editData.nome"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Categoria</label>
                                <select x-model="editData.categoria_id" required
                                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                                    <option value="">Selecione</option>
                                    <template x-for="categoria in categorias" :key="categoria.id">
                                        <option :value="categoria.id" x-text="categoria.nome"></option>
                                    </template>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Preço de Venda Base</label>
                                <input type="text" required x-model="editData.preco"
                                       class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Descrição</label>
                                <textarea x-model="editData.descricao" rows="4"
                                          class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all"></textarea>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Imagem do Produto</label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    x-ref="editFileInput"
                                    @change="handleImageChange($event, 'edit')"
                                    class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold focus:outline-none focus:bg-white focus:border-slate-400 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white hover:file:bg-slate-800"
                                >

                                <div class="mt-3 flex items-start gap-3">
                                    <div class="w-32 h-32 rounded-2xl border border-dashed border-slate-200 bg-slate-50 overflow-hidden flex items-center justify-center">
                                        <template x-if="editData.imagePreview || editData.currentImageUrl">
                                            <img :src="editData.imagePreview || editData.currentImageUrl" class="w-full h-full object-cover" alt="Prévia da imagem">
                                        </template>
                                        <template x-if="!editData.imagePreview && !editData.currentImageUrl">
                                            <div class="text-center px-3">
                                                <svg class="w-6 h-6 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <p class="mt-2 text-[10px] text-slate-400 leading-4">Prévia da imagem cortada</p>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="text-[11px] text-slate-500 leading-5">
                                        Se quiser alterar a imagem, selecione um novo arquivo e ajuste o corte quadrado.
                                        <div class="mt-2 text-slate-400">Se não selecionar outra imagem, a atual será mantida.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Disponibilidade / Status</label>
                                <div class="flex p-1 bg-slate-100 rounded-xl">
                                    <button
                                        type="button"
                                        @click="editData.status = 'ativo'"
                                        class="flex-1 px-4 py-2 text-xs font-bold rounded-lg transition-all"
                                        :class="editData.status === 'ativo' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                                    >
                                        Ativo
                                    </button>

                                    <button
                                        type="button"
                                        @click="editData.status = 'inativo'"
                                        class="flex-1 px-4 py-2 text-xs font-bold rounded-lg transition-all"
                                        :class="editData.status === 'inativo' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                                    >
                                        Inativo
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                            <button type="button" @click="resetForm()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold uppercase rounded-lg transition-all">Cancelar</button>
                            <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold uppercase tracking-wide rounded-lg transition-all shadow">
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div x-show="openCropModal" x-cloak class="fixed inset-0 z-[60] overflow-y-auto" role="dialog">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div x-show="openCropModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="cancelCrop()" class="fixed inset-0 bg-black/50 backdrop-blur-sm"
            ></div>

            <div x-show="openCropModal"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full border border-slate-200"
            >
                <div class="bg-white p-6 sm:p-8 space-y-5">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div>
                            <h3 class="text-base font-bold text-slate-900 uppercase tracking-wide">Ajustar Imagem</h3>
                            <p class="text-[11px] text-slate-400 mt-0.5">Arraste e ajuste o corte em formato quadrado antes de confirmar.</p>
                        </div>
                        <button type="button" @click="cancelCrop()" class="text-slate-400 hover:text-black">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <div
                        class="bg-slate-50 border border-slate-200 rounded-2xl overflow-hidden flex items-center justify-center min-h-[320px] min-w-[320px]"
                        style="min-width:320px; min-height:320px;"
                    >
                        <img
                            x-ref="cropImage"
                            :src="cropSource"
                            class="max-w-full max-h-[70vh] block"
                            style="min-width:200px; min-height:200px;"
                            alt="Imagem para recorte"
                        >
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="cancelCrop()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold uppercase rounded-lg transition-all">Cancelar</button>
                        <button type="button" @click="confirmCrop()" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold uppercase tracking-wide rounded-lg transition-all shadow">
                            Aplicar Corte
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('produtoManager', () => ({
        search: '',
        categoryFilter: 'all',
        statusFilter: 'all',

        currentPage: 1,
        perPage: 5,

        openCreateModal: false,
        openEditModal: false,

        openCropModal: false,
        cropSource: '',
        cropTarget: null,
        cropper: null,
        cropInitTimer: null,
        tempObjectUrl: null,
        cropReady: false,

        createData: {
            nome: '',
            categoria_id: '',
            preco: '',
            descricao: '',
            file: null,
            imagePreview: '',
            status: 'ativo'
        },

        editData: {
            id: null,
            nome: '',
            categoria_id: '',
            preco: '',
            descricao: '',
            file: null,
            imagePreview: '',
            currentImageUrl: '',
            status: 'ativo'
        },

        // Iniciado vazio para receber os dados do banco via requisição Axios
        categorias: [],
        produtos: [],
        loading: false,

        csrf: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || null,

        init() {
            if (window.axios) {
                axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
                axios.defaults.withCredentials = true;
            }
            // Dispara o carregamento das categorias assim que a tela abre
            this.carregarCategorias();
            this.carregarProdutos();
        },

        get totalProdutos() {
            return this.produtos.length;
        },

        get inativosCount() {
            return this.produtos.filter(produto => this.getProdutoStatus(produto) === 'inativo').length;
        },

        get ativosCount() {
            return this.produtos.filter(produto => this.getProdutoStatus(produto) === 'ativo').length;
        },

        get filteredProdutos() {
            const term = this.search.trim().toLowerCase();

            return this.produtos.filter((produto) => {
                const nome = (produto.nome ?? '').toLowerCase();
                const descricao = (produto.descricao ?? '').toLowerCase();
                const sku = this.getSku(produto).toLowerCase();
                const categoriaNome = this.getCategoriaNome(produto).toLowerCase();
                const status = this.getProdutoStatus(produto);

                const matchSearch =
                    term === '' ||
                    nome.includes(term) ||
                    descricao.includes(term) ||
                    sku.includes(term);

                const matchCategoria =
                    this.categoryFilter === 'all' ||
                    categoriaNome === this.categoryFilter.toLowerCase();

                const matchStatus =
                    this.statusFilter === 'all' ||
                    status === this.statusFilter;

                return matchSearch && matchCategoria && matchStatus;
            });
        },

        get paginatedProdutos() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredProdutos.slice(start, end);
        },

        get totalPages() {
            return Math.ceil(this.filteredProdutos.length / this.perPage) || 1;
        },

        get startRecord() {
            if (this.filteredProdutos.length === 0) return 0;
            return (this.currentPage - 1) * this.perPage + 1;
        },

        get endRecord() {
            const calculatedEnd = this.currentPage * this.perPage;
            return calculatedEnd > this.filteredProdutos.length ? this.filteredProdutos.length : calculatedEnd;
        },

        // Requisição AJAX/Axios para pegar as categorias do banco
        async carregarCategorias() {
            try {
                const response = await axios.get('/api/categoria', {
                    headers: { Accept: 'application/json' }
                });
                
                // Mapeia baseado na estrutura JSON retornada pelo seu CategoriasController ('data')
                this.categorias = response.data.data ?? response.data ?? [];
            } catch (error) {
                console.error('Erro ao buscar categorias via API:', error);
            }
        },

        getCategoriaNome(produto) {
            if (produto?.categoria?.nome) return produto.categoria.nome;

            const categoria = this.categorias.find(c => String(c.id) === String(produto?.categoria_id));
            if (categoria) return categoria.nome;

            if (typeof produto?.categoria === 'string' && produto.categoria.trim() !== '') {
                return produto.categoria;
            }

            return 'Sem categoria';
        },

        getProdutoStatus(produto) {
            return produto?.deleted_at ? 'inativo' : 'ativo';
        },

        getSku(produto) {
            if (produto?.sku) return produto.sku;
            const id = String(produto?.id ?? 0).padStart(3, '0');
            return `GLW-${id}`;
        },

        resolveImageUrl(path) {
            if (!path) return '';
            if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('/')) {
                return path;
            }
            return `{{ asset('storage') }}/${path}`;
        },

        formatMoney(valor) {
            const numero = Number(valor ?? 0);
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            }).format(Number.isFinite(numero) ? numero : 0);
        },

        abrirCreateModal() {
            this.resetCreateForm();
            this.openCreateModal = true;
        },

        resetCreateForm() {
            this.createData = {
                nome: '',
                categoria_id: '',
                preco: '',
                descricao: '',
                file: null,
                imagePreview: '',
                status: 'ativo'
            };

            if (this.$refs.createFileInput) {
                this.$refs.createFileInput.value = '';
            }
        },

        resetEditForm() {
            this.editData = {
                id: null,
                nome: '',
                categoria_id: '',
                preco: '',
                descricao: '',
                file: null,
                imagePreview: '',
                currentImageUrl: '',
                status: 'ativo'
            };

            if (this.$refs.editFileInput) {
                this.$refs.editFileInput.value = '';
            }
        },

        resetForm() {
            this.closeCropModal(true);
            this.resetCreateForm();
            this.resetEditForm();
            this.openCreateModal = false;
            this.openEditModal = false;
        },

        handleImageChange(event, target) {
            const file = event.target.files?.[0];

            if (!file) return;

            this.cropTarget = target;
            this.destroyCropper();

            if (this.tempObjectUrl) {
                URL.revokeObjectURL(this.tempObjectUrl);
                this.tempObjectUrl = null;
            }

            this.cropSource = URL.createObjectURL(file);
            this.tempObjectUrl = this.cropSource;
            this.cropReady = false;
            this.openCropModal = true;

            this.$nextTick(() => {
                this.scheduleCropperInit();
            });
        },

        scheduleCropperInit() {
            this.destroyCropper();

            const startedAt = Date.now();
            const maxWaitMs = 3000;

            const tryInit = () => {
                const img = this.$refs.cropImage;
                const container = img?.parentElement;

                const visible =
                    !!this.openCropModal &&
                    !!img &&
                    !!container &&
                    img.offsetParent !== null &&
                    container.offsetParent !== null;

                const ready =
                    visible &&
                    img.complete === true &&
                    img.naturalWidth > 0 &&
                    img.offsetWidth > 0 &&
                    img.offsetHeight > 0;

                if (ready) {
                    this.initCropper();
                    return;
                }

                if (Date.now() - startedAt >= maxWaitMs) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Não foi possível ajustar a imagem.'
                    });
                    return;
                }

                this.cropInitTimer = requestAnimationFrame(tryInit);
            };

            this.cropInitTimer = requestAnimationFrame(tryInit);
        },

        initCropper() {
            const img = this.$refs.cropImage;
            const container = img?.parentElement;

            const ready =
                !!this.openCropModal &&
                !!img &&
                !!container &&
                img.offsetParent !== null &&
                container.offsetParent !== null &&
                img.complete === true &&
                img.naturalWidth > 0 &&
                img.offsetWidth > 0 &&
                img.offsetHeight > 0;

            if (!ready) {
                this.scheduleCropperInit();
                return;
            }

            if (typeof Cropper === 'undefined') {
                console.warn('A biblioteca Cropper.js ainda não está acessível globalmente.');
                this.scheduleCropperInit();
                return;
            }

            this.destroyCropper();

            try {
                this.cropper = new Cropper(img, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 1,
                    responsive: true,
                    background: false,
                    movable: true,
                    zoomable: true,
                    rotatable: false,
                    scalable: false,
                    cropBoxResizable: true,
                    checkOrientation: true,
                    ready: () => {
                        this.cropReady = true;
                    }
                });
            } catch (error) {
                console.warn('Erro controlado ao instanciar o Cropper, tentando novamente...', error);
                this.scheduleCropperInit();
            }
        },

        destroyCropper() {
            if (this.cropInitTimer) {
                cancelAnimationFrame(this.cropInitTimer);
                this.cropInitTimer = null;
            }

            this.cropReady = false;

            if (this.cropper) {
                try {
                    this.cropper.destroy();
                } catch (e) {
                    // Falha silenciosa
                }
                this.cropper = null;
            }
        },

        closeCropModal(clearInput = true) {
            this.destroyCropper();

            if (this.tempObjectUrl) {
                URL.revokeObjectURL(this.tempObjectUrl);
                this.tempObjectUrl = null;
            }

            this.cropSource = '';
            this.openCropModal = false;
            this.cropReady = false;

            if (clearInput && this.cropTarget === 'create' && this.$refs.createFileInput) {
                this.$refs.createFileInput.value = '';
            }

            if (clearInput && this.cropTarget === 'edit' && this.$refs.editFileInput) {
                this.$refs.editFileInput.value = '';
            }

            this.cropTarget = null;
        },

        cancelCrop() {
            this.closeCropModal(true);
        },

        confirmCrop() {
            if (!this.cropper) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Não foi possível ajustar a imagem.'
                });
                return;
            }

            const canvas = this.cropper.getCroppedCanvas({
                width: 800,
                height: 800,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            if (!canvas) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Não foi possível gerar o recorte.'
                });
                return;
            }

            canvas.toBlob((blob) => {
                if (!blob) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Falha ao processar a imagem.'
                    });
                    return;
                }

                const fileName = `produto_${Date.now()}.jpg`;
                const file = new File([blob], fileName, { type: 'image/jpeg' });
                const previewUrl = URL.createObjectURL(blob);

                if (this.cropTarget === 'create') {
                    this.createData.file = file;
                    this.createData.imagePreview = previewUrl;
                }

                if (this.cropTarget === 'edit') {
                    this.editData.file = file;
                    this.editData.imagePreview = previewUrl;
                }

                this.closeCropModal(false);
            }, 'image/jpeg', 0.92);
        },

        async carregarProdutos() {
            this.loading = true;

            try {
                const response = await axios.get('/api/produto', {
                    headers: { Accept: 'application/json' }
                });

                this.produtos = response.data.data ?? response.data ?? [];
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: error.response?.data?.message || 'Erro ao carregar produtos.'
                });
            } finally {
                this.loading = false;
            }
        },

        editarProduto(produto) {
            this.resetEditForm();

            this.editData = {
                id: produto.id ?? null,
                nome: produto.nome ?? '',
                categoria_id: produto.categoria_id ?? '',
                preco: produto.preco ?? '',
                descricao: produto.descricao ?? '',
                file: null,
                imagePreview: '',
                currentImageUrl: this.resolveImageUrl(produto.imagem_url),
                status: this.getProdutoStatus(produto)
            };

            this.openEditModal = true;
        },

        async salvarProduto(modo = 'create') {
            const isEdit = modo === 'edit';
            const source = isEdit ? this.editData : this.createData;

            try {
                const formData = new FormData();
                formData.append('nome', source.nome ?? '');
                formData.append('categoria_id', source.categoria_id ?? '');
                formData.append('preco', source.preco ?? '');
                formData.append('descricao', source.descricao ?? '');
                formData.append('status', source.status ?? 'ativo');

                if (source.file instanceof File) {
                    formData.append('imagem', source.file, source.file.name);
                }

                let response;

                if (isEdit && source.id) {
                    formData.append('_method', 'PUT');

                    response = await axios.post(`/api/produto/${source.id}`, formData, {
                        headers: {
                            'X-CSRF-TOKEN': this.csrf,
                            Accept: 'application/json'
                        }
                    });
                } else {
                    response = await axios.post('/api/produto', formData, {
                        headers: {
                            'X-CSRF-TOKEN': this.csrf,
                            Accept: 'application/json'
                        }
                    });
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: response.data.message || 'Operação realizada com sucesso.'
                });

                this.resetForm();
                await this.carregarProdutos();
            } catch (error) {
                let mensagem = error.response?.data?.message || 'Erro ao salvar produto.';

                if (error.response?.status === 422 && error.response?.data?.errors) {
                    mensagem = Object.values(error.response.data.errors).flat().join('<br>');
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    html: mensagem
                });
            }
        },

        async excluirProduto(id, nome) {
            const confirmacao = await Swal.fire({
                title: 'Excluir produto?',
                text: `"${nome}" será removido do sistema.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, excluir',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#0F172A'
            });

            if (!confirmacao.isConfirmed) return;

            try {
                const response = await axios.delete(`/api/produto/${id}`, {
                    headers: {
                        'X-CSRF-TOKEN': this.csrf,
                        Accept: 'application/json'
                    }
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: response.data.message || 'Produto removido.'
                });

                await this.carregarProdutos();
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: error.response?.data?.message || 'Erro ao excluir produto.'
                });
            }
        }
    }));
});
</script>

@endsection
