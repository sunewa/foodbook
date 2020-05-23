<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">New Post</div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="settings">
                                <form
                                    class="form-horizontal"
                                    @submit.prevent="
                                        isEdit ? updateBlog() : createBlog()
                                    "
                                    @keydown="form.onKeydown($event)"
                                >
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input
                                            v-model="form.title"
                                            type="text"
                                            name="title"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'title'
                                                )
                                            }"
                                            v-on:keyup="checkSlug"
                                        />
                                        .com/{{ form.slug }}
                                        <has-error
                                            :form="form"
                                            field="title"
                                        ></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea
                                            v-model="form.description"
                                            type="text"
                                            name="description"
                                            class="form-control"
                                            :class="{
                                                'is-invalid': form.errors.has(
                                                    'description'
                                                )
                                            }"
                                        ></textarea>
                                        <has-error
                                            :form="form"
                                            field="description"
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
            isEdit: false,
            form: new Form({
                id: this.$route.params.id,
                slug: "",
                unique: "",
                title: "",
                description: ""
            })
        };
    },
    created() {
        if (this.form.id) {
            this.loadBlog(this.form.id);
        }
    },
    mounted() {},
    methods: {
        checkSlug() {
            this.form.slug = "";
            if (this.form.title.length > 5) {
                this.form.post("/api/blog/check-slug").then(res => {
                    this.form.slug = res.data.slug;
                    this.form.unique = res.data.unique;
                });
            }
        },
        loadBlog(id) {
            this.isEdit = true;
            axios.get("/api/blog/" + id).then(res => {
                this.form.fill(res.data.blog);
            });
        },
        createBlog() {
            // Submit the form via a POST request
            this.form
                .post("/api/blog/")
                .then(({ data }) => {
                    Toast.fire({
                        icon: "success",
                        title: "Successfully added"
                    });
                    this.$router.push({ name: "blog" });
                })
                .catch(err => {
                    if (err.response.status === 500) {
                        Toast.fire({
                            icon: "warning",
                            title: err.response.data.message
                        });
                    }
                });
        },
        updateBlog() {
            // Submit the form via a POST request
            this.form
                .put("/api/blog/" + this.form.id)
                .then(({ data }) => {
                    Toast.fire({
                        icon: "success",
                        title: "Successfully added"
                    });
                    this.$router.push({ name: "blog" });
                })
                .catch(err => {
                    if (err.response.status === 401) {
                        Toast.fire({
                            icon: "warning",
                            title: err.response.data.message
                        });
                    }
                });
        }
    }
};
</script>
