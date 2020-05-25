import Vue from "vue";
import VueRouter from "vue-router";

import Dashboard from "./../components/Dashboard";
import Post from "./../components/Post";
import Profile from "./../components/Profile";
import PostForm from "./../components/PostForm";
import User from "./../components/User";

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
        path: "/user",
        name: "user",
        component: User
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

export default router;
