<template>
  <div class="container">
    <div class="row" v-if="post">
      <!-- Post Content Column -->
      <div class="col-lg-8">
        <!-- Title -->
        <h1 class="mt-4">{{ post.title }}</h1>

        <!-- Author -->
        <p class="lead">
          by
          <a href="#">N/A</a>
        </p>

        <hr />

        <!-- Date/Time -->
        <p>{{ post.created_at | myDate }}</p>

        <hr />

        <!-- Preview Image -->

        <img class="img-fluid rounded" :src="post.image_url" alt="900x300" />

        <hr />
        <p v-html="post.description"></p>
        <hr />

        <!-- Comments Form -->
        <div class="card my-4" v-if="isAuth">
          <h5 class="card-header">
            <div>
              Leave a Comment:
              <button
                v-if="can_like"
                class="btn btn-success float-right"
                v-on:click="createLike(post.id,'like')"
              >Like</button>
              <button
                v-else
                class="btn btn-danger float-right"
                v-on:click="createLike(post.id,'unlike')"
              >Unlike</button>

              <span>
                <i class="fas fa-heart"></i>
                {{ like_count }}
              </span>
            </div>
          </h5>

          <div class="card-body">
            <form class="form-horizontal" @submit.prevent="createComment">
              <div class="form-group">
                <textarea
                  v-model="form.comment"
                  type="text"
                  name="price"
                  class="form-control"
                  :class="{'is-invalid':errors.comment}"
                  placeholder="Enter a comment"
                  rows="3"
                ></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
        <div class="card my-4" v-else>
          <h5 class="card-header">
            <div>
              You need to login to like and comment this post
              <span class="float-right">
                <i class="fas fa-heart"></i>
                {{ like_count }}
              </span>
            </div>
          </h5>
        </div>

        <!-- Single Comment -->
        <div class="media mb-4" v-for="comment in comments" :key="comment.id">
          <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt />
          <div class="media-body">
            <h5 class="mt-0">{{ comment.full_name}}</h5>
            {{ comment.comment}}
          </div>

          <div class="form-group" v-if="isAuth && comment.user_id == authUser.id">
            <button class="btn btn-danger" v-on:click="deleteComment(comment.id)">Delete</button>
          </div>
        </div>
      </div>

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">
        <!-- Search Widget -->
        <div class="card my-4">
          <h5 class="card-header">Search</h5>
          <div class="card-body">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for..." />
              <span class="input-group-btn">
                <button class="btn btn-secondary" type="button">Go!</button>
              </span>
            </div>
          </div>
        </div>

        <!-- Categories Widget -->
        <div class="card my-4">
          <h5 class="card-header">Categories</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <ul class="list-unstyled mb-0">
                  <li v-for="category in post.categories" :key="category.id">
                    <a href="#">{{ category.name }}</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="card my-4">
          <h5 class="card-header">Tags</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-12">
                <ul class="list-unstyled mb-0">
                  <li v-for="tag in post.tags" :key="tag.id">
                    <a href="#">{{ tag.name }}</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Side Widget -->
        <div class="card my-4">
          <h5 class="card-header">Contact Chef</h5>
          <div
            class="card-body"
          >You can see the chief of this recipe. Only after you sign up to our account.</div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
</template>

<script>
export default {
  data() {
    return {
      slug: this.$route.params.slug,
      post: null,
      like_count: 0,
      can_like: false,
      comments: [],
      form: {
        id: "",
        full_name: "",
        comment: ""
      },
      errors: []
    };
  },
  created() {
    this.loadPosts();
    this.loadComments();
    this.loadLike();
  },
  mounted() {},
  computed: {
    isAuth() {
      return this.$store.state.isAuth;
    },
    authUser() {
      return this.$store.state.authUser;
    }
  },
  methods: {
    loadPosts() {
      axios.get("/api/home/posts/" + this.slug).then(response => {
        this.post = response.data.post;
        this.form.id = response.data.post.id;
      });
    },
    loadComments() {
      axios.get("/api/home/posts/comment/" + this.slug).then(response => {
        this.comments = response.data.comments;
      });
    },
    createComment() {
      // Submit the form via a POST request
      axios
        .post("/api/home/posts/comment/" + this.slug, this.form)
        .then(response => {
          this.comments = response.data.comments;
          this.form.comment = "";
          Toast.fire({
            icon: "success",
            title: "Comment saved."
          });
        })
        .catch(err => {
          this.errors = err.response;
        });
    },
    deleteComment(id) {
      // Submit the form via a POST request
      axios
        .delete("/api/home/posts/comment/" + this.slug + "/" + id)
        .then(response => {
          this.comments = response.data.comments;
          this.form.comment = "";
          Toast.fire({
            icon: "success",
            title: "Deleted"
          });
        })
        .catch(err => {
          this.errors = err.response;
        });
    },
    createLike(id, type) {
      // Submit the form via a POST request
      axios
        .post("/api/home/posts/like/" + this.slug, { id: id, type: type })
        .then(response => {
          this.like_count = response.data.like_count;
          this.can_like = response.data.can_like;
          Toast.fire({
            icon: "success",
            title: "Updated"
          });
        })
        .catch(err => {
          this.errors = err.response;
        });
    },
    loadLike() {
      axios.get("/api/home/posts/like/" + this.slug).then(response => {
        this.like_count = response.data.like_count;
        this.can_like = response.data.can_like;
      });
    }
  }
};
</script>
