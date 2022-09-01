<template>
	<div style="flex:20">
		<notifications group="foo" />
		<section class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Details</span>
			<div class="d-flex mb-12">
				<div class="d-flex flex-column mr-16" style="flex:20;">
					<div class="d-flex flex-row">
						<div class="borrower-number d-flex flex-column" style="flex: 5">
							<span>Borrower's Number</span>
							<span class="text-center">{{pborrower.borrower_num}}</span>
						</div>
						<div style="flex:4"></div>
						<div class="form-group mb-10" style="flex: 5">
							<!-- <label for="transactionDate" class="form-label">Transaction Date</label>
							<input type="date" class="form-control form-input text-right" id="transactionDate"> -->
						</div>
					</div>
					<div class="form-group mb-5" style="flex: 5">
						<label for="client" class="form-label mb-3">Client</label>
						<input :value="pborrower.firstname + ' ' + pborrower.lastname + ' ' + pborrower.suffix" type="text" class="form-control form-input " id="client">
					</div>
					<div class="form-group mb-10" style="flex: 5">
						<label for="address" class="form-label mb-3">Address</label>
						<input :value="pborrower.address" type="text" class="form-control form-input " id="address">
					</div>
				</div>
				<div class="upload-photo d-flex flex-column" style="flex:4;padding-top:36px;">
					<img :src="borrowerPhoto" alt="" style="max-width:230px;">
				</div>
			</div>
			<div class="sep mb-24"></div>
		</section>

		<section v-if="pborrower.borrower_id" class="mb-36" style="flex:21;padding-left:16px;">
			<span class="section-title section-subtitle mb-12">Select Loan Accounts Payable</span>
			<div class="p-10 light-border mb-24">
				<table class="table table-stripped m-0 th-nbt  th-blue table-hover">
					<thead>
						<th class="text-primary-dark">Account Number</th>
						<th class="text-primary-dark">Date Transaction</th>
						<th class="text-primary-dark">Balance</th>
					</thead>
					<tbody>
						<tr @click="loanAccount=account;amortSched();" v-for="account in pborrower.loan_accounts" :key="account.loan_account_id" :class="isActive(account.loan_account_id)">
							<td>{{account.account_num}}</td>
							<td>{{dateToYMD(new Date(account.date_release))}}</td>
							<td>P {{formatToCurrency(account.current_amortization ? account.current_amortization.outstandingBalance : 0)}}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="sep"></div>
		</section>
		<section v-if="loanAccount.loan_account_id" class="mb-24" style="flex:21;padding-left:16px;">
			<div class="d-flex flex-row justify-content-between align-items-center section-title pb-12 mb-24">
				<span class="section-title section-subtitle b-none p-0">Loan Details</span>
			</div>
			<div class="d-flex flex-row">
				<div class="d-flex flex-column flex-1 mr-45">
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Account Number</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.account_num}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Co Borrower</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.co_borrower_name}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Address</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.co_borrower_address}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Co Maker</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.co_maker_name}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Address</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.co_maker_address}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Contact No.</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{pborrower.contact_number}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Date Release</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.date_release}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Product Name</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.product.product_name}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Missed Payments</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">0</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Type</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.type}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Cycle</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.cycle_no}}</span>
					</div>
				</div>
				<div class="d-flex flex-column flex-1">
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Last Transaction</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{lastTransactionDate}}</span>
					</div>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Loan Amount</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.loan_amount}}</span>
					</div>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Interest</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.interest_amount}}</span>
					</div>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Due Date</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.due_date}}</span>
					</div>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Monthly</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{formatToCurrency(loanAccount.current_amortization.interest + loanAccount.current_amortization.principal)}}</span>
					</div>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Int. Rate</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.interest_rate}}%</span>
					</div>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Mode</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.payment_mode}}</span>
					</div>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Rate</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.interest_rate}}%</span>
					</div>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Term</span>
							<span>:</span>
						</div>
						<span class="flex-2 text-primary-dark">{{loanAccount.terms }} Days</span>
					</div>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Status</span>
							<span>:</span>
						</div>
						<span v-if="loanAccount.current_amortization.delinquent.length > 0" class="flex-2 text-danger">Delinquent</span>
                        <span v-if="loanAccount.current_amortization.delinquent.length == 0" class="flex-2 text-ocean">Current</span>

					</div>
				</div>
			</div>
		</section>
		<div class="flex-1 d-flex flex-row-reverse align-items-end">
			<button @click="distribute()" v-if="loanAccount.loan_account_id" data-toggle="modal" data-target="#paymentModal" class="btn btn-bright-blue min-w-150 mb-5">Pay</button>
		</div>


		<div class="modal" id="paymentModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<form @submit.prevent="pay()">
						<section class="mb-24 p-16" style="flex:21;padding-left:16px;">
							<span class="section-title mb-12">Payment</span>
							<div class="d-flex flex-column flex-lg-row">
								<div class="form-group mb-10 mr-16 flex-1">
									<label for="transactionDate" class="form-label">Payment Type</label>
									<div class="form-group">
										<select required class="form-control form-input" v-model="payment.payment_type">
										<option value="cash">Cash Payment</option>
										<option value="cheque">Cheque Payment</option>
										<option value="memo">Memo</option>
										<option value="pos">POS</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-10 mr-16 flex-1" v-if="payment.payment_type!='memo'">
									<label for="transactionDate" class="form-label">OR #</label>
									<input required v-model="payment.or_no" type="text" class="form-control form-input" id="transactionDate">
								</div>
								<div class="flex-2" v-if="payment.payment_type=='cash'"></div>
								<div class="form-group mb-10 mr-16 flex-1" v-if="payment.payment_type=='pos'">
									<label for="transactionDate" class="form-label">Referrence #</label>
									<input required v-model="payment.reference_no" type="text" class="form-control form-input" id="transactionDate">
								</div>
								<div class="form-group mb-10 mr-16 flex-1" v-if="payment.payment_type=='cheque'">
									<label for="transactionDate" class="form-label">Cheque #</label>
									<input required v-model="payment.cheque_no" type="text" class="form-control form-input" id="transactionDate">
								</div>
								<!-- <div class="form-group mb-10 flex-1" v-if="payment.payment_type=='pos'">
									<label for="transactionDate" class="form-label">Bank Name</label>
									<select required class="form-control form-input">
										<option value="">Land Bank</option>
										<option value="">PNB</option>
										<option value="">BDO</option>
									</select>
								</div> -->
								<div class="form-group mb-10 mr-16 flex-1" v-if="payment.payment_type=='cheque'||payment.payment_type=='pos'">
									<label for="transactionDate" class="form-label">Bank Name</label>
									<div class="form-group">
										<select required v-model="payment.bank_name" class="form-control form-input">
											<option value="Land Bank">Land Bank</option>
											<option value="PNB">PNB</option>
											<option value="BDO">BDO</option>
										</select>
									</div>
								</div>
								<div class="form-group mb-10 flex-1  mr-16" v-if="payment.payment_type=='memo'">
									<label for="transactionDate" class="form-label">Memo Referece #</label>
									<input required v-model="payment.reference_no" type="text" class="form-control form-input" id="transactionDate">
								</div>
								<div class="form-group mb-10 mr-16 flex-1" v-if="payment.payment_type=='memo'">
									<label for="transactionDate" class="form-label">Type</label>
									<div class="form-group">
										<select required v-model="payment.memo_type" class="form-control form-input">
											<option value="Deduct to Balance">Deduct to Balance</option>
										</select>
									</div>
								</div>
								<div class="flex-1" v-if="payment.payment_type=='memo'"></div>
							</div>
							<div class="d-flex flex-row mb-24">
								<div class="form-group mb-0 flex-2 mr-24">
									<label for="transactionDate" class="form-label mb-5">Amount</label>
									<div class="d-flex flex-column flex-lg-row align-items-center justify-content-between">
										<div class="d-flex align-items-center">
											<span class="text-bold mr-10" style="font-size:60px;color:#263f52;line-height:1;">P</span>
											<input @blur="payment.amount_applied=payment.amount_applied==''?0:payment.amount_applied;distribute()" required v-model="payment.amount_applied" type="number" class="form-control form-input mw-250" id="transactionDate" step=".01">
										</div>
									</div>
								</div>
								<div class="d-flex flex-column flex-1 mr-16">
									<span class="font-20 text-primary-dark lh-1 mb-3">Waive</span>
									<div class="d-flex flex-row align-items-center mb-3">
										<input v-model="waive.pdi" type="checkbox" class="form-check-input" style="margin:0">
										<span class="ml-18 text-primary-dark text-24 lh-1">PDI</span>
									</div>
									<input :disabled="disabled(waive.pdi)" v-model="payment.pdi_approval_no" type="text" class="form-control" placeholder="Approval #">
								</div>
								<div class="d-flex flex-column flex-1 mr-16">
									<span class="font-20 text-primary-dark lh-1 invis mb-3">l</span>
									<div class="d-flex flex-row align-items-center mb-3">
										<input v-model="waive.penalty" type="checkbox" class="form-check-input" style="margin:0">
										<span class="ml-18 text-primary-dark text-24 lh-1">Penalty</span>
									</div>
									<input :disabled="disabled(waive.penalty)" v-model="payment.penalty_approval_no" type="text" class="form-control" placeholder="Approval #">
								</div>
								<div class="d-flex flex-column flex-1 mr-16">
									<span class="font-20 text-primary-dark lh-1 invis mb-3">l</span>
									<div class="d-flex flex-row align-items-center mb-3">
										<input v-model="waive.rebates" type="checkbox" class="form-check-input" style="margin:0">
										<span class="ml-18 text-primary-dark text-24 lh-1">Rebates</span>
									</div>
									<input :disabled="disabled(waive.rebates)" v-model="payment.rebates_approval_no" type="text" class="form-control" placeholder="Approval #">
								</div>
								<div class="d-flex flex-column flex-1 mr-24">
									<span class="font-20 text-primary-dark lh-1 invis mb-3">l</span>
									<div class="d-flex flex-row align-items-center mb-3 invis">
										<input type="checkbox" class="form-check-input" style="margin:0">
										<span class="ml-18 text-primary-dark text-24 lh-1">Rebates</span>
									</div>
									<input @focusout="distribute()" :disabled="disabled(waive.rebates)" v-model="payment.rebates" type="text" class="form-control" placeholder="Amount">
								</div>
								<div class="flex-1 d-flex flex-row-reverse align-items-end"><input type="submit" class="btn btn-bright-blue min-w-150 mb-5" value="Pay"></div>
							</div>
							<div class="sep-dark mb-10"></div>
							<section class="mb-24">
								<span class="py-12 darker-bb text-primary-dark text-24 text-bold text-block mb-10">Preview</span>
								<div v-if="loanAccount.current_amortization" class="d-flex flex-row">
									<div class="d-flex flex-column br-dark pr-16 flex-1 text-primary-dark font-md justify-content-start">
										<div class="d-flex flex-column" style="margin-bottom:100px;">
											<span class="mb-5 text-bold">Amortization Scheduled Payment</span>
											<div class="d-flex flex-row mb-7 font-md">
												<div class="d-flex flex-row justify-content-between flex-1 mr-16">
													<span>Principal</span>
													<span>:</span>
												</div>
												<span class="flex-1">P {{formatToCurrency(loanAccount.current_amortization.principal)}}</span>
											</div>
											<div class="d-flex flex-row">
												<div class="d-flex flex-row justify-content-between flex-1 mr-16">
													<span>Interest</span>
													<span>:</span>
												</div>
												<span class="flex-1">P {{formatToCurrency(loanAccount.current_amortization.interest)}}</span>
											</div>
										</div>
										<div class="d-flex flex-column mb-10">
											<span class="text-20 text-primary-dark">TOTAL</span>
											<span class="bg-primary-dark text-white font-30 pxy-25 lh-1">P {{formatToCurrency(totalScheduledPayment)}}</span>
										</div>
										<div class="d-flex flex-column bg-peach p-16">
											<div class="d-flex flex-column mb-12">
												<div class="d-flex flex-row">
													<div class="d-flex flex-row justify-content-between flex-1 mr-16">
														<span class="">Short Principal</span>
														<span>:</span>
													</div>
													<span class="flex-1">P {{formatToCurrency(loanAccount.current_amortization.short_principal)}}</span>
												</div>
												<div class="d-flex flex-row mb-10">
													<div class="d-flex flex-row justify-content-between flex-1 mr-16">
														<span class="">Adv. Principal</span>
														<span>:</span>
													</div>
													<span class="flex-1">P {{formatToCurrency(loanAccount.current_amortization.advance_principal)}}</span>
												</div>
												<div class="d-flex flex-row">
													<div class="d-flex flex-row justify-content-between flex-1 mr-16">
														<span class="">Short Interest</span>
														<span>:</span>
													</div>
													<span class="flex-1">P {{formatToCurrency(loanAccount.current_amortization.short_interest)}}</span>
												</div>
											</div>

										</div>
									</div>
									<div class="d-flex flex-column br-dark pr-16 pl-24 flex-1 font-md justify-content-between">
										<div class="d-flex flex-column mb-24">
											<span class="mb-5 text-bold">Due Amount</span>
											<div class="d-flex flex-row mb-7">
												<div class="d-flex flex-row justify-content-between flex-1 mr-16">
													<span>Principal</span>
													<span>:</span>
												</div>
												<span class="flex-1">P {{formatToCurrency(totalPrincipal)}}</span>
											</div>
											<div class="d-flex flex-row mb-7">
												<div class="d-flex flex-row justify-content-between flex-1 mr-16">
													<span>Interest</span>
													<span>:</span>
												</div>
												<span class="flex-1">P {{formatToCurrency(totalInterest - payment.rebates)}}</span>
											</div>
											<div class="d-flex flex-row mb-7">
												<div class="d-flex flex-row justify-content-between flex-1 mr-16">
													<span>Penalty</span>
													<span>:</span>
												</div>
												<span class="flex-1">P {{formatToCurrency(penalty)}}</span>
											</div>
											<div class="d-flex flex-row mb-7">
												<div class="d-flex flex-row justify-content-between flex-1 mr-16">
													<span>PDI</span>
													<span>:</span>
												</div>
												<span class="flex-1">P {{formatToCurrency(pdi)}}</span>
											</div>
											<!-- <div v-if="overPayment > 0" class="d-flex flex-row">
												<div class="d-flex flex-row justify-content-between flex-1 mr-16">
													<span>Overpayment</span>
													<span>:</span>
												</div>
												<span class="flex-1">P {{overPayment}}</span>
											</div> -->
										</div>
										<div class="d-flex flex-column mb-auto">
											<span class="text-20 text-primary-dark">TOTAL</span>
											<span class="bg-primary-dark text-white font-30 pxy-25 lh-1">P {{formatToCurrency(totalDue)}}</span>
										</div>

									</div>
									<div class="d-flex flex-column br-dark pr-16 pl-24 flex-1 font-md justify-content-between">
										<div class="d-flex flex-column mb-24">
											<span class="mb-5 text-bold">Distribution</span>
											<div class="d-flex flex-row mb-7">
												<div class="d-flex flex-row justify-content-between flex-1 mr-16">
													<span>Principal</span>
													<span>:</span>
												</div>
												<span class="flex-1">P {{formatToCurrency(payment.principal)}}</span>
											</div>
											<div class="d-flex flex-row mb-7">
												<div class="d-flex flex-row justify-content-between flex-1 mr-16">
													<span>Interest</span>
													<span>:</span>
												</div>
												<span class="flex-1">P {{formatToCurrency(payment.interest)}}</span>
											</div>
											<div class="d-flex flex-row mb-7">
												<div class="d-flex flex-row justify-content-between flex-1 mr-16">
													<span>Penalty</span>
													<span>:</span>
												</div>
												<span class="flex-1">P {{formatToCurrency(payment.penalty)}}</span>
											</div>
											<div class="d-flex flex-row mb-7">
												<div class="d-flex flex-row justify-content-between flex-1 mr-16">
													<span>PDI</span>
													<span>:</span>
												</div>
												<span class="flex-1">P {{formatToCurrency(payment.pdi)}}</span>
											</div>
											<div class="d-flex flex-row mb-7">
												<div class="d-flex flex-row justify-content-between flex-1 mr-16">
													<span>Total Waive</span>
													<span>:</span>
												</div>
												<span class="flex-1">P {{formatToCurrency(totalWaive)}}</span>
											</div>
											<!-- <div v-if="overPayment > 0" class="d-flex flex-row">
												<div class="d-flex flex-row justify-content-between flex-1 mr-16">
													<span>Overpayment</span>
													<span>:</span>
												</div>
												<span class="flex-1">P {{formatToCurrency(overPayment)}}</span>
											</div> -->
										</div>
										<div class="d-flex flex-column mb-10">
											<span class="text-20 text-primary-dark">TOTAL</span>
											<span class="bg-darkgreen text-white font-30 pxy-25 lh-1">P {{formatToCurrency(payment.amount_applied)}}</span>
										</div>
										<div class="d-flex flex-column bg-peach p-16">
											<span>Waive</span>
											<div class="d-flex flex-column mb-12">
												<div class="d-flex flex-row">
													<div class="d-flex flex-row justify-content-between flex-1 mr-16">
														<span class="pl-16">PDI</span>
														<span>:</span>
													</div>
													<span class="flex-1">P {{formatToCurrency(this.waive.pdi?loanAccount.current_amortization.pdi:0)}}</span>
												</div>
												<div class="d-flex flex-row">
													<div class="d-flex flex-row justify-content-between flex-1 mr-16">
														<span class="pl-16">Penalty</span>
														<span>:</span>
													</div>
													<span class="flex-1">P {{formatToCurrency(this.waive.penalty?loanAccount.current_amortization.penalty:0)}}</span>
												</div>

											</div>
											<div v-if="dueExcess">
												<span>Excess:</span>
												<div class="d-flex flex-column mb-12">
													<div class="d-flex flex-row">
														<div class="d-flex flex-row justify-content-between flex-1 mr-16">
															<span class="pl-16">Adv. Principal</span>
															<span>:</span>
														</div>
														<span class="flex-1">P {{formatToCurrency(this.payment.advance_principal)}}</span>
													</div>
													<div class="d-flex flex-row">
														<div class="d-flex flex-row justify-content-between flex-1 mr-16">
															<span class="pl-16">Over Payment</span>
															<span>:</span>
														</div>
														<span class="flex-1">P {{formatToCurrency(this.payment.over_payment)}}</span>
													</div>
												</div>
											</div>
											<div v-if="totalShort">
												<span>Short:</span>
												<div class="d-flex flex-column mb-12">
													<div class="d-flex flex-row">
														<div class="d-flex flex-row justify-content-between flex-1 mr-16">
															<span class="pl-16">Principal</span>
															<span>:</span>
														</div>
														<span class="flex-1">P {{formatToCurrency(this.payment.short_principal)}}</span>
													</div>
													<div class="d-flex flex-row">
														<div class="d-flex flex-row justify-content-between flex-1 mr-16">
															<span class="pl-16">Interest</span>
															<span>:</span>
														</div>
														<span class="flex-1">P {{formatToCurrency(this.payment.short_interest)}}</span>
													</div>
													<div class="d-flex flex-row">
														<div class="d-flex flex-row justify-content-between flex-1 mr-16">
															<span class="pl-16">Penalty</span>
															<span>:</span>
														</div>
														<span class="flex-1">P {{formatToCurrency(this.payment.short_penalty)}}</span>
													</div>
													<div class="d-flex flex-row">
														<div class="d-flex flex-row justify-content-between flex-1 mr-16">
															<span class="pl-16">PDI</span>
															<span>:</span>
														</div>
														<span class="flex-1">P {{formatToCurrency(this.payment.short_pdi)}}</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</section>
							<div class="sep-dark"></div>
							<section>
								<span class="py-7 darker-bb text-primary-dark text-24 text-bold text-block mb-10">Outstanding Balance</span>
								<div class="d-flex flex-row font-md text-primary-dark">
									<div class="flex-1">
										<div class="d-flex flex-row mb-5 font-md">
											<div class="d-flex flex-row justify-content-between flex-1 mr-16">
												<span>Principal Balance</span>
												<span>:</span>
											</div>
											<span class="flex-1">P {{formatToCurrency(loanAccount.current_amortization.principal_balance + totalPrincipal )}}</span>
										</div>
										<div class="d-flex flex-row mb-5">
											<div class="d-flex flex-row justify-content-between flex-1 mr-16">
												<span>Interest Balance</span>
												<span>:</span>
											</div>
											<span class="flex-1">P {{formatToCurrency(loanAccount.current_amortization.interest_balance + totalInterest)}}</span>
										</div>
										<div class="d-flex flex-row bb-dashed-2 mb-10">
											<div class="d-flex flex-row justify-content-between flex-1 mr-16 mb-16">
												<span>Surcharge</span>
												<span>:</span>
											</div>
											<span class="flex-1">P {{formatToCurrency(pdi + penalty)}}</span>
										</div>
										<div class="d-flex flex-row mb-5 text-bold">
											<div class="d-flex flex-row justify-content-between flex-1 mr-16">
												<span>TOTAL</span>
												<span>:</span>
											</div>
											<span class="flex-1">P {{formatToCurrency(loanAccount.current_amortization.interest_balance + loanAccount.current_amortization.principal_balance + totalDue)}}</span>
										</div>
									</div>
									<div class="flex-2"></div>
									<button class="btn btn-danger hide" id="paymentCancelBtn" data-dismiss="modal">Cancel</button>
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
	props:['pborrower','token'],
	data(){
		return {
			paymentType:'cash',
			loanAccount:{
				loan_account_id:null,
				cycle_no : 1,
				ao_id : '',
				product_id : '',
				center_id : '',
				type : '',
				payment_mode : '',
				terms : '',
				loan_amount : '',
				no_of_installment : '',
				day_schedule : '',
				borrower_num : '',
				co_borrower_name : '',
				co_borrower_address : '',
				co_borrower_id_type : '',
				co_borrower_id_number : '',
				co_borrower_id_date_issued : '',
				co_maker_name : '',
				co_maker_address : '',
				co_maker_id_type : '',
				co_maker_id_number : '',
				co_maker_id_date_issued : '',
				document_stamp : '',
				filing_fee : '',
				insurance : '',
				notarial_fee : '100.00',
				prepaid_interest : '',
				affidavit_fee : '',
				memo : '',
				total_deduction : '',
				net_proceeds : '',
				release_type : '',
				interest_rate:'',
				interest_amount:'',
				documents: {
					date_release: '',
					description: '',
					bank: '',
					account_no: '',
					card_no:'',
					promissory_number: '',
				},
				outstandingBalance:{
					principal_balance:'',
					interest_balance:'',
					surcharge:'',
				},
				current_amortization:{
					principal:'',
					interest:'',
					short_interest:'',
					advance_interest:'',
					short_principal:'',
					advance_principal:'',
					outstandingBalance:{
						principal_balance:'',
						interest_balance:'',
						surcharge:'',
					},
					lastPayment:{
						principal:'',
						interest:'',
						short_interest:'',
						advance_interest:'',
						short_principal:'',
						advance_principal:'',
					}
				},
			},
			payment:{
				payment_id:null,
				loan_account_id:null,
				branch_id:null,
				payment_type:'cash',
				or_no:null,
				cheque_no:null,
				bank_name:null,
				reference_no:null,
				memo_type:null,
				amortization_id:0,
				principal:0,
				interest:0,
				short_principal:0,
				advance_principal:0,
				short_interest:0,
				advance_interest:0,
				pdi:0,
				pdi_approval_no:null,
				short_pdi:0,
				penalty:0,
				penalty_approval_no:null,
				short_penalty:0,
				vat:0,
				rebates:0,
				rebates_approval_no:null,
				total_payable:0,
				amount_applied:0,
				over_payment:0,
				status:null,
			},
			amortizationSched:[],
			waive:{
				pdi:false,
				penalty:false,
				rebates:false,
			}
		}
	},
	methods:{
		notify:function(title, text, type){
			this.$notify({
				group: 'foo',
				title: title,
				text: text,
				type: type,
			});
		},
		isActive:function(id){
			if(id == this.loanAccount.loan_account_id){
				return 'active'
			}
			return '';
		},
		amortSched:function(){
			axios.post(this.baseURL() + 'api/account/generate-amortization', this.loanAccount, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.amortizationSched = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		distribute:function(){
			var amount = parseFloat(this.payment.amount_applied);
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
			if(this.payment.payment_applied != ''){
				if(amount >= this.pdi){
					amount -= this.pdi;
					this.payment.pdi = this.pdi;
				}else{
					this.payment.pdi = amount;
					this.payment.short_pdi = this.pdi - amount;
					this.payment.short_penalty = this.penalty;
					this.payment.short_interest = this.totalInterest;
					this.payment.short_principal = this.totalPrincipal;
					amount = 0;
				}
				if(amount >= this.penalty){
					amount -= this.loanAccount.current_amortization.penalty;
					this.payment.penalty = this.loanAccount.current_amortization.penalty;
				}else{
					this.payment.penalty = amount;
					this.payment.short_penalty = this.penalty - amount;
					this.payment.short_interest = this.totalInterest;
					this.payment.short_principal = this.totalPrincipal;
					amount = 0;
				}
				// maybe add rebates here?
				// amount += this.payment.rebates;
				if(amount + this.payment.rebates >= this.totalInterest){
					this.payment.interest = this.totalInterest;
					// this.payment.interest = this.payment.interest - this.payment.rebates < 0 ? 0 : this.payment.interest - this.payment.rebates;
					amount -= this.payment.interest;
				}else{
					this.payment.interest = amount;
					this.payment.short_interest = this.totalInterest - amount;
					this.payment.short_principal = this.totalPrincipal;
					// this.payment.interest = this.payment.interest - this.payment.rebates < 0? 0 : this.payment.interest - this.payment.rebates;
					amount = 0;
				}
				amount += this.loanAccount.current_amortization.advance_principal;
				if(amount >= this.totalPrincipal){
					this.payment.principal = this.totalPrincipal;
					if(this.overPayment <= 0){
						this.payment.advance_principal = amount - this.totalPrincipal;
					}
				}else{
					this.payment.principal = amount;
					this.payment.short_principal = this.totalPrincipal - amount;
					amount = 0;
				}
				this.payment.over_payment = this.overPayment;
			}
		},
		pay:function(){
			this.payment.loan_account_id = this.loanAccount.loan_account_id;
			axios.post(this.baseURL() + 'api/payment', this.payment, {
				headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
				}
			})
			.then(function (response) {
				var btn = document.getElementById('paymentCancelBtn');
				btn.click();
				this.notify('','Payment successful.', 'success');
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		disabled:function(element){
			return !element? true : false;
		}
	},
	computed:{
		totalPrincipal:function(){
			return this.loanAccount.current_amortization.principal + this.loanAccount.current_amortization.short_principal;
		},
		totalInterest:function(){
			return this.loanAccount.current_amortization.interest + this.loanAccount.current_amortization.short_interest;
		},
		totalDue:function(){
			return this.totalPrincipal + this.totalInterest + this.pdi + this.penalty;
		},
		pdi:function(){
			return this.waive.pdi? 0 : this.loanAccount.current_amortization.pdi;
		},
		penalty:function(){
			return this.waive.penalty? 0 : this.loanAccount.current_amortization.penalty;
		},
		totalWaive:function(){
			var val = 0;
			if(this.waive.pdi){
				val += this.loanAccount.current_amortization.pdi;
			}
			if(this.waive.penalty){
				val += this.loanAccount.current_amortization.penalty;
			}
			return val;
		},
		totalScheduledPayment:function(){
			if(this.loanAccount.current_amortization.lastPayment){
				return this.loanAccount.current_amortization.interest + this.loanAccount.current_amortization.principal + this.loanAccount.current_amortization.lastPayment.short_principal + this.loanAccount.current_amortization.lastPayment.short_interest;
			}
			return this.loanAccount.current_amortization.interest + this.loanAccount.current_amortization.principal;
		},
		borrowerPhoto:function(){
			return this.pborrower.photo? this.pborrower.photo : '/img/user.png';
		},
		lastTransactionDate:function(){
			return this.loanAccount.current_amortization.lastPayment? this.dateToMDY2(new Date()) : 'None';
		},
		totalBalance:function(){
			return this.totalDue + parseFloat(this.loanAccount.current_amortization.principal_balance) + parseFloat(this.loanAccount.current_amortization.interest_balance)
		},
		amountDistributed:function(){ // just for overpayment calculation
			return parseFloat(this.payment.amount_applied) + parseFloat(this.loanAccount.current_amortization.advance_principal)
			// maybe add rebates?
		},
		totalShort:function(){
			return this.payment.short_pdi + this.payment.short_penalty + this.payment.short_interest + this.payment.short_principal;
		},
		dueExcess:function(){
			return this.payment.advance_principal + this.payment.over_payment;
		},
		overPayment:function(){
			if(this.totalBalance < this.amountDistributed){
				return Math.abs(this.totalBalance - this.amountDistributed )
			}
			return 0;
		},
	},
	watch:{
		'payment.amount_applied':function(newValue){
			if(newValue != ''){
				this.distribute();
			}
		},
		'loanAccount.loan_account_id':function(newValue){
			this.payment.total_payable = this.totalDue;
			this.payment.amortization_id = this.loanAccount.current_amortization.id;
		},
		'waive.pdi':function(newValue){
			this.distribute();
		},
		'waive.penalty':function(newValue){
			this.distribute();
		},
	},
	mounted(){

	}
}
</script>

<style lang="scss" scoped>
	.active {
		background-color: #eee;
	}
</style>