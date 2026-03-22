import { UsuarioService } from '../../api/usuarios';
import { UIService } from '../../service/uiService';
import { MascaraService } from '../../service/mascaraService'; 

export function initFormUsuario() {
    const form = document.getElementById('form-usuario');
    if (!form) return;
    
    const btnSalvar = document.getElementById('btn-salvar');
    const id = window.usuarioId; 
    const cargoLogado = window.authCargo;

    // Seletores (Devem bater com os IDs no Blade)
    const inputCpf = document.getElementById('input-cpf');
    const inputTelefone = document.getElementById('input-telefone');
    const inputCep = document.getElementById('input-cep');

    // --- 1. ESCUTADORES PARA MÁSCARAS ---
    inputCpf?.addEventListener('input', (e) => e.target.value = MascaraService.cpf(e.target.value));
    inputTelefone?.addEventListener('input', (e) => e.target.value = MascaraService.telefone(e.target.value));
    inputCep?.addEventListener('input', (e) => e.target.value = MascaraService.cep(e.target.value));

    // --- 2. CARREGAMENTO (MODO EDIÇÃO) ---
    async function carregarEdicao() {
        if (cargoLogado !== 'distribuidora' && id) {
            window.location.href = '/consultora/dashboard';
            return;
        }

        if (!id) return;

        UIService.show();
        try {
            const response = await UsuarioService.pegarUsuario(id);
            const u = response.data;

            form.nome.value = u.nome;
            form.email.value = u.email;
            if (form.cargo) form.cargo.value = u.cargo;
            if (form.status_id) form.status_id.value = u.status_id;
            
            // Aplica máscara no que vem do banco
            form.cpf.value = MascaraService.cpf(u.cpf);
            form.telefone.value = MascaraService.telefone(u.telefone || '');
            form.cep.value = MascaraService.cep(u.cep || '');

        } catch (err) {
            console.error(err);
            alert("Erro ao carregar dados do usuário.");
        } finally {
            UIService.hide();
        }
    }

    // --- 3. ENVIO DO FORMULÁRIO ---
    form.addEventListener('submit', async (e) => {
        e.preventDefault(); 
        UIService.show();
        btnSalvar.disabled = true;

        const payload = {
            nome: form.nome.value,
            email: form.email.value,
            cpf: form.cpf.value.replace(/\D/g, ''),
            telefone: form.telefone.value.replace(/\D/g, ''), 
            cep: form.cep.value.replace(/\D/g, ''),
            status_id: document.getElementById('status_id').value,
            ...(form.cargo && { cargo: form.cargo.value }),
            ...(form.senha.value && { senha: form.senha.value })
        };

        try {
            const res = await UsuarioService.salvar(payload, id);
            alert(res.messagem || "Dados salvos com sucesso!");
            window.location.href = '/consultora/dashboard'; 
        } catch (err) {
            if (err.errors) {
                const msg = Object.values(err.errors).flat().join('\n');
                alert("Verifique os erros:\n" + msg);
            } else {
                alert(err.messagem || "Erro ao salvar.");
            }
        } finally {
            UIService.hide();
            btnSalvar.disabled = false;
        }
    });

    carregarEdicao();
}