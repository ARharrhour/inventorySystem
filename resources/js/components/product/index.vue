<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">All Products</h1>

            <input type="text" class="form-control w-25" v-model="searchItem" placeholder="Search Here">
        </div>
        <div class="row">

            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Products List</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Photo</th>
                                    <th>Category</th>
                                    <th>Buying price</th>
                                    <th>Selling price</th>
                                    <th>Root</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in filterProducts" :key="product.id">

                                    <td>{{product.product_name}}</td>
                                    <td>{{product.product_code}}</td>
                                    <td>
                                        <img :src="product.image" id="photo">
                                    </td>
                                    <td  v-for="category in categories"  v-if="product.category_id==category.id">{{category.category_name}}</td>
                                    <td>{{product.buying_price}}</td>
                                    <td>{{product.selling_price}}</td>
                                    <td>{{product.root}}</td>

                                    <td>
                                        <router-link class="btn btn-success" :to="{name:'editProduct' , params:{id:product.id}}">edit</router-link>
                                        <button @click="deleteProduct(product.id)" class="btn btn-danger">delete</button>

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
<script>
    export default {

        created() {

            if (!User.loggedIn()) {
                this.$router.push({
                    name: "/"
                })
            }
            this.allProducts();
            axios.get("/api/category")
                .then(({
                    data
                }) => {
                    this.categories = data
                })
                .catch((error) => {
                    this.error = error.response.data.errors
                });
        },
        data() {
            return {
                products: [],
                errors: [],
                categories:[],
                searchItem: ''
            }
        },
        computed: {
            filterProducts() {
                return this.products.filter((product) => {
                    return product.product_name.toLowerCase().match(this.searchItem.toLowerCase());
                })
            }
        },
        methods: {
            allProducts() {
                axios.get("/api/product")
                    .then(({
                        data
                    }) => {
                        this.products = data
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors
                    })
            },
            deleteProduct(id) {
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
                        axios.delete("/api/product/" + id).
                        then(() => {
                                this.products = this.products.filter((product) => {
                                    return product.id != id;
                                })
                            })
                            .catch(() => {
                                Notification.error()
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
    #photo {
        height: 2.5rem;
        width: 2.5rem;
    }
</style>
