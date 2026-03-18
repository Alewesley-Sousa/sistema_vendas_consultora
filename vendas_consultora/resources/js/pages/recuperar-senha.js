// resources/js/pages/recuperar-senha.js
import { ResetarSenhaService } from '../api/resetarSenha';

export function initRecuperarSenha() {
    const form = document.getElementById('formRecuperar');
    if (!form) return; // Garante que só roda se o form existir na página

    const msgDiv = document.getElementById('msg-feedback');
    const btn = document.getElementById('btnEnviar');
    const emailInput = document.getElementById('email_recuperar');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        btn.disabled = true;
        btn.innerText = 'Enviando...';
        msgDiv.classList.add('hidden');

        try {
            const res = await ResetarSenhaService.enviarLink(emailInput.value);
            
            msgDiv.innerText = res.message;
            msgDiv.className = 'mb-4 p-3 rounded bg-green-50 text-green-700';
            msgDiv.classList.remove('hidden');
            btn.innerText = 'Link Enviado!';
        } catch (err) {
            msgDiv.innerText = err.message || 'Erro ao processar.';
            msgDiv.className = 'mb-4 p-3 rounded bg-red-50 text-red-700';
            msgDiv.classList.remove('hidden');
            btn.disabled = false;
            btn.innerText = 'Enviar link de recuperação';
        }
    });
}