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
                                        <h1 class="h4 text-gray-900 mb-4">Edit Expense</h1>
                                    </div>
                                    <form class="expense" @submit.prevent="editExpense" enctype="multipart/form-data">


                                                <div class="form-group">
                                                    <label for="amount">Expense Amount</label>
                                                    <input type="text" class="form-control" placeholder="Enter Expense Amount" v-model="expense.amount">

                                                </div>



                                                <div class="form-group">
                                                    <label for="details">Details</label>
                                                    <textarea class="form-control" v-model="expense.details" id="exampleFormControlTextarea1" rows="7"></textarea>
                                                </div>







                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Update Expense</button>
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
            let id=this.$route.params.id;
            axios.get("/api/expense/"+id)
            .then(({data})=>{
                this.expense=data
            })
            .catch(()=>{Notification.error()})
        },

        data() {
            return {
                expense: {
                    amount: null,
                    details: null,


                },
                errors: {}
            }

        },
        methods: {





            editExpense() {
                let id=this.$route.params.id;
                axios.patch('/api/expense/'+id, this.expense)
                    .then(res => {


                        this.$router.push({
                            path: '/expense'
                        });
                        Notification.success()

                    })
                    .catch(error => {
                        Notification.error()
                    })



            }
        }
    }
</script>
<style type="text/css">

</style>
