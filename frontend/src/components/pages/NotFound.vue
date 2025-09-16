<template>
  <div class="flex justify-center items-center mt-10 overflow-hidden">
    <div class="flex flex-col items-center space-y-4 text-center px-4 max-w-md">
      <h1 class="text-6xl font-bold text-red-600 leading-none">404</h1>
      <h2 class="text-2xl font-semibold">Página não encontrada</h2>
      <p class="text-gray-600">A página que você está procurando não existe ou foi removida.</p>
      <router-link
        to="/"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition-colors"
      >
        Voltar para a página inicial
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NotFound',
};
</script>
