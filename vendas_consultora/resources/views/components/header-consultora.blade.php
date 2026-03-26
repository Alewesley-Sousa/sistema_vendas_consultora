<header class="w-full bg-[#2C3E50] text-white shadow-md border-b-2 border-[#FFD700] relative z-50"> 
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
        
        <div class="flex items-center gap-4">
            <div class="p-1 rounded-md bg-white/5">
                <img src="{{ asset('images/DivasBusiness_logo2.svg') }}" 
                     alt="Divas Business Logo" 
                     class="h-12 w-auto object-contain rounded-md">
            </div>
            <div class="hidden md:block">
                <h1 class="text-lg font-bold tracking-tight leading-none uppercase" style="font-family: 'The Seasons', serif;">
                    Divas Business
                </h1>
                <span class="text-[10px] uppercase tracking-[0.2em] text-[#FFD700] font-semibold">
                    Consultoria de Cosméticos
                </span>
            </div>
        </div>

        <div class="flex items-center gap-4 md:gap-8" x-data="{ open: false }">
            <nav class="flex items-center gap-6">
                <a href="/recrutamento" class="text-xs uppercase tracking-widest hover:text-[#FF69B4] transition-colors font-sans flex items-center gap-2 group">
                    <i class="fa-solid fa-user-plus text-[#FF69B4] group-hover:scale-110 transition-transform"></i>
                    <span class="hidden lg:inline">Recrutamento</span>
                </a>
                
                <button class="bg-[#FF6F61] hover:bg-[#ff5a4a] text-white px-5 py-2 rounded-full text-sm font-bold flex items-center gap-2 shadow-lg transition-all active:scale-95 cursor-pointer">
                    <i class="fa-brands fa-whatsapp text-lg"></i>
                    <span class="hidden sm:inline">Gerar Link</span>
                </button>
            </nav>

            <div class="relative border-l border-white/10 pl-4 md:pl-8">
                <button @click="open = !open" @click.away="open = false" 
                        class="flex items-center gap-3 focus:outline-none group cursor-pointer block">
                    
                    <div class="text-right hidden sm:block">
                        <p class="text-[10px] uppercase tracking-tighter text-[#FFD700]/90 font-semibold leading-none">Consultor(a)</p>
                        <div class="flex items-center gap-2 mt-1">
                            <p class="text-sm font-medium leading-tight text-white">
                                {{ explode(' ', auth()->user()->nome ?? 'Consultora Diva')[0] }}
                            </p>
                            <i class="fa-solid fa-chevron-down text-[9px] text-[#FFD700] transition-transform duration-300"
                            :class="open ? 'rotate-180' : ''"></i>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <div class="h-10 w-10 rounded-full border-2 border-[#FF69B4] p-0.5 shadow-inner group-hover:border-[#FFD700] transition-colors duration-300">
                            @if(auth()->user() && auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                    class="h-full w-full rounded-full object-cover" 
                                    alt="Perfil">
                            @else
                                <div class="h-full w-full rounded-full bg-gray-600 flex items-center justify-center">
                                    <i class="fa-solid fa-user text-xs"></i>
                                </div>
                            @endif
                        </div>
                        <span class="absolute bottom-0 right-0 h-3 w-3 bg-[#FF6F61] border-2 border-[#2C3E50] rounded-full"></span>
                    </div>
                </button>

                <div x-show="open" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                     class="absolute right-0 mt-3 w-52 bg-white rounded-xl shadow-2xl py-2 z-[100] border border-gray-100 overflow-hidden"
                     style="display: none;">
                    
                    <div class="px-4 py-3 border-b border-gray-50 sm:hidden bg-gray-50/50">
                        <p class="text-[10px] uppercase text-gray-400 font-bold tracking-widest">Menu</p>
                        <p class="text-sm font-bold text-[#2C3E50] truncate">{{ auth()->user()->nome ?? 'Diva' }}</p>
                    </div>

                    <a href="/perfil" class="flex items-center gap-3 px-4 py-3 text-sm text-[#2C3E50] hover:bg-[#FFF5F7] transition-colors no-underline group">
                        <i class="fa-solid fa-circle-user text-[#FF69B4] group-hover:scale-110 transition-transform"></i>
                        <span class="font-medium">Meu Perfil</span>
                    </a>

                    <a href="/configuracoes" class="flex items-center gap-3 px-4 py-3 text-sm text-[#2C3E50] hover:bg-[#FFF5F7] transition-colors no-underline group">
                        <i class="fa-solid fa-gear text-gray-400 group-hover:rotate-45 transition-transform"></i>
                        <span class="font-medium">Configurações</span>
                    </a>

                    <div class="border-t border-gray-100 mt-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors cursor-pointer font-semibold">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>Sair do Sistema</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div> </div>
    </div>
</header>