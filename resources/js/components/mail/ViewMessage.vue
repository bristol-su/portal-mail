<template>
    <div>
        <div class="bg-danger border-l-4 rounded-t border-danger-dark text-black p-4 text-left" v-if="message.is_error">
            <p class="font-bold">The email failed to send after {{message.tries}} attempt{{message.tries === 1 ? '' : 's'}}.</p>
            <p>{{ message.error_message }}</p>
             <p-button variant="secondary" @click="resend" :busy="$isLoading('resend-message')" busy-text="Sending">
                 Resend
             </p-button>
        </div>
        <div class="bg-success border-l-4 rounded-t border-success-dark text-black p-4 text-left" v-else-if="message.is_sent">
            <p class="font-bold">The email was sent at {{moment(message.sent_at).format('lll')}}.</p>
            <p-button variant="secondary" @click="resend" :busy="$isLoading('resend-message')" busy-text="Sending">
                Resend
            </p-button>
        </div>
        <div class="bg-warning border-l-4 rounded-t border-warning-dark text-black p-4 text-left" v-else>
            <p class="font-bold">The email was set to send {{moment(message.updated_at).fromNow()}} ago.</p>
            <p-button variant="secondary" @click="resend" :busy="$isLoading('resend-message')" busy-text="Sending">
                Resend
            </p-button>
        </div>

        <span>From: {{message.from.email}}</span>
        <br/>
        <span>To: {{message.to | arrayToString}}</span>
        <br/>
        <span v-if="message.cc.length > 0">Cc: {{message.cc | arrayToString}}</span>
        <br v-if="message.cc.length > 0"/>
        <span v-if="message.bcc.length > 0">Bcc: {{message.bcc | arrayToString}}</span>
        <br v-if="message.cc.length > 0"/>
        <span v-if="message.sent_via">Sent Via: {{message.sent_via}}</span>
        <br v-if="message.sent_via"/>
        <span v-if="message.notes">Notes: {{message.notes}}</span>
        <br v-if="message.notes"/>
        <div v-html="message.preview" class="border-2"></div>
        <br/>

        <div v-if="message.attachments.length > 0">
            Attachments:
            <ul>
                <li v-for="attachment in message.attachments">
                    <a class="mt-5 underline" :href="'/mail/attachment/' + attachment.id + '/download'">{{attachment.filename}}</a> ({{attachment.size | fileSize}})</li>
            </ul>
        </div>

    </div>
</template>

<script>
import moment from 'moment';
import prettyBytes from 'pretty-bytes';

export default {
    name: "ViewMessage",
    props: {
        message: {
            required: true,
            type: Object
        }
    },
    filters: {
        arrayToString: (array) => array.join(', '),
        fileSize: (bytes) => prettyBytes(bytes)
    },
    data() {
        return {

        }
    },
    methods: {
        moment(val) {
            return moment(val)
        },
        resend() {
            this.$ui.confirm.delete('Resending Email', 'Are you sure you want to resent the email? Make sure any links haven\'t expired before proceeding')
                .then(() => {
                    this.$httpBasic.post('/mail/sent/' + this.message.id + '/resend', {}, {name: 'resend-message'})
                        .then(response => {
                            this.$notify.success('Resent email');
                        })
                        .catch(error => this.$notify.alert('Email could not be sent: ' + error.message));
                });
        }
    },
    computed: {
    }
}
</script>

<style scoped>

</style>
