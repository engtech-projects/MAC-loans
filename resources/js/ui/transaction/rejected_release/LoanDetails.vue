<template>
	<form @submit.prevent="submit" action="">
	<div class="d-flex flex-column">
		<notifications group="foo" />
		<section class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Loan Details</span>
			<div class="d-flex flex-row">
				<div style="flex:18" class="mr-16"></div>
				<div class="form-group mb-10" style="flex:7">
					<label for="dateRelease" class="form-label">Date Release</label>
					<input :value="transactionDate.date_end" disabled type="date" class="form-control form-input " id="dateRelease">
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
					<select required v-model="loanDetails.product_id" name="" id="" class="form-control form-input ">
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
					<select required v-model="loanDetails.center_id" name="" id="" class="form-control form-input ">
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
					<input required v-model="loanDetails.loan_amount" type="number" class="form-control form-input " id="center">
				</div>
				<div class="form-group mb-10 mr-16" style="flex:4">
					<label for="group" class="form-label">Terms</label>
					<input required v-model="loanDetails.terms" type="number" class="form-control form-input " id="group">
				</div>
				<div class="form-group mb-10 mr-16" style="flex:5">
					<label for="type" class="form-label">Day Schedule</label>
					<select required v-model="loanDetails.day_schedule" class="form-control form-input " id="type">
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
					<input required disabled :value="interestRate + '%'" type="text" class="form-control form-input " id="interestRate">
				</div>
				<div class="form-group mb-10 mr-16" style="flex:6">
					<label for="interestAmount" class="form-label">Interest Amount</label>
					<input required :value="interestAmount" disabled type="text" class="form-control form-input " id="group">
				</div>
				<div class="form-group mb-10 mr-16" style="flex:6">
					<label for="numberOfInstallment" class="form-label">Number of Installment</label>
					<input required :value="numberOfInstallment" disabled type="number" class="form-control form-input " id="numberOfInstallment">
				</div>
			</div>
		</section>

		<section class="mb-24 pb-45" style="flex:21;padding-left:16px;border-bottom:1px solid #AAA">
			<span class="section-title mb-24">Deduction Fees</span>
			<div class="d-flex flex-row">
				<div class="d-flex flex-column mr-45" style="flex:3;">
					<div class="d-flex flex-row mb-16">
						<label for="dueDate" class="form-label" style="flex:3">Filling Fee</label>
						<input v-model="loanDetails.filing_fee" required type="text" class="form-control form-input text-right mr-16" style="flex:4" id="dueDate">
						<a href="" class="btn btn-success flex-1" style="line-height:2">Edit</a>
					</div>
					<div class="d-flex flex-row mb-16">
						<label for="dueDate" class="form-label" style="flex:3">Doc. Stamp</label>
						<input :value="formatToCurrency(docStamp)" requried disabled type="text" class="form-control form-input text-right mr-16" style="flex:4" id="dueDate">
						<span class="flex-1" style="padding:7px 15px"></span>
					</div>
					<div class="d-flex flex-row mb-16">
						<label for="dueDate" class="form-label" style="flex:3">Insurance</label>
						<input v-model="loanDetails.insurance" required disabled type="text" class="form-control form-input text-right mr-16" style="flex:4" id="dueDate">
						<span class="flex-1" style="padding:7px 15px"></span>
					</div>
					<div class="d-flex flex-row mb-16">
						<label for="dueDate" class="form-label" style="flex:3">Notarial Fee</label>
						<input :value="formatToCurrency(loanDetails.notarial_fee)" required disabled type="text" class="form-control form-input text-right mr-16" style="flex:4" id="dueDate">
						<span class="flex-1" style="padding:7px 15px"></span>
					</div>
					<div v-if="loanDetails.type=='Prepaid'" class="d-flex flex-row mb-16">
						<label for="dueDate" class="form-label" style="flex:3">Prepaid Interest</label>
						<input :value="loanDetails.prepaid_interest" disabled required type="text" class="form-control form-input text-right mr-16" style="flex:4" id="dueDate">
						<span class="flex-1" style="padding:7px 15px"></span>
					</div>
					<div class="d-flex flex-row mb-16">
						<label for="dueDate" class="form-label" style="flex:3">Affidavit</label>
						<input v-model="loanDetails.affidavit_fee" type="text" class="form-control form-input text-right mr-16" style="flex:4" id="dueDate">
						<span class="flex-1" style="padding:7px 15px"></span>
					</div>
					<div class="d-flex flex-row mb-16">
						<label for="dueDate" class="form-label" style="flex:3">Memo</label>
						<input v-model="loanDetails.memo" type="text" class="form-control form-input text-right mr-16" style="flex:4" id="dueDate">
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
							<option value="Cash Release">Cash Release</option>
							<option value="Cheque Release">Cheque Release</option>
							<option value="Restructure Release">Restructure Release</option>
						</select>
					</div>
				</div>
				<div class="flex-1"></div>
			</div>
			<div class="d-flex align-items-center">
				<span class="mr-16 font-20" style="margin-top:10px">Memo - Deduct to Balance</span>
				<div class="d-flex align-items-end flex-1">
					<div class="form-group mr-16 flex-1">
						<select name="" id="" class="form-control form-input pr-12 mr-16 text-green">
							<option value="">5000</option>
						</select>
					</div>
					<div class="form-group flex-2">
						<label for="dueDate" class="form-label">Account # and Balance</label>
						<select name="" id="" class="form-control form-input pr-12 mr-16 text-green">
							<option value="">1232542154 - P 5000.00</option>
						</select>
					</div>
					<div class="flex-1"></div>
				</div>
			</div>
		</section>

		<section class="mb-24 pb-45" style="flex:21;border-bottom:1px solid #AAA">
			<span class="section-title mb-24">Documents</span>
			<div class="d-flex flex-column mb-24">
				<span class="text-bold bg-yellow-light mb-10" style="padding:2px 5px;">Dacion en Pago</span>
				<div class="d-flex justify-content-between mb-10">
					<span class="align-self-end text-bold">Description</span>
					<div class="d-flex align-items-center">
						<span class="flex-1 mr-10 text-bold">Date Release</span>
						<input :value="dateToYMD(new Date)" type="date" class="form-control form-input flex-1">
					</div>
				</div>
				<textarea v-model="loanDetails.documents.description" class="form-control form-input no-resize" style="height:120px!important;"></textarea>
			</div>
			<div class="d-flex flex-column mb-16">
				<span class="text-bold bg-yellow-light mb-10" style="padding:2px 5px;">DOA ATM / PASSBOOK</span>
				<div class="form-group mb-10">
					<label for="">Name of Bank</label>
					<select v-model="loanDetails.documents.bank" name="" id="" class="form-control form-input">
						<option value="Land Bank">Land Bank</option>
						<option value="BDO">BDO</option>
						<option value="BPI">BPI</option>
					</select>
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
					<input v-model="loanDetails.documents.promissory_number" type="text" class="form-control form-input">
				</div>
			</div>
		</section>


		<div class="d-flex flex-row-reverse mb-45 justify-content-between">
			<div class="d-flex">
				<a @click.prevent="navigate('custom-content-below-coborrowerinfo-tab')" href="#" data-tab="custom-content-below-coborrowerinfo-tab" class="btn btn-primary-dark mr-24 tab-navigate min-w-150">Back</a>
				<a href="#" data-toggle="modal" data-target="#warningModal" class="btn btn-success tab-navigate min-w-150 hide" id="warningBtn"></a>
				<button class="btn btn-success tab-navigate min-w-150">Next</button>
			</div>
			<a href="#" data-toggle="modal" data-target="#lettersModal" class="btn btn-yellow-light">Print Document</a>
			<!-- <div style="flex:22"></div> -->
		</div>
		<div class="modal" id="warningModal" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-body p-24">
						<div class="d-flex align-items-center">
							<img :src="baseUrl+'/img/warning.png'" style="width:120px;height:auto;" class="mr-24" alt="warning icon">
							<div class="d-flex flex-column">
								<span class="text-primary-dark text-bold mb-24">
									Please re check all the data if correct and genuine. If checking is done and verified, kindly press proceed.
								</span>
								<div class="d-flex mt-auto justify-content-between">
									<a href="#" data-dismiss="modal" class="btn btn-danger min-w-120">Re Check</a>
									<a @click.prevent="$emit('save',loanDetails)" href="#" data-dismiss="modal" class="btn btn-primary-dark min-w-120">Proceed</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
	</div>
	</form>
</template>

<script>
export default {
	props:['token', 'loandetails', 'borrower', 'borrowerbday', 'saveloandetails','transactionDate'],
	data(){
		return {
			baseUrl:this.baseURL(),
			age:null,
			products:[],
			accountOfficers:[],
			centers:[],
			loanDetails: {
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
				documents:{
					date_release: '',
					description: '',
					bank: '',
					account_no: '',
					card_no:'',
					promissory_number: '',
				}
			}
		}
	},
	methods:{
		fetchProducts: function(){
			axios.get(this.baseURL() + 'api/product/', {
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
			axios.get(this.baseURL() + 'api/accountofficer/', {
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
			axios.get(this.baseURL() + 'api/center/', {
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
		navigate:function(tab){
			document.getElementById(tab).click();
		},
		submit:function(){
			document.getElementById('warningBtn').click();
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
	watch: {
		'loandetails'(newValue) {
			this.loanDetails = newValue;
		},
		'borrower'(newValue) {
			this.loanDetails.borrower_id = newValue.borrower_id;
			this.loanDetails.borrower_num = newValue.borrower_num;
		},
		'borrowerbday'(newValue) {
			this.age = this.calculateAge(newValue);
		},
	},
	computed: {
		interestRate:function(){
			if(this.loanDetails.product_id != ''){
				for(let i in this.products){
					if(this.products[i].product_id === this.loanDetails.product_id){
						return this.products[i].interest_rate;
					}
				}
			}
			return '';
		},
		interestAmount:function(){
			return (this.loanDetails.loan_amount * (this.interestRate * 0.01) * (this.loanDetails.terms / 30)).toFixed(2);
		},
		numberOfInstallment:function(){
			let mode = 0;
			if(this.loanDetails.payment_mode == 'Monthly'){
				mode = 1;
			}else if(this.loanDetails.payment_mode == 'Bi-Monthly'){
				mode = 2;
			}else if(this.loanDetails.payment_mode == 'Weekly'){
				mode = 4;
			}else{
				mode = this.loanDetails.terms
			}
			this.loanDetails.no_of_installment = Math.ceil(this.loanDetails.terms / mode);
			return Math.ceil((this.loanDetails.terms / 30) * mode);
		},
		docStamp:function(){
			this.loanDetails.documents_stamp =  (this.loanDetails.loan_amount / 200 * 1.5 * this.loanDetails.terms / 365).toFixed(2);
			if(this.loanDetails.terms / 30 > 12){
				this.loanDetails.documents_stamp =  (this.loanDetails.loan_amount / 200 * 1.5).toFixed(2);
			}
			return this.loanDetails.documents_stamp;
		},
		calculateInsurance:function(){
			let rate = 1;
			if(this.age > 65){
				rate = 2.8;
			}
			this.loanDetails.insurance =  ((this.loanDetails.loan_amount / 1000) * rate * (Math.ceil(this.loanDetails.terms / 30))).toFixed(2);
			return this.loanDetails.insurance;
		},
		totalDeductions:function(){
			this.loanDetails.total_deduction = (parseFloat(this.loanDetails.memo) + parseFloat(this.loanDetails.filing_fee) + parseFloat(this.loanDetails.affidavit_fee) + parseFloat(this.loanDetails.notarial_fee) + parseFloat(this.loanDetails.documents_stamp) + parseFloat(this.loanDetails.insurance)).toFixed(2);
			return this.loanDetails.total_deduction;
		},
		netProceeds:function(){
			this.loanDetails.net_proceeds = (parseFloat(this.loanDetails.loan_amount) - parseFloat(this.loanDetails.total_deduction));
			return this.loanDetails.net_proceeds;
		},
		amortAmount:function(){
			(this.loanDetails.loan_amount + this.interestAmount) / this.numberOfInstallment;
		}
	},
	mounted(){
		this.fetchProducts();
		this.fetchAo();
		this.fetchCenters();
		this.loanDetails = this.loandetails;
	}
}
</script>