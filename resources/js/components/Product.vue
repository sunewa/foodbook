<template>
    <div class="container">
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Products</h3>

                        <div class="card-tools">
                            <!-- Button trigger modal -->
                            <router-link
                                :to="{ name: 'product-create' }"
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
                                    <th>Price (AU$)</th>
                                    <th>Is available?</th>
                                    <th>Created At</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="product in products"
                                    :key="product.id"
                                >
                                    <td>{{ product.id }}</td>
                                    <td>{{ product.title | upperCase }}</td>
                                    <td>{{ product.price }}</td>
                                    <td>
                                        {{ product.available ? "Yes" : "No" }}
                                    </td>
                                    <td>{{ product.created_at | myDate }}</td>
                                    <td>
                                        <router-link
                                            :to="{
                                                name: 'product-edit',
                                                params: { id: product.id }
                                            }"
                                        >
                                            <i class="fa fa-edit"></i> Edit
                                        </router-link>
                                        <a
                                            href="#"
                                            @click="deleteProduct(product.id)"
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
            products: []
        };
    },
    mounted() {},
    created() {
        this.loadProducts();
        Fire.$on("loadProducts", () => {
            this.loadProducts();
        });
    },
    methods: {
        loadProducts() {
            axios.get("/api/products").then(response => {
                this.products = response.data.products;
            });
        },
        deleteProduct(id) {
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
                        .delete("/api/products/" + id)
                        .then(data => {
                            Swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                            Fire.$emit("loadProducts");
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
