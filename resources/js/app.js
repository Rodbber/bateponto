import './bootstrap';

import Alpine from 'alpinejs';

import {createApp} from 'vue/dist/vue.esm-bundler'

import router from '@/router';

import Empresa from '@/components/Empresas/Home.vue'

import Pontos from '@/components/Empresas/Pontos.vue'
import CadastroFuncionario from '@/components/Empresas/Funcionario/Cadastro.vue'

import AppFuncionario from '@/components/Funcionarios/Home.vue'

import Oruga from '@oruga-ui/oruga-next';
import '@oruga-ui/oruga-next/dist/oruga-full.css';
import mdiVue from 'mdi-vue/v3'
import * as mdijs from '@mdi/js'

import store from './store';



const appf = createApp(AppFuncionario)

//Vue.use(Buefy)
const newApp = createApp(Empresa)
.use(store)
.use(Oruga)
.use(router)
.use(mdiVue,{
    icons: mdijs
})
const empresasPontos = createApp(Pontos).use(mdiVue,{
    icons: mdijs
})
empresasPontos.use(Oruga);
empresasPontos.use(store);
//newApp.use(Buefy)
window.Alpine = Alpine;

const appCadastroFuncionario = createApp(CadastroFuncionario)
.use(store)
.use(Oruga)
.use(mdiVue,{
    icons: mdijs
})

Alpine.start()
newApp.mount("#app")
empresasPontos.mount("#pontosApp")
appCadastroFuncionario.mount("#appCadastroFuncionario")
appf.mount("#appFuncionario")
