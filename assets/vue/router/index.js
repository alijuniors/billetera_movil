import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Registro from '../views/Registro.vue'
import Recarga from '../views/Recarga.vue'
import Pago from '../views/Pago.vue'
import Consulta from '../views/Consulta.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/registro',
    name: 'Registro',
    component: Registro
  },
  {
    path: '/recarga',
    name: 'Recarga',
    component: Recarga
  },
  {
    path: '/pago',
    name: 'Pago',
    component: Pago
  },
  {
    path: '/consulta',
    name: 'Consulta',
    component: Consulta
  }
]

const router = new VueRouter({
  routes
})

export default router
