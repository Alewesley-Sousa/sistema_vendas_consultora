<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Glow | Executive Admin')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Scripts & Frameworks -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @livewireStyles

    <style>
        body { font-family: 'Inter', sans-serif; letter-spacing: -0.01em; }
        
        /* Scrollbar Executiva */
        .custom-scrollbar::-webkit-scrollbar { width: 3px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.05); border-radius: 10px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.15); }

        [x-cloak] { display: none !important; }
        
        .sidebar-gradient {
            background: linear-gradient(180deg, #111827 0%, #000000 100%);
        }

        .main-content-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.03);
        }

        .nav-item-active {
            background: linear-gradient(90deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.02) 100%);
            border-left: 3px solid #FFFFFF;
            color: #FFFFFF !important;
        }
    </style>
</head>

<body class="bg-[#F8FAFC] text-[#0F172A]" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden p-0 md:p-3 gap-3">
        
        <!-- Overlay Mobile -->
        <div x-show="sidebarOpen" 
             x-transition:opacity
             @click="sidebarOpen = false" 
             class="fixed inset-0 bg-black/60 z-40 md:hidden backdrop-blur-md"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed md:static inset-y-0 left-0 z-50 flex flex-col w-72 sidebar-gradient text-slate-400 p-6 transition-transform duration-300 md:translate-x-0 md:rounded-[2rem] shadow-[20px_0_50px_-15px_rgba(0,0,0,0.3)] overflow-hidden border border-white/5">
            
            <!-- Logo -->
            <div class="flex items-center gap-4 mb-12 px-2">
                <div class="flex items-center justify-center w-11 h-11 bg-white rounded-xl">
                    <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-white tracking-[0.1em] leading-none">GLOW</h1>
                    <p class="text-[9px] font-medium text-slate-500 uppercase tracking-[0.3em] mt-1">Management</p>
                </div>
            </div>

            <!-- Profile -->
            <div class="mb-10 p-5 bg-white/5 rounded-2xl border border-white/5 backdrop-blur-sm">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nome) }}&color=FFFFFF&background=334155" 
                             class="w-10 h-10 rounded-full border border-white/10" alt="Avatar">
                        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-emerald-500 border-2 border-[#111827] rounded-full"></div>
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-white font-semibold text-xs truncate">{{ Auth::user()->nome }}</p>
                        <p class="text-[10px] text-slate-500 font-medium uppercase tracking-tighter">Diretoria</p>
                    </div>
                </div>
            </div>

            <!-- Menu -->
            <nav class="flex-1 space-y-8 overflow-y-auto custom-scrollbar pr-2">
                <div>
                    <p class="px-4 mb-4 text-[10px] font-bold text-slate-600 uppercase tracking-[0.25em]">Global Control</p>
                    <div class="space-y-1.5">
                        <a href="{{ route('distribuidora.dashboard') }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all hover:text-white group {{ request()->routeIs('distribuidora.dashboard') ? 'nav-item-active' : '' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                            <span class="text-[11px] font-semibold uppercase tracking-widest">Dashboard</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all hover:bg-white/5 hover:text-white group">
                            <svg class="w-4 h-4 opacity-50 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" /></svg>
                            <span class="text-[11px] font-semibold uppercase tracking-widest">Inventário</span>
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Logout -->
            <div class="pt-6 border-t border-white/5 mt-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-4 text-slate-500 hover:text-white transition-all font-bold group">
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-[10px] uppercase tracking-[0.2em]">Encerrar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0">
            
            <header class="flex items-center justify-between h-20 px-6 md:px-10 shrink-0">
                <div class="flex items-center gap-6">
                    <button @click="sidebarOpen = true" class="p-2.5 bg-white rounded-xl shadow-sm md:hidden border border-slate-200">
                        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="hidden md:block">
                        <h2 class="text-2xl font-bold text-[#0F172A] tracking-tight">@yield('header', 'Controle Central')</h2>
                        <p class="text-[11px] text-slate-400 font-medium uppercase tracking-wider">Monitoramento Executivo</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex flex-col items-end mr-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Status</span>
                        <span class="flex items-center gap-1.5 text-[11px] font-bold text-emerald-600">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Online
                        </span>
                    </div>

                    <!-- BOTÃO DE NOTIFICAÇÃO (Substituindo a engrenagem) -->
                    <button 
                        @click="$dispatch('toggle-notifications')"
                        class="p-3 bg-white text-slate-400 hover:text-black rounded-2xl shadow-sm border border-slate-200 transition-all relative group"
                    >
                        <!-- Badge de Atividade -->
                        <span class="absolute top-3 right-3 flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                        </span>

                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto custom-scrollbar md:rounded-[3rem] main-content-card p-8 md:p-12 mx-0 md:mx-4 mb-0 md:mb-4 border border-slate-200">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- INCLUSÃO DO MODAL (Componente Externo) -->
    @include('components.modal-notifications')

    @livewireScripts
</body>
</html>
