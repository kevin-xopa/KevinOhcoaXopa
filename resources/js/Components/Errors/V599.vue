<template>
  <div>
    <v-carousel
      :show-arrows="false"
      cycle
      invernal="1000"
      hide-delimiter-background
      show-arrows="hover"
      reverse-transition="fade-transition"
      transition="fade-transition"
    >
      <v-carousel-item
        height="1000"
        v-for="(item, i) in items"
        :key="i"
        :src="item.src"
      ></v-carousel-item>
    </v-carousel>

    <v-row align="center" justify="center">
      <v-col class="text-center" cols="12">
        <h1 class="text-h4 font-weight-thin mb-4">599</h1>
        <h4 class="subheading">Error de tiempo de espera de conexión de red</h4>
        <span class="subtitle2">¡No tienes internet!</span>
      </v-col>
    </v-row>
  </div>
</template>
<script>
export default {
  data() {
    return {
      items: [
        {
          src: "../images/errors/599_1.gif",
        },
        {
          src: "../images/errors/599_2.gif",
        },
        {
          src: "../images/errors/599_3.gif",
        },
        {
          src: "../images/errors/599_4.gif",
        },
      ],
    };
  },
};
</script>
