import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/css/calendar-id.css',
                'resources/css/home-rooms.css',
                'resources/css/footer.css',
                'resources/css/home-animations.css',
                'resources/js/app.js',
                'resources/js/alerts.js',
                'resources/js/header-scroll.js',
                'resources/js/home-animations.js'
            ],
            refresh: true,
        }),
    ],
});
