<template>
  <div
    class="flex flex-col rounded-xl bg-white shadow-md p-4 box-border w-full"
  >
    <div
      v-if="$slots.title"
      class="flex flex-row justify-between align-center text-xl"
    >
      <slot name="title"></slot>
    </div>
    <hr class="my-2" />
    <slot></slot>
  </div>
</template>
<script>
export default {
  components: {},
  props: {},
  data() {
    return {};
  },
  mounted() {},
  methods: {},
};
</script>
