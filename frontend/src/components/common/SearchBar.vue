<template>
  <div class="relative">
    <input
      type="text"
      placeholder="Pesquisar..."
      class="w-full pl-4 pr-10 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      @keyup.enter="$emit('search')"
      :disabled="disabled"
    />

    <button
      class="cursor-pointer absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
      @click="$emit('search')"
      :disabled="disabled"
    >
      🔍
    </button>
  </div>
</template>

<script>
export default {
  name: 'SearchBar',
  props: {
    modelValue: {
      type: String,
      default: '',
    },
    disabled: Boolean,
  },
  emits: ['update:modelValue', 'search'],
};
</script>
