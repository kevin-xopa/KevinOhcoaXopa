<script setup>
import { watch } from "vue";
import { useTheme } from "vuetify";
import { useCycleList, computedWithControl } from "@vueuse/core";

const props = defineProps({
  themes: {
    type: Array,
    required: true,
  },
});

const vuetifyTheme = useTheme();

const {
  state: currentTheme,
  next: getNextThemeName,
  index: currentThemeIndex,
} = useCycleList(
  props.themes.map((t) => t.name),
  { initialValue: vuetifyTheme.global.name.value }
);

const changeTheme = () => {
  vuetifyTheme.global.name.value = getNextThemeName();
};

const getThemeIcon = computedWithControl(vuetifyTheme.global.name, () => {
  const nextThemeIndex =
    currentThemeIndex.value + 1 === props.themes.length ? 0 : currentThemeIndex.value + 1;

  return props.themes[nextThemeIndex].icon;
});

const get_color_for_icon_theme = computedWithControl(vuetifyTheme.global.name, () => {
  const nextThemeIndex =
    currentThemeIndex.value + 1 === props.themes.length ? 0 : currentThemeIndex.value + 1;

  return props.themes[nextThemeIndex].color;
});

const get_alias = computedWithControl(vuetifyTheme.global.name, () => {
  const nextThemeIndex =
    currentThemeIndex.value + 1 === props.themes.length ? 0 : currentThemeIndex.value + 1;

  return props.themes[nextThemeIndex].alias;
});

watch(vuetifyTheme.global.name, (val) => {
  currentTheme.value = val;
});
</script>

<template>
  <v-tooltip :text="'Cambia a ' + get_alias" location="start">
    <template v-slot:activator="{ props }">
      <VBtn
        v-bind="props"
        icon
        variant="text"
        :color="get_color_for_icon_theme"
        size="small"
        @click="changeTheme"
      >
        <VIcon :icon="getThemeIcon" size="26" />
      </VBtn>
    </template>
  </v-tooltip>
</template>
