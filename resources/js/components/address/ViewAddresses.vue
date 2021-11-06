<template>
    <div>
        <div class="flex justify-end gap-2 self-end mb-2">
            <span>Actions: </span>
            <a href="#" @click="$ui.modal.show('add-email')" @keydown.space.prevent="$ui.modal.show('add-email')" @keydown.enter.prevent="$ui.modal.show('add-email')" class="text-primary hover:text-primary-dark">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     content="Add Email Address"
                     v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="sr-only">Add Email Address</span>
            </a>
        </div>
        <p-table
            :columns="emailTableFields"
            :items="emailAddresses"
            :deletable="true"
            @delete="deleteAddress">
            <template #actions="{row}">
                <a href="#" @click="verifyEmail(row)" v-if="row.status === 'Waiting for Verification'" @keydown.space.prevent="verifyEmail(row)" @keydown.enter.prevent="verifyEmail(row)" class="text-primary hover:text-primary-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                         content="Send email verification link"
                         v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span class="sr-only">Send email verification link</span>
                </a>
            </template>
        </p-table>

        <p-modal id="add-email" title="Add email address">
            <add-address @added="addEmail">

            </add-address>
        </p-modal>
    </div>
</template>

<script>
import AddAddress from './AddAddress';
export default {
    name: "ViewAddresses",
    components: {AddAddress},
    props: {
        emails: {
            required: true,
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            emailTableFields: [
                {key: 'email', label: 'Email Address'},
                {key: 'status', label: 'Status'},
            ],
            newEmails: [],
            removedEmails: []
        }
    },
    methods: {
        deleteAddress(address) {
            this.$ui.confirm.delete('Delete email address?', 'Are you sure you want to delete this email address?')
                .then(() => {
                    this.$httpBasic.delete('/mail/address/' + address.id, {name: 'delete-email-address-' + address.id})
                        .then(response => {
                            this.$ui.notify.success('Email deleted');
                            this.removedEmails.push(address.id);
                        })
                })
        },
        addEmail(email) {
            this.newEmails.push(email);
            this.$ui.modal.hide('add-email');
        },
        verifyEmail(address) {
            this.$httpBasic.post('/mail/address/' + address.id + '/verification')
                .then(response => this.$ui.notify.success('Verification email sent'))
                .catch(error => this.$ui.notify.error('Verification email not sent: ' + error.message));
        }
    },
    computed: {
        emailAddresses() {
            return _.cloneDeep(this.emails).concat(this.newEmails)
                .filter(email => !this.removedEmails.includes(email.id))
                .map(email => {
                    return {
                        ...email,
                        _table: {
                            isDeleting: this.$isLoading('delete-email-address-' + email.id)
                        }
                    }
                });
        }
    }
}
</script>

<style scoped>

</style>
