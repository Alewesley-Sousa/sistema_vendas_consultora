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

        // 1. Início do Loading
        errorDiv.classList.add('hidden');
        errorList.innerHTML = '';
        btnEntrar.disabled = true;
        
        // Adicionamos as reticências com a classe animate-pulse do Tailwind
        btnEntrar.innerHTML = `
            <span class="flex items-center justify-center gap-1">
                Autenticando
                <span class="inline-flex">
                    <span class="animate-bounce [animation-delay:-0.3s]">.</span>
                    <span class="animate-bounce [animation-delay:-0.15s]">.</span>
                    <span class="animate-bounce">.</span>
                </span>
            </span>
        `;
        // Adiciona um feedback visual de desabilitado
        btnEntrar.classList.add('opacity-70', 'cursor-not-allowed');

        const payload = {
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            remember: document.getElementById('remember').checked
        };

        try {
            const response = await AuthService.login(payload);
            window.location.href = response.redirect;

        } catch (error) {
            // 2. Fim do Loading (em caso de erro)
            btnEntrar.disabled = false;
            btnEntrar.innerText = 'Entrar'; // Volta o texto original
            btnEntrar.classList.remove('opacity-70', 'cursor-not-allowed');
            
            errorDiv.classList.remove('hidden');

            const message = error.message || 'Erro ao realizar login.';
            const li = document.createElement('li');
            li.innerText = message;
            errorList.appendChild(li);
        }
    });
}