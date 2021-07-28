<template>
  <form-section @submitted="formSubmit">
    <template v-if="form.id" #title> Update Cuisine </template>
    <template v-else #title> Add Cuisine </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <jet-label for="name" value="Name" />
        <jet-input id="name" v-model="form.name" type="text" class="w-full" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <jet-label for="description" value="Description" />
        <jet-textarea
          id="description"
          v-model="form.description"
          class="w-full"
        />
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
