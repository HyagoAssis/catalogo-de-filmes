<template>
  <div
    class="bg-gray-900 flex items-center justify-center rounded-lg border border-gray-700 shadow-xl"
  >
    <div class="p-8 w-full">
      <form @submit.prevent="submit" class="flex flex-col items-center">
        <h2 class="text-3xl font-extrabold text-white mb-4 text-center">Sair</h2>

        <p class="text-gray-300 mb-8 text-center">Tem certeza que deseja sair da sua conta?</p>

        <button
          type="submit"
          class="cursor-pointer w-full bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-400 text-white font-semibold py-3 rounded-xl shadow-lg transition duration-300 ease-in-out"
        >
          Sair
        </button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Logout',

  methods: {
    submit() {
      this.$user.logout();
    },
  },
};
</script>
