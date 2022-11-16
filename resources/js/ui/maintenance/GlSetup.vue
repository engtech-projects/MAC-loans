<template>
    <div class="container-fluid" style="padding: 0 !important">
        <notifications group="foo" />
        <div class="mb-16"></div>
        <div class="ml-16 mb-24 bb-primary-dark pb-7 text-block">
            <h1 class="m-0 font-35">General Ledger Setup</h1>
        </div>
        <!-- /.col -->
        <div class="d-flex flex-column flex-xl-row ml-16">
            <div style="flex: 9">
                <form @submit.prevent="save()">
                    <section class="mb-24" style="flex: 21; padding-left: 16px">
                        <span class="section-title section-subtitle mb-12"
                            >Inputs</span
                        >

                        <div class="d-flex flex-column p-16 light-border">
                            <div class="form-group mb-10" style="flex: 1">
                                <label for="loansPortal" class="form-label"
                                    >Loans Portal</label
                                >
                                <input
									v-model="inputs.loans"
                                    type="text"
                                    class="form-control form-input"
                                    id="loansPortal"
                                    required
                                />
                            </div>
                            <div class="form-group mb-10" style="flex: 1">
                                <label for="codePortal" class="form-label"
                                    >Code</label
                                >
                                <input
									v-model="inputs.code"
                                    type="text"
                                    class="form-control form-input"
                                    id="codePortal"
                                    required
                                />
                            </div>
                            <div class="form-group mb-10" style="flex: 1">
                                <label for="loansPortal" class="form-label"
                                    >Accounting Portal</label
                                >
                                <input
								v-model="inputs.accounting"
                                    type="text"
                                    class="form-control form-input"
                                    id="loansPortal"
                                    required
                                />
                            </div>
                            <div class="d-flex align-items-end mb-16">
                                <div
                                    class="form-group mb-0 mr-10"
                                    style="flex: 1"
                                >
                                    <label for="loansPortal" class="form-label"
                                        >Account</label
                                    >
                                    <select
										v-model="inputs.type"
                                        name=""
                                        id=""
                                        class="form-control form-input"
                                        required
                                    >
                                        <option
                                            v-for="a in accounts"
                                            :key="a"
                                            :value="a"
                                        >
                                            {{ upperFirst(a) }}
                                        </option>
                                    </select>
                                </div>
                                <button
                                    data-toggle="modal"
                                    data-target="#accountModal"
                                    class="btn btn-primary-dark"
                                    style="height: 49px"
                                >
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button
                                    class="btn btn-lg btn-success min-w-150"
                                >
                                    Save
                                </button>
                            </div>
                        </div>
                        <div
                            class="d-flex flex-column light-border"
                            v-if="1 == 0"
                        >
                            <div
                                class="d-flex justify-content-between mb-16 bg-primary-dark text-white px-16 py-7"
                            >
                                <span class="text-bold font-md">Edit</span>
                                <a href="" @click.prevent="" class="text-white"
                                    ><i class="fa fa-times"></i
                                ></a>
                            </div>
                            <div class="px-16 mb-16">
                                <div class="form-group mb-10" style="flex: 1">
                                    <label for="productName" class="form-label"
                                        >Product Name</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control form-input"
                                        id="productName"
                                    />
                                </div>
                                <div class="d-flex flex-row mb-24">
                                    <div
                                        class="form-group mb-10 mr-24"
                                        style="flex: 1"
                                    >
                                        <label
                                            for="productName"
                                            class="form-label"
                                            >Product Code</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control form-input"
                                            id="productName"
                                        />
                                    </div>
                                    <div
                                        class="form-group mb-10"
                                        style="flex: 1"
                                    >
                                        <label
                                            for="productName"
                                            class="form-label"
                                            >Percentage</label
                                        >
                                        <input
                                            type="number"
                                            class="form-control form-input"
                                            id="productName"
                                            min="0"
                                            max="100"
                                        />
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a
                                        href="#"
                                        class="btn btn-lg btn-yellow-light min-w-150"
                                        >Activate</a
                                    >
                                    <a
                                        href="#"
                                        class="btn btn-lg btn-danger min-w-150"
                                        >Deactivate</a
                                    >
                                    <a
                                        href="#"
                                        class="btn btn-lg btn-success min-w-150"
                                        >Save</a
                                    >
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
            <div style="flex: 20">
                <section class="mb-24" style="flex: 21; padding-left: 16px">
                    <span class="section-title section-subtitle mb-12"
                        >List</span
                    >
                    <div class="p-16 light-border">
                        <table class="table table-stripped th-nbt table-hover">
                            <thead>
                                <th>Loan's Portal</th>
                                <th>Code</th>
                                <th>Accounting Portal</th>
                                <th>Account</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr v-if="!ledgerAccounts.length">
                                    <td>No products found.</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr
                                    v-for="la in ledgerAccounts"
                                    :key="la.gl_id"
                                >
                                    <td>{{ la.loans }}</td>
                                    <td>{{ la.code }}</td>
                                    <td>{{ la.accounting }}</td>
                                    <td>{{ la.type }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>

        <div class="modal" id="accountModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-24">
                        <form @submit.prevent="addAccount()">
                            <div class="d-flex flex-column">
                                <div
                                    class="form-group mb-10 block"
                                    style="flex: 1"
                                >
                                    <label for="loansPortal" class="form-label"
                                        >Account Name</label
                                    >
                                    <input
                                        required
                                        type="text"
                                        class="form-control form-input"
                                        v-model="newAccount"
                                        id="loansPortal"
                                        placeholder="Enter account name"
                                    />
                                    <i class="text-red">{{ accountErr }}</i>
                                </div>
                                <button
                                    class="btn btn-primary-dark btn-wide align-self-end"
                                >
                                    Add
                                </button>
                                <button
                                    id="cancelAccountBtn"
                                    class="hide"
                                    data-dismiss="modal"
                                ></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["token"],
    data() {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
            ledgerAccounts: [],
            newAccount: "",
            accounts: [],
            accountErr: "",
            inputs: {
                loans: "",
                code: "",
                accounting: "",
                type: "",
                gl_id: null,
            },
        };
    },
    methods: {
		resetInputs: function() {
			this.inputs = {
                loans: "",
                code: "",
                accounting: "",
                type: "",
                gl_id: null,
            }
		},
        async save() {
            if (this.inputs.gl_id) {
                await axios
                    .put(
                        this.baseURL() + "api/deduction/" + this.deduction.id,
                        this.deduction,
                        {
                            headers: {
                                Authorization: "Bearer " + this.token,
                                "Content-Type": "application/json",
                                Accept: "application/json",
                            },
                        }
                    )
                    .then(
                        function (response) {
                            this.notify("", response.data.message, "success");
                            this.fetchDeductions();
                            this.resetDeduction();
                        }.bind(this)
                    )
                    .catch(
                        function (error) {
                            console.log(error);
                        }.bind(this)
                    );
            } else {
                await axios
                    .post(this.baseURL() + "api/gl", this.inputs, {
                        headers: {
                            Authorization: "Bearer " + this.token,
                            "Content-Type": "application/json",
                            Accept: "application/json",
                        },
                    })
                    .then(
                        function (response) {
							this.resetInputs();
                        	this.notify("", response.data.message, "success");
                           	this.fetchLedgerAccounts();
                        }.bind(this)
                    )
                    .catch(
                        function (error) {
                            console.log(error);
                        }.bind(this)
                    );
            }
        },
        fetchLedgerAccounts: function () {
            axios
                .get(this.baseURL() + "api/gl", {
                    headers: {
                        Authorization: "Bearer " + this.token,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                })
                .then(
                    function (response) {
                        this.ledgerAccounts = response.data.data;
                        this.accounts = this.setAccounts();
                    }.bind(this)
                )
                .catch(
                    function (error) {
                        console.log(error);
                    }.bind(this)
                );
        },
        addAccount: function () {
            this.accountErr = "";
            if (
                this.newAccount.length &&
                !this.accounts.includes(this.newAccount.toLowerCase())
            ) {
                this.accounts.push(this.newAccount.toLowerCase());
                this.notify("", "New account has been added.", "success");
                var cancel = document.getElementById("cancelAccountBtn");
                this.newAccount = "";
                cancel.click();
            } else {
                this.accountErr = "Account name has already exists.";
            }
        },
        setAccounts: function () {
            let accounts = [];
            this.ledgerAccounts.forEach((la) => {
                if (!accounts.includes(la.type)) {
                    accounts.push(la.type);
                }
            });
            return accounts;
        },
        notify: function (title, text, type) {
            this.$notify({
                group: "foo",
                title: title,
                text: text,
                type: type,
            });
        },
    },
    computed: {},
    mounted() {
        this.fetchLedgerAccounts();
    },
};
</script>
