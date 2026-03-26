@extends('layouts.app-consultora')

@section('conteudo')
{{-- Ajustei o x-data para o nome do componente definido no seu initDashboardConsultora --}}
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
            <a href="/clientes/cadastrar" class="flex items-center gap-2 bg-[#2C3E50] hover:bg-[#34495e] text-white px-5 py-2.5 rounded-full shadow-lg transition-all active:scale-95 group no-underline">
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
            <div class="absolute -right-4 -bottom-4 opacity-5 text-8xl transform -rotate-12 pointer-events-none">
                <i class="fa-solid fa-gem text-[#2C3E50]"></i>
            </div>
        </div>

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
                    <button class="flex-1 bg-[#FFD700] hover:bg-[#ffc800] text-[#2C3E50] py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-md cursor-pointer">
                        Sacar
                    </button>
                </div>
            </div>
            <div class="absolute -right-6 -bottom-6 opacity-10 text-7xl transform -rotate-12 pointer-events-none">
                <i class="fa-solid fa-sack-dollar"></i>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
    @vite(['resources/js/app.js'])
@endpush