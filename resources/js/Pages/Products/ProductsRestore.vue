<script setup>
import Restore from "@/Components/Products/Products/Restore.vue";
import NamePage from "@/Components/Default/NamePage.vue";

// import AppLayout from "@/Layouts/AppLayout.vue";
const title = "reciclaje de productos";
const route_name = "products.restore";
</script>

<template>
  <Head :title="title" />
  <NamePage :title="title" :route_name="route_name" />
  <Restore />
</template>
