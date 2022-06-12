import './bootstrap';

// import { createApp } from 'vue';
// import MainComponent from './Pages/Main.vue'
//
// createApp({
//     Pages: {
//         MainComponent,
//     }
// }).mount('#app')

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import Layout from "./Shared/Layout"

createInertiaApp({
    resolve: async name => {
        let page = (await require(`./Pages/${name}`)).default;

        if (page.layout == undefined) {
            page.layout = Layout;
        }

        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})
