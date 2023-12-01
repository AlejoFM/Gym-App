import { createRouter, createWebHistory } from "vue-router"
import projects from "@/components/projects.vue";
import login from "@/components/login.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/login',
            name: 'login',
            component: login
        },
        {
            path: '/projects',
            name: 'projects',
            component: projects,
            meta: {
                requiresAuth: true,
            },
        },
    ]
})

export default router