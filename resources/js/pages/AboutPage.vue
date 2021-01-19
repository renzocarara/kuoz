<template>
  <div>
    <h1 class="text-center">About this app</h1>
    <v-card class="d-flex justify-center flex-column">
      <v-card-title>Version</v-card-title>
      <v-card-text> v.0.1.0 </v-card-text>
      <v-card-title>Purpose</v-card-title>
      <v-card-text>
        This is an exercise combining
        <a href="https://laravel.com/" target="_blank" rel="noopener noreferrer"
          >Laravel
        </a>
        &nbsp;8 framework with a
        <a
          href="https://www.postgresql.org/"
          target="_blank"
          rel="noopener noreferrer"
          >PostgreSQL
        </a>
        &nbsp;DB and a
        <a href="https://vuejs.org/" target="_blank" rel="noopener noreferrer"
          >Vue.js
        </a>
        &nbsp;frontend.
      </v-card-text>

      <v-card-title>How it works</v-card-title>
      <v-card-text
        >A minimal authentication system is implemented through
        <a
          href="https://laravel.com/docs/8.x/starter-kits#laravel-breeze"
          target="_blank"
          rel="noopener noreferrer"
          >Laravel Breeze</a
        >, it allows to register, login, and some more out-of-the box features
        provided by Laravel. <br />
        User should register to have access to the app. <br />
        Once logged in, user can see all the Quotes recorded in the DB. User can
        insert new quotes or modify and delete existing ones.
      </v-card-text>

      <v-card-title>Technologies</v-card-title>
      <v-card-text>
        <ul>
          <li>LARAVEL v8.21.0</li>
          <li>VUE.JS v2.6.12</li>
          <li>VUETIFY v2.4.2</li>
          <li>VUE-ROUTER v3.4.9</li>
          <li>VUEX v3.6.0</li>
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
