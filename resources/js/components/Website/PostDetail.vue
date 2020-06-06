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
        <div class="card my-4">
          <h5 class="card-header">Leave a Comment:</h5>
          <div class="card-body">
            <form>
              <div class="form-group">
                <textarea class="form-control" rows="3"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>

        <!-- Single Comment -->
        <div class="media mb-4">
          <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt />
          <div class="media-body">
            <h5 class="mt-0">Commenter Name</h5>Cras sit amet nibh libero, in gravida nulla. Nulla vel
            metus scelerisque ante sollicitudin. Cras purus odio,
            vestibulum in vulputate at, tempus viverra turpis. Fusce
            condimentum nunc ac nisi vulputate fringilla. Donec
            lacinia congue felis in faucibus.
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
      post: null
    };
  },
  created() {
    this.loadPosts();
  },
  mounted() {},
  methods: {
    loadPosts() {
      axios.get("/api/home/posts/" + this.slug).then(response => {
        this.post = response.data.post;
      });
    }
  }
};
</script>
