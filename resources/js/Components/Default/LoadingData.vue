<script setup>
defineProps({
  text: {
    required: false,
    type: String,
    default: "Cargando datos...",
  },
  color: {
    required: false,
    type: String,
    default: "warning",
  },
});
defineEmits(["clickButtonLoadingData"]);
</script>

<template>
  <div class="text-center">
    <img width="300" src="https://usagif.com/wp-content/uploads/loading-1.gif" alt="" />
    <h2 text-color="">{{ text }}</h2>
    <br />
    <v-progress-linear :color="color" indeterminate :height="10"></v-progress-linear>
  </div>
</template>
