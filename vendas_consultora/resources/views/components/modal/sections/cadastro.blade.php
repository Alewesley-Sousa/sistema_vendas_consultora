<div x-show="step === 'cadastro'" x-transition.opacity.duration.200ms class="space-y-4">
    <div class="relative">
        <label class="mb-1 ml-2 block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">
            Nome Completo
        </label>

        <input
            type="text"
            x-model="novoCliente.nome"
            class="w-full rounded-2xl border-2 px-5 py-3 font-semibold text-[#2C3E50] outline-none transition-all focus:bg-white focus:border-[#FFD700]"
            :class="errors.nome ? 'border-red-300 bg-red-50/40' : 'border-gray-100 bg-gray-50'">

        <p x-show="errors.nome" x-text="errors.nome[0]" class="mt-1 ml-2 text-[10px] font-bold text-red-500"></p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label class="mb-1 ml-2 block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">
                CPF
            </label>

            <input
                type="text"
                x-model="novoCliente.cpf"
                @input="formatCPF('novo')"
                maxlength="14"
                placeholder="000.000.000-00"
                class="w-full rounded-2xl border-2 px-5 py-3 font-semibold text-[#2C3E50] outline-none transition-all focus:border-[#FFD700]"
                :class="errors.cpf ? 'border-red-300 bg-red-50/40' : 'border-gray-100 bg-gray-50'">

            <p x-show="errors.cpf" x-text="errors.cpf[0]" class="mt-1 ml-2 text-[10px] font-bold text-red-500"></p>
        </div>

        <div>
            <label class="mb-1 ml-2 block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">
                Telefone
            </label>

            <input
                type="text"
                x-model="novoCliente.telefone"
                @input="formatTelefone()"
                maxlength="15"
                placeholder="(00) 00000-0000"
                class="w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-3 font-semibold text-[#2C3E50] outline-none transition-all focus:border-[#FFD700]">
        </div>
    </div>

    <div>
        <label class="mb-1 ml-2 block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">
            E-mail
        </label>

        <input
            type="email"
            x-model="novoCliente.email"
            class="w-full rounded-2xl border-2 px-5 py-3 font-semibold text-[#2C3E50] outline-none transition-all focus:border-[#FFD700]"
            :class="errors.email ? 'border-red-300 bg-red-50/40' : 'border-gray-100 bg-gray-50'">

        <p x-show="errors.email" x-text="errors.email[0]" class="mt-1 ml-2 text-[10px] font-bold text-red-500"></p>
    </div>

    <div>
        <label class="mb-1 ml-2 block text-[10px] font-bold uppercase tracking-[0.2em] text-gray-400">
            CEP
        </label>

        <input
            type="text"
            x-model="novoCliente.cep"
            @input="formatCEP()"
            maxlength="9"
            placeholder="00000-000"
            class="w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-3 font-semibold text-[#2C3E50] outline-none transition-all focus:border-[#FFD700]">
    </div>

    <button
        type="button"
        @click="cadastrar()"
        :disabled="loading"
        class="mt-2 flex w-full items-center justify-center gap-3 rounded-[1.5rem] bg-[#2C3E50] py-4 font-bold uppercase tracking-[0.2em] text-[#FFD700] shadow-xl transition-all hover:-translate-y-1 active:scale-95 disabled:cursor-not-allowed disabled:opacity-40">

        <span x-show="!loading">
            Finalizar Cadastro
        </span>

        <svg x-show="loading" class="h-5 w-5 animate-spin text-[#FFD700]" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </button>
</div>