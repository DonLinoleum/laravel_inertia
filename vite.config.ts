import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vuePlugin from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/scss/app.scss", "resources/js/app.ts"],
            refresh: true,
        }),
        vuePlugin(),
    ],
    resolve: {
        alias: {
            "~": "/resources/js",
            "~Components": "/resources/js/Components",
            "~Modules": "/resources/js/Modules",
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `
                @use "/resources/scss/vars" as *;
                @use "/resources/scss/mixins" as *;
            `,
            },
        },
    },
});
