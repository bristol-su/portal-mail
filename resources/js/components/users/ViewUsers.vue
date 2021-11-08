<template>
    <div>
        <div class="flex justify-end gap-2 self-end mb-2">
            <span>Actions: </span>
            <a href="#" @click="$ui.modal.show('edit-user')" @keydown.space.prevent="$ui.modal.show('edit-user')" @keydown.enter.prevent="$ui.modal.show('edit-user')" class="text-primary hover:text-primary-dark">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     content="Add User"
                     v-tippy="{ arrow: true, animation: 'fade', placement: 'top-start', arrow: true, interactive: true}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="sr-only">Add User</span>
            </a>
        </div>
        <p-table
            :columns="userTableFields"
            :items="userItems"
            :editable="true"
            @edit="editUser">
        </p-table>

        <p-modal id="edit-user" title="Edit email access">
            <edit-user @added="addUser" :user="editingUser" :available-emails="availableEmails">

            </edit-user>
        </p-modal>
    </div>
</template>

<script>
import EditUser from './EditUser';
export default {
    name: "ViewUsers",
    components: {EditUser},
    props: {
        users: {
            required: true,
            type: Array,
            default: () => []
        },
        availableEmails: {
            required: false,
            default: () => [],
            type: Array
        }
    },
    mounted() {
        this.managedUsers = this.users;
    },
    data() {
        return {
            userTableFields: [
                {key: 'data.preferred_name', label: 'Name'},
                {key: 'data.email', label: 'Email'},
                {key: 'all_emails', label: 'Available Emails', truncateCell: 30}
            ],
            managedUsers: [],
            removedUsers: [],
            editingUser: null
        }
    },
    methods: {
        editUser(user) {
            this.editingUser = user;
            this.$ui.modal.show('edit-user');
        },
        addUser(user) {
            this.managedUsers = this.managedUsers.filter(u => u.id !== user.id);
            if(user.email_addresses.length > 0) {
                this.managedUsers.push(user);
            }
            this.editingUser = null;
            this.$ui.modal.hide('edit-user');
        },
    },
    computed: {
        userItems() {
            return this.managedUsers
                .filter(user => !this.removedUsers.includes(user.id))
                .map(user => {
                    user.all_emails = user.email_addresses.map(e => e.email).join(', ')
                    return user;
                });
        }
    }
}
</script>

<style scoped>

</style>
