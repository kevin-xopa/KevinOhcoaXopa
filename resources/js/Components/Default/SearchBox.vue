<script setup>
import { mdiTableSearch } from "@mdi/js";
import { ref } from "vue";

const needle = ref("");
defineProps({
  label: {
    required: false,
    type: String,
    default: "Find everything!",
  },
  icon: {
    required: false,
    // type: Object,
    default: mdiTableSearch,
  },
  loading: {
    required: false,
    type: Boolean,
    default: false,
  },
  color: {
    required: false,
    type: String,
    default: "loading",
  },
});
defineEmits(["search", "clean_search"]);
</script>
<template>
  <v-text-field
    :loading="loading"
    v-model="needle"
    :label="label"
    :prepend-inner-icon="icon"
    @click:clear="$emit('clean_search', { name: 'clean', value: true })"
    @keyup.enter="$emit('search', { name: 'needle', value: needle })"
    :color="color"
  ></v-text-field>
</template>
