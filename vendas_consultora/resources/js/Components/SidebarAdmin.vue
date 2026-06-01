<template>
  <div>
    <aside
      class="fixed bottom-0 left-0 z-40 flex w-full transition-all duration-300 md:inset-y-0 md:top-3 md:left-3 md:bottom-auto md:h-[calc(100dvh-1.5rem)] md:flex-col md:rounded-[2rem] md:border-none md:pb-0"
      :class="[
        collapsed ? 'md:w-22 md:p-4' : 'md:w-72 md:p-6',
        'sidebar-gradient text-slate-400 shadow-[0_-8px_30px_rgb(0,0,0,0.3)] md:shadow-[20px_0_50px_-15px_rgba(0,0,0,0.3)] border-t border-white/5 md:border pb-safe'
      ]"
    >
      <button
        type="button"
        @click="$emit('toggle')"
        class="absolute -right-3 top-8 hidden rounded-full p-2 shadow-xl transition-all duration-300 hover:scale-110 active:scale-95 md:flex z-50 bg-white text-black"
      >
        <svg
          class="h-4 w-4 transition-transform duration-300"
          :class="collapsed ? 'rotate-180' : ''"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/>
        </svg>
      </button>

      <div class="hidden items-center text-white md:flex md:mb-12 px-2" :class="collapsed ? 'justify-center' : 'gap-4'">
        <div class="flex items-center justify-center w-11 h-11 bg-white rounded-xl shadow-inner shrink-0">
          <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z" />
          </svg>
        </div>
        <div v-if="!collapsed" class="flex flex-col">
          <h1 class="text-xl font-extrabold text-white tracking-[0.1em] leading-none">GLOW</h1>
          <p class="text-[9px] font-medium text-slate-500 uppercase tracking-[0.3em] mt-1">Management</p>
        </div>
      </div>

      <div
        class="hidden flex-col transition-all duration-300 md:flex md:mb-10"
        :class="[
          collapsed
            ? 'p-0 bg-transparent border-none shadow-none items-center'
            : 'p-5 bg-white/5 rounded-2xl border border-white/5 backdrop-blur-sm'
        ]"
      >
        <div class="flex items-center" :class="collapsed ? 'justify-center' : 'gap-4'">
          <div class="relative shrink-0">
            <img
              :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&color=FFFFFF&background=334155`"
              class="h-10 w-10 rounded-full border border-white/10 object-cover"
              alt="Avatar"
            >
            <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-emerald-500 border-2 border-[#111827] rounded-full"></div>
          </div>
          
          <div v-if="!collapsed" class="overflow-hidden">
            <p class="text-white font-semibold text-xs truncate">{{ userName }}</p>
            <p class="text-[10px] text-slate-500 font-medium uppercase tracking-tighter">Diretoria</p>
          </div>
        </div>
      </div>

      <nav
        class="hidden md:block md:space-y-1.5 md:flex-1 transition-all custom-scrollbar overflow-x-hidden pr-1"
        :class="collapsed ? 'md:overflow-visible' : 'md:overflow-y-auto'"
      >
        <p v-if="!collapsed" class="px-4 mb-4 text-[10px] font-bold text-slate-600 uppercase tracking-[0.25em]">Global Control</p>

        <Link
          href="/distribuidora/dashboard"
          class="group relative flex flex-col items-center justify-center rounded-xl px-4 py-3 transition-all duration-200 md:flex-row"
          :class="[
            $page.component.startsWith('Distribuidora/Dashboard') ? 'nav-item-active' : 'text-slate-400 hover:text-white',
            collapsed ? 'md:justify-center' : 'md:justify-start gap-3'
          ]"
        >
          <svg class="w-4 h-4 shrink-0 transition-opacity duration-200" :class="{ 'opacity-50 group-hover:opacity-100': !$page.component.startsWith('Distribuidora/Dashboard') }" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
          </svg>
          <span v-if="!collapsed" class="text-[11px] font-semibold uppercase tracking-widest">Dashboard</span>
          <span v-else class="tooltip-text">Dashboard</span>
        </Link>

        <Link
          href="/distribuidora/produtos"
          class="group relative flex flex-col items-center justify-center rounded-xl px-4 py-3 transition-all duration-200 md:flex-row"
          :class="[
            $page.component.startsWith('Distribuidora/Produtos') ? 'nav-item-active' : 'text-slate-400 hover:text-white',
            collapsed ? 'md:justify-center' : 'md:justify-start gap-3'
          ]"
        >
          <svg class="w-4 h-4 shrink-0 transition-opacity duration-200" :class="{ 'opacity-50 group-hover:opacity-100': !$page.component.startsWith('Distribuidora/Produtos') }" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 11m8 4V5M4 11v10l8 4" />
          </svg>
          <span v-if="!collapsed" class="text-[11px] font-semibold uppercase tracking-widest">Produtos</span>
          <span v-else class="tooltip-text">Produtos</span>
        </Link>

        <Link
          href="/distribuidora/catalogos"
          class="group relative flex flex-col items-center justify-center rounded-xl px-4 py-3 transition-all duration-200 md:flex-row"
          :class="[
            $page.component.startsWith('Distribuidora/Catalogos') ? 'nav-item-active' : 'text-slate-400 hover:text-white',
            collapsed ? 'md:justify-center' : 'md:justify-start gap-3'
          ]"
        >
          <svg class="w-4 h-4 shrink-0 transition-opacity duration-200" :class="{ 'opacity-50 group-hover:opacity-100': !$page.component.startsWith('Distribuidora/Catalogos') }" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
          </svg>
          <span v-if="!collapsed" class="text-[11px] font-semibold uppercase tracking-widest">Catálogos</span>
          <span v-else class="tooltip-text">Catálogos</span>
        </Link>

        <Link
          href="/distribuidora/categorias"
          class="group relative flex flex-col items-center justify-center rounded-xl px-4 py-3 transition-all duration-200 md:flex-row"
          :class="[
            $page.component.startsWith('Distribuidora/Categorias') ? 'nav-item-active' : 'text-slate-400 hover:text-white',
            collapsed ? 'md:justify-center' : 'md:justify-start gap-3'
          ]"
        >
          <svg class="w-4 h-4 shrink-0 transition-opacity duration-200" :class="{ 'opacity-50 group-hover:opacity-100': !$page.component.startsWith('Distribuidora/Categorias') }" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
          </svg>
          <span v-if="!collapsed" class="text-[11px] font-semibold uppercase tracking-widest">Categorias</span>
          <span v-else class="tooltip-text">Categorias</span>
        </Link>

        <Link
          href="/distribuidora/estoques"
          class="group relative flex flex-col items-center justify-center rounded-xl px-4 py-3 transition-all duration-200 md:flex-row"
          :class="[
            $page.component.startsWith('Distribuidora/Estoques') ? 'nav-item-active' : 'text-slate-400 hover:text-white',
            collapsed ? 'md:justify-center' : 'md:justify-start gap-3'
          ]"
        >
          <svg class="w-4 h-4 shrink-0 transition-opacity duration-200" :class="{ 'opacity-50 group-hover:opacity-100': !$page.component.startsWith('Distribuidora/Estoques') }" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
          </svg>
          <span v-if="!collapsed" class="text-[11px] font-semibold uppercase tracking-widest">Estoques</span>
          <span v-else class="tooltip-text">Estoques</span>
        </Link>

        <Link
          href="/distribuidora/solicitacoes"
          class="group relative flex flex-col items-center justify-center rounded-xl px-4 py-3 transition-all duration-200 md:flex-row"
          :class="[
            $page.component.startsWith('Distribuidora/Solicitacoes') ? 'nav-item-active' : 'text-slate-400 hover:text-white',
            collapsed ? 'md:justify-center' : 'md:justify-start gap-3'
          ]"
        >
          <svg class="w-4 h-4 shrink-0 transition-opacity duration-200" :class="{ 'opacity-50 group-hover:opacity-100': !$page.component.startsWith('Distribuidora/Solicitacoes') }" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
          </svg>
          <span v-if="!collapsed" class="text-[11px] font-semibold uppercase tracking-widest">Solicitações</span>
          <span v-else class="tooltip-text">Solicitações</span>
        </Link>

        <Link
          href="/distribuidora/relatorios"
          class="group relative flex flex-col items-center justify-center rounded-xl px-4 py-3 transition-all duration-200 md:flex-row"
          :class="[
            $page.component.startsWith('Distribuidora/Relatorios') ? 'nav-item-active' : 'text-slate-400 hover:text-white',
            collapsed ? 'md:justify-center' : 'md:justify-start gap-3'
          ]"
        >
          <svg class="w-4 h-4 shrink-0 transition-opacity duration-200" :class="{ 'opacity-50 group-hover:opacity-100': !$page.component.startsWith('Distribuidora/Relatorios') }" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z" />
          </svg>
          <span v-if="!collapsed" class="text-[11px] font-semibold uppercase tracking-widest">Relatórios</span>
          <span v-else class="tooltip-text">Relatórios</span>
        </Link>

        <button
          type="button"
          @click="showConfigModal = true"
          class="group relative flex flex-col items-center justify-center rounded-xl px-4 py-3 text-slate-400 hover:text-white transition-all duration-200 md:flex-row md:w-full"
          :class="collapsed ? 'md:justify-center' : 'md:justify-start gap-3'"
        >
          <svg class="w-4 h-4 shrink-0 opacity-50 group-hover:opacity-100 group-hover:rotate-90 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
          <span v-if="!collapsed" class="text-[11px] font-semibold uppercase tracking-widest">Preferências</span>
          <span v-else class="tooltip-text">Preferências</span>
        </button>
      </nav>

      <div class="hidden mt-auto border-t border-white/5 pt-4 md:block">
        <button
          type="button"
          @click="logout"
          class="group relative flex w-full items-center rounded-xl px-4 py-4 text-slate-500 hover:text-white transition-all font-bold duration-200"
          :class="collapsed ? 'md:justify-center' : 'md:gap-3'"
        >
          <svg class="w-5 h-5 shrink-0 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
          <span v-if="!collapsed" class="text-[10px] uppercase tracking-[0.2em]">Encerrar</span>
          <span v-if="collapsed" class="logout-tooltip">Encerrar</span>
        </button>
      </div>

      <div class="flex w-full items-center justify-between px-6 py-2 md:hidden relative">
        <Link 
          href="/distribuidora/dashboard" 
          class="flex flex-col items-center gap-1 min-w-[60px] py-1 text-slate-500"
          :class="{ 'text-white font-bold': $page.component.startsWith('Distribuidora/Dashboard') }"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
          <span class="text-[10px] font-medium tracking-wide">Início</span>
        </Link>

        <div class="relative -top-5 flex justify-center items-center">
          <div class="absolute bottom-0 flex justify-center items-center w-0 h-0 overflow-visible z-50">
            
            <Link
              href="/distribuidora/produtos"
              class="radial-btn transition-all duration-300"
              :class="mobileMenuOpen ? 'open opacity-100 scale-100' : 'opacity-0 scale-50'"
              style="--angle: 210deg; --dist: 100px;"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 11m8 4V5M4 11v10l8 4" /></svg>
              <span class="radial-label">Produtos</span>
            </Link>

            <Link
              href="/distribuidora/solicitacoes"
              class="radial-btn transition-all duration-300"
              :class="mobileMenuOpen ? 'open opacity-100 scale-100' : 'opacity-0 scale-50'"
              style="--angle: 270deg; --dist: 105px;"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
              <span class="radial-label">Pedidos</span>
            </Link>

            <Link
              href="/distribuidora/estoques"
              class="radial-btn transition-all duration-300"
              :class="mobileMenuOpen ? 'open opacity-100 scale-100' : 'opacity-0 scale-50'"
              style="--angle: 330deg; --dist: 100px;"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" /></svg>
              <span class="radial-label">Estoques</span>
            </Link>

            <Link
              href="/distribuidora/catalogos"
              class="radial-btn outer-layer transition-all duration-300"
              :class="mobileMenuOpen ? 'open opacity-100 scale-100' : 'opacity-0 scale-50'"
              style="--angle: 225deg; --dist: 170px;"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
              <span class="radial-label">Catálogos</span>
            </Link>

            <Link
              href="/distribuidora/categorias"
              class="radial-btn outer-layer transition-all duration-300"
              :class="mobileMenuOpen ? 'open opacity-100 scale-100' : 'opacity-0 scale-50'"
              style="--angle: 270deg; --dist: 175px;"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
              <span class="radial-label">Categorias</span>
            </Link>

            <Link
              href="/distribuidora/relatorios"
              class="radial-btn outer-layer transition-all duration-300"
              :class="mobileMenuOpen ? 'open opacity-100 scale-100' : 'opacity-0 scale-50'"
              style="--angle: 315deg; --dist: 170px;"
            >
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z" /></svg>
              <span class="radial-label">Relatórios</span>
            </Link>

          </div>

          <button 
            @click="mobileMenuOpen = !mobileMenuOpen"
            type="button"
            class="w-15 h-15 rounded-full bg-slate-900 border-4 border-slate-950 flex items-center justify-center shadow-xl text-white transition-all duration-300 active:scale-90 z-50"
            :class="mobileMenuOpen ? 'rotate-90 scale-105' : ''"
          >
            <svg v-if="mobileMenuOpen" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            <svg v-else class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
          </button>
        </div>

        <button 
          @click="showConfigModal = true" 
          class="flex flex-col items-center gap-1 min-w-[60px] py-1 text-slate-500 hover:text-white"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /></svg>
          <span class="text-[10px] font-medium tracking-wide">Aparência</span>
        </button>
      </div>
    </aside>

    <div 
      v-if="mobileMenuOpen" 
      @click="mobileMenuOpen = false" 
      class="fixed inset-0 bg-black/70 z-30 md:hidden backdrop-blur-xs transition-opacity duration-300"
    ></div>

    <Teleport to="body">
      <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div v-if="showConfigModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm">
          <Transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="opacity-0 scale-95 translate-y-4"
            enter-to-class="opacity-100 scale-100 translate-y-0"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100 scale-100 translate-y-0"
            leave-to-class="opacity-0 scale-95 translate-y-4"
          >
            <div class="relative w-full max-w-md overflow-hidden rounded-3xl bg-slate-900 p-6 text-slate-100 shadow-2xl border border-white/5 transition-all duration-300">
              <div class="flex items-center justify-between border-b border-white/5 pb-4 mb-6">
                <div class="flex items-center gap-3">
                  <div class="p-2 rounded-xl bg-white/5 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                  </div>
                  <h3 class="text-md font-bold uppercase tracking-wider">Preferências</h3>
                </div>
                <button @click="showConfigModal = false" class="rounded-full p-1.5 text-slate-500 hover:bg-white/5 hover:text-white transition-colors">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
              </div>

              <div class="space-y-4">
                <div class="flex items-center justify-between p-4 rounded-2xl bg-black/40 border border-white/5">
                  <div class="flex flex-col gap-0.5">
                    <span class="text-sm font-semibold">Tema do Sistema</span>
                    <span class="text-xs text-slate-500">Alternar modo claro e escuro</span>
                  </div>

                  <button
                    type="button"
                    @click="toggleDarkMode"
                    class="group relative flex items-center justify-between rounded-full p-1 w-24 h-10 transition-all duration-300 active:scale-95 bg-black/50 border border-white/10 shadow-inner"
                  >
                    <div
                      class="absolute top-1 bottom-1 w-8 rounded-full shadow-md transition-all duration-300 flex items-center justify-center"
                      :class="[isDark ? 'left-14 bg-white text-black' : 'left-1 bg-white text-black']"
                    >
                      <svg v-if="isDark" class="w-3 h-3 text-black" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>
                      <svg v-else class="w-3.5 h-3.5 text-black" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 14.05a1 1 0 011.414 0l.707.707a1 1 0 11-1.414 1.414l-.707-.707a1 1 0 010-1.414zm-.707-8.485a1 1 0 011.414 0l.707.707a1 1 0 11-1.414 1.414l-.707-.707a1 1 0 010-1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" clip-rule="evenodd"/></svg>
                    </div>
                    <span class="text-[9px] font-bold uppercase tracking-wider pl-3 transition-opacity duration-200" :class="isDark ? 'opacity-100 text-white' : 'opacity-0'">Dark</span>
                    <span class="text-[9px] font-bold uppercase tracking-wider pr-3 transition-opacity duration-200" :class="!isDark ? 'opacity-100 text-slate-400' : 'opacity-0'">Light</span>
                  </button>
                </div>

                <button
                  @click="logout"
                  class="w-full mt-2 flex items-center justify-center gap-2 p-3.5 rounded-2xl bg-red-500/10 text-red-400 font-bold text-xs uppercase tracking-wider md:hidden border border-red-500/20"
                >
                  Sair da Conta
                </button>
              </div>

              <div class="mt-8 flex justify-end">
                <button
                  @click="showConfigModal = false"
                  class="px-5 py-2.5 rounded-xl font-medium text-xs uppercase tracking-widest bg-white text-black hover:opacity-90 active:scale-98 transition-all"
                >
                  Concluído
                </button>
              </div>
            </div>
          </Transition>
        </div>
      </Transition>
    </Teleport>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { usePage, Link, router } from '@inertiajs/vue3'

defineProps({
  collapsed: Boolean
})

defineEmits(['toggle'])

const page = usePage()
const isDark = ref(true)
const showConfigModal = ref(false)
const mobileMenuOpen = ref(false)

const userName = computed(() => page.props.auth?.user?.nome || 'Administrador')

const toggleDarkMode = () => {
  isDark.value = !isDark.value
  updateTheme()
}

const updateTheme = () => {
  if (isDark.value) {
    document.documentElement.classList.add('dark')
    localStorage.theme = 'dark'
  } else {
    document.documentElement.classList.remove('dark')
    localStorage.theme = 'light'
  }
}

onMounted(() => {
  const savedTheme = localStorage.theme
  if (savedTheme === 'light') {
    isDark.value = false
  } else {
    isDark.value = true
  }
  updateTheme()
})

const logout = () => {
  router.post(route('logout'))
}
</script>

<style scoped>
/* Gradiente corporativo do layout antigo */
.sidebar-gradient {
  background: linear-gradient(180deg, #111827 0%, #000000 100%);
}

/* Customização fina do Scrollbar Interno */
.custom-scrollbar::-webkit-scrollbar {
  width: 3px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.05);
  border-radius: 10px;
}
.custom-scrollbar:hover::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.15);
}

/* Estilo exato de Item Ativo do Layout Antigo */
.nav-item-active {
  background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.02) 100%);
  border-left: 3px solid #FFFFFF;
  color: #FFFFFF !important;
  font-weight: 700;
  border-top-left-radius: 0px;
  border-bottom-left-radius: 0px;
}

/* Tooltips flutuantes nativos em CSS para estado colapsado (Desktop) */
.tooltip-text, .logout-tooltip {
  position: absolute;
  left: 100%;
  top: 50%;
  transform: translateY(-50%);
  margin-left: 1rem;
  display: none;
  color: #ffffff;
  font-size: 11px;
  text-transform: uppercase;
  font-weight: 600;
  letter-spacing: 0.1em;
  padding: 0.5rem 0.75rem;
  border-radius: 0.5rem;
  opacity: 0;
  pointer-events: none;
  white-space: nowrap;
  z-index: 50;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
  border: 1px solid rgba(255, 255, 255, 0.05);
}

.tooltip-text {
  background-color: #111827;
}

.logout-tooltip {
  background-color: #450a0a;
  color: #f87171;
  border: 1px solid rgba(239, 68, 68, 0.2);
}

@media (min-width: 768px) {
  .group:hover .tooltip-text,
  .group:hover .logout-tooltip {
    display: inline-block;
    opacity: 1;
    transition: opacity 200ms;
  }
}

/* Estilização do Menu Circular Mobile */
.radial-btn {
  position: absolute;
  width: 52px;
  height: 52px;
  border-radius: 99px;
  background-color: #111827;
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: #ffffff;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.6);
  top: -26px;
  left: -26px;
  transform: translate(0, 0) scale(0.1);
  opacity: 0;
  pointer-events: none;
  transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
}

/* Customização para diferenciar visualmente a camada externa */
.radial-btn.outer-layer {
  background-color: #1f2937;
  border: 1px solid rgba(255, 255, 255, 0.15);
}

.radial-btn:active {
  transform: scale(0.95);
}

/* Aplicação da matriz trigonométrica com variáveis CSS */
.radial-btn.open {
  pointer-events: auto;
  opacity: 1;
  transform: translate(
    calc(cos(var(--angle)) * var(--dist)),
    calc(sin(var(--angle)) * var(--dist))
  ) scale(1);
}

.radial-label {
  position: absolute;
  bottom: -1.4rem;
  font-size: 9px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  white-space: nowrap;
  color: #94a3b8;
}

/* Sutil ajuste de label para a camada de fora */
.outer-layer .radial-label {
  color: #cbd5e1;
}
</style>