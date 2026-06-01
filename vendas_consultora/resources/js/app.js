import './bootstrap'
import gsap from 'gsap'
import Alpine from 'alpinejs'
import loginForm from './alpine/loginForm'

// Instancia global do GSAP e Alpine para páginas Blade legadas
window.gsap = gsap
window.Alpine = Alpine
Alpine.data('loginForm', loginForm)
Alpine.start()

// --- CONFIGURAÇÃO DO VUE + INERTIA ---
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers' // <--- Importante!

createInertiaApp({
    title: (title) => title ? `${title} - Sistema de Vendas` : 'Sistema de Vendas',
    
    // Resolve dinamicamente tratando caminhos de forma segura e assíncrona
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
    progress: {
        color: '#FF1493',
    },
})