<header class="w-full bg-[#2C3E50] text-white shadow-md border-b-2 border-[#FFD700] relative z-50" 
        x-data="{ mobileOpen: false }"> 
    
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
        
        <div class="flex items-center gap-3 md:gap-4">
            <div class="p-1 rounded-md bg-white/5 shrink-0">
                <img src="{{ asset('images/DivasBusiness_logo2.svg') }}" 
                     alt="Divas Business Logo" 
                     class="h-10 md:h-12 w-auto object-contain rounded-md">
            </div>
            <div class="block">
                <h1 class="text-sm md:text-lg font-bold tracking-tight leading-none uppercase" style="font-family: 'The Seasons', serif;">
                    Divas Business
                </h1>
                <span class="text-[8px] md:text-[10px] uppercase tracking-[0.15em] md:tracking-[0.2em] text-[#FFD700] font-semibold block mt-0.5">
                    Consultoria de Cosméticos
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2 md:gap-8">
            
            <nav class="hidden md:flex items-center gap-6">
                <a href="/recrutamento" class="text-xs uppercase tracking-widest hover:text-[#FF69B4] transition-colors font-sans flex items-center gap-2 group no-underline text-white">
                    <i class="fa-solid fa-user-plus text-[#FF69B4] group-hover:scale-110 transition-transform"></i>
                    <span>Recrutamento</span>
                </a>
                
                <button class="bg-[#FF6F61] hover:bg-[#ff5a4a] text-white px-5 py-2 rounded-full text-sm font-bold flex items-center gap-2 shadow-lg transition-all active:scale-95 cursor-pointer border-none">
                    <i class="fa-brands fa-whatsapp text-lg"></i>
                    <span>Gerar Link</span>
                </button>
            </nav>

            <button @click="mobileOpen = !mobileOpen" 
                    class="md:hidden p-2 text-[#FFD700] hover:bg-white/5 rounded-lg transition-colors focus:outline-none border-none bg-transparent cursor-pointer">
                <i class="fa-solid" :class="mobileOpen ? 'fa-xmark text-2xl' : 'fa-bars text-xl'"></i>
            </button>

            <div class="relative border-l border-white/10 pl-2 md:pl-8" x-data="{ userOpen: false }">
                <button @click="userOpen = !userOpen" @click.away="userOpen = false" 
                        class="flex items-center gap-3 focus:outline-none group cursor-pointer bg-transparent border-none p-0">
                    
                    <div class="text-right hidden sm:block">
                        <p class="text-[10px] uppercase tracking-tighter text-[#FFD700]/90 font-semibold leading-none">Consultor(a)</p>
                        <div class="flex items-center gap-2 mt-1">
                            <p class="text-sm font-medium leading-tight text-white">
                                {{ explode(' ', auth()->user()->nome ?? 'Consultora Diva')[0] }}
                            </p>
                            <i class="fa-solid fa-chevron-down text-[9px] text-[#FFD700] transition-transform duration-300"
                               :class="userOpen ? 'rotate-180' : ''"></i>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <div class="h-9 w-9 md:h-10 md:w-10 rounded-full border-2 border-[#FF69B4] p-0.5 shadow-inner group-hover:border-[#FFD700] transition-colors duration-300">
                            @if(auth()->user() && auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                    class="h-full w-full rounded-full object-cover" 
                                    alt="Perfil">
                            @else
                                <div class="h-full w-full rounded-full bg-gray-600 flex items-center justify-center">
                                    <i class="fa-solid fa-user text-[10px] text-white"></i>
                                </div>
                            @endif
                        </div>
                        <span class="absolute bottom-0 right-0 h-2.5 w-2.5 bg-[#FF6F61] border-2 border-[#2C3E50] rounded-full"></span>
                    </div>
                </button>

                <div x-show="userOpen" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     class="absolute right-0 mt-3 w-52 bg-white rounded-xl shadow-2xl py-2 z-[100] border border-gray-100 overflow-hidden">
                    
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
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors cursor-pointer font-semibold border-none bg-transparent text-left">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>Sair do Sistema</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div> 
        </div>
    </div>

    <div x-show="mobileOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="md:hidden bg-[#2C3E50] border-t border-white/10 px-6 py-6 space-y-4 shadow-xl">
        
        <a href="/recrutamento" class="flex items-center gap-4 p-4 rounded-xl bg-white/5 hover:bg-white/10 no-underline text-white transition-all">
            <div class="h-10 w-10 rounded-full bg-[#FF69B4]/20 flex items-center justify-center text-[#FF69B4]">
                <i class="fa-solid fa-user-plus text-lg"></i>
            </div>
            <div>
                <p class="text-sm font-bold uppercase tracking-widest">Recrutamento</p>
                <p class="text-[10px] text-gray-400">Cadastrar nova consultora</p>
            </div>
        </a>

        <button class="w-full flex items-center gap-4 p-4 rounded-xl bg-[#FF6F61] hover:bg-[#ff5a4a] text-white transition-all border-none shadow-lg active:scale-95 cursor-pointer">
            <div class="h-10 w-10 rounded-full bg-white/20 flex items-center justify-center">
                <i class="fa-brands fa-whatsapp text-xl"></i>
            </div>
            <div class="text-left">
                <p class="text-sm font-bold uppercase tracking-widest">Gerar Link Pedido</p>
                <p class="text-[10px] text-white/70">Enviar catálogo para cliente</p>
            </div>
        </button>
    </div>
</header>
