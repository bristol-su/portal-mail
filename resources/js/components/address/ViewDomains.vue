<template>
    <div>

        <p-table
            :busy="$isLoading('get-domains')"
            :columns="domainFields"
            :items="domains"
            :viewable="true"
            @view="viewDomain">
        </p-table>

        <p-modal id="view-cname" title="View DNS Records" @hide="viewingDomain = null">
            The following CNAME records should be created for the domain {{viewingDomain ? viewingDomain.domain : 'N/A'}}
            <p-table v-if="viewingDomain" :columns="viewingDomainFields" :items="getDnsDetails(viewingDomain.dns_records)">

            </p-table>
        </p-modal>
    </div>
</template>

<script>
import AddAddress from './AddAddress';
export default {
    name: "ViewDomains",
    components: {AddAddress},
    data() {
        return {
            domainFields: [
                {key: 'domain', label: 'Domain'},
                {key: 'status', label: 'Status'}
            ],
            viewingDomainFields: [
                {key: 'name', label: 'CNAME Name'},
                {key: 'value', label: 'CNAME Value'}
            ],
            domains: [],
            viewingDomain: null
        }
    },
    mounted() {
        this.refreshDomains();
    },
    methods: {
        viewDomain(domain) {
            this.viewingDomain = domain;
            this.$ui.modal.show('view-cname');
        },
        refreshDomains() {
            this.$httpBasic.get('/mail/domains', {name: 'get-domains'})
                .then(response => this.domains = response.data)
                .catch(error => this.$ui.notify.alert('Could not refresh the domain: ' + error.message));
        },
        getDnsDetails(dnsRecords) {
            let details = [];
            for (const [recordName, recordValue] of Object.entries(dnsRecords)) {
                details.push({
                    name: recordName,
                    value: recordValue
                })
            }
            return details;
        }
    }
}
</script>

<style scoped>

</style>
