import "@mdi/font/css/materialdesignicons.css"; // Ensure you are using css-loader
import Vue from "vue";

import Vuetify from "vuetify";
// NOTE: include Vuetify style directly from dashboard.blade.php, (the blade that contains the App.vue entry point)
// if it is importd here it conflicts with Tailwind style applied on the "auth" views (login, register, etc)
// import "vuetify/dist/vuetify.min.css";

Vue.use(Vuetify);

const opts = {
    icons: {
        iconfont: "mdi" // default - only for display purposes
    }
};

export default new Vuetify(opts);
