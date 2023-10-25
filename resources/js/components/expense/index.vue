<template>
    <div>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">All Expenses</h1>

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


                                    <th>Details</th>
                                    <th>Amount</th>
                                    <th>Expense Date</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>



                                <tr v-for="expense in filterExpenses" :key="expense.id">


                                    <td>{{expense.details}}</td>
                                    <td>{{expense.amount}}</td>
                                    <td>{{expense.expense_date}}</td>
                                    <td> <router-link class="btn btn-success" :to="{ name: 'editExpense', params: { id: expense.id } }">edit</router-link>
                                    </td>






                                    <td>
                                        <button class="btn btn-danger" type="button" @click="deleteExpense(expense.id)">delete</button>
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
                expenses: [],
                searchItem: '',
                errors: {}
            }
        },
        computed: {
            filterExpenses() {
                return this.expenses.filter(expense => {
                    return expense.expense_date.toLowerCase().match(this.searchItem.toLowerCase())

                })
            }
        },
        methods: {

            allExpenses() {
                axios.get('/api/expense')
                    .then(({
                        data
                    }) => {
                        this.expenses = data

                    })
                    .catch(() => {
                        Notification.error()
                    })
            },
            deleteExpense(id) {

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
                        axios.delete('/api/expense/' + id)
                            .then(() => {
                                this.expenses = this.expenses.filter(expense => {
                                    return expense.id != id
                                })
                            })
                            .catch(() => {
                                Notification.error();
                            })
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })



            }
        },
        created() {
            this.allExpenses()

        }
    }
</script>
<style type="text/css">

</style>
