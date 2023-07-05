<script setup>
import { ref, watch } from "vue";
import { VOffline } from "v-offline";
import V599 from "@/Components/Errors/V599.vue";

const online = ref(true);
const setOnline = (e) => {
  online.value = e;
};
</script>

<template>
  <v-offline @detected-condition="setOnline">
    <template v-if="online == true">
      <slot />
    </template>
    <template v-else>
      <V599 />
    </template>
  </v-offline>
</template>
