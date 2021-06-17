<template>
    <v-row align="center">
        <v-col
        cols="12"
        sm="4"
        class="overflow-y-auto"
        >
            <v-hover v-slot:default="{ hover }">
                <v-card
                    align="center"
                    color="primary"
                >
                    <v-list>
                        <v-list-item-content>
                            <v-list-item-title>
                                TaskControl Mail
                            </v-list-item-title>

                        </v-list-item-content>
                    </v-list>
                    <v-expand-transition>
                        <div
                            v-if="hover"
                            class="d-flex transition-fast-in-fast-out v-card--reveal display-3 white--text"
                            style="height: 100%;"
                        >
                            <v-card-actions>
                                <v-btn v-on:click="mailPage"><v-icon>mdi-email-sync</v-icon></v-btn>
                                <v-btn v-on:click="options"><v-icon>mdi-pencil</v-icon></v-btn>
                            </v-card-actions>
                        </div>
                    </v-expand-transition>
                </v-card>
            </v-hover>
            <v-card
            :loading="loading"
            >
                <v-list>
                    <v-list-item
                        three-line
                        v-for="mail in mails "
                        v-on:click="getMail(mail)"
                        :key="mail.header_info.date"
                    >
                        <v-list-item-content>
                            <v-list-item-title>
                                <v-icon v-if="mail.flags.seen">mdi-email-open</v-icon>
                                <v-icon v-else>mdi-email</v-icon>
                                {{mail.header_info.subject.replace(/ *\<[^)]*\> */g, " ").trim()}}
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                {{mail.header_info.fromaddress}}
                            </v-list-item-subtitle>
                            <v-list-item-subtitle>
                                {{mail.header_info.date}}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                        <v-icon
                            v-on:click="removeMail(mail.header_info)"
                            v-if="opts"
                        >mdi-delete</v-icon>
                    </v-list-item>
                </v-list>
            </v-card>
            <v-card
                align="center"
                color="primary"
            >
                <v-btn text small color="accent" v-on:click="prevPage()">Prev</v-btn>
                <span>{{page}}</span>
                <v-btn text small color="accent" v-on:click="nextPage()">Next</v-btn>
            </v-card>
        </v-col>
        <v-col>
            <v-card
            class="mx-auto"
            outlined
            v-if="mailActualBody"
            >
            <v-list-item three-line>
                <v-list-item-content>
                    <div class="overline mb-4">
                        READER
                    </div>
                    <v-list-item-title class="headline mb-1">{{mailActualSubject.replace(/ *\<[^)]*\> */g, " ").trim()}}</v-list-item-title>
                    <v-list-item-subtitle>{{mailActualFrom}}</v-list-item-subtitle>
                    <v-list-item-subtitle>{{mailActualTo}}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
                <v-list-item>
                    <span v-html="mailActualBody.content"></span>
                </v-list-item>
                <v-card-actions>
                    <v-btn v-on:click="answerMail">Reply</v-btn>
                    <v-btn v-if="answersDialog" v-on:click="getAnswers" color="secondary">Hide reply</v-btn>
                    <v-btn v-else v-on:click="getAnswers" color="primary">Show reply</v-btn>
                </v-card-actions>
            </v-card>
            <v-card
                    class="mx-auto"
                    outlined
                    v-for="mail in mailActualAnswers"
                    v-if="answersDialog"
            >
                <v-list-item three-line>
                    <v-list-item-content>
                        <div class="overline mb-4">
                            READER
                        </div>
                        <v-list-item-title class="headline mb-1">{{mail.header_info.subject.replace(/ *\<[^)]*\> */g, " ").trim()}}</v-list-item-title>
                        <v-list-item-subtitle>{{mail.header_info.fromaddress}}</v-list-item-subtitle>
                        <v-list-item-subtitle>{{mail.header_info.date}}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item>
                    <span v-html="mail.bodies.html.content"></span>
                </v-list-item>
            </v-card>
        </v-col>
        <v-dialog
                v-model="dialog"
                max-width="640"
                hide-overlay
                transition="dialog-bottom-transition"
        >
            <v-card>
                <v-form ref="comp">
                    <v-card-text>
                        <v-text-field
                                required
                                disabled
                                label="Reply To"
                                ref="toba"
                                v-if="mailActualSubject"
                                v-model="mailActualSubject"

                        >
                        </v-text-field>
                        <v-text-field
                                required
                                label="Subject"
                                hint="example: Sales report"
                                ref="subject"
                                v-if="mailActualSubject"
                                :value="'RE:'+mailActualSubject"
                        >
                        </v-text-field>
                        <v-text-field
                                required
                                label="To"
                                ref="to"
                                v-if="mailActualFrom"
                                v-model="mailActualFrom"
                                disabled
                        ></v-text-field>
                        <v-textarea
                                solo
                                ref="body"
                        >
                        </v-textarea>
                    </v-card-text>
                    <v-spacer></v-spacer>
                    <v-card-actions>
                        <v-btn color="primary" text v-on:click="answer">Reply</v-btn>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
    </v-row>
</template>

<script>

    export default {
        name: "mails",
        data() {
            return {
                dialog: false,
                answersDialog: false,
                loading: false,
                page: 1,
                mails: null,
                mailActualSubject: 'Subject',
                mailActualFrom: 'From',
                mailActualTo: 'To',
                mailActualBody: null,
                mailActualRes: null,
                mailActualAnswers: null,
                folderResponse: null,
                activeBtn: 1,
                mailCounter: 0,
                opts: false,
                boxRoute: '/INBOX',
            }
        },
        mounted() {
            this.loading = false;
            this.mailPage();
        },
        methods: {
            answerMail: function () {
                this.dialog = true;
            },
            getAnswers: function () {
                if(this.answersDialog)
                {
                    this.answersDialog = false
                }
                else
                {
                    this.loading = true;
                    var owner = this.mailActualSubject;
                    var user = window.clientKey;
                    var pass = window.secretKey;
                    var toGet = window.hostKey + 'mail/answers?username='+window.clientKey+'&secret='+window.secretKey+'&owner='+owner;

                    let data = {username: user,secret: pass,owner: owner}
                    axios
                        .get(toGet)
                        .then(response => {
                            this.loading = false;
                            this.mailActualAnswers = response.data
                            this.answersDialog = true
                        })
                }
            },
            answer: function () {
                this.loading = true;
                var owner = this.mailActualSubject;
                var subject = this.$refs.subject.lazyValue;
                var to = this.$refs.to.lazyValue;
                var body = this.$refs.body.lazyValue;
                var from = window.clientKey;
                var toPost = window.hostKey + 'mailanswer';

                let data = {subject: subject, to: to, body: body, from: from,owner: owner}
                axios
                    .post(toPost, data)
                    .then(response => {
                        this.loading = false;
                        this.dialog = false;
                        this.$refs.comp.reset();
                        this.mailActualSubject = owner;
                    })

            },
            getMail: function (mail) {
                if(mail.bodies.html){this.mailActualBody = mail.bodies.html;}else{this.mailActualBody = mail.bodies.text;}
                this.mailActualSubject = mail.header_info.subject;
                this.mailActualFrom = mail.header_info.fromaddress;
                this.mailActualTo = mail.header_info.toaddress;
                this.mailPage();
            },
            removeMail: function (mail) {
                this.loading = true;
                if(window.imapHostKey)
                {var get = window.hostKey + 'trash' + this.$route.path + '/' + mail.Msgno + '?username=' + window.clientKey + '&' + 'secret=' + window.secretKey + '&' + 'host=' + window.imapHostKey;}
                else
                {var get = window.hostKey + 'trash?username=' + window.clientKey + '&secret=' + window.secretKey + '&owner='+mail.subject;}
                console.log(get);
                axios
                    .get(get)
                    .then(response => {
                        this.loading = false;
                        this.mailPage();
                    })
            },
            mailPage: function(){
                this.loading = true;
                if(window.imapHostKey)
                {var get = window.hostKey + 'folders' + this.$route.path + '?username=' + window.clientKey + '&' + 'secret=' + window.secretKey + '&' + 'page=' + this.page + '&' + 'host=' + window.imapHostKey;}
                else
                {var get = window.hostKey + 'folders' + this.$route.path + '?username=' + window.clientKey + '&' + 'secret=' + window.secretKey + '&' + 'page=' + this.page;}
                axios
                    .get(get)
                    .then(response => {
                        this.loading = false;
                        this.mails = response.data;
                    })
            },
            prevPage: function () {
                if(this.page >= 2){
                    this.page -= 1;
                    this.mailPage();
                }
            },
            nextPage: function () {
                if(this.page >= 1){
                    this.page += 1;
                    this.mailPage();
                }
            },
            options: function () {
                if(this.opts == false){this.opts = true}
                else {this.opts = false}
            },
        },
    }
</script>

<style scoped>

</style>

