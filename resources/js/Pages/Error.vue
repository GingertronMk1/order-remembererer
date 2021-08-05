<template>
  <app-layout>
    <template #header>
      {{ title }}
      <inertia-link :href="referrer" class="ml-auto">
        <jet-button>Back</jet-button>
      </inertia-link>
    </template>

    <p class="mb-4" v-text="description" />
    <p v-if="message !== ''" v-text="message" />
  </app-layout>
</template>

<script>
import JetButton from "@/Jetstream/Button.vue";
export default {
  components: { JetButton },
  props: {
    status: {
      type: Number,
      required: true,
    },
    message: {
      type: String,
      default: "",
    },
    referrer: {
      type: String,
      required: true,
    },
  },
  computed: {
    title() {
      return {
        503: "503: Service Unavailable",
        500: "500: Server Error",
        404: "404: Page Not Found",
        403: "403: Forbidden",
      }[this.status];
    },
    description() {
      return {
        503: "Sorry, we are doing some maintenance. Please check back soon.",
        500: "Whoops, something went wrong on our servers.",
        404: "Sorry, the page you are looking for could not be found.",
        403: "Sorry, you are forbidden from accessing this page.",
      }[this.status];
    },
  },
  mounted() {
    console.log(this.status);
    console.log(this.message);
  },
  methods: {
    back() {
      window.history.back();
    },
  },
};
</script>
