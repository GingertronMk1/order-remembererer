<template>
  <label class="block font-medium text-sm text-gray-700">
    <span v-if="value" v-text="value" />
    <span v-else><slot></slot></span>
  </label>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
      required: true,
    },
  },
};
</script>
