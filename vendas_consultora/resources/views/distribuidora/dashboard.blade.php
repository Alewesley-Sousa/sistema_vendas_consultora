@extends('layouts.appAdmin')

@section('header', 'Painel de Controle')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-green-500/10 text-green-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <span class="text-[10px] font-bold text-green-500 bg-green-50 px-2 py-1 rounded-lg">+12%</span>
        </div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Vendas (Mês)</p>
        <h3 class="text-2xl font-black text-slate-800">R$ 8.420,00</h3>
    </div>

    <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-blue-500/10 text-blue-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            </div>
            <span class="text-[10px] font-bold text-blue-500 bg-blue-50 px-2 py-1 rounded-lg">8 Novos</span>
        </div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pedidos Hoje</p>
        <h3 class="text-2xl font-black text-slate-800">24</h3>
    </div>

    <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-purple-500/10 text-purple-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
        </div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Consultoras Ativas</p>
        <h3 class="text-2xl font-black text-slate-800">142</h3>
    </div>

    <div class="bg-white p-6 rounded-[2.5rem] border border-red-100 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 bg-red-500/10 text-red-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
        </div>
        <p class="text-xs font-bold text-red-400 uppercase tracking-widest">Estoque Crítico</p>
        <h3 class="text-2xl font-black text-slate-800">5 Itens</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <livewire:admin.solicitacoes-table />

    <div class="bg-[#1E293B] rounded-[2.5rem] p-8 text-white shadow-xl relative overflow-hidden flex flex-col justify-between">
        <div class="relative z-10">
            <h3 class="text-xl font-bold mb-1">Ações Rápidas</h3>
            <p class="text-slate-400 text-[10px] mb-8 font-bold uppercase tracking-widest">Atalhos Administrativos</p>
            
            <div class="space-y-3">
                <button class="w-full flex items-center justify-between p-4 bg-white/5 hover:bg-white/10 rounded-2xl transition-all group border border-white/5">
                    <span class="text-xs font-bold tracking-wide">Novo Produto</span>
                    <svg class="w-4 h-4 text-yellow-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                </button>
                
                <button class="w-full flex items-center justify-between p-4 bg-white/5 hover:bg-white/10 rounded-2xl transition-all group border border-white/5">
                    <span class="text-xs font-bold tracking-wide">Criar Promoção</span>
                    <svg class="w-4 h-4 text-orange-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                </button>

                <button class="w-full flex items-center justify-between p-4 bg-white/5 hover:bg-white/10 rounded-2xl transition-all group border border-white/5">
                    <span class="text-xs font-bold tracking-wide">Backup do Banco</span>
                    <svg class="w-4 h-4 text-blue-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>
                </button>
            </div>
        </div>
        
        <div class="mt-8 relative z-10">
            <p class="text-[10px] text-slate-500 font-bold mb-2 uppercase">Status do Servidor</p>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="text-[10px] font-bold text-slate-300">Sincronizado</span>
            </div>
        </div>

        <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-yellow-400/10 rounded-full blur-3xl"></div>
    </div>
</div>
@endsection
