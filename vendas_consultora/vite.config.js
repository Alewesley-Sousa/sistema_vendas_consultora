import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  server: {
    watch: {
      // Ignora pastas que não precisam ser observadas
      ignored: ['**/vendor/**', '**/node_modules/**', '**/storage/**', '**/public/**'],
      // Se quiser forçar polling (em vez de usar CHOKIDAR_USEPOLLING env)
      // usePolling: true,
      // interval: 1000,
    },
  },
});
