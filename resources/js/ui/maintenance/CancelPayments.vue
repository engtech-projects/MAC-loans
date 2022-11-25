<template>
    <div class="container-fluid px-16">
        <notifications group="foo" />
        <div class="mb-16"></div>
        <div
            class="d-flex justify-content-between mb-24 bb-primary-dark pb-7 text-block"
        >
            <h1 class="m-0 font-35">Cancel Payments</h1>
            <!-- <a href="#" class="btn btn-primary-dark min-w-150">New Client</a> -->
        </div>
        <!-- /.col -->
        <div v-if="transactionDate.status == 'open'" class="d-flex flex-column flex-xl-row">
            <div style="flex: 9">
                <div class="d-flex justify-content-between">
                    <div class="search-bar mr-10" style="flex: 5">
                        <input
                            type="text"
                            class="form-control"
                            id="searchBar"
                            placeholder="Search"
                            v-model="filter"
                        />
                        <div><i class="fa fa-search"></i></div>
                    </div>
                    <input
                        v-model="searchDate"
                        type="date"
                        class="form-control"
                        style="flex: 2"
                    />
                </div>
                <table
                    class="table table-stripped table-hover"
                    id="clientsList"
                >
                    <thead>
                        <th>Account #</th>
                        <th>Client Name</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr v-if="!filteredBorrowers.length">
                            <td>No payments found.</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr
                            v-for="borrower in filteredBorrowers"
                            :key="borrower.borrower_id"
                            :class="
                                borrower.borrower_id ==
                                selectedBorrower.borrower_id
                                    ? 'active'
                                    : ''
                            "
                        >
                            <td>{{ borrower.borrower_num }}</td>
                            <td>
                                <span class="text-primary-dark">{{
                                    borrower.firstname + " " + borrower.lastname
                                }}</span>
                            </td>
                            <td>
                                <span
                                    @click="selectedBorrower = borrower"
                                    class="text-green select"
                                    >select</span
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="flex: 20">
                <section class="mb-24" style="flex: 21; padding-left: 16px">
                    <span class="section-title mb-24">Details</span>
                    <div class="d-flex mb-12">
                        <div class="d-flex flex-column mr-16" style="flex: 20">
                            <div class="d-flex flex-row">
                                <div
                                    class="borrower-number d-flex flex-column"
                                    style="flex: 5"
                                >
                                    <span>Borrower's Number</span>
                                    <span class="text-center">{{
                                        selectedBorrower.borrower_num
                                    }}</span>
                                </div>
                                <div style="flex: 4"></div>
                                <!-- <div class="form-group mb-10" style="flex: 5">
									<label for="transactionDate" class="form-label">Transaction Date</label>
									<input type="date" class="form-control form-input text-right" id="transactionDate">
								</div> -->
                            </div>
                            <div class="form-group mb-5" style="flex: 5">
                                <label for="client" class="form-label mb-3"
                                    >Client</label
                                >
                                <input
                                    type="text"
                                    class="form-control form-input"
                                    id="client"
                                    :value="
                                        selectedBorrower.firstname +
                                        ' ' +
                                        selectedBorrower.lastname
                                    "
                                    disabled
                                />
                            </div>
                            <div class="form-group mb-10" style="flex: 5">
                                <label for="address" class="form-label mb-3"
                                    >Address</label
                                >
                                <input
                                    type="text"
                                    class="form-control form-input"
                                    id="address"
                                    disabled
                                    :value="selectedBorrower.address"
                                />
                            </div>
                        </div>
                        <div
                            class="upload-photo d-flex flex-column"
                            style="flex: 4; padding-top: 36px"
                        >
                            <img
                                :src="borrowerPhoto"
                                style="max-width: 200px"
                                alt=""
                            />
                        </div>
                    </div>
                    <div class="sep mb-24"></div>
                </section>

                <section
                    v-if="selectedBorrower.borrower_id"
                    class="mb-24"
                    style="flex: 21; padding-left: 16px"
                >
                    <div
                        class="d-flex justify-content-between align-items-center mb-10"
                    >
                        <span
                            class="section-title section-subtitle flex-2"
                            style="
                                padding: 0;
                                margin: 0;
                                line-height: 1.2;
                                border: none;
                            "
                            >Payment Transactions</span
                        >
                        <input
                            type="text"
                            class="form-control flex-1"
                            id="searchBar"
                            v-model="paymentFilter"
                            placeholder="Search"
                        />
                    </div>
                    <table
                        class="table table-stripped table-hover light-border th-blue"
                    >
                        <thead>
                            <th>Account No.</th>
                            <th>Date Paid</th>
                            <th>O.R.</th>
                            <th>Transaction No.</th>
                            <th>Amount</th>
                        </thead>
                        <tbody>
                            <tr
                                @click="selectedPayment = payment"
                                v-for="payment in filteredPayments"
                                :key="payment.payment_id"
                                :class="
                                    selectedPayment.payment_id ==
                                    payment.payment_id
                                        ? 'active-payment'
                                        : ''
                                "
                            >
                                <td>{{ payment.account.account_num }}</td>
                                <td>
                                    {{
                                        dateToYMD(
                                            new Date(payment.transaction_date)
                                        ).replaceAll("-", "/")
                                    }}
                                </td>
                                <td>{{ payment.or_no }}</td>
                                <td>{{ payment.transaction_number }}</td>
                                <td>
                                    P
                                    {{
                                        formatToCurrency(payment.amount_applied)
                                    }}
                                </td>
                            </tr>
                            <tr v-if="!selectedBorrower.payments.length">
                                <td>No payments yet.</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex flex-column">
                        <span class="text-bold">Remarks</span>
                        <textarea
                            class="form-control mb-16"
                            style="height: 95px"
                            v-model="remarks"
                        ></textarea>
                        <div class="d-flex justify-content-end">
                            <button
                                v-if="selectedPayment.payment_id"
                                class="btn btn-bright-blue btn-wide"
                                data-toggle="modal"
                                data-target="#warningModal"
                            >
                                Cancel - Verify
                            </button>
                            <button
                                v-if="!selectedPayment.payment_id"
                                class="btn btn-bright-blue btn-wide"
                                disabled
                            >
                                Cancel - Verify
                            </button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <day-ended v-else></day-ended>

        <warning-modal
            message="Do you want to cancel this payment?"
            @proceed="cancelPayment"
        ></warning-modal>
    </div>
</template>

<script>
export default {
    props: ["branch", "token"],
    data() {
        return {
            transactionDate: {
                branch_id: this.branch,
                status: 'closed',
                date_end: '',
            },
            searchDate: this.dateToYMD(new Date()),
            accounts: [],
            borrowers: [],
            payments: [],
            selectedPayment: {
                payment_id: null,
            },
            selectedBorrower: {
                borrower_id: null,
                borrower_num: "###########",
                firstname: "",
                middlename: "",
                lastname: "",
                address: "",
                payments: [],
            },
            remarks: "",
            filter: "",
            paymentFilter: "",
        };
    },
    methods: {

        fetchTransactionDate:function(){
            axios.get(this.baseURL() + 'api/eod/eodtransaction/'+this.branch, {
            headers: {
                'Authorization': 'Bearer ' + this.token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(function (response) {
                this.transactionDate = response.data.data;
            }.bind(this))
            .catch(function (error) {
                console.log(error);
            }.bind(this));
        },
        async fetchAccounts() {
            await axios
                .post(
                    this.baseURL() + "api/payment/paymentlist",
                    {
                        transaction_date: this.dateToYMD(
                            new Date(this.searchDate)
                        ),
                        branch_id: this.branch,
                    },
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
                        this.borrowers = this.organizePayments(response.data);
                        this.removePayment();
                    }.bind(this)
                )
                .catch(
                    function (error) {
                        console.log(error);
                    }.bind(this)
                );
        },
        organizePayments: function (payments) {
            var borrowers = [];
            var fborrowers = [];
            payments.forEach((p) => {
                if (
                    !borrowers.includes(p.account.borrower_id) &&
                    p.status != "cancelled"
                ) {
                    borrowers.push(p.account.borrower_id);
                    fborrowers.push(p.account.borrower);
                }
            });
            fborrowers.forEach((fb, i) => {
                fborrowers[i].payments = [];
                payments.forEach((p) => {
                    p.account.borrower_id == fb.borrower_id &&
                    p.status != "cancelled"
                        ? fborrowers[i].payments.push(p)
                        : 0;
                });
            });
            return fborrowers;
        },
        setPayments: function () {
            var payments = [];
            this.selectedBorrower.loan_accounts.map(function (data) {
                data.payments.map(function (payment) {
                    if (payment.status == "paid") {
                        payment.account_no = data.account_num;
                        payments.push(payment);
                    }
                });
            });
            this.payments = payments;
        },
        removePayment: function () {
            if (this.selectedBorrower.borrower_id) {
                let counter = 0;
                this.borrowers.forEach((b) => {
                    if (this.selectedBorrower.borrower_id == b.borrower_id) {
                        this.selectedBorrower = b;
                        counter++;
                    }
                });
                if (counter == 0) {
                    this.selectedBorrower = {
                        borrower_id: null,
                        borrower_num: "###########",
                        firstname: "",
                        middlename: "",
                        lastname: "",
                        address: "",
                        payments: [],
                    };
                }
            }
        },
        preparePayment: function (payment) {
            var data = {
                payment_id: payment.payment_id,
                loan_account_id: payment.loan_account_id,
                branch_id: payment.branch_id,
                payment_type: payment.payment_type,
                or_no: payment.or_no,
                cheque_no: payment.cheque_no,
                bank_name: payment.bank_name,
                reference_no: payment.reference_no,
                memo_type: payment.memo_type,
                amortization_id: payment.amortization_id,
                principal: payment.principal,
                interest: payment.interest,
                short_principal: payment.short_principal,
                advance_principal: payment.advance_principal,
                short_interest: payment.short_interest,
                advance_interest: payment.advance_interest,
                pdi: payment.pdi,
                pdi_approval_no: payment.pdi_approval_no,
                short_pdi: payment.short_pdi,
                penalty: payment.penalty,
                penalty_approval_no: payment.penalty_approval_no,
                short_penalty: payment.short_penalty,
                vat: payment.vat,
                rebates: payment.rebates,
                rebatesInputted: payment.rebatesInputted,
                rebates_approval_no: payment.rebates_approval_no,
                total_payable: payment.total_payable,
                amount_applied: payment.amount_applied,
                amount_paid: payment.amount_paid,
                over_payment: payment.over_payment,
                status: payment.status,
                remarks: payment.remarks,
            };
            return data;
        },
        async cancelPayment() {
            this.selectedPayment.status = "cancelled";
            this.selectedPayment.remarks = this.remarks;
            var payment = this.preparePayment(this.selectedPayment);
            await axios
                .put(
                    this.baseURL() + "api/payment/" + payment.payment_id,
                    payment,
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
                        this.notify(
                            "",
                            "Payment has been cancelled successfully.",
                            "success"
                        );
                        // this.removePayment();
                        this.fetchAccounts();
                    }.bind(this)
                )
                .catch(
                    function (error) {
                        console.log(error);
                    }.bind(this)
                );
            this.remarks = "";
        },
        notify: function (title, text, type) {
            this.$notify({
                group: "foo",
                title: title,
                text: text,
                type: type,
            });
        },
		hasTransactionNumber:function(data){
			var result = false;
			data.payments.forEach(d=>{
				if(d.transaction_number && d.transaction_number.includes(this.filter)){
					result = true;
				}
			})
			return result;
		}
    },
    computed: {
        borrowerPhoto: function () {
            return this.selectedBorrower.photo
                ? this.selectedBorrower.photo
                : this.baseURL() + "/img/user.png";
        },
        filteredBorrowers: function () {
            var borrowers = [];
            if (this.filter.length > 0) {
                this.borrowers.map(
                    function (data) {
                        if (
                            data.borrower_num
                                .toLowerCase()
                                .includes(this.filter.toLowerCase()) ||
                            data.firstname
                                .toLowerCase()
                                .includes(this.filter.toLowerCase()) ||
							this.hasTransactionNumber(data) ||
                            data.lastname
                                .toLowerCase()
                                .includes(this.filter.toLowerCase()) ||
                            (data.firstname + " " + data.lastname)
                                .toLowerCase()
                                .includes(this.filter.toLowerCase()) ||
                            (data.lastname + " " + data.firstname)
                                .toLowerCase()
                                .includes(this.filter.toLowerCase())
                        ) {
                            borrowers.push(data);
                        }
                    }.bind(this)
                );
            } else {
                borrowers = this.borrowers;
            }
            return borrowers;
        },
        filteredPayments: function () {
            if (this.paymentFilter.length > 0) {
                return this.selectedBorrower.payments.filter(
                    (data) =>
                        data.account.account_num.includes(this.paymentFilter) ||
                        (data.transaction_num
                            ? data.transaction_num
                            : ""
                        ).includes(this.paymentFilter) ||
                        (data.or_no ? data.or_no : "").includes(
                            this.paymentFilter
                        )
                );
            }
            return this.selectedBorrower.payments;
        },
    },
    watch: {
        "selectedBorrower.borrower_id": function (newValue) {
            this.selectedPayment = { payment_id: null };
            if (newValue && this.selectedBorrower.loan_accounts) {
                this.setPayments();
                if (this.payments.length == 1) {
                    this.selectedPayment = this.payments[0];
                }
            }
        },
        searchDate: function () {
            this.fetchAccounts();
        },
    },
    mounted() {
        this.fetchAccounts();
        this.fetchTransactionDate();
    },
};
</script>

<style scoped>
.select {
    cursor: pointer;
}
.select:hover {
    color: orangered !important;
}
.active {
    background-color: #78e08f !important;
}
.active-payment {
    background-color: #74b9ff !important;
}
</style>
