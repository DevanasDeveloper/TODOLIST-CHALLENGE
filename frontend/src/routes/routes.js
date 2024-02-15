import LoginApp from "../pages/LoginApp.vue";
import RegisterApp from "../pages/RegisterApp.vue";
import DashboardApp from "../pages/DashboardApp.vue";
import TodoListApp from "../pages/TodoListApp.vue";
import {createRouter,createWebHistory} from 'vue-router';

const routes = [
    {
        name:"dashboard",
        path:"/",
        component: DashboardApp,
        meta: { requiresAuth: true }
    },
    {
        name:"todolist",
        path:"/todolist",
        component: TodoListApp,
        meta: { requiresAuth: true }
    },
    {
        name:"register",
        path:"/register",
        component:RegisterApp,
        meta: { requiresAuth: false }
    },
    {
        name:"login",
        path:"/login",
        component:LoginApp,
        meta: { requiresAuth: false }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = localStorage.getItem('token');
    if (to.meta.requiresAuth && !isAuthenticated) {
        next('/login');
    } else if((to.path === '/login' || to.path === '/register') && isAuthenticated){
        next('/');
    }else{
        next();
    }
});

export default router;