import { ClienteService } from '../../api/cliente';
import { Masks } from '../../utils/marks.js'; 

export function initFormularioCliente() {
    if (!document.querySelector('[x-data="clienteForm"]')) return;

    window.Alpine.data('clienteForm', () => ({
        form: {
            nome: '',
            email: '',
            telefone: '',
            cpf: '',
            cep: ''
        },
        loading: false,
        toasts: [],
        masks: Masks,

        // Função rápida para remover tudo que não for número
        unmask(value) {
            return value ? value.replace(/\D/g, '') : '';
        },

        async submeter() {
            if (this.loading) return;
            this.loading = true;
            
            // Criamos uma cópia limpa para não estragar a visão do usuário enquanto envia
            const dadosParaEnvio = {
                ...this.form,
                telefone: this.unmask(this.form.telefone),
                cpf: this.unmask(this.form.cpf),
                cep: this.unmask(this.form.cep)
            };

            try {
                // Enviamos os dados limpos
                const res = await ClienteService.cadastrar(dadosParaEnvio);
                
                if (res.status === 'success') {
                    this.notify(res.messagem, 'success');
                    this.resetForm();
                }
            } catch (error) {
                const msg = error.messagem || error.message || 'Falha ao cadastrar';
                this.notify(msg, 'error');
            } finally {
                this.loading = false;
            }
        },

        resetForm() {
            this.form = { nome: '', email: '', telefone: '', cpf: '', cep: '' };
        },

        notify(message, type = 'success') {
    const id = Date.now();
    // Adiciona o toast
    this.toasts.push({ id, message, type, show: true });

    // Remove automaticamente após 4 segundos
    setTimeout(() => {
        const index = this.toasts.findIndex(t => t.id === id);
        if (index > -1) {
            this.toasts[index].show = false; // Inicia animação de saída
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id); // Remove do array
            }, 500); // Tempo da transição
        }
    }, 4000);
}


    }));
}
