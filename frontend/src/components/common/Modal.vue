<template>
  <div
    v-if="modelValue"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/30"
    @click.self="closeModal"
  >
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl">
      <!-- Header -->
      <div v-if="$slots.header" class="flex items-center justify-between px-4 py-2 border-b">
        <h2 class="text-lg font-bold">
          <slot name="header" />
        </h2>
        <button
          type="button"
          class="text-gray-400 hover:text-gray-600 cursor-pointer"
          @click="closeModal"
        >
          ✕
        </button>
      </div>

      <!-- Body -->
      <div>
        <slot />
      </div>

      <!-- Footer -->
      <div v-if="$slots.footer" class="flex justify-end px-4 py-2">
        <slot name="footer" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Modal',
  props: {
    modelValue: Boolean,
  },
  emits: ['update:modelValue'],
  setup(props, { emit }) {
    const closeModal = () => {
      emit('update:modelValue', false);
    };

    return { closeModal };
  },
};
</script>
