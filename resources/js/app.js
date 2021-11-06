import Vue from 'vue';
import Toolkit from '@bristol-su/frontend-toolkit';
import ViewAddresses from './components/address/ViewAddresses';

Vue.use(Toolkit);

let vue = new Vue({
    el: '#portal-mail-root',
    components: {
        ViewAddresses
    }
});

