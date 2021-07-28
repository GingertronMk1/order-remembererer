<template>
  <app-layout>
    <cuisine-form :cuisine="cuisine" />
  </app-layout>
</template>
<script>
import CuisineForm from "@/Components/CuisineForm.vue";
export default {
  components: { CuisineForm },
  props: {
    cuisine: {
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
