import axios from "axios";
import store from "./../index";

export default {
    namespaced: true,
    state: {
        profile: {},
        token: null
    },
    getters: {
        // isAuthenticated(state) {
        //     if (state.token && state.user) {
        //         return true;
        //     }
        //     return false;
        // },
        getProfile(state) {
            return state.profile;
        }
    },
    actions: {
        // async login({ commit }, formData) {
        //     let response = await formData.post("/api/auth/login");
        //     // let response = await axios.post("/api/auth/login", formData);

        //     const token = response.data.token.access_token;
        //     // const owner = response.data.owner;
        //     if (token) {
        //         localStorage.setItem("token", token);
        //         localStorage.setItem("user", "owner");
        //         commit("SET_TOKEN", token);
        //     }
        // },

        // async attempt({ commit }) {
        //     const token = localStorage.getItem("token");

        //     if (!token || token == "undefined") window.location = "/";

        //     axios.defaults.headers.common["Authorization"] = "Bearer " + token;

        //     try {
        //         let response = await axios.post("/api/auth/refresh");
        //         if (!response.data.token) window.location = "/";

        //         localStorage.setItem("token", response.data.token);
        //         if (!token || token == "undefined") window.location = "/";
        //         commit("SET_TOKEN", response.data.token);

        //         axios.defaults.headers.common["Authorization"] =
        //             "Bearer " + response.data.token;
        //         // return dispatch("attempt", response.data.token);
        //         if (!response.data.token) return;

        //         response = await axios.post("/api/auth/me");

        //         commit("SET_USER", response.data.owner);
        //     } catch (e) {
        //         commit("SET_TOKEN", null);
        //         commit("SET_USER", null);
        //     }
        // },

        async getProfile({ commit }) {
            let response = await axios.get("/api/profile");

            commit("SET_PROFILE", response.data.user);
        }

        // signOut({ commit }) {
        //     commit("SET_TOKEN", null);
        //     commit("SET_USER", null);
        // }
    },
    mutations: {
        // SET_TOKEN(state, payload) {
        //     store.state.isAuth = true;
        //     store.state.user = "owner";
        //     state.token = payload;
        // },

        // SET_USER(state, payload) {
        //     store.state.isAuth = true;
        //     store.state.user = "owner";
        //     state.profile = payload;
        // },
        SET_PROFILE(state, payload) {
            state.profile = payload;
        }
    }
};
