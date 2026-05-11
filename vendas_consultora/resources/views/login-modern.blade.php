@extends('layouts.app-modern')

@section('title', 'Login Moderno - Sistema de Vendas')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.tailwindcss.com"></script>
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(20px); }
    }
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-float-reverse { animation: float 8s ease-in-out infinite reverse; }
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#667eea] to-[#764ba2] p-5 font-sans">
    <div class="bg-white rounded-[20px] shadow-2xl grid grid-cols-1 md:grid-cols-2 w-full max-w-[900px] overflow-hidden animate-[slideIn_0.6s_ease-out]">
        
        <!-- Lado Esquerdo: Branding -->
        <div class="hidden md:flex bg-gradient-to-br from-[#667eea] to-[#764ba2] p-16 flex-col justify-center items-center text-white relative overflow-hidden">
            <div class="absolute w-[200px] h-[200px] bg-white/10 rounded-full -top-[100px] -right-[100px] animate-float"></div>
            <div class="absolute w-[150px] h-[150px] bg-white/10 rounded-full -bottom-[75px] -left-[75px] animate-float-reverse"></div>
            
            <div class="relative z-10 text-center">
                <div class="text-[4rem] mb-8 animate-bounce">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h1 class="text-3xl font-bold mb-4 tracking-wider">Sistema de Vendas</h1>
                <p class="text-white/90 leading-relaxed mb-12">Gerencie suas vendas e consultoras com eficiência</p>
                
                <div class="flex flex-col gap-6 text-left">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center"><i class="fas fa-chart-line"></i></div>
                        <span>Relatórios em tempo real</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center"><i class="fas fa-users"></i></div>
                        <span>Gestão de consultoras</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lado Direito: Formulário -->
        <div class="p-10 md:p-16 flex flex-col justify-center">
            <div class="mb-10">
                <h2 class="text-3xl font-bold text-[#2c3e50] mb-2">Bem-vindo!</h2>
                <p class="text-gray-400">Entre com suas credenciais para acessar o sistema</p>
            </div>

            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-6">
                    <label for="email" class="block mb-3 font-semibold text-[#2c3e50] text-sm uppercase tracking-wider">E-mail</label>
                    <input type="email" id="email" name="email" 
                        class="w-full p-4 border-2 border-gray-100 rounded-xl bg-[#f8f9ff] text-[#2c3e50] focus:outline-none focus:border-[#667eea] focus:bg-white transition-all" 
                        required placeholder="seu@email.com">
                </div>

                <div class="mb-6">
                    <label for="password" class="block mb-3 font-semibold text-[#2c3e50] text-sm uppercase tracking-wider">Senha</label>
                    <input type="password" id="password" name="password" 
                        class="w-full p-4 border-2 border-gray-100 rounded-xl bg-[#f8f9ff] text-[#2c3e50] focus:outline-none focus:border-[#667eea] focus:bg-white transition-all" 
                        required placeholder="Digite sua senha">
                </div>

                <button type="submit" id="btnLogin" 
                    class="w-full bg-gradient-to-r from-[#667eea] to-[#764ba2] text-white p-4 rounded-xl font-bold hover:-translate-y-0.5 hover:shadow-lg transition-all mt-4 disabled:opacity-50 flex justify-center items-center">
                    <span id="btnText">Entrar</span>
                </button>
            </form>

            <div class="flex flex-col sm:flex-row justify-between items-center mt-8 gap-4">
                <a href="{{ route('senha-formulario') }}" class="text-[#667eea] font-semibold hover:text-[#764ba2] transition-colors text-sm">
                    Esqueceu sua senha?
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    // Configuração global do Axios para Laravel
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const btnLogin = document.getElementById('btnLogin');
        const btnText = document.getElementById('btnText');
        const formData = new FormData(this);
        
        btnText.textContent = 'Autenticando...';
        btnLogin.disabled = true;
        
        axios.post(this.action, formData)
        .then(response => {
            // Se o controller enviou o token, salvamos no localStorage (opcional, mas útil para APIs)
            if (response.data.token) {
                localStorage.setItem('auth_token', response.data.token);
                localStorage.setItem('user_name', response.data.user);
            }

            // Redirecionamento baseado no match do Controller
            if (response.data.redirect) {
                window.location.href = response.data.redirect;
            }
        })
        .catch(error => {
            console.error('Erro:', error.response);
            
            // Tratamento das mensagens que você definiu no Controller
            let errorMsg = 'Ocorreu um erro ao tentar entrar.';
            
            if (error.response) {
                if (error.response.status === 403 || error.response.status === 401) {
                    errorMsg = error.response.data.message;
                } else if (error.response.status === 422) {
                    errorMsg = 'Por favor, preencha os dados corretamente.';
                }
            }

            alert(errorMsg);
        })
        .finally(() => {
            btnText.textContent = 'Entrar';
            btnLogin.disabled = false;
        });
    });
</script>
@endpush
