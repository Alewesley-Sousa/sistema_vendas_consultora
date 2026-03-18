// resources/js/pages/atualizar-senha.js
import { ResetarSenhaService } from '../api/resetarSenha';

export function initAtualizarSenha() {
    const form = document.getElementById('formAtualizarSenha');
    if (!form) return;

    const btn = document.getElementById('btnResetar');
    const msgDiv = document.getElementById('msg-feedback');
    const errorList = document.getElementById('error-list');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Reset de interface
        btn.disabled = true;
        btn.innerText = 'Processando...';
        msgDiv.classList.add('hidden');
        errorList.innerHTML = '';

        const payload = {
            token: document.getElementsByName('token')[0].value,
            email: document.getElementsByName('email')[0].value,
            password: document.getElementById('password').value,
            password_confirmation: document.getElementById('password_confirmation').value
        };

        try {
            const res = await ResetarSenhaService.resetar(payload);
            
            // Sucesso! Mostramos a mensagem e redirecionamos após 2 segundos
            msgDiv.innerText = res.message;
            msgDiv.className = 'mb-4 p-3 rounded bg-green-50 text-green-700';
            msgDiv.classList.remove('hidden');

            setTimeout(() => {
                window.location.href = res.redirect;
            }, 2000);

        } catch (err) {
            btn.disabled = false;
            btn.innerText = 'Redefinir senha';
            msgDiv.className = 'mb-4 p-3 rounded bg-red-50 text-red-700';
            msgDiv.classList.remove('hidden');

            // Se o Laravel retornar erros de validação específicos
            if (err.errors) {
                Object.values(err.errors).forEach(messages => {
                    messages.forEach(m => {
                        const li = document.createElement('li');
                        li.innerText = m;
                        errorList.appendChild(li);
                    });
                });
            } else {
                msgDiv.innerText = err.message || 'Erro ao redefinir senha.';
            }
        }
    });
}