<script setup>
import { mdiDelete, mdiPencil, mdiTrashCan } from "@mdi/js";
defineProps({
  type: {
    required: true,
  },
  icon: {
    required: false,
    default: null,
  },
});
</script>

<template>
  <v-btn
    icon
    :color="type == 'delete' ? 'delete' : type == 'update' ? 'success' : 'warning'"
    variant="flat"
    x-small
    size="x-small"
  >
    <v-icon>
      {{
        icon == null
          ? type == "delete"
            ? mdiDelete
            : type == "update"
            ? mdiPencil
            : mdiTrashCan
          : icon
      }}
    </v-icon>
  </v-btn>
</template>
