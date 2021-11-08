import Vue from 'vue';
import Toolkit from '@bristol-su/frontend-toolkit';
import ViewAddresses from './components/address/ViewAddresses';
import ViewUsers from './components/users/ViewUsers';
import SendEmail from './components/send/SendEmail';

Vue.use(Toolkit);

let vue = new Vue({
    el: '#portal-mail-root',
    components: {
        ViewAddresses,
        ViewUsers,
        SendEmail
    }
});

