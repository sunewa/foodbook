<template>
  <!-- Page Content -->
  <div class="container">
    <!-- Page Heading -->
    <h1 class="my-4">
      Contact Us
      <small>More options to contact us</small>
    </h1>

    <div class="row">
      <div class="col-md-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Feedback</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form class="form-horizontal" @submit.prevent="submitFeedback">
            <div class="card-body">
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Name*</label>
                <div class="col-sm-10">
                  <input
                    type="text"
                    class="form-control"
                    :class="{'is-invalid': errors.name}"
                    id="inputEmail3"
                    placeholder="Name"
                    v-model="form.name"
                  />
                  <code v-if="errors.name">
                    {{
                    errors.name[0]
                    }}
                  </code>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                  <input
                    type="email"
                    class="form-control"
                    id="inputEmail3"
                    placeholder="Email"
                    v-model="form.email"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Message*</label>
                <div class="col-sm-10">
                  <textarea
                    class="form-control"
                    placeholder="Type your message..."
                    :class="{'is-invalid': errors.message}"
                    v-model="form.message"
                  ></textarea>
                  <code v-if="errors.message">
                    {{
                    errors.message[0]
                    }}
                  </code>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-info float-right">Submit</button>
            </div>
            <!-- /.card-footer -->
          </form>
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
      form: {
        name: "",
        email: "",
        message: ""
      },
      errors: []
    };
  },
  created() {},
  methods: {
    submitFeedback() {
      // Submit the form via a POST request
      axios
        .post("/api/home/feedback", this.form)
        .then(({ data }) => {
          this.form = [];
          Toast.fire({
            icon: "success",
            title: "Successfully send"
          });
          window.scroll(0, 0);
        })
        .catch(err => {
          this.errors = err.response.data.errors;
        });
    }
  }
};
</script>
