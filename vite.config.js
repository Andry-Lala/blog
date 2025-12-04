import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/notification-system.js', 'resources/js/language-switcher.js', 'resources/js/datatable-improvements.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
