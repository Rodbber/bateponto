import './bootstrap';

import Alpine from 'alpinejs';

import {createApp, h} from 'vue'

import App from './App.vue'
import Pontos from './Empresas/Pontos.vue'

//Vue.use(Buefy)
const newApp = createApp(App)
const empresasPontos = createApp(Pontos)
//newApp.use(Buefy)
window.Alpine = Alpine;

Alpine.start()
newApp.mount("#app")
empresasPontos.mount("#pontosApp")
