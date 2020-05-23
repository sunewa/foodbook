import Vue from "vue";
import VueRouter from "vue-router";

import Dashboard from "./../components/Dashboard";
import Profile from "./../components/Profile";
import User from "./../components/User";

Vue.use(VueRouter);

let routes = [
    {
        path: "/dashboard",
        component: Dashboard
    },
    {
        path: "/profile",
        component: Profile
    },
    {
        path: "/users",
        component: User
    }
];
const router = new VueRouter({
    mode: "history",
    // base: process.env.BASE_URL,
    routes
});

export default router;
