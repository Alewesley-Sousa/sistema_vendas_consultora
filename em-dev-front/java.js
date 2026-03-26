// JavaScript para página de login
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const btnLogin = document.getElementById('btnLogin');
    const errorMessage = document.getElementById('errorMessage');
    const successMessage = document.getElementById('successMessage');
    const loading = document.getElementById('loading');
    const registerLink = document.getElementById('registerLink');
    const forgotLink = document.getElementById('forgotLink');

    // Usuários do sistema (incluindo admin padrão)
    const DEFAULT_USERS = [
        {
            id: '1',
            firstName: 'Admin',
            lastName: 'Sistema',
            email: 'admin@consultora.com',
            password: '123456',
            role: 'admin',
            createdAt: new Date().toISOString()
        }
    ];

    // Carregar usuários do localStorage ou usar padrão
    let users = JSON.parse(localStorage.getItem('users')) || DEFAULT_USERS;
    if (!localStorage.getItem('users')) {
        localStorage.setItem('users', JSON.stringify(DEFAULT_USERS));
    }

    // Animação de digitação no título
    const title = document.querySelector('.login-header h1');
    if (title) {
        const originalText = title.textContent;
        title.textContent = '';
        let i = 0;

        function typeWriter() {
            if (i < originalText.length) {
                title.textContent += originalText.charAt(i);
                i++;
                setTimeout(typeWriter, 100);
            }
        }
        typeWriter();
    }

    // Validação em tempo real
    if (emailInput) {
        emailInput.addEventListener('input', function() {
            validateEmail(this);
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            validatePassword(this);
        });
    }

    function validateEmail(input) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const isValid = emailRegex.test(input.value);

        input.style.borderColor = isValid ? '#27ae60' : input.value ? '#e74c3c' : '#e1e5e9';

        if (input.value && !isValid) {
            showFieldError(input, 'E-mail inválido');
        } else {
            hideFieldError(input);
        }
    }

    function validatePassword(input) {
        const isValid = input.value.length >= 6;

        input.style.borderColor = isValid ? '#27ae60' : input.value ? '#e74c3c' : '#e1e5e9';

        if (input.value && !isValid) {
            showFieldError(input, 'A senha deve ter pelo menos 6 caracteres');
        } else {
            hideFieldError(input);
        }
    }

    function showFieldError(input, message) {
        let errorEl = input.parentNode.querySelector('.field-error');
        if (!errorEl) {
            errorEl = document.createElement('div');
            errorEl.className = 'field-error';
            errorEl.style.cssText = `
                color: #e74c3c;
                font-size: 12px;
                margin-top: 5px;
                animation: fadeIn 0.3s ease;
            `;
            input.parentNode.appendChild(errorEl);
        }
        errorEl.textContent = message;
    }

    function hideFieldError(input) {
        const errorEl = input.parentNode.querySelector('.field-error');
        if (errorEl) {
            errorEl.remove();
        }
    }

    // Login form submission
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const email = emailInput.value;
            const password = passwordInput.value;

            // Mostrar loading
            loading.style.display = 'block';
            btnLogin.disabled = true;
            btnLogin.textContent = 'Verificando...';

            // Simular verificação assíncrona
            setTimeout(() => {
                const user = users.find(u => u.email === email && u.password === password);

                if (user) {
                    // Login bem-sucedido
                    localStorage.setItem('currentUser', JSON.stringify(user));

                    successMessage.textContent = 'Login realizado com sucesso! Redirecionando...';
                    successMessage.style.display = 'block';
                    errorMessage.style.display = 'none';

                    // Animação de sucesso
                    loginForm.style.animation = 'bounce 0.5s ease';

                    setTimeout(() => {
                        // Redirecionar baseado no papel do usuário
                        if (user.role === 'admin') {
                            window.location.href = 'admin.html';
                        } else {
                            window.location.href = 'clientes.html';
                        }
                    }, 1500);
                } else {
                    // Login falhou
                    errorMessage.textContent = 'E-mail ou senha incorretos. Tente novamente.';
                    errorMessage.style.display = 'block';
                    successMessage.style.display = 'none';

                    // Animação de erro (shake)
                    loginForm.style.animation = 'shake 0.5s ease';

                    // Resetar campos
                    passwordInput.value = '';
                    passwordInput.focus();
                }

                // Esconder loading
                loading.style.display = 'none';
                btnLogin.disabled = false;
                btnLogin.textContent = 'Entrar';
            }, 2000);
        });
    }

    // Link para registro
    if (registerLink) {
        registerLink.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = 'register.html';
        });
    }

    // Link "Esqueceu senha"
    if (forgotLink) {
        forgotLink.addEventListener('click', function(e) {
            e.preventDefault();

            const email = prompt('Digite seu e-mail para recuperar a senha:');
            if (email) {
                alert(`Um link de recuperação foi enviado para ${email}`);
            }
        });
    }

    // Animações CSS adicionais
    const additionalStyles = `
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .field-error {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;

    const style = document.createElement('style');
    style.textContent = additionalStyles;
    document.head.appendChild(style);
});