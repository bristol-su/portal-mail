<template>
    <div>

        <p-list-preview :list-items="sentMessageItems" :active-item="this.viewingMessage ? this.viewingMessage.id : null" @change="viewMessage">
            <template #topbar>
                <a href="#" @click="loadMessages()" @keydown.space.prevent="loadMessages()" @keydown.enter.prevent="loadMessages()" class="text-primary hover:text-primary-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                         content="Check for new messages"
                         v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span class="sr-only">Check for new messages</span>
                </a>
            </template>

            <view-message :message="viewingMessage" v-if="viewingMessage !== null" @viewRetry="viewRetry">

            </view-message>

            <template #footer>
            Footer
            </template>
        </p-list-preview>

    </div>
</template>

<script>
import ViewMessage from './ViewMessage';
import moment from 'moment';

export default {
    name: "ViewSent",
    components: {
        ViewMessage
    },
    props: {
        status: {
            required: false,
            type: String,
            default: null
        }
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
            sent: [],
            viewingRetry: null
        }
    },
    created() {
        return this.loadMessages();
    },
    methods: {
        viewRetry(retry) {
            this.viewingRetry = retry;
        },
        loadMessages() {
            this.$httpBasic.get('/mail/sent', {name: 'get-mail'})
                .then(response => this.sent = response.data)
                .catch(error => this.$notify.alert('Could not load mailbox: ' + error.message));
        },
        viewMessage(message) {
            let viewingMessage = this.sent.filter(sent => sent.id === message.id);
            if(viewingMessage.length === 1) {
                this.viewingMessage = viewingMessage[0];
            }
        }
    },
    computed: {
        sentMessageItems() {
            return this.sent
                .filter(sent => this.status === null || sent.status === this.status)
                .map(sent => {
                    return {
                        id: sent.id,
                        title: sent.to.join(', '),
                        subtitle: sent.from?.email,
                        body: sent.subject,
                        note: 'From: ' + (sent.sent_at === null ? moment(sent.updated_at).fromNow() : moment(sent.sent_at).fromNow()),
                    }
                })
        }
    }
}
</script>

<style scoped>

</style>
