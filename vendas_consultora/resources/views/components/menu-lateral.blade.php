<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,900;1,900&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<div class="flex h-screen bg-[#FFF9F9] md:p-6 font-sans overflow-hidden">
    
    <input type="checkbox" id="menu-toggle" class="peer hidden" />

    <label for="menu-toggle" 
           class="fixed top-6 left-6 z-50 flex items-center gap-2 px-4 py-2.5 bg-[#2C3E50] rounded-2xl text-white md:hidden cursor-pointer shadow-[0_10px_30px_rgba(44,62,80,0.4)] transition-all peer-checked:opacity-0 peer-checked:pointer-events-none active:scale-95 border border-white/10">
        <div class="relative">
            <div class="w-5 h-0.5 bg-[#FFD700] mb-1"></div>
            <div class="w-3 h-0.5 bg-[#FFD700] mb-1"></div>
            <div class="w-5 h-0.5 bg-[#FFD700]"></div>
        </div>
        <span class="text-[10px] font-black uppercase tracking-[0.2em] ml-1">Menu</span>
    </label>

    <label for="menu-toggle" 
           class="fixed inset-0 bg-[#1a252f]/60 backdrop-blur-sm z-30 transition-opacity opacity-0 pointer-events-none peer-checked:opacity-100 peer-checked:pointer-events-auto md:hidden"></label>

    <aside class="fixed md:static inset-y-0 left-0 z-40
                  flex flex-col w-72 h-full bg-gradient-to-b from-[#2C3E50] via-[#243342] to-[#1a252f] text-gray-400 p-6 
                  transition-all duration-500 transform -translate-x-full 
                  peer-checked:translate-x-0 md:translate-x-0 md:rounded-[2.5rem] shadow-[25px_0_50px_-15px_rgba(0,0,0,0.3)] border border-white/5">
        
        <label for="menu-toggle" 
               class="absolute top-6 right-6 p-2.5 bg-white/5 rounded-2xl text-red-400 md:hidden cursor-pointer hover:bg-red-500/20 transition-all border border-white/5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                <path d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </label>
        
        <div class="flex items-center gap-3 mb-12 pl-2"> 
            <div class="p-2 bg-gradient-to-br from-[#FFD700] to-[#b89b00] rounded-2xl shadow-[0_8px_20px_rgba(255,215,0,0.3)] ring-4 ring-white/5">
                <svg class="w-6 h-6 text-[#2C3E50]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"></path>
                </svg>
            </div>
            <span class="text-2xl font-serif font-black italic tracking-tighter text-white">Glow <span class="text-[#FFD700] font-light">Cosméticos</span></span>
        </div>

        <div class="flex flex-col items-center mb-10 bg-gradient-to-tr from-white/5 to-transparent p-6 rounded-[2.5rem] border border-white/10 shadow-inner">
            <div class="relative mb-4">
                <div class="absolute -inset-1 rounded-full bg-gradient-to-tr from-[#FFD700] to-[#FF7665] opacity-40 blur-sm"></div>
                <img src="https://randomuser.me/api/portraits/women/44.jpg" 
                     class="relative rounded-full border-2 border-white/30 p-1 object-cover w-20 h-20 shadow-2xl" 
                     alt="Maria Silva" />
                <div class="absolute bottom-1 right-1 w-5 h-5 bg-green-500 border-4 border-[#2C3E50] rounded-full shadow-lg"></div>
            </div>
            <div class="text-center">
                <p class="text-[9px] uppercase tracking-[0.3em] text-[#FFD700] font-black mb-1 opacity-80">Consultora Premium</p>
                <h2 class="text-lg font-bold text-white tracking-tight leading-tight">Maria Silva</h2>
            </div>
        </div>

        <nav class="flex-1 space-y-2 overflow-y-auto custom-scrollbar px-1">
            <a href="#" class="flex items-center gap-4 px-5 py-4 text-[#2C3E50] bg-gradient-to-r from-[#FFD700] to-[#fcd34d] rounded-2xl font-bold shadow-[0_12px_24px_rgba(255,215,0,0.2)] transition-all hover:scale-[1.03] active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                <span class="text-sm">Início</span>
            </a>
            
            <a href="#" class="group flex items-center gap-4 px-5 py-4 text-gray-400 hover:text-white hover:bg-white/5 rounded-2xl transition-all border border-transparent hover:border-white/10">
                <div class="p-2 rounded-xl bg-white/5 group-hover:bg-[#FFD700]/10 transition-colors">
                    <svg class="w-5 h-5 group-hover:text-[#FFD700] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <span class="text-sm font-semibold group-hover:translate-x-1 transition-transform">Meus Produtos</span>
            </a>

            <a href="#" class="group flex items-center gap-4 px-5 py-4 text-gray-400 hover:text-white hover:bg-white/5 rounded-2xl transition-all border border-transparent hover:border-white/10">
                <div class="p-2 rounded-xl bg-white/5 group-hover:bg-[#FFD700]/10 transition-colors">
                    <svg class="w-5 h-5 group-hover:text-[#FFD700] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 022 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012-2"></path>
                    </svg>
                </div>
                <span class="text-sm font-semibold group-hover:translate-x-1 transition-transform">Histórico</span>
            </a>

            <a href="#" class="group flex items-center gap-4 px-5 py-4 text-gray-400 hover:text-white hover:bg-white/5 rounded-2xl transition-all border border-transparent hover:border-white/10">
                <div class="p-2 rounded-xl bg-white/5 group-hover:bg-[#FFD700]/10 transition-colors">
                    <svg class="w-5 h-5 group-hover:text-[#FFD700] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <span class="text-sm font-semibold group-hover:translate-x-1 transition-transform">Lista de Clientes</span>
            </a>
        </nav>

        <div class="mt-auto pt-6 border-t border-white/5">
            <button class="w-full flex items-center gap-4 px-6 py-4 text-red-400/50 hover:text-red-400 hover:bg-red-400/5 rounded-2xl transition-all group border border-transparent hover:border-red-400/10">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span class="text-xs font-black uppercase tracking-[0.2em]">Sair</span>
            </button>
        </div>
    </aside>

    <main class="flex-1 p-4 md:p-10 overflow-y-auto">
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
            <div>
                <h1 class="text-3xl font-serif font-black text-[#2C3E50]">Olá, Maria! ✨</h1>
                <p class="text-gray-400 text-sm mt-1">Pronta para espalhar mais beleza hoje?</p>
            </div>
            
            <div class="flex gap-4">
                <div class="bg-white p-4 rounded-3xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="p-2 bg-green-50 text-green-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Vendas Mês</p>
                        <p class="text-lg font-bold text-[#2C3E50]">R$ 2.450</p>
                    </div>
                </div>
            </div>
        </header>
        
        <div class="w-full h-[65vh] bg-white rounded-[3.5rem] border border-gray-100 shadow-[0_20px_60px_rgba(0,0,0,0.03)] flex flex-col items-center justify-center p-12 text-center group transition-all hover:shadow-xl">
            <div class="w-24 h-24 bg-gray-50 rounded-[2.5rem] flex items-center justify-center mb-6 group-hover:rotate-12 transition-transform duration-500">
                <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-400">Tudo pronto!</h3>
            <p class="text-gray-300 max-w-sm mt-2">Escolha uma categoria ao lado para gerenciar seu império de cosméticos.</p>
        </div>
    </main>

</div>

<style>
    /* Scrollbar minimalista e dourada */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { 
        background: rgba(255, 215, 0, 0.1); 
        border-radius: 10px; 
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 215, 0, 0.3); }

    .font-serif { font-family: 'Playfair Display', serif; }
    body { font-family: 'Poppins', sans-serif; }
</style>
