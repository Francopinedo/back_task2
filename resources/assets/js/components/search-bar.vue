<template>
    <v-dialog v-model="dialog" max-width="640" hide-overlay transition="dialog-bottom-transition">
        <template v-slot:activator="{on}">
            <v-btn fab top right fixed v-on="on" color="primary">
                <v-icon>
                    mdi-email-search
                </v-icon>
            </v-btn>
        </template>
        <v-card>
            <v-card-title>
                <v-autocomplete
                    v-model="model"
                    :items="items"
                    :loading="isLoading"
                    :search-input.sync="search"
                    color="primary"
                    hide-no-data
                    hide-selected
                    item-text="Subject"
                    item-value="Subject"
                    label="Mails"
                    placeholder="Escribe para buscar"
                    prepend-icon="mdi-email-search"
                    ref="searchInput"
                    return-object
                ></v-autocomplete>
            </v-card-title>
            <v-divider></v-divider>
            <v-expand-transition>
                <v-list v-if="model">
                    <v-list-item three-line>
                        <v-list-item-content>
                            <v-list-item-title v-text="fields.Subject"></v-list-item-title>
                            <v-list-item-subtitle v-text="fields.From"></v-list-item-subtitle>
                            <v-list-item-subtitle v-text="fields.To"></v-list-item-subtitle>
                            <v-divider></v-divider>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item>
                        <span v-html="fields.Body"></span>
                    </v-list-item>
                </v-list>
            </v-expand-transition>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "search-bar",
        data() {
            return {
                dialog: false,
                searchlabel: "",
                searchmails: "",
                descriptionLimit: 60,
                entries: [],
                bodies: [],
                isLoading: false,
                model: null,
                search: null,
                actualBody: "",
            }
        },
        computed: {
            fields() {
                if (!this.model) return []
                {
                    return this.model;
                }
            },
            items() {
                return this.entries.map(entry => {
                    const Subject = entry.header_info.subject.length > this.descriptionLimit
                        ? entry.header_info.subject.slice(0, this.descriptionLimit) + '...'
                        : entry.header_info.subject
                    const  Body = entry.bodies.html.content;
                    const  From = entry.header_info.fromaddress;
                    const  To = entry.bodies.html.toaddress;
                    return Object.assign({}, {Body}, {Subject},{To},{From})

                })
            },
        },
        watch: {
            search(val) {
                // Items have already been loaded
                if (this.items.length > 0) return

                // Items have already been requested
                if (this.isLoading) return

                this.isLoading = true

                var get = window.hostKey + 'folders/search' + this.$route.path + '?' + 'username=' + window.clientKey + '&' + 'secret=' + window.secretKey;

                // Lazily load input items
                fetch(get)
                    .then(res => res.json())
                    .then(res => {
                        const {count, entries, bodies} = res
                        this.count = count
                        this.entries = entries
                        this.bodies = bodies
                    })
                    .catch(err => {
                        console.log(err)
                    })
                    .finally(() => (this.isLoading = false))
            },
        },
    }
</script>

<style scoped>

</style>
