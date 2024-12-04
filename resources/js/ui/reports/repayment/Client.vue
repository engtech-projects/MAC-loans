<template>
	<div class="d-flex flex-column" style="flex:8;min-height:1600px;">
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px;">
			</div>
			<span class="font-lg" style="color:#ddd;">Please wait until the process is complete</span>
		</div>
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark" style="flex:2">Transaction</span>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">From: </span>
				<input v-model="filter.date_from" type="date" class="form-control">
			</div>
			<div class="d-flex flex-row align-items-center mr-64" style="flex:2">
				<span class="mr-10">To: </span>
				<input v-model="filter.date_to" type="date" class="form-control">
			</div>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">Type: </span>
				<select v-model="filter.type" name="" id="selectProductClient" class="form-control">
					<option value="all">All Records</option>
					<option value="center">By Center</option>
					<option value="product">By Product</option>
					<option value="account_officer">By Account Officer</option>
					<option value="payment_status">By Payment Status</option>
				</select>
			</div>
			<div class="d-flex flex-row align-items-center" style="flex:2">
				<span class="mr-10">Spec: </span>
				<select v-if="filter.type=='all'" name="" disabled id="selectProductClient" class="form-control">
				</select>
				<select v-if="filter.type=='product'" v-model="filter.spec" name="" id="selectProductClient" class="form-control">
					<option v-for="p in products.filter(pp=>pp.status=='active')" :key="p.product_id" :value="p.product_id">{{p.product_name}}</option>
				</select>
				<div v-if="filter.type=='center'" class="d-flex flex-column">
					<search-dropdown 
						v-if="filter.type=='center'" 
						:reset="resetCenter" 
						@centerReset="resetCenter=false" 
						@sdSelect="centerSelect" 
						:data="centers"
						:center-id="filter.spec"
						:height="'38px'"
						:fontSize="'16px'"
						:borderRadius="'5px'"
						id="center_id" 
						name="center"
					></search-dropdown>
					<input style="border:none!important;width:100%!important;height:0px!important;opacity:0!important;" type="text" v-model="filter.spec">
				</div>
				<select v-if="filter.type=='account_officer'" v-model="filter.spec" name="" id="selectProductClient" class="form-control">
					<option v-for="a in filteredAos" :key="a.ao_id" :value="a.ao_id">{{a.name}}</option>
				</select>
				<select v-if="filter.type=='payment_status'" v-model="filter.spec" id="selectPaymentStatus" class="form-control mr-24">
			        <option value="past_due" selected>Past Due</option>
			    </select>
			</div>
			<div v-if="filter.type=='payment_status'&&filter.spec=='past_due'" class="d-flex flex-row align-items-center" style="flex:2">
				<span class="mr-10">Product: </span>
			    <select v-model="filter.pdproduct" class="form-control">
					<option v-for="p in products.filter(pp=>pp.status=='active')" :key="p.product_id" :value="p.product_id">{{p.product_name}}</option>
				</select>
			</div>
		</div>
		<div class="sep mb-45"></div>
		<div id="printContent">
			

			<section class="" id="clientSection" style="font-weight: bolder; padding: 10px 10px;">
				<div class="d-flex flex-column mb-16">
					<div class="d-flex flex-row align-items-center">
						<div class="flex-1"></div>
						<span class="font-30 text-bold text-primary-dark">SUMMARY OF LOAN REPAYMENTS</span>
						<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
							<current-transactiondate :branch="branch.branch_id" :token="token" :reports="true" @update-transaction-date="setTransactionDate"></current-transactiondate>
							<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
						</div>
					</div>
					<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name + ' Branch (' + branch.branch_code + ')'}}</span>
					<div class="d-flex flex-row justify-content-center text-primary-dark">
						<span class="mr-5">From:</span><span class="mr-16">{{filter.date_from?dateToMDY2(new Date(filter.date_from)).split('-').join('/'):'---'}}</span>
						<span class="mr-5">To:</span><span>{{filter.date_to?dateToMDY2(new Date(filter.date_to)).split('-').join('/'):'---'}}</span>
					</div>
				</div>
				<section class="d-flex flex-column flex-1">
					<table class="table td-nb table-thin th-nbt">
						<thead>
							<th></th>
							<th>Borrower's Name</th>
							<th>Date Pay</th>
							<th>Due Date</th>
							<th>O.R#</th>
							<th>Amort. Prin.</th>
							<th>Principal</th>
							<th>Amort. Int.</th>
							<th>Int.</th>
							<th>PD Int.</th>
							<th>Over</th>
							<th>Tot. Payment</th>
							<th>VATable Int.</th>
							<th>VATable PDI.</th>
							<th>Total VAT</th>
							<th>Type</th>
						</thead>
						<tbody>
							<tr v-if="!reports.length"><td><i>No records found.</i></td></tr>
							<tr v-for="r,i in reports" :key="i">
								<td>{{ i+ 1 }}</td>
								<td>{{r.borrower}}</td>
								<td>{{r.payment_date}}</td>
								<td>{{r.due_date}}</td>
								<td>{{r.or}}</td>
								<td>{{formatToCurrency(r.amortization_principal)}}</td>
								<td>{{formatToCurrency(r.principal)}}</td>
								<td>{{formatToCurrency(r.amortization_interest)}}</td>
								<td>{{formatToCurrency(r.interest - r.rebates) }}</td>
								<td>{{formatToCurrency(r.pdi)}}</td>
								<td>{{formatToCurrency(r.overpayment)}}</td>
								<td>{{formatToCurrency(r.total)}}</td>
								<td>{{formatToCurrency(r.net_interest/(1.12))}}</td>
								<td>{{formatToCurrency(r.net_pdi /(1.12))}}</td>
								<td>{{formatToCurrency(r.vat)}}</td>
								<td>{{r.payment_type}}</td>
							</tr>
							
							<tr class="border-cell-gray-7">
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th>Amort. Principal</th>
								<th>Total Principal</th>
								<th>Amort. Int.</th>
								<th>Total Int</th>
								<th>PD Int.</th>
								<th>Over</th>
								<th>Tot. Payment</th>
								<th>VATable Int.</th>
								<th>VATable PDI.</th>
								<th>Total VAT</th>
								<th></th>
							</tr>
							<tr class="tr-pt-7 text-bold">
								<td v-for="t,p in total" :key="p">{{(t!==''&&t!=='TOTAL')?formatToCurrency(parseFloat(t)):t}}</td>
							</tr>
						</tbody>
					</table>

					<div class="d-flex flex-row bg-skyblue p-10 align-items-center mb-72">
						<div class="d-flex flex-column flex-1 mr-64">
							<div class="d-flex flex-row flex-1 mb-5">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL CASH PAYMENT</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(overall.cash)}}</span>
							</div>
							<div class="d-flex flex-row flex-1 mb-5">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL CHECK PAYMENT</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(overall.check)}}</span>
							</div>
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL MEMO PAYMENT</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(overall.memo)}}</span>
							</div>
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1 pl-24">DED BALANCE</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(overall.dedBalance)}}</span>
							</div>
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1 pl-24">OFFSET PF</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(overall.offsetPf)}}</span>
							</div>
							<!-- <div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1 pl-24">OVER PAYMENT</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(overall.overPayment)}}</span>
							</div> -->
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1 pl-24">DISCOUNT</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(overall.discount)}}</span>
							</div>
							<!-- <div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1 pl-24">CANCELLED</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(overall.cancelled)}}</span>
							</div> -->
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1 pl-24">BRANCH</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(overall.branch)}}</span>
							</div>
							<div class="d-flex flex-row flex-1 mb-5">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL POS</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(overall.pos)}}</span>
							</div>
						</div>
						<div class="d-flex flex-column flex-1">
							<div class="info-display">
								<span class="text-primary-dark">TOTAL PAYMENTS</span>
								<span class="text-primary-dark">{{formatToCurrency(overall.total)}}</span>
							</div>
						</div>
						<div class="flex-2"></div>
					</div>
				</section>
				
			</section>
			
		</div>
		<div class="d-flex flex-row justify-content-between mb-45">
			<div class="d-flex flex-row-reverse justify-content-start flex-1">
				<a @click="print()" href="#" class="btn btn-default min-w-150">Print</a>
				<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
			</div>
		</div>
	</div>

</template>

<script>
export default {
	props:['pbranch','token'],
	data(){
		return {
			loading:false,
			resetCenter:false,
			branch:{},
			filter:{
				date_from:null,
				date_to:null,
				category:'client',
				branch_id:'',
				spec:'',
				type:'all',
				pdproduct:''
			},
			reports:[],
			accountOfficers:[],
			products:[],
			centers:[]
		}
	},
	methods:{
		centerSelect:function(center){
			this.filter.spec = center.center_id;
		},
		async fetchReports(){
			this.loading = true;
			await axios.post(this.baseURL() + 'api/report/repayment', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loading = false;
				this.reports = response.data
			}.bind(this))
			.catch(function (error) {
				this.loading = false;
				console.log(error);
			}.bind(this));
		},
		setTransactionDate(transactionDate) {
			this.filter.date_from = transactionDate;
			this.filter.date_to = transactionDate;
		},
		async fetchProducts(){
			await axios.get(this.baseURL() + 'api/product/', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.products = response.data.data;
				this.fetchCenters();
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		async fetchCenters(){
			await axios.get(this.baseURL() + 'api/center', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.centers = response.data.data;
				this.fetchAo();
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		async fetchAo(){
			await axios.get(this.baseURL() + 'api/accountofficer/getActivesInBranch/' + this.branch.branch_id, {
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
		print:function(){
			var content = document.getElementById('printContent').innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			window.print();
		},
	},
	watch:{
		filter:{
			handler(val){
				const hasDateRange = val.date_from && val.date_to;
				const isTypeAll = val.type === 'all';
				const hasTypeAndSpec = val.type && val.spec !== '';
				if ((hasDateRange && isTypeAll) || hasTypeAndSpec) {
					this.fetchReports();
				}
			},
			deep:true
		},
	},
	computed:{
		filteredAos:function(){
			return this.accountOfficers.filter(ao=>ao.status=='active'&&ao.branch_id==this.branch.branch_id);
		},
		total:function(){
			var result = ['TOTAL','','','','',0,0,0,0,0,0,0,0,0,0,''];
			this.reports.forEach(r => {
				result[5] += r.amortization_principal;
				result[6] += r.principal;
				result[7] += r.amortization_interest;
				result[8] += r.interest-r.rebates;
				result[9] += r.pdi;
				result[10] += r.overpayment;
				result[11] += r.total;
				result[12] += (r.interest-r.rebates) / (1.12);
				result[13] += r.pdi / (1.12);
				result[14] += r.vat;
			});
			return result;
		},
		overall:function(){
			var result = {
				cash:0,
				check:0,
				pos:0,
				memo:0,
				dedBalance:0,
				offsetPf:0,
				branch:0,
				discount:0,
				cancelled:0,
				overPayment:0,
				total:0
			}
			this.reports.forEach(r => {
				if(r.payment_type=='Cash Payment'){
					result.cash += r.total;
				}else if(r.payment_type=='Check Payment'){
					result.check += r.total;
				}else if(r.payment_type=='Memo'){
					result.memo += r.total;
					if(r.memo_type == 'deduct to balance'){
						result.dedBalance += r.total
					}else if(r.memo_type == 'Rebates and Discount'){
						// result.discount += r.total
					}else if(r.memo_type == 'Offset PF'){
						result.offsetPf += r.total
					}else if(r.memo_type == 'Interbranch'){
						result.branch += r.total
					}
				}else{
					result.pos += r.total;
				}
				result.overPayment += r.overpayment;
				result.discount += r.rebates;
				result.total += r.total;
			});
			return result;
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
		this.filter.branch_id = this.branch.branch_id;
		this.fetchProducts();
	}
}
</script>