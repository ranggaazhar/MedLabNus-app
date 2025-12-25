import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/welcome.css',
                'resources/css/custom-utilities.css',
                'resources/css/dashboard.css',
                'resources/css/dropdown.css',
                'resources/css/footer.css',
                'resources/js/app.js',
                'resources/js/slider.js',
            ],
            refresh: true,
        }),
    ],
});