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
                                        <h1 class="h4 text-gray-900 mb-4">Edit Customer</h1>
                                    </div>
                                    <form class="customer" @submit.prevent="editCustomer" enctype="multipart/form-data">

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" placeholder="Enter Customer Full Name" v-model="customer.name">
                                                    <!-- <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small> -->

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="email" v-model="customer.email" class="form-control"  aria-describedby="emailHelp" placeholder="Enter Customer Email Address">
                                                    <!-- <small class="text-danger" v-if="errors.email">{{errors.email[0]}}</small> -->

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" v-model="customer.address">
                                                    <!-- <small class="text-danger" v-if="errors.address">{{errors.address[0]}}</small> -->

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" v-model="customer.phone" class="form-control">
                                                    <!-- <small class="text-danger" v-if="errors.phone">{{errors.phone[0]}}</small> -->

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
                                                <img :src="'/'+customer.photo" alt="" id="photo">
                                            </div>
                                        </div>





                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Update Customer</button>
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
                    name: '/'
                })

            }


            let editId = this.$route.params.id;
            axios.get('/api/customer/' + editId)
                .then(({
                    data
                }) => {
                    this.customer = data
                })
                .catch((error) => {
                    Notification.error()
                })
        },

        data() {
            return {
                customer: {
                    name: '',
                    email: '',
                    address: '',
                    phone: '',
                    photo: '',
                    newPhoto: ''
                },
                errors: {}
            }

        },
        methods: {
            onFileChange(event) {

                let file = event.target.files[0];

                if (file.size > 1048770) {
                    Notification.image_validation()
                } else {
                    let reader = new FileReader();
                    reader.onload = event => {
                        console.log(event)
                        this.customer.newPhoto = event.target.result
                        $("#photo").attr("src", this.customer.newPhoto)
                    }
                    reader.readAsDataURL(file)
                }



            },
            editCustomer() {

                let id = this.$route.params.id;
                axios.patch("/api/customer/" + id, this.customer)
                    .then(() => {

                        this.$router.push({
                            name: "customers"
                        });
                        Notification.success();

                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors
                    })



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
