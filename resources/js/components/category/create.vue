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
                                        <h1 class="h4 text-gray-900 mb-4">
                                            Create Category
                                        </h1>
                                    </div>
                                    <form class="category" @submit.prevent="storeCategory">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="Enter Category's Name" v-model="category.category_name" />
                                            <!-- <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small> -->
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                Create Category
                                            </button>
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
                    name: "/",
                });
            }
        },

        data() {
            return {
                category: {
                    category_name: null,
                },
                errors: {},
            };
        },
        methods: {

            storeCategory() {
                axios.post("/api/category", this.category).
                then(() => {
                    this.$router.push({name:"categories"})
                    Notification.success();

                }).
                catch((error) => this.errors = error.response.data.errors)
            }
        },
    };
</script>
<style type="text/css"></style>
