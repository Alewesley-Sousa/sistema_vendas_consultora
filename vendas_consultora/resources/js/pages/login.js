import { AuthService } from '../api/auth';

export function initLogin() {
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) return;

    const btnEntrar = document.getElementById('btnEntrar');
    const errorDiv = document.getElementById('error-message');
    const errorList = document.getElementById('error-list');

    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        errorDiv.classList.add('hidden');
        errorList.innerHTML = '';
        btnEntrar.disabled = true;
        
        // Mantendo o tracking-[0.5em] e a fonte para não "pular" o layout
        btnEntrar.innerHTML = `
            <span class="flex items-center justify-center gap-2 tracking-[0.2em]">
                AUTENTICANDO
                <span class="flex gap-1">
                    <span class="animate-bounce [animation-delay:-0.3s] text-[#FFD700]">.</span>
                    <span class="animate-bounce [animation-delay:-0.15s] text-[#FFD700]">.</span>
                    <span class="animate-bounce text-[#FFD700]">.</span>
                </span>
            </span>
        `;
        btnEntrar.classList.add('opacity-80', 'cursor-not-allowed');

        const payload = {
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            remember: document.getElementById('remember').checked
        };

        try {
            const response = await AuthService.login(payload);
            window.location.href = response.redirect;

        } catch (error) {
            btnEntrar.disabled = false;
            // Voltando para o texto "ACESSAR" com o ícone correto
            btnEntrar.innerHTML = `
                <span>ACESSAR</span>
                <i class="fa-solid fa-arrow-right-long text-[10px] opacity-50"></i>
            `;
            btnEntrar.classList.remove('opacity-80', 'cursor-not-allowed');
            
            errorDiv.classList.remove('hidden');

            const message = error.message || 'Erro ao realizar login.';
            const li = document.createElement('li');
            li.innerText = message;
            errorList.appendChild(li);
        }
    });
}
