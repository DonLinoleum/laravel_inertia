import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import "../scss/app.scss";
import Toast, {PluginOptions, POSITION } from "vue-toastification";
import "vue-toastification/dist/index.css";


const options:PluginOptions = {
    position: POSITION.TOP_LEFT
}

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Toast,options)
            .mount(el);
    },
});
