<template>
  <div class="flex flex-col space-y-2">
    <form-section @submitted="formSubmit">
      <template v-if="form.id" #title>
        Update Order for {{ vendor.name }}
      </template>
      <template v-else #title> Add Order for {{ vendor.name }} </template>

      <template #form>
        <div class="col-span-6 sm:col-span-4">
          <jet-label for="food" value="Food" />
          <jet-input id="food" v-model="form.food" type="text" class="w-full" />
        </div>
        <div class="col-span-6 sm:col-span-4">
          <jet-label for="drink" value="Drink" />
          <jet-input
            id="drink"
            v-model="form.drink"
            type="text"
            class="w-full"
          />
        </div>
        <div class="col-span-6 sm:col-span-4">
          <jet-label for="other" value="Other" />
          <jet-input
            id="other"
            v-model="form.other"
            type="text"
            class="w-full"
          />
        </div>
      </template>
      <template #actions>
        <jet-button>Submit</jet-button>
      </template>
    </form-section>
  </div>
</template>
<script>
import FormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetLabel from "@/Jetstream/Label.vue";

export default {
  components: {
    FormSection,
    JetInput,
    JetButton,
    JetLabel,
  },
  props: {
    order: {
      type: Object,
      default: () => {
        return {
          food: "",
          drink: "",
          other: "",
        };
      },
    },
    vendor: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      form: this.$inertia.form(this.order),
    };
  },
  mounted() {},
  methods: {
    formSubmit() {
      if (this.form.id) {
        this.form.put(
          route("vendor.order.update", {
            vendor: this.vendor,
            order: this.form,
          })
        );
      } else {
        this.form.post(route("vendor.order.store", { vendor: this.vendor }));
      }
    },
  },
};
</script>
