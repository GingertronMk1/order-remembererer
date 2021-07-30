<template>
  <div class="flex flex-col space-y-2">
    <form-section @submitted="formSubmit">
      <template v-if="form.id" #title> Update Vendor </template>
      <template v-else #title> Add Vendor </template>
      <template #description> Basic Details about this Vendor </template>

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
    <section-border />
    <form-section @submitted="formSubmit">
      <template #title> Contact Information </template>
      <template #description>
        How to get in touch with, or go to, this Vendor
      </template>

      <template #form>
        <div class="col-span-6 sm:col-span-4">
          <jet-label for="address" value="Address" />
          <jet-textarea id="address" v-model="form.address" class="w-full" />
        </div>
        <div class="col-span-6 sm:col-span-4">
          <jet-label for="website" value="Website" />
          <jet-input
            id="website"
            v-model="form.website"
            type="text"
            class="w-full"
          />
        </div>
        <div class="col-span-6 sm:col-span-4">
          <jet-label for="email" value="Email" />
          <jet-input
            id="email"
            v-model="form.email"
            type="text"
            class="w-full"
          />
        </div>
        <div class="col-span-6 sm:col-span-4">
          <jet-label for="phone" value="Phone" />
          <jet-input
            id="phone"
            v-model="form.phone"
            type="text"
            class="w-full"
          />
        </div>
      </template>
      <template #actions>
        <jet-button>Submit</jet-button>
      </template>
    </form-section>
    <section-border />

    <form-section @submitted="formSubmit">
      <template #title> Cuisines </template>
      <template #description> What kind of food this Vendor serves </template>

      <template #form>
        <div class="col-span-6 sm:col-span-4">
          <jet-label> Selected Cuisines </jet-label>
          <div class="flex flex-row items-stretch flex-wrap">
            <jet-button
              v-for="cuisine in form.cuisines"
              :key="cuisine.id"
              class="hover:bg-red-500 mr-2 mb-2"
              @click.prevent="removeCuisine(cuisine)"
              ><i class="fas fa-times mr-2"></i>{{ cuisine.name }}</jet-button
            >
          </div>
        </div>
        <section-border class="col-span-6 sm:col-span-4" />
        <div class="col-span-6 sm:col-span-4">
          <jet-label> Other Cuisines </jet-label>
          <div class="flex flex-row items-stretch flex-wrap">
            <jet-button
              v-for="cuisine in unselected_cuisines"
              :key="cuisine.id"
              class="hover:bg-green-500 mr-2 mb-2"
              @click.prevent="addCuisine(cuisine)"
              ><i class="fas fa-plus mr-2"></i>
              {{ cuisine.name }}
            </jet-button>
          </div>
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
import JetTextarea from "@/Jetstream/Textarea.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetLabel from "@/Jetstream/Label.vue";
import SectionBorder from "../Jetstream/SectionBorder.vue";

export default {
  components: {
    FormSection,
    JetInput,
    JetTextarea,
    JetButton,
    JetLabel,
    SectionBorder,
  },
  props: {
    vendor: {
      type: Object,
      default: () => {
        return {
          name: "",
          description: "",
          address: "",
          website: "",
          email: "",
          phone: "",
          cuisines: [],
        };
      },
    },
    cuisines: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      form: this.$inertia.form(this.vendor),
    };
  },
  computed: {
    unselected_cuisines() {
      return this.cuisines.filter((cuisine) => {
        return (
          this.form.cuisines.map(({ id }) => id).indexOf(cuisine.id) === -1
        );
      });
    },
  },
  mounted() {},
  methods: {
    addCuisine(cuisine) {
      this.form.cuisines.push(cuisine);
    },
    removeCuisine(cuisine) {
      this.form.cuisines = this.form.cuisines.filter(
        ({ id }) => id !== cuisine.id
      );
    },
    formSubmit() {
      if (this.form.id) {
        this.form.put(route("vendor.update", { vendor: this.form }));
      } else {
        this.form.post(route("vendor.store"));
      }
    },
  },
};
</script>
