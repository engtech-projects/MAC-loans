<template>
    <div class="container-fluid" style="padding: 0 !important">
        <notifications group="foo" />
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
        <div class="mb-16"></div>
        <div
            class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between"
        >
            <h1 class="m-0 font-35">Override Payment</h1>
        </div>
        <div class="d-flex flex-column flex-xl-row p-16">
            <div style="flex: 9">
                <div class="mb-12">
                    <div class="d-flex">
                        <!-- <div class="form-group mr-7 flex-1"> -->
                            <!-- <select class="form-control select2 select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true">
								<option value="">2022/11/11</option>
							</select> -->
                            <!-- <input
                                v-model="preference.transaction_date"
                                type="date"
                                class="form-control"
                                placeholder="Pick a date"
                            /> -->
                        <!-- </div> -->
                        <div class="form-group flex-2 mr-7">
                            <input
                                v-model="preference.specification"
                                type="text"
                                class="form-control"
                                placeholder="Specifications"
                            />
                        </div>
                        <select
                            v-model="preference.filter"
                            name=""
                            id=""
                            class="flex-1 form-control input-sm"
                        >
                            <option value="client">Client</option>
                            <option value="ao">Account Officer</option>
                            <option value="product">Product</option>
                        </select>
                    </div>
                </div>

                <table class="table table-stripped mb-24" id="clientsList">
                    <thead>
                        <th>
                            <div class="row">
                                <div class="col-md-6">
                                    <input
                                    v-model="selectAll"
                                    type="checkbox"
                                    class="form-control form-box"
                                    @click="selectAllRows()"
                                />
                                </div>
                                <div class="col-md-4">
                                    All
                                </div>
                            </div>

                        </th>
                        <th>Account #</th>
                        <th>Client Name</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr
                            v-for="p in paginate"
                            :key="p.payment_id"
                            class="client-item"
                            :class="
                                payment.payment_id == p.payment_id
                                    ? 'active'
                                    : ''
                            "
                        >
                            <td style="vertical-align: middle">
                                <input
                                    v-model="p.checked"
                                    type="checkbox"
                                    class="form-control form-box"
                                    @click="selectRow"
                                />
                            </td>
                            <td>{{ p.loan_details.account_num }}</td>
                            <td class="relative">
                                <a href="#" class="mr-5">{{
                                    p.loan_details.borrower.firstname +
                                    " " +
                                    p.loan_details.borrower.lastname
                                }}</a>

                                <i
                                    v-if="!canOverride([p])"
                                    class="fa fa-exclamation-circle text-red relative overrideTooltip"
                                >
								 <span
                                    v-if="!canOverride([p])"
                                    style="
                                        position: absolute;
                                        top: 0;
										min-width:140px;
                                        padding: 5px 7px;
                                        color: #fff;
                                        background-color: #222;
										font-size:11px;
										line-height:1.3;
										font-family:'sans-serif';
										border:1px solid #222;
										border-radius:7px!important;
										display:none;
										z-index:99999;
                                    "
                                    >Reference account is still subject for approval.</span
                                >
								</i>
                            </td>
                            <td @click="payment = p">
                                <span class="text-green c-pointer">select</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
				<!-- <div v-if="filterClient.length > pagination.range" class="d-flex justify-content-end mb-24">
					<div class="d-flex pagination pagination-mini">
						<span @click="pagination.page=i" :class="i==pagination.page?'active':''" v-for="i in Math.ceil(filterClient.length/pagination.range)" :key="i">{{i}}</span>
					</div>
				</div> -->
				<mac-pagination @setpage="setPage" :pdata="filterClient" :ppage="pagination.page" :prange="pagination.range" class="mb-24"></mac-pagination>
                <div
                    class="d-flex flex-row-reverse sep-thin pb-10 mb-16"
                    style="border-bottom-color: #ccc !important"
                >
                    <a
                        href="#"
                        v-if="boverrideCheck"
                        data-toggle="modal"
                        data-target="#warningModal"
                        class="btn btn-success"
                        >Batch Override</a
                    >
					 <button
                        href="#"
                        v-if="!boverrideCheck"
                        disabled
                        class="btn btn-success"
                        >Batch Override</button
                    >
                    <a
                        href="#"
                        data-toggle="modal"
                        data-target="#overrideDetailsModal"
                        class="btn btn-primary min-w-150 mr-16"
                        >View</a
                    >
                </div>
                <section class="light-bb mb-16">
                    <div class="d-flex flex-column mb-16">
                        <div class="d-flex flex-row mb-12">
                            <div
                                class="d-flex flex-row flex-2 justify-content-between pr-24"
                            >
                                <span class="">Unselected</span>
                                <span>:</span>
                            </div>
                            <span class="flex-3 text-primary-dark"
                                >P {{ formatToCurrency(unselected) }}</span
                            >
                        </div>
                        <div class="d-flex flex-row mb-12">
                            <div
                                class="d-flex flex-row flex-2 justify-content-between pr-24"
                            >
                                <span class="">Selected</span>
                                <span>:</span>
                            </div>
                            <span class="flex-3 text-primary-dark"
                                >P {{ formatToCurrency(selected) }}</span
                            >
                        </div>
                        <div class="d-flex flex-row mb-12">
                            <div
                                class="d-flex flex-row flex-2 justify-content-between pr-24"
                            >
                                <span class="">TOTAL</span>
                                <span>:</span>
                            </div>
                            <span class="flex-3 text-primary-dark"
                                >P {{ formatToCurrency(totalSelect) }}</span
                            >
                        </div>
                    </div>
                </section>
                <section>
                    <h4 class="section-title section-subtitle b-none">
                        Payment Summary
                    </h4>
                    <div class="d-flex flex-column mb-16">
                        <div class="d-flex flex-row mb-12">
                            <div
                                class="d-flex flex-row flex-2 justify-content-between pr-24"
                            >
                                <span class="">Total Cash</span>
                                <span>:</span>
                            </div>
                            <span class="flex-3 text-primary-dark"
                                >P {{ formatToCurrency(totalCash) }}</span
                            >
                        </div>
                        <div class="d-flex flex-row mb-12">
                            <div
                                class="d-flex flex-row flex-2 justify-content-between pr-24"
                            >
                                <span class="">Total Check</span>
                                <span>:</span>
                            </div>
                            <span class="flex-3 text-primary-dark"
                                >P {{ formatToCurrency(totalCheck) }}</span
                            >
                        </div>
                        <div class="d-flex flex-row mb-12">
                            <div
                                class="d-flex flex-row flex-2 justify-content-between pr-24"
                            >
                                <span class="">Total Memo Payment</span>
                                <span>:</span>
                            </div>
                            <span class="flex-3 text-primary-dark"
                                >P {{ formatToCurrency(totalMemo) }}</span
                            >
                        </div>
                        <div class="d-flex flex-row mb-12">
                            <div
                                class="d-flex flex-row flex-2 justify-content-between pr-24"
                            >
                                <span class="pl-24">Deduct to balance</span>
                                <span>:</span>
                            </div>
                            <span class="flex-3 text-primary-dark"
                                >P
                                {{
                                    formatToCurrency(totalDeductToBalance)
                                }}</span
                            >
                        </div>
                        <div class="d-flex flex-row mb-12">
                            <div
                                class="d-flex flex-row flex-2 justify-content-between pr-24"
                            >
                                <span class="pl-24">Interbranch</span>
                                <span>:</span>
                            </div>
                            <span class="flex-3 text-primary-dark"
                                >P
                                {{ formatToCurrency(totalInterBranch) }}</span
                            >
                        </div>
                        <div class="d-flex flex-row mb-12">
                            <div
                                class="d-flex flex-row flex-2 justify-content-between pr-24"
                            >
                                <span class="pl-24">Offset P.F</span>
                                <span>:</span>
                            </div>
                            <span class="flex-3 text-primary-dark"
                                >P {{ formatToCurrency(totalOffset) }}</span
                            >
                        </div>
                        <div class="d-flex flex-row mb-12">
                            <div
                                class="d-flex flex-row flex-2 justify-content-between pr-24"
                            >
                                <span class="pl-24">Rebates & Disc</span>
                                <span>:</span>
                            </div>
                            <span class="flex-3 text-primary-dark"
                                >P
                                {{
                                    formatToCurrency(totalRebates)
                                }}</span
                            >
                        </div>
                        <div class="d-flex flex-row mb-12">
                            <div
                                class="d-flex flex-row flex-2 justify-content-between pr-24"
                            >
                                <span class="">Total POS</span>
                                <span>:</span>
                            </div>
                            <span class="flex-3 text-primary-dark"
                                >P {{ formatToCurrency(totalPOS) }}</span
                            >
                        </div>
                    </div>
                    <div class="d-flex flex-column button-text">
                        <span>TOTAL PAYMENT FOR TODAY</span>
                        <div class="d-flex flex-row">
                            <span>P</span>
                            <span>{{ formatToCurrency(totalPayment) }}</span>
                        </div>
                    </div>
                </section>
            </div>
            <overridepayment-details
                :ppayment="payment"
                :token="token"
                @reloadPayments="reloadPayments"
				:candelete="candelete"
                :transactionDate="transactionDate"
            ></overridepayment-details>
        </div>
        <overridepayment-view
            :pbranch="pbranch"
            :ppayments="paymentsBase"
            :transactionDate="transactionDate"
        ></overridepayment-view>

        <div class="modal" id="warningModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body p-24">
                        <div class="d-flex align-items-center">
                            <img
                                :src="baseURL() + '/img/warning.png'"
                                style="width: 120px; height: auto"
                                class="mr-24"
                                alt="warning icon"
                            />
                            <div class="d-flex flex-column">
                                <span class="text-primary-dark text-bold mb-24">
                                    Are you sure you want to override these
                                    payments?
                                </span>
                                <div
                                    class="d-flex mt-auto justify-content-between"
                                >
                                    <a
                                        href="#"
                                        data-dismiss="modal"
                                        class="btn btn-danger min-w-120"
                                        >Cancel</a
                                    >
                                    <a
                                        @click.prevent="batchOverride()"
                                        href="#"
                                        data-dismiss="modal"
                                        class="btn btn-primary-dark min-w-120"
                                        >Proceed</a
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["token", "pbranch", "candelete"],
    data() {
        return {
            selectAll:false,
			loading:false,
			pagination:{
				page: 1,
				range: 10
			},
			transactionDate: {
				branch_id: this.pbranch,
				status: 'closed',
				date_end: '',
			},
            paidPayments: [],
            payments: [],
            paymentsClone: [],
            paymentsBase: [],
            preference: {
                transaction_date: '',
                specification: "",
                filter: "client",
            },
            dates: [],
            payment: {
                payment_id: null,
                borrower_num: "##############",
                firstname: "",
                lastname: "",
                address: "",
                loan_details: {
                    borrower: {
                        borrower_num: "##############",
                        firstname: "",
                        lastname: "",
                        address: "",
                    },
                },
            },
        };
    },
    methods: {
        selectAllRows() {
            if(!this.selectAll) {
                this.selectAll = true
                this.allSelected = true
            }else {
                this.allSelected = false
            }
            this.allSelected = this.selectAll;

        },
        selectRow() {
            /* this.selectAll = this.allSelected; */



        },
		setPage:function(page){
			this.pagination.page = page;
		},
		fetchTransactionDate:function(){
			axios.get(this.baseURL() + 'api/eod/eodtransaction/'+this.pbranch, {
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
        async openPayments() {
			this.loading = true;
            this.preference.transaction_date = this.transactionDate.date_end;
            var data = this.preference;
            data.branch_id = this.pbranch;
            await axios
                .post(this.baseURL() + "transaction/payments/open", data, {
                    headers: {
                        Authorization: "Bearer " + this.token,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                })
                .then(
                    function (response) {
						this.loading = false;
                        this.payments = this.setCheckbox(
                            response.data.payments
                        );
                        this.paymentsBase = response.data.base;
                    }.bind(this)
                )
                .catch(
                    function (error) {
						this.loading = false;
                        console.log(error);
                    }.bind(this)
                );
        },
        async todaysPaidPayments() {
            this.preference.transaction_date = this.transactionDate.date_end;
            await axios
                .post(
                    this.baseURL() + "transaction/payments/paidtoday",
                    this.preference,
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
                        this.paidPayments = response.data;
                    }.bind(this)
                )
                .catch(
                    function (error) {
                        console.log(error);
                    }.bind(this)
                );
        },
        resetPayment: function () {
            this.payment = {
                payment_id: null,
                borrower_num: "##############",
                firstname: "",
                lastname: "",
                address: "",
                loan_details: {
                    borrower: {
                        borrower_num: "##############",
                        firstname: "",
                        lastname: "",
                        address: "",
                    },
                },
            };
        },
        fetchPayments: function () {
            this.preference.transaction_date = this.transactionDate.date_end;
			this.loading = true;
            axios
                .post(this.baseURL() + "api/payment/list", this.preference, {
                    headers: {
                        Authorization: "Bearer " + this.token,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                })
                .then(
                    function (response) {
                        // this.payments = this.setCheckbox(response.data.data);
                        // console.log(response.data);
                    }.bind(this)
                )
                .catch(
                    function (error) {
                        console.log(error);
                    }.bind(this)
                );
        },
        overridePaymentDates: function () {
            axios
                .get(this.baseURL() + "transaction/overridepaymentdates")
                .then(
                    function (response) {
                        this.dates = response.data;
                    }.bind(this)
                )
                .catch(
                    function (error) {
                        console.log(error);
                    }.bind(this)
                );
        },
        setCheckbox: function (data) {
            for (let i in data) {
                data[i].checked = false;
            }
            return data;
        },
        canOverride: function (payment) {
            var result = true;
            payment.forEach((data) => {
                if (data.reference && data.reference.status == "pending") {
                    result = false;
                    return;
                }
            });
            return result;
        },
        batchOverride: function () {
            let checkedPayments = [];
            this.paymentsClone = JSON.parse(JSON.stringify(this.payments));
            this.payments.map(
                function (payment) {
                    if (payment.checked) {
                        checkedPayments.push(payment);
                    }
                }.bind(this)
            );
            axios
                .post(
                    this.baseURL() + "api/payment/override",
                    checkedPayments,
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
                        console.log(response.data);
                        this.notify("", response.data.data, "success");
                        this.openPayments();
                        this.resetPayment();
                        this.todaysPaidPayments();
                    }.bind(this)
                )
                .catch(
                    function (error) {
                        console.log(error);
                    }.bind(this)
                );
        },
        notify: function (title, text, type) {
            this.$notify({
                group: "foo",
                title: title,
                text: text,
                type: type,
            });
        },
        reloadPayments: function () {
            this.openPayments();
            this.resetPayment();
            this.todaysPaidPayments();
        },
    },
    computed: {
        allSelected: {
            get() {
                return this.paginate.every((row) => row.checked);
            },
            set(value) {
                this.selectAll = value;
                this.paginate.forEach((row) => (row.checked = value));
            }
        },
        boverrideCheck: function () {
			var pps = [];
            this.payments.map(
                function (data) {
                    if (data.checked) {
						pps.push(data);
                    }
                }.bind(this)
            );
            return this.canOverride(pps) && pps.length > 1;
        },
        selected: function () {
            var amount = 0;
            this.payments.map(function (payment) {
                if (payment.checked) {
                    amount += payment.amount_applied;
                }
            });
            return amount;
        },
        unselected: function () {
            var amount = 0;
            this.payments.map(function (payment) {
                if (!payment.checked) {
                    amount += payment.amount_applied;
                }
            });
            return amount;
        },
        totalSelect: function () {
            return this.selected + this.unselected;
        },
        totalCash: function () {
            var amount = 0;
            this.paidPayments.map(function (payment) {
                if (payment.payment_type == "Cash Payment") {
                    amount += payment.amount_applied - payment.rebates;
                }
            });
            return amount;
        },
        totalCheck: function () {
            var amount = 0;
            this.paidPayments.map(function (payment) {
                if (payment.payment_type == "Check Payment") {
                    amount += payment.amount_applied - payment.rebates;
                }
            });
            return amount;
        },
        totalRebates: function () {
            var amount = 0;
            this.paidPayments.map(function (payment) {
                // if (payment.payment_type == "Memo") {
                    amount += payment.rebates;
                // }
            });
            return amount;
        },
        totalMemo: function () {
            var amount = 0;
            this.paidPayments.map(function (payment) {
                if (payment.payment_type == "Memo") {
                    amount += payment.amount_applied - payment.rebates;
                }
            });
            return amount;
        },
        totalPOS: function () {
            var amount = 0;
            this.paidPayments.map(function (payment) {
                if (payment.payment_type == "POS") {
                    amount += payment.amount_applied - payment.rebates;
                }
            });
            return amount;
        },
        totalOffset: function () {
            var amount = 0;
            this.paidPayments.map(function (payment) {
                if (payment.memo_type == "Offset PF") {
                    amount += payment.amount_applied  - payment.rebates;
                }
            });
            return amount;
        },
        totalDeductToBalance: function () {
            var amount = 0;
            this.paidPayments.map(function (payment) {
                if (payment.memo_type == "deduct to balance") {
                    amount += payment.amount_applied - payment.rebates;
                }
            });
            return amount;
        },
        totalInterBranch: function () {
            var amount = 0;
            this.paidPayments.map(function (payment) {
                if (payment.memo_type == "Interbranch") {
                    amount += payment.amount_applied - payment.rebates;
                }
            });
            return amount;
        },
        totalRebatesDiscount: function () {
            var amount = 0;
            this.paidPayments.map(function (payment) {
                if (payment.memo_type == "Rebates and Discount") {
                    amount += payment.amount_applied;
                }
            });
            return amount;
        },
        totalPayment: function () {
            return (
                this.totalCash +
                this.totalCheck +
                this.totalPOS +
                this.totalMemo
            );
        },
        totalPrincipal: function () {
            var amount = 0;
            this.payments.map(function (payment) {
                amount += payment.principal;
            });
            return amount;
        },
        totalInterest: function () {
            var amount = 0;
            this.payments.map(function (payment) {
                amount += payment.interest;
            });
            return amount;
        },
        totalPDI: function () {
            var amount = 0;
            this.payments.map(function (payment) {
                amount += payment.pdi;
            });
            return amount;
        },
        totalDiscount: function () {
            var amount = 0;
            this.payments.map(function (payment) {
                amount += payment.rebates;
            });
            return amount;
        },
        filterClient: function () {
			this.pagination.page = 1;
            var result = [];
            if (this.preference.transaction_date != "") {
                this.payments.map(
                    function (val) {
                        if ( this.dateToYMD(new Date(val.transaction_date)) == this.dateToYMD(new Date(this.preference.transaction_date)) ) {
                            if (this.preference.specification == "") {
                                result.push(val);
                                return;
                            } else {
                                if (this.preference.filter == "client") {
                                    if (
                                        val.loan_details.account_num
                                            .toLowerCase()
                                            .includes(
                                                this.preference.specification.toLowerCase()
                                            ) ||
                                        val.loan_details.borrower.firstname
                                            .toLowerCase()
                                            .includes(
                                                this.preference.specification.toLowerCase()
                                            ) ||
                                        val.loan_details.borrower.lastname
                                            .toLowerCase()
                                            .includes(
                                                this.preference.specification.toLowerCase()
                                            ) ||
                                        (
                                            val.loan_details.borrower
                                                .firstname +
                                            " " +
                                            val.loan_details.borrower.lastname
                                        )
                                            .toLowerCase()
                                            .includes(
                                                this.preference.specification.toLowerCase()
                                            ) ||
                                        (
                                            val.loan_details.borrower.lastname +
                                            " " +
                                            val.loan_details.borrower.firstname
                                        )
                                            .toLowerCase()
                                            .includes(
                                                this.preference.specification.toLowerCase()
                                            )
                                    ) {
                                        result.push(val);
                                        return;
                                    }
                                }
                                if (
                                    this.preference.filter == "ao" &&
                                    val.loan_details.account_officer
                                ) {
                                    if (
                                        val.loan_details.account_officer.name
                                            .toLowerCase()
                                            .includes(
                                                this.preference.specification.toLowerCase()
                                            )
                                    ) {
                                        result.push(val);
                                        return;
                                    }
                                }
                                if (
                                    this.preference.filter == "product" &&
                                    val.loan_details.product
                                ) {
                                    if (
                                        val.loan_details.product.product_name
                                            .toLowerCase()
                                            .includes(
                                                this.preference.specification.toLowerCase()
                                            )
                                    ) {
                                        result.push(val);
                                        return;
                                    }
                                }
                            }
                        }
                    }.bind(this)
                );
            }
            return result;
        },
        newList() {
            var result = []
            for(let i in this.paginate) {
                if(this.isAll) {
                    this.paginate[i].checked = true
                }
                result.push(this.paginate[i])
            }
            return result
        },
		paginate:function(){
			var result = [];
			var start = (this.pagination.page - 1) * this.pagination.range;
			var end = 0;
			for(var i = start; i < this.filterClient.length; i++){
				if(end < this.pagination.range){
					result.push(this.filterClient[i]);
                    /* if(this.selectAll) {
                        result[i].checked = true

                    }else {
                        result[i].checked = false
                    } */
				}
				end++;
			}





			return result;
		},
    },
    watch: {
        paginate:{
            handler() {
                this.selectAll = this.allSelected
            }
        },
        deep:true,
        allSelected(value) {
            this.selectAll = value
        },

        "transactionDate": function (newValue) {
            this.fetchPayments();
            this.openPayments(this.preference);
            this.todaysPaidPayments();
        },
        "preference": function (newValue) {
            this.fetchPayments();
            this.openPayments(this.preference);
        },
    },
    async mounted() {

        await this.fetchTransactionDate();
    },
};
</script>

<style scoped>
	.overrideTooltip {
		cursor:pointer;
	}
	.overrideTooltip:hover span{
		display:block!important;
	}
</style>
