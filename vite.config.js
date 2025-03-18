import laravel from 'laravel-vite-plugin'
import react from '@vitejs/plugin-react';
import { defineConfig } from 'vite'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/front/app.js',
                'resources/js/front/gradient.jsx',
                'resources/css/package-headers.css'
            ],
            detectTls: 'spatie.be.test',
        }),
        react(),
    ],
});
