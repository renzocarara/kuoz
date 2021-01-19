import Vue from "vue";
import VueRouter from "vue-router";
import MainPage from "../pages/MainPage.vue";
import ManagePage from "../pages/ManagePage.vue";
import AboutPage from "../pages/AboutPage.vue";
import NotFound from "../pages/NotFound.vue";

const routes = [
    {
        path: "/dashboard",
        name: "MainPage",
        component: MainPage
    },
    {
        path: "/manage",
        name: "ManagePage",
        component: ManagePage
    },
    {
        path: "/about",
        name: "AboutPage",
        component: AboutPage
    },
    {
        path: "*",
        name: "NotFound",
        component: NotFound
    }
];

Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    // NOTE: the line below matters when the application is deployed, it allows to correctly set the root path of the application
    // BASE_URL - corresponds to the publicPath option in vue.config.js and is the base path your app is deployed at.
    base: process.env.BASE_URL,
    routes
});

export default router;
