import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp, Link } from '@inertiajs/vue3';
import { ZiggyVue } from 'ziggy-js';
import GlobalComponents from './global.js';

import * as cards from "@/assets/data.json";

createInertiaApp({
  resolve: (name) => {
    let pages = import.meta.glob('./**/*.vue', { eager: true });
    return pages[`./${name}.vue`];
  },
  setup({ el, App, props, plugin }) {
    let app = createApp({ render: () => h(App, props) });

    app.config.globalProperties.$filters = {
      truncate: function (text, stop, clamp) {
        return text.slice(0, stop) + (stop < text.length ? clamp || '...' : '');
      }
    };

    app.config.globalProperties.$cards = cards.default.map((card) => {
      return {
        ...card,
        rarity: card.rarity.toLowerCase(),
        supertype: card.supertype.toLowerCase(),
        subtypes: Array.isArray(card.subtypes)
          ? card.subtypes.join(" ").toLowerCase()
          : card.subtypes.toLowerCase(),
        gallery: card.number.startsWith("TG"),
      };
    });

    app
      .use(plugin)
      .use(ZiggyVue)
      .use(GlobalComponents)
      .component('inertia-link', Link)
      .mount(el);
  },
});