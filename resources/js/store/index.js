import axios from "axios";
import Vue from "vue";
import Vuex, { Store } from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        uid: 0,
        userQuote: []
    },
    getters: {
        // getVariabile(state) {
        //     return state.Variabile;
        // }
    },

    mutations: {
        SET_UID(state, value) {
            state.uid = value;
        }
    },

    actions: {},

    modules: {}
});
