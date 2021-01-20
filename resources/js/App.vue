<template>
    <v-app>
        <v-app-bar color="blue-grey" dark app>
            <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>
            <v-toolbar-title>
                <v-img
                    class="d-inline-block"
                    src="/images/logo.png"
                    alt="logo"
                    height="40"
                    width="40"
                ></v-img>
                <span class="kuoz-title text-h3">uoz</span>
            </v-toolbar-title>
        </v-app-bar>

        <v-navigation-drawer v-model="drawer" app temporary>
            <v-list nav dense>
                <v-list-item-group
                    v-model="group"
                    active-class="blue-grey--text text--accent-4"
                >
                    <v-list-item to="/dashboard">
                        <v-list-item-icon>
                            <v-icon>mdi-home-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title
                            ><span class="text-h5"
                                >Dashboard</span
                            ></v-list-item-title
                        >
                    </v-list-item>

                    <v-list-item to="/manage">
                        <v-list-item-icon>
                            <v-icon>mdi-pencil-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title
                            ><span class="text-h5"
                                >Manage</span
                            ></v-list-item-title
                        >
                    </v-list-item>

                    <v-list-item to="/about">
                        <v-list-item-icon>
                            <v-icon>mdi-information-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title
                            ><span class="text-h5"
                                >About</span
                            ></v-list-item-title
                        >
                    </v-list-item>

                    <v-list-item @click="logout">
                        <v-list-item-icon>
                            <v-icon>mdi-exit-to-app</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title
                            ><span class="text-h5"
                                >Logout</span
                            ></v-list-item-title
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

<style lang="scss" scoped>
@import "../scss/_variables";
.kuoz-title {
    color: $dark_blue;
    text-shadow: -1px 0 $secondary, 0 1px $secondary;
}
</style>