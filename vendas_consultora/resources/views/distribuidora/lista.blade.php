@extends('layouts.app')

@section('conteudo')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-black text-slate-800">Clientes Cadastrados</h1>
        <a href="{{ route('cliente.cadastrar') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-indigo-700 transition-all">
            <i class="fas fa-plus mr-2"></i> Novo Cliente
        </a>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase">Nome</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase">CPF / Email</th>
                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($clientes as $cliente)
                <tr id="linha-{{ $cliente->id }}" class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 font-bold text-slate-700">{{ $cliente->nome }}</td>
                    <td class="px-6 py-4 text-sm text-slate-500">
                        {{ $cliente->cpf }} <br> <span class="text-xs">{{ $cliente->email }}</span>
                    </td>
                    <td class="px-6 py-4 text-right flex justify-end gap-2">
                        <a href="{{ route('cliente.editar', $cliente->id) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="apagarCliente({{ $cliente->id }})" class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 bg-slate-50">
            {{ $clientes->links() }}
        </div>
    </div>
</div>


<script>
async function apagarCliente(id) {
    if(!confirm('Tem certeza que deseja apagar este cliente?')) return;

    try {
        // Adicionando o header de CSRF Token caso o axios não tenha pego automaticamente
        const response = await axios.delete(`/api/cliente/${id}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        if(response.data.status === 'success') {
            const linha = document.getElementById(`linha-${id}`);
            linha.style.transition = "all 0.5s";
            linha.style.opacity = "0";
            linha.style.transform = "translateX(20px)";
            
            setTimeout(() => {
                linha.remove();
            }, 500);
            
            // Opcional: toast de sucesso (se você tiver uma biblioteca de alertas)
        }
    } catch (error) {
        console.error('Erro detalhado:', error.response); // Isso te mostra o erro real no F12
        alert('Erro ao apagar cliente: ' + (error.response?.data?.mensagem || 'Erro desconhecido'));
    }
}
</script>
@endsection