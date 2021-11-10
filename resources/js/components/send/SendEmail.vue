<template>
    <p-form-padding>
        <mail-builder v-model="newMail" v-if="showForm" :from="from" :resend-id="resendId" :uploaded-attachments="uploadedAttachments">

        </mail-builder>

        <p-button @click.prevent="send" :busy="$isLoading('sending-email')" busy-text="Sending">Send</p-button>

    </p-form-padding>
</template>

<script>
import MailBuilder from './MailBuilder';

export default {
    name: "SendEmail",
    components: {MailBuilder},
    props: {
        from: {
            required: true,
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            showForm: false,
            newMail: {
                from_id: null,
                to: [],
                cc: [],
                bcc: [],
                subject: null,
                notes: null,
                content: [],
                priority: null,
                reply_to: null,
                existing_attachments: []
            },
            uploadedAttachments: []
        }
    },
    created() {
        if(this.resendId) {
            this.$httpBasic.get('/mail/sent/' + this.resendId, {name: 'resent-message'})
                .then(response => {
                    this.uploadedAttachments = response.data.attachments ?? [];
                    this.newMail = {
                        from_id: response.data.from_id ?? null,
                        to: response.data.to ?? [],
                        cc: response.data.cc ?? [],
                        bcc: response.data.bcc ?? [],
                        subject: response.data.subject ?? null,
                        notes: response.data.notes ?? null,
                        content: response.data.content ?? [],
                        priority: response.data.priority ?? null,
                        reply_to: response.data.reply_to ?? null,
                        existing_attachments: this.uploadedAttachments.map(a => a.id) ?? []
                    }
                })
                .catch((error) => this.$notify.alert('Could not load previous mail: ' + error.message))
                .then(() => this.showForm = true);
        } else {
            this.showForm = true;
        }
    },
    methods: {
        send() {
            let data = this.newMail;
            let formData = new FormData();
            formData.append('from_id', data.from_id);
            formData.append('subject', data.subject);
            formData.append('notes', data.notes);
            formData.append('via', 'inbox');
            formData.append('reply_to', data.reply_to);
            formData.append('priority', data.priority);

            for (let attachment of data.attachments) {
                formData.append('attachments[]', attachment)
            }
            for(let e of data.to) {
                formData.append('to[]', e);
            }
            for(let e of data.cc) {
                formData.append('cc[]', e);
            }
            for(let e of data.bcc) {
                formData.append('bcc[]', e);
            }

            if((typeof data.content === 'string' || data.content instanceof String )) {
                formData.append('content', data.content);
            } else {
                let content = data.content ?? {};
                let action = content.action ?? {};

                formData.append('content[greeting]', content.greeting);
                formData.append('content[action][text]', action.text);
                formData.append('content[action][url]', action.url);
                formData.append('content[action][type]', action.type);
                formData.append('content[salutation]', data.salutation);

                for(let line of content.before_lines) {
                    formData.append('content[before_lines][]', line);
                }

                for(let line of content.after_lines) {
                    formData.append('content[after_lines][]', line);
                }

            }

            if(data.existing_attachments && data.existing_attachments.length > 0) {
                for (let existing_attachments of data.existing_attachments) {
                    formData.append('existing_attachments[]', existing_attachments)
                }
            }

            if(this.resendId) {
                formData.append('resend_id', this.resendId);
            }

            this.$httpBasic.post('/mail/send', formData, {name: 'sending-email', headers: {'Content-Type': 'multipart/form-data'}})
                .then(response => {
                    this.$notify.success('Email sent');
                })
                .catch(error => this.$notify.alert('Email was not sent: ' + error.message));
        },
        preview(data) {

        }
    },
    computed: {
        resendId() {
            let resendId = Object.fromEntries(new URLSearchParams(window.location.search).entries()).resendId;
            if(resendId) {
                resendId = Number(resendId);
            }
            return resendId;
        },
    }
}
</script>

<style scoped>

</style>
