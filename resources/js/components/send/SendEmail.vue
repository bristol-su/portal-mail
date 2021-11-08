<template>
    <p-form-padding>
        <p-api-form :schema="form" button-text="Send" @submit="send" :busy="$isLoading('sending-email')" busy-text="Sending">

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
    methods: {
        send(data) {
            let formData = new FormData();
            if(data.attachments.length > 0) {
                formData.append('type', 'file');
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
            formData.append('content', data.content);

            console.log(formData.forEach((value, key) => console.log(value, key)));
            this.$httpBasic.post('/mail/send', formData, {name: 'sending-email', headers: {'Content-Type': 'multipart/form-data'}})
                .then(response => {
                    this.$notify.success('Email sent');
                })
                .catch(error => this.$notify.error('Email was not sent: ' + error.message));
        },
        preview(data) {

        }
    },
    computed: {
        form() {
            return this.$tools.generator.form.newForm()
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
                ).withField((new Field('html', 'content'))
                    .label('Content')
                    .hint('The body of the email')
                    .required(false)
                ).withField(this.$tools.generator.field.file('attachments')
                    .label('Attachments')
                    .multiple(true)
                    .hint('Attachments for the email.')
                    .value([])
                    .tooltip('You may select multiple files.')
                    .required(false)
                );
        }
    }
}
</script>

<style scoped>

</style>
