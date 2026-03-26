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

<div class="w-full max-w-4xl font-brand-body relative p-4">
    
    <div class="w-full flex flex-col md:flex-row gap-0 animated-golden-aura rounded-3xl md:rounded-[1.5rem] overflow-hidden bg-white relative z-10 min-h-[580px]">
        
        <div class="w-full md:w-3/5 p-8 md:p-12 lg:p-20 flex flex-col justify-center bg-white">
            
            <div class="w-full max-w-[340px] mx-auto">
                <header class="mb-10 text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#FFF5F7] border border-[#FF69B4]/10 mb-4">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#FFD700]"></span>
                        <p class="text-[#FF69B4] font-extrabold uppercase tracking-[0.3em] text-[7px]">Divas Business</p>
                    </div>

                    <h1 class="text-4xl font-bold text-[#2C3E50] font-brand-header tracking-tight mb-3">Bem-vinda</h1>
                    <p class="text-[#2C3E50]/40 text-[11px] font-medium tracking-wide leading-relaxed">Acesse sua conta para gerenciar seu ecossistema de alta performance.</p>
                </header>

                <form id="loginForm" class="space-y-5">
                    <div id="error-message" class="hidden p-3 bg-red-50 border-l-2 border-[#FF6F61] text-[#FF6F61] rounded-lg text-[9px] font-bold uppercase tracking-wider">
                        <ul id="error-list" class="list-none"></ul>
                    </div>

                    <div class="space-y-4">
                        <div class="group">
                            <label class="block text-[9px] font-black uppercase tracking-[0.2em] text-[#2C3E50]/40 mb-2 ml-1 italic">E-mail de Acesso</label>
                            <input id="email" type="email" name="email" required autofocus
                                  class="input-premium w-full bg-[#FFF5F7] border border-transparent rounded-xl px-5 py-3.5 text-[#2C3E50] font-medium outline-none text-[12px]"
                                  placeholder="seu@acesso.com">
                        </div>

                        <div class="group">
                            <label class="block text-[9px] font-black uppercase tracking-[0.2em] text-[#2C3E50]/40 mb-2 ml-1 italic">Senha</label>
                            <input id="password" type="password" name="password" required
                                  class="input-premium w-full bg-[#FFF5F7] border border-transparent rounded-xl px-5 py-3.5 text-[#2C3E50] font-medium outline-none text-[12px]"
                                  placeholder="••••••••">
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-[9px] font-bold uppercase tracking-widest px-1 text-[#2C3E50]/50">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input id="remember" type="checkbox" class="h-3.5 w-3.5 rounded-full border-[#FFD700]/50 text-[#FF69B4] focus:ring-0 appearance-none border-2 checked:bg-[#FF69B4] transition-all cursor-pointer">
                            <span class="group-hover:text-[#2C3E50] transition-colors">Lembrar</span>
                        </label>
                        <a href="{{ route('senha-formulario') }}" class="text-[#FF6F61] hover:opacity-70 transition-opacity">Esqueceu a senha?</a>
                    </div>

                    <div class="pt-4">
                        <button type="submit" id="btnEntrar"
                                class="w-full bg-[#2C3E50] hover:bg-[#1a252f] text-white font-bold py-4 rounded-xl shadow-lg shadow-[#2C3E50]/10 transition-all active:scale-[0.98] uppercase tracking-[0.4em] text-[10px] flex items-center justify-center gap-3 cursor-pointer">
                            <span>ENTRAR NO SISTEMA</span>
                            <i class="fa-solid fa-arrow-right-long text-[9px] opacity-40"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="hidden md:flex w-2/5 bg-[#2C3E50] p-10 lg:p-12 flex-col justify-between relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-64 h-64 bg-white/5 rounded-full blur-[60px]"></div>
            
            <div class="relative z-10 flex-1 flex flex-col justify-center items-start">
                <div class="logo-container inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-white shadow-xl mb-6 overflow-hidden">
                    <img src="{{ asset('images/DivasBusiness_logo2.svg') }}" 
                         alt="Divas Business Logo" 
                         class="w-full h-full object-cover"> 
                </div>
                
                <h2 class="text-2xl lg:text-3xl font-brand-header leading-tight mb-4 text-white tracking-wide">
                    Seja Bem-Vinda ao<br>
                    <span class="text-[#FFD700]">Divas Business.</span>
                </h2>
                <p class="text-white/40 text-[10px] leading-relaxed font-light tracking-wide italic max-w-[180px]">
                    Resultados exponenciais para mulheres líderes.
                </p>
            </div>

            <div class="relative z-10 pt-6 border-t border-white/5 text-white/40">
                <div class="flex items-center gap-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-[#FFD700] animate-pulse"></div>
                    <span class="text-[8px] uppercase tracking-[0.3em] font-black italic">Área Restrita</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection