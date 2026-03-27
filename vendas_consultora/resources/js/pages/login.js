import { AuthService } from '../api/auth';

export function initLogin() {
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) return;

    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const rememberInput = document.getElementById('remember');
    const btnEntrar = document.getElementById('btnEntrar');

    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        // 1. Pega os dados do Alpine do componente Blade
        const alpineData = window.Alpine ? Alpine.$data(loginForm.closest('[x-data]')) : null;
        
        if (alpineData) {
            alpineData.isSubmitting = true;
            alpineData.errors = []; 
        }

        if (btnEntrar) btnEntrar.disabled = true;

        const payload = {
            email: emailInput?.value,
            password: passwordInput?.value,
            remember: rememberInput ? rememberInput.checked : false
        };

        try {
            // Chama seu AuthService (que já salva o token no localStorage)
            const response = await AuthService.login(payload);
            
            // 2. Redirecionamento usando o 'redirect' do seu Controller PHP
            window.location.href = response.redirect;

        } catch (error) {
            // 3. Tratamento de Erro sincronizado com o que o Controller envia
            if (btnEntrar) btnEntrar.disabled = false;
            
            if (alpineData) {
                alpineData.isSubmitting = false;
                
                // O seu Controller envia ['message' => '...']
                // Como o seu AuthService dá 'throw error.response.data', o erro aqui já é o JSON
                if (error.errors) {
                    // Caso o Laravel envie erros de validação automáticos
                    alpineData.errors = Object.values(error.errors).flat();
                } else if (error.message) {
                    // Caso seja a mensagem de "Credenciais inválidas" ou "Status 3"
                    alpineData.errors = [error.message];
                } else {
                    alpineData.errors = ['Erro ao realizar login.'];
                }
            } else {
                // Fallback de segurança
                alert(error.message || 'Erro ao processar login.');
            }
        }
    });
}