<template>
  <div class="min-h-screen flex flex-col">
    <nav class="bg-gray-900 text-white shadow-lg sticky top-0 z-50">
      <div class="container m-auto px-2">
        <div class="flex justify-between h-16 items-center">
          <router-link
            to="/"
            class="text-2xl font-extrabold tracking-tight text-white hover:border-b-2 hover:border-white transition-colors"
          >
            🎬 Catálogo de Filmes
          </router-link>

          <div class="hidden md:flex items-center space-x-6">
            <template v-for="route in menuRoutes" :key="route.path">
              <router-link
                v-if="route.props"
                :to="route.path"
                class="hover:border-b-2 hover:border-white font-medium transition-colors"
              >
                {{ route.props.title }}
              </router-link>
            </template>

            <template v-if="$user.user">
              <p class="ml-6 font-semibold">
                Olá, <span class="font-extrabold">{{ $user.user.name }}</span>
              </p>
              <button
                @click="showLogoutModal"
                class="cursor-pointer px-4 py-2 border border-red-500 text-red-500 rounded-lg font-semibold transition-colors hover:bg-red-600 hover:text-white"
              >
                Sair
              </button>
            </template>

            <template v-else>
              <button
                @click="showLoginModal"
                class="cursor-pointer px-4 py-2 border border-white text-white rounded-lg font-semibold transition-colors hover:bg-white hover:text-gray-900"
              >
                Entrar
              </button>
              <button
                @click="showRegisterModal"
                class="cursor-pointer px-4 py-2 bg-white text-gray-900 hover:bg-gray-200 rounded-lg font-semibold transition-colors"
              >
                Registrar
              </button>
            </template>
          </div>

          <div class="md:hidden">
            <button
              @click="mobileMenuOpen = !mobileMenuOpen"
              class="cursor-pointer focus:outline-none"
            >
              <svg
                class="h-7 w-7"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  v-if="!mobileMenuOpen"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
                <path
                  v-else
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <div v-if="mobileMenuOpen" class="md:hidden bg-gray-800 border-t border-gray-700">
        <template v-for="route in menuRoutes" :key="route.path">
          <router-link
            v-if="route.props"
            :to="route.path"
            class="block px-4 py-2 text-white hover:bg-gray-700 font-medium transition-colors"
            @click="mobileMenuOpen = false"
          >
            {{ route.props.title }}
          </router-link>
        </template>

        <div v-if="$user.user" class="flex flex-col items-center py-4 space-y-2">
          <p class="font-semibold">
            Olá, <span class="font-extrabold">{{ $user.user.name }}</span>
          </p>
          <button
            @click="showLogoutModal"
            class="cursor-pointer px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg font-semibold transition-colors"
          >
            Sair
          </button>
        </div>
        <div v-else class="flex flex-col items-center py-4 space-y-2">
          <button
            @click="showLoginModal"
            class="cursor-pointer px-4 py-2 border border-white text-white rounded-lg font-semibold transition-colors hover:bg-white hover:text-gray-900"
          >
            Entrar
          </button>
          <button
            @click="showRegisterModal"
            class="cursor-pointer px-4 py-2 bg-white text-gray-900 hover:bg-gray-200 rounded-lg font-semibold transition-colors"
          >
            Registrar
          </button>
        </div>
      </div>
    </nav>

    <main class="flex-1">
      <RouterView />

      <AuthModal v-model="authModal.show" :action="authModal.action" @close="authModal.close()" />
    </main>
  </div>
</template>

<script>
import AuthModal from '@/components/auth/AuthModal.vue';
import router from '@/router/index.js';
import { authModalStore } from '@/global-scopes/auth-modal.js';

export default {
  name: 'App',
  components: { AuthModal },
  setup() {
    return {
      authModal: authModalStore,
    };
  },
  data() {
    return {
      mobileMenuOpen: false,
    };
  },
  methods: {
    showLogoutModal() {
      this.authModal.open('logout');
    },
    showLoginModal() {
      this.authModal.open('login');
    },
    showRegisterModal() {
      this.authModal.open('register');
    },
  },
  computed: {
    routes() {
      return router.options.routes;
    },
    menuRoutes() {
      return this.routes.filter((route) => {
        const requiresAuth = route.meta?.requiresAuth ?? false;
        return route.props?.showInMenu && (!requiresAuth || this.$user.isLogged());
      });
    },
  },
};
</script>
