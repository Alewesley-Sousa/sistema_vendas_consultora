import './bootstrap';

import { ResetarSenhaService } from './api/resetarSenha';
import { AuthService } from './api/auth';
import { initRecuperarSenha } from './pages/recuperar-senha';
import { initAtualizarSenha } from './pages/atualizar-senha';
import { initLogin } from './pages/login';
import { initDashboardConsultora } from './pages/dashboard-consultora';
import { initFormularioCliente } from './pages/formularios/formulario-cliente.js';

// Inicializa a lógica da página
document.addEventListener('DOMContentLoaded', () => {
    // UIService.init(); // Inicializa o elemento do loader
    initDashboardConsultora();
    initRecuperarSenha();
    initAtualizarSenha();
    initLogin();
    initFormularioCliente();
    


    Alpine.start();
// Garante que o loader suma quando a página carregar (F5/Navegação normal)
    // UIService.hide();
});
window.ResetarSenhaSeResetarSenhaServiceetarSenhaService;
window.AuthService = AuthService;