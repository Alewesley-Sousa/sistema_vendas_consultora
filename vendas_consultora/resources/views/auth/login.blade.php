@extends('layouts.app-modern')

@section('title', 'Login')

@section('content')

<div
    x-data="loginForm"
    x-init="
        animateCard($refs.card);
        animateBrand($refs.brand);
        animateForm($refs.form);
        animateGlow();
        animateInputs();
        animateAurora();
    "
    class="relative min-h-screen overflow-hidden bg-[#0F1722]">

    <!-- Aurora fixa no fundo -->
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden">

        <div
            x-ref="aurora1"
            class="aurora absolute -top-24 left-[-10%] h-[34rem] w-[34rem] rounded-full blur-[120px]"
            style="background: radial-gradient(circle, rgba(255,20,147,.55) 0%, rgba(255,20,147,0) 70%);">
        </div>

        <div
            x-ref="aurora2"
            class="aurora absolute top-[15%] right-[-10%] h-[38rem] w-[38rem] rounded-full blur-[130px]"
            style="background: radial-gradient(circle, rgba(255,111,97,.45) 0%, rgba(255,111,97,0) 70%);">
        </div>

        <div
            x-ref="aurora3"
            class="aurora absolute bottom-[-18%] left-[25%] h-[28rem] w-[28rem] rounded-full blur-[110px]"
            style="background: radial-gradient(circle, rgba(255,215,0,.22) 0%, rgba(255,215,0,0) 70%);">
        </div>

        <div
            x-ref="aurora4"
            class="aurora absolute bottom-0 right-[10%] h-[24rem] w-[24rem] rounded-full blur-[100px]"
            style="background: radial-gradient(circle, rgba(44,62,80,.45) 0%, rgba(44,62,80,0) 70%);">
        </div>

    </div>

    <!-- Conteúdo por cima -->
    <div class="relative z-10 flex min-h-screen items-center justify-center p-5">

        <div
            x-ref="card"
            class="grid w-full max-w-5xl overflow-hidden rounded-3xl bg-white/78 shadow-[0_25px_60px_rgba(44,62,80,.35)] backdrop-blur-2xl md:grid-cols-2 border border-white/20">

            <!-- Branding -->
            <div
                x-ref="brand"
                class="relative hidden overflow-hidden bg-[#2C3E50]/95 md:flex flex-col justify-center items-center p-16 text-white">

                <div class="login-glow absolute -top-24 -right-24 h-56 w-56 rounded-full bg-[#FF1493]/20 blur-3xl"></div>
                <div class="login-glow absolute -bottom-20 -left-20 h-44 w-44 rounded-full bg-[#FF6F61]/20 blur-3xl"></div>
                <div class="login-glow absolute top-1/2 left-1/2 h-32 w-32 -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#FFD700]/10 blur-3xl"></div>

                <div class="relative z-10 text-center">
                    <div class="brand-item mb-8">
                        <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-3xl bg-gradient-to-br from-[#FF1493] to-[#FF6F61] shadow-lg">
                            <i class="fa-solid fa-bag-shopping text-4xl text-white"></i>
                        </div>
                    </div>

                    <div class="brand-item mb-4 inline-flex items-center gap-2 rounded-full border border-[#FFD700]/30 bg-[#FFD700]/10 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-[#FFD700]">
                        <div class="h-2 w-2 rounded-full bg-[#FFD700]"></div>
                        Navy Bold
                    </div>

                    <h1 class="brand-item mb-4 text-4xl font-bold tracking-wide">
                        Sistema de Vendas
                    </h1>

                    <p class="brand-item mb-12 text-white/80 leading-relaxed">
                        Gestão elegante, estratégica e focada em crescimento.
                    </p>
                </div>
            </div>

            <!-- Form -->
            <div
                x-ref="form"
                class="flex flex-col justify-center bg-[#FFF5F7]/90 backdrop-blur-md p-10 md:p-16">

                <div class="mb-10">
                    <div class="mb-4 h-1 w-20 rounded-full bg-gradient-to-r from-[#FF1493] to-[#FFD700]"></div>

                    <h2 class="mb-2 text-3xl font-bold text-[#2C3E50]">
                        Bem-vindo!
                    </h2>

                    <p class="text-[#2C3E50]/60">
                        Entre com suas credenciais
                    </p>
                </div>

                <form
                    @submit.prevent="submit"
                    class="space-y-6">

                    @csrf

                    <div class="login-input">
                        <label class="mb-3 block text-sm font-semibold uppercase tracking-wider text-[#2C3E50]">
                            E-mail
                        </label>

                        <input
                            x-model="email"
                            type="email"
                            required
                            placeholder="seu@email.com"
                            class="w-full rounded-2xl border-2 border-transparent bg-white p-4 text-[#2C3E50] shadow-sm transition focus:border-[#FF1493] focus:outline-none focus:ring-4 focus:ring-[#FF1493]/10">
                    </div>

                    <div class="login-input">
                        <label class="mb-3 block text-sm font-semibold uppercase tracking-wider text-[#2C3E50]">
                            Senha
                        </label>

                        <div class="relative">
                            <input
                                x-model="password"
                                :type="showPassword ? 'text' : 'password'"
                                required
                                placeholder="Digite sua senha"
                                class="w-full rounded-2xl border-2 border-transparent bg-white p-4 pr-14 text-[#2C3E50] shadow-sm transition focus:border-[#FF1493] focus:outline-none focus:ring-4 focus:ring-[#FF1493]/10">

                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-[#FF1493] transition hover:scale-110">
                                <i :class="showPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <div
                        x-show="errorMessage"
                        x-ref="errorBox"
                        x-cloak
                        class="overflow-hidden rounded-2xl border border-[#FF6F61]/30 bg-[#FF6F61]/10 px-4 py-3 text-sm text-[#C0392B]">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-exclamation text-[#FF6F61]"></i>
                            <span x-text="errorMessage"></span>
                        </div>
                    </div>

                    <button
                        x-ref="button"
                        @mouseenter="!loading && animateButtonHover($refs.button)"
                        @mouseleave="!loading && animateButtonLeave($refs.button)"
                        type="submit"
                        :disabled="loading"
                        class="w-full rounded-2xl bg-gradient-to-r from-[#FF1493] via-[#FF6F61] to-[#FFD700] p-4 font-bold text-white shadow-lg transition disabled:cursor-not-allowed disabled:opacity-70">

                        <div class="flex items-center justify-center gap-3">
                            <svg
                                x-show="loading"
                                x-cloak
                                class="h-5 w-5 animate-spin"
                                viewBox="0 0 24 24"
                                fill="none">
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                    class="opacity-25">
                                </circle>
                                <path
                                    fill="currentColor"
                                    class="opacity-75"
                                    d="M4 12a8 8 0 018-8v8z">
                                </path>
                            </svg>

                            <span x-text="loading ? 'Autenticando...' : 'Entrar'"></span>
                        </div>
                    </button>

                </form>
            </div>
        </div>
    </div>

    <!-- Success Transition -->
    <div
        x-show="successTransition"
        x-cloak
        x-transition.opacity
        class="fixed inset-0 z-[999] flex items-center justify-center bg-gradient-to-br from-[#2C3E50] via-[#FF1493] to-[#FF6F61]">

        <div
            x-ref="successOverlay"
            class="text-center text-white">

            <div class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-3xl bg-white/10 backdrop-blur-md">
                <i class="fa-solid fa-check text-4xl text-[#FFD700]"></i>
            </div>

            <h2 class="mb-2 text-3xl font-bold">
                Acesso autorizado
            </h2>

            <p class="text-white/80">
                Entrando no sistema...
            </p>
        </div>
    </div>

</div>

@endsection