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
                                        isEdit ? updatePost() : createPost()
                                    "
                                    @keydown="form.onKeydown($event)"
                                >
                                    <div class="form-group row">
                                        <div class="col-md-8">
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
                                                <div
                                                    class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success"
                                                >
                                                    <input
                                                        type="checkbox"
                                                        class="custom-control-input"
                                                        id="customSwitch3"
                                                        v-model="
                                                            form.allow_comment
                                                        "
                                                    />
                                                    <label
                                                        class="custom-control-label"
                                                        for="customSwitch3"
                                                        >Allows Comment</label
                                                    >
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Description</label>
                                                <vue-editor
                                                    v-model="form.description"
                                                    type="text"
                                                    name="description"
                                                    :class="{
                                                        'is-invalid': form.errors.has(
                                                            'description'
                                                        )
                                                    }"
                                                ></vue-editor>
                                                <has-error
                                                    :form="form"
                                                    field="description"
                                                ></has-error>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputFile"
                                                    >File input</label
                                                >
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input
                                                            v-on:change="
                                                                onImageChange
                                                            "
                                                            type="file"
                                                            name="image"
                                                            class="form-control"
                                                            :class="{
                                                                'is-invalid': form.errors.has(
                                                                    'image'
                                                                )
                                                            }"
                                                            id="exampleInputFile"
                                                        />
                                                        <label
                                                            class="custom-file-label"
                                                            for="exampleInputFile"
                                                            >Choose file</label
                                                        >
                                                    </div>
                                                </div>
                                                <img
                                                    :src="form.image_url"
                                                    class="img-responsive"
                                                    height="300"
                                                    width="300"
                                                />
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
import { VueEditor } from "vue2-editor";
export default {
    components: {
        VueEditor
    },
    data() {
        return {
            isEdit: false,
            form: new Form({
                id: this.$route.params.id,
                slug: "",
                unique: "",
                title: "",
                allow_comment: true,
                image: "",
                image_url: "http://127.0.0.1:8000/img/default.png",
                description: ""
            })
        };
    },
    created() {
        if (this.form.id) {
            this.loadPost(this.form.id);
        }
    },
    mounted() {},
    methods: {
        checkSlug() {
            if (this.form.title.length > 5 && !this.isEdit) {
                this.form.slug = "";
                this.form.post("/api/posts/check-slug").then(res => {
                    this.form.slug = res.data.slug;
                    this.form.unique = res.data.unique;
                });
            }
        },
        loadPost(id) {
            this.isEdit = true;
            axios.get("/api/posts/" + id).then(res => {
                this.form.fill(res.data.post);
            });
        },
        createPost() {
            // Submit the form via a POST request
            this.form
                .post("/api/posts/")
                .then(({ data }) => {
                    Toast.fire({
                        icon: "success",
                        title: "Successfully added"
                    });
                    this.$router.push({ name: "post" });
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
        updatepost() {
            // Submit the form via a POST request
            this.form
                .put("/api/posts/" + this.form.id)
                .then(({ data }) => {
                    Toast.fire({
                        icon: "success",
                        title: "Successfully added"
                    });
                    this.$router.push({ name: "post" });
                })
                .catch(err => {
                    if (err.response.status === 401) {
                        Toast.fire({
                            icon: "warning",
                            title: err.response.data.message
                        });
                    }
                });
        },
        onImageChange(e) {
            e.preventDefault();

            let currentObj = this;

            const config = {
                headers: { "content-type": "multipart/form-data" }
            };

            let formData = new FormData();
            formData.append("image", e.target.files[0]);

            axios
                .post("/api/image-upload", formData, config)
                .then(function(response) {
                    // currentObj.success = response.data.success;
                    currentObj.form.image = response.data.filename;
                    currentObj.form.image_url = response.data.url;
                })
                .catch(function(error) {
                    // currentObj.output = error;
                });
        }
    }
};
</script>
