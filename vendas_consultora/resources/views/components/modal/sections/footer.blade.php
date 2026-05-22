<div class="flex items-center justify-between border-t border-gray-100 bg-[#F8FAFC] px-6 py-5 sm:px-8">
    <button
        type="button"
        x-show="step !== 'menu'"
        @click="step = 'menu'"
        class="group flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-[#2C3E50] transition-colors hover:text-[#FFD700]">
        <svg class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" />
        </svg>
        Início
    </button>

    <button
        type="button"
        @click="closeModal()"
        class="ml-auto flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400 transition-all hover:text-red-500">
        Fechar Janela
    </button>
</div>