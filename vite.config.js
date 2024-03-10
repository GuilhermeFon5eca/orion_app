import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import i18n from 'laravel-vue-i18n/vite';


export default defineConfig({
    plugins: [ 
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/argon/css/argon-dashboard.css',
                'resources/argon/css/nucleo-icons.css',
                'resources/argon/css/nucleo-svg.css',
                'resources/argon/css/custom.css',

                'resources/argon/js/core/popper.min.js', 
                'resources/argon/js/core/bootstrap.min.js', 
                'resources/argon/js/plugins/perfect-scrollbar.min.js', 
                'resources/argon/js/plugins/smooth-scrollbar.min.js', 
                'resources/argon/js/plugins/chartjs.min.js', 
                // 'resources/argon/js/argon-dashboard.min.js',
                'resources/argon/js/argon-dashboard.js',
                'resources/js/main.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        i18n(),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
