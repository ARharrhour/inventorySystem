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
                                        <h1 class="h4 text-gray-900 mb-4">Create Customer</h1>
                                    </div>
                                    <form class="customer" @submit.prevent="storeCustomer" enctype="multipart/form-data">

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" placeholder="Enter Customer Full Name" v-model="customer.name">

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="email" v-model="customer.email" class="form-control" placeholder="Enter Customer Email Address">
                                                    <!-- <small class="text-danger" v-if="errors.email">{{errors.email[0]}}</small> -->

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" placeholder="Enter Customer Address" v-model="customer.address">
                                                    <!-- <small class="text-danger" v-if="errors.address">{{errors.address[0]}}</small> -->

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" v-model="customer.phone" class="form-control" placeholder="Enter Customer Phone">
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
                                                <img :src="customer.photo" alt="" id="photo">
                                            </div>
                                        </div>





                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Create customer</button>
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
        },

        data() {
            return {
                customer: {
                    name: null,
                    email: null,
                    address: null,
                    phone: null,
                    photo: null
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
                    reader.onload = (event) => {
                        this.customer.photo = event.target.result
                    }
                    reader.readAsDataURL(file);

                }

            },


            storeCustomer() {

                axios.post('/api/customer', this.customer)
                    .then(res => {


                        this.$router.push({
                            path: '/customer'
                        });
                        Notification.success()

                    })
                    .catch(error => console.log(error.response.data.errors))



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
