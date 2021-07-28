<template>
  <app-layout>
    <template #header> Cuisines </template>
    <div class="space-y-4">
      <inertia-link :href="route('cuisine.create')">Add Cuisine</inertia-link>

      <card v-for="cuisine in cuisines" :key="cuisine.id">
        <template #title>
          <span class="flex flex-row justify-between">
            <h3 class="text-lg" v-text="cuisine.name" />
            <span class="flex flex-row space-x-3">
              <inertia-link :href="route('cuisine.edit', { cuisine: cuisine })">
                <jet-button>Edit</jet-button>
              </inertia-link>
              <jet-danger-button
                v-if="!cuisine.system"
                @click="deleteCuisine(cuisine)"
              >
                Delete
              </jet-danger-button>
            </span>
          </span>
        </template>
        {{ cuisine.description }}
      </card>
    </div>
  </app-layout>
</template>
<script>
import JetButton from "@/Jetstream/Button";
import JetDangerButton from "@/Jetstream/DangerButton";
export default {
  components: { JetButton, JetDangerButton },
  props: {
    cuisines: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {};
  },
  mounted() {},
  methods: {
    deleteCuisine(cuisine) {
      if (
        window.confirm(`Are you sure you want to delete "${cuisine.name}"?`)
      ) {
        this.$inertia.delete(route("cuisine.destroy", { cuisine: cuisine }));
      }
    },
  },
};
</script>
