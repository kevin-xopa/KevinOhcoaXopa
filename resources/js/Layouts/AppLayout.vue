<script setup>
import { router } from "@inertiajs/vue3";
import Offline from "@/Layouts/Offline.vue";
import FullAppBarMenu from "@/Layouts/FullAppBarMenu.vue";
defineProps({
  title: String,
});

// const showingNavigationDropdown = ref(false);

// const switchToTeam = (team) => {
//   router.put(
//     route("current-team.update"),
//     {
//       team_id: team.id,
//     },
//     {
//       preserveState: false,
//     }
//   );
// };

// const logout = () => {
//   router.post(route("logout"));
// };
</script>

<template>
  <v-app>
    <FullAppBarMenu />
    <v-main class="overflow-y-auto fill-height" id="scrolling-techniques-7" color="primary">
      <div class="mt-1 mx-10">
        <v-container>
          <Offline>
            <slot />
          </Offline>
        </v-container>
      </div>
    </v-main>
  </v-app>
</template>
