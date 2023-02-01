<template>

	<section v-if="loanDetails.loan_account_id" id="accountDetails" class="">
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
										<span>P {{formatToCurrency(loanDetails.amortization.total)}}</span>
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

					<div class="flex-col payments-list" v-if="showPayments">
						<span class="header">Payments</span>
						<table class="table table-stripped mb-64">
							<thead>
								<th>Date</th>
								<th>O.R. #</th>
								<th>Trans. #</th>
								<th>Reference</th>
								<th>Principal</th>
								<th>Interest</th>
								<th>PDI</th>
								<th>Penalty</th>
								<th>Rebates</th>
								<th>Over Payment</th>
								<th>Total Payment</th>
								<th>Remarks</th>
							</thead>
							<tbody>
								<tr v-for="(p,pi) in loanDetails.payments" :key="pi">
									<td>{{dateToMDY(new Date(p.transaction_date))}}</td>
									<td>{{p.or_no}}</td>
									<td>{{p.transaction_number}}</td>
									<td>{{p.reference_no}}</td>
									<td>{{formatToCurrency(p.principal)}}</td>
									<td>{{formatToCurrency(p.interest)}}</td>
									<td>{{formatToCurrency(p.pdi)}}</td>
									<td>{{formatToCurrency(p.penalty)}}</td>
									<td>{{formatToCurrency(p.rebates)}}</td>
									<td>{{formatToCurrency(p.over_payment)}}</td>
									<td>{{formatToCurrency(p.amount_applied)}}</td>
									<td>{{p.status == 'cancelled' ? 'Cancelled' + (p.remarks ? ' - ' + p.remarks : '') : ''}}</td>
								</tr>
								<tr v-if="loanDetails.payments.length==0">
									<td>No payments yet.</td>
								</tr>
							</tbody>
						</table>
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
										<span class="flex-3 pl-10">P {{formatToCurrency(loanDetails.remaining_balance.interest.balance)}}</span>
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
									<span class="text-block bg-primary-dark text-white px-16 text-45 mr-36">P {{formatToCurrency(loanDetails.remaining_balance.memo.balance)}}</span>
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
	</section>

</template>

<script>
	export default {
		props:['ploanDetails','showPayments','showSchedule','token'],
		data(){
			return {
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
			fetchAccount:function(id){
				axios.get(this.baseURL() + 'api/account/show/' + id, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.loanDetails = response.data.data;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
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
			this.fetchAccount(this.ploanDetails);
		}
	}
</script>