<template>
    <p-form-padding>
        <p-api-form v-if="showForm" :initial-data="initialData" :schema="form" button-text="Send" @submit="send" :busy="$isLoading('sending-email')" busy-text="Sending">

        </p-api-form>
    </p-form-padding>
</template>

<script>
import Field from '@bristol-su/portal-ui-kit/src/generator/schema/Field';

export default {
    name: "SendEmail",
    props: {
        from: {
            required: true,
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            initialData: {},
            showForm: false
        }
    },
    created() {
        if(this.query.resend_id) {
            this.$httpBasic.get('/mail/sent/' + this.query.resend_id, {name: 'resent-message'})
                .then(response => this.initialData = {
                    from: response.data.from.id,
                    to: response.data.to,
                    cc: response.data.cc ?? '',
                    bcc: response.data.bcc ?? '',
                    subject: response.data.subject ?? null,
                    notes: response.data.notes ?? null,
                    content: response.data.content ?? null,
                    priority: response.data.priority ?? null,
                    reply_to: response.data.reply_to ?? null,
                    existing_attachments_for_select: response.data.attachments.map(a => {
                        return {id: a.id, text: a.filename}
                    }),
                    existing_attachments: response.data.attachments.map(a => a.id),
                })
                .catch((error) => this.$notify.alert('Could not load previous mail: ' + error.message))
                .then(() => this.showForm = true);
        } else {
            this.showForm = true;
        }
    },
    methods: {
        send(data) {
            let formData = new FormData();
            if(data.attachments.length > 0) {
                for (let attachment of data.attachments) {
                    formData.append('attachments[]', attachment)
                }
            }
            formData.append('from', data.from);
            for(let e of data.to) {
                formData.append('to[]', e);
            }
            for(let e of data.cc) {
                formData.append('cc[]', e);
            }
            for(let e of data.bcc) {
                formData.append('bcc[]', e);
            }
            formData.append('subject', data.subject);
            formData.append('notes', data.notes);
            formData.append('content', data.content);
            formData.append('via', 'inbox');
            formData.append('reply_to', data.reply_to);
            formData.append('priority', data.priority);
            if(data.existing_attachments && data.existing_attachments.length > 0) {
                for (let existing_attachments of data.existing_attachments) {
                    formData.append('existing_attachments[]', existing_attachments)
                }
            }

            if(this.query.resend_id) {
                formData.append('resend_id', this.query.resend_id);
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
        query() {
            return Object.fromEntries(new URLSearchParams(window.location.search).entries());
        },
        form() {
            let form = this.$tools.generator.form.newForm()
                .withField(this.$tools.generator.field.select('from')
                    .setOptions(this.from.map((e) => {
                        return {id: e.id, value: e.email}
                    }))
                    .label('From')
                    .hint('Who to send the email from.')
                    .tooltip('This will appear as the address the email is sent from')
                    .required(true)
                )
                .withField(this.$tools.generator.field.tags('to')
                    .label('To *')
                    .hint('Who to send the email to.')
                    .tooltip('You may enter multiple recipients by pressing enter.')
                    .required(false)
                )
                .withField(this.$tools.generator.field.tags('cc')
                    .label('CC')
                    .hint('Who to cc the email to.')
                    .tooltip('You may enter multiple recipients by pressing enter.')
                    .value([])
                    .required(false)
                )
                .withField(this.$tools.generator.field.tags('bcc')
                    .label('Bcc')
                    .hint('Who to bcc the email to.')
                    .tooltip('You may enter multiple recipients by pressing enter.')
                    .value([])
                    .required(false)
                ).withField(this.$tools.generator.field.text('subject')
                    .label('Subject')
                    .hint('The subject of the message.')
                    .tooltip('This will appear as the subject on the email.')
                    .required(false)
                ).withField(this.$tools.generator.field.text('notes')
                    .label('Notes')
                    .hint('Notes to help you identify the email later.')
                    .tooltip('These notes aren\'t shown to the user, and will be kept private.')
                    .required(false)
                ).withField((new Field('html', 'content'))
                    .label('Content')
                    .hint('The body of the email')
                    .required(false)
                ).withField(this.$tools.generator.field.select('priority')
                    .label('Priority')
                    .hint('1 is high priority, 5 is low priority')
                    .required(false)
                    .withOption(1, 'Highest').withOption(2, 'High').withOption(3, 'Medium').withOption(4, 'Low').withOption(5, 'Lowest')
                ).withField(this.$tools.generator.field.text('reply_to')
                    .label('Reply To')
                    .hint('The email that replies should be directed to.')
                    .required(false)
                ).withField(this.$tools.generator.field.file('attachments')
                    .label('Attachments')
                    .multiple(true)
                    .hint('Attachments for the email.')
                    .value([])
                    .tooltip('You may select multiple files.')
                    .required(false)
                );
            if(Object.entries(this.query.resend_id ?? {}).length > 0 && this.initialData.existing_attachments.length > 0) {
                console.log(this.initialData.existing_attachments.map(e => e.id));
                form.withField(this.$tools.generator.field.checkList('existing_attachments')
                    .label('Uploaded Attachments')
                    .hint('Attachments that have already been uploaded in a previous attempt')
                    .required(false)
                    .value(this.initialData.existing_attachments)
                    .setOptions(this.initialData.existing_attachments_for_select)
                );
            }
            return form;
        }
    }
}
</script>

<style scoped>

</style>
