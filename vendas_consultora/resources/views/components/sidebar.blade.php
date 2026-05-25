@php
    $user = auth()->user();
    $userName = $user?->nome ?? 'Usuário';
    $userCargo = strtolower($user?->cargo ?? '');

    $isDash = request()->routeIs('consultora.dashboard');
    $isRede = request()->is('rede/*');
    $isEquipe = request()->is('pedidos/equipe');
@endphp

<div
    x-data="{
        open: false,
        collapsed: false
    }"
    class="contents">

    <!-- MOBILE OPEN -->
    <button
        type="button"
        @click="open = true"
        class="fixed left-6 top-6 z-50 flex items-center gap-2 rounded-lg bg-[#2C3E50] px-3 py-2 text-white shadow-lg md:hidden"
        :class="open ? 'opacity-0 pointer-events-none' : ''">

        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7"/>
        </svg>

        <span class="text-xs font-bold uppercase">
            Menu
        </span>
    </button>

    <!-- OVERLAY -->
    <div
        x-show="open"
        x-cloak
        x-transition.opacity
        @click="open=false"
        class="fixed inset-0 z-30 bg-[#2C3E50]/40 md:hidden">
    </div>

    <!-- SIDEBAR -->
    <aside
        x-effect="document.body.classList.toggle('overflow-hidden', open)"
        class="fixed inset-y-0 left-0 z-40 flex h-[100dvh] w-64 -translate-x-full transform flex-col bg-[#2C3E50] text-gray-300 shadow-2xl transition-all duration-300 overscroll-none md:fixed md:left-4 md:top-4 md:h-[calc(100dvh-2rem)] md:translate-x-0 md:rounded-3xl"
        :class="[
            open ? 'translate-x-0' : '',
            collapsed ? 'md:w-20 md:p-3 sidebar-collapsed' : 'md:w-64 md:p-6'
        ]">

        <!-- MOBILE CLOSE -->
        <button
            type="button"
            @click="open=false"
            class="absolute right-4 top-4 rounded-lg border-2 border-red-500 p-1.5 text-red-500 md:hidden">

            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="4"
                    d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- DESKTOP COLLAPSE -->
        <button
            type="button"
            @click="collapsed=!collapsed"
            class="absolute -right-3 top-8 hidden rounded-full bg-[#FFD700] p-2 text-[#2C3E50] shadow-xl transition hover:scale-105 md:flex">

            <svg
                class="h-4 w-4 transition-transform duration-300"
                :class="collapsed ? 'rotate-180' : ''"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="3"
                    d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <!-- LOGO -->
        <div
            class="mb-8 flex items-center text-white"
            :class="collapsed ? 'justify-center' : 'gap-3 pr-8'">

            <div class="rounded-lg bg-[#FFD700] p-2">
                <svg class="h-6 w-6 text-[#2C3E50]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>

            <span
                x-show="!collapsed"
                x-transition
                class="text-xl font-bold uppercase">
                Glow
            </span>
        </div>

        <!-- PERFIL -->
        <div
            class="mb-8 border-b border-white/10 pb-8 text-center"
            :class="collapsed ? 'hidden' : 'flex flex-col items-center'">

            <div class="relative mb-4 h-20 w-20">
                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode($userName) }}&color=2C3E50&background=FFD700"
                    class="h-full w-full rounded-full border-2 border-[#FFD700]"
                    alt="Perfil">

                <div class="absolute bottom-1 right-1 h-4 w-4 rounded-full border-2 border-[#2C3E50] bg-green-500"></div>
            </div>

            <p class="text-[10px] font-bold uppercase tracking-widest text-[#FFD700]">
                {{ $userCargo ?: 'Consultora' }}
            </p>

            <h2 class="text-lg font-semibold text-white">
                {{ $userName }}
            </h2>
        </div>

        <!-- NAV -->
        <nav class="min-h-0 flex-1 space-y-2 overflow-visible">

            <!-- DASHBOARD -->
            <a
                href="{{ route('consultora.dashboard') }}"
                data-tooltip="Visão Geral"
                class="sidebar-item group flex items-center rounded-2xl px-4 py-3 transition-all duration-300
                {{ $isDash
                    ? 'bg-[#FFD700] text-[#2C3E50] shadow-lg'
                    : 'hover:bg-white/10 hover:text-white'
                }}"
                :class="collapsed ? 'justify-center' : 'gap-4'">

                <i class="fa-solid fa-house text-lg
                    {{ $isDash ? 'text-[#2C3E50]' : 'text-[#FFD700]' }}">
                </i>

                <span
                    x-show="!collapsed"
                    x-transition
                    class="font-medium">
                    Visão Geral
                </span>
            </a>

            <!-- REDE -->
            <a
                href="/rede/arvore"
                data-tooltip="Minha Rede"
                class="sidebar-item group flex items-center rounded-2xl px-4 py-3 transition-all duration-300
                {{ $isRede
                    ? 'bg-[#FFD700] text-[#2C3E50] shadow-lg'
                    : 'hover:bg-white/10 hover:text-white'
                }}"
                :class="collapsed ? 'justify-center' : 'gap-4'">

                <i class="fa-solid fa-users text-lg
                    {{ $isRede ? 'text-[#2C3E50]' : 'text-[#FFD700]' }}">
                </i>

                <span
                    x-show="!collapsed"
                    x-transition
                    class="font-medium">
                    Minha Rede
                </span>
            </a>

            <!-- PEDIDOS EQUIPE -->
            @if(str_contains($userCargo, 'líder') || str_contains($userCargo, 'lider'))
                <a
                    href="/pedidos/equipe"
                    data-tooltip="Pedidos da Equipe"
                    class="sidebar-item group flex items-center rounded-2xl px-4 py-3 transition-all duration-300
                    {{ $isEquipe
                        ? 'bg-[#FFD700] text-[#2C3E50] shadow-lg'
                        : 'hover:bg-white/10 hover:text-white'
                    }}"
                    :class="collapsed ? 'justify-center' : 'gap-4'">

                    <i class="fa-solid fa-clipboard-list text-lg
                        {{ $isEquipe ? 'text-[#2C3E50]' : 'text-[#FF7665]' }}">
                    </i>

                    <span
                        x-show="!collapsed"
                        x-transition
                        class="font-medium">
                        Pedidos Equipe
                    </span>
                </a>
            @endif

            <!-- CLIENTES -->
            <button
                type="button"
                data-tooltip="Clientes"
                @click="
                    window.dispatchEvent(new CustomEvent('open-modal-cliente'));
                    open=false
                "
                class="sidebar-item group flex w-full items-center rounded-2xl px-4 py-3 transition-all duration-300 hover:bg-white/10 hover:text-white"
                :class="collapsed ? 'justify-center' : 'gap-4'">

                <i class="fa-solid fa-user-group text-lg text-[#FF7665]"></i>

                <span
                    x-show="!collapsed"
                    x-transition
                    class="font-medium">
                    Clientes
                </span>
            </button>

        </nav>

        <!-- LOGOUT -->
        <div class="mt-auto border-t border-white/10 pt-4">

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    data-tooltip="Sair"
                    class="sidebar-item flex w-full items-center rounded-xl px-4 py-3 text-red-400 transition hover:bg-red-400/10"
                    :class="collapsed ? 'justify-center' : 'gap-4'">

                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4"/>
                    </svg>

                    <span x-show="!collapsed">
                        Sair
                    </span>
                </button>
            </form>

        </div>

    </aside>
</div>