import Vue from "vue";
import Vuex from "vuex";
import user from "./modules/user";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        isAuth: false,
        authUser: null
    },
    getters: {
        isAuth(state) {
            return state.isAuth;
        }
    },
    mutations: {
        CLEAR_APP(state, payload) {
            state.isAuth = false;
            state.user = payload;
        },
        FETCH_USER(state, payload) {
            state.isAuth = true;
            state.authUser = payload;
        }
    },
    actions: {
        loadAuthUser({ commit }, data) {
            localStorage.setItem("role", data.user.role);
            commit("FETCH_USER", data.user);
        },
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
