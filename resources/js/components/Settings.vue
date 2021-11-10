<template>

        <p-tabs ref="tabs">
            <p-tab title="Email Addresses" :keep-alive="true">
                <view-addresses :emails="emails" @emailadded="$refs.domains.refreshDomains()">

                </view-addresses>
            </p-tab>
            <p-tab title="Domains" :keep-alive="true" ref="domains">
                <view-domains ref="domains">

                </view-domains>
            </p-tab>
            <p-tab title="User Access" :keep-alive="true">
                <view-users :users="users" :available-emails="emails">

                </view-users>
            </p-tab>
        </p-tabs>

</template>

<script>

import ViewAddresses from './address/ViewAddresses';
import ViewDomains from './address/ViewDomains';
import ViewUsers from './users/ViewUsers';
export default {
    name: "Mail",
    components: {
        ViewUsers,
        ViewDomains,
        ViewAddresses,
    },
    props: {
        emails: {
            type: Array,
            default: () => []
        },
        users: {
            type: Array,
            default: () => []
        }
    },
    mounted() {
        if(Object.fromEntries(new URLSearchParams(window.location.search).entries()).resend_id) {
            this.$nextTick(() => this.$refs.tabs.selectTab(3));
        }
    }
}
</script>

<style scoped>

</style>
