<template>
	<div class="modal" id="overrideDetailsModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-xl" style="min-width:90%" role="document">
		  <div class="modal-content">
			<div class="modal-body" id="PrintContent">
				<div class="d-flex flex-row justify-content-between align-items-center light-bb pb-16 no-print">
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
								<option v-for="aao in filteredAos" :key="aao.ao_id" :value="aao.ao_id">{{aao.name}}</option>
							</select>
						</div>
						<div class="d-flex flex-row align-items-center mr-24">
							<span class="mr-10 flex-1">Center : </span>
							<select v-model="filter.center" class="form-control min-w-200 flex-1" name="" id="">
								<option value="all">All</option>
								<option v-for="cc in filteredCenters" :key="cc.center_id" :value="cc.center_id">{{cc.center}}</option>
							</select>
						</div>
						<div class="d-flex flex-row align-items-center">
							<span class="mr-10 flex-1">Product Name : </span>
							<select v-model="filter.product" class="form-control min-w-200 flex-1" name="" id="">
								<option value="all">All</option>
								<option v-for="pp in filteredProducts" :key="pp.product_id" :value="pp.product_id">{{pp.product_name}}</option>
							</select>
						</div>
					</div>
				</div>
				<table class="table table-stripped light-bb no-print">
					<thead>
						<th>Account #</th>
						<th>Account Name</th>
						<th>O.R #</th>
						<th>Total Payment</th>
						<th>Type</th>
						<th>Principal</th>
						<th>Interest</th>
						<th>Penalty</th>
						<th>PDI</th>
						<th>Overpayment</th>
						<th>Rebates</th>
						<th>L.Disc</th>
						<th>L.Waive</th>
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
							<td>{{formatToCurrency(p.penalty_approval_no ? 0 : p.penalty)}}</td>
							<td>{{formatToCurrency(p.pdi_approval_no ? 0 : p.pdi)}}</td>
							<td>{{formatToCurrency(p.advance_interest + p.advance_principal)}}</td>
							<td>{{formatToCurrency(p.rebates)}}</td>
							<td>{{formatToCurrency(p.penalty_approval_no ? p.penalty : 0)}}</td>
							<td>{{formatToCurrency(p.pdi_approval_no ? p.pdi : 0)}}</td>
						</tr>
						<tr class="text-bold">
							<td>TOTAL</td>
							<td></td>
							<td></td>
							<td>{{formatToCurrency(totalPayment)}}</td>
							<td></td>
							<td>{{formatToCurrency(totalPrincipal)}}</td>
							<td>{{formatToCurrency(totalInterest)}}</td>
							<td>{{formatToCurrency(totalPenalty)}}</td>
							<td>{{formatToCurrency(totalPdi)}}</td>
							<td>{{formatToCurrency(overPayment)}}</td>
							<td>{{formatToCurrency(totalRebates)}}</td>
							<td>{{formatToCurrency(totalPenaltyWaive)}}</td>
							<td>{{formatToCurrency(totalPdiWaive)}}</td>
						</tr>
					</tbody>
				</table>
				<div class="to-print">
					<img :src="baseURL()+'/img/company_header.png'" style="width:100%" class="mb-45" alt="Company Header">
					<table class="table table-stripped  light-bb table-thin text-xs">
						<thead>
							<th>Account #</th>
							<th>Account Name</th>
							<th>O.R #</th>
							<th>Total Payment</th>
							<th>Type</th>
							<th>Principal</th>
							<th>Interest</th>
							<th>Penalty</th>
							<th>PDI</th>
							<th>Overpayment</th>
							<th>Rebates</th>
							<th>L.Disc</th>
							<th>L.Waive</th>
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
								<td>{{formatToCurrency(p.penalty_approval_no ? 0 : p.penalty)}}</td>
								<td>{{formatToCurrency(p.pdi_approval_no ? 0 : p.pdi)}}</td>
								<td>{{formatToCurrency(p.advance_interest + p.advance_principal)}}</td>
								<td>{{formatToCurrency(p.rebates)}}</td>
								<td>{{formatToCurrency(p.penalty_approval_no ? p.penalty : 0)}}</td>
								<td>{{formatToCurrency(p.pdi_approval_no ? p.pdi : 0)}}</td>
							</tr>
							<tr class="text-bold">
								<td>TOTAL</td>
								<td></td>
								<td></td>
								<td>{{formatToCurrency(totalPayment)}}</td>
								<td></td>
								<td>{{formatToCurrency(totalPrincipal)}}</td>
								<td>{{formatToCurrency(totalInterest)}}</td>
								<td>{{formatToCurrency(totalPenalty)}}</td>
								<td>{{formatToCurrency(totalPdi)}}</td>
								<td>{{formatToCurrency(overPayment)}}</td>
								<td>{{formatToCurrency(totalRebates)}}</td>
								<td>{{formatToCurrency(totalPenaltyWaive)}}</td>
								<td>{{formatToCurrency(totalPdiWaive)}}</td>
							</tr>
						</tbody>
					</table>
				</div>
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
									<span class="">Total Check</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalCheck)}}</span>
							</div>
							<div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="">Total POS</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalPOS)}}</span>
							</div>
							<div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="">Total Memo Payment</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalMemo)}}</span>
							</div>
							<div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="pl-24">Interbranch</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalInterbranch)}}</span>
							</div>
							<div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="pl-24">Deduct to Balance</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalDeductToBalance)}}</span>
							</div>
							<div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="pl-24">Offset P.F</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalOffset)}}</span>
							</div>
							<div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="pl-24">Rebates & Disc.</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalRebatesDiscount)}}</span>
							</div>
							<!-- <div class="d-flex flex-row">
								<div class="d-flex flex-row flex-2 justify-content-between pr-24">
									<span class="">TOTAL POS</span>
									<span>:</span>
								</div>
								<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalPos)}}</span>
							</div> -->
					   </div>
					</section>
					<section class="flex-2 d-flex align-items-start">
						<div class="d-flex flex-column button-text mr-45">
						   <span>TOTAL PAYMENT</span>
						   <div class="d-flex flex-row">
							   <span>P</span>
							   <span>{{formatToCurrency(totalPaymentSummary)}}</span>
						   </div>
					   </div>
					   <span class="flex-1 bb-primary-dark pb-24 mr-24">Prepared by:</span>
					   <span class="flex-1 bb-primary-dark pb-24 mr-24">Certified Corrected by:</span>
					   <span class="flex-1 bb-primary-dark pb-24">Approved by:</span>
					</section>
					<section class="d-flex flex-1 justify-content-end">
						<img :src="baseURL() + 'img/logo-footer.png'" class="w-100 page-footer to-print" alt="">
						<a href="#" @click.prevent="printContent('PrintContent')" data-dismiss="modal" class="btn btn-default min-w-150 no-print">Print</a>
					</section>
				</div>
			</div>
		  </div>
		</div>
	  </div>
</template>

<script>
export default {
	props:['ppayments', 'pbranch'],
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
	methods:{
		async pendingPayments(){
			await axios.get(this.baseURL() + 'transaction/payments/pending', {
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
		hasCenter:function(loan){
			return loan.center?loan.center.center_id:false;
		},
		printContent:function(printcontent){
			var content = document.getElementById(printcontent).innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			window.print();
		}
	},
	computed:{
		totalCash:function(){
			var amount = 0;
			this.ppayments.map(function(payment){
				if(payment.payment_type == 'Cash Payment'){
					amount += payment.amount_applied;
				}
			});
			return amount;
		},
		totalCheck:function(){
			var amount = 0;
			this.ppayments.map(function(payment){
				if(payment.payment_type == 'Check Payment'){
					amount += payment.amount_applied;
				}
			});
			return amount;
		},
		totalMemo:function(){
			var amount = 0;
			this.ppayments.map(function(payment){
				if(payment.payment_type == 'Memo'){
					amount += payment.amount_applied;
				}
			});
			return amount;
		},
		totalPOS:function(){
			var amount = 0;
			this.ppayments.map(function(payment){
				if(payment.payment_type == 'POS'){
					amount += payment.amount_applied;
				}
			});
			return amount;
		},
		totalDeductToBalance:function(){
			var amount = 0;
			this.ppayments.map(function(payment){
				if(payment.memo_type == 'deduct to balance'){
					amount += payment.amount_applied;
				}
			});
			return amount;
		},
		totalInterbranch:function(){
			var amount = 0;
			this.ppayments.map(function(payment){
				if(payment.memo_type == 'Interbranch'){
					amount += payment.amount_applied;
				}
			});
			return amount;
		},
		totalOffset:function(){
			var amount = 0;
			this.ppayments.map(function(payment){
				if(payment.memo_type == 'Offset PF'){
					amount += payment.amount_applied;
				}
			});
			return amount;
		},
		totalRebatesDiscount:function(){
			var amount = 0;
			this.ppayments.map(function(payment){
				if(payment.memo_type == 'Rebates and Discount'){
					amount += payment.amount_applied;
				}
			});
			return amount;
		},
		totalPos:function(){
			return this.totalCash + this.totalCheck + this.totalMemo;
		},
		totalPayment:function(){
			var amount = 0;
			this.filteredPayments.map(function(payment){
				amount += payment.amount_applied;
			});
			return amount;
		},
		totalPaymentSummary:function(){
			return this.totalCash + this.totalCheck + this.totalPOS + this.totalMemo - this.totalRebates;
		},
		totalPrincipal:function(){
			var amount = 0;
			this.filteredPayments.map(function(payment){
				amount += payment.principal;
			});
			return amount;
		},
		totalInterest:function(){
			var amount = 0;
			this.filteredPayments.map(function(payment){
				amount += payment.interest;
			});
			return amount;
		},
		totalPenalty:function(){
			var amount = 0;
			this.filteredPayments.map(function(payment){
				if(!payment.penalty_approval_no){
					amount += payment.penalty;
				}
			});
			return amount;
		},
		totalPdi:function(){
			var amount = 0;
			this.filteredPayments.map(function(payment){
				if(!payment.pdi_approval_no){
					amount += payment.pdi;
				}
			});
			return amount;
		},
		totalPenaltyWaive:function(){
			var amount = 0;
			this.filteredPayments.map(function(payment){
				if(payment.penalty_approval_no){
					amount += payment.penalty;
				}
			});
			return amount;
		},
		totalPdiWaive:function(){
			var amount = 0;
			this.filteredPayments.map(function(payment){
				if(payment.pdi_approval_no){
					amount += payment.pdi;
				}
			});
			return amount;
		},
		totalRebates:function(){
			var amount = 0;
			this.filteredPayments.map(function(payment){
				amount += payment.rebates;
			});
			return amount;
		},
		overPayment:function(){
			var amount = 0;
			this.filteredPayments.map(function(payment){
				amount += (payment.advance_principal + payment.advance_interest);
			});
			return amount;
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
						if(data.loan_details.account_officer.ao_id == this.filter.ao && this.hasCenter(data.loan_details) == this.filter.center && data.loan_details.product.product_id == this.filter.product){
							payments.push(data);
						}
					}
					if(this.filter.ao != 'all' && this.filter.center != 'all' && this.filter.product == 'all'){
						if(data.loan_details.account_officer.ao_id == this.filter.ao && this.hasCenter(data.loan_details) == this.filter.center){
							payments.push(data);
						}
					}
					if(this.filter.ao != 'all' && this.filter.center == 'all' && this.filter.product != 'all'){
						if(data.loan_details.account_officer.ao_id == this.filter.ao && data.loan_details.product.product_id == this.filter.product){
							payments.push(data);
						}
					}
					if(this.filter.ao == 'all' && this.filter.center != 'all' && this.filter.product != 'all'){
						if(this.hasCenter(data.loan_details) == this.filter.center && data.loan_details.product.product_id == this.filter.product){
							payments.push(data);
						}
					}
					if(this.filter.ao != 'all' && this.filter.center == 'all' && this.filter.product == 'all'){
						if(data.loan_details.account_officer.ao_id == this.filter.ao){
							payments.push(data);
						}
					}
					if(this.filter.ao == 'all' && this.filter.center == 'all' && this.filter.product != 'all'){
						if(data.loan_details.product.product_id == this.filter.product){
							payments.push(data);
						}
					}
					if(this.filter.ao == 'all' && this.filter.center != 'all' && this.filter.product == 'all'){
						if(this.hasCenter(data.loan_details) == this.filter.center){
							payments.push(data);
						}
					}
					
				}.bind(this));
			}
			return payments
		},
		filteredProducts:function(){
			var products = [];
			this.ppayments.map(function(ov){
				if(ov.loan_details.product){
					var count = 0;
					products.map(function(pp){
						if(ov.loan_details.product.product_id == pp.product_id)
						count++;
					}.bind(this));
					if(count == 0){
						products.push(ov.loan_details.product);
					}
				}
			}.bind(this));
			if(!products.length){
				this.filter.product_id = 'all';
			}
			return products;
		},
		filteredAos:function(){
			var aofficers = [];
			this.ppayments.map(function(ov){
				if(ov.loan_details.account_officer){
					var count = 0;
					aofficers.map(function(pp){
						if(ov.loan_details.account_officer.ao_id == pp.ao_id)
						count++;
					}.bind(this));
					if(count == 0){
						aofficers.push(ov.loan_details.account_officer);
					}
				}
			}.bind(this));
			if(!aofficers.length){
				this.filter.ao_id = 'all';
			}
			return aofficers;
		},
		filteredCenters:function(){
			var centers = [];
			this.ppayments.map(function(ov){
				if(ov.loan_details.center){
					var count = 0;
					centers.map(function(cc){
						if(ov.loan_details.center.center_id == cc.center_id)
						count++;
					}.bind(this));
					if(count == 0){
						centers.push(ov.loan_details.center);
					}
				}
			}.bind(this));
			if(!centers.length){
				this.filter.center_id = 'all';
			}
			return centers;
		},
	},
	mounted(){
		this.setAo;
	}
}
</script>
