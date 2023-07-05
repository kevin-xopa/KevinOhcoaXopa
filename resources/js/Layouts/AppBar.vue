<script setup>
import { usePage } from '@inertiajs/vue3'
import ThemeSwitcher from "@/Layouts/ThemeSwitcher.vue";

import { mdiBrightness5, mdiBrightness2 } from "@mdi/js";
const themes = [
  {
    name: "light",
    alias: "claro",
    icon: mdiBrightness5,
    color: "yellow",
  },
  {
    name: "dark",
    alias: "oscuro",
    icon: mdiBrightness2,
    color: "#07024F",
  },
];
</script>
<template>
  <v-row class="justify-center">
    <Link :href="route('dashboard')" method="get" class="text-decoration-none">
      <v-img
        width="6em"
        src="https://laravel.com/img/logotype.min.svg"
      >
      </v-img>
    </Link>
  </v-row>
  <ThemeSwitcher :themes="themes" />
</template>
