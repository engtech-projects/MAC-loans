<template>
	<div class="d-flex flex-column" style="flex:8;">
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
					<div class=" font-md mb-16">
						<!-- <span class="font-lg text-primary-dark flex-1 mr-45"></span> -->
						<!-- <div class="d-flex flex-row align-items-center mr-24" style="flex:1">
							<span class="mr-10">As of: </span>
							<input type="date" class="form-control flex-1">
						</div> -->
						<form action="" class="d-flex flex-row" @submit.prevent="generate()">
							<div class="d-flex flex-row align-items-center mr-24 justify-content-start flex-1">
								<span class="mr-10 text-block">Acc. Officer: </span>
								<select v-model="filter.account_officer" name="" id="selectProductClient" class="form-control flex-1" required>
									<option value="all">All Account Officers</option>
									<option v-for="ao in aos.filter(a=>a.status=='active'&&a.branch_id==branch.branch_id)" :key="ao.id" :value="ao.ao_id">{{ao.name}}</option>
								</select>
							</div>
							<div class="d-flex flex-row align-items-center mr-24 justify-content-start flex-1">
								<span class="mr-10 text-block">Product: </span>
								<select v-model="filter.product" name="" id="selectProductClient" class="form-control flex-1" required>
									<option value="all">All Products</option>
									<option v-for="product in products.filter(p=>p.status=='active')" :key="product.id" :value="product.product_id">{{product.product_name}}</option>
								</select>
							</div>
							<div class="d-flex flex-row align-items-center mr-24 justify-content-start flex-1">
								<span class="mr-10 text-block">Center: </span>
								<select v-model="filter.center" name="" id="selectProductClient" class="form-control flex-1" required>
									<option value="all">All Centers</option>
									<option v-for="center in centers.filter(c=>c.status=='active')" :key="center.id" :value="center.center_id">{{center.center}}</option>
								</select>
							</div>
							<div class="d-flex flex-row align-items-center mr-24 justify-content-start flex-1">
								<button class="btn btn-primary">Generate</button>
							</div>
						</form>
					</div>
					<div class="sep mb-45"></div>
					<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">


					<section class="mb-72" id="performanceReport">
						<div class="d-flex flex-column mb-24">
							<div class="d-flex flex-row align-items-center">
								<div class="flex-1 d-flex flex-column">

								</div>
								<span class="font-30 text-bold text-primary-dark text-center">Loan Listing</span>
								<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
									<current-transactiondate :branch="branch.branch_id" :token="token" :reports="true"></current-transactiondate>
									<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
								</div>
							</div>
							<span class="text-center text-primary-dark text-bold">As of {{dateToMDY2(new Date()).split('-').join('/')}}</span>
							<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name}} Branch ({{branch.branch_code}})</span>
						</div>
						<section class="d-flex flex-column mb-16 p-10 light-border">
							<section v-for="fr,i in filteredReports" :key="i">
								<div class="d-flex bg-yellow-verylight mb-5">
									<div class="d-flex flex-column text-primary-dark p-7 mr-24">
										<span class="font-md text-bold">Account Officer</span>
										<span class="font-sm">{{fr.ao}}</span>
									</div>
									<div class="d-flex flex-column text-primary-dark p-7 mr-24">
										<span class="font-md text-bold">Product</span>
										<span class="font-sm">{{fr.product}}</span>
									</div>
									<div class="d-flex flex-column text-primary-dark p-7 flex-1">
										<span class="font-md text-bold">Center Name</span>
										<span class="font-sm">{{fr.center}}</span>
									</div>
								</div>
								<div class="bb-dark-8"></div>
								<table class="table table-stripped mb-24">
									<thead>
										<th>Borrower's Name</th>
                                        <th>Account Number</th>
										<th>Date Loan</th>
										<th>Maturity</th>
										<th>Amnt. Loan</th>
										<th>Principal Bal.</th>
										<th>Interest Bal.</th>
										<th>Amort.</th>
                                        <th>Bitay Principal</th>
                                        <th>Bitay Interest</th>
										<th>Amnt. Due</th>
										<th># Days</th>
										<th>STATUS</th>
									</thead>
									<tbody>
										<tr v-for="rws,j in fr.rows" :key="j">
											<td v-for="rw,k in rws" :key="k">{{rw}}</td>
										</tr>
										<tr class="bg-skyblue text-bold">
											<td v-for="tc,l in fr.centerTotal" :key="l">{{tc===""||tc==="CENTER SUB-TOTAL"?tc:formatToCurrency(tc)}}</td>
										</tr>
										<tr v-if="fr.productTotal" class="bg-green-mint text-bold">
											<td v-for="tp,m in fr.productTotal" :key="m">{{tp===""||tp==="PRODUCT SUB-TOTAL"?tp:formatToCurrency(tp)}}</td>
										</tr>
										<tr v-if="fr.aoTotal" class="bg-purple-light text-bold">
											<td v-for="ta,n in fr.aoTotal" :key="n">{{ta===""||ta==="OFFICER SUB-TOTAL"?ta:formatToCurrency(ta)}}</td>
										</tr>
										<tr v-if="fr.total" class="bg-primary-dark text-white text-bold">
											<td v-for="tt,o in fr.total" :key="o">{{tt===""||tt==="TOTAL"?tt:formatToCurrency(tt)}}</td>
										</tr>
									</tbody>
								</table>
							</section>
						</section>
					</section>

					<section class="d-flex flex-row mb-72">
						<span class="flex-2 pb-24 text-bold darker-bb mr-64">Prepared By:</span>
						<span class="flex-2 pb-24 text-bold darker-bb mr-64">Certified Corrected By:</span>
						<span class="flex-2 pb-24 text-bold darker-bb mr-64">Approved By:</span>
						<span class="flex-1"></span>
					</section>

					<div class="d-flex flex-row justify-content-end mb-45">
						<div class="d-flex flex-row-reverse">
							<a href="#" class="btn btn-default min-w-150">Print</a>
							<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
						</div>
					</div>
				</div>

</template>

<script>
export default {
	props:['pbranch', 'token'],
	data(){
		return {
			loading:false,
			filter:{
				type:'loan_listing',
				branch_id:'',
				account_officer:'all',
				product:'all',
				center:'all',
			},
			branch:{},
			reports:[],
			products:[],
			centers:[],
			aos:[]
		}
	},
	methods:{
		generate:function(){
			if(this.filter.account_officer && this.filter.product && this.filter.center && this.filter.branch_id && this.filter.type){
				this.fetchReport();
			}
		},
		async fetchReport(){
			this.loading = true;
			await axios.post(this.baseURL() + 'api/report/branch', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loading = false;
				this.reports = response.data.data
				console.log(this.reports);
			}.bind(this))
			.catch(function (error) {
				this.loading = false;
				console.log(error);
			}.bind(this));
		},
		async fetchProducts(){
			axios.get(this.baseURL() + 'api/product', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.products = response.data.data;
				this.fetchAo();
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		async fetchAo(){
			await axios.get(this.baseURL() + 'api/accountofficer/', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.aos = response.data.data;
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
	computed:{
		filteredReports:function(){
			var tables = [];
			var total = ['TOTAL','','',0,0,0,0,0,'',''];
			this.reports.forEach(ao=>{
				var aoTotal = ['OFFICER SUB-TOTAL','','',0,0,0,0,0,'',''];
				for(var p in ao.products){
					var product = ao.products[p];
					var productTotal = ['PRODUCT SUB-TOTAL','','',0,0,0,0,0,'',''];
					for(var c in product.centers){
						var center = product.centers[c];
						var centerTotal = ['CENTER SUB-TOTAL','','',0,0,0,0,0,'',''];
						if(center.accounts){
							var table = {
								ao:'0' + ao.ao_id + ' - ' + ao.name,
								product:product.product_code + ' - ' + product.product_name,
								center:center.center,
								rows:[],
								centerTotal:null,
								productTotal:null,
								aoTotal:null,
								total:null,
							}
							for(var ac in center.accounts){
								var account = center.accounts[ac];
								var row = [];
								row.push(account.borrower_name);
                                row.push(account.account_num);
								row.push(account.date_loan);
								row.push(account.maturity);

								row.push(this.formatToCurrency(account.amount_loan));
								centerTotal[3] += account.amount_loan;
								row.push(this.formatToCurrency(account.principal_balance));
								centerTotal[4] += account.principal_balance;
								row.push(this.formatToCurrency(account.interest_balance));
								centerTotal[5] += account.interest_balance;
								row.push(this.formatToCurrency(account.amortization));
								centerTotal[6] += account.amortization;
                                row.push(account.distribution.short_principal + account.distribution.principal)
                                row.push(account.distribution.short_interest + account.distribution.interest)
								row.push(this.formatToCurrency(account.amount_due));
								centerTotal[7] += account.amount_due;
								row.push('');
								row.push(account.loan_status=='Ongoing'?account.status:account.loan_status);
								table.rows.push(row);
							}
							productTotal[3] += centerTotal[3];
							productTotal[4] += centerTotal[4];
							productTotal[5] += centerTotal[5];
							productTotal[6] += centerTotal[6];
							productTotal[7] += centerTotal[7];
							table.centerTotal = centerTotal;
							tables.push(table);
						}
					}
					aoTotal[3] += productTotal[3];
					aoTotal[4] += productTotal[4];
					aoTotal[5] += productTotal[5];
					aoTotal[6] += productTotal[6];
					aoTotal[7] += productTotal[7];
					if(tables.length){
						tables[tables.length-1].productTotal = productTotal;
					}
				}
				total[3] += aoTotal[3];
				total[4] += aoTotal[4];
				total[5] += aoTotal[5];
				total[6] += aoTotal[6];
				total[7] += aoTotal[7];
				if(tables.length){
					tables[tables.length-1].aoTotal = aoTotal;
				}
			})
			if(tables.length){
				tables[tables.length-1].total = total;
			}
			return tables;
		}
	},
	watch:{
		
	},
	mounted(){
		this.filter.branch_id = JSON.parse(this.pbranch).branch_id;
		this.branch = JSON.parse(this.pbranch);
		this.fetchProducts();
	}
}
</script>
