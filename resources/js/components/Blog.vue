<template>
    <div class="container">
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Blogs</h3>

                        <div class="card-tools">
                            <!-- Button trigger modal -->
                            <router-link
                                to="/blog/create"
                                class="btn btn-primary"
                            >
                                Add New
                            </router-link>
                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="blog in blogs" :key="blog.id">
                                    <td>{{ blog.id }}</td>
                                    <td>{{ blog.title | upperCase }}</td>
                                    <td>{{ blog.created_at | myDate }}</td>
                                    <td>
                                        <router-link
                                            :to="{
                                                name: 'blog-edit',
                                                params: { id: blog.id }
                                            }"
                                        >
                                            <i class="fa fa-edit"></i> Edit
                                        </router-link>
                                        <a
                                            href="#"
                                            @click="deleteBlog(blog.id)"
                                        >
                                            <i class="fa fa-trash"></i>
                                            Delete
                                        </a>
                                    </td>
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
            blogs: []
        };
    },
    mounted() {},
    created() {
        this.loadPosts();
        Fire.$on("loadPosts", () => {
            this.loadPosts();
        });
    },
    methods: {
        loadPosts() {
            axios.get("/api/blog").then(response => {
                this.blogs = response.data.blogs;
            });
        },
        deleteBlog(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                if (result.value) {
                    axios
                        .delete("/api/blog/" + id)
                        .then(data => {
                            Swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                            Fire.$emit("loadPosts");
                        })
                        .catch(() => {
                            Swal.fire("Failed!", "Something wrong", "warning");
                        });
                }
            });
        }
    }
};
</script>
