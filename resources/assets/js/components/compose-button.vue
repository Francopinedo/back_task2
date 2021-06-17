<template>
    <v-row>
        <v-speed-dial
                v-model="fab"
                bottom="bottom"
                right="right"
                direction="top"
                fixed
                open-on-hover
                transition="slide-y-reverse-transition"
        >
            <template v-slot:activator>
                <v-btn
                        v-model="fab"
                        color="primary"
                        dark
                        fab
                >
                    <v-icon v-if="fab">mdi-close</v-icon>
                    <v-icon v-else>mdi-email</v-icon>
                </v-btn>
            </template>
            <v-btn
                    fab
                    dark
                    small
                    color="green"
                    v-on:click="dialog = true"
            >
                <v-icon>mdi-email-plus</v-icon>
            </v-btn>
            <v-btn
                    fab
                    dark
                    small
                    color="indigo"
                    v-on:click="goToTemplates"
            >
                <v-icon>mdi-email-edit</v-icon>
            </v-btn>
        </v-speed-dial>
        <v-dialog v-model="dialog" max-width="560px">

<!--            <template v-slot:activator="{ on }">
                <v-btn
                        class="mx-2"
                        fab
                        large
                        fixed
                        right
                        bottom
                        transition="slide-y-reverse-transition"
                        color="primary"
                        v-on="on"
                >
                    <v-icon>mdi-email</v-icon>
                </v-btn>
            </template>-->

            <v-card
                    :loading="loading"
            >
                <v-form v-model="isvalid" ref="comp">
                    <v-card-text>
                        <v-text-field
                                required
                                :rules="subjectRules"
                                label="Subject"
                                hint="example: Sales report"
                                ref="subject"
                                v-model="templateSubject"
                        >


                        </v-text-field>
                        <v-select
                                required
                                label="To Group"
                                v-model="selectContactsGroup"
                                :items="contactsGroup"
                                item-text="group"
                                item-value="group"
                        >
                        </v-select>
                        <v-select
                                required
                                label="To"
                                v-if="selectContactsGroup"
                                :items="recivers"
                                item-text="name"
                                return-object
                                v-model="toSend"
                        >
                        </v-select>
                        <v-select
                                required
                                label="Mail"
                                v-if="toSend"
                                :items="contactOptions"
                                ref="to"
                        ></v-select>
                        <!--cc-->
                        <v-select
                                label="Cc Group"
                                v-model="selectccGroup"
                                :items="ccGroup"
                                item-text="group"
                                item-value="group"
                                ref="cc"
                        >
                        </v-select>
                        <v-select
                                label="Cc"
                                v-if="selectccGroup"
                                :items="ccs"
                                item-text="name"
                                v-model="ccSend"
                                return-object
                        >
                        </v-select>
                        <v-select
                                label="Cc Mail"
                                v-if="ccSend"
                                :items="ccOptions"
                                ref="cc"
                        ></v-select>
                        <!--bcc-->
                        <v-select
                                required
                                label="Bcc Group"
                                v-model="selectbccGroup"
                                :items="bccGroup"
                                item-text="group"
                                item-value="group"
                                ref="bcc"
                        >
                        </v-select>
                        <v-select
                                required
                                label="Bcc"
                                v-if="selectbccGroup"
                                :items="bccs"
                                item-text="name"
                                return-object
                                v-model="bccSend"
                        >
                        </v-select>
                        <v-select
                                label="Bcc Mail"
                                v-if="bccSend"
                                :items="bccOptions"
                                ref="bcc"
                        ></v-select>
                        <v-autocomplete
                                v-model="categoModel"
                                :items="categos"
                                :loading="isLoading"
                                :search-input.sync="search"
                                color="primary"
                                hide-no-data
                                hide-selected
                                item-text="Catego"
                                item-value="Catego"
                                label="Categorias"
                                placeholder="Escribe para seleccionar categoria"
                                return-object
                        ></v-autocomplete>
                        <v-select
                                :items="templates.Temps"
                                item-text="title"
                                item-value="title"
                                label="Templates"
                                v-if="templates.Temps"
                                v-model="actualTemplate"
                                ref="template"
                                return-object
                        ></v-select>
                        <v-textarea
                                solo
                                ref="body"
                                v-model="templateBody"
                        >
                        </v-textarea>
                    </v-card-text>
                    <v-spacer></v-spacer>
                    <v-card-actions>
                        <v-btn color="red" text @click="dialog = false">Draft</v-btn>
                        <v-btn color="primary" text @click="send" :disabled="!isvalid">Send</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
        <v-snackbar
                v-model="mailResponse"
                bottom
                :color="mailResponseColor"
        >
            {{mailResponseText}}
        </v-snackbar>
    </v-row>
</template>

<script>
    export default {
        name: "compose-button",
        props: ['contacts'],
        data() {
            return {
                fab: false,
                descriptionLimit: 60,
                entries: [],
                isLoading: false,
                categoModel: null,
                search: null,
                company: null,
                toSend: null,
                ccSend: null,
                bccSend: null,
                selectContactsGroup: null,
                selectccGroup: null,
                selectbccGroup: null,
                actualCategory: null,
                actualTemplate: "",
                mailResponse: false,
                mailResponseText: null,
                mailResponseColor: null,
                loading: false,
                dialog: false,
                subject: null,
                to: null,
                body: null,
                isvalid: true,
                from: window.clientKey,
                pass: window.secretKey,
                subjectRules: [
                    v => !!v || 'Subject is required',
                ],
                toRules: [
                    v => !!v || 'Destination is required'
                ],
                contactsGroup: [
                    {group: 'contacts'},
                    {group: 'customers'},
                    {group: 'providers'},
                    {group: 'users'}
                ],
                ccGroup: [
                    {group: 'contacts'},
                    {group: 'customers'},
                    {group: 'providers'},
                    {group: 'users'}
                ],
                bccGroup: [
                    {group: 'contacts'},
                    {group: 'customers'},
                    {group: 'providers'},
                    {group: 'users'}
                ],
            }
        },

        mounted() {
            this.GetCompany();
        },
        methods: {
            answerMail(){
              this.dialog = true;
            },
            send() {
                this.loading = true;
                var subject = this.$refs.subject.lazyValue;
                var to = this.$refs.to.lazyValue;
                var body = this.$refs.body.lazyValue;
                var from = this.from;
                var pass = this.pass;
                var toPost = window.hostKey + 'mail';
                var cc = this.$refs.cc.lazyValue;
                var bcc = this.$refs.bcc.lazyValue;

                let data = {subject: subject, to: to, body: body, from: from, pass: pass, bcc: bcc, cc: cc}
                axios
                    .post(toPost, data)
                    .then(response => {
                        this.afterSend()
                    })

            },
            afterSend() {
                this.loading = false;
                this.dialog = false;
                this.mailResponseText = "Correo Enviado!";
                this.mailResponseColor = 'success';
                this.mailResponse = true;
                this.$refs.comp.reset();
                this.actualTemplate = '';
            },
            goToTemplates() {
                window.location.href = '/emails/templates';
            },
            GetCompany() {
                var apiCompany = window.tcApiHostKey + 'companies/fromUser/' + window.userIdKey;
                console.log(apiCompany);
                axios
                    .get(apiCompany)
                    .then(response => {
                        this.company = response.data.data;
                    })
            },
            GetTemplate(template) {
                console.log(template);
            }
        },
        computed: {
            templates() {
                if (!this.categoModel) return []
                {
                    return this.categoModel;
                }
            },
            categos() {
                return this.entries.map(entry => {
                    const Catego = entry.title.length > this.descriptionLimit
                        ? entry.title.slice(0, this.descriptionLimit) + '...'
                        : entry.title
                    const Temps = entry.emails.data

                    return Object.assign({}, {Catego}, {Temps})
                })
            },
            recivers() {
                if (this.selectContactsGroup == "contacts") {
                    return this.contacts.contacts
                }
                if (this.selectContactsGroup == "customers") {
                    return this.contacts.customers
                }
                if (this.selectContactsGroup == "providers") {
                    return this.contacts.providers
                }
                if (this.selectContactsGroup == "users") {
                    return this.contacts.users
                }
            },
            ccs() {
                if (this.selectccGroup == "contacts") {
                    return this.contacts.contacts
                }
                if (this.selectccGroup == "customers") {
                    return this.contacts.customers
                }
                if (this.selectccGroup == "providers") {
                    return this.contacts.providers
                }
                if (this.selectccGroup == "users") {
                    return this.contacts.users
                }
            },
            bccs() {
                if (this.selectbccGroup == "contacts") {
                    return this.contacts.contacts
                }
                if (this.selectbccGroup == "customers") {
                    return this.contacts.customers
                }
                if (this.selectbccGroup == "providers") {
                    return this.contacts.providers
                }
                if (this.selectbccGroup == "users") {
                    return this.contacts.users
                }
            },
            templateBody() {
                return this.actualTemplate.body
            },
            templateSubject() {
                return this.actualTemplate.subject
            },
            contactOptions() {
                if (this.toSend.IredMailMail) {
                    const options = [this.toSend.IredMailMail.mail, this.toSend.email]
                    return options
                } else {
                    return this.toSend.email
                }
            },
            ccOptions() {
                if (this.ccSend.IredMailMail) {
                    const options = [this.ccSend.IredMailMail.mail, this.ccSend.email]
                    return options
                } else {
                    return this.ccSend.email
                }
            },
            bccOptions() {
                if (this.bccSend.IredMailMail) {
                    const options = [this.bccSend.IredMailMail.mail, this.bccSend.email]
                    return options
                } else {
                    return this.bccSend.email
                }
            },
        },
        watch: {
            search(val) {
                // categos have already been loaded
                if (this.categos.length > 0) return

                // categos have already been requested
                if (this.isLoading) return

                this.isLoading = true

                var comp_id = this.company.id;
                var usr_id = window.userIdKey;
                var get = window.tcApiHostKey + 'email_categories?company_id=' + comp_id + '&include=emails';


                // Lazily load input categos
                fetch(get)
                    .then(res => res.json())
                    .then(res => {
                        const {data} = res
                        this.entries = data
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
