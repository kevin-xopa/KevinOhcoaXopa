<script setup>
import { ref } from "vue";
import ButtonForAction from "@/Components/Default/ButtonForAction.vue";
import LinkRedirectMinimalist from "@/Components/Default/LinkRedirectMinimalist.vue";
defineProps({
  item: {
    required: true,
    type: Object,
  },
  view_edit: {
    required: true,
    type: Boolean,
  },
});
</script>
<template>
  <div class="d-flex align-center justify-center mt-10">
    <v-card class="auth-card" elevation="10" width="1000">
      <v-row>
        <v-col cols="12" xs="12" sm="12" md="6" lg="6" xl="6">
          <v-card elevation="0">
            <div class="d-flex justify-center align-center">
              <div class="d-flex justify-center align-center">
                <v-img
                  class="mx-6"
                  height="auto"
                  width="auto"
                  v-bind:src="item.photo"
                  lazy-src="/images/animations/preloader-image.gif"
                >
                </v-img>
              </div>
            </div>
          </v-card>
        </v-col>
        <v-col cols="12" xs="12" sm="12" md="6" lg="6" xl="6">
          <div v-if="view_edit == false">
            <v-card-title v-text="item.name" class="text-left" />
            <v-card-text>
              <div>{{ item.presentation }}</div>
              <div>{{ item.department }}</div>
              <div>{{ item.state }}</div>
              <div class="text-yellow">${{ item.price }}</div>
            </v-card-text>
            <v-divider></v-divider>
            <v-divider></v-divider>
            <v-card-text class="text-left text-caption">
              <div>
                Ultima modificación:
                <span class="font-weight-bold">{{ item.created_at }}</span>
              </div>
              <div>
                Creado el: <span class="font-weight-bold">{{ item.created_at }}</span>
              </div>
            </v-card-text>
            <v-card-text class="pt-4 text-left" v-if="item.user_name != null">
              <div>
                Creado por:
                <LinkRedirectMinimalist
                  :title="`${item.user_name} ${item.user_surnames}`"
                  route_name="employee"
                  :params="item.user_slug"
                  :tooltip="true"
                  tooltip_text="Visitar el perfil"
                  location="top"
                />
              </div>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-text class="text-left text-caption" v-if="item.deleted_at != null">
              <div>
                Eliminado el: <span class="font-weight-bold">{{ item.deleted_at }}</span>
              </div>
              <div>
                Eliminado por:
                <LinkRedirectMinimalist
                  :title="`${item.user_name_delete} ${item.user_surnames_delete}`"
                  route_name="employee"
                  :params="item.user_slug"
                  :tooltip="true"
                  tooltip_text="Visitar el perfil"
                  location="top"
                />
              </div>
            </v-card-text>
          </div>
          <slot />
        </v-col>
      </v-row>
    </v-card>
  </div>
</template>
