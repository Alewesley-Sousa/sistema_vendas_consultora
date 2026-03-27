@extends('layouts.app')

@section('conteudo')
<div x-data="{ 
        showPassword: false, 
        isSubmitting: false,
        errors: [], 
        shown: false 
     }" 
     x-init="setTimeout(() => shown = true, 100)"
     class="fixed inset-0 z-50 bg-white sm:relative sm:inset-auto sm:z-0 sm:w-full sm:max-w-4xl sm:flex sm:bg-transparent overflow-hidden">
    
<div class="absolute top-[-7rem] right-[-7rem] z-50 w-60 h-60 rounded-full
bg-gradient-to-br from-[#FF69B4] to-[#2C3E50] shadow-lg flex items-center
justify-center border-2 border-white/50 sm:hidden">
    <div class="w-20 h-20 rounded-full shadow-lg"></div>
</div>


    <div class="hidden sm:block absolute -inset-2 bg-gradient-to-r from-[#2C3E50] to-[#FF69B4] rounded-3xl blur-2xl opacity-15 animate-pulse"></div>

    <div x-show="shown"
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 -translate-x-12"
         x-transition:enter-end="opacity-100 translate-x-0"
         class="relative z-10 flex flex-col justify-center min-h-full px-6 py-12 w-full sm:w-1/2 bg-white sm:rounded-l-2xl sm:shadow-sm sm:border sm:border-r-0 border-gray-100 overflow-hidden">
        
        <div class="mb-10 sm:hidden flex justify-center" x-show="shown" x-transition:enter="transition delay-300 duration-500 opacity-0" x-transition:enter-end="opacity-100">
            <img src="{{ asset('images/DivasBusiness_logo2.svg') }}" alt="Logo" class="h-20 w-auto rounded-md">
        </div>

        <div class="text-center sm:text-left">
            <h2 class="text-2xl font-bold tracking-tight text-[#2C3E50]" style="font-family: 'Rotis Sans Serif', sans-serif;">Acessar Conta</h2>
            <p class="mt-2 text-sm text-gray-500">Informe suas credenciais para entrar.</p>
        </div>

        <template x-if="errors.length > 0">
            <div class="mt-4 p-3 rounded-lg bg-red-50 border border-red-200">
                <ul class="list-disc list-inside">
                    <template x-for="error in errors">
                        <li class="text-xs text-red-600 font-medium" x-text="error"></li>
                    </template>
                </ul>
            </div>
        </template>

        <form id='loginForm' class="mt-8 space-y-5">
            @csrf
            <div class="space-y-4" x-show="shown" x-transition:enter="transition delay-400 duration-500 opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div>
                    <label class="block text-sm font-semibold text-[#2C3E50]">E-mail</label>
                    <input type="email" id="email" name="email" required 
                        class="mt-1.5 block w-full rounded-xl border-0 py-3 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-[#FF69B4] text-base outline-none transition-all hover:ring-[#FF69B4]/50 bg-white">
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-semibold text-[#2C3E50]">Senha</label>
                        <a href="#" class="text-xs font-bold text-[#FF6F61] hover:underline">Esqueceu?</a>
                    </div>
                    <div class="mt-1.5 relative">
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required 
                            class="block w-full rounded-xl border-0 py-3 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-[#FF69B4] text-base outline-none transition-all hover:ring-[#FF69B4]/50 bg-white">
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#2C3E50] transition-colors">
                            <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg x-show="showPassword" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.025 10.025 0 014.132-5.411m0 0L21 21" /></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex items-center" x-show="shown" x-transition:enter="transition delay-500 duration-500 opacity-0" x-transition:enter-end="opacity-100">
                <input id="remember" name="remember" type="checkbox" class="h-5 w-5 rounded border-gray-300 text-[#FF69B4] focus:ring-[#FF69B4] cursor-pointer">
                <label for="remember" class="ml-3 text-sm font-medium text-gray-600 cursor-pointer">Permanecer conectada(o)</label>
            </div>

            <button type="submit" id="btnEntrar" :disabled="isSubmitting"
                x-show="shown" x-transition:enter="transition delay-600 duration-600 opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="w-full flex justify-center items-center rounded-xl bg-[#2C3E50] px-4 py-4 text-sm font-bold text-white hover:bg-[#1a252f] active:scale-[0.98] transition-all shadow-lg disabled:opacity-70 group">
                
                <span x-text="isSubmitting ? 'AUTENTICANDO...' : 'ACESSAR PAINEL'"></span>
            </button>
        </form>
    </div>

    <div class="sm:hidden absolute inset-x-0 bottom-0 z-20 pointer-events-none">
        <svg class="w-full h-[120px] mb-[-180px] opacity-60" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="#FF69B4" d="M0,160L80,176C160,192,320,224,480,213.3C640,203,800,149,960,144C1120,139,1280,181,1360,202.7L1440,224L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
        </svg>
        <svg class="w-full h-[160px]" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="#2C3E50" d="M0,224L80,213.3C160,203,320,181,480,181.3C640,181,800,203,960,213.3C1120,224,1280,224,1360,208L1440,192L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
        </svg>
    </div>

    <div x-show="shown"
         x-transition:enter="transition ease-out duration-700 delay-100"
         x-transition:enter-start="opacity-0 translate-x-12"
         x-transition:enter-end="opacity-100 translate-x-0"
         class="hidden sm:flex sm:w-1/2 bg-[#2C3E50] rounded-r-2xl flex-col justify-between p-12 text-white relative overflow-hidden">
        
        <div class="absolute top-0 right-0 -mr-20 -mt-20 h-80 w-80 rounded-full bg-[#FF69B4] opacity-10 blur-3xl animate-pulse"></div>
        
        <div class="relative z-10">
            <img src="{{ asset('images/DivasBusiness_logo2.svg') }}" alt="Logo" class="h-16 w-auto mix-blend-screen brightness-125 contrast-150 rounded-md">
        </div>

        <div class="relative z-10">
            <h3 class="text-4xl font-bold leading-tight" style="font-family: 'The Seasons', serif;">Seja bem-vinda(o)</h3>
            <div class="mt-6 space-y-4">
                <p class="text-lg text-blue-100/90 italic leading-relaxed">
                    "Minha missão na vida não é apenas sobreviver, mas prosperar..."
                </p>
                <p class="font-bold text-[#FF69B4] tracking-widest uppercase text-xs">— Maya Angelou</p>
            </div>
        </div>
    </div>
</div>
@endsection
