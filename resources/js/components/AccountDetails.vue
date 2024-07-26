<template>

	<section v-if="loanDetails.loan_account_id" id="accountDetails" class="">
		<notifications group="foo" />
		<div class="flex-col accounts-list">
			<div class="card mb-12">
				<div class="card-header" style="background-color:#dfdfd0!important;">
					<h3 class="card-title" style="color: #283f53;">Account Number: {{loanDetails.account_num}}</h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
							<i class="fas fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="card-body p-0" style="padding:25px 20px!important">
					<div class="flex mb-16">
						<div class="flex-col granted-amount mr-24">
							<span>Amount Granted</span>
							<span>P {{formatToCurrency(loanDetails.loan_amount)}}</span>
						</div>
						<div class="flex-col flex-1">
							<div class="row mb-16">
								<div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Amortization</span>
										<span>P {{loanDetails.type == "Prepaid"? formatToCurrency(Math.ceil(loanDetails.loan_amount/loanDetails.no_of_installment)) : formatToCurrency(loanDetails.amortization.total)}}</span>
									</div>
								</div>
								<div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Release Date</span>
										<span>{{dateToMDY(new Date(loanDetails.date_release))}}</span>
									</div>
								</div>
								<div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Term</span>
										<span>{{loanDetails.terms}} Days / {{Math.ceil(loanDetails.terms/30)}} Month (s)</span>
									</div>
								</div>
								<div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Due Date</span>
										<span>{{dateToMDY(new Date(loanDetails.due_date))}}</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Interest</span>
										<span>{{loanDetails.interest_rate}}%</span>
									</div>
								</div>
								<div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Mode</span>
										<span>{{loanDetails.payment_mode}}</span>
									</div>
								</div>
								<!-- <div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Group</span>
										<span>Various Pension</span>
									</div>
								</div> -->
								<div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Type</span>
										<span>{{loanDetails.type}}</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row mb-16">
						<div class="col-xl-3 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Product Name</span>
								<span>{{loanDetails.product.product_name}}</span>
							</div>
						</div>
						<div class="col-xl-2 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Cycle</span>
								<span>{{loanDetails.cycle_no}}</span>
							</div>
						</div>
						<div class="col-xl-2 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Status</span>
								<span>{{loanDetails.loan_status_view}}</span>
							</div>
						</div>
						<div class="col-xl-2 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Center</span>
								<span>{{loanDetails.center?loanDetails.center.center:''}}</span>
							</div>
						</div>
						<div class="col-xl-3 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Collection Rate</span>
								<span>{{loanDetails.collection_rate}}%</span>
							</div>
						</div>
					</div>

					<div class="row mb-16">
						<div class="col-xl-3 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Co-Borrower</span>
								<span>{{loanDetails.co_borrower_name}}</span>
							</div>
						</div>
						<div class="col-xl-5 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Co-Borrower Address</span>
								<span>{{loanDetails.co_borrower_address}}</span>
							</div>
						</div>
						<div class="col-xl-2 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Co-Borrower ID Type</span>
								<span>{{loanDetails.co_borrower_id_type}}</span>
							</div>
						</div>
						<div class="col-xl-2 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Co-Borrower ID</span>
								<span>{{loanDetails.co_borrower_id_number}}</span>
							</div>
						</div>
					</div>

					<div class="row mb-45">
						<div class="col-xl-3 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Co-Maker</span>
								<span>{{loanDetails.co_maker_name}}</span>
							</div>
						</div>
						<div class="col-xl-5 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Co-Maker Address</span>
								<span>{{loanDetails.co_maker_address}}</span>
							</div>
						</div>
						<div class="col-xl-2 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Co-Maker ID Type</span>
								<span>{{loanDetails.co_maker_id_type}}</span>
							</div>
						</div>
						<div class="col-xl-2 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Co-Maker ID</span>
								<span>{{loanDetails.co_maker_id_number}}</span>
							</div>
						</div>
					</div>

					<!-- <div class="flex-col payments-list" v-if="showPayments">
						<span class="header">Payments</span>

					</div> -->

					<div class="card card-primary card-outline card-tabs" style="border-top: 3px solid #283f53;">
						<div class="card-header p-0 pt-1 border-bottom-0">
							<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
								<li class="nav-item">
								<a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Payments</a>
								</li>
								<li class="nav-item">
								<a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Amortization Schedule</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="custom-tabs-three-tabContent">
								<div class="tab-pane fade active show" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
									<table class="table table-stripped mb-64">
										<thead>
											<th>Date</th>
											<th>O.R. #</th>
			
											<th>Reference</th>
											<th>Principal</th>
											<th>Interest</th>
											<th>PDI</th>
											<th>Penalty</th>
											<th>Rebates</th>
											<th>Over Payment</th>
											<th>Total Payment</th>
											<th>Total Payable</th>
                                            <th>Cheque No.</th>
                                            <th>Bank Name</th>
		
											<th></th>
										</thead>
										<tbody>
											<tr v-for="(p,pi) in loanDetails.payments" :key="pi">
												<td>{{dateToMDY(new Date(p.transaction_date))}}</td>
												<td>{{p.or_no}}</td>
												<td>{{p.transaction_number}}</td>
												<!-- <td>{{p.reference_no}}</td> -->
												<td>{{formatToCurrency(p.principal)}}</td>
												<td>{{formatToCurrency(p.interest)}}</td>
												<td>{{formatToCurrency(p.pdi)}}</td>
												<td>{{formatToCurrency(p.penalty)}}</td>
												<td>{{formatToCurrency(p.rebates)}}</td>
												<td>{{formatToCurrency(p.over_payment)}}</td>
												<td>{{formatToCurrency(p.amount_applied)}}</td>
												<td>{{formatToCurrency(p.total_payable)}}</td>
                                                <td>{{ p.cheque_no }}</td>
                                                <td>{{ p.bank_name }}</td>
												<!-- <td>{{p.status == 'cancelled' ? 'Cancelled' + (p.remarks ? ' - ' + p.remarks : '') : ''}}</td> -->
												<td><a v-show="hasAccessToEdit" @click.prevent="editPayment=p" data-toggle="modal" data-target="#editPaymentModal" href=""><i class="fa fa-edit"></i></a></td>
											</tr>
											<tr v-if="loanDetails.payments.length==0">
												<td>No payments yet.</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
									<div class="flex-col payments-list" v-if="showPayments">
										<!-- <span class="header">Schedules</span> -->
										<table class="table table-stripped mb-64">
										<thead>
											<th>No.</th>
											<th>Date</th>
											<th>Principal</th>
											<th>Interest</th>
											<th>Total</th>
											<th>Principal Balance</th>
											<th>Interest Balance</th>
											<th>Status</th>
											<th></th>
										</thead>
										<tbody>
											<tr v-for="(as, a) in amortSched" :key="a">
												<td>{{a + 1}}</td>
												<td>{{dateToMDY(new Date(as.amortization_date))}}</td>
												<td>{{formatToCurrency(as.principal)}}</td>
												<td>{{formatToCurrency(as.interest)}}</td>
												<td>{{formatToCurrency(as.total)}}</td>
												<td>{{formatToCurrency(as.principal_balance)}}</td>
												<td>{{formatToCurrency(as.interest_balance)}}</td>
												<td>{{upperFirst(as.status)}}</td>
												<td><a v-show="hasAccessToEdit" @click.prevent="editAmort=as" data-toggle="modal" data-target="#editAmortizationModal" href=""><i class="fa fa-edit"></i>Edit</a></td>
											</tr>
											<tr v-if="loanDetails.payments.length==0">
												<td>No payments yet.</td>
											</tr>
										</tbody>
									</table>
									</div>
								</div>
							</div>
						</div>
					</div>



					<div class="flex-col schedule-row" v-if="showSchedule">
                        <div class="sep mb-24"></div>
						<div class="d-flex">
							<div class="flex-1 d-flex flex-column justify-content-between pr-16 br-primary-dark">
								<div class="mb-45">
									<span class="pb-10 text-primary-dark text-lg bb-primary-dark text-bold text-block">Amortization Scheduled Payment</span>
									<div class="d-flex justify-content-between py-5 text-primary-dark">
										<div class="flex-4 d-flex justify-content-between">
											<span>Date</span>
											<span>:</span>
										</div>
										<span class="flex-3 pl-10">{{loanDetails.current_amortization.amortization_date}}</span>
									</div>
									<div class="d-flex justify-content-between py-5 text-primary-dark">
										<div class="flex-4 d-flex justify-content-between">
											<span>Amort. Principal</span>
											<span>:</span>
										</div>
										<span class="flex-3 pl-10">P {{formatToCurrency(loanDetails.current_amortization.schedule_principal)}}</span>
									</div>
									<div class="d-flex justify-content-between py-5 text-primary-dark">
										<div class="flex-4 d-flex justify-content-between">
											<span>Interest</span>
											<span>:</span>
										</div>
										<span class="flex-3 pl-10">P {{formatToCurrency(loanDetails.current_amortization.schedule_interest)}}</span>
									</div>
								</div>
								<div>
									<span class="text-lg text-bold text-primary-dark">TOTAL</span>
									<span class="text-block bg-primary-dark text-white px-16 text-45 mr-36">P {{formatToCurrency(totalScheduledPayment)}}</span>
								</div>
							</div>
							<div class="flex-1 px-16 br-primary-dark d-flex flex-column justify-content-between">
								<div class="mb-45">
									<span class="pb-10 text-primary-dark text-lg bb-primary-dark text-bold text-block">Total Amount Due</span>
									<div class="d-flex justify-content-between py-5 text-primary-dark">
										<div class="flex-4 d-flex justify-content-between">
											<span>Principal</span>
											<span>:</span>
										</div>
										<span class="flex-3 pl-10">P {{formatToCurrency(duePrincipal)}}</span>
									</div>
									<div class="d-flex justify-content-between py-5 text-primary-dark">
										<div class="flex-4 d-flex justify-content-between">
											<span>Interest</span>
											<span>:</span>
										</div>
										<span class="flex-3 pl-10">P {{formatToCurrency(dueInterest)}}</span>
									</div>
									<div class="d-flex justify-content-between py-5 text-primary-dark">
										<div class="flex-4 d-flex justify-content-between">
											<span>Penalty</span>
											<span>:</span>
										</div>
										<span class="flex-3 pl-10">P {{formatToCurrency(duePenalty)}}</span>
									</div>
									<div class="d-flex justify-content-between py-5 text-primary-dark">
										<div class="flex-4 d-flex justify-content-between">
											<span>PDI</span>
											<span>:</span>
										</div>
										<span class="flex-3 pl-10">P {{formatToCurrency(duePdi)}}</span>
									</div>
								</div>
								<div>
									<span class="text-lg text-bold text-primary-dark">TOTAL</span>
									<span class="text-block bg-primary-dark text-white px-16 text-45 mr-36">P {{formatToCurrency(totalDue)}}</span>
								</div>
							</div>
							<div class="flex-1 px-16 d-flex flex-column justify-content-between">
								<div class="mb-45">
									<span class="pb-10 text-primary-dark text-lg bb-primary-dark text-bold text-block">Outstanding Balance</span>
									<div class="d-flex justify-content-between py-5 text-primary-dark">
										<div class="flex-4 d-flex justify-content-between">
											<span>Principal Balance</span>
											<span>:</span>
										</div>
										<span class="flex-3 pl-10">P {{formatToCurrency(loanDetails.remaining_balance.principal.balance)}}</span>
									</div>
									<div class="d-flex justify-content-between py-5 text-primary-dark">
										<div class="flex-4 d-flex justify-content-between">
											<span>Interest Balance</span>
											<span>:</span>
										</div>
										<span class="flex-3 pl-10">P {{formatToCurrency(loanDetails.remaining_balance.interest.balance - loanDetails.remaining_balance.rebates.credit)}}</span>
									</div>
									<div class="d-flex justify-content-between py-5 text-primary-dark">
										<div class="flex-4 d-flex justify-content-between">
											<span>Surcharge</span>
											<span>:</span>
										</div>
										<span class="flex-3 pl-10">P {{formatToCurrency(loanDetails.remaining_balance.pdi.balance + loanDetails.remaining_balance.penalty.balance)}}</span>
									</div>
								</div>
								<div>
									<span class="text-lg text-bold text-primary-dark">TOTAL</span>
									<span class="text-block bg-primary-dark text-white px-16 text-45 mr-36">P {{formatToCurrency(loanDetails.remaining_balance.memo.balance+loanDetails.remaining_balance.pdi.balance + loanDetails.remaining_balance.penalty.balance )}}</span>
								</div>
							</div>
							<div class="flex-1 px-16"></div>
						</div>
						<div class="d-flex">
							<div class="flex-1 d-flex flex-column pr-16 br-primary-dark">
								<div class="d-flex flex-column pxy-15 mt-10 bg-peach mr-36">
									<div class="d-flex justify-content-between text-primary-dark">
										<div class="flex-4 d-flex justify-content-between">
											<span>Short Principal</span>
											<span>:</span>
										</div>
										<span class="flex-3 pl-10">P {{formatToCurrency(loanDetails.current_amortization.short_principal)}}</span>
									</div>
									<div class="d-flex justify-content-between mb-10 text-primary-dark">
										<div class="flex-4 d-flex justify-content-between">
											<span>Adv. Principal</span>
											<span>:</span>
										</div>
										<span class="flex-3 pl-10">P {{formatToCurrency(loanDetails.current_amortization.advance_principal)}}</span>
									</div>
									<div class="d-flex justify-content-between text-primary-dark">
										<div class="flex-4 d-flex justify-content-between">
											<span>Short Interest</span>
											<span>:</span>
										</div>
										<span class="flex-3 pl-10">P {{formatToCurrency(loanDetails.current_amortization.short_interest)}}</span>
									</div>
									<div class="d-flex justify-content-between text-primary-dark">
										<div class="flex-4 d-flex justify-content-between">
											<span>Adv. Interest</span>
											<span>:</span>
										</div>
										<span class="flex-3 pl-10">P {{formatToCurrency(loanDetails.current_amortization.advance_interest)}}</span>
									</div>
								</div>
							</div>
							<div class="flex-1 px-16 br-primary-dark d-flex flex-column justify-content-between">

							</div>
							<div class="flex-1 px-16 d-flex flex-column justify-content-between">

							</div>
							<div class="flex-1 px-16"></div>
						</div>
					</div>

				</div>

			</div>

		</div>






		<div class="modal" id="editPaymentModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<form @submit.prevent="">
							<section class="mb-24 p-16" style="flex:21;padding-left:16px;">
								<span class="section-title mb-12">Edit Payment</span>
								<div class="d-flex flex-column">
									<div class="d-flex flex-column flex-lg-row">
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Principal</label>
											<div class="form-group">
												<input v-model="editPayment.principal" type="number" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Interest</label>
											<div class="form-group">
												<input v-model="editPayment.interest" type="number" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">PDI</label>
											<div class="form-group">
												<input v-model="editPayment.pdi" type="number" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Penalty</label>
											<div class="form-group">
												<input v-model="editPayment.penalty" type="number" class="form-control form-input">
											</div>
										</div>
									</div>


									<div class="d-flex flex-column flex-lg-row">
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Rebates</label>
											<div class="form-group">
												<input v-model="editPayment.rebates" type="number" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Total Payment</label>
											<div class="form-group">
												<input v-model="editPayment.amount_applied" type="number" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Total Payable</label>
											<div class="form-group">
												<input v-model="editPayment.total_payable" type="number" class="form-control form-input">
											</div>
										</div>


										<!-- <div class="form-group mb-10 mr-16 flex-1 d-flex align-items-end">
											<button @click="updatePayment()" data-dismiss="modal" class="btn btn-success" style="margin-bottom:1rem;width:100%;height:47px;">UPDATE</button>
										</div> -->
									</div>
                                    <div class="d-flex flex-column flex-lg-row">
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Short Principal</label>
											<div class="form-group">
												<input v-model="editPayment.short_principal" type="number" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Adv. Principal</label>
											<div class="form-group">
												<input v-model="editPayment.advance_principal" type="number" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Adv. Interest</label>
											<div class="form-group">
												<input v-model="editPayment.advance_interest" type="number" class="form-control form-input">
											</div>
										</div>
                                        <div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Short Interest</label>
											<div class="form-group">
												<input v-model="editPayment.short_interest" type="number" class="form-control form-input">
											</div>
										</div>


										<!-- <div class="form-group mb-10 mr-16 flex-1 d-flex align-items-end">
											<button @click="updatePayment()" data-dismiss="modal" class="btn btn-success" style="margin-bottom:1rem;width:100%;height:47px;">UPDATE</button>
										</div> -->
									</div>

                                    <div class="d-flex flex-column flex-lg-row">
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Rebates Approval No.</label>
											<div class="form-group">
												<input v-model="editPayment.rebates_approval_no" type="text" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Penalty Approval No.</label>
											<div class="form-group">
												<input v-model="editPayment.penalty_approval_no" type="text" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Pdi Approval No.</label>
											<div class="form-group">
												<input v-model="editPayment.pdi_approval_no" type="text" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">VAT</label>
											<div class="form-group">
												<input v-model="editPayment.vat" type="text" class="form-control form-input">
											</div>
										</div>
									</div>

									 <div class="d-flex flex-column flex-lg-row">
										<div class="form-group mb-10 mr-16 flex-1"></div>
										<div class="form-group mb-10 mr-16 flex-1"></div>
										<div class="form-group mb-10 mr-16 flex-1"></div>
										<div class="form-group mb-10 mr-16 flex-1 d-flex align-items-end">
											<button @click="updatePayment()" data-dismiss="modal" class="btn btn-success" style="margin-bottom:1rem;width:100%;height:47px;">UPDATE</button>
										</div>
									</div>

									<div class="d-flex flex-column flex-lg-row">
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Amortization Schedule</label>
											<div class="form-group">
												<select v-model="editPayment.amortization_id" class="form-control form-input">
													<template v-for="sched in amortSched">
														<option :value="sched.id">{{sched.amortization_date}}</option>
													</template>
												</select>
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1 d-flex align-items-end">
											<button @click="updatePaymentDistribute()" data-dismiss="modal" class="btn btn-warning" style="margin-bottom:1rem;width:100%;height:47px;">Update and Distribute</button>
										</div>
									</div>
								</div>
							</section>
						</form>
					</div>
				</div>
			</div>
		</div>


		<div class="modal" id="editAmortizationModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<form @submit.prevent="">
							<section class="mb-24 p-16" style="flex:21;padding-left:16px;">
								<span class="section-title mb-12">Edit Amortization</span>
								<div class="d-flex flex-column">

									<div class="d-flex flex-column flex-lg-row">
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Date</label>
											<div class="form-group">
												<input v-model="editAmort.amortization_date" type="date" class="form-control form-input">
											</div>
										</div>
											<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Principal</label>
											<div class="form-group">
												<input v-model="editAmort.principal" type="number" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Interest</label>
											<div class="form-group">
												<input v-model="editAmort.interest" type="number" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Total</label>
											<div class="form-group">
												<input v-model="editAmort.total" type="number" class="form-control form-input">
											</div>
										</div>
									</div>


									<div class="d-flex flex-column flex-lg-row">
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Principal Balance</label>
											<div class="form-group">
												<input v-model="editAmort.principal_balance" type="number" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Interest Balance</label>
											<div class="form-group">
												<input v-model="editAmort.interest_balance" type="number" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Status</label>
											<div class="form-group">
												<select v-model="editAmort.status" class="form-control form-input">
													<option value="open">Open</option>
													<option value="paid">Paid</option>
													<option value="delinquent">Delinquent</option>
												</select>
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1 d-flex align-items-end">
											<button @click="updateAmort()" data-dismiss="modal" class="btn btn-success" style="margin-bottom:1rem;width:100%;height:47px;">UPDATE</button>
										</div>
									</div>
								</div>
							</section>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

</template>

<script>
	export default {
		props:['ploanDetails','showPayments','showSchedule','token'],
		data(){
			return {
				amortSched:[],
				editPayment:{},
				editAmort:{},
                authUser:{},
                hasAccessToEdit:false,
				loanDetails:{
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
					filing_fee : 0,
					insurance : 0,
					notarial_fee : '100.00',
					prepaid_interest : 0,
					affidavit_fee : 0,
					memo : 0,
					total_deduction : 0,
					net_proceeds : 0,
					release_type : 0,
					interest_rate:0,
					interest_amount:0,
					documents: {
						date_release: '',
						description: '',
						bank: '',
						account_no: '',
						card_no:'',
						promissory_number: '',
					},
					outstandingBalance:{
						principal_balance:0,
						interest_balance:0,
						surcharge:0,
					},
					current_amortization:{
						principal:0,
						interest:0,
						short_interest:0,
						advance_interest:0,
						short_principal:0,
						advance_principal:0,
						outstandingBalance:{
							principal_balance:0,
							interest_balance:0,
							surcharge:0,
						},
						lastPayment:{
							principal:0,
							interest:0,
							short_interest:0,
							advance_interest:0,
							short_principal:0,
							advance_principal:0,
						}
					},
					payments:[],
					remaining_balance:{
						memo:{
							debit:0,
							credit:0,
							balance:0
						},
						principal:{
							debit:0,
							credit:0,
							balance:0
						},
						interest:{
							debit:0,
							credit:0,
							balance:0
						},
						pdi:{
							debit:0,
							credit:0,
							balance:0
						},
						penalty:{
							debit:0,
							credit:0,
							balance:0
						}
					},
					loan_status_view:''
				}
			}
		},
		methods:{
            async fetchAuthUser() {
                await axios.get(this.baseURL() + 'api/auth', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
                    this.authUser = response.data
                    this.hasAccessToEdit = this.authUser.accessibility.some(accessibility => accessibility['permission'] === 'edit payment in statement of account');


				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
            },
			async fetchAmortSched(){
				await axios.get(this.baseURL() + 'api/account/amortizations/' + this.loanDetails.loan_account_id, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					// console.log(response.data);
					this.amortSched = response.data.data;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
			fetchAccount:function(id){
				this.$emit('load');
				axios.get(this.baseURL() + 'api/account/show/' + id, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.$emit('unload');
					this.loanDetails = response.data.data;
					this.fetchAmortSched();
				}.bind(this))
				.catch(function (error) {
					this.$emit('unload');
					console.log(error);
				}.bind(this));
			},
			updatePayment:function(){
				axios.put(this.baseURL() + 'api/payment/' + this.editPayment.payment_id, this.editPayment, {
					headers: {
							'Authorization': 'Bearer ' + this.token,
							'Content-Type': 'application/json',
							'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.notify('','Payment successfully updated.', 'success');
				}.bind(this))
				.catch(function (error) {
					console.log(error);
					this.notify('',error.response.data.data, 'error');
				}.bind(this));
			},
			updatePaymentDistribute:function(){
				axios.put(this.baseURL() + 'api/payment/' + this.editPayment.payment_id, this.editPayment, {
					headers: {
							'Authorization': 'Bearer ' + this.token,
							'Content-Type': 'application/json',
							'Accept': 'application/json'
					}
				})
				.then(function (response) {
					axios.get(this.baseURL() + 'api/migrate/loanAccount?type=realtime&account_num=' + this.loanDetails.account_num, {
						headers: {
								'Authorization': 'Bearer ' + this.token,
								'Content-Type': 'application/json',
								'Accept': 'application/json'
						}
					})
					.then(function (response) {
						this.notify('','Payment successfully updated.', 'success');
					}.bind(this))
					.catch(function (error) {
						console.log(error);
						this.notify('',error.response.data.data, 'error');
					}.bind(this));
				}.bind(this))
				.catch(function (error) {
					console.log(error);
					this.notify('',error.response.data.data, 'error');
				}.bind(this));
			},
			updateAmort:function(){
				axios.post(this.baseURL() + 'api/account/amortizations/update/' + this.editAmort.id, this.editAmort, {
					headers: {
							'Authorization': 'Bearer ' + this.token,
							'Content-Type': 'application/json',
							'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.notify('','Amortization successfully updated.', 'success');
				}.bind(this))
				.catch(function (error) {
					console.log(error);
					this.notify('',error.response.data.data, 'error');
				}.bind(this));
			},
			notify:function(title, text, type){
				this.$notify({
					group: 'foo',
					title: title,
					text: text,
					type: type,
				});
			},
		},
		computed:{
			totalAmountBalance:function(){
				var amount = this.loanDetails.loan_amount;
				this.loanDetails.payments.map(function(val){
					amount-=val.principal;
				}.bind(this));
				return amount;

			},
			totalInterestBalance:function(){
				var amount = this.loanDetails.interest_amount;
				this.loanDetails.payments.map(function(val){
					amount-=val.interest;
				}.bind(this));
				return amount;
			},
			totalPrincipalPaid:function(){
				var amount = 0;
				this.loanDetails.payments.map(function(val){
					amount+=val.principal;
				}.bind(this));
				return amount;
			},
			totalInterestPaid:function(){
				var amount = 0;
				this.loanDetails.payments.map(function(val){
					amount+=val.interest;
				}.bind(this));
				return amount;
			},
			totalScheduledPayment:function(){
				return this.loanDetails.current_amortization.schedule_interest + this.loanDetails.current_amortization.schedule_principal;
			},
			totalInterest:function(){
				return this.loanDetails.current_amortization.interest + this.loanDetails.current_amortization.short_interest;
			},
			totalPrincipal:function(){
				return this.loanDetails.current_amortization.principal + this.loanDetails.current_amortization.short_principal;
			},
			duePdi:function(){
				if(this.loanDetails.remaining_balance){
					return this.loanDetails.remaining_balance.pdi.balance;
				}
				return 0;
			},
			duePenalty:function(){
				return this.loanDetails.current_amortization.penalty + this.loanDetails.current_amortization.short_penalty;
			},
			dueInterest:function(){
				return this.totalInterest > this.loanDetails.current_amortization.advance_interest ? this.totalInterest - this.loanDetails.current_amortization.advance_interest : 0;
			},
			duePrincipal:function(){
				return this.totalPrincipal > this.loanDetails.current_amortization.advance_principal ? this.totalPrincipal - this.loanDetails.current_amortization.advance_principal : 0;
			},
			totalDue:function(){
				return this.duePrincipal + this.dueInterest + this.duePdi + this.duePenalty;
			},
			excessAdvancePrincipal:function(){
				return this.loanDetails.current_amortization.advance_principal < this.totalPrincipal ? 0 : this.loanDetails.current_amortization.advance_principal - this.totalPrincipal;
			},
			excessAdvanceInterest:function(){
				return this.loanDetails.current_amortization.advance_interest < this.totalInterest ? 0 : this.loanDetails.current_amortization.advance_interest - this.totalInterest;
			},
			outstandingInterest:function(){
				return this.loanDetails.current_amortization.interest_balance + this.dueInterest - this.excessAdvanceInterest;
			},
			outstandingPrincipalRemaining:function(){
				return this.loanDetails.current_amortization.principal_balance + this.duePrincipal - this.excessAdvancePrincipal;
			},
			outstandingInterestRemaining:function(){
				return this.outstandingInterest;
			},
			outstandingSurchargeRemaining: function(){
				return this.duePdi + this.duePenalty;
			},
			outstandingTotalRemaining:function(){
				return this.outstandingPrincipalRemaining + this.outstandingInterestRemaining + this.outstandingSurchargeRemaining;
			},
		},
		watch:{
			'ploanDetails':function(val){
				this.fetchAccount(val);
			}
		},
		mounted(){
            this.fetchAuthUser();
			this.fetchAccount(this.ploanDetails);
		}
	}
</script>
