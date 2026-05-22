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

        // Validação Matemática de CPF (Módulo 11)
        isCPFValido(cpf) {
            cpf = cpf.replace(/\D/g, '');
            if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;
            
            let soma = 0, resto;
            for (let i = 1; i <= 9; i++) soma += parseInt(cpf.substring(i-1, i)) * (11 - i);
            resto = (soma * 10) % 11;
            if ((resto === 10) || (resto === 11)) resto = 0;
            if (resto !== parseInt(cpf.substring(9, 10))) return false;
            
            soma = 0;
            for (let i = 1; i <= 10; i++) soma += parseInt(cpf.substring(i-1, i)) * (12 - i);
            resto = (soma * 10) % 11;
            if ((resto === 10) || (resto === 11)) resto = 0;
            if (resto !== parseInt(cpf.substring(10, 11))) return false;
            
            return true;
        },

        // Formatação de CPF com máscara dinâmica
        formatCPF(field = 'cpf') {
            let target = field === 'cpf' ? this : this.novoCliente;
            let v = target.cpf.replace(/\D/g, '');
            if (v.length > 11) v = v.slice(0, 11);
            target.cpf = v.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4')
                         .replace(/-$/, '')
                         .replace(/\.$/, '');
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
            if (!this.novoCliente.nome) this.errors.nome = ['O nome é obrigatório'];
            
            // Validação rigorosa no cadastro: Tamanho + Algoritmo
            if (this.novoCliente.cpf.length < 14) {
                this.errors.cpf = ['CPF incompleto'];
            } else if (!this.isCPFValido(this.novoCliente.cpf)) {
                this.errors.cpf = ['Este CPF é invalido!'];
            }

            if (!this.novoCliente.email.includes('@')) this.errors.email = ['E-mail inválido'];
            return Object.keys(this.errors).length === 0;
        },

        async consultar() {
            let cleanCPF = this.cpf.replace(/\D/g, '');
            // Consulta flexível: apenas checa se tem os 11 números
            if(cleanCPF.length < 11) return;

            this.loading = true;
            this.clienteData = null;

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
                    this.step = 'erro';
                }
            } catch (error) {
                console.error('Erro na consulta:', error);
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
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']')?.getAttribute('content')
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
                    if (!result.errors || response.status !== 422) this.step = 'erro';
                }
            } catch (error) {
                this.step = 'erro';
            } finally {
                this.loading = false;
            }
        },

        resetFormulario() {
            this.novoCliente = { nome: '', email: '', telefone: '', cep: '', cpf: '' };
            this.cpf = '';
            this.errors = {};
        },

        resetModal() {
            this.step = 'menu';
            this.resetFormulario();
            this.loading = false;
            this.clienteData = null;
        }
    }"
    x-show="open"
    @open-modal-{{ $id }}.window="open = true; resetModal()"
    @close-modal.window="open = false"
    @keydown.escape.window="open = false"
    x-cloak
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 font-['Rotis_Sans_Serif',_sans-serif]">

    <div x-show="open" x-transition.opacity @click="open = false" class="fixed inset-0 bg-[#2C3E50]/80 backdrop-blur-md"></div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        class="relative w-full max-w-lg bg-white rounded-[3rem] overflow-hidden border border-[#2C3E50]/20 shadow-[0_30px_70px_rgba(0,0,0,0.4)]">
        
        <div class="bg-[#2C3E50] px-10 py-10 flex items-center justify-between relative overflow-hidden">
            <div class="absolute -right-2 -top-2 w-40 h-40 bg-white/5 rounded-full blur-[40px]"></div>
            <div class="relative z-10">
                <h2 class="text-2xl font-bold text-white font-['The_Seasons',_serif] tracking-wide" x-text="step === 'menu' ? '{{ $title }}' : (step === 'cadastro' ? 'Novo Cadastro' : (step === 'resultado' ? 'Dossiê do Cliente' : 'Atenção'))"></h2>
                <p class="text-sm text-[#FFD700] font-bold uppercase tracking-[0.25em] mt-1.5 opacity-80">Glow Database</p>
            </div>
            <button @click="open = false" class="relative z-20 p-3 bg-white/10 rounded-2xl text-white/70 hover:bg-white/20 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="px-10 py-10 bg-white min-h-[400px] flex flex-col">
            
            <div x-show="step === 'menu'" x-transition class="space-y-4">
                <button @click="step = 'form'" class="w-full flex items-center gap-5 p-6 rounded-[2rem] border border-gray-100 bg-gray-50/50 hover:bg-white hover:border-[#FFD700] hover:shadow-xl transition-all group text-left">
                    <div class="p-4 bg-[#2C3E50] text-white rounded-2xl group-hover:bg-[#FFD700] group-hover:text-[#2C3E50] transition-colors shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <div>
                        <p class="font-bold text-[#2C3E50] text-lg leading-none">Consultar CPF</p>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-1">Busca instantânea</p>
                    </div>
                </button>

                <button @click="step = 'cadastro'" class="w-full flex items-center gap-5 p-6 rounded-[2rem] border border-gray-100 bg-gray-50/50 hover:bg-white hover:border-[#FFD700] hover:shadow-xl transition-all group text-left">
                    <div class="p-4 bg-[#2C3E50] text-white rounded-2xl group-hover:bg-[#FFD700] group-hover:text-[#2C3E50] transition-colors shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    </div>
                    <div>
                        <p class="font-bold text-[#2C3E50] text-lg leading-none">Novo Cliente</p>
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mt-1">Cadastro de sistema</p>
                    </div>
                </button>
            </div>

            <div x-show="step === 'form'" x-transition class="text-center">
                <h3 class="text-xl font-bold text-[#2C3E50] mb-6 font-['The_Seasons',_serif]">Identificação do Cliente</h3>
                <input type="text" x-model="cpf" @input="formatCPF('cpf')" @keydown.enter="consultar()" placeholder="000.000.000-00" class="w-full bg-gray-50 border-2 border-gray-100 rounded-2xl px-6 py-5 text-2xl text-center font-bold tracking-widest text-[#2C3E50] focus:border-[#2C3E50] focus:bg-white outline-none transition-all mb-6 shadow-inner">
                <button @click="consultar()" :disabled="cpf.length < 14 || loading" class="w-full bg-[#2C3E50] text-[#FFD700] py-5 rounded-2xl font-bold uppercase tracking-[0.2em] shadow-lg hover:shadow-[#2C3E50]/20 hover:-translate-y-1 transition-all disabled:opacity-30 flex justify-center items-center gap-3">
                    <span x-show="!loading">Confirmar Consulta</span>
                    <svg x-show="loading" class="animate-spin h-5 w-5 text-[#FFD700]" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>

            <div x-show="step === 'cadastro'" x-transition class="space-y-4">
                <div class="relative">
                    <label class="text-[10px] font-bold uppercase text-gray-400 tracking-[0.2em] ml-2 mb-1 block">Nome Completo</label>
                    <input type="text" x-model="novoCliente.nome" class="w-full bg-gray-50 border-2 rounded-2xl px-5 py-3 text-[#2C3E50] font-semibold focus:bg-white focus:border-[#FFD700] outline-none transition-all" :class="errors.nome ? 'border-red-300' : 'border-gray-100'">
                    <p x-show="errors.nome" x-text="errors.nome[0]" class="text-red-500 text-[10px] mt-1 ml-2 font-bold"></p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-bold uppercase text-gray-400 tracking-[0.2em] ml-2 mb-1 block">CPF</label>
                        <input type="text" x-model="novoCliente.cpf" @input="formatCPF('novo')" placeholder="000.000.000-00" class="w-full bg-gray-50 border-2 rounded-2xl px-5 py-3 text-[#2C3E50] font-semibold focus:border-[#FFD700] outline-none transition-all" :class="errors.cpf ? 'border-red-300' : 'border-gray-100'">
                        <p x-show="errors.cpf" x-text="errors.cpf[0]" class="text-red-500 text-[10px] mt-1 ml-2 font-bold"></p>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold uppercase text-gray-400 tracking-[0.2em] ml-2 mb-1 block">Telefone</label>
                        <input type="text" x-model="novoCliente.telefone" @input="formatTelefone()" placeholder="(00) 00000-0000" class="w-full bg-gray-50 border-2 rounded-2xl px-5 py-3 text-[#2C3E50] font-semibold focus:border-[#FFD700] outline-none transition-all border-gray-100">
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-bold uppercase text-gray-400 tracking-[0.2em] ml-2 mb-1 block">E-mail</label>
                    <input type="email" x-model="novoCliente.email" class="w-full bg-gray-50 border-2 rounded-2xl px-5 py-3 text-[#2C3E50] font-semibold focus:border-[#FFD700] outline-none transition-all" :class="errors.email ? 'border-red-300' : 'border-gray-100'">
                    <p x-show="errors.email" x-text="errors.email[0]" class="text-red-500 text-[10px] mt-1 ml-2 font-bold"></p>
                </div>

                <div>
                    <label class="text-[10px] font-bold uppercase text-gray-400 tracking-[0.2em] ml-2 mb-1 block">CEP</label>
                    <input type="text" x-model="novoCliente.cep" @input="formatCEP()" placeholder="00000-000" class="w-full bg-gray-50 border-2 rounded-2xl px-5 py-3 text-[#2C3E50] font-semibold focus:border-[#FFD700] outline-none transition-all border-gray-100">
                </div>

                <button @click="cadastrar()" :disabled="loading" class="w-full bg-[#2C3E50] text-[#FFD700] py-4 mt-2 rounded-[1.5rem] font-bold uppercase tracking-[0.2em] shadow-xl hover:-translate-y-1 active:scale-95 transition-all flex justify-center items-center gap-3">
                    <span x-show="!loading">Finalizar Cadastro</span>
                    <svg x-show="loading" class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </div>

            <div x-show="step === 'resultado'" x-transition>
                <template x-if="clienteData">
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 p-4 bg-green-50 rounded-2xl border border-green-100 mb-6">
                            <div class="bg-green-500 text-white p-2 rounded-full"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg></div>
                            <p class="text-green-800 font-bold text-xs uppercase tracking-widest">Ação Realizada com Sucesso</p>
                        </div>

                        <div class="relative bg-[#2C3E50] rounded-[2rem] p-8 text-white overflow-hidden shadow-2xl">
                            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-[#FFD700]/10 rounded-full blur-3xl"></div>
                            <div class="flex justify-between items-start mb-8 relative z-10">
                                <div>
                                    <p class="text-[#FFD700] text-[10px] font-bold uppercase tracking-[0.3em] mb-1">Nome Completo</p>
                                    <h4 class="text-2xl font-bold font-['The_Seasons',_serif]" x-text="clienteData.nome"></h4>
                                </div>
                                <div class="bg-white/10 px-3 py-1 rounded-lg border border-white/10 text-center min-w-[80px]">
                                    <p class="text-[9px] font-bold opacity-60 uppercase tracking-tighter">ID</p>
                                    <p class="text-xs font-mono font-bold text-[#FFD700]" x-text="`#${clienteData.id}`"></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-6 relative z-10">
                                <div>
                                    <p class="text-[#FFD700] text-[10px] font-bold uppercase tracking-[0.3em] mb-1">CPF Oficial</p>
                                    <p class="text-sm font-medium tracking-widest" x-text="maskCPF(clienteData.cpf)"></p>
                                </div>
                                <div>
                                    <p class="text-[#FFD700] text-[10px] font-bold uppercase tracking-[0.3em] mb-1">E-mail</p>
                                    <p class="text-sm font-medium truncate" x-text="clienteData.email"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div x-show="step === 'erro'" x-transition class="text-center py-10">
                <div class="inline-flex p-5 bg-red-50 text-red-500 rounded-full mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-[#2C3E50] mb-2">Ops! Algo deu errado</h3>
                <p class="text-gray-400 text-sm mb-8" x-text="errors.message || 'O registro não foi encontrado ou ocorreu uma falha no sistema.'"></p>
                <div class="flex flex-col gap-3">
                    <button @click="step = 'form'" class="w-full py-4 bg-[#2C3E50] text-white rounded-xl font-bold hover:opacity-95 transition-all">Tentar Novamente</button>
                    <button @click="step = 'cadastro'" class="w-full py-4 border-2 border-[#2C3E50] text-[#2C3E50] rounded-xl font-bold hover:bg-[#2C3E50] hover:text-white transition-all">Ir para Cadastro</button>
                </div>
            </div>
        </div>

        <div class="px-10 py-6 bg-gray-50 flex justify-between items-center border-t border-gray-100">
            <button x-show="step !== 'menu'" @click="step = 'menu'" class="flex items-center gap-2 text-xs font-bold text-[#2C3E50] uppercase tracking-widest hover:text-[#FFD700] transition-colors group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7" /></svg>
                Início
            </button>
            <button @click="open = false" class="text-[10px] font-bold text-gray-400 hover:text-red-500 uppercase tracking-[0.2em] ml-auto transition-all duration-300 flex items-center gap-2 group">
                Fechar Janela
            </button>
        </div>
    </div>
</div>
