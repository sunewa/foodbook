<template>
    <!-- Modal -->
    <div
        class="modal fade"
        id="addUserModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="addUserLabel"
        aria-hidden="true"
        v-show="showModal"
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
                            <has-error :form="form" field="name"></has-error>
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
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input
                                v-model="form.password"
                                type="password"
                                name="password"
                                class="form-control"
                                :class="{
                                    'is-invalid': form.errors.has('password')
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
                                name="role"
                                class="form-control"
                                :class="{
                                    'is-invalid': form.errors.has('role')
                                }"
                            >
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                            <has-error :form="form" field="role"></has-error>
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
</template>

<script>
export default {
    props: { editMode: Boolean, showModal: Boolean },
    data() {
        return {
            form: new Form({
                id: "",
                name: "",
                email: "",
                password: "",
                role: "user",
                photo: ""
            })
        };
    },
    created() {
        this.form.reset();
        $("#addUserModal").modal("show");
        console.log("t");
    },
    mounted() {
        // console.log("Component mounted.");
    },
    methods: {
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
        }
    }
};
</script>
