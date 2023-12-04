// Composables
import { createRouter, createWebHistory } from 'vue-router'
import login from "@/views/Login.vue";
import routines from "@/views/Routines.vue";
import dashboard from "@/views/Dashboard.vue"
import dashboardClientInfo from "@/components/dashboardClientInfo.vue";
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: login,
      meta: {
        requiresAuth: false,
      }
    },
    {
      path:'/',
      name: 'home',
      component: routines,
      meta: {
        requiresAuth: true,
      }
    },
    {
      path:'/dashboard',
      name: 'dashboard',
      component: dashboard,
      meta:{
        requiresAuth: true,
      }
    },
    {
      path:'/userRoutine',
      name: 'userRoutine',
      component: dashboardClientInfo,
      meta:{
        requiresAuth: true,
      }
    }
  ]
});
router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    const token = localStorage.getItem('token');
    if (token) {
      // User is authenticated, proceed to the route
      next();
    } else {
      // User is not authenticated, redirect to login
      next('/login');
    }
  } else {
    // Non-protected route, allow access
    next();
  }
});

export default router
