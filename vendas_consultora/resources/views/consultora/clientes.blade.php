@extends('layouts.app')

@section('title', 'Meus Clientes - Consultora')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Cabeçalho -->
        <div class="mb-8 bg-gradient-to-r from-green-600 via-teal-600 to-cyan-600 rounded-3xl p-8 text-white shadow-2xl">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-extrabold mb-2">👥 Meus Clientes</h1>
                    <p class="text-green-100 text-lg">Gerencie seus clientes cadastrados</p>
                </div>
                <a href="{{ route('cliente.cadastrar') }}"
                   class="bg-white text-green-600 font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    ➕ Novo Cliente
                </a>
            </div>
        </div>

        <!-- Lista de Clientes -->
        <div class="bg-white rounded-2xl shadow-xl p-6">
            @if($clientes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($clientes as $cliente)
                        <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                    {{ substr($cliente->nome, 0, 1) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg">{{ $cliente->nome }}</h3>
                                    <p class="text-sm text-gray-600">{{ $cliente->email }}</p>
                                </div>
                            </div>

                            <div class="space-y-2 text-sm text-gray-600">
                                <p><strong>CPF:</strong> {{ $cliente->cpf }}</p>
                                <p><strong>Telefone:</strong> {{ $cliente->telefone ?? 'N/A' }}</p>
                                <p><strong>Endereço:</strong> {{ $cliente->endereco ?? 'N/A' }}</p>
                                <p><strong>Data Cadastro:</strong> {{ $cliente->created_at->format('d/m/Y') }}</p>
                            </div>

                            <div class="flex gap-2 mt-6">
                                <a href="{{ route('cliente.editar', $cliente->id) }}"
                                   class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 px-4 rounded-lg text-sm font-semibold transition">
                                    ✏️ Editar
                                </a>
                                <button onclick="deletarCliente({{ $cliente->id }})"
                                        class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg text-sm font-semibold transition">
                                    🗑️ Deletar
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 mb-4 text-lg">Nenhum cliente cadastrado ainda.</p>
                    <a href="{{ route('cliente.cadastrar') }}"
                       class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-xl transition">
                        Cadastrar Primeiro Cliente
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    async function deletarCliente(id) {
        if (!confirm('Tem certeza que deseja deletar este cliente?')) return;

        try {
            const response = await fetch(`/api/clientes/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (data.status === 'success') {
                alert('Cliente deletado com sucesso!');
                location.reload();
            } else {
                alert('Erro ao deletar cliente: ' + data.message);
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao deletar cliente');
        }
    }
</script>
@endsection