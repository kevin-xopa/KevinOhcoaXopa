<script setup>
import { useTheme } from "vuetify";
const theme = useTheme();
defineProps({
  text: {
    required: false,
    type: String,
    default: "Cargando datos...",
  },
  color: {
    required: false,
    type: String,
    default: "warning",
  },
  button: {
    required: false,
    type: Boolean,
    default: false,
  },
  text_button: {
    required: false,
    type: String,
    default: "Volver a intentar",
  },
  color_button: {
    required: false,
    type: String,
    default: "primary",
  },
  color_button: {
    required: false,
    type: String,
    default: "primary",
  },
  variant_button: {
    required: false,
    type: String,
    default: "flat",
  },
});
defineEmits(["clickButtonLoadingData"]);
</script>

<template>
  <div class="text-center">
    <img
      width="500"
      :src="
        theme.global.name.value == 'dark'
          ? 'https://media.tenor.com/2iAZpFihOGYAAAAC/loading-error.gif'
          : 'https://media.tenor.com/2iAZpFihOGYAAAAC/loading-error.gif'
      "
      alt=""
    />
    <h2 text-color="">{{ text }}</h2>
    <br />
    <v-btn
      :variant="variant_button"
      :color="color_button"
      v-if="!button"
      @click="$emit('clickButtonLoadingData')"
    >
      {{ text_button }}
    </v-btn>
  </div>
</template>
