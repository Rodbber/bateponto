import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'


export default defineConfig({
    esbuild: {
        jsxInject: `import * as L from 'leaflet'`,
        jsxInject: `import * as GeoSearch from 'leaflet-geosearch'`,
    },
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
