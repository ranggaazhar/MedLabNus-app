import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/welcome.css', 
                'resources/css/footer.css', 
                // TAMBAHKAN FILE JS ANDA DI SINI
                'resources/js/slider.js' 
            ],
            refresh: true,
        }),
    ],
});
