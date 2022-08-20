import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'


export default defineConfig({
    esbuild: {
        jsxInject: `import * as L from 'leaflet'`,
        jsxInject: `import * as GeoSearch from 'leaflet-geosearch'`,
        jsxInject: `import Oruga from '@oruga-ui/oruga-next'`,
    },
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/assets/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),

    ],
});
