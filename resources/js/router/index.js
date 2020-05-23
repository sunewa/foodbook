import Vue from "vue";
import VueRouter from "vue-router";

import Dashboard from "./../components/Dashboard";
import Blog from "./../components/Blog";
import Profile from "./../components/Profile";
import BlogForm from "./../components/BlogForm";
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
        path: "/user",
        name: "user",
        component: User
    },
    {
        path: "/blog",
        name: "blog",
        component: Blog
    },
    {
        path: "/blog/create",
        name: "blog-create",
        component: BlogForm
    },
    {
        path: "/blog/:id/edit",
        name: "blog-edit",
        component: BlogForm
    }
];
const router = new VueRouter({
    mode: "history",
    // base: process.env.BASE_URL,
    routes
});

export default router;
