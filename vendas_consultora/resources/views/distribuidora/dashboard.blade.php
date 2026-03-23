@extends('layouts.app')

@section('conteudo')
<div class="max-w-7xl mx-auto px-4 py-10 min-h-screen">
    
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <span class="text-indigo-600 font-black text-xs uppercase tracking-[0.3em] mb-1 block">Painel Administrativo</span>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight leading-none">Distribuidora Central</h1>
            <p class="text-slate-500 font-medium mt-3 text-lg">Visão geral e controle de consultoras.</p>
        </div>
        
        <div class="flex items-center gap-4 bg-white p-4 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 shadow-inner">
                <i class="fas fa-calendar-check text-xl"></i>
            </div>
            <div>
                <span class="block text-[10px] text-slate-400 font-black uppercase tracking-widest">Status do Sistema</span>
                <span class="flex items-center gap-2 font-black text-slate-700 text-sm">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> Online
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm transition-all hover:shadow-md">
            <span class="text-slate-400 font-bold text-[10px] uppercase tracking-widest">Total de Clientes</span>
            <div class="flex items-end justify-between mt-4">
                <span class="text-5xl font-black text-slate-900 tracking-tighter">--</span>
                <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-users text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm transition-all hover:shadow-md">
            <span class="text-slate-400 font-bold text-[10px] uppercase tracking-widest">Consultoras Ativas</span>
            <div class="flex items-end justify-between mt-4">
                <span class="text-5xl font-black text-slate-900 tracking-tighter">--</span>
                <div class="w-12 h-12 bg-purple-50 text-purple-500 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-user-tie text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-slate-900 p-8 rounded-[2.5rem] shadow-2xl shadow-indigo-100 lg:col-span-2 flex items-center justify-between overflow-hidden relative">
            <div class="relative z-10">
                <h4 class="text-white font-black text-2xl leading-tight">Módulo de Gestão <br><span class="text-indigo-400">Liberado.</span></h4>
                <p class="text-slate-400 text-xs mt-3 font-medium max-w-[200px]">Gerencie sua base de dados centralizada agora mesmo.</p>
            </div>
            <i class="fas fa-shield-alt text-indigo-500/20 text-8xl absolute -right-4 -bottom-4 rotate-12"></i>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-3">
            Ferramentas de Controle
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <a href="{{ route('cliente.listar') }}" 
           class="group relative bg-white p-1 rounded-[3rem] transition-all duration-500 hover:-translate-y-2">
            
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-[3rem] opacity-0 group-hover:opacity-100 transition-opacity blur-2xl"></div>
            
            <div class="relative bg-white border border-slate-100 p-10 rounded-[2.9rem] h-full shadow-sm group-hover:shadow-2xl transition-all">
                <div class="w-20 h-20 bg-indigo-600 rounded-[1.8rem] flex items-center justify-center text-white mb-8 shadow-xl shadow-indigo-200 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-list-ul text-3xl"></i>
                </div>
                
                <h3 class="text-2xl font-black text-slate-800 tracking-tight group-hover:text-indigo-600 transition-colors">Lista de Clientes</h3>
                <p class="text-slate-500 mt-3 text-sm leading-relaxed font-medium">
                    Visualize todos os clientes cadastrados por todas as consultoras, realize edições e exclusões globais.
                </p>

                <div class="mt-8 flex items-center gap-3">
                    <span class="text-indigo-600 font-black text-[10px] uppercase tracking-[0.2em]">Acessar Lista Completa</span>
                    <i class="fas fa-chevron-right text-[10px] text-indigo-600 group-hover:translate-x-2 transition-transform"></i>
                </div>
            </div>
        </a>

        <div class="border-2 border-dashed border-slate-200 p-10 rounded-[3rem] flex flex-col items-center justify-center text-center opacity-40">
            <div class="w-14 h-14 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 mb-4">
                <i class="fas fa-plus text-xl"></i>
            </div>
            <span class="font-bold text-slate-400">Novo Módulo</span>
        </div>

    </div>
</div>
@endsection