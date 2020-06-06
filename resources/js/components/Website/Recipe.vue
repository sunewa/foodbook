<template>
  <!-- Page Content -->
  <div class="container">
    <!-- Page Heading -->
    <h1 class="my-4">
      Recipe
      <small>All delicious foods recipe</small>
    </h1>

    <div class="row">
      <div class="col-lg-4 col-sm-6 mb-4" v-for="post in posts" :key="post.id">
        <PostComponent v-bind:post="post"></PostComponent>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
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
