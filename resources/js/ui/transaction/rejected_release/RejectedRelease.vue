<template>
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between">
			<h1 class="m-0 font-35">Rejected Release</h1>
			<a href="#" class="btn btn-primary-dark min-w-150">New Client</a>
		</div>
		<div class="d-flex flex-column flex-xl-row p-16">
			<div style="flex:9;">
				<div class="search-bar mb-12">
					<input v-model="filter" type="text" class="form-control" id="searchBar" placeholder="Search">
					<div><i class="fa fa-search"></i></div>
				</div>
				<table class="table table-stripped table-hover" id="clientsList">
					<thead>
						<th>Account #</th>
						<th>Client Name</th>
						<th></th>
					</thead>
					<tbody>
						<tr v-if="filterAccounts.length == 0">
							<td>No rejected accounts found.</td>
							<td></td>
							<td></td>
						</tr>
						<tr v-for="account in filterAccounts" :key="account.loan_account_id" class="loan-item" :class="isActive(account)">
							<td>{{account.account_num}}</td>
							<td><a href="#">{{account.borrower.firstname + ' ' + account.borrower.lastname}}</a></td>
							<td @click="loanAccount=account"><span class="text-green c-pointer">Select</span></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div style="flex:20">
				<section class="mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title mb-24">Details</span>
					<div class="d-flex mb-12">
						<div class="d-flex flex-column mr-16" style="flex:20;">
							<div class="d-flex flex-row">
								<div class="borrower-number d-flex flex-column" style="flex: 5">
									<span>Borrower's Number</span>
									<span class="text-center">{{loanAccount.borrower.borrower_num}}</span>
								</div>
								<div style="flex:3"></div>
								<div class="form-group mb-10 mr-16" style="flex: 5">
									<label for="transactionDate" class="form-label">Loan Account #</label>
									<input :value="loanAccount.account_num" type="text" class="form-control form-input text-right" id="loanAccountNumber">
								</div>
								<div class="form-group mb-10" style="flex: 4">
									<label for="transactionDate" class="form-label">Transaction Date</label>
									<input :value="dateToYMD(new Date)" type="date" class="form-control form-input text-right" id="transactionDate">
								</div>
							</div>
							<div class="form-group mb-5" style="flex: 5">
								<label for="client" class="form-label mb-3">Client</label>
								<input :value="loanAccount.borrower.firstname + ' ' + loanAccount.borrower.lastname" type="text" class="form-control form-input " id="client">
							</div>
							<div class="form-group mb-10" style="flex: 5">
								<label for="address" class="form-label mb-3">Address</label>
								<input :value="loanAccount.borrower.address" type="text" class="form-control form-input " id="address">
							</div>
						</div>
						<div class="upload-photo d-flex flex-column" style="flex:4;padding-top:36px;">
							<img :src="borrowerPhoto" style="max-width:210px" alt="">
						</div>
					</div>
					<div class="sep mb-24"></div>
				</section>

				<section class="mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-24">Loan Application</span>
					<div class="d-flex flex-row loan-details">
						<div class="d-flex flex-column flex-1">
							<h4 class="text-primary-dark mb-12">Loan Details</h4>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Amount Loan</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{formatToCurrency(loanAccount.loan_amount)}}</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Interest</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{formatToCurrency(loanAccount.interest_amount)}}</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Term</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{loanAccount.terms}}</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Rate</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{loanAccount.interest_rate}}%</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Type</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{loanAccount.type}}</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Mode</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{loanAccount.payment_mode}}</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Product</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{loanAccount.product.product_name}}</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Net Amount</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{formatToCurrency(loanAccount.loan_amount - totalDeductions)}}</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Day Schedule</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{loanAccount.day_schedule}}</span>
							</div>

					
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class=""># of Installment</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{numOfInstallment}}</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Center Name</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{center}}</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Account Officer</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{loanAccount.account_officer.name}}</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Co Borrower</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{loanAccount.co_borrower_name}}</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Co Borrower Address</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{loanAccount.co_borrower_address}}</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Co Maker</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{loanAccount.co_maker_name}}</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Co Maker Address</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{loanAccount.co_maker_address}}</span>
							</div>
						</div>
						<div class="d-flex flex-column flex-1">
							<h4 class="text-primary-dark mb-12">Deductions</h4>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Filling Fee</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{formatToCurrency(loanAccount.filing_fee)}}</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Documents</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{formatToCurrency(loanAccount.document_stamp)}}</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Insurance</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{formatToCurrency(loanAccount.insurance)}}</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Notarial</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{formatToCurrency(loanAccount.notarial_fee)}}</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Prepaid_interest</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{formatToCurrency(prepaidInterest)}}</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Affidavit</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{formatToCurrency(loanAccount.affidavit_fee)}}</span>
							</div>
							<div class="d-flex flex-row mb-24">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Memo</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">{{formatToCurrency(loanAccount.memo)}}</span>
							</div>
							<div class="d-flex flex-row mb-12 bb-dark-10">
								
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="text-bold">Total Deduction</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark text-bold">{{formatToCurrency(totalDeductions)}}</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="text-bold">Net Amount</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark text-bold">{{formatToCurrency(loanAccount.loan_amount - totalDeductions)}}</span>
							</div>
						</div>
					</div>
				</section>

				<section class="mb-24" style="flex:21;padding-left:16px;">
					<!-- <span class="section-title section-subtitle mb-24">Amortization Schedules</span>
					<div class="loan-details mb-24">
						<table class="table table-stripped th-nbt">
							<thead>
								<th class="text-primary-dark">No.</th>
								<th class="text-primary-dark">Date</th>
								<th class="text-primary-dark">Principal</th>
								<th class="text-primary-dark">Interest</th>
								<th class="text-primary-dark">Total</th>
								<th class="text-primary-dark">Prin. Bal.</th>
								<th class="text-primary-dark">Int. Bal.</th>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
									<td>740</td>
									<td>2,282.00</td>
									<td>35,475.00</td>
									<td>17,200.00</td>
								</tr>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
									<td>740</td>
									<td>2,282.00</td>
									<td>35,475.00</td>
									<td>17,200.00</td>
								</tr>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
									<td>740</td>
									<td>2,282.00</td>
									<td>35,475.00</td>
									<td>17,200.00</td>
								</tr>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
									<td>740</td>
									<td>2,282.00</td>
									<td>35,475.00</td>
									<td>17,200.00</td>
								</tr>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
									<td>740</td>
									<td>2,282.00</td>
									<td>35,475.00</td>
									<td>17,200.00</td>
								</tr>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
									<td>740</td>
									<td>2,282.00</td>
									<td>35,475.00</td>
									<td>17,200.00</td>
								</tr>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
									<td>740</td>
									<td>2,282.00</td>
									<td>35,475.00</td>
									<td>17,200.00</td>
								</tr>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
									<td>740</td>
									<td>2,282.00</td>
									<td>35,475.00</td>
									<td>17,200.00</td>
								</tr>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
									<td>740</td>
									<td>2,282.00</td>
									<td>35,475.00</td>
									<td>17,200.00</td>
								</tr>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
									<td>740</td>
									<td>2,282.00</td>
									<td>35,475.00</td>
									<td>17,200.00</td>
								</tr>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
									<td>740</td>
									<td>2,282.00</td>
									<td>35,475.00</td>
									<td>17,200.00</td>
								</tr>
							</tbody>
						</table>
					</div> -->
					<div class="d-flex flex-row">
						<div style="flex:2"></div>
						<div v-if="loanAccount.loan_account_id" class="d-flex flex-row-reverse" style="flex:3">
							<a href="#" class="flex-1 btn btn-black mw-150">Cancel</a>
							<a href="#" data-toggle="modal" data-target="#editModal" class="mr-16 flex-1 btn btn-bright-blue mw-150">Edit</a>
						</div>
					</div>
				</section>
			</div>
		</div>
		<div class="modal" id="editModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-body">
			  <div class="d-flex flex-column" style="min-height:200px;padding:16px;">
				  <div class="d-flex flex-1 justify-content-center align-items-center">
					<p class="text-24 text-center mb-24">You are about to edit the Loan Details, Proceed anyway?</p>
				  </div>
				  <div class="d-flex flex-row">
					  <div style="flex:2"></div>
					  <a :href="'/transaction/rejected_release/edit/' + loanAccount.loan_account_id" class="btn btn-lg btn-primary-dark mr-24" style="flex:3">Yes</a>
					  <button data-dismiss="modal" class="btn btn-lg btn-bright-blue" style="flex:3">No</button>
					  <div style="flex:2"></div>
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
	props:['token','rejectid'],
	data(){
		return {
			loanAccounts:[],
			filter:'',
			loanAccount:{
				loan_account_id:null,
				cycle_no : 1,
				ao_id : '',
				product_id : '',
				center_id : '',
				type : '',
				payment_mode : '',
				terms : 0,
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
				document_stamp : 0.00,
				filing_fee : 0.00,
				insurance : 0.00,
				notarial_fee : 100.00,
				prepaid_interest : 0.00,
				affidavit_fee : 0.00,
				memo : 0.00,
				total_deduction : 0.00,
				net_proceeds : 0.00,
				release_type : '',
				borrower:{
					borrower_num:'################',
					firstname:'',
					middlename:'',
					lastname:''
				},
				product:{
					product_name:''
				},
				account_officer:{
					name:''
				},
				center:{
					center:''
				}
			}
		}
	},
	methods: {
		fetchRejectedAccounts:function(){
			axios.get(window.location.origin + '/api/account/rejected/', {
			headers: {
				'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loanAccounts = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		isActive:function(data){
			if(data.loan_account_id == this.loanAccount.loan_account_id){
				return 'active'
			}
			return '';
		}
	},
	computed:{
		filterAccounts:function(){
			var accounts = [];
			this.loanAccounts.map(function(account){
				if(account.borrower.firstname.toLowerCase().includes(this.filter.toLowerCase()) || account.borrower.lastname.toLowerCase().includes(this.filter.toLowerCase()) || (account.borrower.firstname + ' ' + account.borrower.lastname).toLowerCase().includes(this.filter.toLowerCase()) || (account.borrower.lastname + ' ' + account.borrower.firstname).toLowerCase().includes(this.filter.toLowerCase()) || account.borrower.borrower_num.toLowerCase().includes(this.filter.toLowerCase())){
					accounts.push(account);
				}
			}.bind(this));
			return accounts;
		},
		borrowerPhoto:function(){
			return this.loanAccount.borrower_photo? this.loanAccount.borrower_photo : '/img/user.png';
		},
		dueDate:function(){
			if(this.loanAccount.loan_account_id){
				var dt = new Date(this.loanAccount.date_release);
				dt.setDate(dt.getDate() + this.loanAccount.terms);
				return dt;
			}
			return new Date
		},
		dueDate:function(){
			if(this.loanAccount.loan_account_id && this.loanAccount.date_release){
				var dt = new Date(this.loanAccount.date_release);
				dt.setDate(dt.getDate() + this.loanAccount.terms);
				return dt;
			}
			return new Date
		},
		numOfInstallment:function(){
			return this.loanAccount.terms / 30;
		},
		totalDeductions:function(){
			return this.loanAccount.filing_fee + this.loanAccount.document_stamp + this.loanAccount.insurance + this.loanAccount.notarial_fee + this.loanAccount.prepaid_interest + this.loanAccount.affidavit_fee + this.loanAccount.memo;
		},
		center:function(){
			return this.loanAccount.center? this.loanAccount.center.center : '';
		},
		prepaidInterest:function(){
			return this.loanAccount.type=='Add-On'? 0 : this.loanAccount.prepaid_interest;
		}
	},
	mounted(){
		this.fetchRejectedAccounts();
	}
}
</script>

<style lang="scss" scoped>
	.loan-item.active {
		background-color: #ccffcc;
	}
</style>
