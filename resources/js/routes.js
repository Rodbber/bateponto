import Router from 'vue-router'

const routes = [
    { path: '/', component: () => import('./components/Empresas/Home.vue') },
    {
        path: '/cadastro/funcionario',
        name: 'funcionario.cadastro',
        component: () => import('./components/Empresas/Funcionario/Cadastro.vue')
    },
    {
        path: '/cadastro/funcionario/:id',
        name: 'funcionario.edit',
        component: () => import('./components/Empresas/Funcionario/Cadastro.vue')
    },
]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = Router.createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: Router.createWebHashHistory(),
    routes, // short for `routes: routes`
})

export default router;
