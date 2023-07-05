import './bootstrap';
import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3'
import { createApp, h } from 'vue';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import vuetify from "./plugins/vuetify/vuetify";
import Layout from '@/Layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3';
import { createPinia } from 'pinia'


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    progress: {
        color: '#F6B032',
    },
    title: (title) => `${title} - ${appName}`,
    // resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    resolve: async name => {
        const page = await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob("./Pages/**/*.vue"));
        page.default.layout ??= Layout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(ShortKey)
            .use(VueMask)
            .use(print)
            .use(vuetify)
            .component("Head", Head)
            .component("Link", Link)
            .use(createPinia())
            .mount(el);
    },
});
