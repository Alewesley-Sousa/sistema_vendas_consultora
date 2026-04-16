            --secondary: #FF69B4; /* Hot Pink */
            --dark-sidebar: #2C3E50; /* Azul Petróleo */
            --dark-sidebar-end: #1a252f;
            --background: #FFF5F7; /* Rosa Claro */
            --gold: #FFD700; /* Dourado */
            --card-bg: #FFFFFF;
            --text: #2C3E50;
            --text-muted: #5d6d7e;
            --radius: 15px; 
            --shadow: 0 4px 12px rgba(0,0,0,0.08); 
        }

        .register-container {
            background: var(--card-bg);
            width: 100%;
            max-width: 600px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
         
rem;
       1    display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 15px;
        }

        .form-group { margin-bottom: 20px; }

        .form-group label {a 
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: var(--primary);
            outline: none;
        }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0);} }
</style>
@endpush

@section('content')
    <div class="register-container">
        <form id="registerForm" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <input type="text" id="firstName" name="firstName" required placeholder=" ">
                    <label for="firstName">Nome</label>
                </div>
                <div class="form-group">
                    <input type="text" id="lastName" name="lastName" required placeholder=" ">
                    <label for="lastName">Sobrenome</label>
                </div>
            </div>

            <div class="form-group">
                <input type="email" id="email" name="email" required placeholder=" ">
                <label for="email">E-mail</label>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <input type="password" id="password" name="password" required placeholder=" ">
                    <label for="password">Senha</label>                  <div class="strength-fill" id="strengthFill"></div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="password" id="confirmPassword" name="confirmPassword" required placeholder=" ">
                    <labe srle-options" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 30px;">
                    <div class="role-option" data-role="cliente" style="border: 2px solid #eee; padding: 15px; border-radius: 12px; text-align: center; cursor: pointer; transition: all 0.3s ease;">
                        <div class="role-icon"><i class="fas fa-user"></i></div>
                        <div class="role-title">Cliente</div>
                        <div class="role-desc">Acesso limitado às compras</div>
                    </div>
                    <div class="role-option" data-role="funcionario" style="border: 2px solid #eee; padding: 15px; border-radius: 12px; text-align: center; cursor: pointer; transition: all 0.3s ease;">
                        <div class="role-icon"><i class="fas fa-user-tie"></i></div>
                        <div class="role-title">Funcionário</div>
                        <div class="role-desc">Gerenciamento de vendas</div>
                    </div>
                    <div class="role-option" data-role="admin" style="border: 2px solid #eee; padding: 15px; border-radius: 12px; text-align: center; cursor: pointer; transition: all 0.3s ease;">
                        <div class="role-icon"><i class="fas fa-user-shield"></i></div>
                        <div class="role-title">Administrador</div>
                        <div class="role-desc">Controle total do sistema</div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-register" id="btnRegister" disabled style="background: var(--primary); color: white; border: none; padding: 15px; width: 100%; border-radius: 10px; font-weight: bold; cursor: pointer; font-size: 1.1rem; transition: background 0.3s;">
                Criar Conta
            </button>
        </form>
    </div>
@endsection