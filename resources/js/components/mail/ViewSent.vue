<template>
    <div>
        <p-table :busy="$isLoading('get-mail')" :items="sentMessages" :columns="sentColumns" :viewable="true" @view="viewMessage">

        </p-table>

        <p-modal id="view-message" @hide="viewingMessage = null" :title="'Viewing Message #' + (viewingMessage ? viewingMessage.id : 'N/A')">
            <view-message :message="viewingMessage" v-if="viewingMessage !== null">

            </view-message>
        </p-modal>
    </div>
</template>

<script>
import ViewMessage from './ViewMessage';

export default {
    name: "ViewSent",
    components: {
        ViewMessage
    },
    data() {
        return {
            sentColumns: [
                {key: 'id', label: 'ID'},
                {key: 'string_to', label: 'To'},
                {key: 'subject', label: 'Subject'},
                {key: 'status', label: 'Status'},
            ],
            viewingMessage: null,
            sent: []
        }
    },
    created() {
        return this.loadMessages();
    },
    methods: {
        loadMessages() {
            this.$httpBasic.get('/mail/sent', {name: 'get-mail'})
                .then(response => this.sent = response.data)
                .catch(error => this.$notify.alert('Could not load mailbox: ' + error.message));
        },
        viewMessage(message) {
            this.viewingMessage = message;
            this.$ui.modal.show('view-message');
        }
    },
    computed: {
        sentMessages() {
            return this.sent.map(sent => {
                sent.string_to = sent.to.join(', ')
                sent.status = (sent.is_error ? 'Failed' : (sent.is_sent ? 'Sent' : 'Pending'));
                return sent;
            })
        }
    }
}
</script>

<style scoped>

</style>
