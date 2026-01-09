<template>
   <div class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-row font-md mb-16">
			<span class="flex-2"></span>
			<!-- <div class="d-flex flex-row align-items-center mr-24" style="flex:1">
				<span class="mr-10">As of: </span>
				<input v-model="filter.as_of" type="date" class="form-control flex-1">
			</div> -->
			<div class="d-flex flex-row align-items-center mr-24" style="flex:1">
				<span class="mr-10">Acc. Officer: </span>
				<select v-model="filter.account_officer" name="" id="selectProductClient" class="form-control flex-1">
					<option value="all">All</option>
					<option v-for="ao in aos.filter(aa=>aa.status=='active'&&aa.branch_id==branch.branch_id)" :key="ao.ao_id" :value="ao.ao_id">{{ao.name}}</option>
				</select>
			</div>	
			<div class="d-flex flex-row align-items-center mr-24" style="flex:1">
				<span class="mr-10">Product: </span>
				<select v-model="filter.product" name="" id="selectProductClient" class="form-control flex-1">
					<option value="all">All</option>
					<option v-for="product in products.filter(p=>p.status=='active')" :key="product.product_id" :value="product.product_id">{{product.product_name}}</option>
				</select>
			</div>				
		</div>
		<div class="sep mb-45"></div>
		<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">


		<section class="mb-72" id="performanceReport">
			<div class="d-flex flex-column mb-24">
				<div class="d-flex flex-row align-items-center">
					<div class="flex-1 d-flex flex-column">
					
					</div>
					<span class="font-30 text-bold text-primary-dark text-center">Loan Aging Summary</span>
					<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
						<current-transactiondate :branch="branch.branch_id" :token="token" :reports="true"></current-transactiondate>
						<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
					</div>
				</div>
				<span class="text-center text-primary-dark text-bold">As of {{filter.as_of?dateToMDY2(new Date(filter.as_of)).split('-').join('/'):'---'}}</span>
				<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name}} Branch ({{branch.branch_code}})</span>
			</div>
			<section class="d-flex flex-column mb-16 p-10 light-border">
				<table class="table table-stripped mb-24">
					<thead>
						<th>STATUS</th>
						<th>DAYS</th>
						<th># Acct.</th>
						<th>Amnt. Loan</th>
						<th>Balance</th>
						<th>Amnt. Due</th>
					</thead>
					<tbody>
						<tr v-if="!filteredResults.length"><td><i>No records found.</i></td></tr>
						<tr :class="fr[0].includes('TOTAL')?'text-bold bg-skyblue':''" v-for="fr,i in filteredResults" :key="i">
							<td v-for="j,k in fr" :key="k">{{k!==0&&k!==1?formatToCurrency(j):j}}</td>
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

		<div class="d-flex flex-row justify-content-end mb-45">
			<div class="d-flex flex-row-reverse">
				<a href="#" class="btn btn-default min-w-150">Print</a>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props:['pbranch','token'],
	data(){
		return {
			branch:{},
			filter:{
				account_officer:'all',
				product:'all',
				as_of:'',
				branch_id:'',
				type:'loan_aging_summary'
			},
			reports:[],
			products:[],
			aos:[]
		}
	},
    methods: {
		async fetchReports(){
			await axios.post(this.baseURL() + 'api/report/branch', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.reports = response.data.data;n  
				console.log(this.reports);
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
				this.fetchAo();
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		async fetchTransactionDate(){
			await axios.get(this.baseURL() + 'api/eod/eodtransaction/' + this.branch.branch_id,{
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.filter.as_of = response.data.data.date_end;
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
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
        print: function () {
            var content = document.getElementById("printContent").innerHTML;
            var target = document.querySelector(".to-print");
            target.innerHTML = content;
            window.print();
        },
    },
	computed:{
		filteredResults:function(){
			var rows = [];
			if(this.reports.current){
				var row = [];
				row.push('CURRENT');
				row.push('');
				row.push(this.reports.current.num_accts)
				row.push(this.reports.current.loan_amt)
				row.push(this.reports.current.balance)
				row.push(this.reports.current.due_amt)
				rows.push(row);
				var rowTotal = JSON.parse(JSON.stringify(row));
				rowTotal[0] = 'CURRENT TOTAL';
				rows.push(rowTotal);			}
			for(var i in this.reports){
				if(i != 'current'){
					var rowTotal = [i.toUpperCase() + ' TOTAL', '', 0,0,0,0];
					var count = 0;
					for (var j in this.reports[i]){
						var row = [];
						row.push(count==0?i.toUpperCase():'');
						row.push(j);
						row.push(this.reports[i][j].num_accts);
						rowTotal[2] += this.reports[i][j].num_accts;
						row.push(this.reports[i][j].loan_amt);
						rowTotal[3] += this.reports[i][j].loan_amt;
						row.push(this.reports[i][j].balance);
						rowTotal[4] += this.reports[i][j].balance;
						row.push(this.reports[i][j].due_amt);
						rowTotal[5] += this.reports[i][j].due_amt;
						count++;
						rows.push(row);
					}
					rows.push(rowTotal);
				}
			}
			return rows;
		}
	},
	watch:{
		 filter: {
			handler(val){
				if(val.as_of && val.product && val.account_officer){
					this.fetchReports();
				}
			},
			deep: true
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
		this.filter.branch_id = this.branch.branch_id;
		this.fetchProducts();
		this.fetchTransactionDate();
	}
};
</script>
