import { defineConfig, loadEnv } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'
import vue from '@vitejs/plugin-vue' // <--- 1. Importe o plugin do Vue

export default defineConfig(({ mode }) => {
    // Carrega o arquivo .env atual
    const env = loadEnv(mode, process.cwd(), '');
    
    // Se existir a variável do túnel, limpa o "https://" dela, senão usa localhost
    const tunnelHost = env.VITE_TUNNEL_URL ? env.VITE_TUNNEL_URL.replace('https://', '') : 'localhost';

    return {
        plugins: [
            laravel({
                input: [
                    'resources/css/app.css',
                    'resources/js/app.js',
                ],
                refresh: true,
            }),
            vue({ // <--- 2. Adicione o plugin do Vue aqui com as configs de asset do Laravel
                template: {
                    transformAssetUrls: {
                        base: null,
                        includeAbsolute: false,
                    },
                },
            }),
            tailwindcss(),
        ],

        server: {
            host: '0.0.0.0',
            port: 5173,
            strictPort: true,
            // Configura o HMR (Hot Reload) para conversar via WebSocket Seguro (wss) com o Cloudflare
            hmr: {
                host: tunnelHost,
                clientPort: env.VITE_TUNNEL_URL ? 443 : 5173,
                protocol: env.VITE_TUNNEL_URL ? 'wss' : 'ws',
            },
            cors: true,
            allowedHosts: [tunnelHost],
            watch: {
                ignored: [
                    '**/vendor/**',
                    '**/node_modules/**',
                    '**/storage/**',
                    '**/public/**',
                ],
            },
        },
    };
});