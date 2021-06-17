<template>
    <v-row>
        <v-col
                sm="12"
                lg="3"
                class="mb-4 controls"
        >
            <v-btn
                    fab
                    small
                    absolute
                    left
                    color="primary"
                    @click="$refs.calendar.prev()"
            >
                <v-icon dark>mdi-chevron-left</v-icon>
            </v-btn>
            <v-btn
                    fab
                    small
                    absolute
                    right
                    color="primary"
                    @click="$refs.calendar.next()"
            >
                <v-icon dark>mdi-chevron-right</v-icon>
            </v-btn>
            <br><br><br>
            <v-select
                    v-model="type"
                    :items="typeOptions"
                    label="Mode"
                    hide-details
                    outlined
                    dense
            ></v-select>
            <v-menu
                    ref="startMenu"
                    v-model="startMenu"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    :return-value.sync="start"
                    transition="scale-transition"
                    min-width="290px"
                    offset-y
            >
                <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                            v-model="start"
                            class="mt-3"
                            label="Date"
                            dense
                            readonly
                            outlined
                            hide-details
                            v-bind="attrs"
                            v-on="on"
                    ></v-text-field>
                </template>
                <v-date-picker
                        v-model="start"
                        no-title
                        scrollable
                >
                    <v-spacer></v-spacer>
                    <v-btn
                            text
                            color="primary"
                            @click="startMenu = false"
                    >
                        Cancel
                    </v-btn>
                    <v-btn
                            text
                            color="primary"
                            @click="$refs.startMenu.save(start)"
                    >
                        OK
                    </v-btn>
                </v-date-picker>
            </v-menu>

            <v-select
                    v-model="mode"
                    :items="modeOptions"
                    dense
                    outlined
                    hide-details
                    class="mt-3"
                    label="Event Overlap Mode"
            ></v-select>
            <v-select
                    v-model="weekdays"
                    :items="weekdaysOptions"
                    dense
                    outlined
                    hide-details
                    class="mt-3"
                    label="Show"
            ></v-select>
        </v-col>
        <v-col
                sm="12"
                lg="9"
                class="pl-4"
        >
            <v-sheet height="600">
                <v-calendar
                        ref="calendar"
                        v-model="start"
                        :type="type"
                        :start="start"
                        :end="end"
                        :min-weeks="minWeeks"
                        :max-days="maxDays"
                        :now="now"
                        :weekdays="weekdays"
                        :first-interval="intervals.first"
                        :interval-minutes="intervals.minutes"
                        :interval-count="intervals.count"
                        :interval-height="intervals.height"
                        :interval-style="intervalStyle"
                        :show-interval-label="showIntervalLabel"
                        :short-intervals="shortIntervals"
                        :short-months="shortMonths"
                        :short-weekdays="shortWeekdays"
                        :color="color"
                        :events="events"
                        :event-overlap-mode="mode"
                        :event-overlap-threshold="45"
                        :event-color="getEventColor"
                        @click:event="showEvent"
                        @change="getEvents"
                ></v-calendar>
            </v-sheet>
        </v-col>
        <v-dialog
                v-model="dialog"
                max-width="640px"
        >
            <v-card>
                <v-list-item three-line>
                    <v-list-item-content>
                        <div class="overline mb-4">TaskControl Event</div>
                        <v-list-item-title class="headline mb-1">{{ this.actualevtitle }}</v-list-item-title>
                        <v-list-item-subtitle>Start:{{ this.actualevstart }}</v-list-item-subtitle>
                        <v-list-item-subtitle>Due:{{ this.actualevdue }}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>

                <v-card-actions>
<!--                    <v-btn-->
<!--                            text-->
<!--                            color="primary"-->
<!--                            v-on:click="getIcs()"-->
<!--                    >Download .Ics-->
<!--                    </v-btn>-->
                    <v-btn
                            text
                            color="primary"
                            v-on:click="openShareIcs()"
                    >Share
                    </v-btn>
                    <v-btn
                            text
                            color="error"
                            v-on:click="removeIcs()"
                    >Delete
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog
                max-width="640px"
                v-model="share">

            <v-card>
                <v-form>
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
                            v-model="actualTo"
                    ></v-select>
                </v-form>
                <v-card-actions>
                    <v-btn
                            text
                            color="primary"
                            v-on:click="shareIcs()"
                    >Share
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>


<script>
    const weekdaysDefault = [0, 1, 2, 3, 4, 5, 6]

    const intervalsDefault = {
        first: 0,
        minutes: 60,
        count: 24,
        height: 48,
    }

    const stylings = {
        default(interval) {
            return undefined
        },
        workday(interval) {
            const inactive = interval.weekday === 0 ||
                interval.weekday === 6 ||
                interval.hour < 9 ||
                interval.hour >= 17
            const startOfHour = interval.minute === 0
            const dark = this.dark
            const mid = dark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)'

            return {
                backgroundColor: inactive ? (dark ? 'rgba(0,0,0,0.4)' : 'rgba(0,0,0,0.05)') : undefined,
                borderTop: startOfHour ? undefined : '1px dashed ' + mid,
            }
        },
        past(interval) {
            return {
                backgroundColor: interval.past ? (this.dark ? 'rgba(0,0,0,0.4)' : 'rgba(0,0,0,0.05)') : undefined,
            }
        },
    }

    export default {
        name: "agenda-calendar",
        props: ['contacts'],
        data: () => ({
            toSend: null,
            selectContactsGroup: null,
            share: false,
            actualTo: '',
            actualevpath: '',
            actualevtitle: '',
            actualevstart: '',
            actualevdue: '',
            actualevuid: '',
            dialog: false,
            startMenu: false,
            start: '2020-01-12',
            endMenu: false,
            end: '2020-01-27',
            nowMenu: false,
            minWeeks: 1,
            now: null,
            events: [],
            type: 'month',
            typeOptions: [
                {text: 'Day', value: 'day'},
                {text: '4 Day', value: '4day'},
                {text: 'Week', value: 'week'},
                {text: 'Month', value: 'month'},
            ],
            mode: 'stack',
            modeOptions: [
                {text: 'Stack', value: 'stack'},
                {text: 'Column', value: 'column'},
            ],
            weekdays: weekdaysDefault,
            weekdaysOptions: [
                {text: 'Sunday - Saturday', value: weekdaysDefault},
                {text: 'Mon, Wed, Fri', value: [1, 3, 5]},
                {text: 'Mon - Fri', value: [1, 2, 3, 4, 5]},
                {text: 'Mon - Sun', value: [1, 2, 3, 4, 5, 6, 0]},
            ],
            intervals: intervalsDefault,
            intervalsOptions: [
                {text: 'Default', value: intervalsDefault},
                {text: 'Workday', value: {first: 16, minutes: 30, count: 20, height: 48}},
            ],
            maxDays: 7,
            maxDaysOptions: [
                {text: '7 days', value: 7},
                {text: '5 days', value: 5},
                {text: '4 days', value: 4},
                {text: '3 days', value: 3},
            ],
            styleInterval: 'default',
            styleIntervalOptions: [
                {text: 'Default', value: 'default'},
                {text: 'Workday', value: 'workday'},
                {text: 'Past', value: 'past'},
            ],
            color: 'primary',
            colorOptions: [
                {text: 'Primary', value: 'primary'},
                {text: 'Secondary', value: 'secondary'},
                {text: 'Accent', value: 'accent'},
                {text: 'Red', value: 'red'},
                {text: 'Pink', value: 'pink'},
                {text: 'Purple', value: 'purple'},
                {text: 'Deep Purple', value: 'deep-purple'},
                {text: 'Indigo', value: 'indigo'},
                {text: 'Blue', value: 'blue'},
                {text: 'Light Blue', value: 'light-blue'},
                {text: 'Cyan', value: 'cyan'},
                {text: 'Teal', value: 'teal'},
                {text: 'Green', value: 'green'},
                {text: 'Light Green', value: 'light-green'},
                {text: 'Lime', value: 'lime'},
                {text: 'Yellow', value: 'yellow'},
                {text: 'Amber', value: 'amber'},
                {text: 'Orange', value: 'orange'},
                {text: 'Deep Orange', value: 'deep-orange'},
                {text: 'Brown', value: 'brown'},
                {text: 'Blue Gray', value: 'blue-gray'},
                {text: 'Gray', value: 'gray'},
                {text: 'Black', value: 'black'},
            ],
            contactsGroup: [
                {group: 'contacts'},
                {group: 'customers'},
                {group: 'providers'},
                {group: 'users'}
            ],
            shortIntervals: true,
            shortMonths: false,
            shortWeekdays: false,
        }),
        mounted() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            this.start = yyyy + '-' + mm + '-' + dd;
        },
        computed: {
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
            contactOptions() {
                if (this.toSend.IredMailMail) {
                    const options = [this.toSend.IredMailMail.mail, this.toSend.email]
                    return options
                } else {
                    return this.toSend.email
                }
            },
            intervalStyle() {
                return stylings[this.styleInterval].bind(this)
            },
            hasIntervals() {
                return this.type in {
                    week: 1, day: 1, '4day': 1, 'custom-daily': 1,
                }
            },
            hasEnd() {
                return this.type in {
                    'custom-weekly': 1, 'custom-daily': 1,
                }
            },
        },
        methods: {
            openShareIcs() {

                this.share = true
            },
            shareIcs() {

                var toPost = window.hostKey + 'mail/ics?uid=' + this.actualevuid + '&ics=' + this.actualevpath + '&subject=Taskcontrol event!' + '&from=' + window.clientKey + '&pass=' + window.secretKey + '&to=' + this.actualTo;

                axios
                    .post(toPost)
                    .then(response => {
                        this.share = false;
                        this.dialog = false;
                    })
            },
            getIcs() {

                var toGet = window.hostKey + 'agenda/event?uid=' + this.actualevuid;

                window.open(toGet)
            },
            removeIcs() {

                var toGet = window.hostKey + 'agenda/remove/event?uid=' + this.actualevuid;

                axios
                    .get(toGet)
                    .then(response => {
                        location.reload();
                    })
            },
            showEvent(event) {
                this.dialog = true;
                this.actualevtitle = event.event.title;
                this.actualevstart = event.event.start;
                this.actualevdue = event.event.due;
                this.actualevuid = event.event.uid;
                this.actualevpath = event.event.path;

            },
            viewDay({date}) {
                this.start = date
                this.type = 'day'
            },
            getEventColor(event) {
                if(event.priority == 1) {
                    return 'primary'
                }
                if(event.priority == 2) {
                    return 'warning'
                }
                if(event.priority == 3) {
                    return 'error'
                }
            },
            showIntervalLabel(interval) {
                return interval.minute === 0
            },
            getEvents() {
                var user = window.clientKey;
                var pass = window.secretKey;
                var toGet = window.hostKey + 'agenda/events?username=' + window.clientKey + '&secret=' + window.secretKey;

                axios
                    .get(toGet)
                    .then(response => {
                        this.events = response.data
                    })

            },
            rnd(a, b) {
                return Math.floor((b - a + 1) * Math.random()) + a
            },
            formatDate(a, withTime) {
                return withTime
                    ? `${a.getFullYear()}-${a.getMonth() + 1}-${a.getDate()} ${a.getHours()}:${a.getMinutes()}`
                    : `${a.getFullYear()}-${a.getMonth() + 1}-${a.getDate()}`
            },
        },
    }
</script>


<style scoped>

</style>