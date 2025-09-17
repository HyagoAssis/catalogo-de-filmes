<template>
  <div class="container m-auto mt-8 relative">
    <div class="ml-2 mb-6">
      <h1 class="text-3xl font-extrabold text-gray-900">🎬 Pesquisar Filmes</h1>
      <p class="text-gray-600 mt-1">Encontre seus filmes favoritos rapidamente</p>
    </div>

    <SearchBar
      v-model="searchText"
      :disabled="!!requests"
      @search="search"
      @clean="clean"
      class="mr-2 ml-2 mb-2"
    />

    <MovieList
      :can-fetch-items="canFetchItems"
      :method="method"
      :params="params"
      :data-key="'results'"
      @busy="requests++"
      @done="requests--"
      :pagination-keys="{
        total: 'total_results',
        page: 'page',
        totalPages: 'total_pages',
      }"
    />
  </div>
</template>

<script>
import Spinner from '@/components/common/Spinner.vue';
import { tmdbService } from '@/service/resource.js';
import MovieList from '@/components/movies/MovieList.vue';
import SearchBar from '@/components/common/SearchBar.vue';

export default {
  components: { SearchBar, Spinner, MovieList },
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
    clean() {
      this.searchText = '';
      this.params.query = '';
    },
  },

  computed: {
    canFetchItems() {
      return this.params && this.params.query;
    },
  },
};
</script>
