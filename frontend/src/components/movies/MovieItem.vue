<template>
  <div class="relative mt-2 max-w-2xl mx-auto bg-white shadow-md overflow-hidden flex h-60">
    <div class="flex-shrink-0 bg-gray-200 w-40 h-60 flex items-center justify-center">
      <img
        v-if="movie.poster_path"
        :src="'https://image.tmdb.org/t/p/w500/' + movie.poster_path"
        :alt="title"
        class="w-full h-full object-cover"
      />
      <span v-else class="text-gray-500 text-sm">Sem imagem</span>
    </div>

    <div class="p-4 flex flex-col flex-1 justify-between">
      <div>
        <div class="flex justify-between items-start">
          <h2 class="text-lg font-semibold text-gray-900">
            {{ title }}
          </h2>
          <button
            @click="isFavoriteScreen ? deleteFavoriteMovie(movie.id) : setFavorite(movie)"
            :title="
              isFavoriteScreen || movie.is_favorite
                ? 'Remover dos favoritos'
                : 'Inserir aos favoritos'
            "
            class="cursor-pointer transition-colors"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6"
              :class="
                movie.is_favorite || isFavoriteScreen
                  ? 'text-red-600 hover:text-gray-400'
                  : 'text-gray-400 hover:text-red-600'
              "
              viewBox="0 0 24 24"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28
         2 8.5 2 6 4 4 6.5 4c1.74 0 3.41 1
         4.5 2.09C12.09 5 13.76 4 15.5 4
         18 4 20 6 20 8.5c0 3.78-3.4 6.86-8.55
         11.54L12 21.35z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
        </div>

        <p class="mt-2 text-sm text-gray-600 line-clamp-4" :title="movie.overview">
          {{ movie.overview }}
        </p>
      </div>
      <p class="mt-4 text-sm text-gray-500">{{ formatGenres(movie.genres) }}</p>

      <p class="mt-4 text-sm text-gray-500 text-right">
        {{ moment(movie.release_date).format('DD/MM/YYYY') }}
      </p>
    </div>
  </div>
</template>

<script>
import moment from 'moment';
import { favoriteMoviesService } from '@/service/resource.js';
import { authModalStore } from '@/global-scopes/auth-modal.js';

export default {
  name: 'MovieItem',

  props: {
    movie: {
      type: Object,
      required: true,
    },
    isFavoriteScreen: false,
  },

  data() {
    return {
      moment,
    };
  },

  computed: {
    title() {
      return this.movie.original_title ?? this.movie.name;
    },
  },

  methods: {
    setFavorite(movie) {
      if (!this.$user || !this.$user.user) {
        authModalStore.open('login');
        return;
      }

      const promise = movie.is_favorite
        ? this.isFavoriteScreen
          ? favoriteMoviesService.delete(movie.id)
          : favoriteMoviesService.deleteByMovieDbId(movie.id)
        : favoriteMoviesService.save({
            name: movie.original_title,
            genres: movie.genre_ids,
            movie_db_id: this.isFavoriteScreen ? movie.movie_db_id : movie.id,
            overview: movie.overview,
            poster_path: movie.poster_path,
            release_date: movie.release_date,
          });

      promise
        .then(() => {
          movie.is_favorite = !movie.is_favorite;
        })
        .catch(() => this.$notification.error('Erro!', 'Não foi possível salvar'));
    },

    deleteFavoriteMovie(id) {
      favoriteMoviesService
        .delete(id)
        .then(() => {})
        .catch(() => this.$notification.error('Erro!', 'Não foi possível salvar'))
        .then(() => {
          this.$emit('reloadPage');
        });
    },

    formatGenres(genres) {
      if (!genres) {
        return;
      }

      return genres.map((genre) => genre.name).join(', ');
    },
  },
};
</script>
