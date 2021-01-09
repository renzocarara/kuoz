require("./bootstrap");
require("alpinejs");

import Vue from "vue";
import App from "./App.vue";
import vuetify from "./plugins/vuetify"; // path to vuetify export
import router from "./router/index"; // path to router export
import store from "./store/index";

const app = new Vue({
    el: "#app",
    vuetify,
    router,
    store,
    components: { App }
});
