<template>
  <h1>Won't be a moment, just getting your timezone...</h1>
</template>
<script>
export default {
  props: {
    purchaseId: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {};
  },
  mounted() {
    let tz = "UTC";
    if (Intl.DateTimeFormat().resolvedOptions().timeZone !== undefined) {
      tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
    }
    window.location.href = route("purchase.pdf", {
      purchase: this.purchaseId,
      timezone: tz,
    });
  },
  methods: {},
};
</script>
