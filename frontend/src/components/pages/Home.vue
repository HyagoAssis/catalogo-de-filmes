<template>
  <div class="container m-auto mt-8 relative">
    <div class="relative mb-4">
      <input
        type="text"
        placeholder="Pesquisar..."
        class="w-full pl-4 pr-10 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
        v-model="searchText"
        @keyup.enter="search"
        :disabled="requests"
      />

      <!-- Botão de pesquisa -->
      <button
        class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
        @click="search"
        :disabled="requests"
      >
        🔍
      </button>
    </div>

    <MovieList
      :can-fetch-items="canFetchItems"
      :method="method"
      :params="params"
      :data-key="'results'"
      :pagination-keys="{ total: 'total_results', page: 'page', totalPages: 'total_pages' }"
    />
  </div>
</template>

<script>
import Spinner from '@/components/common/Spinner.vue';
import { tmdbService } from '@/service/resource.js';
import MovieList from '@/components/movies/MovieList.vue';

export default {
  components: { Spinner, MovieList },
  data() {
    return {
      searchText: '',
      params: {
        query: '',
      },
      requests: 0,
      data: null,
      method: tmdbService.searchMovie,
    };
  },

  methods: {
    search() {
      this.params.query = this.searchText;
    },
  },

  computed: {
    canFetchItems() {
      return this.params && this.params.query;
    },
  },
};
</script>
