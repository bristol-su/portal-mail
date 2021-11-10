<template>
    <div>
        <div class="bg-danger border-l-4 rounded-t border-danger-dark text-black p-4 text-left" v-if="message.status === 'Failed'">
            <p class="font-bold">The email failed to send after {{message.retries.length + 1}} attempt{{message.retries.length === 0 ? '' : 's'}}.</p>
            <p v-if="failedDueToValidation">
                {{validationErrorMessage.errors}}

                {{validationErrorMessage.data}}
            </p>
            <p v-else>{{ message.error_message }}</p>
        </div>

        <div class="bg-warning border-l-4 rounded-t border-warning-dark text-black p-4 text-left" v-else-if="message.status === 'Pending'">
            <p class="font-bold">The email was set to send {{moment(message.updated_at).fromNow()}}.</p>
        </div>

        <span>From: {{message.from.name}} <{{message.from.email}}></span>
        <br/>
        <span>To: {{message.to | arrayToString}}</span>
        <br/>
        <span v-if="message.cc && message.cc.length > 0">Cc: {{message.cc | arrayToString}}</span>
        <br v-if="message.cc && message.cc.length > 0"/>
        <span v-if="message.bcc && message.bcc.length > 0">Bcc: {{message.bcc | arrayToString}}</span>
        <br v-if="message.bcc && message.bcc.length > 0"/>
        <span v-if="message.sent_via">Sent Via: {{message.sent_via}}</span>
        <br v-if="message.sent_via"/>
        <span v-if="message.reply_to">Reply To: {{message.reply_to}}</span>
        <br v-if="message.reply_to"/>
        <span v-if="message.priority">Priority: {{message.priority}}</span>
        <br v-if="message.priority"/>
        <span v-if="message.notes">Notes: {{message.notes}}</span>
        <br v-if="message.notes"/>
        <span v-if="message.sent_at">Sent At: {{moment(message.sent_at).format('lll')}}</span>
        <br v-if="message.sent_at"/>
        <div v-html="message.preview" class="border-2"></div>
        <br/>

        <div v-if="message.attachments && message.attachments.length > 0">
            Attachments:
            <ul>
                <li v-for="attachment in message.attachments">
                    <a class="mt-5 underline" :href="'/mail/attachment/' + attachment.id + '/download'">{{attachment.filename}}</a> ({{attachment.size | fileSize}})</li>
            </ul>
        </div>

        <div v-if="message.resend_id === null">
            <p-button variant="secondary" :href="resendUrl">
                Resend
            </p-button>

            <p-table :columns="retryColumns" :items="retries" :viewable="true" @view="$emit('viewRetry', $event)">

            </p-table>

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
        arrayToString: (array) => Array.isArray(array) ? array.join(', ') : '',
        fileSize: (bytes) => prettyBytes(bytes)
    },
    data() {
        return {
            retryColumns: [
                {key: 'id', label: 'ID'},
                {key: 'status', label: 'Status'}
            ]
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
        resendUrl() {
            let parsedUrl = new URL(this.$tools.routes.basic.baseWebUrl() + '/mail/send');

            Object.entries({resend_id: this.message.id}).forEach(([key, value]) => {
                parsedUrl.searchParams.set(key, value);
            })
            return parsedUrl.toString();
        },
        retries() {
            return this.message.retries;
        },
        validationErrorMessage() {
            return JSON.parse(this.message.error_message)
        },
        failedDueToValidation() {
            try {
                console.log(this.validationErrorMessage.validation);
                return this.validationErrorMessage.validation;
            } catch (e) {}
            return false;
        }
    }
}
</script>

<style scoped>

</style>
