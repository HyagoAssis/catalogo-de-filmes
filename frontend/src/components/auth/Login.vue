<template>
  <div class="bg-gray-900 p-8 rounded-lg shadow-lg w-full mx-auto">
    <form @submit.prevent="submit">
      <h2 class="text-2xl font-bold text-white text-center mb-6">Entrar</h2>

      <!-- Email -->
      <div class="mb-4">
        <label class="text-gray-300 block mb-2">Email</label>
        <input
          v-model="userToRegister.email"
          type="email"
          placeholder="Digite seu email"
          class="w-full p-3 rounded bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
          required
        />
      </div>

      <!-- Senha -->
      <div class="mb-6">
        <label class="text-gray-300 block mb-2">Senha</label>
        <input
          v-model="userToRegister.password"
          type="password"
          placeholder="Digite sua senha"
          class="w-full p-3 rounded bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-colors"
          required
        />
      </div>
      <div v-if="errorMessage">
        <p class="text-red-500">{{ errorMessage }}</p>
      </div>
      <div>
        <button
          type="submit"
          class="cursor-pointer w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg shadow-md transition-colors"
        >
          Entrar
        </button>
      </div>
    </form>
    <div class="mt-2 text-center">
      <small class="text-white"
        >Ainda não possui conta?
        <span class="underline font-bold cursor-pointer" @click="$emit('change-action', 'register')"
          >Faça o cadastro!
        </span></small
      >
    </div>
  </div>
</template>

<script>
import { authService } from '@/service/resource.js';

const DEFAULT_USER = {
  email: null,
  password: null,
};

export default {
  name: 'Login',

  data() {
    return {
      userToRegister: { ...DEFAULT_USER },
      errorMessage: null,
    };
  },

  methods: {
    submit() {
      authService
        .login(this.userToRegister)
        .then(() => {
          this.$user.setSession(true);
        })
        .catch((error) => {
          this.errorMessage =
            error?.response.data?.message ??
            'Não foi possível realizar login, verique os campos e tente novamente';
        });
    },
  },
};
</script>
