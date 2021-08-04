<template>
  <card>
    {{ notification.type }}
    <pre v-text="notification.data" />
  </card>
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
