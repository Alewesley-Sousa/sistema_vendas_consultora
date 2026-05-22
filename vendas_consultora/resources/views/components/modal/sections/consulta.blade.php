<div x-show="step === 'form'" x-transition.opacity.duration.200ms class="text-center">
    <div class="mx-auto mb-4 h-1 w-20 rounded-full bg-gradient-to-r from-[#FF1493] to-[#FFD700]"></div>

    <h3 class="mb-6 text-2xl font-bold text-[#2C3E50]">
        Identificação do Cliente
    </h3>

    <input
        type="text"
        x-model="cpf"
        @input="formatCPF('cpf')"
        @keydown.enter.prevent="consultar()"
        maxlength="14"
        placeholder="000.000.000-00"
        class="mb-6 w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-6 py-5 text-center text-2xl font-bold tracking-widest text-[#2C3E50] outline-none transition-all focus:border-[#2C3E50] focus:bg-white focus:shadow-inner">

    <button
        type="button"
        @click="consultar()"
        :disabled="cpf.length < 14 || loading"
        class="flex w-full items-center justify-center gap-3 rounded-2xl bg-[#2C3E50] py-5 font-bold uppercase tracking-[0.2em] text-[#FFD700] shadow-lg transition-all hover:-translate-y-1 hover:shadow-[#2C3E50]/20 disabled:cursor-not-allowed disabled:opacity-30">

        <span x-show="!loading">
            Confirmar Consulta
        </span>

        <svg x-show="loading" class="h-5 w-5 animate-spin text-[#FFD700]" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </button>
</div>