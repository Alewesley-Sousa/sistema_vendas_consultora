@props(['id', 'title', 'subtitle'])

<div
    x-data="{
        open: false,
        step: 'menu',
        cpf: '',
        loading: false,
        clienteData: null,
        novoCliente: {
            nome: '',
            email: '',
            telefone: '',
            cep: '',
            cpf: ''
        },
        errors: {},

        openModal() {
            this.resetModal()
            this.open = true
            document.body.classList.add('overflow-hidden')
        },

        closeModal() {
            this.open = false
            this.resetModal()
            document.body.classList.remove('overflow-hidden')
        },

        // Validação Matemática de CPF (Módulo 11)
        isCPFValido(cpf) {
            cpf = cpf.replace(/\D/g, '');
            if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;

            let soma = 0, resto;
            for (let i = 1; i <= 9; i++) soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
            resto = (soma * 10) % 11;
            if ((resto === 10) || (resto === 11)) resto = 0;
            if (resto !== parseInt(cpf.substring(9, 10))) return false;

            soma = 0;
            for (let i = 1; i <= 10; i++) soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
            resto = (soma * 10) % 11;
            if ((resto === 10) || (resto === 11)) resto = 0;
            if (resto !== parseInt(cpf.substring(10, 11))) return false;

            return true;
        },

        // Máscara de CPF
        formatCPF(field = 'cpf') {
            let target = field === 'cpf' ? this : this.novoCliente;
            let v = target.cpf.replace(/\D/g, '');
            if (v.length > 11) v = v.slice(0, 11);

            if (v.length <= 3) {
                target.cpf = v;
            } else if (v.length <= 6) {
                target.cpf = v.replace(/^(\d{3})(\d{0,3})/, '$1.$2');
            } else if (v.length <= 9) {
                target.cpf = v.replace(/^(\d{3})(\d{3})(\d{0,3})/, '$1.$2.$3');
            } else {
                target.cpf = v.replace(/^(\d{3})(\d{3})(\d{3})(\d{0,2})/, '$1.$2.$3-$4');
            }
        },

        formatTelefone() {
            let v = this.novoCliente.telefone.replace(/\D/g, '');
            if (v.length > 11) v = v.slice(0, 11);

            if (v.length > 10) {
                this.novoCliente.telefone = v.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
            } else if (v.length > 5) {
                this.novoCliente.telefone = v.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
            } else if (v.length > 2) {
                this.novoCliente.telefone = v.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
            } else {
                this.novoCliente.telefone = v;
            }
        },

        formatCEP() {
            let v = this.novoCliente.cep.replace(/\D/g, '');
            if (v.length > 8) v = v.slice(0, 8);
            this.novoCliente.cep = v.replace(/^(\d{5})(\d{3})/, '$1-$2');
        },

        maskCPF(value) {
            if (!value) return 'N/A';
            let clean = value.replace(/\D/g, '');
            return clean.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
        },

        validarFormulario() {
            this.errors = {};

            if (!this.novoCliente.nome?.trim()) {
                this.errors.nome = ['O nome é obrigatório'];
            }

            if (this.novoCliente.cpf.length < 14) {
                this.errors.cpf = ['CPF incompleto'];
            } else if (!this.isCPFValido(this.novoCliente.cpf)) {
                this.errors.cpf = ['Este CPF é inválido!'];
            }

            if (!this.novoCliente.email?.includes('@')) {
                this.errors.email = ['E-mail inválido'];
            }

            return Object.keys(this.errors).length === 0;
        },

        async consultar() {
            let cleanCPF = this.cpf.replace(/\D/g, '');
            if (cleanCPF.length < 11) return;

            this.loading = true;
            this.clienteData = null;
            this.errors = {};

            try {
                const token = localStorage.getItem('auth_token');
                const response = await fetch(`/api/cliente/${cleanCPF}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': token ? `Bearer ${token}` : ''
                    }
                });

                const result = await response.json();

                if (response.ok && (result.status === 'success' || result.data)) {
                    this.clienteData = result.data || result;
                    this.step = 'resultado';
                    this.cpf = '';
                } else {
                    this.errors.message = result.message || 'Cliente não encontrado.';
                    this.step = 'erro';
                }
            } catch (error) {
                console.error('Erro na consulta:', error);
                this.errors.message = 'Falha ao consultar o cliente.';
                this.step = 'erro';
            } finally {
                this.loading = false;
            }
        },

        async cadastrar() {
            if (!this.validarFormulario()) return;

            this.loading = true;
            this.errors = {};

            const token = localStorage.getItem('auth_token');

            const dadosParaEnviar = {
                ...this.novoCliente,
                cpf: this.novoCliente.cpf.replace(/\D/g, ''),
                cep: this.novoCliente.cep.replace(/\D/g, ''),
                telefone: this.novoCliente.telefone.replace(/\D/g, '')
            };

            try {
                const response = await fetch('/api/cliente', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': token ? `Bearer ${token}` : '',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    },
                    body: JSON.stringify(dadosParaEnviar)
                });

                const result = await response.json();

                if (response.ok) {
                    this.clienteData = result.data || result;
                    this.step = 'resultado';
                    this.resetFormulario();
                } else {
                    this.errors = result.errors || { message: result.message || 'Erro ao processar cadastro' };
                    if (!result.errors || response.status !== 422) {
                        this.step = 'erro';
                    }
                }
            } catch (error) {
                console.error('Erro no cadastro:', error);
                this.errors.message = 'Falha ao cadastrar o cliente.';
                this.step = 'erro';
            } finally {
                this.loading = false;
            }
        },

        resetFormulario() {
            this.novoCliente = {
                nome: '',
                email: '',
                telefone: '',
                cep: '',
                cpf: ''
            };
            this.cpf = '';
            this.errors = {};
        },

        resetModal() {
            this.step = 'menu';
            this.resetFormulario();
            this.loading = false;
            this.clienteData = null;
            this.errors = {};
        }
    }"
    x-show="open"
    @open-modal-{{ $id }}.window="openModal()"
    @close-modal.window="closeModal()"
    @keydown.escape.window="closeModal()"
    x-cloak
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-title-{{ $id }}"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4">

    <!-- Backdrop -->
    <div
        x-show="open"
        x-transition.opacity.duration.300ms
        @click="closeModal()"
        class="fixed inset-0 bg-[#0F1722]/70 backdrop-blur-md">
    </div>

    <!-- Panel -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-6"
        class="relative z-10 w-full max-w-2xl overflow-hidden rounded-[2.5rem] border border-white/20 bg-white shadow-[0_30px_70px_rgba(0,0,0,0.35)]">

        <!-- Header -->
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

        <!-- Content -->
        <div class="max-h-[70vh] overflow-y-auto bg-white px-6 py-6 sm:px-8 sm:py-8">
            
            <!-- MENU -->
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

            <!-- CONSULTA -->
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

            <!-- CADASTRO -->
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

            <!-- RESULTADO -->
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

                            <div class="relative z-10 mb-8 flex items-start justify-between">
                                <div>
                                    <p class="mb-1 text-[10px] font-bold uppercase tracking-[0.3em] text-[#FFD700]">
                                        Nome Completo
                                    </p>
                                    <h4 class="text-2xl font-bold">
                                        {{ !true }}
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

            <!-- ERRO -->
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
        </div>

        <!-- Footer -->
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
    </div>
</div>