import './bootstrap';

import { AuthService } from './api/auth';
import { ResetarSenhaService } from './api/resetarSenha';
import { initRecuperarSenha } from './pages/recuperar-senha';
import { initAtualizarSenha } from './pages/atualizar-senha';
import { initLogin } from './pages/login';
import { initDashboardConsultora } from './pages/dashboard-consultora';

// Inicializa a lógica da página
document.addEventListener('DOMContentLoaded', () => {
    initRecuperarSenha();
    initDashboardConsultora();
    initAtualizarSenha();
    initLogin();
});
window.ResetarSenhaService = ResetarSenhaService;
window.AuthService = AuthService;