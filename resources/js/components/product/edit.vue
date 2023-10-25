<template>

    <!-- Register Content -->
    <div class="">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Edit Product</h1>
                                    </div>
                                    <form class="product" @submit.prevent="editProduct" enctype="multipart/form-data">

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="name">Product Name</label>
                                                    <input type="text" class="form-control" placeholder="Enter Product Name" v-model="product.product_name">

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="code">Product Code</label>
                                                    <input type="text" v-model="product.product_code" class="form-control" placeholder="Enter Product Code">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="root">Product Root</label>
                                                    <input type="text" class="form-control" placeholder="Enter the Root" v-model="product.root">

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="quantity">Product Quantity</label>
                                                    <input type="text" v-model="product.product_quantity" class="form-control" placeholder="Enter Product Quantity">

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="buyingdate">Buying Date</label>
                                                    <input type="date" class="form-control" placeholder="Enter Buying Date" v-model="product.buying_date">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="sell">Selling Price</label>
                                                    <input type="text" class="form-control" placeholder="Enter Selling Price" v-model="product.selling_price">

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="buying">Buying Price</label>
                                                    <input type="text" v-model="product.buying_price" class="form-control" placeholder="Enter Buying Price">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="category">Category select</label>
                                                    <select class="form-control" id="categorySelect" v-model="product.category_id">

                                                        <option v-for="category in categories" :value="category.id">{{category.category_name}}</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="supplier">Supplier select</label>
                                                    <select class="form-control" v-model="product.supplier_id">

                                                        <option v-for="supplier in suppliers" :value="supplier.id">{{supplier.name}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>






                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="file" class="custom-file-input" id="customFile" @change="onFileChange">
                                                    <label for="customFile" class="custom-file-label">Choose file</label>

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <img :src="'/'+product.image" alt="" id="photo">
                                            </div>
                                        </div>





                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Update Product</button>
                                        </div>

                                    </form>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Content -->
</template>
<script type="text/javascript">
    export default {
        created() {

            if (!User.loggedIn()) {
                this.$router.push({
                    name: "/"
                })
            }

            let id = this.$route.params.id;
            axios.get("/api/product/" + id)
                .then(({
                    data
                }) => {
                    this.product = data
                })
                .catch(() => {
                    Notification.error();
                })
            axios.get("/api/supplier")
                .then(({
                    data
                }) => {
                    this.suppliers = data
                })
                .catch((error) => {
                    this.error = error.response.data.errors
                });


            axios.get("/api/category")
                .then(({
                    data
                }) => {
                    this.categories = data
                })
                .catch((error) => {
                    this.error = error.response.data.errors
                })
        },
        data() {

            return {
                product: {
                    product_name: '',
                    image: '',
                    selling_price: 0.0,
                    buying_price: 0.0,
                    product_code: '',
                    supplier_id: null,
                    root: '',
                    buying_date: '',
                    product_quantity: 0.0,
                    category_id: null,
                    newPhoto: null
                },
                errors: {},
                categories: [],
                suppliers: [],
            }
        },
        methods: {
            editProduct() {
                let id = this.$route.params.id;
                axios.patch("/api/product/" + id, this.product)
                    .then(() => {
                        this.$router.push({
                            name: "products"
                        })
                        Notification.success()
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors
                    })
            },
            onFileChange(event) {
                let file = event.target.files[0];
                if (file.size > 1048770) {
                    Notification.image_validation();
                } else {
                    let reader = new FileReader();
                    reader.onload = (event) => {
                        this.product.newPhoto = event.target.result
                        $("#photo").attr("src", this.product.newPhoto)
                    }
                    reader.readAsDataURL(file);
                }


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
