@extends('layouts.app')

@section('title', isset($produto) ? 'Editar Produto' : 'Cadastrar Novo Produto')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        
        <h1 class="text-3xl font-bold mb-6 text-gray-800">
            {{ isset($produto) ? 'Editar Produto' : 'Cadastrar Novo Produto' }}
        </h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <h3 class="font-bold mb-2">Erros encontrados:</h3>
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="produtoForm" 
              action="{{ isset($produto) ? route('api.produtos.atualizar', $produto->id) : route('api.produtos.criar') }}" 
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @if(isset($produto))
                @method('PUT')
            @endif

            <!-- Nome do Produto -->
            <div class="mb-6">
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-2">
                    Nome do Produto <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="nome" 
                    name="nome"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Ex: Perfume Essencial"
                    value="{{ old('nome', $produto->nome ?? '') }}"
                    required>
                <span class="error-text text-red-500 text-sm hidden"></span>
            </div>

            <!-- Preço -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="preco" class="block text-sm font-medium text-gray-700 mb-2">
                        Preço (R$) <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="preco" 
                        name="preco"
                        step="0.01"
                        min="0.01"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="0.00"
                        value="{{ old('preco', $produto->preco ?? '') }}"
                        required>
                    <span class="error-text text-red-500 text-sm hidden"></span>
                </div>

                <!-- Categoria -->
                <div>
                    <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Categoria <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="categoria_id" 
                        name="categoria_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                        <option value="">-- Selecione uma categoria --</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" 
                                {{ old('categoria_id', $produto->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nome }}
                            </option>
                        @endforeach
                    </select>
                    <span class="error-text text-red-500 text-sm hidden"></span>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label for="status_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select 
                    id="status_id" 
                    name="status_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
                    <option value="">-- Selecione um status --</option>
                    @foreach($status as $stat)
                        <option value="{{ $stat->id }}" 
                            {{ old('status_id', $produto->status_id ?? '') == $stat->id ? 'selected' : '' }}>
                            {{ $stat->nome }}
                        </option>
                    @endforeach
                </select>
                <span class="error-text text-red-500 text-sm hidden"></span>
            </div>

            <!-- Descrição -->
            <div class="mb-6">
                <label for="descricao" class="block text-sm font-medium text-gray-700 mb-2">
                    Descrição
                </label>
                <textarea 
                    id="descricao" 
                    name="descricao"
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Descreva o produto...">{{ old('descricao', $produto->descricao ?? '') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Máximo 500 caracteres</p>
            </div>

            <!-- URL da Imagem -->
            <div class="mb-6">
                <label for="imagem_url" class="block text-sm font-medium text-gray-700 mb-2">
                    URL da Imagem
                </label>
                <input 
                    type="url" 
                    id="imagem_url" 
                    name="imagem_url"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="https://exemplo.com/imagem.jpg"
                    value="{{ old('imagem_url', $produto->imagem_url ?? '') }}">
                <p class="text-xs text-gray-500 mt-1">Cole a URL completa da imagem do produto</p>
            </div>

            <!-- Estoque Inicial (apenas para novo produto) -->
            @if(!isset($produto))
            <div class="mb-6">
                <label for="estoque_inicial" class="block text-sm font-medium text-gray-700 mb-2">
                    Estoque Inicial
                </label>
                <input 
                    type="number" 
                    id="estoque_inicial" 
                    name="estoque_inicial"
                    min="0"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="0"
                    value="{{ old('estoque_inicial', '') }}">
                <p class="text-xs text-gray-500 mt-1">Quantidade inicial em estoque</p>
            </div>
            @endif

            <!-- Botões de Ação -->
            <div class="flex gap-4 mt-8">
                <button 
                    type="submit" 
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
                    {{ isset($produto) ? 'Atualizar Produto' : 'Criar Produto' }}
                </button>
                <a 
                    href="{{ route('consultora.dashboard') }}" 
                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg text-center transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Script para processar o formulário via AJAX -->
<script>
document.getElementById('produtoForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = this;
    const formData = new FormData(form);
    const url = form.action;
    const method = form.querySelector('input[name="_method"]') ? 'PUT' : 'POST';

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        });

        const data = await response.json();

        if (response.ok) {
            alert('✅ ' + data.mensagem);
            window.location.href = '{{ route("consultora.dashboard") }}';
        } else {
            alert('❌ Erro: ' + data.mensagem);
            console.error('Erro:', data);
        }
    } catch (error) {
        alert('❌ Erro na requisição: ' + error.message);
        console.error('Erro:', error);
    }
});
</script>

<style>
    .container {
        max-width: 1200px;
    }
    
    input:focus, select:focus, textarea:focus {
        outline: none;
    }
</style>
@endsection
