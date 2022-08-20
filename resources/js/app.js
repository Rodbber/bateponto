import './bootstrap';

import Alpine from 'alpinejs';

import {createApp, h} from 'vue'

import App from './App.vue'
import Pontos from './Empresas/Pontos.vue'

import Oruga from '@oruga-ui/oruga-next';
import '@oruga-ui/oruga-next/dist/oruga-full.css';
import mdiVue from 'mdi-vue/v3'
import * as mdijs from '@mdi/js'
//Vue.use(Buefy)
const newApp = createApp(App)
const empresasPontos = createApp(Pontos).use(mdiVue,{
    icons: mdijs
})
empresasPontos.use(Oruga);
//newApp.use(Buefy)
window.Alpine = Alpine;

Alpine.start()
newApp.mount("#app")
empresasPontos.mount("#pontosApp")
