<template>
  <div class="container m-auto mt-8 relative">
    <h1 class="text-2xl font-bold mb-4 ml-2">Meus favoritos</h1>
    <div class="flex flex-col sm:flex-row items-center gap-2 mb-4 mx-2">
      <SearchBar v-model="searchText" :disabled="!!requests" @search="search" class="w-full h-10" />

      <div class="flex items-center gap-2" v-if="genres">
        <label for="genre" class="text-gray-700 flex items-center h-10"> Gênero: </label>
        <select
          id="genre"
          v-model="params.genre_id"
          @change="search"
          class="border rounded-lg px-3 h-10 sm:w-48 w-full focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"
          :disabled="!!requests"
        >
          <option v-for="genre in genres" :key="genre.id" :value="genre.id">
            {{ genre.name }}
          </option>
        </select>
      </div>
    </div>

    <MovieList
      :can-fetch-items="true"
      :method="method"
      data-key="data"
      pagination-object="meta"
      :pagination-keys="{ total: 'total', page: 'current_page', perPage: 'per_page' }"
      :is-favorite-screen="true"
      :params="params"
      @busy="requests++"
      @done="requests--"
    />
  </div>
</template>

<script>
import MovieList from '@/components/movies/MovieList.vue';
import { favoriteMoviesService, genresService } from '@/service/resource.js';
import SearchBar from '@/components/common/SearchBar.vue';
import Spinner from '@/components/common/Spinner.vue';

export default {
  name: 'FavoritesMovies',
  components: { Spinner, SearchBar, MovieList },

  data() {
    return {
      requests: 0,
      method: favoriteMoviesService.query,
      searchText: null,
      params: {
        query: null,
        genre_id: null,
      },
      genres: [{ id: null, name: 'Todos os gêneros' }],
    };
  },

  methods: {
    search() {
      this.params.query = this.searchText;
    },

    fetchGenres() {
      this.requests++;

      genresService
        .query()
        .then((response) => {
          this.genres = [...this.genres, ...response.data];
        })
        .catch(() => {
          this.$notification.error('Erro!', 'Não foi possível carregar os gêneros');
        })
        .then(() => this.requests--);
    },
  },

  created() {
    this.fetchGenres();
  },
};
</script>
