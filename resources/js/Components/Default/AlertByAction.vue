<script setup>
import { mdiAlertBox, mdiCheckCircle } from "@mdi/js";

// props
const props = defineProps({
  status: {
    required: true,
  },
  message: {
    required: true,
  },
});
</script>

<template>
  <v-alert
    closable
    border="start"
    density="comfortable"
    variant="tonal"
    :type="status === 200 || status === 201 ? 'success' : 'warning'"
    :icon="status === 200 || status === 201 ? mdiCheckCircle : mdiAlertBox"
  >
    <div v-if="Array.isArray(message)">
      <ul>
        <li v-for="item in message">
          {{ item }}
        </li>
      </ul>
    </div>
    <div v-else>
      {{ message }}
    </div>
  </v-alert>
</template>
