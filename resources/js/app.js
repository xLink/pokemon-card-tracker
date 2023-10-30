import './bootstrap';

import Vue from 'vue';
import { createInertiaApp } from '@inertiajs/vue2';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js';
import GlobalComponents from './global.js';
import { Link } from '@inertiajs/vue2';

createInertiaApp({
  resolve: async (name) => {
    let page = await resolvePageComponent(`./${name}.vue`, import.meta.glob('./**/*.vue'));
    return page;
  },
  setup({ el, App, props, plugin }) {
    Vue.use(plugin);
    Vue.use(ZiggyVue);
    Vue.use(GlobalComponents);
    Vue.component('inertia-link', Link);

    new Vue({
      render: h => h(App, props),
    }).$mount(el);
  },
});