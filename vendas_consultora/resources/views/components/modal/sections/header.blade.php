<div class="relative overflow-hidden bg-[#2C3E50] px-8 py-7 sm:px-10">
    <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/5 blur-[40px]"></div>
    <div class="absolute -bottom-12 left-1/2 h-36 w-36 -translate-x-1/2 rounded-full bg-[#FFD700]/10 blur-[50px]"></div>

    <div class="relative z-10 flex items-start justify-between gap-4">
        <div>
            <div class="mb-2 inline-flex items-center gap-2 rounded-full border border-[#FFD700]/30 bg-[#FFD700]/10 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.25em] text-[#FFD700]">
                <span class="h-2 w-2 rounded-full bg-[#FFD700]"></span>
                Glow Database
            </div>

            <h2
                id="modal-title-{{ $id }}"
                class="text-2xl font-bold tracking-wide text-white"
                x-text="step === 'menu'
                    ? '{{ $title }}'
                    : (step === 'cadastro'
                        ? 'Novo Cadastro'
                        : (step === 'resultado'
                            ? 'Dossiê do Cliente'
                            : 'Atenção'))">
            </h2>

            <p class="mt-1 text-sm text-white/70">
                {{ $subtitle }}
            </p>
        </div>

        <button
            type="button"
            @click="closeModal()"
            class="rounded-2xl bg-white/10 p-3 text-white/80 transition hover:bg-white/20 hover:text-white">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>