import Vue from "vue";
import VueRouter from "vue-router";
import MainPage from "../pages/MainPage.vue";
import AboutPage from "../pages/AboutPage.vue";

const routes = [
    {
        path: "/dashboard",
        name: "MainPage",
        component: MainPage
    },
    {
        path: "/about",
        name: "AboutPage",
        component: AboutPage
    }
];

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    // NOTA: la riga qui sotto è importante quando si fa il deploy dell'applicazione, per settare il path di root corretto
    // BASE_URL - corresponds to the publicPath option in vue.config.js and is the base path your app is deployed at.
    base: process.env.BASE_URL,
    routes
});

export default router;
