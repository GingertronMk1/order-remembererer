<template>
  <app-layout>
<card>
    <template #title> There was an error accepting this invitation </template>
    {{ message }}
</card>
 </app-layout>
</template>
<script>
export default {
  props: {
      message: {
          type: String,
          required: true
      }
  },
};
</script>
