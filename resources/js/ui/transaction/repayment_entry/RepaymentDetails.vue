<template>
    <div style="flex: 20">
        <notifications group="foo" />
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
                                pborrower.borrower_num
                            }}</span>
                        </div>
                        <div style="flex: 4"></div>
                        <div class="form-group mb-10" style="flex: 5">
                            <!-- <label for="transactionDate" class="form-label">Transaction Date</label>
							<input type="date" class="form-control form-input text-right" id="transactionDate"> -->
                        </div>
                    </div>
                    <div class="form-group mb-5" style="flex: 5">
                        <label for="client" class="form-label mb-3"
                            >Client</label
                        >
                        <input
                            disabled
                            :value="
                                pborrower.borrower_id
                                    ? pborrower.firstname +
                                      ' ' +
                                      pborrower.lastname +
                                      ' ' +
                                      pborrower.middlename.charAt(0) +
                                      '.'
                                    : ''
                            "
                            type="text"
                            class="form-control form-input"
                            id="client"
                        />
                    </div>
                    <div class="form-group mb-10" style="flex: 5">
                        <label for="address" class="form-label mb-3"
                            >Address</label
                        >
                        <input
                            disabled
                            :value="pborrower.address"
                            type="text"
                            class="form-control form-input"
                            id="address"
                        />
                    </div>
                </div>
                <div
                    class="upload-photo d-flex flex-column"
                    style="flex: 4; padding-top: 36px"
                >
                    <img :src="borrowerPhoto" alt="" style="max-width: 230px" />
                </div>
            </div>
            <div class="sep mb-24"></div>
        </section>

        <section
            v-if="pborrower.borrower_id"
            class="mb-36"
            style="flex: 21; padding-left: 16px"
        >
            <span class="section-title section-subtitle mb-12"
                >Select Loan Accounts Payable</span
            >
            <div class="p-10 light-border mb-24">
                <table
                    class="table table-stripped m-0 th-nbt th-blue table-hover"
                >
                    <thead>
                        <th class="text-primary-dark">Account Number</th>
                        <th class="text-primary-dark">Date Transaction</th>
                        <th class="text-primary-dark">Balance</th>
                    </thead>
                    <tbody>
                        <tr
                            v-for="account in unpaidLoanAccounts"
                            @click="amortSched(account)"
                            :key="account.loan_account_id"
                            :class="isActive(account.loan_account_id)"
                        >
                            <td>{{ account.account_num }}</td>
                            <td>
                                {{ dateToMDY(new Date(account.date_release)) }}
                            </td>
                            <td>
                                P
                                {{
                                    formatToCurrency(
                                        account.remainingBalance.memo.balance
                                            ? account.remainingBalance.memo
                                                  .balance
                                            : 0
                                    )
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="sep"></div>
        </section>

        <section
            v-if="loanAccount.loan_account_id"
            class="mb-24"
            style="flex: 21; padding-left: 16px"
        >
            <div
                class="d-flex flex-row justify-content-between align-items-center section-title pb-12 mb-24"
            >
                <span class="section-title section-subtitle b-none p-0"
                    >Loan Details</span
                >
            </div>
            <div class="d-flex flex-row">
                <div class="d-flex flex-column flex-1 mr-45">
                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Account Number</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{
                            loanAccount.account_num
                        }}</span>
                    </div>

                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Co Borrower</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{
                            loanAccount.co_borrower_name
                        }}</span>
                    </div>

                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Address</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{
                            loanAccount.co_borrower_address
                        }}</span>
                    </div>

                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Co Maker</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{
                            loanAccount.co_maker_name
                        }}</span>
                    </div>

                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Address</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{
                            loanAccount.co_maker_address
                        }}</span>
                    </div>

                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Contact No.</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{
                            pborrower.contact_number
                        }}</span>
                    </div>

                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Date Release</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{
                            dateToMDY(new Date(loanAccount.date_release))
                        }}</span>
                    </div>

                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Product Name</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{
                            loanAccount.product.product_name
                        }}</span>
                    </div>

                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Missed Payments</span>
                            <span>:</span>
                        </div>

                        <span class="flex-2 text-primary-dark">{{
                            loanAccount.current_amortization.delinquent
                                ? loanAccount.current_amortization.delinquent
                                      .missed.length
                                : 0
                        }}</span>
                    </div>

                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Type</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{
                            loanAccount.type
                        }}</span>
                    </div>

                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Cycle</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{
                            loanAccount.cycle_no
                        }}</span>
                    </div>
                </div>
                <div class="d-flex flex-column flex-1">
                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Last Transaction</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{
                            lastTransactionDate
                        }}</span>
                    </div>
                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Loan Amount</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{
                            formatToCurrency(loanAccount.loan_amount)
                        }}</span>
                    </div>
                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Interest</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{
                            formatToCurrency(loanAccount.interest_amount)
                        }}</span>
                    </div>
                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Due Date</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{
                            dateToMDY(new Date(loanAccount.due_date))
                        }}</span>
                    </div>
                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Mode</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{
                            loanAccount.payment_mode
                        }}</span>
                    </div>
                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Amortization</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark">{{loanAccount.type == "Prepaid"? formatToCurrency(Math.ceil(loanAccount.loan_amount/loanAccount.no_of_installment)) : formatToCurrency(Math.ceil(loanAccount.interest_amount/loanAccount.no_of_installment) + Math.ceil(loanAccount.loan_amount/loanAccount.no_of_installment))}}
                        </span>
                    </div>
                    <!-- <div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Int. Rate</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.interest_rate}}%</span>
					</div> -->
                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Rate</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark"
                            >{{ loanAccount.interest_rate }}%</span
                        >
                    </div>
                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Term</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2 text-primary-dark"
                            >{{ loanAccount.terms }} Days</span
                        >
                    </div>
                    <div class="d-flex flex-row mb-12">
                        <div
                            class="d-flex flex-row flex-1 justify-content-between pr-24"
                        >
                            <span class="">Status</span>
                            <span>:</span>
                        </div>
                        <span class="flex-2" :class="loanAccountStatusColor">{{
                            loanAccountStatus
                        }}</span>
                    </div>
                </div>
            </div>
        </section>
        <div class="flex-1 d-flex flex-row-reverse align-items-end">
            <button
                 @click="loadAccount(loanAccount.loan_account_id)"
                v-if="loanAccount.loan_account_id"
                class="btn btn-bright-blue min-w-150 mb-5"
            >
                Pay
            </button>
            <button
            id="paymentBtn"
                v-if="loanAccount.loan_account_id"
                data-toggle="modal"
                data-target="#paymentModal"
                class="btn btn-bright-blue min-w-150 mb-5 hide"
            >
                Pay
            </button>
        </div>

        <div
            class="modal"
            id="paymentModal"
            tabindex="-1"
            role="dialog"
        >
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form @submit.prevent="pay()">
                            <section
                                class="mb-24 p-16"
                                style="flex: 21; padding-left: 16px"
                            >
                                <span class="section-title mb-12">Payment</span>
                                <div class="d-flex flex-column flex-lg-row">
                                    <div class="form-group mb-10 mr-16 flex-1">
                                        <label
                                            for="transactionDate"
                                            class="form-label"
                                            >Payment Type</label
                                        >
                                        <div class="form-group">
                                            <select
                                                required
                                                class="form-control form-input"
                                                v-model="payment.payment_type"
                                            >
                                                <option
                                                    v-for="(
                                                        r, i
                                                    ) in rpaymentType"
                                                    :value="r"
                                                    :key="i"
                                                >
                                                    {{ r }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div
                                        class="form-group mb-10 mr-16 flex-1"
                                        v-if="payment.payment_type != 'Memo'"
                                    >
                                        <label
                                            for="transactionDate"
                                            class="form-label"
                                            >OR #</label
                                        >
                                        <input
                                            required
                                            v-model="payment.or_no"
                                            type="text"
                                            class="form-control form-input"
                                            id="transactionDate"
                                        />
                                    </div>
                                    <div
                                        class="flex-2"
                                        v-if="
                                            payment.payment_type ==
                                            'Cash Payment'
                                        "
                                    ></div>
                                    <div
                                        class="form-group mb-10 mr-16 flex-1"
                                        v-if="payment.payment_type == 'POS'"
                                    >
                                        <label
                                            for="transactionDate"
                                            class="form-label"
                                            >Reference #</label
                                        >
                                        <input
                                            required
                                            v-model="payment.reference_no"
                                            type="text"
                                            class="form-control form-input"
                                            id="transactionDate"
                                        />
                                    </div>
                                    <div
                                        class="form-group mb-10 mr-16 flex-1"
                                        v-if="
                                            payment.payment_type ==
                                            'Check Payment'
                                        "
                                    >
                                        <label
                                            for="transactionDate"
                                            class="form-label"
                                            >Cheque #</label
                                        >
                                        <input
                                            required
                                            v-model="payment.cheque_no"
                                            type="text"
                                            class="form-control form-input"
                                            id="transactionDate"
                                        />
                                    </div>
                                    <!-- <div class="form-group mb-10 flex-1" v-if="payment.payment_type=='pos'">
									<label for="transactionDate" class="form-label">Bank Name</label>
									<select required class="form-control form-input">
										<option value="">Land Bank</option>
										<option value="">PNB</option>
										<option value="">BDO</option>
									</select>
								</div> -->
                                    <div
                                        class="form-group mb-10 mr-16 flex-1"
                                        v-if="
                                            payment.payment_type ==
                                                'Check Payment' ||
                                            payment.payment_type == 'POS'
                                        "
                                    >
                                        <label
                                            for="transactionDate"
                                            class="form-label"
                                            >Bank Name</label
                                        >
                                        <div class="form-group">
                                            <input
                                                @blur="addAnotherBank"
                                                v-if="chequeAdd"
                                                type="text"
                                                v-model="payment.bank_name"
                                                class="form-control form-input"
                                            />
                                            <div
                                                class="d-flex"
                                                v-if="!chequeAdd"
                                            >
                                                <select
                                                    required
                                                    v-model="payment.bank_name"
                                                    class="form-control form-input"
                                                >
                                                    <option
                                                        v-for="(b, i) in banks"
                                                        :key="i"
                                                        :value="b"
                                                    >
                                                        {{ b }}
                                                    </option>
                                                    <!-- <option value="Land Bank">Land Bank</option>
												<option value="PNB">PNB</option>
												<option value="BDO">BDO</option> -->
                                                </select>
                                                <a
                                                    @click.prevent="
                                                        chequeAdd = true
                                                    "
                                                    href="#"
                                                    class="btn btn-defualt form-input"
                                                    ><i class="fa fa-plus"></i
                                                ></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="form-group mb-10 flex-1 mr-16"
                                        v-if="payment.payment_type == 'Memo'"
                                    >
                                        <label
                                            for="transactionDate"
                                            class="form-label"
                                            >Memo Reference #</label
                                        >
                                        <input
                                            required
                                            v-model="payment.reference_no"
                                            type="text"
                                            class="form-control form-input"
                                            id="transactionDate"
                                        />
                                    </div>
                                    <div
                                        class="form-group mb-10 mr-16 flex-1"
                                        v-if="payment.payment_type == 'Memo'"
                                    >
                                        <label
                                            for="transactionDate"
                                            class="form-label"
                                            >Type</label
                                        >
                                        <div class="form-group">
                                            <select
                                                required
                                                v-model="payment.memo_type"
                                                class="form-control form-input"
                                            >
                                                <option value="Interbranch">
                                                    Interbranch
                                                </option>
                                                <option value="Offset PF">
                                                    Offset PF
                                                </option>
                                                <option
                                                    value="Rebates and Discount"
                                                >
                                                    Rebates and Discount
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div
                                        class="form-group mb-10 flex-1 mr-16"
                                        v-if="
                                            payment.payment_type == 'Memo' &&
                                            payment.memo_type == 'Interbranch'
                                        "
                                    >
                                        <label
                                            for="transactionDate"
                                            class="form-label"
                                            >OR</label
                                        >
                                        <input
                                            required
                                            v-model="payment.or_no"
                                            type="text"
                                            class="form-control form-input"
                                            id="transactionDate"
                                        />
                                    </div>
                                    <div
                                        class="flex-1"
                                        v-if="
                                            payment.payment_type == 'Memo' &&
                                            payment.memo_type != 'Interbranch'
                                        "
                                    ></div>
                                </div>
                                <div class="d-flex flex-row mb-24">
                                    <div class="form-group mb-0 flex-2 mr-24">
                                        <label
                                            for="transactionDate"
                                            class="form-label mb-5"
                                            >Amount</label
                                        >
                                        <div
                                            class="d-flex flex-column flex-lg-row align-items-center justify-content-between"
                                        >
                                            <div
                                                class="d-flex align-items-center"
                                            >
                                                <span
                                                    class="text-bold mr-10"
                                                    style="
                                                        font-size: 60px;
                                                        color: #263f52;
                                                        line-height: 1;
                                                    "
                                                    >P</span
                                                >
                                                <input
                                                    @blur="
                                                        payment.amount_paid =
                                                            payment.amount_paid ==
                                                            ''
                                                                ? 0
                                                                : payment.amount_paid;
                                                        distribute();
                                                    "
                                                    required
                                                    v-model="
                                                        payment.amount_paid
                                                    "
                                                    type="number"
                                                    class="form-control form-input mw-250"
                                                    id="transactionDate"
                                                    step=".01"
													:disabled="payment.payment_type=='Memo'&&payment.memo_type=='Rebates and Discount'"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-column flex-1 mr-16"
                                    >
                                        <span
                                            class="font-20 text-primary-dark lh-1 mb-3"
                                            >Waive</span
                                        >
                                        <div
                                            class="d-flex flex-row align-items-center mb-3"
                                        >
                                            <input
                                                v-model="waive.pdi"
                                                type="checkbox"
                                                class="form-check-input"
                                                style="margin: 0"
                                            />
                                            <span
                                                class="ml-18 text-primary-dark text-24 lh-1"
                                                >PDI</span
                                            >
                                        </div>
                                        <input
                                            :disabled="disabled(waive.pdi)"
                                            :required="required(waive.pdi)"
                                            v-model="payment.pdi_approval_no"
                                            type="text"
                                            class="form-control"
                                            placeholder="Approval #"
                                        />
                                    </div>
                                    <div
                                        class="d-flex flex-column flex-1 mr-16"
                                    >
                                        <span
                                            class="font-20 text-primary-dark lh-1 invis mb-3"
                                            >l</span
                                        >
                                        <div
                                            class="d-flex flex-row align-items-center mb-3"
                                        >
                                            <input
                                                v-model="waive.penalty"
                                                type="checkbox"
                                                class="form-check-input"
                                                style="margin: 0"
                                            />
                                            <span
                                                class="ml-18 text-primary-dark text-24 lh-1"
                                                >Penalty</span
                                            >
                                        </div>
                                        <input
                                            :disabled="disabled(waive.penalty)"
                                            :required="required(waive.penalty)"
                                            v-model="
                                                payment.penalty_approval_no
                                            "
                                            type="text"
                                            class="form-control"
                                            placeholder="Approval #"
                                        />
                                    </div>
                                    <div
                                        class="d-flex flex-column flex-1 mr-16"
                                    >
                                        <span
                                            class="font-20 text-primary-dark lh-1 invis mb-3"
                                            >l</span
                                        >
                                        <div
                                            class="d-flex flex-row align-items-center mb-3"
                                        >
                                            <input
                                                v-model="waive.rebates"
                                                type="checkbox"
                                                class="form-check-input"
                                                style="margin: 0"
                                            />
                                            <span
                                                class="ml-18 text-primary-dark text-24 lh-1"
                                                >Rebates</span
                                            >
                                        </div>
                                        <input
                                            :disabled="disabled(waive.rebates)"
                                            :required="required(waive.rebates)"
                                            v-model="
                                                payment.rebates_approval_no
                                            "
                                            type="text"
                                            class="form-control"
                                            placeholder="Approval #"
                                        />
                                    </div>
                                    <div
                                        class="d-flex flex-column flex-1 mr-24"
                                    >
                                        <span
                                            class="font-20 text-primary-dark lh-1 invis mb-3"
                                            >l</span
                                        >
                                        <div
                                            class="d-flex flex-row align-items-center mb-3 invis"
                                        >
                                            <input
                                                type="checkbox"
                                                class="form-check-input"
                                                style="margin: 0"
                                            />
                                            <span
                                                class="ml-18 text-primary-dark text-24 lh-1"
                                                >Rebates</span
                                            >
                                        </div>
                                        <input
                                            @focusout="distribute()"
                                            :disabled="disabled(waive.rebates)"
                                            :required="required(waive.rebates)"
                                            v-model="payment.rebatesInputted"
                                            type="number"
                                            class="form-control"
                                            placeholder="Amount"
                                        />
                                    </div>
                                    <div
                                        class="flex-1 d-flex flex-row-reverse align-items-end"
                                    >
                                        <input
                                            type="submit"
                                            class="btn btn-bright-blue min-w-150 mb-5"
                                            value="Pay"
                                        />
                                    </div>
                                </div>
                                <div class="sep-dark mb-10"></div>
                                <section class="mb-24">
                                    <span
                                        class="py-12 darker-bb text-primary-dark text-24 text-bold text-block mb-10"
                                        >Preview</span
                                    >
                                    <div
                                        v-if="loanAccount.current_amortization"
                                        class="d-flex flex-row"
                                    >
                                        <div
                                            class="d-flex flex-column br-dark pr-16 flex-1 text-primary-dark font-md justify-content-start"
                                        >
                                            <div
                                                class="d-flex flex-column"
                                                style="margin-bottom: 100px"
                                            >
                                                <span class="mb-5 text-bold"
                                                    >Amortization Scheduled
                                                    Payment</span
                                                >
                                                <div
                                                    class="d-flex flex-row mb-7 font-md"
                                                >
                                                    <div
                                                        class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                    >
                                                        <span>Date</span>
                                                        <span>:</span>
                                                    </div>
                                                    <span class="flex-1">{{
                                                        loanAccount
                                                            .current_amortization
                                                            .amortization_date
                                                    }}</span>
                                                </div>
                                                <div
                                                    class="d-flex flex-row mb-7 font-md"
                                                >
                                                    <div
                                                        class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                    >
                                                        <span>Principal</span>
                                                        <span>:</span>
                                                    </div>
                                                    <span class="flex-1"
                                                        >P
                                                        {{
                                                            formatToCurrency(
                                                                loanAccount
                                                                    .current_amortization
                                                                    .schedule_principal
                                                            )
                                                        }}</span
                                                    >
                                                </div>
                                                <div class="d-flex flex-row">
                                                    <div
                                                        class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                    >
                                                        <span>Interest</span>
                                                        <span>:</span>
                                                    </div>
                                                    <span class="flex-1"
                                                        >P
                                                        {{
                                                            formatToCurrency(
                                                                loanAccount
                                                                    .current_amortization
                                                                    .schedule_interest
                                                            )
                                                        }}</span
                                                    >
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex flex-column mb-10"
                                            >
                                                <span
                                                    class="text-20 text-primary-dark"
                                                    >TOTAL</span
                                                >
                                                <span
                                                    class="bg-primary-dark text-white font-30 pxy-25 lh-1"
                                                    >P
                                                    {{
                                                        formatToCurrency(
                                                            totalScheduledPayment
                                                        )
                                                    }}</span
                                                >
                                            </div>
                                            <div
                                                class="d-flex flex-column bg-peach p-16"
                                            >
                                                <div
                                                    class="d-flex flex-column mb-12"
                                                >
                                                    <div
                                                        class="d-flex flex-row"
                                                    >
                                                        <div
                                                            class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                        >
                                                            <span class=""
                                                                >Short
                                                                Principal</span
                                                            >
                                                            <span>:</span>
                                                        </div>
                                                        <span class="flex-1"
                                                            >P
                                                            {{
                                                                formatToCurrency(
                                                                    loanAccount
                                                                        .current_amortization
                                                                        .short_principal
                                                                )
                                                            }}</span
                                                        >
                                                    </div>
                                                    <div
                                                        class="d-flex flex-row mb-10"
                                                    >
                                                        <div
                                                            class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                        >
                                                            <span class=""
                                                                >Adv.
                                                                Principal</span
                                                            >
                                                            <span>:</span>
                                                        </div>
                                                        <span class="flex-1"
                                                            >P
                                                            {{
                                                                formatToCurrency(
                                                                    loanAccount
                                                                        .current_amortization
                                                                        .advance_principal
                                                                )
                                                            }}</span
                                                        >
                                                    </div>
                                                    <div
                                                        class="d-flex flex-row"
                                                    >
                                                        <div
                                                            class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                        >
                                                            <span class=""
                                                                >Short
                                                                Interest</span
                                                            >
                                                            <span>:</span>
                                                        </div>
                                                        <span class="flex-1"
                                                            >P
                                                            {{
                                                                formatToCurrency(
                                                                    loanAccount
                                                                        .current_amortization
                                                                        .short_interest
                                                                )
                                                            }}</span
                                                        >
                                                    </div>
                                                    <div
                                                        class="d-flex flex-row mb-10"
                                                    >
                                                        <div
                                                            class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                        >
                                                            <span class=""
                                                                >Adv.
                                                                Interest</span
                                                            >
                                                            <span>:</span>
                                                        </div>
                                                        <span class="flex-1"
                                                            >P
                                                            {{
                                                                formatToCurrency(
                                                                    loanAccount
                                                                        .current_amortization
                                                                        .advance_interest
                                                                )
                                                            }}</span
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex flex-column br-dark pr-16 pl-24 flex-1 font-md justify-content-between"
                                        >
                                            <div
                                                class="d-flex flex-column mb-24"
                                            >
                                                <span class="mb-5 text-bold"
                                                    >Due Amount</span
                                                >
                                                <div
                                                    class="d-flex flex-row mb-7"
                                                >
                                                    <div
                                                        class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                    >
                                                        <span>Principal</span>
                                                        <span>:</span>
                                                    </div>
                                                    <span class="flex-1"
                                                        >P
                                                        {{
                                                            formatToCurrency(
                                                                duePrincipal
                                                            )
                                                        }}</span
                                                    >
                                                </div>
                                                <div
                                                    class="d-flex flex-row mb-7"
                                                >
                                                    <div
                                                        class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                    >
                                                        <span>Interest</span>
                                                        <span>:</span>
                                                    </div>
                                                    <span class="flex-1"
                                                        >P
                                                        {{
                                                            formatToCurrency(
                                                                dueInterestRebates
                                                            )
                                                        }}</span
                                                    >
                                                </div>
                                                <div
                                                    class="d-flex flex-row mb-7"
                                                >
                                                    <div
                                                        class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                    >
                                                        <span>Penalty</span>
                                                        <span>:</span>
                                                    </div>
                                                    <span class="flex-1"
                                                        >P
                                                        {{
                                                            formatToCurrency(
                                                                duePenalty
                                                            )
                                                        }}</span
                                                    >
                                                </div>
                                                <div
                                                    class="d-flex flex-row mb-7"
                                                >
                                                    <div
                                                        class="d-flex flex-row justify-content-between flex-1"
                                                    >
                                                        <span>PDI</span>
                                                        <span>:</span>
                                                    </div>
                                                    <input
                                                        type="number"
                                                        step="0.01"
                                                        v-model.number="pdi"
                                                        class="form-control flex-1"
                                                        placeholder="PDI"
                                                    />
                                                    <!-- <span class="flex-1">P {{formatToCurrency(duePdi)}}</span> -->
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex flex-column mb-auto"
                                            >
                                                <span
                                                    class="text-20 text-primary-dark"
                                                    >TOTAL</span
                                                >
                                                <span
                                                    class="bg-primary-dark text-white font-30 pxy-25 lh-1"
                                                    >P
                                                    {{
                                                        formatToCurrency(
                                                            totalDue
                                                        )
                                                    }}</span
                                                >
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex flex-column br-dark pr-16 pl-24 flex-1 font-md justify-content-between"
                                        >
                                            <div
                                                class="d-flex flex-column mb-24"
                                            >
                                                <span class="mb-5 text-bold"
                                                    >Distribution</span
                                                >
                                                <div
                                                    class="d-flex flex-row mb-7"
                                                >
                                                    <div
                                                        class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                    >
                                                        <span>Principal</span>
                                                        <span>:</span>
                                                    </div>
                                                    <span class="flex-1"
                                                        >P
                                                        {{
                                                            formatToCurrency(
                                                                payment.principal
                                                            )
                                                        }}</span
                                                    >
                                                </div>
                                                <div
                                                    class="d-flex flex-row mb-7"
                                                >
                                                    <div
                                                        class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                    >
                                                        <span>Interest</span>
                                                        <span>:</span>
                                                    </div>
                                                    <span class="flex-1"
                                                        >P
                                                        {{
                                                            formatToCurrency(
                                                                payment.interest
                                                            )
                                                        }}</span
                                                    >
                                                </div>
                                                <div
                                                    class="d-flex flex-row mb-7"
                                                >
                                                    <div
                                                        class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                    >
                                                        <span>Penalty</span>
                                                        <span>:</span>
                                                    </div>
                                                    <span class="flex-1"
                                                        >P
                                                        {{
                                                            formatToCurrency(
                                                                payment.penalty
                                                            )
                                                        }}</span
                                                    >
                                                </div>
                                                <div
                                                    class="d-flex flex-row mb-7"
                                                >
                                                    <div
                                                        class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                    >
                                                        <span>PDI</span>
                                                        <span>:</span>
                                                    </div>
                                                    <span class="flex-1"
                                                        >P
                                                        {{
                                                            formatToCurrency(
                                                                payment.pdi
                                                            )
                                                        }}</span
                                                    >
                                                </div>
                                                <div
                                                    class="d-flex flex-row mb-7"
                                                >
                                                    <div
                                                        class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                    >
                                                        <span>Rebates</span>
                                                        <span>:</span>
                                                    </div>
                                                    <span class="flex-1"
                                                        >P
                                                        {{
                                                            formatToCurrency(
                                                                rebatesApplied
                                                            )
                                                        }}</span
                                                    >
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex flex-column mb-10"
                                            >
                                                <span
                                                    class="text-20 text-primary-dark"
                                                    >TOTAL</span
                                                >
                                                <span
                                                    class="bg-darkgreen text-white font-30 pxy-25 lh-1"
                                                    >P
                                                    {{
                                                        formatToCurrency(
                                                            payment.amount_applied
                                                        )
                                                    }}</span
                                                >
                                            </div>
                                            <div
                                                class="d-flex flex-column bg-peach p-16"
                                            >
                                                <span>Waive:</span>
                                                <div
                                                    class="d-flex flex-column mb-12"
                                                >
                                                    <div
                                                        class="d-flex flex-row"
                                                    >
                                                        <div
                                                            class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                        >
                                                            <span class="pl-16"
                                                                >PDI</span
                                                            >
                                                            <span>:</span>
                                                        </div>
                                                        <span class="flex-1"
                                                            >P
                                                            {{
                                                                formatToCurrency(
                                                                    pdiWaive
                                                                )
                                                            }}</span
                                                        >
                                                    </div>
                                                    <div
                                                        class="d-flex flex-row"
                                                    >
                                                        <div
                                                            class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                        >
                                                            <span class="pl-16"
                                                                >Penalty</span
                                                            >
                                                            <span>:</span>
                                                        </div>
                                                        <span class="flex-1"
                                                            >P
                                                            {{
                                                                formatToCurrency(
                                                                    penaltyWaive
                                                                )
                                                            }}</span
                                                        >
                                                    </div>
                                                    <div
                                                        class="d-flex flex-row mb-7"
                                                    >
                                                        <div
                                                            class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                        >
                                                            <span
                                                                >Total
                                                                Waive</span
                                                            >
                                                            <span>:</span>
                                                        </div>
                                                        <span class="flex-1"
                                                            >P
                                                            {{
                                                                formatToCurrency(
                                                                    totalWaive
                                                                )
                                                            }}</span
                                                        >
                                                    </div>
                                                </div>
                                                <div v-if="dueExcess">
                                                    <span>Excess:</span>
                                                    <div
                                                        class="d-flex flex-column mb-12"
                                                    >
                                                        <div
                                                            class="d-flex flex-row"
                                                        >
                                                            <div
                                                                class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                            >
                                                                <span
                                                                    class="pl-16"
                                                                    >Adv.
                                                                    Principal</span
                                                                >
                                                                <span>:</span>
                                                            </div>
                                                            <span class="flex-1"
                                                                >P
                                                                {{
                                                                    formatToCurrency(
                                                                        this
                                                                            .payment
                                                                            .advance_principal
                                                                    )
                                                                }}</span
                                                            >
                                                        </div>
                                                        <div
                                                            class="d-flex flex-row"
                                                        >
                                                            <div
                                                                class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                            >
                                                                <span
                                                                    class="pl-16"
                                                                    >Adv.
                                                                    Interest</span
                                                                >
                                                                <span>:</span>
                                                            </div>
                                                            <span class="flex-1"
                                                                >P
                                                                {{
                                                                    formatToCurrency(
                                                                        this
                                                                            .payment
                                                                            .advance_interest
                                                                    )
                                                                }}</span
                                                            >
                                                        </div>
                                                        <div
                                                            class="d-flex flex-row"
                                                        >
                                                            <div
                                                                class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                            >
                                                                <span
                                                                    class="pl-16"
                                                                    >Over
                                                                    Payment</span
                                                                >
                                                                <span>:</span>
                                                            </div>
                                                            <span class="flex-1"
                                                                >P
                                                                {{
                                                                    formatToCurrency(
                                                                        this
                                                                            .payment
                                                                            .over_payment
                                                                    )
                                                                }}</span
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="totalShort">
                                                    <span>Short:</span>
                                                    <div
                                                        class="d-flex flex-column mb-12"
                                                    >
                                                        <div
                                                            class="d-flex flex-row"
                                                        >
                                                            <div
                                                                class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                            >
                                                                <span
                                                                    class="pl-16"
                                                                    >Principal</span
                                                                >
                                                                <span>:</span>
                                                            </div>
                                                            <span class="flex-1"
                                                                >P
                                                                {{
                                                                    formatToCurrency(
                                                                        this
                                                                            .payment
                                                                            .short_principal
                                                                    )
                                                                }}</span
                                                            >
                                                        </div>
                                                        <div
                                                            class="d-flex flex-row"
                                                        >
                                                            <div
                                                                class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                            >
                                                                <span
                                                                    class="pl-16"
                                                                    >Interest</span
                                                                >
                                                                <span>:</span>
                                                            </div>
                                                            <span class="flex-1"
                                                                >P
                                                                {{
                                                                    formatToCurrency(
                                                                        this
                                                                            .payment
                                                                            .short_interest
                                                                    )
                                                                }}</span
                                                            >
                                                        </div>
                                                        <div
                                                            class="d-flex flex-row"
                                                        >
                                                            <div
                                                                class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                            >
                                                                <span
                                                                    class="pl-16"
                                                                    >Penalty</span
                                                                >
                                                                <span>:</span>
                                                            </div>
                                                            <span class="flex-1"
                                                                >P
                                                                {{
                                                                    formatToCurrency(
                                                                        this
                                                                            .payment
                                                                            .short_penalty
                                                                    )
                                                                }}</span
                                                            >
                                                        </div>
                                                        <div
                                                            class="d-flex flex-row"
                                                        >
                                                            <div
                                                                class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                            >
                                                                <span
                                                                    class="pl-16"
                                                                    >PDI</span
                                                                >
                                                                <span>:</span>
                                                            </div>
                                                            <span class="flex-1"
                                                                >P
                                                                {{
                                                                    formatToCurrency(
                                                                        this
                                                                            .payment
                                                                            .short_pdi
                                                                    )
                                                                }}</span
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <div class="sep-dark"></div>
                                <section>
                                    <span
                                        class="py-7 darker-bb text-primary-dark text-24 text-bold text-block mb-10"
                                        >Outstanding Balance</span
                                    >
                                    <div
                                        class="d-flex flex-row font-md text-primary-dark"
                                    >
                                        <div class="flex-1">
                                            <div
                                                class="d-flex flex-row mb-5 font-md"
                                            >
                                                <div
                                                    class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                >
                                                    <span
                                                        >Principal Balance</span
                                                    >
                                                    <span>:</span>
                                                </div>
                                                <span class="flex-1"
                                                    >P
                                                    {{
                                                        formatToCurrency(
                                                            outstandingPrincipalRemaining
                                                        )
                                                    }}</span
                                                >
                                            </div>
                                            <div class="d-flex flex-row mb-5">
                                                <div
                                                    class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                >
                                                    <span
                                                        >Interest Balance</span
                                                    >
                                                    <span>:</span>
                                                </div>
                                                <span class="flex-1"
                                                    >P
                                                    {{
                                                        formatToCurrency(
                                                            outstandingInterestRemaining
                                                        )
                                                    }}</span
                                                >
                                            </div>
                                            <div
                                                class="d-flex flex-row bb-dashed-2 mb-10"
                                            >
                                                <div
                                                    class="d-flex flex-row justify-content-between flex-1 mr-16 mb-16"
                                                >
                                                    <span>Surcharge</span>
                                                    <span>:</span>
                                                </div>
                                                <span class="flex-1"
                                                    >P
                                                    {{
                                                        formatToCurrency(
                                                            outstandingSurchargeRemaining
                                                        )
                                                    }}</span
                                                >
                                            </div>
                                            <div
                                                class="d-flex flex-row mb-5 text-bold"
                                            >
                                                <div
                                                    class="d-flex flex-row justify-content-between flex-1 mr-16"
                                                >
                                                    <span>TOTAL</span>
                                                    <span>:</span>
                                                </div>
                                                <span class="flex-1"
                                                    >P
                                                    {{
                                                        formatToCurrency(
                                                            outstandingTotalRemaining
                                                        )
                                                    }}</span
                                                >
                                            </div>
                                        </div>
                                        <div class="flex-2"></div>
                                        <button
                                            class="btn btn-danger hide"
                                            id="paymentCancelBtn"
                                            data-dismiss="modal"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                </section>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["pborrower", "borrower", "token", "pbranch", "ppaymenttype"],
    data() {
        return {
            modal: false,
            banks: ["Land Bank", "PNB", "BDO"],
            chequeAdd: false,
            paymentType: "Cash Payment",
            transactionDate: {
                branch_id: this.pbranch,
                status: "closed",
                date_end: "",
            },
            pdi: 0,
            account: {
                loan_account_id: null,
            },
            loanAccount: {
                loan_account_id: null,
                cycle_no: 1,
                ao_id: "",
                product_id: "",
                center_id: "",
                type: "",
                payment_mode: "",
                terms: "",
                loan_amount: "",
                no_of_installment: "",
                day_schedule: "",
                borrower_num: "",
                co_borrower_name: "",
                co_borrower_address: "",
                co_borrower_id_type: "",
                co_borrower_id_number: "",
                co_borrower_id_date_issued: "",
                co_maker_name: "",
                co_maker_address: "",
                co_maker_id_type: "",
                co_maker_id_number: "",
                co_maker_id_date_issued: "",
                document_stamp: "",
                filing_fee: "",
                insurance: "",
                notarial_fee: "100.00",
                prepaid_interest: "",
                affidavit_fee: "",
                memo: "",
                total_deduction: "",
                net_proceeds: "",
                release_type: "",
                interest_rate: "",
                interest_amount: "",
                documents: {
                    date_release: "",
                    description: "",
                    bank: "",
                    account_no: "",
                    card_no: "",
                    promissory_number: "",
                },
                outstandingBalance: {
                    principal_balance: "",
                    interest_balance: "",
                    surcharge: "",
                },
                current_amortization: {
                    principal: "",
                    interest: "",
                    short_interest: "",
                    advance_interest: "",
                    short_principal: "",
                    advance_principal: "",
                    outstandingBalance: {
                        principal_balance: "",
                        interest_balance: "",
                        surcharge: "",
                    },
                    lastPayment: {
                        principal: "",
                        interest: "",
                        short_interest: "",
                        advance_interest: "",
                        short_principal: "",
                        advance_principal: "",
                    },
                },
                pastdue_interest: null,
                remainingBalance: {
                    memo: {
                        debit: 0,
                        credit: 0,
                        balance: 0,
                    },
                    principal: {
                        debit: 0,
                        credit: 0,
                        balance: 0,
                    },
                    interest: {
                        debit: 0,
                        credit: 0,
                        balance: 0,
                    },
                    pdi: {
                        debit: 0,
                        credit: 0,
                        balance: 0,
                    },
                    penalty: {
                        debit: 0,
                        credit: 0,
                        balance: 0,
                    },
                    rebates: {
                        debit: 0,
                        credit: 0,
                        balance: 0,
                    },
                },
                loan_status_view: "",
            },

            payment: {
                payment_id: null,
                loan_account_id: null,
                branch_id: this.pbranch,
                payment_type: "Cash Payment",
                or_no: null,
                cheque_no: null,
                bank_name: null,
                reference_no: null,
                memo_type: null,
                amortization_id: 0,
                principal: 0,
                interest: 0,
                short_principal: 0,
                advance_principal: 0,
                short_interest: 0,
                advance_interest: 0,
                pdi: 0,
                pdi_approval_no: null,
                short_pdi: 0,
                penalty: 0,
                penalty_approval_no: null,
                short_penalty: 0,
                vat: 0,
                rebates: 0,
                rebatesInputted: 0,
                rebates_approval_no: null,
                total_payable: 0,
                amount_applied: 0,
                amount_paid: 0,
                over_payment: 0,
                status: null,
            },
            amortizationSched: [],
            waive: {
                pdi: false,
                penalty: false,
                rebates: false,
            },
        };
    },
    methods: {
        addAnotherBank: function () {
            if (
                this.payment.bank_name &&
                this.payment.bank_name.length > 0 &&
                this.banks.filter(
                    (b) =>
                        b.toLowerCase() === this.payment.bank_name.toLowerCase()
                ).length == 0
            ) {
                this.banks.push(this.payment.bank_name);
            }
            this.chequeAdd = false;
        },
        resetPayment: function () {
            this.payment = {
                payment_id: null,
                loan_account_id: null,
                branch_id: this.pbranch,
                payment_type: "Cash Payment",
                or_no: null,
                cheque_no: null,
                bank_name: null,
                reference_no: null,
                memo_type: null,
                amortization_id: 0,
                principal: 0,
                interest: 0,
                short_principal: 0,
                advance_principal: 0,
                short_interest: 0,
                advance_interest: 0,
                pdi: 0,
                pdi_approval_no: null,
                short_pdi: 0,
                penalty: 0,
                penalty_approval_no: null,
                short_penalty: 0,
                vat: 0,
                rebates: 0,
                rebatesInputted: 0,
                rebates_approval_no: null,
                total_payable: 0,
                amount_applied: 0,
                amount_paid: 0,
                over_payment: 0,
                status: null,
            };
            this.waive = {
                pdi: false,
                penalty: false,
                rebates: false,
            };
        },
        resetLoanAccount: function () {
            this.loanAccount = {
                loan_account_id: null,
                cycle_no: 1,
                ao_id: "",
                product_id: "",
                center_id: "",
                type: "",
                payment_mode: "",
                terms: "",
                loan_amount: "",
                no_of_installment: "",
                day_schedule: "",
                borrower_num: "",
                co_borrower_name: "",
                co_borrower_address: "",
                co_borrower_id_type: "",
                co_borrower_id_number: "",
                co_borrower_id_date_issued: "",
                co_maker_name: "",
                co_maker_address: "",
                co_maker_id_type: "",
                co_maker_id_number: "",
                co_maker_id_date_issued: "",
                document_stamp: "",
                filing_fee: "",
                insurance: "",
                notarial_fee: "100.00",
                prepaid_interest: "",
                affidavit_fee: "",
                memo: "",
                total_deduction: "",
                net_proceeds: "",
                release_type: "",
                interest_rate: "",
                interest_amount: "",
                documents: {
                    date_release: "",
                    description: "",
                    bank: "",
                    account_no: "",
                    card_no: "",
                    promissory_number: "",
                },
                outstandingBalance: {
                    principal_balance: "",
                    interest_balance: "",
                    surcharge: "",
                },
                current_amortization: {
                    principal: "",
                    interest: "",
                    short_interest: "",
                    advance_interest: "",
                    short_principal: "",
                    advance_principal: "",
                    outstandingBalance: {
                        principal_balance: "",
                        interest_balance: "",
                        surcharge: "",
                    },
                    lastPayment: {
                        principal: "",
                        interest: "",
                        short_interest: "",
                        advance_interest: "",
                        short_principal: "",
                        advance_principal: "",
                    },
                },
                remainingBalance: {
                    memo: {
                        debit: 0,
                        credit: 0,
                        balance: 0,
                    },
                    principal: {
                        debit: 0,
                        credit: 0,
                        balance: 0,
                    },
                    interest: {
                        debit: 0,
                        credit: 0,
                        balance: 0,
                    },
                    pdi: {
                        debit: 0,
                        credit: 0,
                        balance: 0,
                    },
                    penalty: {
                        debit: 0,
                        credit: 0,
                        balance: 0,
                    },
                    rebates: {
                        debit: 0,
                        credit: 0,
                        balance: 0,
                    },
                },
                loan_status_view: "",
            };
        },
        showModal: function (success) {
            alert(success)
            var btn = null;
/*             if(success){
                btn = document.getElementById("paymentModal");
            }
            if(btn) {
                btn.click();
            } */

        },
        loadAccount: async function (accountId) {
            this.account.loan_account_id = accountId;
            var success = false;
            try {
                await axios
                    .post(
                        this.baseURL() + "api/payment/account",
                        this.account,
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
                            this.modal = true;
                            var btn =
                                document.getElementById("paymentBtn");
                            if(btn) {
                                btn.click()
                            }
                            this.fetchAccount(accountId);
                        }.bind(this)
                    )
                    .catch(
                        function (error) {
                            this.modal = false
                            var btn =
                                document.getElementById("paymentCancelBtn");
                            if(btn) {
                                btn.click()
                            }
                            this.notify(
                                error.response.data.message,
                                error.response.data.data,
                                "error"
                            );
                        }.bind(this)
                    )
                    /* .finally(
                        function () {
                            this.modal = success
                        }.bind(this)
                    ); */
            } catch (error) {
                console.log(error);
            }
        },
        fetchTransactionDate: function () {
            axios
                .get(
                    this.baseURL() + "api/eod/eodtransaction/" + this.pbranch,
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
                        this.transactionDate = response.data.data;
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
        isActive: function (id) {
            if (id == this.loanAccount.loan_account_id) {
                return "active";
            }
            return "";
        },
        amortSched: function (account) {
            this.loadAccount(account.loan_account_id);
            axios
                .post(
                    this.baseURL() + "api/account/generate-amortization",
                    account,
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
                        this.amortizationSched = response.data.data;
                        this.fetchAccount(account.loan_account_id)
                    }.bind(this)
                )
                .catch(
                    function (error) {
                        console.log(error);
                    }.bind(this)
                );
        },
        getPaymentsOpen: function () {
            /*             axios.get(this.baseURL() + 'api/transaction/payments/open/').then(function(response) {

            }).then((result) => {

            }).catch((err) => {

            }); */
        },
        fetchAccount: function (id) {
            this.$emit("load");
            axios
                .get(this.baseURL() + "api/account/show/" + id, {
                    headers: {
                        Authorization: "Bearer " + this.token,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                })
                .then(
                    function (response) {
                        this.$emit("unload");
                        var loan = response.data.data;
                        loan.remainingBalance =
                            response.data.data.remaining_balance;
                        loan.current_amortization = loan.current_amortization
                            ? loan.current_amortization
                            : {};
                        this.loanAccount = loan;
                        /*                 this.amortization_id = loan?.current_amortization?.id */

                        console.log(this.loanAccount?.current_amortization?.id);
                    }.bind(this)
                )
                .catch(
                    function (error) {
                        this.$emit("unload");
                        console.log(error);
                    }.bind(this)
                );
        },
        distribute: function () {
            var amount = parseFloat(this.payment.amount_paid);
            this.payment.pdi = 0;
            this.payment.penalty = 0;
            this.payment.interest = 0;
            this.payment.principal = 0;
            this.payment.short_pdi = 0;
            this.payment.short_penalty = 0;
            this.payment.short_interest = 0;
            this.payment.short_principal = 0;
            this.payment.advance_interest = 0;
            this.payment.advance_principal = 0;
            this.payment.over_payment = 0;
            this.payment.rebates = this.rebatesApplied;
            if (this.payment.payment_applied != "") {
                // pdi
                if (amount >= this.duePdi) {
                    amount -= this.duePdi;
                    this.payment.pdi = this.duePdi;
                } else {
                    this.payment.pdi = amount;
                    amount = 0;
                }
                this.payment.short_pdi = this.duePdi - this.payment.pdi;
                // penalty
                if (amount >= this.duePenalty) {
                    amount -= this.duePenalty;
                    this.payment.penalty = this.duePenalty;
                } else {
                    this.payment.penalty = amount;
                    amount = 0;
                }
                this.payment.short_penalty =
                    this.duePenalty - this.payment.penalty;
                // interest
                amount += this.dueRebates;
                if (amount > this.dueInterest) {
                    this.payment.interest = this.dueInterest;
                    amount -= this.dueInterest;
                } else {
                    this.payment.interest = amount;
                    amount = 0;
                }
                this.payment.short_interest =
                    this.dueInterest - this.payment.interest;
                // principal
                if (amount > this.duePrincipal) {
                    this.payment.principal = this.duePrincipal;
                    amount -= this.duePrincipal;
                } else {
                    this.payment.principal = amount;
                    amount = 0;
                }
                this.payment.short_principal =
                    this.duePrincipal - this.payment.principal;
                // advance principal
                if (
                    amount >
                    this.loanAccount.remainingBalance.principal.balance -
                        this.duePrincipal
                ) {
                    this.payment.principal +=
                        this.loanAccount.remainingBalance.principal.balance -
                        this.duePrincipal;
                    this.payment.advance_principal =
                        this.loanAccount.current_amortization.principal_balance;
                    amount -=
                        this.loanAccount.remainingBalance.principal.balance -
                        this.duePrincipal;
                } else {
                    this.payment.principal += amount;
                    this.payment.advance_principal =
                        amount + this.excessAdvancePrincipal;
                    amount = 0;
                }
                // advance interest
                amount += this.excessDueRebates;
                if (
                    amount >
                    this.loanAccount.remainingBalance.interest.balance -
                        this.dueInterest
                ) {
                    this.payment.interest +=
                        this.loanAccount.remainingBalance.interest.balance -
                        this.dueInterest;
                    this.payment.advance_interest =
                        this.loanAccount.current_amortization.interest_balance;
                    amount -=
                        this.loanAccount.remainingBalance.interest.balance -
                        this.dueInterest;
                } else {
                    this.payment.interest += amount;
                    this.payment.advance_interest =
                        amount + this.excessAdvanceInterest;
                    amount = 0;
                }
                this.payment.interest -= this.rebatesApplied;
                this.payment.advance_interest -= this.excessDueRebates;
                // overpayment
                this.payment.over_payment = amount;
                this.payment.total_payable = this.totalDue; // Verify if change payable if waived fees

                this.payment.amount_applied = this.payment.pdi;
                this.payment.amount_applied += this.payment.penalty;
                this.payment.amount_applied += this.payment.interest;
                this.payment.amount_applied += this.rebatesApplied;
                this.payment.amount_applied += this.payment.principal;
                this.payment.amount_applied += this.payment.over_payment;
                // this.payment.amount_applied =  parseFloat(this.payment.amount_paid);
            }
        },
        checkRebates: function () {
            if (this.waive.rebates) {
                return this.payment.rebatesInputted > 0;
            }
            return true;
        },
        pay: function () {
            this.payment.loan_account_id = this.loanAccount.loan_account_id;
            this.payment.pdi += this.pdiWaive;
            this.payment.penalty += this.penaltyWaive;
            this.payment.transaction_date = this.transactionDate.date_end;
            this.payment.amortization_id =
                this.loanAccount?.current_amortization.id;
            if (
                parseFloat(this.payment.amount_paid) > 0 &&
                this.checkRebates() || this.payment.memo_type == 'Rebates and Discount'
            ) {
                axios
                    .post(this.baseURL() + "api/payment", this.payment, {
                        headers: {
                            Authorization: "Bearer " + this.token,
                            "Content-Type": "application/json",
                            Accept: "application/json",
                        },
                    })
                    .then(
                        function (response) {
                            this.resetPayment();
                            var btn =
                                document.getElementById("paymentCancelBtn");
                            btn.click();
                            this.isModalOpen = false;
                            this.notify("", "Payment successful.", "success");
                        }.bind(this)
                    )
                    .catch(
                        function (error) {
                            console.log(error);
                            this.notify("", error.response.data.data, "error");
                        }.bind(this)
                    );
            } else if (!this.checkRebates()) {
                this.notify(
                    "",
                    "Rebates amount must not be zero or below.",
                    "error"
                );
            } else {
                this.notify(
                    "",
                    "Amount paid must not be zero or below.",
                    "error"
                );
            }
        },
        disabled: function (element) {
            return !element ? true : false;
        },
        required: function (element) {
            return !element ? false : true;
        },
    },
    computed: {
        isModalOpen: {
            get: function () {
                return this.modal;
            },
            set: function (newValue) {
                this.modal = newValue;
                return this.modal;
            },
        },
        loanAccountStatus: function () {
            return this.loanAccount.loan_status_view;
        },
        loanAccountStatusColor: function () {
            if (this.loanAccountStatus == "Past Due") {
                return "text-danger";
            } else if (this.loanAccountStatus == "Delinquent") {
                return "text-danger";
            }
            return "text-ocean";
        },
        rebatesApplied: function () {
            return this.waive.rebates
                ? parseFloat(this.payment.rebatesInputted)
                : 0;
        },
        pdiWaive: function () {
            if (this.pdi != this.duePdiCopy) {
                return this.waive.pdi ? this.pdi : 0;
            }
            return this.waive.pdi ? this.pdiWaiveCopy : 0;
        },
        pdiWaiveCopy: function () {
            if (this.loanAccount.remainingBalance) {
                return this.waive.pdi
                    ? this.loanAccount.remainingBalance.pdi.balance
                    : 0;
            }
        },
        penaltyWaive: function () {
            return this.waive.penalty
                ? this.loanAccount.current_amortization.penalty +
                      this.loanAccount.current_amortization.short_penalty
                : 0;
        },
        totalWaive: function () {
            return this.penaltyWaive + this.pdiWaive;
        },
        totalScheduledPayment: function () {
            return (
                this.loanAccount.current_amortization.schedule_interest +
                this.loanAccount.current_amortization.schedule_principal
            );
        },
        borrowerPhoto: function () {
            return this.pborrower.photo
                ? this.pborrower.photo
                : this.baseURL() + "/img/user.png";
        },
        lastTransactionDate: function () {
            return this.loanAccount.payments.length > 0
                ? this.dateToMDY(
                      new Date(
                          this.loanAccount.payments[
                              this.loanAccount.payments.length - 1
                          ].transaction_date
                      )
                  )
                : "None";
        },
        amountDistributed: function () {
            return (
                parseFloat(this.payment.amount_paid) +
                parseFloat(
                    this.loanAccount.current_amortization.advance_principal
                )
            );
        },
        totalBalance: function () {
            return (
                this.totalDue +
                parseFloat(
                    this.loanAccount.current_amortization.principal_balance
                ) +
                parseFloat(
                    this.loanAccount.current_amortization.interest_balance
                )
            );
        },
        totalShort: function () {
            return (
                this.payment.short_pdi +
                this.payment.short_penalty +
                this.payment.short_interest +
                this.payment.short_principal
            );
        },
        totalInterest: function () {
            return (
                this.loanAccount.current_amortization.interest +
                this.loanAccount.current_amortization.short_interest
            );
        },
        totalPrincipal: function () {
            return this.loanAccount.current_amortization
                ? this.loanAccount.current_amortization.principal +
                      this.loanAccount.current_amortization.short_principal
                : 0;
        },

        duePdi: function () {
            if (this.pdi != this.duePdiCopy) {
                return this.waive.pdi ? 0 : this.pdi;
            }
            return this.waive.pdi ? 0 : this.duePdiCopy;
        },

        duePdiCopy: function () {
            if (this.loanAccount.remainingBalance) {
                return this.loanAccount.remainingBalance.pdi.balance;
            }
            return 0;
        },
        duePenalty: function () {
            return this.waive.penalty
                ? 0
                : this.loanAccount.current_amortization.penalty +
                      this.loanAccount.current_amortization.short_penalty;
        },
        dueInterest: function () {
            return this.totalInterest >
                this.loanAccount.current_amortization.advance_interest
                ? this.totalInterest -
                      this.loanAccount.current_amortization.advance_interest
                : 0;
        },
        dueInterestRebates: function () {
            return this.dueInterest < this.rebatesApplied
                ? 0
                : this.dueInterest - this.rebatesApplied;
        },
        duePrincipal: function () {
            return this.totalPrincipal >
                this.loanAccount.current_amortization.advance_principal ? this.totalPrincipal - this.loanAccount.current_amortization.advance_principal : 0;
        },
        totalDue: function () {
            return (
                this.duePrincipal +
                this.dueInterestRebates +
                this.duePdi +
                this.duePenalty
            );
        },
        excessAdvancePrincipal: function () {
            return this.loanAccount.current_amortization.advance_principal <
                this.totalPrincipal
                ? 0
                : this.loanAccount.current_amortization.advance_principal -
                      this.totalPrincipal;
        },
        excessAdvanceInterest: function () {
            return this.loanAccount.current_amortization.advance_interest <
                this.totalInterest
                ? 0
                : this.loanAccount.current_amortization.advance_interest -
                      this.totalInterest;
        },
        dueRebates: function () {
            return this.dueInterest >= this.rebatesApplied
                ? this.rebatesApplied
                : this.dueInterest;
        },
        excessDueRebates: function () {
            return this.dueInterest < this.rebatesApplied
                ? this.rebatesApplied - this.dueRebates
                : 0;
        },
        dueExcess: function () {
            return (
                this.payment.advance_principal +
                this.payment.advance_interest +
                this.payment.over_payment
            );
        },
        outstandingPrincipal: function () {
            return this.loanAccount.remainingBalance.principal.balance;
        },
        outstandingInterest: function () {
            return this.loanAccount.remainingBalance.interest.balance;
        },
        outstandingSurcharge: function () {
            return this.duePdi + this.duePenalty;
        },
        outstandingTotal: function () {
            return (
                this.outstandingPrincipal +
                this.outstandingInterest +
                this.outstandingSurcharge
            );
        },
        outstandingPrincipalRemaining: function () {
            return (
                this.loanAccount.remainingBalance.principal.balance -
                this.payment.principal
            );
        },
        outstandingInterestRemaining: function () {
            const intBal = this.loanAccount.remainingBalance.interest.balance - this.loanAccount.remainingBalance.rebates.credit;
            return (
                intBal -
                this.payment.interest -
                this.rebatesApplied
            );
        },
        outstandingSurchargeRemaining: function () {
            return (
                this.duePdi +
                this.duePenalty -
                this.payment.penalty -
                this.payment.pdi
            );
        },
        outstandingTotalRemaining: function () {
            return (
                this.outstandingPrincipalRemaining +
                this.outstandingInterestRemaining +
                this.outstandingSurchargeRemaining
            );
        },
        rpaymentType: function () {
            return JSON.parse(this.ppaymenttype);
        },
        unpaidLoanAccounts: function () {
            let filteredData = [];
            if (this.pborrower.loan_accounts) {
                this.pborrower.loan_accounts.map(
                    function (data) {
                        if (data.remainingBalance.memo.balance > 0) {
                            filteredData.push(data);
                            // return;
                        }
                    }.bind(this)
                );
            }

            return filteredData;
        },
    },
    watch: {
        "pborrower.borrower_id": function (newValue) {
            this.resetPayment();
            this.resetLoanAccount();
        },
        "payment.amount_paid": function (newValue) {
            this.distribute();
        },
        "loanAccount.loan_account_id": function (newValue) {
            this.payment.total_payable = this.totalDue;
            this.payment.amortization_id =
                this.loanAccount.current_amortization.id;
            this.pdi = parseFloat(
                this.loanAccount.remainingBalance.pdi.balance
            );
        },
        "waive.pdi": function (newValue) {
            this.distribute();
        },
        pdi: function (newValue) {
            this.distribute();
        },
        "waive.penalty": function (newValue) {
            this.distribute();
        },
        "waive.rebates": function (newValue) {
            this.distribute();
        },
        "payment.rebatesInputted": function (newValue) {
            if (this.outstandingInterest < this.payment.rebatesInputted) {
                this.payment.rebatesInputted = this.outstandingInterest;
            } else if (this.payment.rebatesInputted < 0) {
                this.payment.rebatesInputted = 0;
            }
            this.distribute();
        },
    },
    mounted() {
        this.fetchTransactionDate();
        this.payment.branch_id = this.pbranch;
    },
};
</script>

<style lang="scss" scoped>
.active {
    background-color: #eee;
}
</style>
