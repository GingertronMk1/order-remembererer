<template>
  <app-layout>
    <vendor-order-form v-bind="$props" />
  </app-layout>
</template>
<script>
import VendorOrderForm from "@/Components/VendorOrderForm.vue";
export default {
  components: { VendorOrderForm },
  props: {
    vendor: {
      type: Object,
      required: true,
    },
    order: {
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
