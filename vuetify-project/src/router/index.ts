// Composables
import { createRouter, createWebHistory } from 'vue-router'
import login from "@/views/Login.vue";
import routines from "@/views/Routines.vue";
import dashboard from "@/views/Dashboard.vue"
import dashboardClientInfo from "@/components/dashboardClientInfo.vue";
import Unauthorized from "@/views/Unauthorized.vue";
import Notfound from "@/views/Notfound.vue";
import dashboardExercises from "@/components/dashboardExercises.vue";
import DashboardExercisesList from "@/components/DashboardExercisesList.vue";
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/:catchAll(.*)', redirect: '/notfound',},
    { path: '/login', name: 'login', component: login, meta: {requiresAuth: false,}},
    { path:'/', name: 'home', component: routines, meta: { requiresAuth: true, isAdmin: false,}},
    { path:'/dashboard', name: 'dashboard', component: dashboard, meta:{ requiresAuth: true, isAdmin : true,}},
    { path:'/dashboard/users/:user_id', name: 'user-routine', component: dashboardClientInfo, meta:{ requiresAuth: true, isAdmin: true,}},
    { path: '/unauthorized', name: 'unauthorized', component: Unauthorized, meta:{ requiresAuth: false, isAdmin: false,}},
    { path: '/notfound', name: 'notfound', component: Notfound, meta:{requiresAuth: false, isAdmin: false,}},
    { path: '/dashboard/exercises', name: 'exercises', component: dashboardExercises, meta:{ requiresAuth: true, isAdmin: true,}},
    { path: '/dashboard/exercises/:exercise_muscular_group', name: 'exercises_list', component: DashboardExercisesList, meta:{ requiresAuth: true, isAdmin: true,}},
  ]
});
router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    const token = localStorage.getItem('token');
    const user = localStorage.getItem('user');
    if (!token || !user) {
      next('/login');
      return;
    }
    const userRole = JSON.parse(user).rol;

    if (userRole !== "admin" && to.meta.isAdmin === true) {
      if (to.path.endsWith('/unauthorized')) {
        next();
      } else {
        next('/unauthorized')
      }
    } else {
      next();
    }
  } else {
    next();
  }
});


export default router
