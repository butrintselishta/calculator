import { createRouter, createWebHistory } from 'vue-router';
import Login from './pages/Login.vue';
import Calculator from './pages/Calculator.vue';

const routes = [
  { path: '/login', component: Login },
  { path: '/calculator', component: Calculator, name: 'calculator', meta: { requiresAuth: true } },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('authToken');
    if (to.matched.some((record) => record.meta.requiresAuth)) {
      if (!token) {
        next('/login');
      } else {
        next();
      }
    } else {
        if (token) next('/calculator')
        else next();
    }
  });

export default router;
