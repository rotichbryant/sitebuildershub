import CoreuiVue from '@coreui/vue'
import CIcon from '@coreui/icons-vue'
import { iconsSet as icons } from '../icons'

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, DefineComponent, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const { VITE_APP_NAME, VITE_APP_URL } = import.meta.env || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${VITE_APP_NAME || 'Laravel'}`,
    resolve: (name) => {
        if( name.includes('Landing') ){
            [
                { src: 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',   type: 'css'    },
                { src: `${VITE_APP_URL}/assets/plugins/jquery/jquery.min.js`,                         type: 'script' },
                { src: `${VITE_APP_URL}/assets/js/vendor.min.js`,                                     type: 'script' },
                { src: `${VITE_APP_URL}/assets/css/bootstrap.css`,                                    type: 'css'    },
                { src: `${VITE_APP_URL}/assets/css/theme.css`,                                        type: 'css'    },
                { src: `${VITE_APP_URL}/assets/plugins/ui-range-slider/jquery-ui.css`,                type: 'css'    },
                { src: `${VITE_APP_URL}/assets/plugins/ui-range-slider/jquery-ui.js`,                 type: 'script' },
                { src: `${VITE_APP_URL}/assets/plugins/fancybox/jquery.fancybox.min.css`,             type: 'css'    },
                { src: `${VITE_APP_URL}/assets/plugins/fancybox/jquery.fancybox.min.js`,              type: 'script' },
                { src: `${VITE_APP_URL}/assets/plugins/counter-up/jquery.counterup.min.js`,           type: 'script' },
                { src: `${VITE_APP_URL}/assets/plugins/counter-up/jquery.waypoints.min.js`,           type: 'script' },
                { src: `${VITE_APP_URL}/assets/plugins/nice-select/nice-select.min.css`,              type: 'css'    },
                { src: `${VITE_APP_URL}/assets/plugins/nice-select/jquery.nice-select.min.js`,        type: 'script' },
                { src: `${VITE_APP_URL}/assets/plugins/aos/aos.min.js`,                               type: 'script' },
                { src: `${VITE_APP_URL}/assets/plugins/aos/aos.min.css`,                              type: 'css'    },
                { src: `${VITE_APP_URL}/assets/js/custom.js`,                                         type: 'script' },
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
