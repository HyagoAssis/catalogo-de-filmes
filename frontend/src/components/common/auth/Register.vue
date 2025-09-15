<template>
  <div class="bg-gray-900 p-8 rounded-lg shadow-lg w-full mx-auto">
    <form @submit.prevent="submit">
      <h2 class="text-2xl font-bold text-white text-center">Registrar</h2>
      <div class="mt-2">
        <label class="text-gray-300 mb-2">Usuário</label>
        <input
          v-model="userToRegister.name"
          type="text"
          class="w-full p-2 rounded bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>

      <div class="mt-2">
        <label class="text-gray-300 mb-2">Email</label>
        <input
          v-model="userToRegister.email"
          type="email"
          class="w-full p-2 rounded bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>

      <div class="mt-2">
        <label class="text-gray-300">Senha</label>
        <input
          v-model="userToRegister.password"
          type="password"
          class="w-full p-2 rounded bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>

      <div class="mt-2">
        <label class="text-gray-300 mb-2">Confirme a senha</label>
        <input
          v-model="userToRegister.password_confirmation"
          type="password"
          class="w-full p-2 rounded bg-gray-700 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>

      <div class="mt-4">
        <button
          type="submit"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded transition-colors"
        >
          Registrar
        </button>
      </div>
    </form>
    <div class="mt-2 text-center">
      <small class="text-white"
        >Já possui conta?
        <span class="underline font-bold cursor-pointer" @click="$emit('change-action', 'login')"
          >Entre!
        </span></small
      >
    </div>
  </div>
</template>

<script>
import { authService } from '@/service/resource.js';

const DEFAULT_USER = {
  name: null,
  email: null,
  password: null,
  password_confirmation: null,
};

export default {
  name: 'Register',

  data() {
    return {
      userToRegister: { ...DEFAULT_USER },
    };
  },

  methods: {
    submit() {
      authService
        .register(this.userToRegister)
        .then(() => {})
        .catch((error) => {
          console.log(error);
        });
    },
  },

  created() {
    authService.csrfToken().then(() => {});
  },
};
</script>
