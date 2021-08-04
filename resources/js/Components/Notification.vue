<template>
  <component
    :is="notification.component"
    v-for="notification in computed_notifications"
    :key="'notification' + notification.id"
  />
</template>
<script>
import { shallowRef } from "vue";
import FallbackNotification from "@/Components/Notification/FallbackNotification";
import PurchaseInvitationNotification from "@/Components/Notification/PurchaseInvitationNotification";
import PurchaseExpiredNotification from "@/Components/Notification/PurchaseExpiredNotification";
export default {
  props: {
    notifications: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {};
  },
  computed: {
    computed_notifications() {
      return this.notifications.map((notification) => {
        switch (notification.type) {
          case "App\\Notifications\\PurchaseInvitationNotification":
            notification.component = PurchaseInvitationNotification;
            break;
          case "App\\Notifications\\PurchaseExpiredNotification":
            notification.component = PurchaseExpiredNotification;
            break;
          default:
            notification.component = FallbackNotification;
            break;
        }
        notification.component = shallowRef(notification.component);
        return notification;
      });
    },
  },
};
</script>
