import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        // Match APP_URL's hostname exactly. Vite's default bind (127.0.0.1)
        // and APP_URL=http://localhost:8000 are, to a browser, different
        // origins even though both resolve to loopback — so asset
        // <script type="module"> tags get blocked as cross-origin (CORS is
        // enforced for module scripts, unlike classic scripts).
        host: 'localhost',
    },
});
