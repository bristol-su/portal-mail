<template>
    <p-api-form v-model="emailForm" :schema="form" button-text="Add Address" @submit="addEmail" :busy="$isLoading('email-address-add')" busy-text="Adding Address">

    </p-api-form>
</template>

<script>
export default {
    name: "AddAddress",
    data() {
        return {
            emailForm: {}
        }
    },
    methods: {
        addEmail(data) {
            // TODO Change to info not delete
            this.$ui.confirm.delete('Add email address?', 'Are you sure you want to add this email address? This will allow emails to be sent from ' + data.email)
                .then(() => {
                    this.$httpBasic.post('/mail/address', {
                        email: data.email
                    }, {name: 'email-address-add'})
                        .then(response => {
                            this.$ui.notify.success('Email added');
                            this.$emit('added', response.data);
                        })
                })
        }
    },
    computed: {
        emailAddresses() {
            return this.emails;
        },
        form() {
            return this.$tools.generator.form.newForm()
                .withField(this.$tools.generator.field.text('email')
                    .label('Email Address')
                    .hint('The new email address')
                    .tooltip('The email you\'d like to be able to send from')
                    .required(true)
                );
        }
    }
}
</script>

<style scoped>

</style>
