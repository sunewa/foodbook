import Vue from "vue";
import VueRouter from "vue-router";

import Dashboard from "./../components/Dashboard";
import Post from "./../components/Post";
import Profile from "./../components/Profile";
import PostForm from "./../components/PostForm";
import User from "./../components/User";
import store from "../store";

Vue.use(VueRouter);

let routes = [
    {
        path: "/manage/dashboard",
        component: Dashboard
    },
    {
        path: "/manage/profile",
        component: Profile
    },
    {
        path: "/manage/users",
        name: "user",
        component: User,
        meta: { isAdmin: true }
    },
    {
        path: "/manage/post",
        name: "post",
        component: Post
    },
    {
        path: "/manage/post/create",
        name: "post-create",
        component: PostForm
    },
    {
        path: "/manage/post/:id/edit",
        name: "post-edit",
        component: PostForm
    }
];
const router = new VueRouter({
    mode: "history",
    // base: process.env.BASE_URL,
    routes
});

router.beforeEach((to, from, next) => {
    // you could define your own authentication logic with token
    let role = localStorage.getItem("role"); //store.getters.isAuthenticated

    // check route meta if it requires auth or not
    if (to.matched.some(record => record.meta.isAdmin)) {
        if (role === "admin") {
            next();
        } else {
            window.location.href = "/login";
            next({
                path: "/login",
                params: { nextUrl: to.fullPath }
            });
        }
    } else if (to.matched.some(record => record.meta.isUser)) {
        if (role === "user") {
            next();
        } else {
            window.location.href = "/login";
            next({
                path: "/login",
                params: { nextUrl: to.fullPath }
            });
        }
    } else {
        next();
    }
});

export default router;
