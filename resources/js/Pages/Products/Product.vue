<script setup>
import Product from "@/Components/Product/Product.vue";
import NamePage from "@/Components/Default/NamePage.vue";

// import AppLayout from "@/Layouts/AppLayout.vue";
const title = "Product details";
const route_name = "product";
const params = { product: route().params.product };
</script>

<template>
  <Head :title="title" />
  <NamePage :title="title" :route_name="route_name" :params="params" />
  <Product />
</template>
