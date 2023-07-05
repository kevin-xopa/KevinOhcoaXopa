<script setup>
import { ref } from "vue";

defineProps({
  title: {
    required: true,
    type: String,
  },
  route_name: {
    required: true,
    type: String,
  },
  params: {
    required: false,
    default: null,
  },
  tooltip: {
    required: false,
    type: Boolean,
    default: false,
  },
  tooltip_text: {
    required: false,
    type: String,
    default: "Redirigir",
  },
  location: {
    required: false,
    type: String,
    default: "top",
  },
});
const page = ref(1);
defineEmits(["pageIsUpdated"]);
</script>

<template>
  <v-tooltip :text="tooltip_text" v-if="tooltip" :location="location">
    <template v-slot:activator="{ props }">
      <Link
        v-bind="props"
        :href="params == null ? route(route_name) : route(route_name, params)"
        method="get"
        class="text-decoration-none on-secondary"
      >
        {{ title }}
      </Link>
    </template>
  </v-tooltip>
  <Link
    v-else
    :href="params == null ? route(route_name) : route(route_name, params)"
    method="get"
    class="text-decoration-none on-secondary"
  >
    {{ title }}
  </Link>
</template>
