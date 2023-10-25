<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">All Customers</h1>

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
                                    <th>email</th>
                                    <th>address</th>
                                    <th>phone</th>
                                    <th>photo</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>



                                <tr v-for="customer in filterCustomers" :key="customer.id">

                                    <td>{{customer.name}}</td>
                                    <td>{{customer.email}}</td>
                                    <td>{{customer.address}}</td>
                                    <td>{{customer.phone}}</td>
                                    <td>
                                        <img :src="customer.photo" class="customer-photo">
                                    </td>



                                    <td>
                                        <router-link class="btn btn-success" :to="{ name: 'editCustomer', params: { id: customer.id } }">edit</router-link>
                                        <button class="btn btn-danger" type="button" @click="deleteCustomer(customer.id)">delete</button>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    export default {
        created() {
            if (!User.loggedIn()) {
                this.$router.push({
                    name: '/'
                })

            }
        },
        data() {
            return {
                customers: [],
                searchItem: '',
                errors: {}
            }
        },
        computed: {
            filterCustomers() {
                return this.customers.filter(customer => {
                    return customer.name.toLowerCase().match(this.searchItem.toLowerCase())

                })
            }
        },
        methods: {

            allCustomers() {
                axios.get('/api/customer')
                    .then(({
                        data
                    }) => {
                        this.customers = data

                    })
                    .catch(() => {

                    })
            },
            deleteCustomer(id) {

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
                        axios.delete('/api/customer/' + id)
                            .then(() => {
                                this.customers = this.customers.filter(customer => {
                                    return customer.id != id
                                })
                            })
                            .catch(() => {
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
        },
        created() {
            this.allCustomers()

        }
    }
</script>
<style type="text/css">
    .customer-photo {
        height: 2.5rem;
        width: 2.5rem;
    }
</style>
