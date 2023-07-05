<script setup>
const props = defineProps({
  time: {
    required: false,
    type: Number,
    default: 5,
  },
  overlay: {
    required: true,
    type: Boolean,
  },
});
// const totalTime = ref(props.time);
// onMounted(() => {
//   window.onload = updateClock;
//   totalTime.value -= 1;
//   setTimeout("updateClock()", totalTime.value * 1000);
// });
</script>
<template>
  <v-overlay :model-value="props.overlay" class="align-center justify-center">
    <v-card color="black">
      <img width="300" src="/images/animations/loading.gif" alt="" />
      <h3 class="text-center">Ya vamos para allá</h3>
      <br />
      <v-progress-linear color="green" indeterminate :height="10"></v-progress-linear>
    </v-card>
  </v-overlay>
</template>
