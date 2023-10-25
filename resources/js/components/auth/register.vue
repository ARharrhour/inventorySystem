<template>

    <!-- Register Content -->
    <div class="col-md-6 mx-auto">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Register</h1>
                                    </div>
                                    <form class="user" @submit.prevent="register">
                                        <div class="form-group">

                                            <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Your Full Name" v-model="form.name">
                                            <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>

                                        </div>

                                        <div class="form-group">

                                            <input type="email" v-model="form.email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address">
                                            <small class="text-danger" v-if="errors.email">{{errors.email[0]}}</small>

                                        </div>
                                        <div class="form-group">

                                            <input type="password" v-model="form.password" class="form-control" id="exampleInputPassword" placeholder="Password">
                                            <small class="text-danger" v-if="errors.password">{{errors.password[0]}}</small>

                                        </div>
                                        <div class="form-group">

                                            <input type="password" v-model="form.confirmPassword" class="form-control" id="exampleInputPasswordRepeat" placeholder="Confirm Password">
                                            <small class="text-danger" v-if="errors.confirmPassword">{{errors.confirmPassword[0]}}</small>

                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                                        </div>

                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <router-link to="/" class="font-weight-bold small">Already have an account?</router-link>
                                    </div>

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
            if (User.loggedIn()) {
                this.$router.push({
                    name: 'home'
                })

            }
        },

        data() {
            return {
                form: {
                    name: null,
                    email: null,
                    password: null,
                    confirmPassword: null
                },
                errors: {}
            }

        },
        methods: {
            login() {
                axios.post('/api/auth/signup', this.form)
                    .then(res => {
                        User.responseAfterLogin(res)

                        // notify success signed in
                        // Toast.fire({
                        //     icon: 'success',
                        //     title: 'Registered successfully!'
                        // })

                        this.$router.push({
                            name: 'home'
                        })

                    })
                    .catch(error => this.errors = error.response.data.errors)

            }
        }
    }
</script>
<style type="text/css"></style>
