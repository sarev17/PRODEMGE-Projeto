import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { InertiaProgress } from '@inertiajs/progress'

// Importe o Vuetify
import { createVuetify } from 'vuetify'
import 'vuetify/styles' // Importe os estilos do Vuetify
import * as components from 'vuetify/components' // Importe os componentes do Vuetify
import * as directives from 'vuetify/directives' // Importe as diretivas do Vuetify

//icons css
import { fa } from "vuetify/iconsets/fa";
import { aliases, mdi } from "vuetify/lib/iconsets/mdi";
// make sure to also import the coresponding css
import "@mdi/font/css/materialdesignicons.css"; // Ensure you are using css-loader
import "@fortawesome/fontawesome-free/css/all.css"; // Ensure your project is capable of handling css files


//templates
import HeaderVue from './layouts/Header.vue'

InertiaProgress.init()

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    // Crie o Vuetify
    const vuetify = createVuetify({
      components,
      directives,
      HeaderVue,
      fa
    })

    // Crie o aplicativo Vue
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(vuetify) // Use o Vuetify como plugin
      .mount(el)
  },
})
