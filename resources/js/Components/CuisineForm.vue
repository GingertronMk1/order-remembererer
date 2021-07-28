<template>
  <form-section @submitted="formSubmit">
    <template #title v-if="form.id"> Update Cuisine </template>
    <template #title v-else> Add Cuisine </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <jet-label for="name" value="Name" />
        <jet-input v-model="form.name" type="text" id="name" class="w-full" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <jet-label for="description" value="Description" />
        <jet-textarea v-model="form.description" id="description" class="w-full" />
      </div>
    </template>
    <template #actions>
      <jet-button>Submit</jet-button>
    </template>
  </form-section>
</template>
<script>
import FormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetTextarea from "@/Jetstream/Textarea.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetLabel from "@/Jetstream/Label.vue";

export default {
  components: { FormSection, JetInput, JetTextarea, JetButton, JetLabel },
  props: {
    cuisine: {
      type: Object,
      default: () => {
        return {
          name: "",
          description: "",
        };
      },
    },
  },
  data() {
    return {
      form: this.$inertia.form(this.cuisine),
    };
  },
  mounted() {},
  methods: {
    formSubmit() {
      if (this.form.id) {
        this.form.put(route("cuisine.update", { cuisine: this.form }));
      } else {
        this.form.post(route("cuisine.store"));
      }
    },
  },
};
</script>
