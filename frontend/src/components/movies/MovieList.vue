<template>
  <Spinner v-if="requests" />
  <template v-else-if="!items || items.length === 0">
    <div class="text-center mt-2">
      <p>Nenhum resultado encontrado</p>
    </div>
  </template>
  <template v-else>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
      <div v-for="item in items" :key="item.id" class="ml-2 mr-2">
        <MovieItem :movie="item" :is-favorite-screen="isFavoriteScreen" @reloadPage="fetchItems" />
      </div>
    </div>

    <Pagination v-if="pagination" :pagination="pagination" @change-page="changePage" />
  </template>
</template>

<script>
import Spinner from '@/components/common/Spinner.vue';
import axios from 'axios';
import MovieItem from './MovieItem.vue';
import Pagination from '@/components/common/Pagination.vue';

const CancelToken = axios.CancelToken;
export default {
  name: 'MovieList',
  components: { Pagination, MovieItem, Spinner },

  props: {
    method: {
      type: Function,
      required: true,
    },
    params: Object,
    headers: Array,
    dataKey: String,
    paginationKeys: Object,
    canFetchItems: false,
    paginationObject: null,
    isFavoriteScreen: false,
  },

  emits: ['busy', 'done'],

  data() {
    return {
      requests: 0,
      items: null,
      pagination: {
        perPage: null,
        currentPage: 1,
        pageItemsCount: null,
        totalItemsCount: null,
      },
      cancelToken: undefined,
    };
  },
  watch: {
    method: {
      immediate: true,
      handler(to) {
        if (to) {
          this.fetchItems();
        }
      },
    },

    params: {
      immediate: true,
      deep: true,
      handler(to) {
        if (to) {
          this.changePage(1);
          this.fetchItems();
        }
      },
    },

    'pagination.currentPage'() {
      this.fetchItems();
    },
  },

  methods: {
    fetchItems() {
      if (!this.canFetchItems) {
        this.items = null;
        return;
      }

      if (this.requestCancelToken) {
        this.requestCancelToken.cancel();
        this.requestCancelToken = undefined;
      }

      this.requests++;
      this.$emit('busy');

      this.requestCancelToken = CancelToken.source();

      this.method(
        { page: this.pagination.currentPage, ...this.params },
        {
          cancelToken: this.requestCancelToken.token,
        }
      )
        .then((response) => {
          this.items = response.data[this.dataKey];

          this.updatePagination(
            !this.paginationObject ? response.data : response.data[this.paginationObject]
          );
        })
        .catch((error) => {
          this.items = null;
          if (!axios.isCancel(error)) {
            this.$notification.error('Erro!', 'Não foi possível carregar os resultados');
          }
        })
        .then(() => {
          this.requests--;
          this.$emit('done');
        });
    },

    updatePagination(resourcePagination) {
      if (resourcePagination) {
        this.pagination.perPage = resourcePagination[this.paginationKeys.perPage]
          ? resourcePagination[this.paginationKeys.perPage]
          : resourcePagination[this.paginationKeys.total] /
            resourcePagination[this.paginationKeys.totalPages];
        this.pagination.currentPage = resourcePagination[this.paginationKeys.page];
        this.pagination.totalItemsCount = resourcePagination[this.paginationKeys.total];
      }
    },

    changePage(page) {
      this.pagination.currentPage = page;
    },
  },
};
</script>
