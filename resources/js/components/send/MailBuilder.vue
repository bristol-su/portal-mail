<template>
    <p-dynamic-form
        :schema="form"
        v-model="data"
        ref="form"
    >
    </p-dynamic-form>
</template>

<script>
import Field from '@bristol-su/portal-ui-kit/src/generator/schema/Field';

export default {
    name: "MailBuilder",
    props: {
        value: {
            required: true,
            type: Object
        },
        from: {
            required: true,
            type: Array,
            default: () => []
        },
        resendId: {
            required: false,
            type: Number
        },
        uploadedAttachments: {
            required: false,
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            alternativeContent: null,
            alternativeContentType: 'html'
        }
    },
    computed: {

        data: {
            get() {
                let contentType = this.value.content ? (
                    (typeof this.value.content === 'string' || this.value.content instanceof String ) ? 'html' : 'builder'
                ) : 'html';

                return {
                    html_content: contentType === 'html' ? this.value.content : null,
                    content_type: contentType,
                    greeting: (contentType === 'builder' && this.value.content.hasOwnProperty('greeting')) ? this.value.content.greeting : null,
                    before_lines: (contentType === 'builder' && this.value.content.hasOwnProperty('before_lines')) ? this.value.content.before_lines : null,
                    action_text: (contentType === 'builder' && this.value.content.hasOwnProperty('action') && this.value.content.action.hasOwnProperty('text')) ? this.value.content.action.text : null,
                    action_url: (contentType === 'builder' && this.value.content.hasOwnProperty('action') && this.value.content.action.hasOwnProperty('url')) ? this.value.content.action.url : null,
                    action_type: (contentType === 'builder' && this.value.content.hasOwnProperty('action') && this.value.content.action.hasOwnProperty('type')) ? this.value.content.action.type : null,
                    after_lines: (contentType === 'builder' && this.value.content.hasOwnProperty('after_lines')) ? this.value.content.after_lines : null,
                    salutation: (contentType === 'builder' && this.value.content.hasOwnProperty('salutation')) ? this.value.content.salutation : null,
                    ...this.value
                };
            },
            set(val) {
                let newValue = {
                    from_id: val.from_id,
                    to: val.to,
                    cc: val.cc ?? [],
                    bcc: val.bcc ?? [],
                    subject: val.subject ?? null,
                    notes: val.notes ?? null,
                    priority: val.priority ?? null,
                    reply_to: val.reply_to ?? null,
                    existing_attachments: val.existing_attachments,
                    attachments: val.attachments
                }

                let htmlContent = this.alternativeContentType === 'html' ? this.alternativeContent : val.html_content;
                let builderContent = this.alternativeContentType === 'builder' ? this.alternativeContent : {
                    greeting: val.greeting ?? null,
                    before_lines: Array.isArray(val.before_lines) ? val.before_lines : [val.before_lines],
                    action: {
                        text: val.action_text ?? null,
                        url: val.action_url ?? null,
                        type: val.action_type ?? null,
                    },
                    after_lines: Array.isArray(val.after_lines) ? val.after_lines : [val.after_lines],
                    salutation: val.salutation ?? null,
                };

                if(val.content_type === 'html') {
                    newValue.content = htmlContent;
                    this.alternativeContentType = 'builder';
                    this.alternativeContent = builderContent;
                } else {
                    newValue.content = builderContent
                    this.alternativeContentType = 'html';
                    this.alternativeContent = htmlContent;
                }

                this.$emit('input', newValue);
            }
        },
        form() {
            let recipientsGroup = this.$tools.generator.group.newGroup('Recipients')
                .withField(this.$tools.generator.field.select('from_id')
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
                )
                .withField(this.$tools.generator.field.text('reply_to')
                    .label('Reply To')
                    .hint('The email that replies should be directed to.')
                    .required(false)
                );

            let contentGroup = this.$tools.generator.group.newGroup('Content')
                .withField(this.$tools.generator.field.text('subject')
                    .label('Subject')
                    .hint('The subject of the message.')
                    .tooltip('This will appear as the subject on the email.')
                    .required(false)
                )
                .withField(this.$tools.generator.field.radios('content_type')
                    .label('Content Type')
                    .hint('The type of content you want to send.')
                    .value('builder')
                    .withOption('html', 'HTML')
                    .withOption('builder', 'Builder')
                    .required(false)
                )
                .withField((new Field('html', 'html_content'))
                    .label('Content')
                    .hint('The body of the email')
                    .required(false)
                )
                .withField(this.$tools.generator.field.text('greeting')
                    .label('Greeting')
                    .hint('The first line of the message')
                    .tooltip('e.g. Dear X,')
                    .required(false)
                )
                .withField(this.$tools.generator.field.textArea('before_lines')
                    .label('Before Lines')
                    .hint('Lines that appear before the action')
                    .required(false)
                )
                .withField(this.$tools.generator.field.text('action_text')
                    .label('Action Name')
                    .hint('The text to show on the action button')
                    .required(false)
                )
                .withField(this.$tools.generator.field.text('action_url')
                    .label('Action URL')
                    .hint('The URL to send the user to when they click the button')
                    .required(false)
                )
                .withField(this.$tools.generator.field.select('action_type')
                    .label('Action Type')
                    .withOption('action', 'Normal')
                    .withOption('error', 'Error')
                    .withOption('success', 'Success')
                    .value('action')
                    .hint('The text to show on the action button')
                    .required(false)
                )
                .withField(this.$tools.generator.field.textArea('after_lines')
                    .label('After Lines')
                    .hint('Lines that appear after the action')
                    .required(false)
                )
                .withField(this.$tools.generator.field.textArea('salutation')
                    .label('Salutation')
                    .hint('The last line of the message')
                    .tooltip('e.g. Many thanks,')
                    .required(false)
                )

            contentGroup.withField(this.$tools.generator.field.file('attachments')
                .label('Attachments')
                .multiple(true)
                .hint('Attachments for the email.')
                .value([])
                .tooltip('You may select multiple files.')
                .required(false)
            )

            if(this.resendId && this.data.existing_attachments.length > 0) {
                contentGroup.withField(this.$tools.generator.field.checkList('existing_attachments_value')
                    .label('Uploaded Attachments')
                    .hint('Attachments that have already been uploaded in a previous attempt')
                    .required(false)
                    .value(this.data.existing_attachments)
                    .setOptions(this.uploadedAttachments.map(a => {
                        return {id: a.id, value: a.value};
                    }))
                );
            }

            let metaGroup = this.$tools.generator.group.newGroup('Meta Data')
                .withField(this.$tools.generator.field.text('notes')
                    .label('Notes')
                    .hint('Notes to help you identify the email later.')
                    .tooltip('These notes aren\'t shown to the user, and will be kept private.')
                    .required(false)
                ).withField(this.$tools.generator.field.select('priority')
                    .label('Priority')
                    .hint('1 is high priority, 5 is low priority')
                    .required(false)
                    .withOption(1, 'Highest').withOption(2, 'High').withOption(3, 'Medium').withOption(4, 'Low').withOption(5, 'Lowest')
                )

            return this.$tools.generator.form.newForm()
                .withGroup(recipientsGroup).withGroup(contentGroup).withGroup(metaGroup);
        }
    }
}
</script>

<style scoped>

</style>
