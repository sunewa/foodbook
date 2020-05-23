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
                            {{ profile.name }}
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
                                <form
                                    class="form-horizontal"
                                    @submit.prevent="updateProfile"
                                    @keydown="form.onKeydown($event)"
                                >
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input
                                            v-model="form.name"
                                            type="text"
                                            name="name"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'name'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="name"
                                        ></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input
                                            v-model="form.email"
                                            type="text"
                                            name="email"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'email'
                                                )
                                            }"
                                        />
                                        <has-error
                                            :form="form"
                                            field="email"
                                        ></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            >Password (leave empty if not
                                            changing)</label
                                        >
                                        <input
                                            v-model="form.password"
                                            type="password"
                                            name="password"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'password'
                                                )
                                            }"
                                        />

                                        <has-error
                                            :form="form"
                                            field="password"
                                        ></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label>Experience</label>
                                        <textarea
                                            v-model="form.experience"
                                            type="text"
                                            name="experience"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'experience'
                                                )
                                            }"
                                        ></textarea>
                                        <has-error
                                            :form="form"
                                            field="experience"
                                        ></has-error>
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
        this.loadProfile();
    },
    mounted() {},
    methods: {
        loadProfile() {
            // Submit the form via a POST request
            axios.get("/api/profile").then(({ data }) => {
                this.profile = data.user;
                this.form.fill(data.user);
            });
        },
        updateProfile() {
            console.log(this.form);
            // Submit the form via a POST request
            this.form.put("/api/user/" + this.form.id).then(({ data }) => {
                Toast.fire({
                    icon: "success",
                    title: "Successfully updated"
                });
            });
        }
    }
};
</script>
