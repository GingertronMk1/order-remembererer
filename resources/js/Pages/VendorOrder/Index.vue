<template>
  <app-layout>
    <template #header>
      Orders in Team {{ $page.props.user.current_team.name }} for
      {{ vendor.name }}
    </template>
    <div class="space-y-4">
      <inertia-link :href="route('vendor.order.create', { vendor: vendor })"
        >Add Order</inertia-link
      >

      <card v-for="order in orders" :key="order.id">
        <template #title>
          <span class="flex flex-row justify-between">
            <h3 class="text-lg" v-text="order.user.name" />
            <span
              v-if="order.user_id === $page.props.user.id"
              class="flex flex-row space-x-3"
            >
              <inertia-link
                :href="
                  route('vendor.order.edit', { vendor: vendor, order: order })
                "
              >
                <jet-button>Edit</jet-button>
              </inertia-link>
              <jet-danger-button @click="deleteOrder(order)"
                >Delete</jet-danger-button
              >
            </span>
          </span>
        </template>
        <ul>
          <li v-text="order.food" />
          <li v-text="order.drink" />
          <li v-text="order.other" />
        </ul>
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
    orders: {
      type: Array,
      default: () => [],
    },
    vendor: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {};
  },
  mounted() {},
  methods: {
    deleteOrder(order) {
      if (window.confirm("Are you sure you want to delete this order?")) {
        this.$inertia.delete(
          route("vendor.order.destroy", { vendor: this.vendor, order: order })
        );
      }
    },
  },
};
</script>
