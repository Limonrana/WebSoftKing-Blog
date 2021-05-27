<template>

</template>

<script>
export default {
    name: "logout",
    async created() {
        const res = await this.callApi('get', '/logout');
        if (res.status == 200) {
            this.s('Admin has been logout successfully!')
            this.$router.push({name: '/login'})
        }
    }
}
</script>

<style scoped>

</style>
