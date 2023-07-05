<script setup>
import { ref } from "vue";

defineProps({
  title: {
    required: true,
    type: String,
    default: 8,
  },
  route_name: {
    required: true,
    type: String,
  },
  params: {
    required: false,
    type: Object,
  },
});
</script>

<template>
  <div class="text-left">
    <h3 class="text-decoration-none">
      <Link
        :href="route(route_name, params)"
        method="get"
        class="text-decoration-none on-secondary text-capitalize"
      >
        {{ title }}
      </Link>
    </h3>
    <v-divider class="my-1"></v-divider>
  </div>
  <br />
</template>
