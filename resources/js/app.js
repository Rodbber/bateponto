import './bootstrap';

import Alpine from 'alpinejs';

import {createApp, h} from 'vue'

import App from './App.vue'
import Pontos from './Empresas/Pontos.vue'

import Oruga from '@oruga-ui/oruga-next';
import '@oruga-ui/oruga-next/dist/oruga-full.css';

//Vue.use(Buefy)
const newApp = createApp(App)
const empresasPontos = createApp(Pontos)
empresasPontos.use(Oruga);
//newApp.use(Buefy)
window.Alpine = Alpine;

Alpine.start()
newApp.mount("#app")
empresasPontos.mount("#pontosApp")
