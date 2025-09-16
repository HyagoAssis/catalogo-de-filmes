import { authService } from '@/service/resource.js';
import { reactive } from 'vue';

export const User = reactive({
  user: null,

  fetchUser() {
    authService
      .getUser()
      .then((response) => {
        this.setUser(response.data);
      })
      .catch((error) => {
        if (error.response?.status === 419) {
          this.setSession(true);
        }
      });
  },

  setSession(forceCsrf = false) {
    this.ensureCsrf(forceCsrf);

    const user = localStorage.getItem('user');

    if (user) {
      this.user = JSON.parse(user);
    } else {
      this.fetchUser();
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
    authService.logout();

    this.user = null;
    localStorage.removeItem('user');
  },

  setUser(user) {
    localStorage.setItem('user', JSON.stringify(user));
    this.user = user;
  },
});
