<template>
    <v-dialog
            v-model="dialog"
            max-width="640"
            transition="dialog-bottom-transition"
            scrollable
    >
        <template v-slot:activator="{on}">
            <v-btn
                    bottom
                    right
                    fixed
                    color="primary"
                    v-on="on"
            >
                ChatRooms
                <v-icon>
                    mdi-forum
                </v-icon>
            </v-btn>
        </template>
        <v-card
                :loading="loading"
        >
            <v-card-title>
                ChatRooms
            </v-card-title>
            <v-expansion-panels
                    focusable
            >
                <v-expansion-panel v-if="generalChatRooms">
                    <v-expansion-panel-header>General</v-expansion-panel-header>
                    <v-expansion-panel-content v-for="generalChatRoom in generalChatRooms">
                        <v-btn color="primary" block text v-on:click="getChatRoom(generalChatRoom)">Chat with
                            {{generalChatRoom.name}}
                        </v-btn>
                    </v-expansion-panel-content>
                </v-expansion-panel>
                <v-expansion-panel v-if="workgroupChatRooms">
                    <v-expansion-panel-header>WorkGroup</v-expansion-panel-header>
                    <v-expansion-panel-content v-for="workgroupChatRoom in workgroupChatRooms">
                        <v-btn color="primary" block text v-on:click="getChatRoom(workgroupChatRoom)">Chat with
                            {{workgroupChatRoom.name}}
                        </v-btn>
                    </v-expansion-panel-content>
                </v-expansion-panel>
                <v-expansion-panel v-if="projectsChatRooms">
                    <v-expansion-panel-header>Projects</v-expansion-panel-header>
                    <v-expansion-panel-content v-for="projectChatRoom in projectsChatRooms">
                        <v-btn color="primary" block text v-on:click="getChatRoom(projectChatRoom)">Chat with
                            {{projectChatRoom.name}}
                        </v-btn>
                    </v-expansion-panel-content>
                </v-expansion-panel>
                <v-expansion-panel v-if="usersChatRooms">
                    <v-expansion-panel-header>Users</v-expansion-panel-header>
                    <v-expansion-panel-content v-for="userChatRoom in usersChatRooms">
                        <v-btn color="primary" block text v-on:click="getuserChatRoom(userChatRoom.RocketChatUser)">Chat
                            with {{userChatRoom.name}}
                        </v-btn>
                    </v-expansion-panel-content>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-card>
        <v-dialog
                v-model="room"
                max-width="640"
                hide-overlay
                transition="dialog-bottom-transition"
        >
            <v-card
                    v-show="room"
            >
                <v-card-title>
                    Chat: {{this.roomName}}
                </v-card-title>
                <iframe v-on:load="authFrame" id="rcChannel" name="rcChannel" style="width: 640px;height: 640px"
                        :src="roomPath"></iframe>
                <v-card-actions>
                    Powered by taskcontrol.
                </v-card-actions>
            </v-card>

        </v-dialog>
    </v-dialog>
</template>

<script>
    export default {
        name: "chat-bar",
        props: ['apipath', 'userid', 'rcapipath'],
        data() {
            return {
                dialog: false,
                roomInput: null,
                generalChatRooms: null,
                workgroupChatRooms: null,
                projectsChatRooms: null,
                usersChatRooms: null,
                workgroupid: null,
                companyid: null,
                memberof: null,
                projects: null,
                roomPath: null,
                roomName: null,
                room: null,
                user: null,
                rcuser: null,
                company: null,
                authtoken: null,
                loading: false,
            }
        },
        mounted() {
            this.getGeneralChatRooms();
        },
        methods: {
            getAuthToken: function () {
                this.loading = true;
                var post = this.rcapipath + 'rcauth';
                let data = {username: this.rcuser.rcuser, password: this.rcuser.rcpass};
                console.log(post)
                axios
                    .post(post, data)
                    .then(response => {
                        this.authtoken = response.data;
                        this.loading = false;
                    })
            },
            getGeneralChatRooms: function () {
                this.loading = true;
                var get = this.apipath + 'users/' + this.userid;
                console.log(get)
                axios
                    .get(get)
                    .then(response => {
                        this.loading = false;
                        this.generalChatRooms = response.data.data.ChatRooms;
                        this.user = response.data.data;
                        this.rcuser = response.data.data.RocketChatUser;
                        this.companyid = this.rcuser.company_id;
                        this.workgroupid = response.data.data.workgroup_id;
                        this.getWorkgroupChatRooms();
                    })
            },
            getWorkgroupChatRooms: function () {
                if (this.workgroupid)
                {
                    this.loading = true;
                    var get = this.apipath + 'workgroups/' + this.workgroupid;
                    console.log(get)
                    axios
                        .get(get)
                        .then(response => {
                            this.loading = false;
                            this.workgroupChatRooms = response.data.data.chatchannel;
                            this.getAuthToken();
                            this.getMemberOf();
                        })
                }
                else
                {
                    console.log('no workgroups')
                    this.getAuthToken();
                }
            },
            getMemberOf: function () {
                this.loading = true;
                var get = this.apipath + 'team_users/get_user/' + this.user.id;
                console.log(get)
                axios
                    .get(get)
                    .then(response => {
                        this.loading = false;
                        this.memberof = response.data.data;
                        this.getProjectsChatRooms();
                    })
            },
            getProjectsChatRooms: function () {
                this.loading = true;
                var i;
                for (i = 0; i < this.project_ids; i++) {
                    var get = this.apipath + 'projects/' + this.project_ids[i];
                    console.log(get)
                    axios
                        .get(get)
                        .then(response => {
                            this.loading = false;
                            this.projects = response.data.data;
                            this.projectsChatRooms = response.data.data.chatchannel;
                        })
                }
                this.getUsersChatRooms();
            },
            getUsersChatRooms: function () {
                this.loading = true;
                var get = this.apipath + 'users/?company_id=' + this.companyid;
                console.log(get)
                axios
                    .get(get)
                    .then(response => {
                        this.loading = false;
                        this.usersChatRooms = response.data.data;
                        this.getAuthToken();
                    })
            },
            authFrame: function () {
                setTimeout(() => {
                    document.getElementById('rcChannel').contentWindow.postMessage({
                        event: 'login-with-token',
                        loginToken: this.authtoken
                    }, '*');
                    console.log('1 try');
                }, 2000);
                setTimeout(() => {
                    document.getElementById('rcChannel').contentWindow.postMessage({
                        event: 'login-with-token',
                        loginToken: this.authtoken
                    }, '*');
                    console.log('2 try');
                }, 4000);
                setTimeout(() => {
                    document.getElementById('rcChannel').contentWindow.postMessage({
                        event: 'login-with-token',
                        loginToken: this.authtoken
                    }, '*');
                    console.log('3 try');
                }, 6000);
            },
            getChatRoom: function (chatRoom) {
                this.room = true;
                this.roomPath = chatRoom.path;
                this.roomName = chatRoom.name;
                this.authFrame();
            },
            getuserChatRoom: function (chatRoom) {
                this.room = true;
                this.roomPath = chatRoom.rcpath;
                this.roomName = chatRoom.rcuser;
                this.authFrame();
            },
        },
        computed: {
            project_ids() {
                if (this.memberof) {
                    var ids = [];
                    var i;
                    for (i = 0; i < this.memberof.length; i++) {
                        ids[i] = this.memberof[i].project_id
                    }
                    return ids;
                } else {
                    return null;
                }

            },
        }
    }
</script>

<style scoped>

</style>
