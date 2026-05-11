<div x-data="cadastroConsultora()" 
     x-show="open" 
     x-on:abrir-modal-cadastro.window="open = true"
     class="fixed inset-0 z-50 overflow-y-auto" 
     style="display: none;">
    
    {{-- Overlay com animação de fade --}}
    <div class="fixed inset-0 bg-[#2C3E50]/80 backdrop-blur-sm transition-opacity"
         x-show="open"
         x-transition:enter="transition opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"></div>

    {{-- Modal com escala e mola --}}
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 scale-90 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="bg-white w-full max-w-2xl rounded-[3rem] shadow-2xl overflow-hidden relative">
            
            {{-- Header do Modal --}}
            <div class="bg-[#2C3E50] p-8 text-white relative">
                <button @click="open = false" class="absolute top-6 right-6 text-white/50 hover:text-white transition-transform hover:rotate-90 duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="border-l-4 border-[#FF7665] pl-4 animate-pulse">
                    <h2 class="text-2xl font-serif font-bold tracking-tight">Nova Consultora</h2>
                    <p class="text-xs uppercase tracking-widest text-[#FF7665] font-bold">Passo <span x-text="step"></span> de 3</p>
                </div>

                {{-- Progress Bar Dinâmica --}}
                <div class="flex gap-2 mt-6">
                    <template x-for="i in 3">
                        <div class="h-1.5 flex-1 rounded-full transition-all duration-700" 
                             :class="step >= i ? 'bg-[#FF7665] shadow-[0_0_10px_#FF7665]' : 'bg-white/10'"></div>
                    </template>
                </div>
            </div>

            {{-- Formulário --}}
            <div class="p-10">
                <form @submit.prevent="submitForm">
                    
                    {{-- ETAPA 1: Dados Básicos --}}
                    <div x-show="step === 1" 
                         x-transition:enter="transition ease-out duration-400 delay-200"
                         x-transition:enter-start="opacity-0 translate-x-8"
                         x-transition:enter-end="opacity-100 translate-x-0">
                        <h3 class="text-lg font-bold text-[#2C3E50] mb-6 flex items-center gap-2">
                            <span class="bg-[#FFF9F9] text-[#FF7665] w-8 h-8 rounded-lg flex items-center justify-center shadow-sm">01</span>
                            Informações Pessoais
                        </h3>
                        <div class="space-y-4">
                            <div class="group">
                                <label class="block text-[10px] uppercase font-black text-gray-400 mb-1 ml-2 transition-colors group-focus-within:text-[#FF7665]">Nome Completo</label>
                                <input type="text" x-model="formData.nome" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#FF7665]/20 text-sm transition-all" placeholder="Ex: Maria Silva">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] uppercase font-black text-gray-400 mb-1 ml-2">CPF (11 números)</label>
                                    <input type="text" x-model="formData.cpf" @input="mascaraCPF" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#FF7665]/20 text-sm transition-all" placeholder="000.000.000-00">
                                </div>
                                <div>
                                    <label class="block text-[10px] uppercase font-black text-gray-400 mb-1 ml-2">WhatsApp</label>
                                    <input type="text" x-model="formData.telefone" @input="mascaraTelefone" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#FF7665]/20 text-sm transition-all" placeholder="(85) 9 0000-0000">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase font-black text-gray-400 mb-1 ml-2">CEP (8 números)</label>
                                <input type="text" x-model="formData.cep" @input="mascaraCEP" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#FF7665]/20 text-sm transition-all" placeholder="00000-000">
                            </div>
                        </div>
                    </div>

                    {{-- ETAPA 2: Acesso --}}
                    <div x-show="step === 2" 
                         x-transition:enter="transition ease-out duration-400"
                         x-transition:enter-start="opacity-0 translate-x-8"
                         x-transition:enter-end="opacity-100 translate-x-0">
                        <h3 class="text-lg font-bold text-[#2C3E50] mb-6 flex items-center gap-2">
                            <span class="bg-[#FFF9F9] text-[#FF7665] w-8 h-8 rounded-lg flex items-center justify-center shadow-sm">02</span>
                            Dados de Acesso
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] uppercase font-black text-gray-400 mb-1 ml-2">E-mail Profissional</label>
                                <input type="email" x-model="formData.email" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#FF7665]/20 text-sm transition-all" placeholder="consultora@glow.com">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase font-black text-gray-400 mb-1 ml-2">Senha Inicial</label>
                                <input type="password" x-model="formData.senha" class="w-full bg-gray-50 border-none rounded-2xl p-4 focus:ring-2 focus:ring-[#FF7665]/20 text-sm transition-all" placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    {{-- ETAPA 3: Confirmação --}}
                    <div x-show="step === 3" 
                         x-transition:enter="transition ease-out duration-400"
                         x-transition:enter-start="opacity-0 translate-x-8"
                         x-transition:enter-end="opacity-100 translate-x-0">
                        <h3 class="text-lg font-bold text-[#2C3E50] mb-6 flex items-center gap-2">
                            <span class="bg-[#FFF9F9] text-[#FF7665] w-8 h-8 rounded-lg flex items-center justify-center shadow-sm">03</span>
                            Finalizar Pré-Cadastro
                        </h3>
                        <div class="p-6 bg-[#FFF9F9] rounded-[2rem] border border-[#FF7665]/10 mb-6 hover:shadow-inner transition-all">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="bg-[#FF7665] text-white p-3 rounded-xl animate-bounce">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-[#2C3E50] text-sm">Quase lá!</h4>
                                    <p class="text-[10px] text-gray-500 uppercase tracking-tighter">O cadastro ficará pendente de aprovação.</p>
                                </div>
                            </div>
                            <div class="space-y-2 border-t border-gray-100 pt-4">
                                <p class="text-xs text-gray-600"><strong>Nome:</strong> <span x-text="formData.nome" class="text-[#2C3E50] font-medium"></span></p>
                                <p class="text-xs text-gray-600"><strong>WhatsApp:</strong> <span x-text="formData.telefone" class="text-[#2C3E50] font-medium"></span></p>
                                <p class="text-xs text-gray-600"><strong>Indicada por:</strong> <span class="text-[#2C3E50] font-medium">{{ Auth::user()->nome }}</span></p>
                                <p class="text-xs text-gray-600"><strong>Status:</strong> <span class="text-[#FF7665] font-bold">Aguardando Aprovação</span></p>
                            </div>
                        </div>
                    </div>

                    {{-- Botões de Navegação --}}
                    <div class="flex justify-between mt-10">
                        <button type="button" x-show="step > 1" @click="step--" class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-[#2C3E50] transition-all transform hover:-translate-x-1">
                            Voltar
                        </button>
                        <div class="flex-1"></div>
                        
                        {{-- Botão Próximo --}}
                        <button type="button" x-show="step < 3" @click="step++" 
                                class="bg-[#2C3E50] text-white px-10 py-4 rounded-2xl shadow-xl font-bold text-xs uppercase tracking-widest hover:bg-[#1a252f] hover:shadow-[#2C3E50]/20 transition-all transform hover:scale-105 active:scale-95">
                            Próximo Passo
                        </button>

                        {{-- Botão Concluir --}}
                        <button type="submit" x-show="step === 3" :disabled="loading" 
                                class="bg-[#FF7665] text-white px-10 py-4 rounded-2xl shadow-lg shadow-[#FF7665]/30 font-bold text-xs uppercase tracking-widest hover:bg-[#ff6450] transition-all transform hover:scale-105 active:scale-95 disabled:opacity-50 disabled:scale-100">
                            <span x-show="!loading">Concluir Pré-Cadastro</span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Processando...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function cadastroConsultora() {
        return {
            open: false,
            step: 1,
            loading: false,
            formData: {
                nome: '',
                cpf: '',
                telefone: '',
                cep: '',
                email: '',
                senha: '',
                status_id: 3,
                cargo: 'consultora'
            },

            mascaraCPF(e) {
                let v = e.target.value.replace(/\D/g, '').slice(0, 11);
                if (v.length > 9) v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
                else if (v.length > 6) v = v.replace(/(\d{3})(\d{3})(\d{3})/, "$1.$2.$3");
                else if (v.length > 3) v = v.replace(/(\d{3})(\d{3})/, "$1.$2");
                this.formData.cpf = v;
            },

            mascaraCEP(e) {
                let v = e.target.value.replace(/\D/g, '').slice(0, 8);
                if (v.length > 5) v = v.replace(/(\d{5})(\d{3})/, "$1-$2");
                this.formData.cep = v;
            },

            mascaraTelefone(e) {
                let v = e.target.value.replace(/\D/g, '').slice(0, 11);
                if (v.length > 10) v = v.replace(/^(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
                else if (v.length > 2) v = v.replace(/^(\d{2})(\d{0,5})/, "($1) $2");
                this.formData.telefone = v;
            },

            async submitForm() {
                this.loading = true;
                
                const cleanData = {
                    ...this.formData,
                    cpf: this.formData.cpf.replace(/\D/g, ''),
                    cep: this.formData.cep.replace(/\D/g, ''),
                    telefone: this.formData.telefone.replace(/\D/g, '')
                };
                
                try {
                    const token = localStorage.getItem('auth_token');
                    
                    const response = await axios.post('/api/usuario', cleanData, {
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    
                    if (response.data.status === 'success') {
                        await Swal.fire({
                            title: 'Tudo pronto!',
                            text: 'Cadastro realizado com sucesso.',
                            icon: 'success',
                            confirmButtonColor: '#2C3E50',
                            showClass: { popup: 'animate__animated animate__fadeInUp' }
                        });
                        this.open = false;
                        this.resetForm();
                        window.location.reload();
                    }
                } catch (e) {
                    let mensagemErro = 'Erro ao processar.';
                    if (e.response?.status === 422) {
                        mensagemErro = Object.values(e.response.data.errors).flat().join('<br>');
                    }
                    Swal.fire({ title: 'Atenção', html: mensagemErro, icon: 'error', confirmButtonColor: '#FF7665' });
                } finally {
                    this.loading = false;
                }
            },

            resetForm() {
                this.step = 1;
                this.formData = { nome: '', cpf: '', telefone: '', cep: '', email: '', senha: '', status_id: 3, cargo: 'consultora' };
            }
        }
    }
</script>
