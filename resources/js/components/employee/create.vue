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
                                        <h1 class="h4 text-gray-900 mb-4">Create Employee</h1>
                                    </div>
                                    <form class="employee" @submit.prevent="storeEmployee" enctype="multipart/form-data">

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Your Full Name" v-model="form.name">
                                                    <!-- <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small> -->

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="email" v-model="form.email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address">
                                                    <!-- <small class="text-danger" v-if="errors.email">{{errors.email[0]}}</small> -->

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" placeholder="Enter Your Address" v-model="form.address">
                                                    <!-- <small class="text-danger" v-if="errors.address">{{errors.address[0]}}</small> -->

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" v-model="form.phone" class="form-control" placeholder="Enter Your Phone">
                                                    <!-- <small class="text-danger" v-if="errors.phone">{{errors.phone[0]}}</small> -->

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" class="form-control" placeholder="Enter Your NId" v-model="form.nid">
                                                    <!-- <small class="text-danger" v-if="errors.nid">{{errors.nid[0]}}</small> -->

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="text" v-model="form.salary" class="form-control" placeholder="Enter Your Salary">
                                                    <!-- <small class="text-danger" v-if="errors.salary">{{errors.salary[0]}}</small> -->

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <input type="date" class="form-control" v-model="form.joining_date">

                                                    <!-- <small class="text-danger" v-if="errors.joining_date">{{errors.joining_date[0]}}</small> -->

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
                                                <img :src="form.photo" alt="" id="photo">
                                            </div>
                                        </div>





                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Create Employee</button>
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
                form: {
                    name: null,
                    email: null,
                    address: null,
                    nid: null,
                    phone: null,
                    salary: null,
                    joining_date: null,
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
                    reader.onload = event => {
                        this.form.photo = event.target.result
                    }
                    reader.readAsDataURL(file)
                }



            },
            storeEmployee() {

                axios.post('/api/employee',this.form)
                    .then(res => {


                        this.$router.push({
                            path: '/employee'
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
