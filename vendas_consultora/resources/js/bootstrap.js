import axios from 'axios'

window.axios = axios

// AJAX Laravel
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

// Cookies / Sanctum
axios.defaults.withCredentials = true

// CSRF
const token = document
    .querySelector('meta[name="csrf-token"]')

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] =
        token.content
} else {
    console.warn('CSRF token não encontrado')
}