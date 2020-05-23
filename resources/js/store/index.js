import Vue from "vue";
import Vuex from "vuex";
import user from "./modules/user";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        isAuth: false
    },
    mutations: {
        CLEAR_APP(state, payload) {
            state.isAuth = false;
            state.user = payload;
        }
    },
    actions: {
        cleanApp({ commit }) {
            localStorage.removeItem("token");
            localStorage.removeItem("user");
            commit("CLEAR_APP", null);
        }
    },
    modules: {
        user
    }
});
