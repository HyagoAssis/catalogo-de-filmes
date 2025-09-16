import { createWebHistory, createRouter } from 'vue-router';
import { routes } from '@/router/routes.js';
import { User } from '@/global-scopes/user.js';

export const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Navigation guard global
router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !User.isLogged()) {
    // Redireciona para a página inicial se não estiver logado
    next({ name: 'home' });
  } else {
    next();
  }
});

export default router;
