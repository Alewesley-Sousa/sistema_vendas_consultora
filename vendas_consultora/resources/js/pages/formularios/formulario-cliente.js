import { ClienteService } from '../../api/cliente';
import { UIService } from '../../service/uiService';
import { MascaraService } from '../../service/mascaraService'; 

export function initFormCliente() {
    const form = document.getElementById('form-cliente');
    if (!form) return;
    const titulo = document.getElementById('titulo-pagina');
    const btnSalvar = document.getElementById('btn-salvar');
    const id = window.clienteId; 

    // Seletores dos campos para aplicação de máscaras em tempo real
    const inputCpf = document.getElementById('input-cpf');
    const inputTelefone = document.getElementById('input-telefone');
    const inputCep = document.getElementById('input-cep');

    // --- 1. ESCUTADORES DE EVENTOS PARA MÁSCARAS ---
    inputCpf?.addEventListener('input', (e) => {
        e.target.value = MascaraService.cpf(e.target.value);
    });

    inputTelefone?.addEventListener('input', (e) => {
        e.target.value = MascaraService.telefone(e.target.value);
    });

    inputCep?.addEventListener('input', (e) => {
        e.target.value = MascaraService.cep(e.target.value);
    });

    // --- 2. LÓGICA DE CARREGAMENTO (MODO EDIÇÃO) ---
    async function carregarEdicao() {
        if (!id) {
            titulo.innerText = "Novo Cliente";
            return;
        }

        titulo.innerText = "Editar Cliente";
        UIService.show();

        try {
            const response = await ClienteService.getCliente(id);
            const c = response.data;

            // Preenche os campos de texto simples
            form.nome.value = c.nome;
            form.email.value = c.email;
            
            // Preenche os campos que precisam de máscara (formatando o que vem do banco)
            form.cpf.value = MascaraService.cpf(c.cpf);
            form.telefone.value = MascaraService.telefone(c.telefone || '');
            form.cep.value = MascaraService.cep(c.cep || '');

        } catch (err) {
            console.error(err);
            alert("Erro ao carregar dados do cliente para edição.");
        } finally {
            UIService.hide();
        }
    }

    // --- 3. ENVIO DO FORMULÁRIO (CLEAN DATA) ---
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Bloqueia interações durante o processamento
        UIService.show();
        btnSalvar.disabled = true;

        // Montamos o payload garantindo que dados sensíveis vão sem máscara
        const payload = {
            nome: form.nome.value,
            email: form.email.value,
            // .replace(/\D/g, '') garante que apenas números cheguem ao backend
            cpf: form.cpf.value.replace(/\D/g, ''),
            telefone: form.telefone.value.replace(/\D/g, ''), 
            cep: form.cep.value.replace(/\D/g, '')
        };

        try {
            const res = await ClienteService.salvar(payload, id);
            
            // Mensagem de sucesso baseada na resposta do seu ClientesService
            alert(res.messagem || "Dados salvos com sucesso!");
            
            // Redireciona para a listagem ou dashboard
            window.location.href = '/consultora/dashboard'; 

        } catch (err) {
            // Tratamento de erros de validação (Status 422 do Laravel)
            if (err.errors) {
                const msg = Object.values(err.errors).flat().join('\n');
                alert("Verifique os seguintes erros:\n" + msg);
            } else {
                alert(err.messagem || "Ocorreu um erro ao tentar salvar o registro.");
            }
        } finally {
            UIService.hide();
            btnSalvar.disabled = false;
        }
    });

    // Inicializa o processo
    carregarEdicao();
}