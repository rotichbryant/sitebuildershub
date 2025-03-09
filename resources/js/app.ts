import CoreuiVue from '@coreui/vue'
import CIcon from '@coreui/icons-vue'
import { iconsSet as icons } from '../icons'

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        if( name.includes('Landing') ){
            [
                { src: 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',   type: 'css'    },
                { src: 'https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js',                     type: 'script' },
                { src: 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.3/js/bootstrap.min.js',  type: 'script' },
                { src: '../../assets/js/vendor.min.js',                                               type: 'script' },
            ].forEach( ({ type, src }) => {
                if(type == 'css' && document.querySelector(`link[href="${src}"]`) == null ) {            
                    const css = document.createElement('link');
                    css.href  = src;
                    css.rel   = 'stylesheet';
                    document.head.appendChild(css);
                }
                if(type == 'script' && document.querySelector(`script[src="${src}"]`) == null ) {
                    const script = document.createElement('script');
                    script.src   = src;
                    document.body.appendChild(script);
                }
            });
        }
        return resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        )
    },
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
