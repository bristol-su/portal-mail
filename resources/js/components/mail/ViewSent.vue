<template>
    <div>

        <p-list-preview
            :list-items="sentMessageItems"
            :active-item="this.viewingMessage ? this.viewingMessage.id : null"
            @change="viewMessage"
            @nextPage="page = page + 1"
            :loading="$isLoading('get-mail-' + status)"
            :load-more="this.totalPages === null || this.loadedPages.length < this.totalPages">
            <template #topbar>
                <a href="#" @click="reloadMessages()" @keydown.space.prevent="reloadMessages()"
                   @keydown.enter.prevent="reloadMessages()" class="text-primary hover:text-primary-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor"
                         content="Check for new messages"
                         v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span class="sr-only">Check for new messages</span>
                </a>
            </template>

            <view-message :message="viewingMessage" v-if="viewingMessage !== null">

            </view-message>
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
            loadedPages: [],
            page: 1,
            totalPages: null
        }
    },
    created() {
        return this.loadMessages();
    },
    watch: {
        page(page) {
            if (page < 1) {
                this.page = 1;
            } else if (page > this.totalPages ?? 0) {
                this.page = this.totalPages ?? 0;
            } else {
                this.loadMessages();
            }
        }
    },
    methods: {
        loadMessages() {
            let url = '/mail/sent?page=' + this.page;
            if (this.status !== null) {
                url = url + '&status=' + this.status;
            }
            this.$httpBasic.get(url, {name: 'get-mail-' + this.status})
                .then(response => {
                    (response.data.data ?? []).forEach((mail) => {
                        if(this.sent.filter(s => s.id === mail.id).length === 0) {
                            this.sent.push(mail);
                        }
                    })
                    this.sent = this.sent.concat();
                    this.totalPages = response.data.last_page;
                    this.$emit('updateCount', response.data.total);
                    this.loadedPages.push(this.page);
                })
                .catch(error => this.$notify.alert('Could not load mailbox: ' + error.message));
        },
        reloadMessages() {
            this.sent = [];
            this.page = 1;
            this.loadMessages();
        },
        viewMessage(message) {
            let viewingMessage = this.sent.filter(sent => sent.id === message.id);
            if (viewingMessage.length === 1) {
                this.viewingMessage = viewingMessage[0];
            }
        }
    },
    computed: {
        sentMessageItems() {
            return this.sent.map(sent => {
                return {
                    id: sent.id,
                    title: (sent.to ?? []).join(', '),
                    subtitle: 'From: ' + sent.from?.email,
                    body: sent.subject,
                    note: (sent.sent_at === null ? moment(sent.updated_at).fromNow() : moment(sent.sent_at).fromNow()),
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
