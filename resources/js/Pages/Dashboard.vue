<script setup>
import { ref, provide } from "vue";

// import AppLayout from "@/Layouts/AppLayout.vue";
// import Welcome from '@/Components/Welcome.vue';

const title = ref("Inicio");
const route_name = ref("dashboard");

provide("title", title);
provide("route_name", route_name);
</script>

<template>
  <Head :title="title" />
  <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
  <!-- <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </div>
        </div> -->
</template>
