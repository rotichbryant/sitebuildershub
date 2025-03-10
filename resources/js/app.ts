import CoreuiVue from '@coreui/vue'
import CIcon from '@coreui/icons-vue'
import { iconsSet as icons } from '../icons'
import { debounce } from 'lodash';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const { VITE_APP_NAME, VITE_APP_URL } = import.meta.env || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${VITE_APP_NAME || 'Laravel'}`,
    resolve: async (name) => resolvePageComponent(
        `./Pages/${name}.vue`,
        import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
    ),
    setup({ el, App, props, plugin }) {
        const app     = createApp({ render: () => h(App, props) });

        app.use(plugin);
        app.use(CoreuiVue)
        app.provide('icons', icons)
        app.component('CIcon', CIcon)
        app.use(ZiggyVue);
        app.mount(el);
        
        app.config.globalProperties.$route = route
    },
    progress: {
        color: '#4B5563',
    },
});
