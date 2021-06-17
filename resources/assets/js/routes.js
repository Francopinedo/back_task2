import Vue from 'vue';
import VueRouter from 'vue-router';

import Mails from '@/js/components/mails';

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/INBOX',
            name: 'INBOX',
            component: Mails
        },
        {
            path: '/sent',
            name: 'Sent',
            component: Mails
        },
        {
            path: '/trash',
            name: 'Trash',
            component: Mails
        },
        {
            path: '/junk',
            name: 'Junk',
            component: Mails
        },
        {
            path: '/drafts',
            component: Mails,
            name: 'Drafts',

        },


    ]
});

export default router;
