<template>
  <div class="container">
    <div class="row mt-2">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Feedbacks</h3>

            <div class="card-tools">
              <!-- Button trigger modal -->
            </div>
          </div>

          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Message</th>
                  <th>Sent At</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="fb in feedbacks" :key="fb.id">
                  <td>{{ fb.id }}</td>
                  <td>{{ fb.name | upperCase }}</td>
                  <td>{{ fb.email || "N/A"}}</td>
                  <td>{{ fb.message }}</td>
                  <td>{{ fb.created_at | myDate }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      feedbacks: []
    };
  },
  mounted() {},
  created() {
    this.loadFeedback();
  },
  methods: {
    loadFeedback() {
      axios.get("/api/feedback").then(response => {
        this.feedbacks = response.data.feedback;
      });
    }
  }
};
</script>
