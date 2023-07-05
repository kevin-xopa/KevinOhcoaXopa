<script setup>
import Restore from "@/Components/Products/Restore.vue";
import NamePage from "@/Components/Default/NamePage.vue";

// import AppLayout from "@/Layouts/AppLayout.vue";
const title = "Products dump";
const route_name = "products.dump";
</script>

<template>
  <Head :title="title" />
  <NamePage :title="title" :route_name="route_name" />
  <Restore />
</template>
