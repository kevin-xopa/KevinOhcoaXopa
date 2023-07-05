<script setup>
import { ref } from "vue";

import Products from "@/Components/Products/Products.vue";
import NamePage from "@/Components/Default/NamePage.vue";

// import AppLayout from "@/Layouts/AppLayout.vue";
const title = "Products";
const route_name = "products";
</script>

<template>
  <Head :title="title" />
  <NamePage :title="title" :route_name="route_name" />
  <Products />
</template>
