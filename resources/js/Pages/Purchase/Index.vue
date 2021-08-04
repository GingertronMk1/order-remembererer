<template>
  <app-layout>
    <div class="flex flex-col space-y-2">
      <inertia-link :href="route('purchase.create')"
        >Start new Purchase</inertia-link
      >

      <card v-for="purchase in purchases" :key="'purchase' + purchase.id">
        <template #title>
          <span class="flex flex-row space-x-4">
            <span v-text="purchase.vendor.name" />
            <span v-text="dateToLocaleString(purchase.expires_at)" />
          </span>

          <jet-button
            ><a
              v-if="purchase.expired"
              target="_blank"
              :href="route('purchase.pdf', { purchase: purchase })"
              >Download PDF</a
            ></jet-button
          >
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
import JetButton from "@/Jetstream/Button.vue";
export default {
  components: { JetButton },
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
