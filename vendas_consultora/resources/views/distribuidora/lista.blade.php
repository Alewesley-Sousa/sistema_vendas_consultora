@extends('layouts.app')

@section('title', 'Lista de Clientes')
@section('header-icon', 'fas fa-users')
@section('header-title', 'Meus Clientes')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Clientes Cadastrados</h1>
        <a href="{{ route('cliente.cadastrar') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
            <i class="fas fa-plus mr-2"></i>Criar Nova Conta de Cliente
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            @if($clientes->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPF</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefone</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($clientes as $cliente)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $cliente->nome }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cliente->email }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cliente->cpf }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cliente->telefone }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('cliente.editar', $cliente->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                                        <button onclick="excluirCliente({{ $cliente->id }})" class="text-red-600 hover:text-red-900">Excluir</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum cliente cadastrado</h3>
                    <p class="text-gray-500 mb-6">Comece cadastrando seu primeiro cliente.</p>
                    <a href="{{ route('cliente.cadastrar') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                        <i class="fas fa-plus mr-2"></i>Criar Primeira Conta de Cliente
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function excluirCliente(id) {
    if (confirm('Tem certeza que deseja excluir este cliente?')) {
        fetch(`/cliente/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Cliente excluído com sucesso!');
                location.reload();
            } else {
                alert('Erro ao excluir cliente: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao excluir cliente.');
        });
    }
}
</script>
@endsection