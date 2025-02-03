<template>
    <div class="p-4">
        <div class="row mb-5">
            <div class="col-md-4 col-6 header-col">
                <h3 class="heading">Users</h3>
            </div>
            <div class="col-md-8 col-6">
                <div class="btn-text m-0 add-new-cat" style="display: flex; justify-content: flex-end;">
                    <!-- <router-link to="/user-create" class="import2 add-cc hover-cc">Add &nbsp;New</router-link> -->
                </div>
            </div>
        </div>
        <div class="table-border">
            <div class="row p-2">
                <div class="col-md-6 col-12 left-side-filttle">
                    <!-- Status Filter -->
                    <div class="status-filter flex-start gap-3">
                        <p class="active-lable mb-0">All</p>
                        <p class="mb-0 fitle-offer">Pending</p>
                        <p class="mb-0 fitle-offer">Complete</p>
                        <p class="mb-0 fitle-offer">Not Complete</p>
                    </div>

                </div>
                <div class="col-md-6 col-12 right-side-search">
                    <div class="search-input">
                        <input type="text" class="form-control" placeholder="Search..." />
                        <i class="fa fa-search search-icon"></i>
                    </div>
                </div>
            </div>
            <hr class="m-0">
            <div class="spinner2 d-flex justify-content-center mb-3 mt-3" v-if="isAuthenticated">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <table class="table" v-else>
                <thead>
                    <tr>
                        <th class='input-check-box'><input data-v-0b14badc="" type="checkbox"></th>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Role</th>
                        <th scope="col">Agent Id</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in user">
                        <th class='input-check-box'><input data-v-0b14badc="" type="checkbox"></th>
                        <th>{{ index + 1 }}</th>
                        <td>{{ item.name }}</td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.phone }}</td>
                        <td>{{ item.role }}</td>
                        <td>{{ item.agent_id }}</td>
                        <td>
                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Edit-user">
                                <router-link :to="{ name: 'userEdit', params: { id: item.id } }"
                                    class="import2 add-cc hover-cc py-2">
                                    <i class="fa-solid fa-check"></i>
                                </router-link>
                            </span>
                            <span data-bs-toggle="tooltip" data-bs-placement="top" title="Delete-user">
                                <a @click="confirmDelete(item.id)" class="import2 add-cc hover-cc py-2">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div v-if="user && user.length === 0" class="text" style="text-align: center; margin: 10px 0;">
                No User data found
            </div>
        </div>

    </div>
</template>

<script>
import { mapActions, mapState } from 'vuex';


export default {

    methods: {
        ...mapActions('auth', ['fetchAllUsers', 'deleteUsers']),
        confirmDelete(id) {
            if (!id || typeof id !== 'number' && typeof id !== 'string') {
                console.error("Invalid ID passed to delete operation");
                return;
            }

            this.$swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.deleteUsers(id).then(() => {
                        this.$swal.fire({
                            title: "Deleted!",
                            text: "Services is deleted successfully.",
                            icon: "success"
                        });
                    });
                    this.fetchAllUsers(1);
                }
            });
        }
    },
    computed: {
        ...mapState('auth', ['user', 'isAuthenticated', 'pagination']),
    },

    mounted() {
        this.fetchAllUsers(1);
    }
}
</script>

<style scoped>
.table {
    background: #f7f8f9;
}

.input-check-box {
    width: 3%;
    padding-left: 12px;
}

.table-border {
    border: 2px solid #dbdbdb;
    border-radius: 10px;
    background: #f7f8f9;
}

.fitle-offer {
    color: black;
    font-weight: 700;
}
</style>