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
                                >
                                    <div class="form-group row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label>Title*</label>
                                                <input
                                                    v-model="form.title"
                                                    type="text"
                                                    name="title"
                                                    class="form-control"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.title
                                                    }"
                                                    v-on:keyup="checkSlug"
                                                />
                                                <code v-if="errors.title">{{
                                                    errors.title[0]
                                                }}</code>
                                                <br />
                                                .com/{{ form.slug }}
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
                                                <label>Description*</label>
                                                <vue-editor
                                                    v-model="form.description"
                                                    type="text"
                                                    name="description"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.description
                                                    }"
                                                ></vue-editor>
                                                <code
                                                    v-if="errors.description"
                                                    >{{
                                                        errors.description[0]
                                                    }}</code
                                                >
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Categories</label>
                                                <multiselect
                                                    v-model="form.categories"
                                                    placeholder="Search for category"
                                                    label="name"
                                                    track-by="code"
                                                    :options="categories"
                                                    :searchable="false"
                                                    :multiple="true"
                                                    :taggable="true"
                                                    :hide-selected="true"
                                                    open-direction="bottom"
                                                    :class="{
                                                        'is-invalid':
                                                            errors.categories
                                                    }"
                                                >
                                                    >
                                                </multiselect>
                                                <code
                                                    v-if="errors.categories"
                                                    >{{
                                                        errors.categories[0]
                                                    }}</code
                                                >
                                            </div>
                                            <div class="form-group">
                                                <label>Tags</label>
                                                <multiselect
                                                    v-model="form.tags"
                                                    tag-placeholder="Add this as new tag"
                                                    placeholder="Search or add a tag"
                                                    label="name"
                                                    track-by="code"
                                                    :options="options"
                                                    :multiple="true"
                                                    :taggable="true"
                                                    :hide-selected="true"
                                                    open-direction="bottom"
                                                    @tag="addTag"
                                                ></multiselect>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputFile"
                                                    >Image</label
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
                                        <div class="col-sm-12">
                                            <button
                                                type="submit"
                                                class="btn btn-success float-right"
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
import Multiselect from "vue-multiselect";
export default {
    components: {
        VueEditor,
        Multiselect
    },
    data() {
        return {
            isEdit: false,
            options: [],
            categories: [],
            form: {
                id: this.$route.params.id,
                slug: "",
                unique: "",
                title: "",
                allow_comment: true,
                image: "",
                image_url: "http://127.0.0.1:8000/img/default.png",
                description: "",
                tags: [],
                categories: []
            },
            errors: []
        };
    },
    created() {
        this.loadTags();
        this.loadCategorys();
        if (this.form.id) {
            this.loadPost(this.form.id);
        }
    },
    mounted() {},
    methods: {
        addTag(newTag) {
            const tag = {
                name: newTag,
                code:
                    newTag.substring(0, 2) +
                    Math.floor(Math.random() * 10000000)
            };
            this.options.push(tag);
            this.form.tags.push(tag);
        },
        checkSlug() {
            this.errors = [];
            if (this.form.title.length > 5 && !this.isEdit) {
                this.form.slug = "";
                axios.post("/api/posts/check-slug", this.form).then(res => {
                    this.form.slug = res.data.slug;
                    this.form.unique = res.data.unique;
                });
            }
        },
        loadTags() {
            axios.get("/api/posts/tags").then(res => {
                this.options = Object.keys(res.data.tags).map(key => {
                    return res.data.tags[key];
                });
            });
        },
        loadCategorys() {
            axios.get("/api/posts/categories").then(res => {
                this.categories = Object.keys(res.data.categories).map(key => {
                    return res.data.categories[key];
                });
            });
        },
        loadPost(id) {
            this.isEdit = true;
            axios.get("/api/posts/" + id).then(res => {
                const {
                    id,
                    title,
                    description,
                    allow_comment,
                    tags,
                    categories,
                    image,
                    image_url
                } = res.data.post;

                this.form.id = id;
                this.form.title = title;
                this.form.description = description;
                this.form.allow_comment = allow_comment;
                this.form.tags = tags;
                this.form.categories = categories;
                this.form.image = image;
                this.form.image_url = image_url;
            });
        },
        createPost() {
            // Submit the form via a POST request
            axios
                .post("/api/posts", this.form)
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
                    this.errors = err.response.data.errors;
                    window.scrollTo(0, 0);
                });
        },
        updatePost() {
            // Submit the form via a POST request
            axios
                .put("/api/posts/" + this.form.id, this.form)
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
                    this.errors = err.response.data.errors;
                    window.scrollTo(0, 0);
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

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
