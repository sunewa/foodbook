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
                        <h3 class="widget-user-username text-right">
                            {{ this.profile.name }}
                        </h3>
                        <h5 class="widget-user-desc text-right">User</h5>
                    </div>
                    <div class="widget-user-image">
                        <img
                            class="img-circle"
                            src="/img/profile.png"
                            alt="User Avatar"
                        />
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">1</h5>
                                    <span class="description-text"
                                        >Following</span
                                    >
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">10</h5>
                                    <span class="description-text"
                                        >Followers</span
                                    >
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
                    <div class="card-header">User</div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="settings">
                                <form class="form-horizontal">
                                    <div class="form-group row">
                                        <label
                                            for="inputName"
                                            class="col-sm-2 col-form-label"
                                            >Name</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="email"
                                                class="form-control"
                                                id="inputName"
                                                placeholder="Name"
                                                v-model="this.form.name"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="inputEmail"
                                            class="col-sm-2 col-form-label"
                                            >Email</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="email"
                                                class="form-control"
                                                id="inputEmail"
                                                placeholder="Email"
                                                v-model="this.form.email"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="inputName2"
                                            class="col-sm-2 col-form-label"
                                            >Password</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="inputName2"
                                                placeholder="Password"
                                            />
                                            (leave empty if not changing)
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="inputExperience"
                                            class="col-sm-2 col-form-label"
                                            >Experience</label
                                        >
                                        <div class="col-sm-10">
                                            <textarea
                                                class="form-control"
                                                id="inputExperience"
                                                placeholder="Experience"
                                            ></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label
                                            for="inputSkills"
                                            class="col-sm-2 col-form-label"
                                            >Skills</label
                                        >
                                        <div class="col-sm-10">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="inputSkills"
                                                placeholder="Skills"
                                            />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" /> I
                                                    agree to the
                                                    <a href="#"
                                                        >terms and conditions</a
                                                    >
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button
                                                type="submit"
                                                class="btn btn-danger"
                                            >
                                                Submit
                                            </button>
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
export default {
    data() {
        return {
            profile: {},
            editMode: false,
            form: new Form({
                id: "",
                name: "",
                email: "",
                password: "",
                photo: ""
            })
        };
    },
    created() {
        // this.form.get("/api/profile/1").then(({ data }) => {});
        this.loadProfile();
    },
    mounted() {
        console.log("Component mounted.");
    },
    methods: {
        loadProfile() {
            // Submit the form via a POST request
            axios.get("/api/profile").then(({ data }) => {
                this.profile = data.user;
                this.form.fill(data.user);
            });
        }
    }
};
</script>
