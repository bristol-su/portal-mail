<template>

    <div>
        <p-tabs ref="tabs">
            <p-tab title="Sent Mail" :badge="sentCount" :keep-alive="true" icon="fas fa-inbox">
                <view-sent status="sent" @updateCount="sentCount = $event" :enabled-addresses="enabledAddresses">

                </view-sent>
            </p-tab>
            <p-tab title="Failed Messages" :badge="failedCount" :keep-alive="true" icon="fa-solid fa-triangle-exclamation">
                <view-sent status="failed" @updateCount="failedCount = $event" :enabled-addresses="enabledAddresses">

                </view-sent>
            </p-tab>
            <p-tab title="Outbox" :badge="outboxCount" :keep-alive="true" icon="fas fa-rocket">
                <view-sent status="pending" @updateCount="outboxCount = $event" :enabled-addresses="enabledAddresses">

                </view-sent>
            </p-tab>
            <p-tab title="New Message" :keep-alive="true" icon="fa-solid fa-paper-plane">
                <send-email @sent="sent">

                </send-email>
            </p-tab>
        </p-tabs>
    </div>

</template>

<script>
import ViewSent from './mail/ViewSent';
import SendEmail from './send/SendEmail';

export default {
    name: "Mail",
    components: {
        ViewSent, SendEmail
    },
    props: {
        enabledAddresses: {
            required: false,
            default: () => [],
            type: Array
        }
    },
    mounted() {
        if(Object.fromEntries(new URLSearchParams(window.location.search).entries()).resend_id) {
            this.$nextTick(() => this.$refs.tabs.selectTab(3));
        }
    },
    data() {
        return {
            outboxCount: null,
            failedCount: null,
            sentCount: null
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
