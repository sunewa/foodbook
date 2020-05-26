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
        path: "/manage/users",
        component: User
    },
    {
        path: "/manage/profile",
        component: Profile
    },
    {
        path: "/manage/posts",
        name: "post",
        component: Post
    },
    {
        path: "/manage/posts/create",
        name: "post-create",
        component: PostForm
    },
    {
        path: "/manage/posts/:id/edit",
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
