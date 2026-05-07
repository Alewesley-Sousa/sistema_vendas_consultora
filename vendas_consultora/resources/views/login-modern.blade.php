@extends('layouts.app-modern')

@section('title', 'Login Moderno - Sistema de Vendas')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .login-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        padding: 20px;
    }

    .login-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        display: grid;
        grid-template-columns: 1fr 1fr;
        width: 100%;
        max-width: 900px;
        overflow: hidden;
        animation: slideIn 0.6s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-left {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 4rem 2rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .login-left::before {
        content: "";
        position: absolute;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        top: -100px;
        right: -100px;
        animation: float 6s ease-in-out infinite;
    }

    .login-left::after {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        bottom: -75px;
        left: -75px;
        animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(20px);
        }
    }

    .login-left-content {
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .brand-icon {
        font-size: 4rem;
        margin-bottom: 2rem;
        animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    .brand-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        letter-spacing: 1px;
    }

    .brand-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 3rem;
        line-height: 1.6;
    }

    .features {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-top: 3rem;
        text-align: left;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        opacity: 0.95;
    }

    .feature-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .login-right {
        padding: 4rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .login-header {
        margin-bottom: 2.5rem;
    }

    .login-title {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .login-description {
        color: #95a5a6;
        font-size: 0.95rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.8rem;
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1.2rem;
        border: 2px solid #ecf0f1;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8f9ff;
        color: #2c3e50;
        font-family: inherit;
    }

    .form-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.08);
        background: white;
    }

    .btn-login {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 1.2rem;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1.5rem;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }

    .auth-links {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2rem;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .auth-links a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .auth-links a:hover {
        color: #764ba2;
    }

    .separator {
        color: #ecf0f1;
    }

    @media (max-width: 768px) {
        .login-container {
            grid-template-columns: 1fr;
        }

        .login-left {
            display: none;
        }

        .login-right {
            padding: 2rem;
        }

        .login-title {
            font-size: 1.5rem;
        }

        .auth-links {
            flex-direction: column;
            gap: 1rem;
        }

        .separator {
            display: none;
        }
    }
</style>
@endpush

@section('content')
<div class="login-page">
    <div class="login-container">
        <div class="login-left">
            <div class="login-left-content">
                <div class="brand-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h1 class="brand-title">Sistema de Vendas</h1>
                <p class="brand-subtitle">Gerencie suas vendas e consultoras com eficiência</p>
                <div class="features">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                        <div>Relatórios em tempo real</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-users"></i></div>
                        <div>Gestão de consultoras</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-wallet"></i></div>
                        <div>Controle de comissões</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="login-right">
            <div class="login-header">
                <h2 class="login-title">Bem-vindo!</h2>
                <p class="login-description">Entre com suas credenciais para acessar o sistema</p>
            </div>

            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" id="email" name="email" class="form-input" required placeholder="seu@email.com">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" id="password" name="password" class="form-input" required placeholder="Digite sua senha">
                </div>

                <button type="submit" class="btn-login" id="btnLogin">
                    Entrar
                </button>
            </form>

            <div class="auth-links">
                
                <span class="separator">|</span>
                <a href="{{ route('senha-formulario') }}">Esqueceu sua senha?</a>
            </div>
        </div>
@endsection

@push('scripts')
<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const btnLogin = document.getElementById('btnLogin');
    const originalText = btnLogin.textContent;
    
    btnLogin.textContent = 'Entrando...';
    btnLogin.disabled = true;
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.redirect) {
            window.location.href = data.redirect;
        } else if (data.message) {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erro ao fazer login. Tente novamente.');
    })
    .finally(() => {
        btnLogin.textContent = originalText;
        btnLogin.disabled = false;
    });
});
</script>
@endpush
