<template>
  <app-layout>
    <form-section @submitted="formSubmit">
      <template v-if="form.id" #title> Update Cuisine </template>
      <template v-else #title> Add Cuisine </template>

      <template #form>
        <div class="col-span-6 sm:col-span-4">
            <jet-label for="food" value="Food" />
            <jet-checkbox v-model="form.food" :checked="form.food" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <jet-label for="drink" value="Drink" />
            <jet-checkbox v-model="form.drink" :checked="form.drink" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <jet-label for="other" value="Other" />
            <jet-checkbox v-model="form.other" :checked="form.other" />
        </div>
      </template>
      <template #actions>
        <jet-button>Submit</jet-button>
      </template>
    </form-section>
  </app-layout>
</template>
<script>
import FormSection from "@/Jetstream/FormSection.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";

export default {
  components: { FormSection, JetLabel, JetButton, JetCheckbox },
  props: { purchase_invitation: { type: Object, required: true } },
  data() {
    return {
      form: this.$inertia.form({
          food: true,
          drink: true,
          other: true,
      }),
    };
  },
  mounted() {},
  methods: {
    formSubmit() {
        this.form.put(route('purchase-invitation.update', {purchase_invitation: this.purchase_invitation.token}))
    },
  },
};
</script>
