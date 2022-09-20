import { createRouter, createWebHistory } from 'vue-router'

import HomeEmpresa from 'resources/js/components/Empresas/Home/Home.vue'
import Relatorios from 'resources/js/components/Empresas/Home/Relatorios.vue'
import FuncionarioNovo from 'resources/js/components/Empresas/funcionario/Cadastro.vue'

let baseEmpresaHistory = '/empresa/home'

const routes = [
    /* {
      path: '/',
      name: 'home',
      component: HomeEmpresa,
    }, */
    { path: baseEmpresaHistory, name: 'home.empresa', component: HomeEmpresa },
    { path: baseEmpresaHistory + '/relatorios-funcionario/:id', name: 'relatorios', component: Relatorios, props: true },
    { path: baseEmpresaHistory + '/funcionario/cadastro', name: 'empresa.funcionario.cadastro', component: FuncionarioNovo }
]

//let baseHistory = '/empresa/'



// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { x: 0, y: 0 }
        }
    }

})

export default router;
