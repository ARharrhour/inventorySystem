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
                                    <th>email</th>
                                    <th>address</th>
                                    <th>phone</th>
                                    <th>salary</th>
                                    <th>photo</th>
                                    <th>joining_date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>



                                <tr v-for="employee in filterSearch" :key="employee.id">

                                    <td>{{employee.name}}</td>
                                    <td>{{employee.email}}</td>
                                    <td>{{employee.address}}</td>
                                    <td>{{employee.phone}}</td>
                                    <td>{{employee.salary}}</td>
                                    <td>
                                        <img :src="employee.photo" class="employee-photo">
                                    </td>
                                    <td>{{employee.joining_date}}</td>


                                    <td>
                                        <router-link class="btn btn-success" :to="{ name: 'pay-salary', params: { id: employee.id } }">Pay Salary</router-link>
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
                employees: [],
                searchItem: '',
                errors: {}
            }
        },
        computed: {
            filterSearch() {
                return this.employees.filter(employee => {
                    return employee.name.toLowerCase().match(this.searchItem.toLowerCase())

                })
            }
        },
        methods: {

            allEmployees() {
                axios.get('/api/employee')
                    .then(({
                        data
                    }) => {
                        this.employees = data

                    })
                    .catch(() => {

                    })
            }
        },
        created() {
            this.allEmployees()

        }
    }
</script>
<style type="text/css">
    .employee-photo {
        height: 2.5rem;
        width: 2.5rem;
    }
</style>
