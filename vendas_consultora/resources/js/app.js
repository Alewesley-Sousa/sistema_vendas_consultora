import './bootstrap';

import { AuthService } from './api/auth';
import { ResetarSenhaService } from './api/resetarSenha';
import { initRecuperarSenha } from './recuperar-senha'
import { initAtualizarSenha } from './atualizar-senha';
import { initLogin } from './pages/login';

// Inicializa a lógica da página
document.addEventListener('DOMContentLoaded', () => {
    // UIService.init(); // Inicializa o elemento do loader

    initRecuperarSenha();
    initAtualizarSenha();
    initLogin();

// Garante que o loader suma quando a página carregar (F5/Navegação normal)
    // UIService.hide();
});
window.ResetarSenhaSeResetarSenhaServiceetarSenhaService;
window.AuthService = AuthService;