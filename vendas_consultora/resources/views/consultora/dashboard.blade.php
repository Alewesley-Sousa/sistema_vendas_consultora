@extends('layouts.app')

@section('conteudo')
<div class="max-w-4xl mx-auto px-4 py-8">
    
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800">Olá, <span class="text-indigo-600">Seja bem-vinda!</span></h1>
            <p class="text-slate-500 font-medium">Aqui está o resumo do seu desempenho hoje.</p>
        </div>
        <div class="bg-indigo-100 p-3 rounded-2xl">
            <i class="fas fa-chart-line text-indigo-600 text-2xl"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Minha Comissão</span>
            <div class="flex items-center gap-3 mt-2">
                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                    <i class="fas fa-wallet"></i>
                </div>
                <h2 id="comissao" class="text-2xl font-bold text-slate-800">R$ 0,00</h2>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Meta do Mês</span>
            <div class="flex items-center gap-3 mt-2">
                <div class="w-10 h-10 rounded-full bg-rose-100 flex items-center justify-center text-rose-600">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h2 id="meta" class="text-2xl font-bold text-slate-800">R$ 0,00</h2>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <span class="text-slate-400 text-xs font-bold uppercase tracking-wider">Progresso Atual</span>
            <div class="flex items-center gap-3 mt-2">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fas fa-tasks"></i>
                </div>
                <h2 id="metaProgresso" class="text-2xl font-bold text-slate-800">0%</h2>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="bg-slate-50 p-6 rounded-3xl border border-dashed border-slate-300">
            <h3 class="text-slate-700 font-bold mb-4 flex items-center gap-2">
                <i class="fas fa-users text-slate-400"></i> Gestão de Vendas
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('cliente.cadastrar') }}" 
                   class="flex items-center justify-center gap-2 px-4 py-3 bg-white hover:bg-indigo-50 text-indigo-600 border border-indigo-200 font-bold rounded-2xl transition-all active:scale-95 shadow-sm">
                   <i class="fas fa-plus-circle text-sm"></i> Novo Cliente
                </a>

                <a href="{{ route('cliente.editar', ['id' => 2]) }}" 
                   class="flex items-center justify-center gap-2 px-4 py-3 bg-white hover:bg-slate-100 text-slate-600 border border-slate-200 font-bold rounded-2xl transition-all active:scale-95 shadow-sm">
                   <i class="fas fa-edit text-sm"></i> Editar (2)
                </a>
            </div>
            <a href="{{ route('consultoraHistorico') }}" class="block text-center text-xs font-bold text-indigo-500 hover:underline mt-4">
                CONFERIR HISTÓRICO COMPLETO
            </a>
        </div>

        <div class="bg-indigo-600 p-6 rounded-3xl shadow-xl shadow-indigo-200">
            <h3 class="text-indigo-100 font-bold mb-4 flex items-center gap-2">
                <i class="fas fa-seedling text-indigo-300"></i> Expansão de Equipe
            </h3>
            <p class="text-indigo-200 text-sm mb-6">Cadastre novas consultoras e aumente sua rede de ganhos.</p>
            
            <a href="{{ route('usuario.cadastrar') }}" 
               class="flex items-center justify-center gap-2 px-4 py-4 bg-white hover:bg-indigo-50 text-indigo-700 font-extrabold rounded-2xl transition-all active:scale-95 shadow-lg">
               <i class="fas fa-user-plus"></i> RECRUTAR NOVA CONSULTORA
            </a>
        </div>

    </div>

    <p id="erro" class="text-red-500 mt-8 text-center font-medium bg-red-50 rounded-lg py-2 hidden"></p>
</div>
@endsection