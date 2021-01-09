<template>
  <v-app>
    <v-app-bar color="blue-grey" dark app>
      <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>
      <v-toolbar-title
        >LavQuotes<span class="subtitle-2 ml-5">Quotes</span></v-toolbar-title
      >
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" app temporary>
      <v-list nav dense>
        <v-list-item-group
          v-model="group"
          active-class="blue-grey--text text--accent-4"
        >
          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-home</v-icon>
            </v-list-item-icon>
            <v-list-item-title
              ><router-link to="/">Home</router-link></v-list-item-title
            >
          </v-list-item>

          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-information</v-icon>
            </v-list-item-icon>
            <v-list-item-title
              ><router-link to="/about">About</router-link></v-list-item-title
            >
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-navigation-drawer>

    <v-main>
      <v-container>
        <router-view />
      </v-container>
    </v-main>

    <the-footer />
  </v-app>
</template>

       
<script>
import TheFooter from "./components/TheFooter.vue";

export default {
  name: "App", // nome di questo componente

  components: {
    TheFooter,
  },

  data() {
    return {
      drawer: false,
      group: null,
    };
  },
};
</script>

<style scoped>
</style>