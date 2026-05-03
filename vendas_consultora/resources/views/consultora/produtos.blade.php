@extends('layouts.app')

@section('title', 'Meus Produtos - Consultora')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Cabeçalho -->
        <div class="mb-8 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-3xl p-8 text-white shadow-2xl">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-extrabold mb-2">📦 Meus Produtos</h1>
                    <p class="text-blue-100 text-lg">Gerencie seu catálogo de produtos</p>
                </div>
                <a href="{{ route('produto.cadastrar') }}"
                   class="bg-white text-indigo-600 font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    ➕ Novo Produto
                </a>
            </div>
        </div>

        <!-- Lista de Produtos -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            @if($produtos->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($produtos as $produto)
                        <div class="border border-gray-200 rounded-xl p-4 hover:shadow-lg transition-all duration-300">
                            @if($produto->imagem_url)
                                <img src="{{ $produto->imagem_url }}" alt="{{ $produto->nome }}"
                                     class="w-full h-40 object-cover rounded-lg mb-3">
                            @else
                                <div class="w-full h-40 bg-gray-300 rounded-lg mb-3 flex items-center justify-center">
                                    <span class="text-gray-500">Sem imagem</span>
                                </div>
                            @endif

                            <h3 class="font-bold text-gray-800 text-lg line-clamp-2">{{ $produto->nome }}</h3>

                            <p class="text-sm text-gray-600 mb-2">
                                Categoria: <span class="font-semibold">{{ $produto->categoria?->nome ?? 'N/A' }}</span>
                            </p>

                            <div class="flex justify-between items-center mt-4">
                                <span class="text-xl font-bold text-green-600">
                                    R$ {{ number_format($produto->preco, 2, ',', '.') }}
                                </span>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs font-semibold">
                                    {{ $produto->status?->nome ?? 'Ativo' }}
                                </span>
                            </div>

                            @if($produto->descricao)
                                <p class="text-xs text-gray-600 mt-3 line-clamp-2">{{ $produto->descricao }}</p>
                            @endif

                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('produto.editar', $produto->id) }}"
                                   class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 px-4 rounded-lg text-sm font-semibold transition">
                                    ✏️ Editar
                                </a>
                                <button onclick="deletarProduto({{ $produto->id }})"
                                        class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg text-sm font-semibold transition">
                                    🗑️ Deletar
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 mb-4 text-lg">Nenhum produto cadastrado ainda.</p>
                    <a href="{{ route('produto.cadastrar') }}"
                       class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-xl transition">
                        Criar Primeiro Produto
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    async function deletarProduto(id) {
        if (!confirm('Tem certeza que deseja deletar este produto?')) return;

        try {
            const response = await fetch(`/api/produtos/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (data.status === 'success') {
                alert('Produto deletado com sucesso!');
                location.reload();
            } else {
                alert('Erro ao deletar produto: ' + data.message);
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao deletar produto');
        }
    }
</script>
@endsection