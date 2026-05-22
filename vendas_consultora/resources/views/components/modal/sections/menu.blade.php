<div x-show="step === 'menu'" x-transition.opacity.duration.200ms class="space-y-4">
    <button
        type="button"
        @click="step = 'form'"
        class="group flex w-full items-center gap-5 rounded-[2rem] border border-gray-100 bg-[#FFF5F7] p-5 text-left transition-all hover:-translate-y-0.5 hover:border-[#FFD700] hover:bg-white hover:shadow-xl sm:p-6">

        <div class="rounded-2xl bg-[#2C3E50] p-4 text-white shadow-lg transition-colors group-hover:bg-[#FFD700] group-hover:text-[#2C3E50]">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <div>
            <p class="text-lg font-bold leading-none text-[#2C3E50]">
                Consultar CPF
            </p>
            <p class="mt-1 text-xs font-bold uppercase tracking-wider text-gray-400">
                Busca instantânea
            </p>
        </div>
    </button>

    <button
        type="button"
        @click="step = 'cadastro'"
        class="group flex w-full items-center gap-5 rounded-[2rem] border border-gray-100 bg-[#FFF5F7] p-5 text-left transition-all hover:-translate-y-0.5 hover:border-[#FFD700] hover:bg-white hover:shadow-xl sm:p-6">

        <div class="rounded-2xl bg-[#2C3E50] p-4 text-white shadow-lg transition-colors group-hover:bg-[#FFD700] group-hover:text-[#2C3E50]">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
        </div>

        <div>
            <p class="text-lg font-bold leading-none text-[#2C3E50]">
                Novo Cliente
            </p>
            <p class="mt-1 text-xs font-bold uppercase tracking-wider text-gray-400">
                Cadastro de sistema
            </p>
        </div>
    </button>
</div>