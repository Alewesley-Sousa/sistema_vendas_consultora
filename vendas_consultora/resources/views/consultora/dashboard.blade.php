@extends('layouts.app')

@section('conteudo')
<div class="max-w-4xl mx-auto px-4 py-8">
    
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-800">Olá, <span class="text-indigo-600">Seja bem-vinda!</span></h1>
            <p class="text-slate-500 font-medium">Aqui está o resumo do seu desempenho hoje.</p>
        </div>
        <div class="bg-indigo-100 p-4 rounded-3xl hidden md:block">
            <i class="fas fa-chart-line text-indigo-600 text-2xl"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Minha Comissão</span>
            <div class="flex items-center gap-3 mt-2">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                    <i class="fas fa-wallet"></i>
                </div>
                <h2 id="comissao" class="text-2xl font-black text-slate-800">R$ 0,00</h2>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Meta do Mês</span>
            <div class="flex items-center gap-3 mt-2">
                <div class="w-10 h-10 rounded-2xl bg-rose-100 flex items-center justify-center text-rose-600">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h2 id="meta" class="text-2xl font-black text-slate-800">R$ 0,00</h2>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <span class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Progresso Atual</span>
            <div class="flex items-center gap-3 mt-2">
                <div class="w-10 h-10 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fas fa-tasks"></i>
                </div>
                <h2 id="metaProgresso" class="text-2xl font-black text-slate-800">0%</h2>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="bg-white p-8 rounded-[2rem] border-2 border-indigo-50 shadow-xl shadow-indigo-100/50 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform duration-700 ease-in-out opacity-50"></div>
            
            <div class="relative">
                <h3 class="text-slate-800 font-black text-xl mb-2 flex items-center gap-2">
                    <i class="fas fa-shopping-bag text-indigo-600"></i> Vendas & Pedidos
                </h3>
                <p class="text-slate-500 text-sm mb-8 font-medium leading-relaxed">Consulte os produtos disponíveis no catálogo atual e registre as vendas das suas clientes.</p>
                
                <div class="space-y-4">
                    <a href="{{ route('catalogo.visualizar') }}" 
                       class="flex items-center justify-center gap-3 px-6 py-5 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl transition-all active:scale-95 shadow-lg shadow-indigo-200 uppercase tracking-wider text-sm">
                       <i class="fas fa-book-open"></i> Abrir Catálogo Digital
                    </a>

                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('cliente.cadastrar') }}" 
                           class="flex items-center justify-center gap-2 px-4 py-4 bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200 font-bold rounded-2xl transition-all active:scale-95 text-xs">
                           <i class="fas fa-user-plus text-indigo-500 text-sm"></i> Novo Cliente
                        </a>

                        <a href="{{ route('consultoraHistorico') }}" 
                           class="flex items-center justify-center gap-2 px-4 py-4 bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200 font-bold rounded-2xl transition-all active:scale-95 text-xs">
                           <i class="fas fa-history text-indigo-500 text-sm"></i> Ver Pedidos
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-indigo-600 p-8 rounded-[2rem] shadow-xl shadow-indigo-200 flex flex-col justify-between border-b-8 border-indigo-800">
            <div>
                <div class="w-14 h-14 bg-indigo-500 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                    <i class="fas fa-seedling text-indigo-200 text-2xl"></i>
                </div>
                <h3 class="text-white font-black text-xl mb-2 tracking-tight">Expansão de Equipe</h3>
                <p class="text-indigo-100 text-sm mb-8 font-medium leading-relaxed opacity-80">Indique novas consultoras para sua rede e aumente seu percentual de ganhos sobre as vendas da equipe.</p>
            </div>
            
            <a href="{{ route('usuario.cadastrar') }}" 
               class="flex items-center justify-center gap-3 px-6 py-5 bg-white hover:bg-indigo-50 text-indigo-700 font-black rounded-2xl transition-all active:scale-95 shadow-lg uppercase tracking-wider text-sm">
               <i class="fas fa-user-plus"></i> Recrutar Agora
            </a>
        </div>

    </div>

    <p id="erro" class="text-red-500 mt-10 text-center font-bold bg-red-50 rounded-2xl py-4 hidden border border-red-100 mx-4"></p>
</div>
@endsection