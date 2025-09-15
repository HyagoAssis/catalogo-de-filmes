<template>
  <div class="min-h-screen flex flex-col">
    <nav class="bg-gray-900 text-white shadow-md">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
          <div class="flex-shrink-0">
            <router-link to="/" class="text-xl font-bold"> Catálogo de Filmes </router-link>
          </div>

          <div class="hidden md:flex items-center space-x-4">
            <template v-for="route in menuRoutes">
              <router-link
                v-if="route.props"
                :to="route.path"
                class="hover:text-blue-400 font-semibold"
              >
                {{ route.props.title }}
              </router-link>
            </template>

            <template v-if="$user.user">
              <p class="ml-4 font-bold">Olá, {{ $user.user.name }}</p>

              <button
                @click="logout"
                class="cursor-pointer px-4 py-2 border border-red-600 text-red-600 rounded font-semibold transition-colors hover:bg-red-600 hover:text-white"
              >
                Logout
              </button>
            </template>
            <template v-else>
              <button
                @click="showLoginModal"
                class="cursor-pointer px-4 py-2 border border-white text-white rounded font-semibold transition-colors hover:bg-white hover:text-gray-900"
              >
                Entrar
              </button>
              <button
                @click="showRegisterModal"
                class="cursor-pointer px-4 py-2 bg-white text-gray-900 rounded font-semibold transition-colors hover:bg-gray-200"
              >
                Registrar
              </button>
            </template>
          </div>

          <div class="md:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="focus:outline-none">
              <svg
                class="h-6 w-6"
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

      <div v-if="mobileMenuOpen" class="md:hidden bg-gray-800">
        <template v-for="route in menuRoutes">
          <router-link
            v-if="route.props"
            :to="route.path"
            class="block px-4 py-2 text-white hover:bg-gray-700 font-semibold"
            @click="mobileMenuOpen = false"
          >
            {{ route.props.title }}
          </router-link>
        </template>

        <template v-if="$user.user">
          <p class="ml-4 font-bold">Olá, {{ $user.user.name }}</p>

          <button
            @click="logout"
            class="cursor-pointer px-4 py-2 bg-red-600 hover:bg-red-700 rounded font-semibold transition-colors"
          >
            Logout
          </button>
        </template>
        <template v-else>
          <button
            @click="showLoginModal"
            class="cursor-pointer px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded font-semibold transition-colors"
          >
            Logar
          </button>
          <button
            @click="showRegisterModal"
            class="cursor-pointer px-4 py-2 bg-green-600 hover:bg-green-700 rounded font-semibold transition-colors"
          >
            Registrar
          </button>
        </template>
      </div>
    </nav>

    <main class="flex-1">
      <RouterView />

      <AuthModal
        v-model="showAuthModal"
        v-if="actionAuth"
        :action="actionAuth"
        @close="showAuthModal = false"
      />
    </main>
  </div>
</template>

<script>
import AuthModal from '@/components/auth/AuthModal.vue';
import router from '@/router/index.js';

export default {
  name: 'App',
  components: { AuthModal },
  data() {
    return {
      mobileMenuOpen: false,

      showAuthModal: false,
      actionAuth: null,
    };
  },

  watch: {
    showAuthModal: {
      immediate: true,
      handler(to) {
        if (!to) {
          this.actionAuth = null;
        }
      },
    },
  },

  methods: {
    showLoginModal() {
      this.showAuthModal = true;
      this.actionAuth = 'login';
    },

    showRegisterModal() {
      this.showAuthModal = true;
      this.actionAuth = 'register';
    },

    logout() {
      this.$user.logout();
    },
  },

  computed: {
    routes() {
      return router.options.routes;
    },
    menuRoutes() {
      return this.routes.filter((route) => route.props?.showInMenu);
    },
  },
};
</script>
