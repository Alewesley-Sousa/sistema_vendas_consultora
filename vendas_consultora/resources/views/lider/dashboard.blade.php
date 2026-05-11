@extends('layouts.app')

@section('title', 'Painel Inicial - Glow Cosmetics')

@section('header')
<style>
    /* Suporte para Glassmorphism */
    .backdrop-blur-md {
        -webkit-backdrop-filter: blur(12px);
        backdrop-filter: blur(12px);
    }
</style>

<div class="flex flex-col md:flex-row md:items-center justify-between gap-6" x-data>
    <div>
        <h1 class="text-4xl font-serif font-medium text-[#2C3E50]">
            Bem-vinda de volta, <span class="text-[#E67E73] font-bold">{{ explode(' ', Auth::user()->nome)[0] }}.</span>
        </h1>
    </div>

    <div class="flex gap-4">
        <button @click="$dispatch('abrir-modal-cadastro')" 
                class="flex items-center gap-3 bg-[#FF7665] text-white px-6 py-4 rounded-2xl shadow-lg shadow-[#FF7665]/30 hover:bg-[#ff6450] transition-all font-bold uppercase text-xs tracking-wider focus:outline-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            Cadastrar Consultora
        </button>

        <a href="/catalogo" class="flex items-center gap-3 bg-white text-[#2C3E50] border border-gray-200 px-6 py-4 rounded-2xl shadow-sm hover:bg-gray-50 transition-all font-bold uppercase text-xs tracking-wider">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            Novo Pedido
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-4">
    {{-- Card de Comissão --}}
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 relative overflow-hidden group">
        <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:scale-110 transition-transform">
            <svg class="w-24 h-24 text-[#E67E73]" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"></path></svg>
        </div>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-4">Financeiro Disponível</p>
        <h3 class="text-gray-600 text-3xl font-light">
            Saldo de Comissão: <span id="saldo-comissao" class="text-[#E67E73] font-bold">R$ 0,00</span>
        </h3>
        <div class="mt-8">
            <a href="/comissao/historico" class="text-[#E67E73] font-bold text-sm underline underline-offset-4 hover:text-[#2C3E50] transition-colors italic">Ver Histórico</a>
        </div>
    </div>

    {{-- Card de Metas --}}
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 relative">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-2">Produtividade Mensal</p>
                <h3 class="text-gray-600 text-3xl font-light">
                    Meta Mensal: <span id="valor-meta" class="text-[#2C3E50] font-bold">R$ 0,00</span>
                </h3>
            </div>
            <span id="porcentagem-meta" class="bg-[#FFF9E5] text-[#D4AF37] px-4 py-2 rounded-xl font-bold text-lg">0%</span>
        </div>

        <div class="mt-8">
            <div class="flex justify-between text-xs font-bold mb-2 uppercase tracking-tighter">
                <span id="meta-atingida" class="text-gray-400 font-serif italic">R$ 0,00 atingidos</span>
                <span id="meta-restante" class="text-gray-400 font-serif italic">Carregando...</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden">
                <div id="barra-meta" class="bg-gradient-to-r from-[#FF7665] to-[#ffb3a9] h-full rounded-full transition-all duration-1000" style="width: 0%"></div>
            </div>
            <p class="text-[11px] text-gray-400 mt-4 italic">Dados atualizados em tempo real.</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">
    {{-- Banner de Rede (Esquerda) --}}
    <div class="relative h-72 rounded-[2.5rem] overflow-hidden group shadow-xl">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=1000" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Equipe Glow">
        <div class="absolute inset-0 bg-gradient-to-r from-[#8B2E2E]/90 to-transparent flex flex-col justify-center px-12">
            <span class="bg-[#FF7665] text-white text-[10px] font-bold px-3 py-1 rounded-full w-fit mb-4 uppercase tracking-widest">Minhas indicações</span>
            <h2 class="text-3xl font-serif text-white mb-6">Expansão de<br><span class="font-bold italic">Árvore de Rede</span></h2>
            <a href="/rede/arvore" class="bg-white text-[#2C3E50] px-8 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-[#FFD700] transition-all w-fit flex items-center gap-2 group">
                Organização
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
        </div>
    </div>

    {{-- Banner de Pedidos da Equipe (Direita) --}}
    <div class="relative h-72 rounded-[2.5rem] overflow-hidden group shadow-xl border border-white/20">
        <img src="https://images.unsplash.com/photo-1556742044-3c52d6e88c62?auto=format&fit=crop&q=80&w=1000" 
             class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" 
             alt="Pedidos Equipe">
        
        <div class="absolute inset-0 bg-gradient-to-l from-[#2C3E50]/80 via-[#2C3E50]/40 to-transparent"></div>

        <div class="absolute inset-0 flex flex-col justify-center items-end px-12 text-right">
            <div class="backdrop-blur-md bg-white/10 p-6 rounded-[2rem] border border-white/20 shadow-2xl transform group-hover:-translate-y-2 transition-transform duration-500">
                
                <div class="flex items-center justify-end gap-3 mb-3">
                    <span class="text-white text-[9px] font-black uppercase tracking-[0.3em]">Monitoramento</span>
                    <div class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#FF7665] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#FF7665]"></span>
                    </div>
                </div>

                <h2 class="text-3xl font-serif text-white mb-2">Pedidos da <span class="font-bold italic text-[#FF7665]">Equipe</span></h2>
                <p class="text-gray-200 text-[11px] mb-4 font-light max-w-[200px] ml-auto leading-tight">
                    Acompanhe em tempo real as vendas e o desempenho do seu time.
                </p>

                <a href="/pedidos/equipe" class="inline-flex items-center gap-3 bg-[#FF7665] text-white px-6 py-3 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-[#ff6450] transition-all group/btn">
                    <svg class="w-4 h-4 text-white group-hover/btn:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Ver Pedidos
                </a>
            </div>
        </div>
    </div>
</div>

<x-modal-cadastro-consultora />

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    axios.defaults.withCredentials = true;
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (token) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const formatMoney = (v) => new Intl.NumberFormat('pt-BR', {style: 'currency', currency: 'BRL'}).format(v || 0);

        axios.get('/api/comissao').then(r => {
            if (r.data.status === 'sucesso') document.getElementById('saldo-comissao').innerText = formatMoney(r.data.data);
        }).catch(err => console.error("Erro Comissão:", err));

        Promise.all([
            axios.get('/api/meta').catch(() => ({data: {data: 0}})),
            axios.get('/api/meta/progresso').catch(() => ({data: {data: 0}}))
        ]).then(([resMeta, resProgresso]) => {
            const valorTotal = parseFloat(resMeta.data.data) || 0;
            const percentual = parseFloat(resProgresso.data.data) || 0;
            const valorAtingido = (valorTotal * percentual) / 100;
            
            document.getElementById('valor-meta').innerText = formatMoney(valorTotal);
            document.getElementById('porcentagem-meta').innerText = Math.round(percentual) + '%';
            document.getElementById('meta-atingida').innerText = formatMoney(valorAtingido) + ' atingidos';
            
            const barra = document.getElementById('barra-meta');
            if (barra) setTimeout(() => barra.style.width = (percentual > 100 ? 100 : percentual) + '%', 200);
        });
    });
</script>
@endsection
