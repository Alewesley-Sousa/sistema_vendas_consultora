<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Glow Cosmetics Admin')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @livewireStyles

    <style>
        body { font-family: 'Inter', sans-serif; letter-spacing: -0.01em; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
        [x-cloak] { display: none !important; }
        
        .main-content-card {
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
        }
    </style>
</head>

<body class="bg-[#F1F5F9] text-[#1E293B]" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden p-0 md:p-4 gap-4">
        
        <div x-show="sidebarOpen" 
             x-transition:opacity
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-slate-900/60 z-40 md:hidden backdrop-blur-sm"></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed md:static inset-y-0 left-0 z-50 flex flex-col w-72 bg-[#1E293B] text-slate-300 p-6 transition-transform duration-300 md:translate-x-0 md:rounded-[2.5rem] shadow-2xl overflow-hidden">
            
            <div class="flex items-center gap-3 mb-10 px-2">
                <div class="flex items-center justify-center w-10 h-10 bg-[#FFD700] rounded-xl shadow-lg shadow-yellow-500/20">
                    <svg class="w-6 h-6 text-[#1E293B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-white tracking-tight leading-none">GLOW</h1>
                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Admin Control</p>
                </div>
            </div>

            <div class="mb-8 p-4 bg-slate-800/50 rounded-3xl border border-white/5">
                <div class="flex items-center gap-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nome) }}&color=1E293B&background=FFD700" 
                         class="w-10 h-10 rounded-2xl ring-2 ring-yellow-500/20" alt="Avatar">
                    <div class="overflow-hidden">
                        <p class="text-white font-bold text-xs truncate">{{ Auth::user()->nome }}</p>
                        <p class="text-[10px] text-slate-500 uppercase tracking-tighter">Administrador</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 space-y-6 overflow-y-auto custom-scrollbar pr-2">
                
                <div>
                    <p class="px-4 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Comercial</p>
                    <div class="space-y-1">
                        <a href="{{ route('distribuidora.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all hover:bg-white/5 {{ request()->routeIs('distribuidora.dashboard') ? 'bg-yellow-400 text-[#1E293B] font-bold' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                            <span class="text-[11px] uppercase tracking-wider">Dashboard</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all hover:bg-white/5 group">
                            <svg class="w-4 h-4 group-hover:text-pink-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                            <span class="text-[11px] uppercase tracking-wider">Gerenciar Produtos</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all hover:bg-white/5 group">
                            <svg class="w-4 h-4 group-hover:text-yellow-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            <span class="text-[11px] uppercase tracking-wider">Catálogo</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all hover:bg-white/5 group">
                            <svg class="w-4 h-4 group-hover:text-orange-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                            <span class="text-[11px] uppercase tracking-wider">Promoções</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-4 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Operacional</p>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all hover:bg-white/5 group">
                            <svg class="w-4 h-4 group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                            <span class="text-[11px] uppercase tracking-wider">Novas Consultoras</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all hover:bg-white/5 group">
                            <svg class="w-4 h-4 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>
                            <span class="text-[11px] uppercase tracking-wider">Estoque</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-4 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Financeiro</p>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all hover:bg-white/5 group">
                            <svg class="w-4 h-4 group-hover:text-green-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span class="text-[11px] uppercase tracking-wider">Saques</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all hover:bg-white/5 group">
                            <svg class="w-4 h-4 group-hover:text-yellow-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" /></svg>
                            <span class="text-[11px] uppercase tracking-wider">Resgates</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all hover:bg-white/5 group">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            <span class="text-[11px] uppercase tracking-wider">Comissões</span>
                        </a>
                    </div>
                </div>

                <div>
                    <p class="px-4 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Sistema</p>
                    <div class="space-y-1">
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all hover:bg-white/5 group">
                            <svg class="w-4 h-4 group-hover:text-cyan-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            <span class="text-[11px] uppercase tracking-wider">Relatórios</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all hover:bg-white/5 group text-red-300">
                            <svg class="w-4 h-4 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>
                            <span class="text-[11px] uppercase tracking-wider">Backup DB</span>
                        </a>
                    </div>
                </div>
            </nav>

            <div class="pt-6 border-t border-white/5 mt-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-4 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-2xl transition-all font-bold group">
                        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-xs uppercase tracking-widest">Sair</span>
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0">
            
            <header class="flex items-center justify-between h-20 px-4 md:px-8 shrink-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="p-2.5 bg-white rounded-xl shadow-sm md:hidden border border-slate-200">
                        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="hidden md:block leading-tight">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Bem-vindo,</p>
                        <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">@yield('header', 'Controle Central')</h2>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button class="p-2.5 bg-white text-slate-400 hover:text-slate-600 rounded-xl shadow-sm border border-slate-200/50 transition-all relative">
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                    </button>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto custom-scrollbar md:rounded-[2.5rem] main-content-card p-6 md:p-10 mx-0 md:mx-2 mb-0 md:mb-2">
                @yield('content')
            </div>
        </main>
    </div>

    <x-modal id="clientes" title="Gestão de Clientes" subtitle="Controle de base e cadastros">
        </x-modal>

    @livewireScripts
</body>
</html>
