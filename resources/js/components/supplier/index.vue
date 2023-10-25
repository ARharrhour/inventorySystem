<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">All Suppliers</h1>

            <input type="text" class="form-control w-25" v-model="searchItem" placeholder="Search Here">
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>

                                    <th>Name</th>
                                    <th>photo</th>
                                    <th>Shop Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>



                                <tr v-for="supplier in filterSupplier" :key="supplier.id">

                                    <td>{{supplier.name}}</td>
                                    <td>
                                        <img :src="supplier.photo" class="employee-photo">
                                    </td>
                                    <td>{{supplier.shop_name}}</td>
                                    <td>{{supplier.email}}</td>
                                    <td>{{supplier.address}}</td>
                                    <td>{{supplier.phone}}</td>



                                    <td>
                                        <router-link class="btn btn-success" :to="{ name: 'editSupplier', params: { id: supplier.id } }">edit</router-link>
                                        <button class="btn btn-danger" type="button" @click="deleteSupplier(supplier.id)">delete</button>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="alter alert-warning text-center" id="notFound" role="alert" v-show="this.suppliers.length==0">Not Found !</div>

            </div>
        </div>
    </div>

</template>

<script>
    export default {

        created() {
            if (!User.loggedIn()) {
                this.$router.push({
                    name: "/"
                })
            }

            this.allSuppliers()



        },
        computed: {
            filterSupplier() {
                return this.suppliers.filter((supplier) => {
                    return supplier.name.toLowerCase().match(this.searchItem.toLowerCase())
                })
            }
        },
        data() {
            return {
                suppliers: [],
                errors: {},
                searchItem: ""
            }

        },
        methods: {

            allSuppliers() {

                axios.get("/api/supplier")
                    .then(({
                        data
                    }) => {
                        this.suppliers = data
                    })
                    .catch((error) => this.errors = error.response.data.errors);
            },

            deleteSupplier(id) {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete("/api/supplier/" + id).
                        then(() => {
                            this.suppliers = this.suppliers.filter((supplier) => {
                                return supplier.id != id;
                            })
                        }).catch(() => {
                            Notification.error();
                        })
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            }
        }





    }
</script>

<style>
    #notFound{
        font-size: 1.50rem;
    }
</style>
