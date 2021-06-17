<template>
    
</template>

<script>
    export default {
        name: "yellow",
        mounted() {
            this.$vuetify.theme.dark = false;
            this.$vuetify.theme.themes.light.primary = '#ffeb3b';
        }
    }
</script>

<style scoped>

</style>