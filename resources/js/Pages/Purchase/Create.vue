<template>
  <app-layout>
    <form-section @submitted="createPurchase">
      <template #title> Start new Purchase </template>

      <template #form>
        <div class="col-span-6 sm:col-span-4">
          <jet-label for="vendor" value="Vendor" />
          <select id="vendor" name="vendor" v-model="form.vendor">
            <option
              v-for="vendor in vendors"
              :key="'vendor' + vendor.id"
              :value="vendor.id"
              v-text="vendor.name"
            />
          </select>
        </div>
      </template>
    </form-section>
  </app-layout>
</template>
<script>
import FormSection from "@/Jetstream/FormSection.vue";
// import JetInput from "@/Jetstream/Input.vue";
// import JetTextarea from "@/Jetstream/Textarea.vue";
// import JetButton from "@/Jetstream/Button.vue";
import JetLabel from "@/Jetstream/Label.vue";

export default {
  components: {
    FormSection,
    //   JetInput,
    //   JetTextarea,
    //   JetButton,
    JetLabel,
  },

  props: {
    vendors: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      form: this.$inertia.form({
        vendor: null,
      }),
    };
  },
  mounted() {},
  methods: {
    createPurchase() {
      this.form.post(route("purchase.store"));
    },
  },
};
</script>
