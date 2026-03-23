import './bootstrap';

import { AuthService } from './api/auth';
import { ResetarSenhaService } from './api/resetarSenha';
import { initRecuperarSenha } from './pages/recuperar-senha';
import { initAtualizarSenha } from './pages/atualizar-senha';
import { initLogin } from './pages/login';
import { initDashboardConsultora } from './pages/dashboard-consultora';
import { UIService } from './service/uiService';
import { initHistoricoComissao } from "./pages/historico-comissao";
import { initFormCliente } from './pages/formularios/formulario-cliente';
import { initFormUsuario } from './pages/formularios/formulario-usuario';
import { InitCatalogoProduto } from './pages/catalogo-produtos';

// Inicializa a lógica da página
document.addEventListener('DOMContentLoaded', () => {
    UIService.init(); // Inicializa o elemento do loader

    initRecuperarSenha();
    initDashboardConsultora();
    initAtualizarSenha();
    initLogin();
    initHistoricoComissao();
    initFormCliente();
    initFormUsuario();
    InitCatalogoProduto();

// Garante que o loader suma quando a página carregar (F5/Navegação normal)
    UIService.hide();
});
window.ResetarSenhaService = ResetarSenhaService;
window.AuthService = AuthService;