<div x-show="step === 'resultado'" x-transition.opacity.duration.200ms>
    <template x-if="clienteData">
        <div class="space-y-4">
            <div class="mb-6 flex items-center gap-4 rounded-2xl border border-green-100 bg-green-50 p-4">
                <div class="rounded-full bg-green-500 p-2 text-white">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <p class="text-xs font-bold uppercase tracking-widest text-green-800">
                    Ação Realizada com Sucesso
                </p>
            </div>

            <div class="relative overflow-hidden rounded-[2rem] bg-[#2C3E50] p-8 text-white shadow-2xl">
                <div class="absolute -right-10 -bottom-10 h-40 w-40 rounded-full bg-[#FFD700]/10 blur-3xl"></div>

                <div class="relative z-10 mb-8 flex items-start justify-between gap-4">
                    <div>
                        <p class="mb-1 text-[10px] font-bold uppercase tracking-[0.3em] text-[#FFD700]">
                            Nome Completo
                        </p>
                        <h4 class="text-2xl font-bold">
                            <span x-text="clienteData.nome"></span>
                        </h4>
                    </div>

                    <div class="min-w-[80px] rounded-lg border border-white/10 bg-white/10 px-3 py-1 text-center">
                        <p class="text-[9px] font-bold uppercase tracking-tighter opacity-60">
                            ID
                        </p>
                        <p class="font-mono text-xs font-bold text-[#FFD700]" x-text="`#${clienteData.id}`"></p>
                    </div>
                </div>

                <div class="relative z-10 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <p class="mb-1 text-[10px] font-bold uppercase tracking-[0.3em] text-[#FFD700]">
                            CPF Oficial
                        </p>
                        <p class="text-sm font-medium tracking-widest" x-text="maskCPF(clienteData.cpf)"></p>
                    </div>

                    <div>
                        <p class="mb-1 text-[10px] font-bold uppercase tracking-[0.3em] text-[#FFD700]">
                            E-mail
                        </p>
                        <p class="truncate text-sm font-medium" x-text="clienteData.email"></p>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>