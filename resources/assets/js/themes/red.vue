<template>
    
</template>

<script>
    export default {
        name: "red",
        mounted() {
            this.$vuetify.theme.dark = false;
            this.$vuetify.theme.themes.light.primary = '#f44336';
        }
    }
</script>

<style scoped>

</style>