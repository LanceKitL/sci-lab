import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', // <--- Must match file location
                'resources/js/app.js',   // <--- Must match file location
            ],
            refresh: true,
        }),
    ],
});