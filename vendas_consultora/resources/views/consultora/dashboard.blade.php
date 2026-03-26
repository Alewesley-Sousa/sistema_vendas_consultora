@extends('layouts.app-consultora')

@section('conteudo')
{{-- Iniciando o componente do Alpine --}}
<div class="space-y-8" x-data="dashboardComponent" x-init="fetchData()">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-3xl font-bold text-[#2C3E50]" style="font-family: 'The Seasons', serif;">
                Olá, {{ explode(' ', auth()->user()->nome)[0] }}!
            </h2>
            <div class="flex items-center gap-2 mt-1">
                <span class="h-1 w-1 rounded-full bg-[#FF69B4]"></span>
                <p class="text-gray-500 font-sans tracking-wide uppercase text-[10px] tracking-[0.15em]">Dashboard de Performance</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            {{-- Rota de Cadastro de Cliente aplicada aqui --}}
            <a href="{{ route('cliente.cadastrar') }}" 
               class="flex items-center gap-2 bg-[#2C3E50] hover:bg-[#34495e] text-white px-5 py-2.5 rounded-full shadow-lg transition-all active:scale-95 group no-underline">
                <div class="bg-[#FF69B4] rounded-full h-6 w-6 flex items-center justify-center group-hover:rotate-90 transition-transform duration-300">
                    <i class="fa-solid fa-plus text-[10px]"></i>
                </div>
                <span class="text-xs font-bold uppercase tracking-widest">Novo Cliente</span>
            </a>

            <a href="/suporte" class="group flex items-center gap-2 bg-white border border-gray-100 p-1.5 pr-4 rounded-full shadow-sm hover:border-[#FF69B4]/30 transition-all no-underline">
                <div class="bg-[#FFF5F7] h-8 w-8 rounded-full flex items-center justify-center text-[#FF69B4] group-hover:bg-[#FF69B4] group-hover:text-white transition-all">
                    <i class="fa-solid fa-circle-question text-sm"></i>
                </div>
                <span class="text-[10px] font-bold text-[#2C3E50] uppercase tracking-widest hidden sm:inline">Ajuda</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Card Meta --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden flex flex-col justify-between min-h-[220px]">
            <div class="relative z-10">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[14px] font-bold text-[#FF69B4] uppercase tracking-[0.2em]">Meta do Mês</p>
                        <h3 class="text-3xl font-black text-[#2C3E50] mt-1" x-text="formatCurrency(metaTotal)">R$ 0,00</h3>
                    </div>
                    <div class="bg-[#FFF5F7] p-3 rounded-xl text-[#FF69B4] shadow-sm">
                        <i class="fa-solid fa-chart-line text-lg"></i>
                    </div>
                </div>
            </div>

            <div class="relative z-10 space-y-3">
                <div class="flex justify-between text-[10px] font-bold uppercase tracking-widest">
                    <span class="text-gray-500">Progresso Atual</span>
                    <span class="text-[#FF69B4]" x-text="Math.round(progresso * 100) + '%'">0%</span>
                </div>
                <div class="w-full bg-gray-100 h-3 rounded-full overflow-hidden border border-gray-50">
                    <div class="h-full bg-gradient-to-r from-[#FF69B4] to-[#FFD700] rounded-full transition-all duration-[2000ms] ease-out shadow-sm"
                         :style="`width: ${progresso * 100}%` ">
                    </div>
                </div>
                <p class="text-[10px] text-gray-500 italic">
                    Faltam <span class="font-bold text-[#2C3E50]" x-text="formatCurrency(faltaParaMeta)"></span> para o objetivo.
                </p>
            </div>
        </div>

        {{-- Card Comissão --}}
        <div class="bg-[#2C3E50] rounded-2xl p-6 shadow-xl relative overflow-hidden text-white flex flex-col justify-between min-h-[220px]">
            <div class="relative z-10">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[14px] font-bold text-[#FFD700] uppercase tracking-[0.2em]">Minha Comissão</p>
                        <h3 class="text-3xl font-black text-white mt-1" x-text="formatCurrency(comissaoTotal)">R$ 0,00</h3>
                    </div>
                    <div class="bg-[#FF6F61] p-3 rounded-xl shadow-lg border border-white/10 text-white">
                        <i class="fa-solid fa-wallet text-lg"></i>
                    </div>
                </div>
            </div>

            <div class="relative z-10">
                <p class="text-[10px] text-gray-300 mb-4 uppercase tracking-widest font-medium">Saldo disponível para resgate</p>
                <div class="flex items-center gap-2">
                    <button class="flex-1 bg-white/10 hover:bg-white/20 text-white py-2.5 rounded-xl text-[10px] font-bold uppercase tracking-widest border border-white/5 cursor-pointer">
                        Extrato
                    </button>
                    <button 
                        @click="solicitarSaque()"
                        :disabled="carregandoSaque || comissaoTotal <= 0"
                        :class="(carregandoSaque || comissaoTotal <= 0) ? 'opacity-50 cursor-not-allowed bg-gray-400' : 'bg-[#FFD700] hover:bg-[#ffc800] active:scale-95'"
                        class="flex-1 text-[#2C3E50] py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-md cursor-pointer transition-all flex items-center justify-center gap-2 text-center border-none">
                        
                        <i x-show="carregandoSaque" class="fa-solid fa-spinner animate-spin"></i>
                        <span x-text="carregandoSaque ? 'Processando...' : 'Sacar'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DE CONFIRMAÇÃO --}}
    <template x-teleport="body">
        <div x-show="mostrarModalSaque" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-[#2C3E50]/80 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-cloak>
            
            <div class="bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl transform transition-all border-b-4 border-[#FFD700]"
                 @click.away="mostrarModalSaque = false">
                
                <div class="text-center">
                    <div class="bg-[#FFF5F7] h-16 w-16 rounded-full flex items-center justify-center text-[#FF69B4] mx-auto mb-4">
                        <i class="fa-solid fa-hand-holding-dollar text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#2C3E50] mb-2" style="font-family: 'The Seasons', serif;">Solicitar Resgate</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Você está prestes a solicitar o resgate de sua comissão acumulada de 
                        <span class="font-bold text-[#2C3E50]" x-text="formatCurrency(comissaoTotal)"></span>.
                    </p>
                </div>

                <div class="mt-8 flex flex-col gap-3">
                    <button @click="executarSaque()" 
                            class="w-full bg-[#2C3E50] hover:bg-[#1a252f] text-white font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition-all active:scale-95 shadow-lg border-none cursor-pointer">
                        Confirmar Solicitação
                    </button>
                    <button @click="mostrarModalSaque = false" 
                            class="w-full bg-gray-50 hover:bg-gray-100 text-gray-500 font-bold py-3 rounded-xl uppercase text-[10px] tracking-widest transition-all border-none cursor-pointer">
                        Agora não
                    </button>
                </div>
            </div>
        </div>
    </template>

    {{-- SISTEMA DE TOASTS - REPOSICIONADO PARA O TOPO --}}
    <div class="fixed top-6 left-4 right-4 md:left-auto md:right-8 z-[110] flex flex-col gap-3 pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.show" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="-translate-y-12 opacity-0"
                 x-transition:enter-end="translate-y-0 opacity-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 :class="toast.type === 'success' ? 'bg-[#2C3E50] border-[#FFD700]' : 'bg-red-600 border-red-400'"
                 class="flex items-center gap-4 px-6 py-4 rounded-2xl shadow-2xl border-t-4 text-white min-w-[300px] pointer-events-auto transition-all">
                
                <i class="fa-solid text-lg" :class="toast.type === 'success' ? 'fa-circle-check text-[#FFD700]' : 'fa-circle-exclamation'"></i>
                
                <div class="flex flex-col">
                    <span class="text-[8px] uppercase tracking-widest font-black opacity-60" 
                          x-text="toast.type === 'success' ? 'Sucesso' : 'Atenção'"></span>
                    <span class="text-xs font-bold leading-tight" x-text="toast.message"></span>
                </div>

                <button @click="toast.show = false" class="ml-auto opacity-50 hover:opacity-100 transition-opacity">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>
        </template>
    </div>


</div> {{-- FIM DO x-data dashboardComponent --}}
@endsection
