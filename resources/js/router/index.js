import { createRouter, createWebHistory } from 'vue-router'

import HomeEmpresa from '@/components/Empresas/Home/Home.vue'
import Relatorios from '@/components/Empresas/Home/Relatorios.vue'
import FuncionarioNovo from '@/components/Empresas/funcionario/Cadastro.vue'

const routes = [
    {
      path: '/',
      name: 'home',
      component: HomeEmpresa,
    },
    { path: '/empresa/home', name: 'home.empresa', component: HomeEmpresa },
    { path: '/relatorios-funcionario/:id', name: 'relatorios', component: Relatorios, props: true },
    { path: '/empresa/funcionario/cadastro', name: 'empresa.funcionario.cadastro', component: FuncionarioNovo }
]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = createRouter({
    history: createWebHistory('/empresa/home/'),
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
