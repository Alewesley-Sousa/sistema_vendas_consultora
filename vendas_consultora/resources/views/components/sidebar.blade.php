@php
    $user = auth()->user();
    $userName = $user?->nome ?? 'Usuário';
    $userCargo = strtolower($user?->cargo ?? '');

    $isDash = request()->routeIs('consultora.dashboard');
    $isRede = request()->is('rede/*');
    $isEquipe = request()->is('pedidos/equipe');
@endphp

<div x-data="{ open: false }" class="contents">
    <!-- Botão Abrir Menu (Mobile) -->
    <button
        type="button"
        @click="open = true"
        class="fixed left-6 top-6 z-50 flex items-center gap-2 rounded-lg bg-[#2C3E50] px-3 py-2 text-white shadow-lg transition-all active:scale-95 md:hidden"
        :class="open ? 'opacity-0 pointer-events-none' : 'opacity-100'">

        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>

        <span class="text-xs font-bold uppercase tracking-wider">
            Menu
        </span>
    </button>

    <!-- Overlay Mobile -->
    <div
        x-show="open"
        x-cloak
        x-transition.opacity
        @click="open = false"
        class="fixed inset-0 z-30 bg-[#2C3E50]/40 md:hidden">
    </div>

    <!-- Sidebar -->
    <aside
        class="fixed inset-y-0 left-0 z-40 flex h-full w-64 -translate-x-full transform flex-col bg-[#2C3E50] p-6 text-gray-300 shadow-2xl transition-transform duration-300 md:static md:translate-x-0 md:rounded-3xl"
        :class="open ? 'translate-x-0' : ''">

        <!-- Botão Fechar (Mobile) -->
        <button
            type="button"
            @click="open = false"
            class="absolute right-4 top-4 rounded-lg border-2 border-red-500 bg-[#2C3E50] p-1.5 text-red-500 shadow-[0_0_15px_rgba(239,68,68,0.8)] transition-all active:scale-90 md:hidden">

            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <!-- Logo -->
        <div class="mb-8 flex items-center gap-3 pr-8 text-white">
            <div class="rounded-lg bg-[#FFD700] p-1.5 shadow-sm">
                <svg class="h-6 w-6 text-[#2C3E50]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <span class="text-xl font-bold tracking-tight uppercase">
                Glow
            </span>
        </div>

        <!-- Perfil do Usuário -->
        <div class="mb-8 flex flex-col items-center border-b border-white/10 pb-8 text-center">
            <div class="relative mb-4 h-20 w-20">
                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode($userName) }}&color=2C3E50&background=FFD700"
                    class="h-full w-full rounded-full border-2 border-[#FFD700] object-cover p-1 shadow-md"
                    alt="Perfil">

                <div class="absolute bottom-1 right-1 h-4 w-4 rounded-full border-2 border-[#2C3E50] bg-green-500"></div>
            </div>

            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-[#FFD700]">
                    {{ $userCargo ?: 'Consultora' }}
                </p>
                <h2 class="text-lg font-semibold text-white">
                    {{ $userName }}
                </h2>
            </div>
        </div>

        <!-- Navegação -->
        <nav class="flex-1 space-y-2 overflow-y-auto pr-2">
            <a
                href="{{ route('consultora.dashboard') }}"
                class="flex items-center gap-4 rounded-xl px-4 py-3 transition-all {{ $isDash ? 'bg-[#FFD700] font-bold text-[#2C3E50] shadow-lg' : 'hover:bg-white/10 hover:text-white' }}">
                <svg class="h-5 w-5 {{ $isDash ? 'text-[#2C3E50]' : 'text-[#FFD700]' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 00-1.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                <span class="text-sm">Visão Geral</span>
            </a>

            <a
                href="/rede/arvore"
                class="flex items-center gap-4 rounded-xl px-4 py-3 transition-all {{ $isRede ? 'bg-[#FFD700] font-bold text-[#2C3E50] shadow-lg' : 'hover:bg-white/10 hover:text-white' }}">
                <svg class="h-5 w-5 {{ $isRede ? 'text-[#2C3E50]' : 'text-[#FFD700]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="text-sm">Minha Rede</span>
            </a>

            @if(str_contains($userCargo, 'líder') || str_contains($userCargo, 'lider'))
                <a
                    href="/pedidos/equipe"
                    class="flex items-center gap-4 rounded-xl px-4 py-3 transition-all {{ $isEquipe ? 'bg-[#FFD700] font-bold text-[#2C3E50] shadow-lg' : 'hover:bg-white/10 hover:text-white' }}">
                    <svg class="h-5 w-5 {{ $isEquipe ? 'text-[#2C3E50]' : 'text-[#FF7665]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="text-sm">Pedidos Equipe</span>
                </a>
            @endif

          <button
    type="button"
    @click="
        window.dispatchEvent(
            new CustomEvent('open-modal-clientes')
        );
        open = false
    "
    class="flex w-full cursor-pointer items-center gap-4 rounded-xl px-4 py-3 text-left transition-all hover:bg-white/10 hover:text-white">

    <svg class="h-5 w-5 text-[#FF7665]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
    </svg>

    <span class="text-sm">Clientes</span>
</button>
        </nav>

        <!-- Rodapé -->
        <div class="mt-auto border-t border-white/10 pt-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="flex w-full cursor-pointer items-center gap-4 rounded-xl px-4 py-3 font-bold text-red-400 transition-all hover:bg-red-400/10 group">
                    <svg class="h-5 w-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    <span class="text-sm">Sair do Painel</span>
                </button>
            </form>
        </div>
    </aside>
</div>