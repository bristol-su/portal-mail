<template>

        <p-tabs ref="tabs">
            <p-tab title="Sent Mail" :keep-alive="true">
                <view-sent status="Sent">

                </view-sent>
            </p-tab>
            <p-tab title="Failed Messages" :keep-alive="true">
                <view-sent status="Failed">

                </view-sent>
            </p-tab>
            <p-tab title="Outbox" :keep-alive="true">
                <view-sent status="Pending">

                </view-sent>
            </p-tab>
            <p-tab title="New Message" :keep-alive="true">
                <send-email @sent="sent">

                </send-email>
            </p-tab>
        </p-tabs>

</template>

<script>
import ViewSent from './mail/ViewSent';
import SendEmail from './send/SendEmail';

export default {
    name: "Mail",
    components: {
        ViewSent, SendEmail
    },
    mounted() {
        if(Object.fromEntries(new URLSearchParams(window.location.search).entries()).resend_id) {
            this.$nextTick(() => this.$refs.tabs.selectTab(3));
        }
    },
    methods: {
        sent() {

        }
    }
}
</script>

<style scoped>

</style>
