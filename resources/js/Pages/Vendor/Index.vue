<template>
  <app-layout>
    <template #header> Vendors </template>
    <div class="space-y-4">
      <inertia-link :href="route('vendor.create')">Add Vendor</inertia-link>

      <card v-for="vendor in vendors" :key="vendor.id">
        <template #title>
          <span class="flex flex-row justify-between">
            <h3 class="text-lg" v-text="vendor.name" />
            <span class="flex flex-row space-x-3">
              <inertia-link
                :href="route('vendor.order.index', { vendor: vendor })"
              >
                <jet-button>View Team Orders</jet-button>
              </inertia-link>
              <inertia-link :href="route('vendor.edit', { vendor: vendor })">
                <jet-button>Edit</jet-button>
              </inertia-link>
              <jet-danger-button
                v-if="!vendor.system"
                @click="deleteVendor(vendor)"
              >
                Delete
              </jet-danger-button>
            </span>
          </span>
        </template>
        {{ vendor.description }}
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
    vendors: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {};
  },
  mounted() {},
  methods: {
    deleteVendor(vendor) {
      if (window.confirm(`Are you sure you want to delete "${vendor.name}"?`)) {
        this.$inertia.delete(route("vendor.destroy", { vendor: vendor }));
      }
    },
  },
};
</script>
