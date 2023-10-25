<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">All Employees</h1>

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
                                    <th>Update</th>

                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>



                                <tr v-for="category in filterSearch" :key="category.id">

                                    <td>{{category.category_name}}</td>


                                    <td> <router-link class="btn btn-success" :to="{ name: 'editCategory', params: { id: category.id } }">edit</router-link>
                                    </td>

                                    <td>
                                        <button class="btn btn-danger" type="button" @click="deleteCategory(category.id)">delete</button>
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
                categories: [],
                searchItem: '',
                errors: {}
            }
        },
        computed: {
            filterSearch() {
                return this.categories.filter(category => {
                    return category.category_name.toLowerCase().match(this.searchItem.toLowerCase())

                })
            }
        },
        methods: {

            allCategories() {
                axios.get('/api/category')
                    .then(({
                        data
                    }) => {

                        this.categories = data

                    })
                    .catch(() => {

                    })
            },
            deleteCategory(id) {

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
                        axios.delete('/api/category/' + id)
                            .then(() => {
                                this.categories = this.categories.filter(category => {
                                    return category.id != id
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
            this.allCategories()

        }
    }
</script>
<style type="text/css">

</style>
