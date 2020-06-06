<template>
    <div class="container">
        <div class="row mb-2">
            <div class="col-md-6" v-for="post in posts" :key="post.id">
                <PostComponent v-bind:post="post"></PostComponent>
            </div>
        </div>
    </div>
</template>

<script>
import PostComponent from "./PostComponent";
export default {
    components: {
        PostComponent
    },
    data() {
        return {
            posts: []
        };
    },
    created() {
        this.loadPosts();
    },
    mounted() {
        console.log("Component mounted.");
    },
    methods: {
        loadPosts() {
            axios.get("/api/home/posts").then(response => {
                this.posts = response.data.posts;
            });
        }
    }
};
</script>
