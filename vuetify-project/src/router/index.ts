// Composables
import { createRouter, createWebHistory } from 'vue-router'
import login from "@/views/Login.vue";
import routines from "@/views/Routines.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: login
    },
    {
      path:'/',
      name: 'home',
      component: login
    },
    {
      path:'/routines',
      name: 'routine',
      component: routines
    },
  ]
})

export default router
