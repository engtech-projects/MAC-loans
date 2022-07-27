<template>
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div class="mb-16"></div>
			<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between">
				<h1 class="m-0 font-35">Override Payment</h1>
				<a href="#" class="btn btn-primary-dark min-w-150">New Client</a>
			</div>
		<div class="d-flex flex-column flex-xl-row p-16">
			<div style="flex:9;">
				<div class="mb-12">
					<div class="d-flex">
						<div class="form-group mr-7 flex-1">
							<!-- <select class="form-control select2 select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true">
								<option value="">2022/11/11</option>
							</select> -->
							<input v-model="filter.created_at" type="date" class="form-control" placeholder="Pick a date">
						</div>
						<div class="form-group flex-2">
							<input type="text" class="form-control" placeholder="Specifications">
						</div>
					</div>
				</div>
				<table class="table table-stripped mb-10" id="clientsList">
					<thead>
						<th>All</th>
						<th>Account #</th>
						<th>Client Name</th>
						<th></th>
					</thead>
					<tbody>
						<tr v-for="p in payments" :key="p.payment_id" class="client-item" :class="payment.payment_id==p.payment_id?'active':''">
							<td style="vertical-align:middle;"><input v-model="p.checked" type="checkbox" class="form-control form-box"></td>
							<td>{{p.account_num}}</td>
							<td><a href="#">{{p.firstname + ' ' + p.lastname}}</a></td>
							<td @click="payment=p"><span class="text-green c-pointer">select</span></td>
						</tr>
					
					</tbody>
				</table>
				<div class="d-flex flex-row-reverse sep-thin pb-10 mb-16" style="border-bottom-color:#CCC!important;">
					<a href="#" class="btn btn-success">Batch Override</a>
					<a href="#" data-toggle="modal" data-target="#overrideDetailsModal" class="btn btn-primary min-w-150 mr-16">View</a>
				</div>
				<section class="light-bb mb-16">
					<div class="d-flex flex-column mb-16">
						<div class="d-flex flex-row mb-12">
							<div class="d-flex flex-row flex-2 justify-content-between pr-24">
								<span class="">Unselected</span>
								<span>:</span>
							</div>
							<span class="flex-3 text-primary-dark">P {{formatToCurrency(unselected)}}</span>
						</div>
						<div class="d-flex flex-row mb-12">
							<div class="d-flex flex-row flex-2 justify-content-between pr-24">
								<span class="">Selected</span>
								<span>:</span>
							</div>
							<span class="flex-3 text-primary-dark">P {{formatToCurrency(selected)}}</span>
						</div>
						<div class="d-flex flex-row mb-12">
							<div class="d-flex flex-row flex-2 justify-content-between pr-24">
								<span class="">TOTAL</span>
								<span>:</span>
							</div>
							<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalSelect)}}</span>
						</div>
					</div>
				</section>
				<section>
					<h4 class="section-title section-subtitle b-none">Payment Summary</h4>
					<div class="d-flex flex-column mb-16">
						<div class="d-flex flex-row mb-12">
							<div class="d-flex flex-row flex-2 justify-content-between pr-24">
								<span class="">Total Cash</span>
								<span>:</span>
							</div>
							<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalCash)}}</span>
						</div>
						<div class="d-flex flex-row mb-12">
							<div class="d-flex flex-row flex-2 justify-content-between pr-24">
								<span class="">Total Memo</span>
								<span>:</span>
							</div>
							<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalMemo)}}</span>
						</div>
						<div class="d-flex flex-row mb-12">
							<div class="d-flex flex-row flex-2 justify-content-between pr-24">
								<span class="">Total Check</span>
								<span>:</span>
							</div>
							<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalCheck)}}</span>
						</div>
						<div class="d-flex flex-row mb-12">
							<div class="d-flex flex-row flex-2 justify-content-between pr-24">
								<span class="">Total Memo Payment</span>
								<span>:</span>
							</div>
							<span class="flex-3 text-primary-dark">P 0.00</span>
						</div>
					</div>
					<div class="d-flex flex-column mb-24">
						<div class="d-flex flex-column mb-5">
							<span class="text-primary-dark font-20 bb-primary-dark">PRINCIPAL</span>
							<span class="text-right font-md">P {{formatToCurrency(totalPrincipal)}}</span>
						</div>
						<div class="d-flex flex-column mb-5">
							<span class="text-primary-dark font-20 bb-primary-dark">INTEREST</span>
							<span class="text-right font-md">P {{formatToCurrency(totalInterest)}}</span>
						</div>
						<div class="d-flex flex-column mb-5">
							<span class="text-primary-dark font-20 bb-primary-dark">PENALTY / PDI</span>
							<span class="text-right font-md">P {{formatToCurrency(totalPDI)}}</span>
						</div>
						<div class="d-flex flex-column mb-5">
							<span class="text-primary-dark font-20 bb-primary-dark">OTHERS</span>
							<span class="text-right font-md">P 0.00</span>
						</div>
						<div class="d-flex flex-column mb-5">
							<span class="text-primary-dark font-20 bb-primary-dark">DISCOUNT</span>
							<span class="text-right font-md">P {{formatToCurrency(totalDiscount)}}</span>
						</div>
						<div class="d-flex flex-column mb-5">
							<span class="text-primary-dark font-20 bb-primary-dark">INSURANCE</span>
							<span class="text-right font-md">P 0.00</span>
						</div>
					</div>
					<div class="d-flex flex-column button-text">
						<span>TOTAL PAYMENT FOR TODAY</span>
						<div class="d-flex flex-row">
							<span>P</span>
							<span>{{formatToCurrency(totalPayment)}}</span>
						</div>
					</div>
				</section>
			</div>
			<overridepayment-details :ppayment="payment" :token="token"></overridepayment-details>
		</div>
	</div>
</template>

<script>
export default {
	props:['token'],
	data(){
		return {
			payments:[],
			filter:{
				created_at: this.dateToYMD(new Date()),
			},
			dates:[],
			payment:{
				payment_id:null,
				borrower_num:'##############',
				firstname:'',
				lastname:'',
				address:'',
			}
		}
	},
	methods:{
		fetchPayments:function(){
			axios.post(this.baseUrl() + '/api/payment/list',this.filter,{
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.payments = this.setCheckbox(response.data.data);
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		overridePaymentDates:function(){
			axios.get(this.baseUrl() + '/transaction/overridepaymentdates')
			.then(function (response) {
				this.dates = response.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		setCheckbox:function(data){
			for(let i in data){
				data[i].checked = false;
			}
			return data;
		},
	},
	computed:{
		selected:function(){
			var amount = 0;
			this.payments.map(function(payment){
				if(payment.checked){
					amount += payment.amount_applied;
				}
			});
			return amount;
		},
		unselected:function(){
			var amount = 0;
			this.payments.map(function(payment){
				if(!payment.checked){
					amount += payment.amount_applied;
				}
			});
			return amount;
		},
		totalSelect:function(){
			return this.selected + this.unselected;
		},
		totalCash:function(){
			var amount = 0;
			this.payments.map(function(payment){
				if(payment.payment_type == 'cash'){
					amount += payment.amount_applied;
				}
			});
			return amount;
		},
		totalCheck:function(){
			var amount = 0;
			this.payments.map(function(payment){
				if(payment.payment_type == 'check'){
					amount += payment.amount_applied;
				}
			});
			return amount;
		},
		totalMemo:function(){
			var amount = 0;
			this.payments.map(function(payment){
				if(payment.payment_type == 'memo'){
					amount += payment.amount_applied;
				}
			});
			return amount;
		},
		totalPayment:function(){
			return this.selected + this.unselected;
		},
		totalPrincipal:function(){
			var amount = 0;
			this.payments.map(function(payment){
				amount += payment.principal;
			});
			return amount;
		},
		totalInterest:function(){
			var amount = 0;
			this.payments.map(function(payment){
				amount += payment.interest;
			});
			return amount;
		},
		totalPDI:function(){
			var amount = 0;
			this.payments.map(function(payment){
				amount += payment.pdi;
			});
			return amount;
		},
		totalDiscount:function(){
			var amount = 0;
			this.payments.map(function(payment){
				amount += payment.rebates;
			});
			return amount;
		},
	},
	watch:{
		'filter.created_at':function(newValue){
			this.fetchPayments();
		}
	},
	mounted(){
		this.fetchPayments();
		this.overridePaymentDates();
	}
}
</script>