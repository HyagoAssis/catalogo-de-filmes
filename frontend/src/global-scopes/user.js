import { authService } from '@/service/resource.js';
import { reactive } from 'vue';
import alerts from '@/global-scopes/alerts.js';

export const User = reactive({
  user: null,

  async fetchUser() {
    await authService
      .getUser()
      .then((response) => {
        this.setUser(response.data);
      })
      .catch((error) => {
        if (error.response?.status === 419) {
          this.setSession(false, true);
        }
      });
  },

  setSession(fetchUser = false, forceCsrf = false) {
    this.ensureCsrf(forceCsrf);

    if (fetchUser) {
      this.fetchUser().then(() => {
        window.location.reload();
      });
      return;
    }

    const user = localStorage.getItem('user');

    if (user) {
      this.user = JSON.parse(user);
    }
  },

  ensureCsrf(force = false) {
    if (!document.cookie.includes('XSRF-TOKEN') || force) {
      authService.csrfToken();
    }
  },

  isLogged() {
    return !!this.user;
  },

  logout() {
    authService
      .logout()
      .then(() => {
        this.user = null;

        localStorage.removeItem('user');

        window.location.reload();
      })
      .catch(() => {
        console.log('Não foi possível deslogar');
      });
  },

  setUser(user) {
    localStorage.setItem('user', JSON.stringify(user));
    this.user = user;
  },
});
