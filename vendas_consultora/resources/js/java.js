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

    const DEFAULT_USERS = [{
        id: '1',
        firstName: 'Admin',
        lastName: 'Sistema',
        email: 'admin@consultora.com',
        password: '123456',
        role: 'admin',
        createdAt: new Date().toISOString()
    }];

    let users = [];
    try {
        users = JSON.parse(localStorage.getItem('users')) || DEFAULT_USERS;
        if (!localStorage.getItem('users')) {
            localStorage.setItem('users', JSON.stringify(DEFAULT_USERS));
        }
    } catch (e) {
        console.warn('localStorage indisponível', e);
        users = DEFAULT_USERS;
    }

    function showFieldError(input, msg) {
        let el = input.parentNode.querySelector('.field-error');
        if (!el) {
            el = document.createElement('div');
            el.className = 'field-error';
            input.parentNode.appendChild(el);
        }
        el.textContent = msg;
    }
    function hideFieldError(input) {
        const el = input.parentNode.querySelector('.field-error');
        if (el) el.remove();
    }

    function validateEmail(input) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const ok = re.test(input.value);
        input.style.borderColor = ok ? '#27ae60' : '#e74c3c';
        if (!ok && input.value) showFieldError(input, 'E-mail inválido');
        else hideFieldError(input);
    }
    function validatePassword(input) {
        const ok = input.value.length >= 6;
        input.style.borderColor = ok ? '#27ae60' : '#e74c3c';
        if (!ok && input.value) showFieldError(input, 'Senha mínimo 6 caracteres');
        else hideFieldError(input);
    }

    if (emailInput) emailInput.addEventListener('input', function() { validateEmail(this); });
    if (passwordInput) passwordInput.addEventListener('input', function() { validatePassword(this); });

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = emailInput.value.trim();
            const pwd = passwordInput.value.trim();
            if (!email || !pwd) {
                errorMessage.textContent = 'Preencha todos os campos';
                errorMessage.style.display = 'block';
                return;
            }
            loading.style.display = 'block';
            btnLogin.disabled = true;
            btnLogin.textContent = 'Verificando...';
            setTimeout(() => {
                const user = users.find(u => u.email === email && u.password === pwd);
                if (user) {
                    localStorage.setItem('currentUser', JSON.stringify(user));
                    successMessage.textContent = 'Login ok';
                    successMessage.style.display = 'block';
                    errorMessage.style.display = 'none';
                    setTimeout(() => {
                        window.location.href = user.role === 'admin' ? './admin.php' : './dashboard.php';
                    }, 1000);
                } else {
                    errorMessage.textContent = 'E-mail ou senha incorretos';
                    errorMessage.style.display = 'block';
                    successMessage.style.display = 'none';
                    passwordInput.value = '';
                    passwordInput.focus();
                }
                loading.style.display = 'none';
                btnLogin.disabled = false;
                btnLogin.textContent = 'Entrar';
            }, 1000);
        });
    }

    if (registerLink) registerLink.addEventListener('click', e => { e.preventDefault(); window.location.href = './register.php'; });
    if (forgotLink) forgotLink.addEventListener('click', e => {
        e.preventDefault();
        const email = prompt('E-mail para recuperar senha:');
        if (email) alert(`Enviado para ${email}`);
    });
});