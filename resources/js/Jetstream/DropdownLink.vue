<template>
  <button
    v-if="as == 'button'"
    type="submit"
    class="
      block
      w-full
      px-4
      py-2
      text-sm
      leading-5
      text-gray-700 text-left
      hover:bg-gray-100
      focus:outline-none focus:bg-gray-100
      transition
    "
  >
    <slot></slot>
  </button>

  <a
    v-else-if="as == 'a'"
    :href="href"
    class="
      block
      px-4
      py-2
      text-sm
      leading-5
      text-gray-700
      hover:bg-gray-100
      focus:outline-none focus:bg-gray-100
      transition
    "
  >
    <slot></slot>
  </a>

  <inertia-link
    v-else
    :href="href"
    class="
      block
      px-4
      py-2
      text-sm
      leading-5
      text-gray-700
      hover:bg-gray-100
      focus:outline-none focus:bg-gray-100
      transition
    "
  >
    <slot></slot>
  </inertia-link>
</template>

<script>
export default {
  props: {
    href: {
      type: String,
      default: "#",
    },
    as: {
      type: String,
      default: "button",
    },
  },
};
</script>
