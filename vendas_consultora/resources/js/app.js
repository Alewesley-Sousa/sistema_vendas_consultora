import './bootstrap';

import { AuthService } from './api/auth';
import { ResetarSenhaService } from './api/resetarSenha';
import { initRecuperarSenha } from './pages/recuperar-senha';
import { initAtualizarSenha } from './pages/atualizar-senha';
import { initLogin } from './pages/login';
import { initDashboardConsultora } from './pages/dashboard-consultora';
import { UIService } from './service/uiService';
import { ImportGlobFunction } from 'vite';
import { initHistoricoComissao } from "./pages/historico-comissao";

// Inicializa a lógica da página
document.addEventListener('DOMContentLoaded', () => {
    UIService.init(); // Inicializa o elemento do loader

    initRecuperarSenha();
    initDashboardConsultora();
    initAtualizarSenha();
    initLogin();
    initHistoricoComissao();

// Garante que o loader suma quando a página carregar (F5/Navegação normal)
    UIService.hide();
});
window.ResetarSenhaService = ResetarSenhaService;
window.AuthService = AuthService;