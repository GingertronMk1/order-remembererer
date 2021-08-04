<template>
  <div>
    You have been sent a purchase invitation! Click
    <inertia-link
      class="font-black"
      :href="
        route('purchase-invitation.edit', {
          purchase_invitation: notification.data.purchaseInvitation,
        })
      "
      >here</inertia-link
    >
    to accept
  </div>
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
