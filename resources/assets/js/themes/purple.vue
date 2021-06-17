<template>
    
</template>

<script>
    export default {
        name: "purple",
        mounted() {
            this.$vuetify.theme.dark = false;
            this.$vuetify.theme.themes.light.primary = '#673ab7';
        }
    }
</script>

<style scoped>

</style>