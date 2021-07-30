<template>
  <app-layout>
    <vendor-form v-bind="$props" />
  </app-layout>
</template>
<script>
import VendorForm from "@/Components/VendorForm.vue";
export default {
  components: { VendorForm },
  props: {
    vendor: {
      type: Object,
      required: true,
    },
    cuisines: {
      type: Array,
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
