<script setup>
import AppBar from "@/Layouts/AppBar.vue";
import VerticalMenuList from "@/Layouts/VerticalMenuList.vue";
import { usePage } from '@inertiajs/vue3'
import { ref, computed } from "vue";
import { mdiPin, mdiPinOff, mdiMenu } from "@mdi/js";
// const
const rail = ref(false);
const drawer = ref(true);

// props
defineProps({});

// computed
const data_user = computed(() => {
  return usePage().props.user;
});

// watchers

// methods
</script>

<template>
  <v-navigation-drawer
    app
    permanent
    floating
    v-model="drawer"
    :rail="rail"
    @click="rail = false"
    class="elevation-20 mt-2 ml-1 rounded-lg"
    color="vertical_menu"
  >
    <div class="background-navigation rounded-lg">
      <v-list-item
        :prepend-avatar="
          'https://ui-avatars.com/api/?name=' + data_user.name + '?rounded=true'
        "
        nav
      >
        <template v-slot:append>
          <v-btn
            color="primary_2"
            variant="tonal"
            :icon="rail == true ? mdiPin : mdiPinOff"
            @click.stop="rail = !rail"
          ></v-btn>
        </template>
      </v-list-item>

      <v-list-item link class="mt-8">
        <div v-if="!rail">
          <v-list-item-title class="text-h6 text-white">
            <p class="">
              {{ data_user.name }}
            </p>
          </v-list-item-title>
          <v-list-item-subtitle class="text-white">
            {{ data_user.email }}
          </v-list-item-subtitle>
        </div>
        <div v-else>
          <v-list-item-title class="text-h6 text-white">
            <p class=" text-center">
              {{ data_user.name.charAt(0) }}
            </p>
          </v-list-item-title>
        </div>
      </v-list-item>
      <v-divider></v-divider>
      <br />
    </div>
    <VerticalMenuList />
  </v-navigation-drawer>
  <v-app-bar app color="tool_bar" class="mx-2 mt-2 rounded-lg">
    <v-app-bar-nav-icon
      @click.stop="drawer = !drawer"
      :icon="mdiMenu"
      variant="text"
      color
    >
    </v-app-bar-nav-icon>
    <AppBar />

    <!-- <Preferences :themes="themes" /> -->
  </v-app-bar>
</template>
