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
                            <option value="">-Select Logname-</option>
                            <option value="Release Entry">Release Entry</option>
                            <option value="Override Release">Override Release</option>
                            <option value="Rejected Release">Rejected Release</option>
                            <option value="Repayment Entry">Repayment</option>
                            <option value="Override Payment">Override Payment</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="" v-model="filter.event" class="form-control flex-1">
                            <option value="">-Select Event-</option>
                            <option value="created">Create</option>
                            <option value="updated">Edit </option>
                            <option value="deleted">Delete</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary" @click="search()">Search</button>
                    </div>

                </div>

                <div class="p-16 light-border">
                    <table class="table table-striped th-nbt table-hover">
                        <th width="15%">Log Name</th>
                        <th>Description</th>
                        <th>Subject Type</th>
                        <th>Log By</th>
                        <th>Event</th>
                        <th>Transaction Date</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th width="13%">Action</th>
                        <tbody>
                            <tr v-if="!activityLogs.length">
                                <td>No activity logs yet.</td>
                            </tr>
                            <tr v-for="d in activityLogs" :key="d.id">
                                <td>{{ d.log_name }}</td>
                                <td>{{ d.description }}</td>
                                <td>{{ d.subject_type }}</td>
                                <td>{{ d.causer }}</td>
                                <td>{{ d.event }}</td>
                                <td> {{ d.transaction_date }}</td>
                                <td>{{ d.created_at }}</td>
                                <td>{{ d.updated_at }}</td>
                                <td>
                                    <button @click="view(d.id)" data-toggle="modal" data-target="#viewLogModal"
                                        class="btn btn-xs btn-primary">
                                        <i class="fa fa-info-circle text-sm"></i>
                                    </button>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <div class="modal fade" id="viewLogModal" tabindex="-1" role="dialog" aria-labelledby="viewActivityLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="viewActivityLabel">
                            Activity Log - @{{ activityLog.log_name }}
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
                                                    Subject:
                                                </div>
                                                <div class="col-md-8">
                                                    <ul>
                                                        <li v-for="(item, index) in activityLog.subject?.data"
                                                            :key="index">
                                                            {{ index }} : <br> {{ item }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    Description:
                                                </div>
                                                <div class="col-md-6">
                                                    {{ activityLog.event }}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    Log by:
                                                </div>
                                                <div class="col-md-6">
                                                    {{ activityLog.causer }}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    Event:
                                                </div>
                                                <div class="col-md-6">
                                                    {{ activityLog.description }}
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
                                                    Attributes
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <ul>
                                                        <li v-for="(item, index) in activityLog.properties?.attributes"
                                                            :key="index">
                                                            {{ index }}: <br> {{ item }}
                                                        </li>
                                                    </ul>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header text-bold">
                                                    Old
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <ul>
                                                        <li v-for="(item, index) in activityLog.properties?.old"
                                                            :key="index">
                                                            {{ index }} : <br> {{ item }}
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
        async fetchActivityLogs() {
            await axios.get(this.baseURL() + 'api/activity-logs/', {
                params: {
                    'log_name': this.filter.log_name,
                    'event': this.filter.event
                },
                headers: {
                    'Authorization': 'Bearer ' + this.token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
                .then(function (response) {
                    this.activityLogs = response.data.data;
                }.bind(this))
                .catch(function (error) {
                    console.log(error);
                }.bind(this));
        },
        search() {
            this.fetchActivityLogs();
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
