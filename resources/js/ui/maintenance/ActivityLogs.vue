<template>
    <div class="container-fluid" style="padding:0!important">
        <notifications group="foo" />
        <div class="mb-16"></div>
        <div class="ml-16 mb-24 bb-primary-dark pb-7 text-block">
            <h1 class="m-0 font-35">Activity Logs</h1>
        </div><!-- /.col -->
        <div class="d-flex flex-column flex-xl-row ml-16">
            <div style="flex:20">

                <div class="row mb-10">
                    <div class="col-md-2">

                        <select name="" v-model="filter.log_name" class="form-control flex-1">
                            <option value="" disabled selected>Module Name</option>
                            <option value="">All Modules</option>
                            <option value="Personal Information">Personal Information</option>
                            <option value="Release Entry">Release Entry</option>
                            <option value="Override Release">Override Release</option>
                            <option value="Rejected Release">Rejected Release</option>
                            <option value="Repayment Entry">Repayment Entry</option>
                            <option value="Override Payment">Override Payment</option>
                            <option value="Cancel Payments">Cancel Payments</option>
                            <option value="Product Setup">Product Setup</option>
                            <option value="Center - AO Setup">Center - AO Setup</option>
                            <option value="User Settings">User Settings</option>
                            <option value="Account Re-Tagging">Account Re-Tagging</option>
                            <option value="Deduction Rate">Deduction Rate</option>
                            <option value="End of Day">End of Day</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="" v-model="filter.event" class="form-control flex-1">
                            <option value="" disabled selected>Event</option>
                            <option value="">All Events</option>
                            <option value="created">Created</option>
                            <option value="updated">Updated</option>
                            <option value="deleted">Deleted</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" @click="search()">Search</button>
                    </div>

                </div>

                <div class="p-16 light-border">
                    <table class="table table-striped th-nbt table-hover">
                        <th width="15%">Module Name</th>
                        <th>Description</th>
                        <th>Subject Type</th>
                        <th>Log By</th>
                        <th>Event</th>
                        <th>Transaction Date</th>
                        <th>Log Date & Time</th>
                        <th>Action</th>
                        <tbody>
                            <tr v-if="!activityLogs.length">
                                <td colspan="8">No activity logs yet.</td>
                            </tr>
                            <tr v-for="d in activityLogs" :key="d.id">
                                <td>{{ d.log_name }}</td>
                                <td>{{ d.description }}</td>
                                <td>{{ d.subject_type }}</td>
                                <td>{{ d.causer }}</td>
                                <td style="text-transform: capitalize;">{{ d.event }}</td>
                                <td> {{ d.transaction_date }}</td>
                                <td>{{ d.created_at }}</td>
                                <td>
                                    <button @click="view(d.id)" data-toggle="modal" data-target="#viewLogModal"
                                        class="btn btn-xs btn-primary">
                                        <i class="fa fa-info-circle text-sm"></i>
                                    </button>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row" v-if="pagination.lastPage > 1">
                        <div class="col-12 d-flex flex-column align-items-center">
                            <div class="btn-group mb-2" role="group" aria-label="Pagination">
                                <button type="button" class="btn btn-outline-secondary btn-md"
                                    :disabled="pagination.currentPage === 1"
                                    @click.prevent="changePage(pagination.currentPage - 1)">
                                    ‹ Prev
                                </button>
                                <button type="button" v-for="page in paginationRange"
                                    :key="page"
                                    class="btn"
                                    :class="{
                                        'btn-primary': page === pagination.currentPage,
                                        'btn-outline-secondary': page !== pagination.currentPage,
                                        'disabled': page === '...'
                                    }"
                                    style="min-width: 40px;"
                                    @click.prevent="page !== '...' && changePage(page)">
                                    {{ page }}
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-md"
                                    :disabled="pagination.currentPage === pagination.lastPage"
                                    @click.prevent="changePage(pagination.currentPage + 1)">
                                    Next ›
                                </button>
                            </div>
                            <div class="dataTables_info text-center" style="font-size: 0.875rem; color: #6c757d;">
                                Showing {{ showingFrom }} to {{ showingTo }} of {{ pagination.total }} entries
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="viewLogModal" tabindex="-1" role="dialog" aria-labelledby="viewActivityLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="viewActivityLabel">
                            Activity Log - {{ activityLog.log_name }}
                        </h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-primary text-bold">
                                        Log Info
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    Description:
                                                </div>
                                                <div class="col-md-6">
                                                    {{ activityLog.description }}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    Log by:
                                                </div>
                                                <div class="col-md-6">
                                                    {{ activityLog.causer }}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    Event:
                                                </div>
                                                <div class="col-md-6" style="text-transform: capitalize;">
                                                    {{ activityLog.event }}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    Subject:
                                                </div>
                                                <div class="col-md-8">
                                                    <ul>
                                                        <li v-for="key in Object.keys(activityLog.subject?.data || {}).sort()" :key="key">
                                                            {{ key }} : {{ activityLog.subject.data[key] }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-primary text-bold">
                                        Properties
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header text-bold">
                                                    New Values
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <ul>
                                                        <li v-for="key in Object.keys(activityLog.properties?.attributes || {}).sort()" :key="key">
                                                            {{ key }} : {{ activityLog.properties.attributes[key] }}
                                                        </li>
                                                    </ul>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header text-bold">
                                                    Old Values
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <ul>
                                                        <li v-for="key in Object.keys(activityLog.properties?.old || {}).sort()" :key="key">
                                                            {{ key }} : {{ activityLog.properties.old[key] }}
                                                        </li>
                                                    </ul>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    props: ['token'],
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            activityLogs: [],
            activityLog: {},
            deductions: [],
            pagination: {
                currentPage: 1,
                lastPage: 1,
                perPage: 10,
                total: 0
            },
            filter: {
                log_name: "",
                event: ""
            },
            deduction: {
                id: null,
                name: '',
                rate: '',
                product_id: '',
                term_start: '',
                term_end: '',
                age_start: '',
                age_end: '',
                status: 'active',
            }
        }
    },
    methods: {
        async fetchActivityLogs(page = 1) {
            await axios.get(this.baseURL() + 'api/activity-logs/', {
                params: {
                    'log_name': this.filter.log_name,
                    'event': this.filter.event,
                    'page': page
                },
                headers: {
                    'Authorization': 'Bearer ' + this.token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
                .then(function (response) {
                    this.activityLogs = response.data.data;
                    this.pagination.currentPage = response.data.current_page;
                    this.pagination.lastPage = response.data.last_page;
                    this.pagination.perPage = response.data.per_page;
                    this.pagination.total = response.data.total;
                }.bind(this))
                .catch(function (error) {
                    console.log(error);
                }.bind(this));
        },
        changePage(page) {
            if (page >= 1 && page <= this.pagination.lastPage) {
                this.fetchActivityLogs(page);
            }
        },
        search() {
            this.fetchActivityLogs(1);
        },

        async view(id) {
            await axios.get(this.baseURL() + 'api/activity-logs/' + id, {
                headers: {
                    'Authorization': 'Bearer ' + this.token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
                .then(function (response) {
                    this.activityLog = response.data.data
                }.bind(this))
                .catch(function (error) {
                    console.log(error);
                }.bind(this));
        }
    },
    computed: {
        paginationRange() {
            const current = this.pagination.currentPage;
            const last = this.pagination.lastPage;
            const delta = 2;
            const range = [];
            
            for (let i = Math.max(2, current - delta); i <= Math.min(last - 1, current + delta); i++) {
                range.push(i);
            }
            
            if (current - delta > 2) {
                range.unshift('...');
            }
            if (current + delta < last - 1) {
                range.push('...');
            }
            
            range.unshift(1);
            if (last > 1) {
                range.push(last);
            }
            
            return range;
        },
        showingFrom() {
            return ((this.pagination.currentPage - 1) * this.pagination.perPage) + 1;
        },
        showingTo() {
            return Math.min(this.pagination.currentPage * this.pagination.perPage, this.pagination.total);
        }
    },
    mounted() {
        this.fetchActivityLogs();
    }
}
</script>

<style scoped>
td {
    cursor: pointer;
}
</style>
