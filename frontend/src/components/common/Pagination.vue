<template>
  <nav class="mt-2 mb-4 flex justify-center">
    <ul class="inline-flex items-center space-x-1">
      <!-- Previous -->
      <li>
        <button
          @click="$emit('change-page', pagination.currentPage - 1)"
          :disabled="pagination.currentPage === 1"
          class="cursor-pointer px-3 py-1 rounded-md text-gray-500 hover:text-white hover:bg-gray-900 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 inline-block"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 19l-7-7 7-7"
            />
          </svg>
        </button>
      </li>

      <template v-for="page in pages" :key="page">
        <li>
          <button
            @click="$emit('change-page', page)"
            :disabled="page === '...'"
            :class="[
              'cursor-pointer px-3 py-1 rounded-md font-semibold',
              pagination.currentPage === page
                ? 'bg-gray-900 text-white'
                : 'text-gray-700 hover:bg-gray-200',
            ]"
          >
            {{ page }}
          </button>
        </li>
      </template>

      <!-- Next -->
      <li>
        <button
          @click="$emit('change-page', pagination.currentPage + 1)"
          :disabled="pagination.currentPage === totalPages"
          class="cursor-pointer px-3 py-1 rounded-md text-gray-500 hover:text-white hover:bg-gray-900 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 inline-block"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 5l7 7-7 7"
            />
          </svg>
        </button>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: 'Pagination',

  props: {
    pagination: Object,
  },

  computed: {
    totalPages() {
      return Math.ceil(this.pagination.totalItemsCount / this.pagination.perPage);
    },

    pages() {
      let pages = [1];

      if (this.totalPages === 1) {
        return pages;
      }

      let middle = [];

      for (
        let i = this.pagination.currentPage - 4 < 2 ? 2 : this.pagination.currentPage - 3;
        i <
        (this.pagination.currentPage + 4 > this.totalPages
          ? this.totalPages
          : this.pagination.currentPage + 4);
        i++
      ) {
        middle.push(i);
      }

      if (middle.length > 0) {
        if (middle[0] - 1 > 1) middle[0] = '...';

        if (middle[middle.length - 1] + 1 < this.totalPages) middle[middle.length - 1] = '...';

        middle.forEach((val) => {
          pages.push(val);
        });
      }

      pages.push(this.totalPages);

      return pages;
    },
  },
};
</script>
