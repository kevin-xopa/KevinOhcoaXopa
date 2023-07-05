<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { mdiHome, mdiPackageVariant, mdiBreadSlice } from "@mdi/js";
const open = ref(["Inventario"]);
const routes = ref([
    {
        name: "Inicio",
        icon: mdiHome,
        route_name: "dashboard",
    },
    {
        name: "Inventario",
        icon: mdiPackageVariant,
        route_name: false,
        children: [
            {
                name: "Productos",
                icon: mdiBreadSlice,
                route_name: "products",
            },
        ],
    },
]);
</script>

<template>
    <v-list
        v-for="(item, i) in routes"
        v-model:opened="open"
        :lines="false"
        nav
    >
        <Link
            v-if="item.route_name !== false"
            :href="route(item.route_name)"
            method="get"
            class="text-decoration-none text-white"
        >
            <v-list-item
                :prepend-icon="item.icon"
                :value="item.name"
                variant="tonal"
            >
                <v-list-item-title v-text="item.name" />
            </v-list-item>
        </Link>
        <v-list-group v-else-if="item.route_name == false" :value="item.name">
            <template v-slot:activator="{ props }">
                <v-list-item
                    :prepend-icon="item.icon"
                    :title="item.name"
                    :value="item.name"
                    v-bind="props"
                    variant="tonal"
                ></v-list-item>
            </template>

            <Link
                v-for="(item, i) in item.children"
                :key="i"
                :value="item.name"
                :href="route(item.route_name)"
                method="get"
                class="text-decoration-none text-white"
            >
                <v-list-item
                    :key="i"
                    :value="item.name"
                    :prepend-icon="item.icon"
                >
                    <v-list-item-title v-text="item.name" />
                </v-list-item>
            </Link>
        </v-list-group>
    </v-list>
</template>
