import '../css/app.css'
import './bootstrap';

import { createApp, h, DefineComponent } from 'vue';  
import { createInertiaApp } from '@inertiajs/vue3';  
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';  
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import i18n from './Lang/i18n';
  
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'WLF';  
  
createInertiaApp({  
    title: (title) => `${title} - ${appName}`,  
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),  
    setup({ el, App, props, plugin }) {  
        createApp({ render: () => h(App, props) })  
            .use(plugin)  
            .use(ZiggyVue)  
            .use(i18n)
            .component('QuillEditor', QuillEditor)
            .component("v-select", vSelect)
            .mount(el);  
    },    progress: {  
        color: '#4B5563',  
    },});  
