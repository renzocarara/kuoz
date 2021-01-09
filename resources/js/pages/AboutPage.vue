<template>
  <div>
    <h1><v-icon>mdi-information</v-icon>About this app</h1>
    <v-card class="d-flex justify-center flex-column">
      <v-card-title>Purpose</v-card-title>
      <v-card-text>
        This is an exercise combining Laravel 8 framework with a PostgreSQL DB
        and a Vue frontend.
      </v-card-text>

      <v-card-title>How it works</v-card-title>
      <v-card-text> blah blah </v-card-text>
      <v-img
        class="my-2"
        alt="lavu flowchart"
        max-width="420"
        src="assets/to_be_defined_flowchart.png"
      ></v-img>
      <v-card-text> blah blah </v-card-text>

      <v-card-title>Technologies</v-card-title>
      <v-card-text>
        <ul>
          <li>LARAVEL v8.21.0</li>
          <li>VUE.JS v2.6.12</li>
          <li>VUETIFY v2.4.2</li>
          <li>VUE-ROUTER v3.4.9</li>
        </ul>
      </v-card-text>
    </v-card>
  </div>
</template>

<script>
export default {
  name: "AboutPage", // nome di questo componente
};
</script>

<style lang="css" scoped>
</style>
