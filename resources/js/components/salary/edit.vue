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
                                        <h1 class="h4 text-gray-900 mb-4">Update Salary</h1>
                                    </div>
                                    <form class="salary" @submit.prevent="updateSalary">

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="employee">Employee</label>

                                                    <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Employee Name" v-model="salary.name">
                                                    <!-- <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small> -->

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email</label>

                                                    <input type="email" v-model="salary.email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address">
                                                    <!-- <small class="text-danger" v-if="errors.email">{{errors.email[0]}}</small> -->

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="months">Months</label>
                                                    <select class="form-control" v-model="salary.salary_month">
                                                        <option value="January">January</option>
                                                        <option value="February">February</option>
                                                        <option value="March">March</option>
                                                        <option value="April">April</option>
                                                        <option value="May">May</option>
                                                        <option value="June">June</option>
                                                        <option value="July">July</option>
                                                        <option value="August">August</option>
                                                        <option value="September">September</option>
                                                        <option value="October">October</option>
                                                        <option value="November">November</option>
                                                        <option value="December">December</option>
                                                    </select>

                                                    </select>

                                                </div>
                                                <input type="hidden" v-model="salary.employee_id">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="salary">Salary</label>

                                                    <input type="text" v-model="salary.amount" class="form-control" placeholder="Enter Salary Amount">

                                                </div>
                                            </div>
                                        </div>







                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Update Salary</button>
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
            let id = this.$route.params.id
            axios.get('/api/edit/salary/' + id)
                .then(({
                    data
                }) => (this.salary = data))
                .catch()
        },

        data() {
            return {
                salary: {
                    name: null,
                    email: null,
                    amount: null,
                    salary_month: null,
                    employee_id:null
                },
                errors: {}
            }

        },
        methods: {

            updateSalary() {

                let id = this.$route.params.id;
                axios.post('/api/salary/update/' + id, this.salary)
                    .then(res => {


                        this.$router.push({
                            path: '/given-salary'
                        });
                        Notification.success()

                    })
                    .catch(error => console.log(error.response.data.errors))



            }
        }
    }
</script>
<style type="text/css">

</style>
