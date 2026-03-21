@extends('layouts.app')

@section('conteudo')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-4">Seja bem-vinda!</h1>
        
        <div class="space-y-4 mb-6">
            <h2 class="text-lg">Comissão: <span id="comissao" class="font-bold text-green-600">Carregando...</span></h2>
            <h2 class="text-lg">Meta Atual: <span id="meta" class="font-bold text-pink-600">Carregando...</span></h2>
            <h2 class="text-lg">Progresso: <span id="metaProgresso" class="font-bold text-blue-600">Carregando...</span></h2>
        </div>

        <div class="flex flex-col gap-3 border-t pt-6">
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider">Ações de Cliente (Testes)</h3>
            
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('cliente.cadastrar') }}" 
                   class="flex-1 text-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-100">
                   <i class="fas fa-user-plus mr-2"></i> Novo Cliente
                </a>

                <a href="{{ route('cliente.editar', ['id' => 2]) }}" 
                   class="flex-1 text-center px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-amber-100">
                   <i class="fas fa-user-edit mr-2"></i> Editar (ID: 2)
                </a>
            </div>

            <a href="{{ route('consultoraHistorico') }}" class="text-center text-sm font-medium text-slate-500 hover:text-blue-600 mt-2 transition-colors">
                Ver Histórico de Comissões
            </a>
        </div>

        <p id="erro" class="text-red-500 mt-4 font-medium"></p>
    </div>
@endsection