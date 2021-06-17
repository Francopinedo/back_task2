<template>
    
</template>

<script>
    export default {
        name: "gray",
        mounted() {
            this.$vuetify.theme.dark = false;
            this.$vuetify.theme.themes.light.primary = '#444';
        }
    }
</script>

<style scoped>

</style>