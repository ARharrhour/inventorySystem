<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">All Salary <Details></Details></h1>

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

                                    <th>Month Name</th>
                                    <th>Details</th>

                                </tr>
                            </thead>
                            <tbody>



                                <tr v-for="salary in filterSalaries" :key="salary.id">

                                    <td>{{salary.salary_month}}</td>
                                    <td>
                                        <router-link class="btn btn-primary" :to="{ name: 'view-salary', params: { id: salary.salary_month } }">View Salary</router-link>
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
                salaries: [],
                searchItem: '',
                errors: {}
            }
        },
        computed: {
            filterSearch() {
                return this.salaries.filter(salary => {
                    return salary.salary_month.toLowerCase().match(this.searchItem.toLowerCase())

                })
            }
        },
        methods: {

            allSalaries() {
                axios.get('/api/salary')
                    .then(({
                        data
                    }) => {
                        this.salaries = data

                    })
                    .catch((error) => {
                        this.errors=error.response.data.errors

                    })
            },

        },
        created() {
            this.allSalaries()

        }
    }
</script>
<style type="text/css">

</style>
