<script setup>
import { ref } from "vue";

defineProps({
  length: {
    required: true,
    type: Number,
  },
  total_visible: {
    required: false,
    type: Number,
    default: 7,
  },
  color: {
    required: false,
    type: String,
    default: "color_paginate",
  },
  rounded: {
    required: false,
    type: String,
    default: "lg",
  },
});
const page = ref(1);
defineEmits(["pageIsUpdated"]);
</script>

<template>
  <v-pagination
    v-model="page"
    :length="length"
    :rounded="rounded"
    :color="color"
    :total-visible="total_visible"
    @update:modelValue="$emit('pageIsUpdated', { name: 'page', value: page })"
  ></v-pagination>
</template>
