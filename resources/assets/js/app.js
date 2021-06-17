/**
 *
 *Vue init!
 *
 */

/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */
require('./bootstrap');
import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import '@mdi/font/css/materialdesignicons.css';
import colors from 'vuetify/lib/util/colors';
import  Routes from './routes.js';

window.Vue = require('vue');
//components
import Navbar from "@/js/layouts/navbar";
import ComposeButton from "@/js/components/compose-button";
import Mails from "@/js/components/mails";
import SearchBar from "@/js/components/search-bar";
import ChatBar from "@/js/components/chat-bar";
import ChatBarAdmin from "@/js/components/chat-bar-admin";
import AgendaCalendar from "@/js/components/agenda-calendar";
import ThemeDefault from "@/js/themes/default";
import ThemeDark from "@/js/themes/dark";
import ThemePurple from "@/js/themes/purple";
import ThemeYellow from "@/js/themes/yellow";
import ThemeBrown from "@/js/themes/brown";
import ThemeRed from "@/js/themes/red";
import ThemeGray from "@/js/themes/gray";
Vue.component('navbar', require('./layouts/navbar.vue').default);
Vue.component('compose-button', require('./components/compose-button.vue').default);
Vue.component('mails', require('./components/mails.vue').default);
Vue.component('search-bar', require('./components/search-bar.vue').default);
Vue.component('chat-bar', require('./components/chat-bar.vue').default);
Vue.component('chat-bar-admin', require('./components/chat-bar-admin.vue').default);
Vue.component('agenda-calendar', require('./components/agenda-calendar.vue').default);
Vue.component('theme-default', require('./themes/default.vue').default);
Vue.component('theme-dark', require('./themes/dark.vue').default);
Vue.component('theme-purple', require('./themes/purple.vue').default);
Vue.component('theme-yellow', require('./themes/yellow.vue').default);
Vue.component('theme-brown', require('./themes/brown.vue').default);
Vue.component('theme-red', require('./themes/red.vue').default);
Vue.component('theme-gray', require('./themes/gray.vue').default);
Vue.use(Vuetify);

const vuetify = new Vuetify({
    theme: {
        themes: {
            light: {
                primary: colors.indigo,
                secondary: colors.grey.darken1,
                accent: colors.shades.black,
                error: colors.red.accent3,
            },
            dark: {
                primary: colors.blueGrey,
                accent: colors.shades.black,
            },
        },
        dark:false,
        light:true,
    },
});

const app = new Vue({
    el: '#app',
    vuetify,
    router: Routes,
});