<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12 fade-in">
    <div>
        <button onclick="window.history.back()" class="group flex items-center gap-2 text-[#E67E73] font-bold text-xs uppercase tracking-widest mb-4 hover:opacity-70 transition-all">
            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
            Voltar ao Início
        </button>
        <h1 class="text-5xl font-serif text-[#2C3E50]">Fluxo de <span class="text-[#E67E73]">Pedidos</span></h1>
        <p class="text-gray-400 mt-2 font-light italic">Gestão e acompanhamento da sua rede de consultoras.</p>
    </div>

    <div class="relative w-full md:w-80">
        <input type="text" x-model="search" placeholder="Buscar consultora..." 
               class="w-full bg-white border border-gray-100 rounded-2xl py-4 pl-12 pr-4 shadow-sm focus:ring-2 focus:ring-[#FF7665]/20 focus:border-[#FF7665] outline-none transition-all text-sm font-medium">
        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
    </div>
</div>
