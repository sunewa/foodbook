<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">Dashboard</div>
          <!-- <div>{{ authUser.role }}</div> -->
          <div class="card-body" v-if="authUser.role == 'admin'">
            <p>User : {{ count.user }}</p>
            <p>Post : {{ count.post }}</p>
            <p>Feedback : {{ count.feedback }}</p>
          </div>
          <div class="card-body">
            <h2>Welcome to Food Book</h2>
            <p>You can start posting recipes, post food item(product) to sell.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      count: {}
    };
  },
  created() {
    this.loadStats();
  },
  computed: {
    authUser() {
      return this.$store.state.authUser;
    }
  },
  mounted() {
    console.log("Component mounted.");
  },
  methods: {
    loadStats() {
      axios.get("/api/home/stats").then(response => {
        this.count = response.data.count;
      });
    }
  }
};
</script>
