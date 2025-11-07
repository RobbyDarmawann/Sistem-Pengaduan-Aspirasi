import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],

    server: { // <-- Tambahkan bagian ini
        host: '0.0.0.0', // <-- Atur host di sini
        hmr: { // <-- Kadang ini juga diperlukan
          host: 'localhost',
        },
    },
});
