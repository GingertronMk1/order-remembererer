<template>
  <div>
    Purchase expired! Click
    <a
      target="_blank"
      class="font-black"
      :href="route('purchase.pdf', { purchase: notification.data.purchase })"
      >here</a
    >
    to download the purchase.
  </div>
</template>
<script>
export default {
  props: {
    notification: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {};
  },
  mounted() {},
  methods: {},
};
</script>
