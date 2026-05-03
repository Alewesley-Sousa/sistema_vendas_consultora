<!-- EXEMPLO DE INTEGRAÇÃO NO DASHBOARD -->
<!-- Copie e cole este código no seu arquivo: resources/views/consultora/dashboard.blade.php -->

@extends('layouts.app')

@section('title', 'Dashboard - Consultora')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Cabeçalho do Dashboard -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900">
            👋 Bem-vindo(a), {{ Auth::user()->nome ?? 'Consultora' }}!
        </h1>
        <p class="text-gray-600 mt-2">Gerencie seus produtos e pedidos aqui</p>
    </div>

    <!-- Barra de Atalhos -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
            <h3 class="font-bold text-blue-900">📊 Estatísticas</h3>
            <div id="stats" class="mt-2 text-sm text-blue-700">Carregando...</div>
        </div>
        
        <a href="{{ route('produto.cadastrar') }}" 
           class="bg-green-50 border-l-4 border-green-500 p-4 rounded hover:shadow-md transition">
            <h3 class="font-bold text-green-900">➕ Novo Produto</h3>
            <p class="text-sm text-green-700">Adicione um novo produto ao catálogo</p>
        </a>
        
        <a href="{{ route('cliente.listar') }}" 
           class="bg-purple-50 border-l-4 border-purple-500 p-4 rounded hover:shadow-md transition">
            <h3 class="font-bold text-purple-900">👥 Meus Clientes</h3>
            <p class="text-sm text-purple-700">Gerenciar clientes cadastrados</p>
        </a>
    </div>

    <!-- WIDGET DE PRODUTOS (PRINCIPAL) -->
    @include('components.widget-produtos-dashboard')

    <!-- Seção de Pedidos Recentes (Opcional) -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">📋 Pedidos Recentes</h2>
        
        <div id="pedidosContainer" class="space-y-3">
            <!-- Carregado via JavaScript -->
        </div>
    </div>

    <!-- Seção de Relatórios -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Produtos com Baixo Estoque -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <h3 class="text-xl font-bold text-yellow-900 mb-4">⚠️ Produtos com Baixo Estoque</h3>
            <div id="estoqueContainer" class="space-y-2">
                <p class="text-gray-600">Carregando...</p>
            </div>
        </div>

        <!-- Resumo de Vendas -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <h3 class="text-xl font-bold text-green-900 mb-4">💰 Resumo de Vendas</h3>
            <div id="vendasContainer" class="space-y-2">
                <p class="text-gray-600">Carregando...</p>
            </div>
        </div>
    </div>
</div>

<script>
// ============ ESTATÍSTICAS ============
async function carregarEstatisticas() {
    try {
        const response = await fetch('/api/produtos/', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();
        
        if (data.status === 'success') {
            const total = data.dados.length;
            const preco_medio = data.dados.length > 0 
                ? (data.dados.reduce((sum, p) => sum + parseFloat(p.preco), 0) / total).toFixed(2)
                : 0;

            document.getElementById('stats').innerHTML = `
                <p><strong>${total}</strong> produtos cadastrados</p>
                <p>Preço médio: <strong>R$ ${preco_medio.replace('.', ',')}</strong></p>
            `;
        }
    } catch (error) {
        console.error('Erro ao carregar estatísticas:', error);
    }
}

// ============ PRODUTOS COM BAIXO ESTOQUE ============
async function carregarEstoqueBaixo() {
    try {
        const response = await fetch('/api/produtos/relatorio/baixo-estoque?minimo=10', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();
        const container = document.getElementById('estoqueContainer');

        if (data.status === 'success' && data.dados.length > 0) {
            container.innerHTML = data.dados.map(p => `
                <div class="flex justify-between items-center bg-white p-3 rounded border border-yellow-100">
                    <div>
                        <p class="font-semibold text-gray-800">${p.nome}</p>
                        <p class="text-sm text-gray-500">Estoque: ${p.estoques?.[0]?.quantidade ?? '0'} unidades</p>
                    </div>
                    <a href="{{ route('produto.editar', '') }}/${p.id}" 
                       class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600 transition">
                        Reabastecer
                    </a>
                </div>
            `).join('');
        } else {
            container.innerHTML = '<p class="text-green-700 font-semibold">✅ Todos os produtos têm estoque adequado</p>';
        }
    } catch (error) {
        console.error('Erro ao carregar estoque:', error);
        document.getElementById('estoqueContainer').innerHTML = '<p class="text-red-500">Erro ao carregar dados</p>';
    }
}

// ============ CARREGAR TUDO AO INICIAR ============
document.addEventListener('DOMContentLoaded', () => {
    carregarEstatisticas();
    carregarEstoqueBaixo();
});

// Atualizar a cada 30 segundos
setInterval(() => {
    carregarEstatisticas();
    carregarEstoqueBaixo();
}, 30000);
</script>

<style>
    .container {
        max-width: 1400px;
    }
</style>
@endsection
