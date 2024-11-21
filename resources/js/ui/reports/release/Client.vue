<template>
	<div class="d-flex flex-column" style="flex:8;min-height:1500px">
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark" style="flex:3">Transaction</span>
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
					<option value="new">New Accounts</option>
					<option value="center">By Center</option>
					<option value="product">By Product</option>
					<option value="account_officer">By Account Officer</option>
				</select>
			</div>
			<div class="d-flex flex-row align-items-center" style="flex:2">
				<span class="mr-10">Spec: </span>
				<select v-if="filter.type=='all'||filter.type=='new'" disabled v-model="filter.spec" name="" id="selectProductClient" class="form-control">
				</select>
				<select v-if="filter.type=='product'" v-model="filter.spec" name="" id="selectProductClient" class="form-control">
					<option v-for="p in filteredProducts" :key="p.product_id" :value="p.product_id">{{p.product_name}}</option>
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
					<option v-for="a in accountOfficers.filter(aa=>aa.status=='active')" :key="a.ao_id" :value="a.ao_id">{{a.name}}</option>
				</select>
			</div>
		</div>
		<div class="sep mb-45"></div>
		<div id="printContent">
			<!-- <img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt=""> -->
			
			<section class="" id="clientSection" style="font-weight: bolder; padding: 10px 10px;">
				<div class="d-flex flex-column mb-16">
					<div class="d-flex flex-row align-items-center">
						<div class="flex-1"></div>
						<span class="font-30 text-bold text-primary-dark">SUMMARY OF LOAN RELEASE</span>
						<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
							<current-transactiondate :branch="branch.branch_id" :token="token" :reports="true" @update-transaction-date="setTransactionDate"></current-transactiondate>
							<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
						</div>
					</div>
					<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name + ' Branch (' + branch.branch_code + ')'}}</span>
					<div class="d-flex flex-row justify-content-center text-primary-dark">
						<span class="mr-5">From:</span><span class="mr-16">{{filter.date_from?filter.date_from:'---'}}</span>
						<span class="mr-5">To:</span><span>{{filter.date_to?filter.date_to:'---'}}</span>
					</div>
				</div>
				<section class="d-flex flex-column mb-16">
					<span class="text-bold bg-yellow-light" style="padding:2px 5px;">RELEASES SUMMARY</span>
					<table class="table td-nb table-thin">
						<thead>
							<th>Acct. #</th>
							<th>Acct. Name</th>
							<th>Date Loan</th>
							<th>Term</th>
							<th>Amount Loan</th>
							<th>Fil. Fee</th>
							<th>D.S</th>
							<th>Ins.</th>
							<th>Notl</th>
							<th>Affidavit</th>
							<th>Ded. Bal</th>
							<th>Prep</th>
							<th>Net Prcds</th>
							<th>Type</th>
						</thead>
						<tbody>
							<tr v-for="r,i in release.sort((a, b) => a.borrower.localeCompare(b.borrower))" :key="i">
								<td>{{r.account_num}}</td>
								<td>{{r.borrower}}</td>
								<td>{{r.date_loan}}</td>
								<td>{{r.term}}</td>
								<td>{{formatToCurrency(r.amount_loan)}}</td>
								<td>{{formatToCurrency(r.filing_fee)}}</td>
								<td>{{formatToCurrency(r.document_stamp)}}</td>
								<td>{{formatToCurrency(r.insurance)}}</td>
								<td>{{formatToCurrency(r.notarial_fee)}}</td>
								<td>{{formatToCurrency(r.affidavit_fee)}}</td>
								<td>{{formatToCurrency(r.memo)}}</td>
								<td>{{formatToCurrency(r.prepaid_interest)}}</td>
								<td>{{formatToCurrency(r.net_proceeds)}}</td>
								<td>{{r.type.toUpperCase()}}</td>
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
							</tr>
							<tr class="tr-pt-7 text-bold">
								<td>TOTAL</td>
								<td></td>
								<td></td>
								<td></td>
								<td v-for="t,i in total" :key="i">{{formatToCurrency(t)}}</td>
								<td></td>
							</tr>
						</tbody>
					</table>
					<div class="d-flex flex-row bg-yellow-pale p-5 align-items-center">
						<div class="d-flex flex-column flex-1 mr-64">
							<div class="d-flex flex-row flex-1 mb-5">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL CASH RELEASE</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(totalCash)}}</span>
							</div>
							<div class="d-flex flex-row flex-1 mb-5">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL CHECK RELEASE</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(totalCheck)}}</span>
							</div>
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL MEMO RELEASE</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(totalMemo)}}</span>
							</div>
						</div>
						<div class="d-flex flex-column flex-1">
							<div class="info-display">
								<span class="text-primary-dark">TOTAL RELEASES</span>
								<span class="text-primary-dark">{{formatToCurrency(totalCash + totalCheck)}}</span>
							</div>
						</div>
						<div class="flex-2"></div>
					</div>
				</section>
				
			</section>


			<section class="d-flex flex-row mb-72" style="margin-top:auto">
				<span class="flex-2 pb-24 text-bold darker-bb mr-64">Prepared By:</span>
				<span class="flex-2 pb-24 text-bold darker-bb mr-64">Certified Corrected By:</span>
				<span class="flex-2 pb-24 text-bold darker-bb mr-64">Approved By:</span>
				<span class="flex-1"></span>
			</section>
			<div class="d-flex mb-64" style="margin-top:auto">
				<!-- <img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt=""> -->
			</div>
		</div>
		
		<div class="d-flex flex-row justify-content-between mb-45">
			<a href="#" data-toggle="modal" data-target="#dstModal" class="btn btn-purple min-w-150">Generate DST</a>
			<div class="d-flex flex-row-reverse">
				<a @click="print" href="#" class="btn btn-default min-w-150">Print</a>
				<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
			</div>
		</div>

		<div class="modal" id="dstModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" style="min-width:60%;" role="document">
		  <div class="modal-content">
			<div class="modal-body p-24">
				<div class="d-flex flex-column">
				<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">


				<section class="" id="clientSection">
					<div class="d-flex flex-column mb-16">
						<div class="d-flex flex-row align-items-center">
							<div class="flex-1"></div>
							<span class="font-30 text-bold text-primary-dark">SUMMARY OF ALL NEW RELEASES BY DST</span>
							<div class="flex-1" style="padding-left:24px">
								<span class="text-primary-dark mr-10">Tuesday 12/21/2021</span>
								<span class="text-primary-dark">Time: 11:36 AM</span>
							</div>
						</div>
						<span class="text-center text-primary-dark text-bold font-md mb-5">Butuan Branch (001)</span>
						<div class="d-flex flex-row justify-content-center text-primary-dark">
							<span class="mr-5">From:</span><span class="mr-16">{{filter.date_from?filter.date_from:'---'}}</span>
							<span class="mr-5">To:</span><span>{{filter.date_to?filter.date_to:'---'}}</span>
						</div>
					</div>
					<section class="d-flex flex-column mb-64">
						<span class="text-bold bg-yellow-light" style="padding:2px 5px;">RELEASES SUMMARY</span>
						<table class="table td-nb table-thin">
							<thead>
								<th>Term</th>
								<th>Amount Loan</th>
								<th>Proportion</th>
								<th>Tax Rate</th>
								<th>DST Total</th>
							
							</thead>
							<tbody>
								<tr>
									<td>30</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00%</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>60</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00%</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>90</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00%</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>120</td>
									<td>0.00</td>
									<td>0.00</td>
									<td>0.00%</td>
									<td>0.00</td>
								</tr>
								
								<tr class="border-cell-gray-7">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr class="tr-pt-7 text-bold">
									<td>TOTAL</td>
									<td>22,000.00</td>
									<td>10,000.00</td>
									<td>0.00%</td>
									<td>81.37</td>
								</tr>
							</tbody>
						</table>
						
					</section>
					
				</section>


				<section class="d-flex flex-row mb-72">
					<span class="flex-2 pb-24 text-bold darker-bb mr-64">Prepared By:</span>
					<span class="flex-2 pb-24 text-bold darker-bb mr-64">Certified Corrected By:</span>
					<span class="flex-2 pb-24 text-bold darker-bb mr-64">Approved By:</span>
					<span class="flex-1"></span>
				</section>
				<div class="d-flex flex-row justify-content-between mb-45">
					<span></span>
					<div class="d-flex flex-row-reverse">
						<a href="#" class="btn btn-default min-w-150">Print</a>
						<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
					</div>
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
	props:['token', 'pbranch'],
	data(){
		return {
			resetCenter:false,
			branch:{},
			filter:{
				date_from:null,
				date_to:null,
				category:'client',
				branch_id:'',
				spec:'',
				type:'all'
			},
			reports:[],
			products:[],
			centers:[],
			accountOfficers:[],
			dst:[]
		}
	},
	methods:{
		centerSelect:function(center){
			this.filter.spec = center.center_id;
		},
		async fetchReports(){
			await axios.post(this.baseURL() + 'api/report/release', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.reports = response.data.data
				// console.log(response.data);
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		setTransactionDate(transactionDate) {
			this.filter.date_from = transactionDate;
			this.filter.date_to = transactionDate;
		},
		async fetchDst(){
			this.filter.category = 'dst';
			await axios.post(this.baseURL() + 'api/report/release', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.dst = response.data.data
				// console.log(response.data);
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
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
		'filter.type':function(val){
			this.filter.spec = 'all';
			// if(val=='account_officer'){
			// 	if(this.filteredAos.length == 1){
			// 		this.filter.spec = this.filteredAos[0].ao_id;
			// 	}
			// }
		},
		filter:{
			handler(val){
				if(val.date_from && val.date_to){
					this.fetchReports();
				}
			},
			deep:true
		},
	},
	computed:{
		release:function(){
			if(this.reports.release){
				return this.filter.type=='new'?this.reports.release.filter(r=>r.cycle_no==1):this.reports.release;
			}
			return [];
		},
		filteredProducts:function(){
			return this.products.filter(p=>p.status=='active');
		},
		total:function(){
			var row = [0,0,0,0,0,0,0,0,0];
			this.release.forEach(r => {
				row[0] += r.amount_loan;
				row[1] += r.filing_fee;
				row[2] += r.document_stamp;
				row[3] += r.insurance;
				row[4] += r.notarial_fee;
				row[5] += r.affidavit_fee;
				row[6] += r.memo;
				row[7] += r.prepaid_interest;
				row[8] += r.net_proceeds;
			});
			return row;
		},
		totalCash:function(){
			var amount = 0;
			this.release.forEach(r=>{
				if(r.type == 'Cash'){
					amount+=r.net_proceeds;
				}
			})
			return amount;
		},
		totalCheck:function(){
			var amount = 0;
			this.release.forEach(r=>{
				if(r.type == 'Check'){
					amount+=r.net_proceeds;
				}
			})
			return amount;
		},
		totalMemo:function(){
			var amount = 0;
			this.release.forEach(r=>{
				amount+=r.memo;
			})
			return amount;
		},
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
		this.filter.branch_id = this.branch.branch_id;
		this.fetchProducts();
		
	}
}
</script>