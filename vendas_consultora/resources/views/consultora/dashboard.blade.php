@extends('layouts.app')
@section('conteudo')
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-4">Seja bem-vinda!</h1>
        
        <div class="space-y-4">
            <h2 class="text-lg">Comissão: <span id="comissao" class="font-bold text-green-600">Carregando...</span></h2>
            <h2 class="text-lg">Meta Atual: <span id="meta" class="font-bold text-pink-600">Carregando...</span></h2>
            <h2 class="text-lg">Progresso: <span id="metaProgresso" class="font-bold text-blue-600">Carregando...</span></h2>
        </div>

        <p id="erro" class="text-red-500 mt-4 font-medium"></p>
    </div>
@endsection