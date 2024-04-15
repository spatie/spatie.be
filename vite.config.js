import laravel from 'laravel-vite-plugin'
import { defineConfig } from 'vite'

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/front/app.js',
            detectTls: 'spatie.be.test',
        }),
    ],
});
