<template>
  <div class="container m-auto mt-8 relative">
    <h1 class="text-2xl font-bold mb-4 ml-2">Pesquisar Filmes</h1>

    <SearchBar
      v-model="searchText"
      :disabled="!!requests"
      @search="search"
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
  },

  computed: {
    canFetchItems() {
      return this.params && this.params.query;
    },
  },
};
</script>
