<template>
  <div
    class="flex flex-col rounded-xl bg-white shadow-md p-4 box-border w-full"
  >
    <slot v-if="$slots.title" name="title"></slot>
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
