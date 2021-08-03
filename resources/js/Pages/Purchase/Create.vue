<template>
  <app-layout>
    <form-section @submitted="createPurchase">
      <template #title> Start new Purchase </template>

      <template #form>
        <div class="col-span-6 sm:col-span-4">
          <jet-label for="vendor" value="Vendor" />
          <select id="vendor" v-model="form.vendor_id" name="vendor">
            <option
              v-for="vendor in vendors"
              :key="'vendor' + vendor.id"
              :value="vendor.id"
              v-text="vendor.name"
            />
          </select>
        </div>
        <div class="col-span-6 sm:col-span-4">
          <jet-label for="null" value="Invite Users" />
          <div
            v-for="user in team.users"
            :key="'user' + user.id"
            class="flex flex-row space-x-2"
          >
            <input
              :id="'input-user' + user.id"
              v-model="form.user_ids"
              type="checkbox"
              :value="user.id"
              :name="'input-user' + user.id"
            />
            <jet-label :for="'input-user' + user.id" :value="user.name" />
          </div>
        </div>
        <div class="col-span-6 sm:col-span-4">
          <jet-label for="expires_at" value="Expires At" />
          <jet-input id="expires_at" v-model="form.expires_at" class="w-full" />
        </div>
      </template>
      <template #actions>
        <jet-button
          :disabled="
            form.vendor_id !== null && form.user_ids.length > 0
              ? null
              : 'disabled'
          "
          >Create</jet-button
        >
      </template>
    </form-section>
  </app-layout>
</template>
<script>
import FormSection from "@/Jetstream/FormSection.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";

export default {
  components: {
    FormSection,
    JetLabel,
    JetButton,
    JetInput,
  },

  props: {
    vendors: {
      type: Array,
      required: true,
    },
    team: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      form: this.$inertia.form({
        vendor_id: null,
        user_ids: this.team.users.map(({ id }) => id),
        expires_at: -1,
      }),
    };
  },
  mounted() {
    if (this.form.expires_at === -1) {
      const d = new Date();
      d.setHours(d.getHours() + 1);
      this.form.expires_at = d.toJSON();
    }
  },
  methods: {
    createPurchase() {
      this.form.post(route("purchase.store"));
    },
  },
};
</script>
