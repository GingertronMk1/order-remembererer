<template>
  <app-layout>
    <div class="flex flex-col space-y-2">
      <inertia-link :href="route('purchase.create')"
        >Start new Purchase</inertia-link
      >

      <card v-for="purchase in purchases" :key="'purchase' + purchase.id">
        <template #title>
          <span v-text="purchase.vendor.name" />
          <span v-text="new Date(purchase.expires_at).toLocaleString()" />
        </template>

        <ul
          v-for="invitation in purchase.invitations"
          :key="'invitation' + invitation.id"
        >
          <li v-text="invitation.user.name"></li>
        </ul>
      </card>
    </div>
  </app-layout>
</template>
<script>
export default {
  props: {
    purchases: {
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
