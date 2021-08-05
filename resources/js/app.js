require("./bootstrap");

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import AppLayout from "@/Layouts/AppLayout.vue";
import Card from "@/Components/Card.vue";
import Logo from "@/Components/Logo.vue";

const appName =
  window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => require(`./Pages/${name}.vue`),
  setup({ el, app, props, plugin }) {
    return createApp({ render: () => h(app, props) })
      .use(plugin)
      .component("app-layout", AppLayout)
      .component("card", Card)
      .component("logo", Logo)
      .mixin({
        methods: {
          route,
          dateToLocaleString: (date) => {
            return new Date(Date.parse(date)).toLocaleString();
          },
        },
      })
      .mount(el);
  },
});

InertiaProgress.init({ color: "#4B5563" });
