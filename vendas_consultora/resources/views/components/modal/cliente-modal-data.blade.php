<script>
    function clienteModalData() {
        return {
            open: false,
            step: 'menu',
            cpf: '',
            loading: false,
            clienteData: null,
            errors: {},
            novoCliente: {
                nome: '',
                email: '',
                telefone: '',
                cep: '',
                cpf: ''
            },

            openModal() {
                this.resetModal();
                this.open = true;
                document.body.classList.add('overflow-hidden');
            },

            closeModal() {
                this.open = false;
                this.resetModal();
                document.body.classList.remove('overflow-hidden');
            },

            isCPFValido(cpf) {
                cpf = cpf.replace(/\D/g, '');
                if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;

                let soma = 0, resto;

                for (let i = 1; i <= 9; i++) {
                    soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
                }

                resto = (soma * 10) % 11;
                if ((resto === 10) || (resto === 11)) resto = 0;
                if (resto !== parseInt(cpf.substring(9, 10))) return false;

                soma = 0;

                for (let i = 1; i <= 10; i++) {
                    soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
                }

                resto = (soma * 10) % 11;
                if ((resto === 10) || (resto === 11)) resto = 0;
                if (resto !== parseInt(cpf.substring(10, 11))) return false;

                return true;
            },

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
        }
    }
</script>