<script setup>
import {  mdiBreadSlice } from "@mdi/js";
import LinkRedirectMinimalist from "@/Components/Default/LinkRedirectMinimalist.vue";
defineProps({
  item: {
    required: true,
    type: Object,
  },
});
</script>
<template>
  <v-card class="my-2" :append-icon="mdiBreadSlice">
    <v-card-text>
      <div class="text-subtitle-1">{{ item.name }}</div>
    </v-card-text>
    <v-card-text v-if="item.description">
      {{ item.description != null ? item.description : " " }}
    </v-card-text>
    <v-divider></v-divider>
    <v-card-text class="text-left text-caption">
      <div>
        Ultima modificación:
        <span class="font-weight-bold">{{ item.created_at }}</span>
      </div>
      <div>
        Creado el: <span class="font-weight-bold">{{ item.created_at }}</span>
      </div>
    </v-card-text>

    <v-card-actions>
      <v-spacer />
      <slot></slot>
    </v-card-actions>
  </v-card>
</template>
