import Vue from "vue";
import VueRouter from "vue-router";

import Dashboard from "./../components/Dashboard";
import Post from "./../components/Post";
import Product from "./../components/Product";
import Profile from "./../components/Profile";
import PostForm from "./../components/PostForm";
import ProductForm from "./../components/ProductForm";
import User from "./../components/User";

import Home from "./../components/Website/Home";
import About from "./../components/Website/About";
import Recipe from "./../components/Website/Recipe";
import PostDetail from "./../components/Website/PostDetail";
import Market from "./../components/Website/Market";
import store from "../store";

Vue.use(VueRouter);

let routes = [
    {
        path: "/",
        component: Home
    },
    {
        path: "/about",
        component: About
    },
    {
        path: "/recipe",
        component: Recipe,
        name: "home-post"
    },
    {
        path: "/recipe/:slug",
        component: PostDetail,
        name: "home-post-detail"
    },
    {
        path: "/market",
        component: Market
    },
    {
        path: "/manage/dashboard",
        component: Dashboard
    },
    {
        path: "/manage/users",
        name: "user",
        component: User,
        meta: { isAdmin: true }
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
    },
    {
        path: "/manage/products",
        name: "product",
        component: Product
    },
    {
        path: "/manage/products/create",
        name: "product-create",
        component: ProductForm
    },
    {
        path: "/manage/products/:id/edit",
        name: "product-edit",
        component: ProductForm
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
