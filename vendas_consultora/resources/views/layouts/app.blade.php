<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Glow Cosmetics')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Scrollbar fina para a lista de navegação */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.05); }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 10px; }
    </style>
</head>

<body class="bg-[#FFF5F7]">

    <div class="flex h-screen md:p-4 font-sans overflow-hidden">
        <input type="checkbox" id="menu-toggle" class="peer hidden" />

        <label for="menu-toggle" class="fixed top-6 left-6 z-50 flex items-center gap-2 px-3 py-2 bg-[#2C3E50] rounded-lg text-white md:hidden cursor-pointer shadow-lg transition-all peer-checked:opacity-0 peer-checked:pointer-events-none active:scale-95">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
            <span class="text-xs font-bold uppercase tracking-wider">Menu</span>
        </label>

        <label for="menu-toggle" class="fixed inset-0 bg-[#2C3E50]/40 z-30 transition-opacity opacity-0 pointer-events-none peer-checked:opacity-100 peer-checked:pointer-events-auto md:hidden"></label>

        <aside class="fixed md:static inset-y-0 left-0 z-40 flex flex-col w-64 h-full bg-[#2C3E50] text-gray-300 p-6 transition-transform duration-300 transform -translate-x-full peer-checked:translate-x-0 md:translate-x-0 md:rounded-3xl shadow-2xl">
            
            <label for="menu-toggle" class="absolute top-4 right-4 p-1.5 bg-[#2C3E50] rounded-lg text-red-500 md:hidden cursor-pointer border-2 border-red-500 shadow-[0_0_15px_rgba(239,68,68,0.8)] transition-all active:scale-90">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </label>

            <div class="flex items-center gap-3 mb-8 text-white pr-8">
                <div class="p-1.5 bg-[#FFD700] rounded-lg shadow-sm">
                    <svg class="w-6 h-6 text-[#2C3E50]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight">Glow Cosmetics</span>
            </div>

            <div class="flex flex-col items-center mb-8 border-b border-white/10 pb-8 text-center">
                <div class="relative w-20 h-20 mb-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=2C3E50&background=FFD700" class="rounded-full border-2 border-[#FFD700] p-1 object-cover w-full h-full shadow-md" alt="Perfil">
                    <div class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 border-2 border-[#2C3E50] rounded-full"></div>
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-[#FFD700] font-bold">{{ Auth::user()->cargo ?? 'Consultora' }}</p>
                    <h2 class="text-lg font-semibold text-white">{{ Auth::user()->name }}</h2>
                </div>
            </div>

            <nav class="flex-1 space-y-1.5 overflow-y-auto custom-scrollbar pr-2">
                @php $isDash = request()->routeIs('consultora.dashboard'); @endphp

                <a href="{{ route('consultora.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all {{ $isDash ? 'text-[#2C3E50] bg-[#FFD700] font-bold shadow-lg' : 'hover:text-white hover:bg-white/10 group' }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    <span class="text-sm">Visão Geral</span>
                </a>

                <a href="#" class="flex items-center gap-4 px-4 py-3 hover:text-white hover:bg-white/10 rounded-xl transition-all group">
                    <svg class="w-5 h-5 group-hover:text-[#FFD700]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="text-sm">Produtos</span>
                </a>

                <a href="#" class="flex items-center gap-4 px-4 py-3 hover:text-white hover:bg-white/10 rounded-xl transition-all group">
                    <svg class="w-5 h-5 group-hover:text-[#FFD700]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2"></path>
                    </svg>
                    <span class="text-sm">Pedidos</span>
                </a>
            </nav>

            <div class="mt-auto space-y-1.5">
                <a href="#" class="flex items-center gap-4 px-4 py-3 hover:text-white hover:bg-white/10 rounded-xl transition-all group">
                    <svg class="w-5 h-5 group-hover:text-[#FFD700]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-sm">Configurações</span>
                </a>

                <div class="pt-4 border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-4 px-4 py-3 text-red-400 hover:bg-red-400/10 rounded-xl transition-all group font-bold">
                            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="text-sm">Sair do Painel</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <main class="flex-1 p-8 overflow-y-auto">
            <header class="mb-8">
                <h1 class="text-2xl font-bold text-[#2C3E50]">@yield('header')</h1>
            </header>
            <section>
                @yield('content')
            </section>
        </main>
    </div>

</body>
</html>
