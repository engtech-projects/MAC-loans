<template>
	<div class="modal" id="overrideDetailsModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-xl" style="min-width:90%" role="document">
		  <div class="modal-content">
			<div class="modal-body">
				<div class="d-flex flex-row justify-content-between align-items-center light-bb pb-16">
					<span class="text-primary-dark text-bold">View Override Details</span>
					<div class="d-flex flex-row">
						<div class="d-flex font-md mr-24 align-items-center">
							<span class="mr-5">Date:</span>
							<span>12/12/2021</span>
						</div>
						<div class="d-flex font-md align-items-center mr-45">
							<span class="mr-5">Time:</span>
							<span>12:00 PM</span>
						</div>
						<div class="d-flex flex-row align-items-center mr-24">
							<span class="mr-10 flex-1">Account Officer : </span>
							<select v-model="filter.ao" class="form-control flex-1 min-w-200" name="" id="">
								<option value="all">All</option>
								<option v-for="aao in setAo" :key="aao.ao_id" :value="aao.ao_id">{{aao.name}}</option>
							</select>
						</div>
						<div class="d-flex flex-row align-items-center mr-24">
							<span class="mr-10 flex-1">Center : </span>
							<select v-model="filter.center" class="form-control min-w-200 flex-1" name="" id="">
								<option value="all">All</option>
								<option v-for="cc in setCenter" :key="cc.center_id" :value="cc.center_id">{{cc.center}}</option>
							</select>
						</div>
						<div class="d-flex flex-row align-items-center">
							<span class="mr-10 flex-1">Product Name : </span>
							<select v-model="filter.product" class="form-control min-w-200 flex-1" name="" id="">
								<option value="all">All</option>
								<option v-for="pp in setProduct" :key="pp.product_id" :value="pp.product_id">{{pp.product_name}}</option>
							</select>
						</div>
					</div>
				</div>
				<table class="table table-stripped light-bb">
					<thead>
						<th>Account #</th>
						<th>Account Name</th>
						<th>O.R #</th>
						<th>Total Payment</th>
						<th>Type</th>
						<th>Principal</th>
						<th>Interest</th>
						<th>Pnlty / PDI</th>
						<th>Others</th>
						<th>Discount</th>
						<th>Life Ins.</th>
					</thead>
					<tbody>
						<tr v-for="p in filteredPayments" :key="p.payment_id">
							<td>{{p.loan_details.account_num}}</td>
							<td>{{p.loan_details.borrower.firstname + ' ' + p.loan_details.borrower.lastname}}</td>
							<td>{{p.or_no}}</td>
							<td>{{formatToCurrency(p.amount_applied)}}</td>
							<td>{{p.payment_type}}</td>
							<td>{{formatToCurrency(p.principal)}}</td>
							<td>{{formatToCurrency(p.interest)}}</td>
							<td>{{formatToCurrency(p.pdi + p.penalty)}}</td>
							<td>0.00</td>
							<td>{{formatToCurrency(p.rebates)}}</td>
							<td>{{p.ao_id}}</td>
						</tr>
						<!-- <tr>
							<td>0212154265</td>
							<td>Jose Pedales</td>
							<td>0000015711</td>
							<td>12,000.00</td>
							<td>CASH</td>
							<td>32,000.00</td>
							<td>2,000.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>200.00</td>
						</tr>
						<tr>
							<td>0212154265</td>
							<td>Jose Pedales</td>
							<td>0000015711</td>
							<td>12,000.00</td>
							<td>CASH</td>
							<td>32,000.00</td>
							<td>2,000.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>200.00</td>
						</tr>
						<tr>
							<td>0212154265</td>
							<td>Jose Pedales</td>
							<td>0000015711</td>
							<td>12,000.00</td>
							<td>CASH</td>
							<td>32,000.00</td>
							<td>2,000.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>200.00</td>
						</tr>
						<tr>
							<td>0212154265</td>
							<td>Jose Pedales</td>
							<td>0000015711</td>
							<td>12,000.00</td>
							<td>CASH</td>
							<td>32,000.00</td>
							<td>2,000.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>200.00</td>
						</tr>
						<tr>
							<td>0212154265</td>
							<td>Jose Pedales</td>
							<td>0000015711</td>
							<td>12,000.00</td>
							<td>CASH</td>
							<td>32,000.00</td>
							<td>2,000.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>200.00</td>
						</tr>
						<tr>
							<td>0212154265</td>
							<td>Jose Pedales</td>
							<td>0000015711</td>
							<td>12,000.00</td>
							<td>CASH</td>
							<td>32,000.00</td>
							<td>2,000.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>200.00</td>
						</tr>
						<tr>
							<td>0212154265</td>
							<td>Jose Pedales</td>
							<td>0000015711</td>
							<td>12,000.00</td>
							<td>CASH</td>
							<td>32,000.00</td>
							<td>2,000.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>200.00</td>
						</tr>
						<tr>
							<td>0212154265</td>
							<td>Jose Pedales</td>
							<td>0000015711</td>
							<td>12,000.00</td>
							<td>CASH</td>
							<td>32,000.00</td>
							<td>2,000.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>200.00</td>
						</tr>
						<tr class="bbt-8 text-primary-dark text-bold">
							<td>TOTAL</td>
							<td></td>
							<td></td>
							<td>21,000.00</td>
							<td></td>
							<td>323,000.00</td>
							<td>323,000.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>00.00</td>
						</tr> -->
					</tbody>
				</table>
				<div class="d-flex align-items-end mb-45">
					<section class="flex-1">
					   <h4 class="section-title section-subtitle b-none">Payment Summary</h4>
					   <div class="d-flex flex-column">
							<div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="">Total Cash</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalCash)}}</span>
							</div>
							<div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="">Total Cheque</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalCheck)}}</span>
							</div>
							<div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="">POS</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P 0.00</span>
							</div>
							<div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="">Total Memo Payment</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P 0.00</span>
							</div>
							<div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="pl-24">Interbranch</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P 0.00</span>
							</div>
							<div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="pl-24">Deduct to Balance</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P 0.00</span>
							</div>
							<div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="pl-24">Offset P.F</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P 0.00</span>
							</div>
							<div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="pl-24">Rebates & Disc.</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P 0.00</span>
							</div>
							<div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="">TOTAL POS</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalPos)}}</span>
							</div>
					   </div>
					</section>
					<section class="flex-2 d-flex align-items-start">
						<div class="d-flex flex-column button-text mr-45">
						   <span>TOTAL PAYMENT</span>
						   <div class="d-flex flex-row">
							   <span>P</span>
							   <span>{{formatToCurrency(totalPos + totalCash + totalCheck)}}</span>
						   </div>
					   </div>
					   <span class="flex-1 bb-primary-dark pb-24 mr-24">Prepared by:</span>
					   <span class="flex-1 bb-primary-dark pb-24 mr-24">Certified Corrected by:</span>
					   <span class="flex-1 bb-primary-dark pb-24">Approved by:</span>
					</section>
					<section class="d-flex flex-1 justify-content-end">
						<a href="#" data-dismiss="modal" class="btn btn-success mr-16">Download to Excel</a>
						<a href="#" data-dismiss="modal" class="btn btn-default min-w-150">Print</a>
					</section>
				</div>
			</div>
		  </div>
		</div>
	  </div>
</template>

<script>
export default {
	props:['ppayments'],
	data(){
		return {
			filter:{
				ao:'all',
				center:'all',
				product:'all'
			},
			aofficers:[],
		}
	},
	computed:{
		totalCash:function(){
			var amount = 0;
			this.ppayments.map(function(payment){
				if(payment.payment_type == 'cash'){
					amount += payment.amount_applied;
				}
			});
			return amount;
		},
		totalCheck:function(){
			var amount = 0;
			this.ppayments.map(function(payment){
				if(payment.payment_type == 'check'){
					amount += payment.amount_applied;
				}
			});
			return amount;
		},
		totalPos:function(){
			return this.totalCash + this.totalCheck;
		},
		setAo:function(){
			let aos = [];
			let aofficers = [];
			this.filteredPayments.map(function(data){
				if(data.loan_details.account_officer){
					let ao = data.loan_details.account_officer.ao_id;
					if(!aos.includes(ao)){
						aos.push(ao);
						aofficers.push(data.loan_details.account_officer);
					}
				}
			}.bind(this));
			return aofficers;
		},
		setCenter:function(){
			let centers = [];
			let ccenters = [];
			this.filteredPayments.map(function(data){
				if(data.loan_details.center){
					let center = data.loan_details.center.center_id;
					if(!ccenters.includes(center)){
						ccenters.push(center);
						centers.push(data.loan_details.center);
					}
				}
			}.bind(this));
			return centers;
		},
		setProduct:function(){
			let products = [];
			let pproducts = [];
			this.filteredPayments.map(function(data){
				if(data.loan_details.product){
					let product = data.loan_details.product.product_id;
					if(!pproducts.includes(product)){
						pproducts.push(product);
						products.push(data.loan_details.product);
					}
				}
			}.bind(this));
			return products;
		},
		filteredPayments:function(){
			var payments = [];
			if(this.filter.ao == 'all' && this.filter.center == 'all' && this.filter.product == 'all'){				
				return this.ppayments;
			}else{
				this.ppayments.map(function(data){
					if(this.filter.ao != 'all' && this.filter.center != 'all' && this.filter.product != 'all'){
						if(data.loan_details.account_officer.ao_id == this.filter.ao && data.loan_details.center.center_id == data.filter.center && data.loan_details.product.product_id == data.filter.product){
							payments.push(data);
						}
					}
					if(this.filter.ao != 'all' && this.filter.center != 'all' && this.filter.product == 'all'){
						if(data.loan_details.account_officer.ao_id == this.filter.ao && data.loan_details.center.center_id == data.filter.center){
							payments.push(data);
						}
					}
					if(this.filter.ao != 'all' && this.filter.center == 'all' && this.filter.product != 'all'){
						if(data.loan_details.account_officer.ao_id == this.filter.ao && data.loan_details.product.product_id == data.filter.product){
							payments.push(data);
						}
					}
					if(this.filter.ao != 'all' && this.filter.center == 'all' && this.filter.product == 'all'){
						if(data.loan_details.account_officer.ao_id == this.filter.ao){
							payments.push(data);
						}
					}
					
				}.bind(this));
			}
			return payments
		}
	},
	mounted(){
		this.setAo;
	}
}
</script>
