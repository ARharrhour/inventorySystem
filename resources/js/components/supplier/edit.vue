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
                                        <h1 class="h4 text-gray-900 mb-4">Update Supplier</h1>
                                    </div>
                                    <form class="supplier" @submit.prevent="editSupplier" enctype="multipart/form-data">

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" placeholder="Enter Your Full Name" v-model="supplier.name">
                                                    <!-- <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small> -->

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="email" v-model="supplier.email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address">
                                                    <!-- <small class="text-danger" v-if="errors.email">{{errors.email[0]}}</small> -->

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" placeholder="Enter Your Address" v-model="supplier.address">
                                                    <!-- <small class="text-danger" v-if="errors.address">{{errors.address[0]}}</small> -->

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" v-model="supplier.shop_name" class="form-control" placeholder="Enter Your Shop Name">
                                                    <!-- <small class="text-danger" v-if="errors.phone">{{errors.phone[0]}}</small> -->

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" placeholder="Enter Your Number Phone" v-model="supplier.phone">
                                                    <!-- <small class="text-danger" v-if="errors.nid">{{errors.nid[0]}}</small> -->

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
                                                <img :src="'/'+supplier.photo" alt="" id="photo">
                                            </div>
                                        </div>





                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Update Supplier</button>
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

            let id=this.$route.params.id;
            axios.get("/api/supplier/"+id)
            .then(({data})=>{
                this.supplier=data
            })
            .catch(()=>{
                Notification.error();
            })
        },
        data() {

            return {
                supplier: {
                    name: '',
                    email: '',
                    address: '',
                    phone: '',
                    shop_name: '',
                    photo: '',
                    newPhoto:''
                },
                errors: {}
            }
        },
        methods: {
            editSupplier() {
                let id=this.$route.params.id;
                axios.patch("/api/supplier/"+id, this.supplier)
                    .then(() => {
                        this.$router.push({
                            name: "suppliers"
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
                        this.supplier.newPhoto = event.target.result
                        $("#photo").attr("src",this.supplier.newPhoto)
                    }
                    reader.readAsDataURL(file);
                }


            }

        }
    }
</script>
<style type="text/css">
    #photo {
        height: 2.5rem;
        width: 2.5rem;
    }
</style>
