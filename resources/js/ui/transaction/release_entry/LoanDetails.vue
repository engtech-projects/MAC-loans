<template>
	<form @submit.prevent="submit" action="">
	<div class="d-flex flex-column">
		<notifications group="foo" />
		<section class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Loan Details</span>
			<div class="d-flex flex-row">
				<div style="flex:18" class="mr-16"></div>
				<div class="form-group mb-10" style="flex:7">
					<label for="dateRelease" class="form-label">Loan Created</label>
					<input v-model="loanDetails.transaction_date" disabled type="date" class="form-control form-input " id="dateRelease">
				</div>
			</div>
			<div class="d-flex flex-row">
				<div class="form-group mb-10 mr-16" style="flex:3">
					<label for="cycleNumber" class="form-label">Cycle Number</label>
					<input v-model="loanDetails.cycle_no" disabled type="text" class="form-control form-input " id="cycleNumber">
				</div>
				<div class="form-group mb-10 mr-16" style="flex:7">
					<label for="accountOfficer" class="form-label">Account Officer</label>
					<select required v-model="loanDetails.ao_id" name="" id="" class="form-control form-input ">
						<option v-for="ao in accountOfficers" :key="ao.ao_id" :value="ao.ao_id">{{ao.name}}</option>
					</select>
				</div>
				<div class="form-group mb-10 mr-16" style="flex:7">
					<label for="product" class="form-label">Product</label>
					<select @change="setInterestRate();setCenterSched();" required v-model="loanDetails.product_id" name="" id="" class="form-control form-input ">
						<option v-for="prod in products" :key="prod.product_id" :value="prod.product_id">{{prod.product_name}}</option>
					</select>
				</div>
				<div class="form-group mb-10" style="flex:7">
					<label for="accountNumber" class="form-label">Account Number</label>
					<input :value="loanDetails.borrower_num" disabled type="text" class="form-control form-input" id="accountNumber">
				</div>
			</div>
			<div class="d-flex flex-row">
				<div class="form-group mb-10 mr-16" style="flex:7">
					<label for="center" class="form-label">Center</label>
					<select v-if="!productEnable" disabled required v-model="loanDetails.center_id" name="" id="" class="form-control form-input ">
						<!-- <option v-for="center in centers" :key="center.center_id" :value="center.center_id">{{center.center}}</option> -->
					</select>
					<select v-if="productEnable" required v-model="loanDetails.center_id" name="" id="" class="form-control form-input ">
						<option v-for="center in centers" :key="center.center_id" :value="center.center_id">{{center.center}}</option>
					</select>
				</div>
				<div class="form-group mb-10 mr-16" style="flex:7">
					<label for="type" class="form-label">Type</label>
					<select required v-model="loanDetails.type" name="" id="" class="form-control form-input ">
						<option value="Add-On">Add-On</option>
						<option value="Prepaid">Prepaid</option>
					</select>
				</div>
				<div class="form-group mb-10" style="flex:7">
					<label for="mode" class="form-label">Mode</label>
					<select required v-model="loanDetails.payment_mode" name="" id="" class="form-control form-input ">
						<option value="Monthly">Monthly</option>
						<option value="Bi-Monthly">Bi-Monthly</option>
						<option value="Weekly">Weekly</option>
						<option value="Lumpsum">Lumpsum</option>
					</select>
				</div>
			</div>
			<div class="d-flex flex-row pb-45 mb-24" style="border-bottom:1px solid #dfdfd0">
				<div class="form-group mb-10 mr-16" style="flex:7">
					<label for="center" class="form-label">Loan Amount</label>
					<input @blur="inputs.loanAmount=false" v-if="inputs.loanAmount" required v-model="loanDetails.loan_amount" type="number" class="form-control form-input " id="center">
					<input @focus="inputs.loanAmount=true" v-if="!inputs.loanAmount" required :value="formatToCurrency(loanDetails.loan_amount)" type="text" class="form-control form-input " id="center">
				</div>
				<div class="form-group mb-10 mr-16" style="flex:4">
					<label for="group" class="form-label">Terms/Days</label>
					<input required v-model="loanDetails.terms" type="number" class="form-control form-input " id="group">
				</div>
				<div class="form-group mb-10 mr-16" style="flex:5">
					<label for="type" class="form-label">Day Schedule</label>
					<select v-if="!productEnable" disabled required v-model="loanDetails.day_schedule" class="form-control form-input " id="type">

					</select>
					<select v-if="productEnable" required v-model="loanDetails.day_schedule" class="form-control form-input " id="type">
						<option value="daily">Daily</option>
						<option value="monday">Monday</option>
						<option value="tuesday">Tuesday</option>
						<option value="wednesday">Wednesday</option>
						<option value="thursday">Thursday</option>
						<option value="friday">Friday</option>
					</select>
				</div>
				<div style="flex:9"></div>
			</div>

			<div class="d-flex flex-row">
				<div class="form-group mb-10 mr-16" style="flex:6">
					<label for="interestRate" class="form-label">Interest Rate</label>
					<input required v-model="loanDetails.interest_rate" type="text" class="form-control form-input " id="interestRate">
				</div>
				<div class="form-group mb-10 mr-16" style="flex:6">
					<label for="interestAmount" class="form-label">Interest Amount</label>
					<input required :value="interestAmount" type="text" disabled class="form-control form-input " id="group">
				</div>
				<div class="form-group mb-10 mr-16" style="flex:6">
					<label for="numberOfInstallment" class="form-label">Number of Installment</label>
					<input required :value="numberOfInstallment" disabled type="number" class="form-control form-input " id="numberOfInstallment">
				</div>
			</div>
		</section>

		<section class="mb-24 pb-45" style="flex:21;padding-left:16px;">
			<div class="d-flex justify-content-between align-items-center section-title mb-24 no-padding">
				<span class="section-title no-border no-padding">Deduction Fees</span>
				<button @click.prevent="compute()" class="btn btn-success btn-sm btn-wide mb-10">Compute</button>
			</div>
			<div :hidden="isComputed">
				<div class="d-flex flex-row" >
					<div class="d-flex flex-column mr-45" style="flex:3;">
						<div class="d-flex flex-row mb-16">
							<label for="dueDate" class="form-label" style="flex:3">Filling Fee</label>
							<input @blur="inputs.filingFee=false" v-if="inputs.filingFee" v-model="loanDetails.filing_fee" required type="number" class="form-control form-input text-right mr-16" style="flex:4" id="filingFee">
							<input @focus="inputs.filingFee=true" v-if="!inputs.filingFee" :value="formatToCurrency(loanDetails.filing_fee)" required type="text" class="form-control form-input text-right mr-16" style="flex:4" id="filingFee">
							<span class="flex-1" style="padding:7px 15px"></span>
						</div>
						<div class="d-flex flex-row mb-16">
							<label for="dueDate" class="form-label" style="flex:3">Doc. Stamp</label>
							<input @blur="inputs.docStamp=false" v-if="inputs.docStamp" v-model="loanDetails.document_stamp" requried type="number" class="form-control form-input text-right mr-16" style="flex:4" id="docStamp">
							<input @focus="inputs.docStamp=true" v-if="!inputs.docStamp" :value="formatToCurrency(loanDetails.document_stamp)" requried type="text" class="form-control form-input text-right mr-16" style="flex:4" id="docStamp2">
							<span class="flex-1" style="padding:7px 15px"></span>
						</div>
						<div class="d-flex flex-row mb-16">
							<label for="dueDate" class="form-label" style="flex:3">Insurance</label>
							<input @blur="inputs.insurance=false" v-if="inputs.insurance" v-model="loanDetails.insurance" required type="number" class="form-control form-input text-right mr-16" style="flex:4" id="insurance">
							<input @focus="inputs.insurance=true" v-if="!inputs.insurance" :value="formatToCurrency(loanDetails.insurance)" required type="text" class="form-control form-input text-right mr-16" style="flex:4" id="insurance">
							<span class="flex-1" style="padding:7px 15px"></span>
						</div>
						<div class="d-flex flex-row mb-16">
							<label for="dueDate" class="form-label" style="flex:3">Notarial Fee</label>
							<input @blur="inputs.notarialFee=false" v-if="inputs.notarialFee" v-model="loanDetails.notarial_fee" required type="number" class="form-control form-input text-right mr-16" style="flex:4" id="notrialFee">
							<input @focus="inputs.notarialFee=true" v-if="!inputs.notarialFee" :value="formatToCurrency(loanDetails.notarial_fee)" required type="text" class="form-control form-input text-right mr-16" style="flex:4" id="notrialFee">
							<span class="flex-1" style="padding:7px 15px"></span>
						</div>
						<div v-if="loanDetails.type=='Prepaid'" class="d-flex flex-row mb-16">
							<label for="dueDate" class="form-label" style="flex:3">Prepaid Interest</label>
							<input @blur="inputs.prepaidInterest=false" v-if="inputs.prepaidInterest" v-model="loanDetails.prepaid_interest" required type="number" class="form-control form-input text-right mr-16" style="flex:4" id="prepaidInterest">
							<input @focus="inputs.prepaidInterest=true" v-if="!inputs.prepaidInterest" :value="formatToCurrency(loanDetails.prepaid_interest)" required type="text" class="form-control form-input text-right mr-16" style="flex:4" id="prepaidInterest">
							<span class="flex-1" style="padding:7px 15px"></span>
						</div>
						<div class="d-flex flex-row mb-16">
							<label for="dueDate" class="form-label" style="flex:3">Affidavit</label>
							<input @blur="inputs.affidavit=false" v-if="inputs.affidavit" v-model="loanDetails.affidavit_fee" type="number" class="form-control form-input text-right mr-16" style="flex:4" id="affidavit">
							<input @focus="inputs.affidavit=true" v-if="!inputs.affidavit" :value="formatToCurrency(loanDetails.affidavit_fee)" type="text" class="form-control form-input text-right mr-16" style="flex:4" id="affidavit">
							<span class="flex-1" style="padding:7px 15px"></span>
						</div>
						<div class="d-flex flex-row mb-16">
							<div style="flex:3;align-items:center" class="d-flex">
								<input v-model="memoChecked" type="checkbox" class="" style="margin-right:10px;width:25px;height:25px;">
								<label for="dueDate" class="form-label" style="margin-bottom:0;">Memo</label>
							</div>
							<input @blur="inputs.memo=false" v-if="inputs.memo" v-model="loanDetails.memo" type="number" class="form-control form-input text-right mr-16" style="flex:4" id="memo">
							<input disabled @focus="inputs.memo=true" v-if="!inputs.memo" :value="formatToCurrency(loanDetails.memo)" type="text" class="form-control form-input text-right mr-16" style="flex:4" id="memo">
							<span class="flex-1" style="padding:7px 15px"></span>
						</div>
					</div>
					<div class="d-flex flex-column" style="flex:2;">
						<div class="form-group mb-16">
							<label for="dueDate" class="form-label">Total Deductions</label>
							<input required :value="formatToCurrency(totalDeductions)" disabled type="text" class="form-control form-input text-right mr-16 text-green " id="dueDate">
							<span class="flex-1" style="padding:7px 15px"></span>
						</div>
						<div class="form-group mb-45">
							<label for="dueDate" class="form-label">Net Proceeds</label>
							<input required :value="formatToCurrency(netProceeds)" disabled type="text" class="form-control form-input text-right mr-16 text-green " id="dueDate">
							<span class="flex-1" style="padding:7px 15px"></span>
						</div>
						<div class="form-group">
							<label for="dueDate" class="form-label">Release Type</label>
							<select required v-model="loanDetails.release_type" name="" id="" class="form-control form-input pr-12 text-right mr-16 text-green">
								<option v-for="(r,p) in releaseType" :key="p" :value="r">{{r}}</option>
								<!-- <option value="Cheque Release">Cheque Release</option>
								<option value="Restructure Release">Restructure Release</option> -->
							</select>
						</div>
					</div>
					<div class="flex-1"></div>
				</div>
				<div v-if="memoChecked" class="d-flex flex-column" style="padding-top:24px">
					<div class="d-flex align-items-end">
						<div class="d-flex flex-2 align-items-center">
							<span class="mr-16 font-20 flex-2">Account # and Balance</span>
							<select  v-if="memoRefNo.length" v-model="selectedLoanAccount" name="" id="" class="form-control form-input pr-12 mr-24 text-green flex-3">
								<option v-for="(la, z) in loanaccounts" :key="z" :value="la.loan_account_id">{{la.account_num + ' - ' + formatToCurrency(la.remainingBalance.memo.balance)}}</option>
							</select>
							<select disabled v-if="!memoRefNo.length" v-model="selectedLoanAccount" name="" id="" class="form-control form-input pr-12 mr-24 text-green flex-3">
								<option value=""></option>
							</select>
						</div>
						<div class="d-flex flex-column flex-1">
							<label for="dueDate" class="form-label">Memo Reference No.</label>
							<input v-model="memoRefNo" type="text" class="form-control form-input">
						</div>
						<div class="flex-1"></div>
					</div>
					<div class="d-flex align-items-end mb-36">
						<div class="d-flex flex-2 align-items-center">
							<span class="mr-16 font-20 flex-2">Outstanding Principal</span>
							<input type="text" :value="formatToCurrency(loanaccount.remainingBalance.principal.balance)" class="form-control form-input flex-3 mr-24" disabled>
						</div>
						<div class="d-flex flex-column flex-1">
							<label for="dueDate" class="form-label">Rebate Amount</label>
							<input v-model="loanaccount.remainingBalance.rebates.balance" v-if="rebatesRefNo.length" type="number" class="form-control form-input">
							<input v-if="!rebatesRefNo.length" type="number" :value="formatToCurrency(baseAmount)" class="form-control form-input" disabled>
						</div>
						<div class="flex-1"></div>
					</div>
					<div class="d-flex align-items-end">
						<div class="d-flex flex-2 align-items-center">
							<span class="mr-16 font-20 flex-2">Outstanding Interest</span>
							<input :value="formatToCurrency((loanaccount.remainingBalance.interest.balance - loanaccount.remainingBalance.rebates.credit - this.loanaccount.remainingBalance.rebates.balance) > 0? loanaccount.remainingBalance.interest.balance - loanaccount.remainingBalance.rebates.credit - this.loanaccount.remainingBalance.rebates.balance:0)" type="text" class="form-control form-input flex-3 mr-24" disabled>
						</div>
						<div class="d-flex flex-column flex-1">
							<span class="mr-16 font-20 flex-2">Rebate Approval No.</span>
							<input v-model="rebatesRefNo" type="text" class="form-control form-input flex-3 mr-24">
						</div>
						<div class="flex-1"></div>
					</div>
				</div>
			</div>
			<div :hidden="!isComputed">
				<label>Press compute to show Deductions</label>

			</div>
			<!-- <div class="d-flex align-items-center" v-if="memoChecked">
				<span class="mr-16 font-20" style="margin-top:10px">Account # and Balance</span>
				<div class="d-flex align-items-end flex-2">
					<div class="form-group mr-16 flex-1">
						<select name="" id="" class="form-control form-input pr-12 mr-16 text-green">
							<option value="">5000</option>
						</select>
					</div>
					<div class="form-group flex-1">
						<label for="dueDate" class="form-label">Memo Reference No.</label>
						<input type="text" class="form-control form-input">
					</div>
					<div class="flex-1"></div>
				</div>
			</div> -->
			<!-- <div class="d-flex align-items-center" v-if="memoChecked">
				<span class="mr-16 font-20" style="margin-top:10px">Outstanding Principal</span>
				<div class="d-flex align-items-end flex-2">
					<div class="form-group mr-16 flex-1">
						<input type="number" class="form-control form-input" disabled>
					</div>
					<div class="form-group flex-1">
						<label for="dueDate" class="form-label">Rebate Amount</label>
						<input type="text" class="form-control form-input">
					</div>
					<div class="flex-1"></div>
				</div>
			</div>
			<div class="d-flex align-items-center" v-if="memoChecked">
				<span class="mr-16 font-20" style="margin-top:10px">Outstanding Interest</span>
				<div class="d-flex align-items-end flex-2">
					<div class="form-group mr-16 flex-1">
						<input type="number" class="form-control form-input" disabled>
					</div>
					<div class="form-group flex-1">
						<label for="dueDate" class="form-label">Rebate Amount</label>
						<input type="text" class="form-control form-input">
					</div>
					<div class="flex-1"></div>
				</div>
			</div> -->
		</section>

		<section class="mb-24 pb-45" style="flex:21;border-bottom:1px solid #AAA">
			<span class="section-title mb-24">Documents</span>
			<div class="d-flex flex-column mb-24">
				<span class="text-bold bg-yellow-light mb-10" style="padding:2px 5px;">Dacion en Pago</span>
				<div class="d-flex justify-content-between mb-10">
					<span class="align-self-end text-bold">Description</span>
					<div class="d-flex align-items-center">
						<span class="flex-1 mr-10 text-bold">Date Release</span>
						<input v-model="loanDetails.documents.date_release" type="date" class="form-control form-input flex-1">
					</div>
				</div>
				<textarea v-model="loanDetails.documents.description" class="form-control form-input no-resize" style="height:120px!important;"></textarea>
			</div>
			<div class="d-flex flex-column mb-16">
				<span class="text-bold bg-yellow-light mb-10" style="padding:2px 5px;">DOA ATM / PASSBOOK</span>
				<div class="form-group mb-10">
					<label for="">Name of Bank</label>
					<input type="text" v-model="loanDetails.documents.bank" name="" id="" class="form-control form-input">
				</div>
				<div class="form-group mb-10">
					<label for="">Account No.</label>
					<input v-model="loanDetails.documents.account_no" type="text" class="form-control form-input">
				</div>
				<div class="form-group mb-10">
					<label for="">Card No.</label>
					<input v-model="loanDetails.documents.card_no" type="text" class="form-control form-input">
				</div>
			</div>
			<div class="d-flex flex-column">
				<span class="text-bold bg-yellow-light mb-10" style="padding:2px 5px;">MOA / SME</span>
				<div class="form-group mb-10">
					<label for="">Promissory Number</label>
					<input v-model="loanDetails.documents.promissory_number" disabled type="text" class="form-control form-input">
				</div>
			</div>
		</section>



		<div class="d-flex flex-row-reverse mb-45 justify-content-between">
			<div class="d-flex">
				<a @click.prevent="navigate('custom-content-below-coborrowerinfo-tab')" href="#" data-tab="custom-content-below-coborrowerinfo-tab" class="btn btn-primary-dark mr-24 tab-navigate min-w-150">Back</a>
				<a href="#" data-toggle="modal" data-target="#warningModal" class="btn btn-success tab-navigate min-w-150 hide" id="warningBtn"></a>
				<a href="#" data-toggle="modal" data-target="#zeroModal" class="btn btn-success tab-navigate min-w-150 hide" id="zeroBtn"></a>
				<button v-if="!loandetails.loan_account_id" :disabled="isComputed" class="btn btn-success tab-navigate min-w-150">Next</button>
				<button v-if="prejected" :disabled="isComputed" class="btn btn-success tab-navigate min-w-150">Next</button>
			</div>
			<a href="#" data-toggle="modal" data-target="#lettersModal" class="btn btn-yellow-light">Print Document</a>
			<!-- <div style="flex:22"></div> -->
		</div>
	</div>

	</form>
</template>

<script>
export default {
	props:[
		'borrowerswitch',
		'token',
		'loandetails',
		'borrower',
		'borrowerbday',
		'saveloandetails',
		'idtype',
		'releasetype',
		'pbranch',
		'loanaccounts',
		'prejected',
		'transactionDate'
	],
	data(){
		return {
			inputs:{
				loanAmount:false,
				interestAmount:false,
				filingFee:false,
				docStamp:false,
				insurance:false,
				notarialFee:false,
				prepaidInterest:false,
				affidavit:false,
				memo:false,
			},
			age:null,
			products:[],
			accountOfficers:[],
			centers:[],
			memoChecked:false,
			currentProduct:{
				product_name:null,
			},
			loanDetails: {
				cycle_no : 1,
				ao_id : '',
				product_id : '',
				center_id : '',
				type : '',
				payment_mode : '',
				terms : '',
				loan_amount : 0,
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
				memo : 0,
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
				product:{
					product_name:'',
				}
			},
			branch:{
				branch_id:null,
			},
			selectedLoanAccount:null,
			loanaccount:{
				loan_account_id:null,
				remainingBalance:{
					memo:{
						balance:0,
					},
					principal:{
						balance:0
					},
					interest:{
						balance:0
					},
					rebates:{
						balance:0,
					}
				}
			},
			baseAmount:0.00,
			rebatesRefNo:'',
			memoRefNo:'',
			deductionComputation:0,
		}
	},
	methods:{
		resetLoans:function(){
			this.loanDetails = {
				cycle_no : 1,
				ao_id : '',
				product_id : '',
				center_id : '',
				type : '',
				payment_mode : '',
				terms : '',
				loan_amount : 0,
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
				memo : 0,
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
				product:{
					product_name:'',
				}
			}
		},
		async computeDeduction(){
			var data = {
				loan_amount: this.loanDetails.loan_amount,
				terms: this.loanDetails.terms,
				product_id: this.loanDetails.product_id,
				birthdate: this.borrowerbday
			}
			await axios.post(this.baseURL() + 'api/deduction/calculate', data, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				var result = response.data.data;
				this.loanDetails.filing_fee = result.filing_fee.rate;
				this.loanDetails.document_stamp = result.doc_stamp.rate;
				this.loanDetails.insurance = result.insurance.rate;
				this.loanDetails.notarial_fee = result.notarial_fee.rate;
				this.loanDetails.affidavit_fee = result.affidavit.rate;
				this.loanDetails.prepaid_interest = this.loanDetails.type=="Add-On"?0:this.loanDetails.interest_amount;

			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		fetchProducts: function(){
			axios.get(this.baseURL() + 'api/products/activeProducts', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.products = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		fetchAo: function(){
			axios.get(this.baseURL() + 'api/accountofficer/getActivesInBranch/' + this.branch, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.accountOfficers = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		fetchCenters: function(){
			axios.get(this.baseURL() + 'api/centers/activeCenters', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.centers = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		fetchPromissoryNo: function(){
			if(this.loanDetails.product_id && this.loanDetails.product_id !== ''){
				axios.post(this.baseURL() + 'api/account/promissoryno',{'product_id':this.loanDetails.product_id, branch_id:this.branch}, {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.loanDetails.documents.promissory_number = response.data;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			}
		},
		navigate:function(tab){
			document.getElementById(tab).click();
		},
		submit:function(){
			if(this.netProceeds >= 0){
				document.getElementById('warningBtn').click();
			}else{
				document.getElementById('zeroBtn').click();
			}

		},
		save: function(){
			this.setPrepaidInterest();
			this.loanDetails.status = 'pending';
			this.loanDetails.branch_id = this.branch;
			this.loanDetails.transaction_date = this.transactionDate.date_end;
			this.$emit('load');
			if(this.loanDetails.loan_account_id){
				axios.post(this.baseURL() + 'api/account/update/' + this.loanDetails.loan_account_id, this.loanDetails, {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.notify('',response.data.message, 'success');
					this.$emit('savedInfo', response.data.data)
					this.pay(response.data.data.loan_account_id);
					if(this.prejected){
						window.location.href = this.baseURL() + 'transaction/rejected_release';
					}
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			}else {
				this.$emit('load');
				axios.post(this.baseURL() + 'api/account/create/' + this.loanDetails.borrower_id, this.loanDetails, {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					// console.log(response.data.data);
					this.notify('',response.data.message, 'success');
					this.pay(response.data.data.loan_account_id);
					this.$emit('savedInfo', response.data.data)
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			}

		},
		notify:function(title, text, type){
			this.$notify({
				group: 'foo',
				title: title,
				text: text,
				type: type,
			});
		},
		setInterestRate:function(){
			this.products.map(function(product){
				if(product.product_id == this.loanDetails.product_id){
					this.loanDetails.interest_rate = product.interest_rate;
					this.currentProduct = product;
				}
			}.bind(this));
		},
		setCenterSched:function(){
			this.loanDetails.center_id = null;
			this.loanDetails.day_schedule = null;
		},
		isEnabled:function(data){
			if(data){
				return true;
			}
			return false;
		},
		setPrepaidInterest:function(){
			if(this.loanDetails.type == 'Add-On'){
				this.loanDetails.prepaid_interest = 0.00;
			}
		},
		compute:function(){

			if(this.loanDetails.loan_amount == 0 ){
				this.notify("Can't Compute", "Loan Amount is Required", 'error')
			}else if(this.loanDetails.terms == ''){
				this.notify("Can't Compute", "Terms is Required", 'error')
			}else if(this.loanDetails.product_id == ''){
				this.notify("Can't Compute", "Product is Required", 'error')
			}else{
				this.computeDeduction();
				this.deductionComputation += 1;
			}

		},
		fetchAccount:function(id){
				axios.get(this.baseURL() + 'api/account/show/' + this.loanaccount.loan_account_id, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					console.log(response.data.data);
					this.$emit('load');
					let payment = {
						loan_account_id: this.loanaccount.loan_account_id,
						branch_id: this.pbranch,
						payment_type: 'Memo',
						reference_no: this.memoRefNo,
						reference_id: id,
						memo_type: 'deduct to balance',
						amortization_id: response.data.data.current_amortization!=null?response.data.data.current_amortization.id:'',
						principal: this.loanaccount.remainingBalance.principal.balance,
						interest: (this.loanaccount.remainingBalance.interest.balance - this.loanaccount.remainingBalance.rebates.credit) - this.loanaccount.remainingBalance.rebates.balance,
						rebates: this.loanaccount.remainingBalance.rebates.balance,
						rebates_approval_no: this.rebatesRefNo,
						pdi:0,
						penalty:0,
						total_payable: 0,
						amount_applied: this.loanaccount.remainingBalance.principal.balance + (this.loanaccount.remainingBalance.interest.balance - this.loanaccount.remainingBalance.rebates.credit),
						transaction_date: this.transactionDate.date_end
					}

					axios.post(this.baseURL() + 'api/payment', payment, {
						headers: {
								'Authorization': 'Bearer ' + this.token,
								'Content-Type': 'application/json',
								'Accept': 'application/json'
						}
						})
						.then(function (response) {
							this.$emit('unload');
							this.memoChecked = false;
							this.notify('','Payment successful.', 'success');
							this.resetLoans();
							this.$emit('resetall')
						}.bind(this))
						.catch(function (error) {
							this.notify('',error.response.data.message + ' ' + error.response.data.data, 'error');
							console.log(error);
							this.$emit('unload');
							this.$emit('resetall')
							this.resetLoans
						}.bind(this));
						}.bind(this))
						.catch(function (error) {
							console.log(error);
						}.bind(this));
					},

		pay:function(accountId){
			if(this.loanaccount.loan_account_id){
				this.fetchAccount();
			}else{
				this.$emit('resetall')
				this.$emit('unload');
			}
		},

	},
	watch: {
		'loandetails'(newValue) {
			this.loanDetails = newValue;
			if(this.prejected) {
				this.loanDetails.memo = 0;
			}
		},
		'borrower'(newValue) {
			this.loanDetails.borrower_id = newValue.borrower_id;
			this.loanDetails.borrower_num = newValue.borrower_num;
			this.save();
		},
		'borrowerswitch'(newValue) {
			this.memoChecked = false;
		},
		'borrowerbday'(newValue) {
			this.age = this.calculateAge(newValue);
		},
		'memoChecked'(newValue){
			if(!newValue){
				this.selectedLoanAccount = null;
				this.loanaccount = {
					loan_account_id:null,
					remainingBalance:{
						memo:{
							balance:0,
						},
						principal:{
							balance:0
						},
						interest:{
							balance:0
						},
						rebates:{
							balance:0,
						}
					}
				}
				this.memoRefNo = '';
				this.rebatesRefNo = '';
			}
		},
		'loanDetails.product_id'(newValue){
			this.setInterestRate();
			if(!this.prejected && newValue){
				this.fetchPromissoryNo();
			}
			this.deductionComputation = 0;
		},
		'loanDetails.terms'(){
			this.deductionComputation = 0;
		},
		'loanDetails.loan_amount'(){
			this.deductionComputation = 0;
		},
		'loanDetails.type'(){
			this.deductionComputation = 0;
		},
		'loanDetails.center_id':function(){
			this.centers.map(function(data){
				if(this.loanDetails.center_id == data.center_id){
					this.loanDetails.day_schedule = data.day_sched.toLowerCase()
				}
			}.bind(this));
		},
		'pbranch':function(newValue){
			this.branch = newValue
		},
		'selectedLoanAccount':function(newValue){
			if(newValue){
				this.loanaccounts.map(function(data){
					if(newValue == data.loan_account_id){
						this.loanaccount = data;
					}
				}.bind(this));
			}
		},
		'rebatesRefNo':function(newValue){
			if(!newValue.length){
				this.loanaccount.remainingBalance.rebates.balance = 0;
			}
		},
		'memoRefNo':function(newValue){
			if(!newValue.length){
				this.selectedLoanAccount = null;
				this.loanaccount = {
					loan_account_id:null,
					remainingBalance:{
						memo:{
							balance:0,
						},
						principal:{
							balance:0
						},
						interest:{
							balance:0
						},
						rebates:{
							balance:0,
						}
					}
				}
				this.memoRefNo = '';
				this.rebatesRefNo = '';
			}
		},
		'loanaccount.loan_account_id':function(newValue){
			this.calculateMemo
		},
		'loanaccount.remainingBalance.rebates.balance':function(){
			if(this.loanaccount.remainingBalance.rebates.balance > this.loanaccount.remainingBalance.interest.balance - this.loanaccount.remainingBalance.rebates.credit){
				this.loanaccount.remainingBalance.rebates.balance =  this.loanaccount.remainingBalance.interest.balance - this.loanaccount.remainingBalance.rebates.credit;
			}else if(this.loanaccount.remainingBalance.rebates.balance < 0){
				this.loanaccount.remainingBalance.rebates.balance =  0;
			}
			this.calculateMemo
		},
		'loanDetails.transaction_date':function(){
			if(this.loandetails.documents.date_release == "" || this.prejected){
				console.log(this.prejected);
				this.loandetails.documents.date_release = this.transactionDate.date_end;
			}
			if(this. loanDetails.transaction_date == "" || this.prejected){
				console.log(this.prejected);
				this.loanDetails.transaction_date = this.transactionDate.date_end;
			}
		},

	},
	computed: {
		isComputed:function(){
			return this.deductionComputation > 0 ? false : true;
		},
		releaseType:function(){
			return JSON.parse(this.releasetype);
		},
		productEnable:function(){
			if(this.currentProduct.product_name == 'Micro Group' || this.currentProduct.product_name == 'Micro Individual'){
				return true;
			}
			return false;
		},
		interestRate:function(){
			if(this.loanDetails.product_id != '' && !this.loanDetails.interest_rate){
				for(let i in this.products){
					if(this.products[i].product_id === this.loanDetails.product_id){
						return this.products[i].interest_rate;
					}
				}
			}
			return this.loanDetails.interest_rate;
		},
		idType:function(){
			return JSON.parse(this.idtype);
		},
		interestAmount:function(){
			this.loanDetails.interest_amount = (this.loanDetails.loan_amount * (this.interestRate * 0.01) * (this.loanDetails.terms / 30)).toFixed(2);
			// this.loanDetails.prepaid_interest = (this.loanDetails.loan_amount * (this.interestRate * 0.01) * (this.loanDetails.terms / 30)).toFixed(2);
			return (this.loanDetails.loan_amount * (this.interestRate * 0.01) * (this.loanDetails.terms / 30)).toFixed(2);
		},
		numberOfInstallment:function(){
			let mode = this.loanDetails.terms;
			let result = 0;
			if(this.loanDetails.payment_mode == 'Monthly'){
				mode = 30;
				result = Math.ceil((this.loanDetails.terms / mode))
			}else if(this.loanDetails.payment_mode == 'Bi-Monthly'){
				mode = 15;
				result = Math.ceil((this.loanDetails.terms / mode))
			}else if(this.loanDetails.payment_mode == 'Weekly'){
				mode = 30;
				result = Math.ceil((this.loanDetails.terms / mode)*4);
			}else{
				mode = this.loanDetails.terms
				result = Math.ceil((this.loanDetails.terms / mode))
			}
			this.loanDetails.no_of_installment = result;
			return result;
		},
		// docStamp:function(){
		// 	this.loanDetails.document_stamp =  (this.loanDetails.loan_amount / 200 * 1.5 * this.loanDetails.terms / 365).toFixed(2);
		// 	if(this.loanDetails.terms / 30 > 12){
		// 		this.loanDetails.document_stamp =  (this.loanDetails.loan_amount / 200 * 1.5).toFixed(2);
		// 	}
		// 	return this.loanDetails.document_stamp;
		// },
		// calculateInsurance:function(){
		// 	let rate = 1;
		// 	if(this.age > 65){
		// 		rate = 2.8;
		// 	}
		// 	this.loanDetails.insurance =  ((this.loanDetails.loan_amount / 1000) * rate * (Math.ceil(this.loanDetails.terms / 30))).toFixed(2);
		// 	return this.loanDetails.insurance;
		// },
		totalDeductions:function(){
			this.loanDetails.total_deduction = (parseFloat(this.loanDetails.memo) + parseFloat(this.loanDetails.prepaid_interest) + parseFloat(this.loanDetails.filing_fee) + parseFloat(this.loanDetails.affidavit_fee) + parseFloat(this.loanDetails.notarial_fee) + parseFloat(this.loanDetails.document_stamp) + parseFloat(this.loanDetails.insurance)).toFixed(2);
			return this.loanDetails.total_deduction;
		},
		netProceeds:function(){
			this.loanDetails.net_proceeds = (parseFloat(this.loanDetails.loan_amount) - parseFloat(this.loanDetails.total_deduction));
			return this.loanDetails.net_proceeds;
		},
		calculateMemo:function(){
			let rebates = (this.loanaccount.remainingBalance.interest.balance - this.loanaccount.remainingBalance.rebates.balance) > 0? this.loanaccount.remainingBalance.rebates.balance : this.loanaccount.remainingBalance.interest.balance;
			this.loanDetails.memo = this.loanaccount.remainingBalance.memo.balance - rebates;
		}
	},
	mounted(){
		this.branch = this.pbranch
		this.fetchProducts();
		this.fetchAo();
		this.fetchCenters();
		this.loanDetails = this.loandetails;
		this.setInterestRate();
		console.log(this.prejected);
	}
}
</script>