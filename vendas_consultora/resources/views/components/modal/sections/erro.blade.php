<div x-show="step === 'erro'" x-transition.opacity.duration.200ms class="py-8 text-center">
    <div class="mx-auto mb-6 inline-flex rounded-full bg-red-50 p-5 text-red-500">
        <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
    </div>

    <h3 class="mb-2 text-xl font-bold text-[#2C3E50]">
        Ops! Algo deu errado
    </h3>

    <p class="mb-8 text-sm text-gray-400" x-text="errors.message || 'O registro não foi encontrado ou ocorreu uma falha no sistema.'"></p>

    <div class="flex flex-col gap-3 sm:flex-row">
        <button
            type="button"
            @click="step = 'form'"
            class="w-full rounded-xl bg-[#2C3E50] py-4 font-bold text-white transition-all hover:opacity-95">
            Tentar Novamente
        </button>

        <button
            type="button"
            @click="step = 'cadastro'"
            class="w-full rounded-xl border-2 border-[#2C3E50] py-4 font-bold text-[#2C3E50] transition-all hover:bg-[#2C3E50] hover:text-white">
            Ir para Cadastro
        </button>
    </div>
</div>