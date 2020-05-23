<template>
    <div class="container">
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users</h3>

                        <div class="card-tools">
                            <!-- Button trigger modal -->
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="openUserModal"
                            >
                                Add New
                            </button>
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
                                    <th>Created At</th>
                                    <th>Type</th>
                                    <th>Modify</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td>{{ user.id }}</td>
                                    <td>{{ user.name | upperCase }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.created_at | myDate }}</td>
                                    <td>
                                        Role
                                    </td>
                                    <td>
                                        <a
                                            href="#"
                                            @click="editUserModal(user)"
                                        >
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a
                                            href="#"
                                            @click="deleteUser(user.id)"
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

        <!-- Modal -->
        <div
            class="modal fade"
            id="addUserModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="addUserLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form
                        @submit.prevent="editMode ? updateUser() : createUser()"
                        @keydown="form.onKeydown($event)"
                    >
                        <div class="modal-header">
                            <h5
                                class="modal-title"
                                id="addUserLabel"
                                v-show="!editMode"
                            >
                                Add User
                            </h5>
                            <h5
                                class="modal-title"
                                id="addUserLabel"
                                v-show="editMode"
                            >
                                Edit User
                            </h5>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input
                                    v-model="form.name"
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('name')
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
                                        'is-invalid': form.errors.has('email')
                                    }"
                                />
                                <has-error
                                    :form="form"
                                    field="email"
                                ></has-error>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
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
                                <label>Role</label>
                                <select
                                    v-model="form.role"
                                    type="text"
                                    name="role"
                                    class="form-control"
                                    :class="{
                                        'is-invalid': form.errors.has('role')
                                    }"
                                >
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                                <has-error
                                    :form="form"
                                    field="role"
                                ></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-danger"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button
                                v-show="!editMode"
                                type="submit"
                                class="btn btn-primary"
                                :disabled="form.busy"
                            >
                                Create
                            </button>
                            <button
                                v-show="editMode"
                                type="submit"
                                class="btn btn-primary"
                                :disabled="form.busy"
                            >
                                Edit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            users: [],
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
    mounted() {
        console.log("Component mounted.");
    },
    created() {
        console.log("a");
        this.loadUsers();
        Fire.$on("loadUsers", () => {
            this.loadUsers();
        });
    },
    methods: {
        openUserModal() {
            this.editMode = false;
            this.form.reset();
            $("#addUserModal").modal("show");
        },
        editUserModal(user) {
            this.editMode = true;
            this.form.reset();
            $("#addUserModal").modal("show");
            this.form.fill(user);
        },
        createUser() {
            // Submit the form via a POST request
            this.form.post("/api/user").then(({ data }) => {
                console.log(data);
                $("#addUserModal").modal("hide");

                Toast.fire({
                    icon: "success",
                    title: "Successfully created"
                });

                Fire.$emit("loadUsers");
            });
        },
        updateUser() {
            // Submit the form via a POST request
            this.form.put("/api/user/" + this.form.id).then(({ data }) => {
                $("#addUserModal").modal("hide");

                Toast.fire({
                    icon: "success",
                    title: "Successfully updated"
                });

                Fire.$emit("loadUsers");
            });
        },
        loadUsers() {
            axios.get("/api/user").then(res => {
                this.users = res.data.user.data;
            });
        },
        deleteUser(id) {
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
                        .delete("/api/user/" + id)
                        .then(data => {
                            Swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            );
                            Fire.$emit("loadUsers");
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
