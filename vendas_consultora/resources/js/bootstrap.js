import axios from 'axios';
import Alpine from 'alpinejs';
import { UIService } from './service/uiService'; // Importamos o serviço que gerencia o loader

window.Alpine = Alpine;
window.axios = axios;

// Identifica para o Laravel que a requisição é AJAX
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;
// Configura o Token CSRF automaticamente
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

/**
 * ADICIONANDO OS INTERCEPTORES PARA O PRELOADER
 */

// 1. Interceptor de Requisição (Mostra o loader ao iniciar qualquer chamada)
window.axios.interceptors.request.use((config) => {
    UIService.show(); 
    return config;
}, (error) => {
    UIService.hide();
    return Promise.reject(error);
});

// 2. Interceptor de Resposta (Esconde o loader quando a chamada termina)
window.axios.interceptors.response.use((response) => {
    UIService.hide();
    return response;
}, (error) => {
    UIService.hide();
    // Aqui tem possibilidade de tratamento de erros globais (ex: 401 ou 500)
    return Promise.reject(error);
});