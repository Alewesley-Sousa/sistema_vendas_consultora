@extends('layouts.app')

@section('title', 'Painel Inicial - Glow Cosmetics')

@section('header')
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

{{-- Banner de Rede --}}
<div class="mt-10 relative h-72 rounded-[2.5rem] overflow-hidden group shadow-xl">
    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&q=80&w=1000" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Equipe Glow">
    <div class="absolute inset-0 bg-gradient-to-r from-[#8B2E2E]/90 to-transparent flex flex-col justify-center px-12">
        <span class="bg-[#FF7665] text-white text-[10px] font-bold px-3 py-1 rounded-full w-fit mb-4 uppercase tracking-widest">Minhas indicações</span>
        <h2 class="text-4xl font-serif text-white mb-6">Expansão de<br><span class="font-bold italic">Árvore de Rede</span></h2>
        <a href="/rede/arvore" class="bg-white text-[#2C3E50] px-8 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-[#FFD700] transition-all w-fit flex items-center gap-2 group">
            Visualizar Organização
            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
        </a>
    </div>
</div>

{{-- Div Personalizada com Upgrade de Cargo --}}
<div x-data="gestorUpgrade()" x-init="checarStatus()" class="mt-10 mb-10">
    
    <template x-if="loading">
        <div class="h-32 bg-gray-50 rounded-[2.5rem] animate-pulse flex items-center justify-center border border-dashed border-gray-200">
            <span class="text-gray-400 font-serif italic">Analisando sua evolução de carreira...</span>
        </div>
    </template>

    <template x-if="!loading && erro">
        <div class="bg-red-50 border border-red-200 p-8 rounded-[2.5rem] flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm">
            <div class="flex items-center gap-4 text-red-700">
                <div class="bg-red-100 p-3 rounded-2xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="font-bold text-lg">Houve um imprevisto</p>
                    <p class="text-xs font-mono bg-white/50 p-2 rounded border border-red-200 mt-1" x-text="detalheErro"></p>
                </div>
            </div>
            <button @click="checarStatus()" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl text-xs font-bold uppercase transition-colors shadow-lg shadow-red-200">Recarregar Painel</button>
        </div>
    </template>

    <template x-if="!loading && !erro">
        <div :class="{
                'bg-white border-gray-100': !status.atende_requisitos,
                'bg-gradient-to-br from-[#2C3E50] to-[#1a252f] text-white shadow-[#2C3E50]/30 shadow-2xl': status.atende_requisitos
             }" 
             class="relative overflow-hidden p-8 rounded-[2.5rem] border transition-all duration-700 transform hover:scale-[1.01]">
            
            <div x-show="status.atende_requisitos" class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-20"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div :class="status.atende_requisitos ? 'bg-[#FF7665] rotate-12 scale-110' : 'bg-[#FFF9F9]'" 
                         class="w-20 h-20 rounded-[2rem] flex items-center justify-center transition-all duration-500 shadow-inner">
                        <template x-if="!status.atende_requisitos">
                            <svg class="w-10 h-10 text-[#FF7665]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </template>
                        <template x-if="status.atende_requisitos">
                            <svg class="w-10 h-10 text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </template>
                    </div>

                    <div>
                        <h4 class="text-xl font-serif font-bold" :class="status.atende_requisitos ? 'text-white' : 'text-[#2C3E50]'">
                            <span x-text="status.atende_requisitos ? 'Evolução de Carreira Disponível!' : 'Próximo Passo: Líder Glow'"></span>
                        </h4>
                        <p class="text-sm" :class="status.atende_requisitos ? 'text-gray-300' : 'text-gray-500'">
                            <span x-text="status.mensagem"></span>
                        </p>
                    </div>
                </div>

                <div class="flex flex-col items-end gap-2 w-full md:w-auto">
                    <template x-if="!status.atende_requisitos">
                        <div class="text-right">
                            <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">Progresso Geral</span>
                            <div class="flex items-center gap-3">
                                <div class="w-32 bg-gray-100 h-2 rounded-full overflow-hidden">
                                    <div class="bg-[#FF7665] h-full transition-all duration-1000" :style="`width: ${calcularProgresso()}%`"></div>
                                </div>
                                <span class="font-bold text-[#2C3E50]" x-text="calcularProgresso() + '%'"></span>
                            </div>
                        </div>
                    </template>

                    <template x-if="status.atende_requisitos">
                        <button @click="solicitarUpgrade()" 
                                class="group bg-[#FF7665] text-white px-10 py-5 rounded-2xl font-black uppercase text-xs tracking-[0.2em] shadow-2xl hover:bg-white hover:text-[#FF7665] transition-all duration-300 transform hover:scale-105 active:scale-95 flex items-center gap-3">
                            Tornar-me Líder agora
                            <svg class="w-5 h-5 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </template>
</div>

<x-modal-cadastro-consultora />
@endsection

@push('modals')
    <x-modal.cliente-modal 
        id="clientes"
        title="Área do Cliente"
        subtitle="Gestão de contatos" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    axios.defaults.withCredentials = true;
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (token) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
    }

    function gestorUpgrade() {
        return {
            loading: true,
            erro: false,
            detalheErro: '',
            status: {
                atende_requisitos: false,
                mensagem: '',
                dados: { total_vendas: 0, consultoras_ativas: 0 }
            },
            async checarStatus() {
                this.loading = true;
                this.erro = false;
                this.detalheErro = '';
                
                try {
                    const response = await axios.get('/lider/upgrade');
                    this.status = {
                        atende_requisitos: response.data.atende_requisitos,
                        mensagem: response.data.mensagem,
                        dados: response.data.dados
                    };
                } catch (e) {
                    this.erro = true;
                    this.detalheErro = e.response?.data?.message || `Falha na requisição: ${e.message}`;
                    console.error("DEBUG UPGRADE:", e);
                } finally {
                    this.loading = false;
                }
            },
            calcularProgresso() {
                const pVendas = Math.min((this.status.dados.total_vendas / 5000) * 100, 100);
                const pAtivas = Math.min((this.status.dados.consultoras_ativas / 3) * 100, 100);
                return Math.round((pVendas + pAtivas) / 2);
            },
            async solicitarUpgrade() {
                const result = await Swal.fire({
                    title: 'Confirmar Upgrade?',
                    text: "Sua jornada como Líder Glow começa agora!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#FF7665',
                    confirmButtonText: 'QUERO SER LÍDER!',
                    cancelButtonText: 'Ainda não'
                });

                if (result.isConfirmed) {
                    try {
                        const response = await axios.get('/lider/mudarCargo');
                        
                        if (response.data.status === 'success') {
                            await Swal.fire('Sucesso!', response.data.mensagem, 'success');
                            window.location.reload(); 
                        } else {
                            Swal.fire('Ops!', response.data.mensagem, 'error');
                        }
                    } catch (e) {
                        Swal.fire('Erro!', 'Não foi possível processar seu upgrade agora.', 'error');
                    }
                }
            }
        }
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
@endpush
