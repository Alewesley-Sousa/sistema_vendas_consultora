import axios from 'axios';
window.axios = axios;

// Identifica para o Laravel que a requisição é AJAX
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;
// Configura o Token CSRF automaticamente
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// Opcional: Definir a URL base se sua API tiver um prefixo fixo
// window.axios.defaults.baseURL = '/api';