<template>
  <v-app>
    <v-app-bar color="blue-grey" dark app>
      <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>
      <v-toolbar-title
        >Kuoz<span class="subtitle-2 ml-5"></span
      ></v-toolbar-title>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" app temporary>
      <v-list nav dense>
        <v-list-item-group
          v-model="group"
          active-class="blue-grey--text text--accent-4"
        >
          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-home-outline</v-icon>
            </v-list-item-icon>
            <v-list-item-title
              ><router-link to="/dashboard"
                >Dashboard</router-link
              ></v-list-item-title
            >
          </v-list-item>

          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-pencil-outline</v-icon>
            </v-list-item-icon>
            <v-list-item-title
              ><router-link to="/manage">Manage</router-link></v-list-item-title
            >
          </v-list-item>

          <v-list-item>
            <v-list-item-icon>
              <v-icon>mdi-information-outline</v-icon>
            </v-list-item-icon>
            <v-list-item-title
              ><router-link to="/about">About</router-link></v-list-item-title
            >
          </v-list-item>

          <v-list-item @click="logout">
            <v-list-item-icon>
              <v-icon>mdi-exit-to-app</v-icon>
            </v-list-item-icon>
            <v-list-item-title>Logout</v-list-item-title>
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
  created() {
    console.log("APP CREATED: uid from backend: ", this.uid);
    // save uid in the store
    this.$store.commit("SET_UID", this.uid);
  },
  mounted() {
    console.log("APP MOUNTED");
  },

  props: ["uid"],

  data() {
    return {
      drawer: false,
      group: null,
    };
  },
  methods: {
    logout() {
      console.log("Logout clicked...");
      axios
        .post("/logout")
        .then((response) => {
          window.location.href = "/";
          console.log("Logout completed.");
        })
        .catch((error) => {
          console.log("Error trying to logout.");
        });
    },
  },
};
</script>

<style scoped>
</style>