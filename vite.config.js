import { defineConfig } from "vite";
import path from 'path';
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/scss/front/front.scss",
                "resources/js/front/custom.js",
                "resources/scss/admin/admin.scss",
                "resources/js/admin/admin.js",
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
            '@modules': path.resolve(__dirname, 'resources/js/front/modules'),
        },
    },
    build: {
        chunkSizeWarningLimit: 100000000,
    },
});
