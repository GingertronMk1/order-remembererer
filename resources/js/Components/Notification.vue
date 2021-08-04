<template>
  <card
    v-for="notification in notifications"
    :key="'notification' + notification.id"
  >
    <template #title>
      <span
        class="text-xs"
        v-text="dateToLocaleString(notification.created_at)"
      />
    </template>
    <component
      :is="getComponentType(notification)"
      :notification="notification"
      @click="deleteNotification(notification)"
    />
  </card>
</template>
<script>
import FallbackNotification from "@/Components/Notification/FallbackNotification";
import PurchaseInvitationNotification from "@/Components/Notification/PurchaseInvitationNotification";
import PurchaseExpiredNotification from "@/Components/Notification/PurchaseExpiredNotification";
import Card from "./Card.vue";
export default {
  components: { Card },
  props: {
    notifications: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {};
  },
  mounted() {
    console.log(this.notifications);
    this.notifications.forEach(({ type }) => {
      console.log(type);
    });
  },
  methods: {
    getComponentType(notification) {
      switch (notification.type) {
        case "App\\Notifications\\PurchaseInvitationNotification":
          return PurchaseInvitationNotification;
        case "App\\Notifications\\PurchaseExpiredNotification":
          return PurchaseExpiredNotification;
        default:
          return FallbackNotification;
      }
    },
    deleteNotification(notification) {
      axios({
        method: "PUT",
        url: route("iapi.notification.update", { notification: notification }),
        data: {
          read_at: new Date().toJSON(),
        },
      }).then(({ data }) => {
        if (data === 1) {
          this.$page.props.notifications.splice(
            this.$page.props.notifications.indexOf(notification),
            1
          );
        }
      });
    },
  },
};
</script>
