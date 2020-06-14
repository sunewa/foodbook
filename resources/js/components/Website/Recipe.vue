<template>
  <!-- Page Content -->
  <div class="container">
    <!-- Page Heading -->
    <h1 class="my-4">
      Recipe Book
      <small>All delicious foods recipe</small>

      <input
        class="form-control"
        type="text"
        placeholder="Search for recipe..."
        v-model="search"
        v-on:keyup="searchPost"
      />

      <h5 v-if="search">You have searched for {{ search }}</h5>
      <h5 v-if="search">{{ posts.length }} posts found</h5>
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
      posts: [],
      search: this.$route.query.search || ""
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
      axios.get("/api/home/posts?search=" + this.search).then(response => {
        this.posts = response.data.posts;
      });
    },
    searchPost() {
      this.loadPosts();
    }
  }
};
</script>
