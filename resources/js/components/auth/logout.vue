<template>

</template>

<script type="text/javascript">
    export default {
        created() {
            localStorage.removeItem('token')
            localStorage.removeItem('user')
            Toast.fire({
                icon: 'success',
                title: 'logged out successfully!'
            })
            this.$router.push({
                name: '/'
            })

        }
    }
</script>
<style type="text/css"></style>
