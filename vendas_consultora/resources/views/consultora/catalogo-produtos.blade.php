@extends('layouts.app')

@section('conteudo')
<div class="max-w-7xl mx-auto px-4 py-10 min-h-screen bg-slate-50/30">
    <div class="mb-12 flex flex-col md:flex-row gap-6 items-center justify-between">
        <div class="relative w-full md:w-[500px] group">
            <div class="absolute inset-0 bg-indigo-500/10 blur-2xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative flex items-center">
                <i class="fas fa-search absolute left-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                <input type="text" id="filtro-pesquisa" oninput="window.appCatalogo.filtrar(this.value)" 
                       placeholder="Pesquisar catálogo..." 
                       class="w-full pl-14 pr-6 py-5 bg-white rounded-[2rem] border-none shadow-[0_10px_40px_rgba(0,0,0,0.04)] focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all text-slate-700 font-medium">
            </div>
        </div>
        
        <div class="hidden md:flex gap-3">
            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 shadow-sm border border-slate-100">
                <i class="fas fa-th-large"></i>
            </div>
            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 shadow-sm border border-slate-100">
                <i class="fas fa-filter"></i>
            </div>
        </div>
    </div>

    <div id="app-catalogo" class="transition-all duration-500">
        </div>

    <div id="resumo-venda" class="hidden fixed bottom-6 right-4 left-4 md:right-10 md:left-auto md:w-[450px] bg-white/80 backdrop-blur-2xl rounded-[3rem] shadow-[0_40px_100px_rgba(0,0,0,0.25)] border border-white/50 p-8 z-50">
        <div class="flex items-center justify-between mb-8">
            <div>
                <span class="text-indigo-600 font-black text-[10px] uppercase tracking-[0.2em] block mb-1">Seu Carrinho</span>
                <h4 class="font-black text-slate-900 text-2xl tracking-tight">Resumo da Venda</h4>
            </div>
            <button onclick="window.appCatalogo.limparCarrinho()" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm">
                <i class="fas fa-trash-alt text-sm"></i>
            </button>
        </div>
        
        <div id="lista-itens" class="max-h-64 overflow-y-auto mb-8 space-y-3 pr-2 custom-scrollbar scroll-smooth">
            </div>

        <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white">
            <div class="flex items-center justify-between mb-6">
                <span class="text-slate-400 font-bold text-xs uppercase tracking-widest">Valor Total</span>
                <span id="total-venda" class="text-3xl font-black text-indigo-400 font-mono">R$ 0,00</span>
            </div>

            <button onclick="window.appCatalogo.finalizar()" 
                    class="w-full py-5 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl shadow-xl shadow-indigo-900/40 transition-all active:scale-95 flex items-center justify-center gap-3 uppercase text-sm tracking-[0.15em]">
                Finalizar Pedido <i class="fas fa-arrow-right text-xs"></i>
            </button>
        </div>
    </div>
</div>

<style>
    /* Scrollbar Personalizada para o Carrinho */
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #6366f1; }
</style>
@endsection