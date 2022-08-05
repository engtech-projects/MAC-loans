<template>
	<div style="flex:20">
		<section class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Details</span>
			<div class="d-flex mb-12">
				<div class="d-flex flex-column mr-16" style="flex:20;">
					<div class="d-flex flex-row">
						<div class="borrower-number d-flex flex-column" style="flex: 5">
							<span>Borrower's Number</span>
							<span class="text-center">{{ppayment.borrower_num}}</span>
						</div>
						<div style="flex:4"></div>
						<div class="form-group mb-10" style="flex: 5">
							<label for="transactionDate" class="form-label">Transaction Date</label>
							<input :value="this.dateToYMD(new Date)" type="date" class="form-control form-input text-right" id="transactionDate">
						</div>
					</div>
					<div class="form-group mb-5" style="flex: 5">
						<label for="client" class="form-label mb-3">Client</label>
						<input :value="ppayment.firstname + ' ' + ppayment.lastname" type="text" class="form-control form-input " id="client">
					</div>
					<div class="form-group mb-10" style="flex: 5">
						<label for="address" class="form-label mb-3">Address</label>
						<input :value="ppayment.address" type="text" class="form-control form-input " id="address">
					</div>
				</div>
				<div class="upload-photo d-flex flex-column" style="flex:4;padding-top:36px;">
					<img src="/img/user.png" alt="">
				</div>
			</div>
			<div class="sep mb-24"></div>
		</section>

		<!-- <section v-if="ppayment.payment_id" class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title section-subtitle mb-16">Loan Account Summary</span>
			<div class="d-flex" style="padding:16px;border:1px solid #ccc;">
				<div class="d-flex flex-column flex-1">
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-2 justify-content-between pr-24">
							<span class="">Account#</span>
							<span>:</span>
						</div>
						<span class="flex-3 text-primary-dark">{{ppayment.account_num}}</span>
					</div>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-2 justify-content-between pr-24">
							<span class="">Total Cash</span>
							<span>:</span>
						</div>
						<span class="flex-3 text-primary-dark">P {{formatToCurrency(ppayment.amount_applied)}}</span>
					</div>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-2 justify-content-between pr-24">
							<span class="">Total Memo</span>
							<span>:</span>
						</div>
						<span class="flex-3 text-primary-dark">P 0.00</span>
					</div>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-2 justify-content-between pr-24">
							<span class="">Total Check</span>
							<span>:</span>
						</div>
						<span class="flex-3 text-primary-dark">P 0.00</span>
					</div>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-2 justify-content-between pr-24">
							<span class="">Total Memo Payment</span>
							<span>:</span>
						</div>
						<span class="flex-3 text-primary-dark">P {{formatToCurrency(ppayment.amount_applied)}}</span>
					</div>
				</div>
				<div class="flex-1"></div>
			</div>
		</section> -->

		<section v-if="ppayment.payment_id" class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title section-subtitle mb-16">Payment Summary</span>
			<div class="d-flex flex-column mb-16" style="padding:10px;border:1px solid #ddd">
				<div class="d-flex flex-row mb-24">
					<div class="d-flex flex-row flex-2 mr-24">
						<div class="d-flex flex-1 text-white p-10 bg-dark-gray mr-16 font-20 align-items-center">
							<span class="mr-16">OR. Number :</span>
							<span>{{ppayment.or_no}}</span>
						</div>
						<div class="d-flex flex-1 text-white p-10 bg-green font-20 align-items-center">
							<span class="mr-16">TOTAL PAYMENT :</span>
							<span>P {{formatToCurrency(ppayment.amount_applied)}}</span>
						</div>
					</div>
					<div class="d-flex flex-row flex-1">
						<div class="d-flex flex-column flex-1 mr-24">
							<span class="font-20 lh-1 pb-5 mb-5" style="border-bottom:1px solid #555;">TYPE</span>
							<span class="font-20 lh-1">{{ppayment.payment_type}}</span>
						</div>
						<div class="d-flex flex-column flex-1">
							<span class="font-20 lh-1 pb-5 mb-5" style="border-bottom:1px solid #555;">PRINCIPAL</span>
							<span class="font-20 lh-1">P {{formatToCurrency(ppayment.principal)}}</span>
						</div>
					</div>
				</div>

				<div class="d-flex flex-row mb-24">
					<div class="d-flex flex-column flex-1 mr-24">
						<span class="font-20 lh-1 pb-5 mb-5" style="border-bottom:1px solid #555;">INTEREST</span>
						<span class="font-20 lh-1">P {{formatToCurrency(ppayment.interest)}}</span>
					</div>
					<div class="d-flex flex-column flex-1 mr-24">
						<span class="font-20 lh-1 pb-5 mb-5" style="border-bottom:1px solid #555;">PENALTY / PDI</span>
						<span class="font-20 lh-1">P {{formatToCurrency(ppayment.pdi)}}</span>
					</div>
					<div class="d-flex flex-column flex-1 mr-24">
						<span class="font-20 lh-1 pb-5 mb-5" style="border-bottom:1px solid #555;">OTHERS</span>
						<span class="font-20 lh-1">P 0.00</span>
					</div>
					<div class="d-flex flex-column flex-1 mr-24">
						<span class="font-20 lh-1 pb-5 mb-5" style="border-bottom:1px solid #555;">DISCOUNT</span>
						<span class="font-20 lh-1">P {{formatToCurrency(ppayment.rebates)}}</span>
					</div>
					<div class="d-flex flex-column flex-1">
						<span class="font-20 lh-1 pb-5 mb-5" style="border-bottom:1px solid #555;">INSURANCE</span>
						<span class="font-20 lh-1">P 0.00</span>
					</div>
				</div>
				<div class="p-16 bg-yellow d-flex">
					<div class="d-flex flex-column flex-1 mr-24">
						<span class="bb-primary-dark font-20 text-primary-dark">LESS</span>
						<span></span>
					</div>
					<div class="d-flex flex-column flex-1 mr-16">
						<span class="font-20 text-primary-dark">Rebates</span>
						<span>P {{formatToCurrency(ppayment.rebates)}}</span>
					</div>
					<div class="d-flex flex-column flex-1 mr-16">
						<span class="font-20 text-primary-dark">Discount</span>
						<span>P 0.00</span>
					</div>
					<div class="d-flex flex-column flex-1 mr-16">
						<span class="font-20 text-primary-dark">Wave: PDI</span>
						<span>P 0.00</span>
					</div>
					<div class="d-flex flex-column flex-1">
						<span class="font-20 text-primary-dark">Prepd</span>
						<span>P 0.00</span>
					</div>
				</div>
			</div>
			<div class="d-flex flex-row-reverse">
				<a href="#" class="btn btn-success min-w-150" @click="override()">Override</a>
				<a href="#" data-toggle="modal" data-target="#cancelModal" class="btn btn-bright-blue min-w-150 mr-16">Delete</a>
			</div>
		</section>
	</div>
</template>

<script>
export default {
	props:['ppayment', 'token'],
	methods:{
		override:function(){
			axios.post(this.baseURL() + 'api/payment/override',[this.ppayment],{
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				console.log(response.data);
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
	}
	
}
</script>

<style lang="scss" scoped>
	
</style>