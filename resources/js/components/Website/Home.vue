<template>
  <div>
    <!-- Full Page Image Header with Vertically Centered Content -->
    <header class="masthead">
      <div class="container h-100">
        <div class="row h-100 align-items-center">
          <div class="col-12 text-center">
            <h1 class="font-weight-light">Food Blog</h1>
            <p class="lead">A great starter food for you to try</p>
          </div>
        </div>
      </div>
    </header>

    <!-- Page Content -->
    <section class="py-5">
      <div class="container">
        <h2 class="font-weight-light">About Us</h2>
        <p>Australian Culinary Federation is a giant organization which operates in every state of Australia with its national office being located at Kew East VIC 3102. It is an umbrella organization for professional chefs, cooks, Apprentices and culinary students. Every state office has its own board of executive members for state wise decisions while national level decisions are handled by national offices which also consist of board of executive members. People who are involved in the food business can become members of this organization. It also looks after the Chef Association of Australia</p>
      </div>
    </section>

    <div class="row">
      <div class="col-md-8">
        <img class="img-fluid" src="http://placehold.it/750x500" alt />
      </div>

      <div class="col-md-4">
        <h3 class="my-3">Project Description</h3>
        <p>Australian Culinary Federation, head office located at Kew East VIC 3102</p>
        <h3 class="my-3">Mission</h3>
        <ul>
          <li>To provide a networking web-application for the members of Australian Culinary Federation.</li>
          <li>To make the application available for general users who can post their recipe and hire chefs.</li>
          <li>To provide a platform for food lovers to post about recipes.</li>
          <li>To share information about the healthy diet and nutrients.</li>
        </ul>
      </div>
    </div>
    <!-- /.row -->

    <!-- Related Projects Row -->
    <h3 class="my-4">More Recipe</h3>

    <div class="row">
      <div class="col-md-3 col-sm-6 mb-4">
        <a href="#">
          <img class="img-fluid" src="http://placehold.it/500x300" alt />
        </a>
      </div>

      <div class="col-md-3 col-sm-6 mb-4">
        <a href="#">
          <img class="img-fluid" src="http://placehold.it/500x300" alt />
        </a>
      </div>

      <div class="col-md-3 col-sm-6 mb-4">
        <a href="#">
          <img class="img-fluid" src="http://placehold.it/500x300" alt />
        </a>
      </div>

      <div class="col-md-3 col-sm-6 mb-4">
        <a href="#">
          <img class="img-fluid" src="http://placehold.it/500x300" alt />
        </a>
      </div>
    </div>
    <!-- /.row -->
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  }
};
</script>

<style scoped>
/* 1920x1080 */
.masthead {
  height: 100vh;
  min-height: 500px;
  background-image: url("https://source.unsplash.com/BtbjCFUvBXs/1920x1080");
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}
</style>