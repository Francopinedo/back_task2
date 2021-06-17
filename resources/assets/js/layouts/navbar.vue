<template>
        <v-bottom-navigation
            :value="activeBtn"
            color="primary"
            horizontal
            fixed
            scroll-threshold
        >
            <v-btn v-for="folder in folderResponse.slice().reverse()" :to="folder.full_name">
                <span>{{folder.full_name}}</span>
                 <v-icon v-if="folder.full_name == 'External'">mdi-email</v-icon>
                <v-icon v-if="folder.full_name == 'INBOX'">mdi-email</v-icon>
                <v-icon v-if="folder.full_name == 'Drafts'">mdi-email-edit</v-icon>
                <v-icon v-if="folder.full_name == 'Trash'">mdi-email-minus</v-icon>
                <v-icon v-if="folder.full_name == 'Sent'">mdi-email-receive</v-icon>
            </v-btn>
        </v-bottom-navigation>

</template>
<script>
    export default {
        name: "nav-bar",
        props: ['selectedtheme'],
        data () {
            return {
                folderResponse: null,
                activeBtn: 0,
            }
        },
        created(){
            this.$router.push('/INBOX');
        },
        mounted() {
            if(window.imapHostKey)
            {var get = window.hostKey + 'folders?username=' + window.clientKey + '&' + 'secret=' + window.secretKey + '&' + 'secret=' + window.secretKey + '&' + 'host=' + window.imapHostKey;}
            else
            {var get = window.hostKey + 'folders?username=' + window.clientKey + '&' + 'secret=' + window.secretKey;}
            console.log(get);
            axios
                .get(get)
                .then(response => (this.folderResponse = response.data))
        },
    }
</script>

