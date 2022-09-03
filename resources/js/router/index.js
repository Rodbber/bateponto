import {createRouter, createWebHistory} from 'vue-router'

import HomeEmpresa from '@/components/Empresas/Home/Home.vue'
import Relatorios from '@/components/Empresas/Home/Relatorios.vue'

const routes = [
    { path: '/empresa/home', name:'HomeEmpresa', component: HomeEmpresa },
    { path: '/empresa/relatorios-funcionario', name:'Relatorios', component: Relatorios }
  ]

  // 3. Create the router instance and pass the `routes` option
  // You can pass in additional options here, but let's
  // keep it simple for now.
  const router = createRouter({
    history:createWebHistory(),
    routes // short for `routes: routes`
  })

export default router;
