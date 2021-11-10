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

        <span>To: {{message.to | arrayToString}}</span>
        <br/>
        <span>From: {{message.from.name}} <{{message.from.email}}></span>
        <br/>
        <span v-if="message.subject">Subject: {{message.subject}}</span>
        <br v-if="message.subject"/>

        <a href="#" class="underline" role="button" @click="expand = true" v-if="expand === false">See More</a>

        <div v-if="expand">
            <span v-if="message.cc && message.cc.length > 0">Cc: {{message.cc | arrayToString}}</span>
            <br v-if="message.cc && message.cc.length > 0"/>
            <span v-if="message.bcc && message.bcc.length > 0">Bcc: {{message.bcc | arrayToString}}</span>
            <br v-if="message.bcc && message.bcc.length > 0"/>
            <span v-if="message.reply_to">Reply To: {{message.reply_to}}</span>
            <br v-if="message.reply_to"/>
            <span v-if="message.sent_at">Sent At: {{moment(message.sent_at).format('lll')}}</span>
            <br v-if="message.sent_at"/>
            <span v-if="message.sent_via">Sent Via: {{message.sent_via}}</span>
            <br v-if="message.sent_via"/>
            <span v-if="message.notes">Notes: {{message.notes}}</span>
            <br v-if="message.notes"/>
        </div>

        <a href="#" class="underline" role="button" @click="expand = false" v-if="expand === true">See Less</a>

        <br/>

        <div v-html="message.preview" class="border-2"></div>
        <br/>

        <div class="flex">
            <div class="flex-1">
                <div v-if="message.attachments && message.attachments.length > 0">
                    Attachments:
                    <ul>
                        <li v-for="attachment in message.attachments">
                            <a class="mt-5 underline" :href="'/mail/attachment/' + attachment.id + '/download'">{{attachment.filename}}</a> ({{attachment.size | fileSize}})</li>
                    </ul>
                </div>
            </div>
            <div class="flex-1" v-if="message.resend_id === null">
                <p-button variant="secondary" :href="resendUrl">
                    Resend
                </p-button>

                <a href="#" class="underline" role="button" @click="expandRetries = !expandRetries" v-if="retries.length > 0.">
                    <span v-if="expandRetries === false">See Retries ({{retries.length}})</span>
                    <span v-else>Hide Retries</span>
                </a>

                <p-modal id="view-retry" title="View Retry" @hide="viewingRetry = null">
                    <view-message :message="viewingRetry" v-if="viewingRetry"></view-message>
                </p-modal>
            </div>
        </div>

        <p-table v-if="message.resend_id === null && expandRetries" :columns="retryColumns" :items="retries" :viewable="true" @view="viewRetry">

        </p-table>

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
            ],
            expand: false,
            expandRetries: false,
            viewingRetry: true
        }
    },
    methods: {
        viewRetry(retry) {
            this.viewingRetry = retry;
            this.$ui.modal.show('view-retry');
        },
        moment(val) {
            return moment(val)
        }
    },
    computed: {
        resendUrl() {
            let parsedUrl = new URL(this.$tools.routes.basic.baseWebUrl() + '/mail');

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
