@extends('layouts.appAdmin')

@section('title', 'Glow | Gerenciar Produtos')

@section('header', 'Gerenciamento de Produtos')

@section('content')

{{-- Fontes e estilos de simulação específicos para o visual do painel --}}
<link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;900&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">

<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        vertical-align: middle;
    }
    /* Estilo para simulação de Tooltip elegante */
    [data-tooltip] { position: relative; cursor: pointer; }
    [data-tooltip]:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        padding: 4px 8px;
        background: #1b1b1b;
        color: white;
        font-size: 10px;
        font-family: 'JetBrains Mono', monospace;
        border-radius: 4px;
        white-space: nowrap;
        z-index: 100;
    }
</style>

<div
    x-data="produtoManager()"
    x-init="init()"
    class="space-y-6 font-['Hanken_Grotesk',sans-serif] text-[#0b1c30]"
>
    {{-- Seção de Cards KPI (Resolvido o problema de esticamento artificial) --}}
    <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-[#cfc4c5]/20">
            <p class="text-xs font-['JetBrains_Mono'] text-[#4c4546] mb-1">Total de Produtos</p>
            <p class="text-2xl font-bold text-black" x-text="totalProdutos">0</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-[#cfc4c5]/20">
            <p class="text-xs font-['JetBrains_Mono'] text-[#4c4546] mb-1">Produtos Ativos</p>
            <p class="text-2xl font-bold text-black" x-text="totalProdutos">0</p> {{-- Mapeado dinamicamente para o seu counter --}}
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-[#cfc4c5]/20">
            <p class="text-xs font-['JetBrains_Mono'] text-[#4c4546] mb-1">Em Promoção</p>
            <p class="text-2xl font-bold text-emerald-600">1 <span class="text-xs font-normal text-[#4c4546]">Ativo</span></p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-[#cfc4c5]/20">
            <p class="text-xs font-['JetBrains_Mono'] text-[#4c4546] mb-1">Avisos</p>
            <p class="text-2xl font-bold text-black">0 <span class="text-xs font-normal text-[#4c4546]">críticos</span></p>
        </div>
    </section>

    {{-- Barra de Ações (Filtros Avançados alinhados e Input Amplo) --}}
    <section class="bg-white p-4 rounded-xl shadow-sm flex flex-wrap gap-4 items-center border border-[#cfc4c5]/20">
        {{-- Busca --}}
        <div class="flex-1 min-w-[300px] relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[#4c4546]">search</span>
            <input 
                x-model="search" 
                @input="currentPage = 1" 
                type="text" 
                placeholder="Buscar por nome, descrição ou SKU..."
                class="w-full pl-12 pr-4 py-2 bg-[#f8f9ff] border border-[#cfc4c5] rounded-lg text-sm focus:border-black focus:ring-0 transition-all outline-none"
            />
        </div>

        {{-- Dropdown customizado de Categorias reestruturado para o novo padrão --}}
        <div class="relative" x-data="{ open: false, selected: 'all' }">
            <button 
                @click="open = !open" 
                @click.outside="open = false" 
                type="button" 
                class="bg-[#f8f9ff] border border-[#cfc4c5] rounded-lg px-4 py-2 text-sm focus:border-black focus:ring-0 outline-none min-w-[180px] flex items-center justify-between gap-2"
            >
                <span x-text="selected === 'all' ? 'Categoria' : selected"></span>
                <span class="material-symbols-outlined text-sm">keyboard_arrow_down</span>
            </button>
            <ul 
                x-show="open" 
                x-transition
                class="absolute left-0 mt-2 w-full z-10 bg-white border border-[#cfc4c5]/30 rounded-xl shadow-xl py-1 max-h-60 overflow-y-auto font-medium"
                style="display: none;"
            >
                <li @click="categoryFilter = 'all'; selected = 'all'; open = false; currentPage = 1" class="px-4 py-2 text-sm text-[#4c4546] cursor-pointer hover:bg-[#f8f9ff]">Todas as Categorias</li>
                <template x-for="categoria in categorias" :key="categoria.id">
                    <li @click="categoryFilter = categoria.nome; selected = categoria.nome; open = false; currentPage = 1" 
                        class="px-4 py-2 text-sm text-[#4c4546] cursor-pointer hover:bg-[#f8f9ff]"
                        x-text="categoria.nome"></li>
                </template>
            </ul>
        </div>

        {{-- Botão de limpar filtros condicional --}}
        <button 
            x-show="search !== '' || categoryFilter !== 'all'"
            @click="search = ''; categoryFilter = 'all'; currentPage = 1"
            class="text-[#4c4546] hover:text-black font-['JetBrains_Mono'] text-xs transition-colors px-2"
            style="display: none;"
        >
            Limpar Filtros
        </button>

        {{-- Espaçador para alinhar o botão principal à direita em telas largas --}}
        <div class="md:flex-1 md:text-right">
            <button 
                @click="abrirCreateModal()" 
                class="w-full md:w-auto bg-black text-white px-6 py-2 rounded-lg flex items-center justify-center gap-2 font-['JetBrains_Mono'] text-xs hover:opacity-90 transition-all active:scale-95 shadow-sm uppercase tracking-wider"
            >
                + Novo Produto
            </button>
        </div>
    </section>

    {{-- Tabela de Produtos Moderna (Com Badges e Hierarquia Visual de Imagens) --}}
    <section class="bg-white rounded-xl shadow-sm border border-[#cfc4c5]/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-[#eff4ff] border-b border-[#cfc4c5]/50">
                    <tr>
                        <th class="p-4 w-12 text-center">
                            <input class="rounded border-[#cfc4c5] text-black focus:ring-0" type="checkbox"/>
                        </th>
                        <th class="p-4 text-xs font-['JetBrains_Mono'] text-[#4c4546] uppercase tracking-wider">Produto</th>
                        <th class="p-4 text-xs font-['JetBrains_Mono'] text-[#4c4546] uppercase tracking-wider">Categoria</th>
                        <th class="p-4 text-xs font-['JetBrains_Mono'] text-[#4c4546] uppercase tracking-wider text-right">Preço Base</th>
                        <th class="p-4 text-xs font-['JetBrains_Mono'] text-[#4c4546] uppercase tracking-wider">Status</th>
                        <th class="p-4 text-xs font-['JetBrains_Mono'] text-[#4c4546] uppercase tracking-wider text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#cfc4c5]/30 text-sm font-medium">
                    <template x-for="produto in paginatedProdutos" :key="produto.id">
                        <tr class="hover:bg-[#f8fafc] transition-colors">
                            <td class="p-4 text-center">
                                <input class="rounded border-[#cfc4c5] text-black focus:ring-0" type="checkbox"/>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-[#e5eeff] border border-[#cfc4c5]/40 overflow-hidden flex items-center justify-center shrink-0">
                                        <template x-if="produto.imagem_url">
                                            <img :src="resolveImageUrl(produto.imagem_url)" :alt="produto.nome" class="w-full h-full object-cover">
                                        </template>
                                        <template x-if="!produto.imagem_url">
                                            <span class="font-bold text-[10px] text-[#4c4546]/60 tracking-wider">GLOW</span>
                                        </template>
                                    </div>
                                    <div>
                                        <p class="font-bold text-[#0b1c30]" x-text="produto.nome"></p>
                                        <p class="text-xs font-['JetBrains_Mono'] text-[#4c4546]" x-text="`SKU: ${getSku(produto)}`"></p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-3 py-1 bg-[#d3e4fe] text-[#004395] rounded-full text-xs font-['JetBrains_Mono']" x-text="getCategoriaNome(produto)"></span>
                            </td>
                            <td class="p-4 text-right font-['JetBrains_Mono'] text-black font-semibold" x-text="formatMoney(produto.preco)"></td>
                            <td class="p-4">
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-['JetBrains_Mono'] inline-flex items-center">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-700 mr-1.5"></span>
                                    Ativo
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button @click="editarProduto(produto)" class="p-2 hover:bg-[#eff4ff] rounded-lg transition-colors text-[#4c4546] hover:text-black" data-tooltip="Editar">
                                        <span class="material-symbols-outlined text-base">edit</span>
                                    </button>
                                    <button @click="excluirProduto(produto.id, produto.nome)" class="p-2 hover:bg-red-50 rounded-lg transition-colors text-[#4c4546] hover:text-red-600" data-tooltip="Excluir">
                                        <span class="material-symbols-outlined text-base">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>

                    {{-- Estado Vazio Tratado --}}
                    <tr x-show="filteredProdutos.length === 0" style="display: none;">
                        <td colspan="6" class="py-12 p-4 text-center text-[#4c4546] text-sm">
                            Nenhum produto cadastrado ou encontrado nos filtros.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Rodapé de Paginação Redesenhado --}}
        <footer x-show="filteredProdutos.length > 0" class="p-4 bg-[#eff4ff] flex flex-col sm:flex-row justify-between items-center border-t border-[#cfc4c5]/30 gap-4 text-xs font-['JetBrains_Mono'] text-[#4c4546]">
            <div>
                Exibindo de <span class="text-black font-bold" x-text="startRecord"></span> até <span class="text-black font-bold" x-text="endRecord"></span> de <span class="text-black font-bold" x-text="filteredProdutos.length"></span> resultados
            </div>
            
            <div class="flex items-center gap-1" x-show="totalPages > 1" style="display: none;">
                <button 
                    @click="currentPage > 1 ? currentPage-- : null" 
                    :disabled="currentPage === 1"
                    class="w-8 h-8 flex items-center justify-center rounded border border-[#cfc4c5] bg-white hover:bg-[#eff4ff] transition-colors disabled:opacity-40"
                >
                    <span class="material-symbols-outlined text-sm">chevron_left</span>
                </button>

                <template x-for="page in totalPages" :key="page">
                    <button 
                        @click="currentPage = page" 
                        x-text="page"
                        class="w-8 h-8 flex items-center justify-center rounded transition-all font-['JetBrains_Mono']"
                        :class="currentPage === page ? 'bg-black text-white' : 'hover:bg-[#eff4ff] text-[#4c4546]'"
                    ></button>
                </template>

                <button 
                    @click="currentPage < totalPages ? currentPage++ : null" 
                    :disabled="currentPage === totalPages"
                    class="w-8 h-8 flex items-center justify-center rounded border border-[#cfc4c5] bg-white hover:bg-[#eff4ff] transition-colors disabled:opacity-40"
                >
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </button>
            </div>
        </footer>
    </section>

    {{-- ========================================== --}}
    {{-- MODAIS (Mantive sua marcação de Crop intacta) --}}
    {{-- ========================================== --}}

    {{-- Modal de Criação --}}
    <div x-show="openCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div x-show="openCreateModal" x-transition.opacity @click="resetForm()" class="fixed inset-0 bg-black/40 backdrop-blur-sm shadow-inner"></div>

            <div x-show="openCreateModal" x-transition.scale
                 class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-[#cfc4c5]/30"
            >
                <div class="bg-white p-6 sm:p-8">
                    <div class="flex items-center justify-between border-b border-[#cfc4c5]/20 pb-4 mb-6">
                        <div>
                            <h3 class="text-base font-bold text-black uppercase tracking-wide font-['JetBrains_Mono']">Novo Cosmético</h3>
                            <p class="text-xs text-[#4c4546] mt-0.5">Cadastre o produto definindo nome, categoria, preço e imagem.</p>
                        </div>
                        <button @click="resetForm()" class="text-[#4c4546] hover:text-black">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <form @submit.prevent="salvarProduto('create')" class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-[#4c4546] uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Nome do Produto</label>
                                <input type="text" required x-model="createData.nome" placeholder="Ex: Protetor Solar Fluido FPS 60"
                                       class="w-full px-4 py-2 bg-[#f8f9ff] border border-[#cfc4c5] rounded-lg text-sm focus:border-black focus:ring-0 transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[#4c4546] uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Categoria</label>
                                <select x-model="createData.categoria_id" required
                                        class="w-full px-4 py-2 bg-[#f8f9ff] border border-[#cfc4c5] rounded-lg text-sm focus:border-black focus:ring-0 transition-all">
                                    <option value="">Selecione</option>
                                    <template x-for="categoria in categorias" :key="categoria.id">
                                        <option :value="categoria.id" x-text="categoria.nome"></option>
                                    </template>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[#4c4546] uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Preço de Venda Base</label>
                                <input type="text" required x-model="createData.preco" placeholder="R$ 0,00"
                                       class="w-full px-4 py-2 bg-[#f8f9ff] border border-[#cfc4c5] rounded-lg text-sm focus:border-black focus:ring-0 transition-all">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-[#4c4546] uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Descrição</label>
                                <textarea x-model="createData.descricao" rows="4" placeholder="Descrição do produto"
                                          class="w-full px-4 py-2 bg-[#f8f9ff] border border-[#cfc4c5] rounded-lg text-sm focus:border-black focus:ring-0 transition-all"></textarea>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-[#4c4546] uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Imagem do Produto</label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    required
                                    x-ref="createFileInput"
                                    @change="handleImageChange($event, 'create')"
                                    class="w-full px-4 py-2 bg-[#f8f9ff] border border-[#cfc4c5] rounded-lg text-sm focus:border-black focus:ring-0 transition-all file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-bold file:bg-black file:text-white hover:file:opacity-90"
                                >

                                <div class="mt-3 flex items-start gap-4">
                                    <div class="w-32 h-32 rounded-xl border border-dashed border-[#cfc4c5] bg-[#f8f9ff] overflow-hidden flex items-center justify-center shrink-0">
                                        <template x-if="createData.imagePreview">
                                            <img :src="createData.imagePreview" class="w-full h-full object-cover" alt="Prévia da imagem">
                                        </template>
                                        <template x-if="!createData.imagePreview">
                                            <div class="text-center px-3">
                                                <span class="material-symbols-outlined text-[#cfc4c5] text-2xl">image</span>
                                                <p class="mt-1 text-[10px] text-[#4c4546] leading-4">Corte 1:1</p>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="text-xs text-[#4c4546] leading-5">
                                        Selecione uma imagem e ajuste o recorte quadrado antes de enviar.
                                        <div class="mt-1 text-[#cfc4c5]">A imagem será enviada já no formato ideal.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-[#cfc4c5]/20">
                            <button type="button" @click="resetForm()" class="px-4 py-2 bg-[#eff4ff] text-[#4c4546] text-xs font-bold uppercase font-['JetBrains_Mono'] rounded-lg transition-all">Cancelar</button>
                            <button type="submit" class="px-5 py-2 bg-black text-white text-xs font-bold uppercase tracking-wide font-['JetBrains_Mono'] rounded-lg transition-all shadow">
                                Salvar Produto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Edição --}}
    <div x-show="openEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div x-show="openEditModal" x-transition.opacity @click="resetForm()" class="fixed inset-0 bg-black/40 backdrop-blur-sm"></div>

            <div x-show="openEditModal" x-transition.scale
                 class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-[#cfc4c5]/30"
            >
                <div class="bg-white p-6 sm:p-8">
                    <div class="flex items-center justify-between border-b border-[#cfc4c5]/20 pb-4 mb-6">
                        <div>
                            <h3 class="text-base font-bold text-black uppercase tracking-wide font-['JetBrains_Mono']">Editar Informações</h3>
                            <p class="text-xs text-[#4c4546] mt-0.5">Modifique os dados do produto selecionado.</p>
                        </div>
                        <button @click="resetForm()" class="text-[#4c4546] hover:text-black">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <form @submit.prevent="salvarProduto('edit')" class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-[#4c4546] uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Nome do Produto</label>
                                <input type="text" required x-model="editData.nome"
                                       class="w-full px-4 py-2 bg-[#f8f9ff] border border-[#cfc4c5] rounded-lg text-sm focus:border-black focus:ring-0 transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[#4c4546] uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Categoria</label>
                                <select x-model="editData.categoria_id" required
                                        class="w-full px-4 py-2 bg-[#f8f9ff] border border-[#cfc4c5] rounded-lg text-sm focus:border-black focus:ring-0 transition-all">
                                    <option value="">Selecione</option>
                                    <template x-for="categoria in categorias" :key="categoria.id">
                                        <option :value="categoria.id" x-text="categoria.nome"></option>
                                    </template>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-[#4c4546] uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Preço de Venda Base</label>
                                <input type="text" required x-model="editData.preco"
                                       class="w-full px-4 py-2 bg-[#f8f9ff] border border-[#cfc4c5] rounded-lg text-sm focus:border-black focus:ring-0 transition-all">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-[#4c4546] uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Descrição</label>
                                <textarea x-model="editData.descricao" rows="4"
                                          class="w-full px-4 py-2 bg-[#f8f9ff] border border-[#cfc4c5] rounded-lg text-sm focus:border-black focus:ring-0 transition-all"></textarea>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-[#4c4546] uppercase tracking-wider mb-2 font-['JetBrains_Mono']">Imagem do Produto</label>
                                <input
                                    type="file"
                                    accept="image/*"
                                    x-ref="editFileInput"
                                    @change="handleImageChange($event, 'edit')"
                                    class="w-full px-4 py-2 bg-[#f8f9ff] border border-[#cfc4c5] rounded-lg text-sm focus:border-black focus:ring-0 transition-all file:mr-4 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-bold file:bg-black file:text-white hover:file:opacity-90"
                                >

                                <div class="mt-3 flex items-start gap-4">
                                    <div class="w-32 h-32 rounded-xl border border-dashed border-[#cfc4c5] bg-[#f8f9ff] overflow-hidden flex items-center justify-center shrink-0">
                                        <template x-if="editData.imagePreview || editData.currentImageUrl">
                                            <img :src="editData.imagePreview || editData.currentImageUrl" class="w-full h-full object-cover" alt="Prévia da imagem">
                                        </template>
                                        <template x-if="!editData.imagePreview && !editData.currentImageUrl">
                                            <div class="text-center px-3">
                                                <span class="material-symbols-outlined text-[#cfc4c5] text-2xl">image</span>
                                                <p class="mt-1 text-[10px] text-[#4c4546] leading-4">Sem Imagem</p>
                                            </div>
                                        </template>
                                    </div>
                                    <div class="text-xs text-[#4c4546] leading-5">
                                        Se quiser alterar a imagem, selecione um novo arquivo e ajuste o corte quadrado.
                                        <div class="mt-1 text-[#cfc4c5]">Se não selecionar outra imagem, a atual será mantida.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-[#cfc4c5]/20">
                            <button type="button" @click="resetForm()" class="px-4 py-2 bg-[#eff4ff] text-[#4c4546] text-xs font-bold uppercase font-['JetBrains_Mono'] rounded-lg transition-all">Cancelar</button>
                            <button type="submit" class="px-5 py-2 bg-black text-white text-xs font-bold uppercase tracking-wide font-['JetBrains_Mono'] rounded-lg transition-all shadow">
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Crop --}}
    <div x-show="openCropModal" x-cloak class="fixed inset-0 z-[60] overflow-y-auto" role="dialog">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div x-show="openCropModal" x-transition.opacity @click="cancelCrop()" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

            <div x-show="openCropModal" x-transition.scale
                 class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full border border-[#cfc4c5]/30"
            >
                <div class="bg-white p-6 sm:p-8 space-y-5">
                    <div class="flex items-center justify-between border-b border-[#cfc4c5]/20 pb-4">
                        <div>
                            <h3 class="text-base font-bold text-black uppercase tracking-wide font-['JetBrains_Mono']">Ajustar Imagem</h3>
                            <p class="text-xs text-[#4c4546] mt-0.5">Arraste e ajuste o corte em formato quadrado antes de confirmar.</p>
                        </div>
                        <button type="button" @click="cancelCrop()" class="text-[#4c4546] hover:text-black">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    <div class="bg-[#f8f9ff] border border-[#cfc4c5] rounded-2xl overflow-hidden flex items-center justify-center min-h-[320px] min-w-[320px]">
                        <img x-ref="cropImage" :src="cropSource" class="max-w-full max-h-[70vh] block" style="min-width:200px; min-height:200px;" alt="Imagem para recorte">
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" @click="cancelCrop()" class="px-4 py-2 bg-[#eff4ff] text-[#4c4546] text-xs font-bold uppercase font-['JetBrains_Mono'] rounded-lg transition-all">Cancelar</button>
                        <button type="button" @click="confirmCrop()" class="px-5 py-2 bg-black text-white text-xs font-bold uppercase tracking-wide font-['JetBrains_Mono'] rounded-lg transition-all shadow">
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
            imagePreview: ''
        },

        editData: {
            id: null,
            nome: '',
            categoria_id: '',
            preco: '',
            descricao: '',
            file: null,
            imagePreview: '',
            currentImageUrl: ''
        },

        categorias: [],
        produtos: [],
        loading: false,

        csrf: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || null,

        init() {
            if (window.axios) {
                axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
                axios.defaults.withCredentials = true;
            }
            this.carregarCategorias();
            this.carregarProdutos();
        },

        get totalProdutos() {
            return this.produtos.length;
        },

        get filteredProdutos() {
            const term = this.search.trim().toLowerCase();

            return this.produtos.filter((produto) => {
                const nome = (produto.nome ?? '').toLowerCase();
                const descricao = (produto.descricao ?? '').toLowerCase();
                const sku = this.getSku(produto).toLowerCase();
                const categoriaNome = this.getCategoriaNome(produto).toLowerCase();

                const matchSearch =
                    term === '' ||
                    nome.includes(term) ||
                    descricao.includes(term) ||
                    sku.includes(term);

                const matchCategoria =
                    this.categoryFilter === 'all' ||
                    categoriaNome === this.categoryFilter.toLowerCase();

                return matchSearch && matchCategoria;
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

        async carregarCategorias() {
            try {
                const response = await axios.get('/api/categoria', {
                    headers: { Accept: 'application/json' }
                });
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
                imagePreview: ''
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
                currentImageUrl: ''
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

                // Campo obrigatório adicionado de forma fixa nos bastidores
                formData.append('status', 'ativo');

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
