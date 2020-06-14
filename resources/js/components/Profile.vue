<template>
  <div class="container">
    <div class="row mt-3">
      <div class="col-md-5">
        <div class="card card-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div
            class="widget-user-header text-white"
            style="background: url('https://adminlte.io/themes/dev/AdminLTE/dist/img/photo1.png') center center;"
          >
            <h3 class="widget-user-username text-right">{{ profile.name }}</h3>
            <h5 class="widget-user-desc text-right">{{ profile.role }}</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" src="/img/profile.png" alt="User Avatar" />
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">1</h5>
                  <span class="description-text">Following</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">10</h5>
                  <span class="description-text">Followers</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
              <div class="col-sm-4">
                <div class="description-block">
                  <h5 class="description-header">5</h5>
                  <span class="description-text">Posts</span>
                </div>
                <!-- /.description-block -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
        </div>
      </div>

      <div class="col-md-7">
        <div class="card">
          <div class="card-header">Profile</div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="settings">
                <form class="form-horizontal" @submit.prevent="updateProfile">
                  <div class="form-group">
                    <label>Name*</label>
                    <input
                      v-model="form.name"
                      type="text"
                      name="name"
                      class="form-control"
                      :class="{
                                                'is-invalid': errors.name
                                            }"
                    />
                    <code v-if="errors.name">
                      {{
                      errors.name[0]
                      }}
                    </code>
                  </div>
                  <div class="form-group">
                    <label>Email*</label>
                    <input
                      v-model="form.email"
                      type="text"
                      name="email"
                      class="form-control"
                      :class="{
                                                'is-invalid': errors.name
                                            }"
                    />
                    <code v-if="errors.email">
                      {{
                      errors.email[0]
                      }}
                    </code>
                  </div>
                  <div class="form-group">
                    <label>
                      Password (leave empty if not
                      changing)
                    </label>
                    <input
                      v-model="form.password"
                      type="password"
                      name="password"
                      class="form-control"
                    />
                  </div>
                  <div class="form-group">
                    <label>About</label>

                    <textarea v-model="form.about" type="text" name="about" class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Hobbies</label>
                    <multiselect
                      v-model="form.hobbies"
                      tag-placeholder="Add this as new tag"
                      placeholder="Search or add a tag"
                      label="name"
                      track-by="code"
                      :options="options"
                      :multiple="true"
                      :taggable="true"
                      @tag="addTag"
                    ></multiselect>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-success float-right">Update</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
    </div>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";
export default {
  components: {
    Multiselect
  },
  data() {
    return {
      options: [
        { name: "Cooking", code: "1" },
        { name: "Reading", code: "2" },
        { name: "Travelling", code: "3" }
      ],
      profile: {},
      form: {
        id: "",
        name: "",
        email: "",
        password: "",
        about: "",
        hobbies: []
      },
      errors: []
    };
  },
  created() {
    this.loadProfile();
  },
  mounted() {},
  methods: {
    addTag(newTag) {
      console.log(newTag);
      const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000)
      };

      this.options.push(tag);
      this.form.hobbies.push(tag);
    },
    loadProfile() {
      // Submit the form via a POST request
      axios.get("/api/profile").then(({ data }) => {
        const { id, name, about, email, hobbies } = data.user;
        this.profile = data.user;
        this.form.id = id;
        this.form.name = name;
        this.form.email = email;
        this.form.about = about;
        this.form.hobbies = hobbies;
      });
    },
    updateProfile() {
      // Submit the form via a POST request
      axios
        .put("/api/profile", this.form)
        .then(({ data }) => {
          Toast.fire({
            icon: "success",
            title: "Successfully updated"
          });
        })
        .catch(err => {
          this.errors = err.response.data.errors;
        });
    }
  }
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
