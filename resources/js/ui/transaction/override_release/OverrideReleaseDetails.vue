<template>
	<div class="d-flex flex-column">
		<section class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Details</span>
			<div class="d-flex mb-12">
				<div class="d-flex flex-column mr-16" style="flex:20;">
					<div class="d-flex flex-row">
						<div class="borrower-number d-flex flex-column" style="flex: 5">
							<span>Borrower's Number</span>
							<span class="text-center">{{borrower.borrower_num}}</span>
						</div>
						<div style="flex:4"></div>
						<div class="form-group mb-10" style="flex: 5">
							<label for="transactionDate" class="form-label">Transaction Date</label>
							<input :value="dateToYMD(new Date(loanDetails.created_at))" type="date" class="form-control form-input text-right" id="transactionDate">
						</div>
					</div>
					<div class="form-group mb-5" style="flex: 5">
						<label for="client" class="form-label mb-3">Client</label>
						<input :value="borrower.firstname + ' ' + borrower.lastname" type="text" class="form-control form-input " id="client">
					</div>
					<div class="form-group mb-10" style="flex: 5">
						<label for="address" class="form-label mb-3">Address</label>
						<input :value="borrower.address" type="text" class="form-control form-input " id="address">
					</div>
				</div>
				<div class="upload-photo d-flex flex-column" style="flex:4;padding-top:36px;">
					<img src="/img/user.png" alt="">
				</div>
			</div>
			<div class="sep mb-24"></div>
		</section>

		<section v-if="loanDetails.loan_account_id" class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title section-subtitle mb-24">Loan Application</span>
			<div class="d-flex flex-row loan-details mb-24">
				<div class="d-flex flex-column flex-1">
					<h4 class="text-primary-dark mb-12">Deduction Fees</h4>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Filling Fee</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanDetails.filing_fee}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Documents</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanDetails.document_stamp}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Insurance</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanDetails.insurance}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Notarial</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanDetails.notarial_fee}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Prepaid Interest</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanDetails.prepaid_interest}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Other / Mem</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanDetails.memo}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Net Amount</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanDetails.net_proceeds}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Release Type</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanDetails.release_type}}</span>
					</div>
				</div>
				<div class="d-flex flex-column flex-1">
					<h4 class="text-primary-dark mb-12">Loan Details</h4>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Amount Loan</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanDetails.loan_amount}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Interest</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanDetails.filing_fee}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Term</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanDetails.terms}} Days</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Rate</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">30%</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Type</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanDetails.type}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Mode</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanDetails.payment_mode}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Product</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{productName}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Center Name</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">Albatross</span>
					</div>

				</div>
			</div>
			<div class="d-flex flex-row">
				<div class="d-flex flex-row align-items-between" style="flex:1">
					<a href="#" data-toggle="modal" data-target="#lettersModal" class="mr-16 flex-1 btn btn-yellow-light">Print Document</a>
					<a href="#" data-toggle="modal" data-target="#schedulesModal" class="mr-16 flex-1 btn btn-orange">Print Amort. Sched.</a>
					<a href="#" data-toggle="modal" data-target="#cashVoucherModal" class="mr-16 flex-1 btn btn-brown">Print Voucher</a>
					<a href="#" data-toggle="modal" data-target="#rejectModal" class="mr-16 flex-1 btn btn-primary-dark">Reject</a>
					<a href="#" class="mr-16 flex-1 btn btn-primary">Delete</a>
					<a href="#" data-toggle="modal" data-target="" class="flex-1 btn btn-success">Override</a>
				</div>
			</div>
		</section>
	</div>
</template>

<script>
export default {
	props:['pborrower', 'pdate', 'token'],
	data(){
		return {
			borrower:'',
			loanDetails:'',
			centers:[],
			products:[],
			productName:'',
		}
	},
	methods:{
		fetchCenters:function(){
			axios.get(window.location.origin + '/api/center', {
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
		fetchProducts: function(){
			axios.get(window.location.origin + '/api/product/', {
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
	},
	computed:{
		setLoanDetails:function(){
			this.borrower.loanAccounts.map(function(data){
				if(this.dateToYMD(new Date(this.pdate)) == this.dateToYMD(new Date(data.created_at))){
					this.loanDetails = data;
				}
			}.bind(this));
		},
		product:function(){
			this.products.map(function(product){
				if(this.loanDetails.product_id == product.product_id){
					this.productName = product.product_name;
				}
			}.bind(this));
		},
	},
	watch:{
		'pborrower'(newData){
			this.borrower = newData;
			this.setLoanDetails;
		},
		'pdate'(){
			this.setLoanDetails;
			this.product;
		}
	},
}
</script>