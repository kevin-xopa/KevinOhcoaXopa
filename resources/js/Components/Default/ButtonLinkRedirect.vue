<script setup>
import { mdiTrashCan, mdiEye, mdiCardsHeart } from "@mdi/js";
defineProps({
  text: {
    required: true,
  },
  route_name: {
    required: true,
  },
  params: {
    required: false,
  },
  type: {
    required: true,
  },
  size: {
    required: false,
    default: "small",
  },
  variant: {
    required: false,
    default: "flat",
  },
});
</script>
<template>
  <Link :href="route(route_name, params)" class="text-decoration-none pr-2">
    <v-btn
      icon
      :color="type == 'restore' ? 'delete' : type == 'more_info' ? 'info' : 'info'"
      :size="size"
      :variant="variant"
    >
      <v-icon>
        {{
          type == "restore" ? mdiTrashCan : type == "more_info" ? mdiEye : mdiCardsHeart
        }}
      </v-icon>
      <v-tooltip activator="parent" location="bottom"> {{ text }} </v-tooltip>
    </v-btn>
  </Link>
</template>
