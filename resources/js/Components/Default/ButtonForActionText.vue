<script setup>
import { mdiDelete, mdiPencil, mdiTrashCan } from "@mdi/js";
defineProps({
  type: {
    required: true,
  },
  label: {
    required: true,
  },
});
</script>

<template>
  <v-btn
    block
    variant="outlined"
    :color="type == 'delete' ? 'error' : type == 'updated' ? 'success' : 'warning'"
    :prepend-icon="mdiTrashCan"
    :append-icon="mdiTrashCan"
  >
    {{ label }}
  </v-btn>
</template>
