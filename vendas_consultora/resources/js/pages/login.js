// resources/js/pages/login.js
import { AuthService } from '../api/auth';

export function initLogin() {
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) return;

    const btnEntrar = document.getElementById('btnEntrar');
    const errorDiv = document.getElementById('error-message');
    const errorList = document.getElementById('error-list');

    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Reset da interface
        errorDiv.classList.add('hidden');
        errorList.innerHTML = '';
        btnEntrar.disabled = true;
        btnEntrar.innerText = 'Autenticando...';

        const payload = {
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            remember: document.getElementById('remember').checked
        };

        try {
            const response = await AuthService.login(payload);
            
            // Redireciona para o dashboard retornado pelo backend (PHP)
            window.location.href = response.redirect;

        } catch (error) {
            btnEntrar.disabled = false;
            btnEntrar.innerText = 'Entrar';
            errorDiv.classList.remove('hidden');

            // Se o Laravel retornar erros de validação (422) ou mensagem simples
            const message = error.message || 'Erro ao realizar login.';
            const li = document.createElement('li');
            li.innerText = message;
            errorList.appendChild(li);
        }
    });
}