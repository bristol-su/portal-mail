<template>
    <p-api-form v-model="userForm" :schema="form" button-text="Grant Permissions" @submit="addUser" :busy="$isLoading('user-add')" busy-text="Changing user permissions">

    </p-api-form>
</template>

<script>
import Field from '@bristol-su/portal-ui-kit/src/generator/schema/Field';

export default {
    name: "EditUser",
    data() {
        return {
            userForm: {}
        }
    },
    props: {
        user: {
            required: false,
            default: null
        },
        availableEmails: {
            required: false,
            default: () => [],
            type: Array
        }
    },
    methods: {
        addUser(data) {
            this.$ui.confirm.delete('Change user access?', 'Are you sure you want to change the email access for this user?')
                .then(() => {
                    this.$httpBasic.patch('/mail/user/' + data.user, {email_ids: data.email_ids}, {name: 'user-add'})
                        .then(response => {
                            this.$ui.notify.success('User permissions changed');
                            this.$emit('added', response.data);
                        })
                })
        }
    },
    computed: {
        userAddresses() {
            return this.users;
        },
        form() {
            return this.$tools.generator.form.newForm()
                .withField((new Field('p-user-search', 'user'))
                    .label('User')
                    .hint('The user to grant access to')
                    .required(true)
                    .value(this.user !== null ? this.user.id : null)
                    .disabled(this.user !== null)
                )
                .withField(this.$tools.generator.field.checkList('email_ids')
                    .label('Emails')
                    .hint('The emails the user can send from')
                    .tooltip('The email addresses that the user has permission to send from')
                    .required(false)
                    .setOptions(this.availableEmails.map(e => { return {id: e.id, text: e.email} }))
                    .value(this.user !== null ? this.user.email_addresses.map(e => e.id) : [])
                );
        }
    }
}
</script>

<style scoped>

</style>
