@extends('layouts.app')

@section('conteudo')
<style>
    /* Tipografia da Marca */
    .font-brand-header { font-family: 'The Seasons', serif; }
    .font-brand-body { font-family: 'Inter', 'Rotis Sans Serif', sans-serif; }
    
    /* Animação da Aura */
    @keyframes aura-pulse {
        0% { box-shadow: 0 0 50px -10px rgba(255, 215, 0, 0.2), 0 20px 50px -20px rgba(44, 62, 80, 0.1); }
        50% { box-shadow: 0 0 80px 5px rgba(255, 215, 0, 0.3), 0 20px 50px -20px rgba(44, 62, 80, 0.1); }
        100% { box-shadow: 0 0 50px -10px rgba(255, 215, 0, 0.2), 0 20px 50px -20px rgba(44, 62, 80, 0.1); }
    }

    @keyframes logo-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    .animated-golden-aura { 
        animation: aura-pulse 6s ease-in-out infinite;
        border: 1px solid rgba(255, 215, 0, 0.1);
    }

    .logo-container {
        animation: logo-float 4s ease-in-out infinite;
    }

    .input-premium {
        transition: all 0.3s ease;
    }
    .input-premium:focus {
        background-color: #fff !important;
        border-color: #FFD700 !important;
        box-shadow: 0 5px 15px rgba(255, 215, 0, 0.08);
    }
</style>

<div class="w-full max-w-3xl font-brand-body relative p-4">
    
    <div class="w-full flex flex-col md:flex-row gap-0 animated-golden-aura rounded-3xl md:rounded-[1.5rem] overflow-hidden bg-white relative z-10">
        
        <div class="w-full md:w-3/5 p-6 md:p-10 lg:p-12 relative bg-white">
            <header class="mb-6 md:mb-8">
                <div class="flex items-center gap-2 mb-2">
                    <span class="h-[1px] w-6 bg-[#FFD700]"></span>
                    <p class="text-[#FF69B4] font-black uppercase tracking-[0.4em] text-[7px] opacity-90">Divas Business</p>
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-[#2C3E50] font-brand-header tracking-tight">Bem-vinda</h1>
            </header>

            <form id="loginForm" class="space-y-4 md:max-w-[280px]">
                <div id="error-message" class="hidden p-3 bg-red-50 border-l-2 border-[#FF6F61] text-[#FF6F61] rounded-lg text-[9px] font-bold uppercase tracking-wider">
                    <ul id="error-list" class="list-none"></ul>
                </div>

                <div class="space-y-3">
                    <div class="group">
                        <label class="block text-[8px] font-black uppercase tracking-[0.2em] text-[#2C3E50]/40 mb-1.5 ml-1 italic">E-mail de Acesso</label>
                        <input id="email" type="email" required autofocus
                              class="input-premium w-full bg-[#FFF5F7] border border-transparent rounded-lg px-4 py-2.5 text-[#2C3E50] font-medium outline-none text-[11px]"
                              placeholder="seu@acesso.com">
                    </div>

                    <div class="group">
                        <label class="block text-[8px] font-black uppercase tracking-[0.2em] text-[#2C3E50]/40 mb-1.5 ml-1 italic">Senha</label>
                        <input id="password" type="password" required
                              class="input-premium w-full bg-[#FFF5F7] border border-transparent rounded-lg px-4 py-2.5 text-[#2C3E50] font-medium outline-none text-[11px]"
                              placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between text-[8px] font-bold uppercase tracking-widest px-1 text-[#2C3E50]/50">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input id="remember" type="checkbox" class="h-3 w-3 rounded-full border-[#FFD700]/50 text-[#FF69B4] focus:ring-0 appearance-none border-2 checked:bg-[#FF69B4] transition-all">
                        <span>Lembrar</span>
                    </label>
                    <a href="{{ route('senha-formulario') }}" class="text-[#FF6F61] hover:opacity-70 transition-opacity">Esqueceu?</a>
                </div>

                <div class="pt-2">
                    <button type="submit" id="btnEntrar"
                            class="w-full bg-[#2C3E50] hover:bg-[#1a252f] text-white font-bold py-3 rounded-lg shadow-md shadow-[#2C3E50]/10 transition-all active:scale-[0.98] uppercase tracking-[0.4em] text-[9px] flex items-center justify-center gap-2 cursor-pointer">
                        <span>ACESSAR</span>
                        <i class="fa-solid fa-arrow-right-long text-[8px] opacity-40"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="hidden md:flex w-2/5 bg-[#2C3E50] p-8 lg:p-10 flex-col justify-between relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full blur-[50px]"></div>
            
            <div class="relative z-10 flex-1 flex flex-col justify-center">
                <div class="logo-container inline-flex items-center justify-center w-12 h-12 rounded-xl bg-white shadow-lg mb-5 overflow-hidden self-start">
                    <img src="{{ asset('images/DivasBusiness_logo2.svg') }}" 
                         alt="Divas Business Logo" 
                         class="w-full h-full object-cover"> 
                </div>
                
                <h2 class="text-xl lg:text-2xl font-brand-header leading-tight mb-3 text-white tracking-wide">
                    Seja bem-vinda ao<br>
                    <span class="text-[#FFD700]">Divas Business.</span>
                </h2>
                <p class="text-white/40 text-[9px] leading-relaxed font-light tracking-wide italic max-w-[160px]">
                    Alta performance e resultados para mulheres reais.
                </p>
            </div>

            <div class="relative z-10 pt-4 border-t border-white/5 text-white/40">
                <div class="flex items-center gap-2">
                    <div class="w-1 h-1 rounded-full bg-[#FFD700] animate-pulse"></div>
                    <span class="text-[7px] uppercase tracking-[0.2em] font-black">Área Exclusiva</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
