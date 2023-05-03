<template>
	<div class="d-flex flex-column" style="flex:8;">
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark" style="flex:3">Report</span>
			<!-- <div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">From: </span>
				<input type="date" class="form-control">
			</div>
			<div class="d-flex flex-row align-items-center mr-64" style="flex:2">
				<span class="mr-10">To: </span>
				<input type="date" class="form-control">
			</div> -->
			<!-- <div class="d-flex flex-row align-items-center mr-24" style="flex:3">
				<span class="mr-10 flex-1">Account Officer: </span>
				<select v-model="filter.account_officer" name="" id="selectProductClient" class="form-control">
					<option v-for="ao in aos" :key="ao.ao_id" :value="ao.ao_id">{{ao.name}}</option>
					<option value="all">All</option>
				</select>
			</div> -->
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">Report Type </span>
				<select v-model="filter.group" name="" id="selectProductClient" class="form-control flex-1">
					<option value="performance_report">Performance Report</option>
					<option value="write_off">Write Off Report</option>
					<option value="delinquent">Delinquent Report</option>
				</select>
			</div>
			<div class="d-flex flex-row align-items-center mr-24 justify-content-start flex-1">
				<button @click="generate()" class="btn btn-primary">Generate</button>
			</div>
			<!-- <div class="d-flex flex-row align-items-center" style="flex:3">
				<span class="mr-10">AO: </span>
				<select name="" id="selectProductClient" class="form-control">
					<option value="">Allotment Loan</option>
					<option value="">Micro Group</option>
					<option value="">Micro Individual</option>
					<option value="">Pension Emergency</option>
					<option value="">Pension Loan</option>
					<option value="">SME Loan</option>
				</select>
			</div> -->
		</div>
		<div class="sep mb-45"></div>
		<div id="printContent">
			<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">
				<section class="mb-72" id="performanceReport">
						<div class="d-flex flex-column mb-24">
							<div class="d-flex flex-row align-items-center">
								<div class="flex-1 d-flex flex-column">
								
								</div>
								<span v-if="filter.group=='performance_report'" class="font-30 text-bold text-primary-dark">ACCOUNT OFFICER PERFORMANCE REPORT</span>
								<span v-else-if="filter.group=='write_off'" class="font-30 text-bold text-primary-dark">ACCOUNT OFFICER WRITE-OFF REPORT</span>
								<span v-else class="font-30 text-bold text-primary-dark">ACCOUNT OFFICER DELINQUENT REPORT</span>
								<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
									<current-transactiondate :branch="branch.branch_id" :token="token" :reports="true"></current-transactiondate>
									<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
								</div>
							</div>
							<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name}} Branch ({{branch.branch_code}})</span>
							<div class="d-flex flex-row justify-content-center text-primary-dark">
								<span class="text-center text-primary-dark text-bold">As of {{filter.as_of?dateToMDY2(new Date(filter.as_of)).split('-').join('/'):'---'}}</span>
							</div>
						</div>
						<section class="d-flex flex-column mb-16">
							<div class="p-10 light-border">
								
								<!-- Table for Performance Report  -->
								<table v-if="filter.group == 'performance_report'" class="table table-stripped th-blue th-nbt">
									<thead>
										<th>Account Officer</th>
										<th>Product</th>
										<th># Acct.</th>
										<th>Portfolio</th>
										<th># Acct.</th>
										<th>Delinquent Amount</th>
										<th>Due Rate</th>
										<th># Acct.</th>
										<th>Pastdue</th>
										<th>PD Rate</th>
									</thead>
									<tbody>
										<tr v-if="!filteredResult.length"><td><i>No data available.</i></td></tr>
										<tr v-for="fr,i in filteredResult" :key="i" :class="prTableStyle(fr)">
											<td v-for="r,k in fr" :key="k">{{r}}</td>
										</tr>
									</tbody>
								</table>

								<!-- Table for Write-off Report -->
								<table v-if="filter.group == 'write_off'" class="table table-stripped th-blue th-nbt">
									<thead>
										<th>Account Officer</th>
										<th>No. of Accounts</th>
										<th>Portfolio</th>
										<th>Principal Bal</th>
										<th>Interest Bal</th>
									</thead>
									<tbody>
										<tr v-if="!filteredResult.length"><td><i>No data available.</i></td></tr>
										<tr v-for="fr,i in reports" :key="i">
											<td>{{fr.ao_name}}</td>
											<td>{{fr.num_of_accounts}}</td>
											<td>{{formatToCurrency(fr.principal_balance)}}</td>
											<td>{{formatToCurrency(fr.principal_balance)}}</td>
											<td>{{formatToCurrency(fr.interest_balance)}}</td>
										</tr>
									</tbody>
								</table>

								<!-- Table for Delinquent Report -->
								<table v-if="filter.group == 'delinquent'" class="table table-stripped th-blue th-nbt">
									<thead>
										<th>Borrower's Name</th>
										<th>Acct. #</th>
										<th>Date Loan</th>
										<th>Maturity</th>
										<th>Amt. Loan</th>
										<th>Balance</th>
										<th>Principal Bal.</th>
										<th>Interest Bal.</th>
										<th>Amort Amt</th>
										<th>Deli Amt</th>
										<th>Type</th>
										<th>Ms Amrt</th>
										<th># of Days</th>
										<th>Status</th>
									</thead>
									<tbody>
										<tr v-if="!filteredResult.length"><td><i>No data available.</i></td></tr>
										<tr v-for="fr,i in delinquentReport" :key="i">
											<td v-for="row,j in fr" :key="j">{{row}}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</section>

					</section>

					<section class="d-flex flex-row mb-72">
						<span class="flex-2 pb-24 text-bold darker-bb mr-64">Prepared By:</span>
						<span class="flex-2 pb-24 text-bold darker-bb mr-64">Certified Corrected By:</span>
						<span class="flex-2 pb-24 text-bold darker-bb mr-64">Approved By:</span>
						<span class="flex-1"></span>
					</section>

					
			<div class="d-flex mb-24">
				<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
			</div>
		</div>
		<!-- <div class="d-flex flex-row justify-content-end mb-24">
			<a href="#" class="text-green text-md text-bold mr-24">Previous Page</a>
			<a href="#" class="text-green text-md text-bold">Next Page</a>
		</div> -->
		<div class="d-flex flex-row block mb-45">
			<div class="d-flex justify-content-end block flex-1">
				<a @click="print()" href="#" class="btn btn-default min-w-150">Print</a>
				<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
			</div>
		</div>
	</div>

</template>

<script>
export default {
	props:['token', 'pbranch'],
	data(){
		return {
			loading:false,
			aos:[],
			branch:{},
			filter:{
				branch_id:'',
				group:'performance_report',
				type:'account_officer'
			},
			reports:[],
		}
	},
	methods:{
		generate:function(){
			this.fetchReports();
		},
		async fetchReports(){
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
				// console.log(this.reports);
			}.bind(this))
			.catch(function (error) {
				this.loading = false;
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
		
		print:function(){
			var content = document.getElementById('printContent').innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			window.print();
		},
		prTableStyle:function(fr){
			if(fr[0]=='OFFICER SUB-TOTAL'){
				return 'bbt-8-light text-primary-dark text-bold';
			}else if(fr[0]=='TOTAL'){
				return 'text-white text-bold bg-primary-dark'
			}
			
		}
	},
	computed:{
		total:function(){
			var row = [0,0];
			this.reports.forEach(r=>{
				row[0] += r.principal_balance;
				row[1] += r.interest_balance;
			})
			return row;
		},
		accountOfficer:function(){
			var aos = this.aos.filter(ao=>ao.ao_id==this.filter.account_officer);
			return aos.length?aos[0]:[];
		},
		filteredResult:function(){
			var result = [];
			var overall = ['TOTAL','',0,0,0,0,'',0,0,''];
			this.reports.forEach(r=>{
				var total = ['OFFICER SUB-TOTAL','',0,0,0,0,0,0,0,0];
				if(r.products){
					r.products.forEach((p,i)=>{
						var row = [0,0,0,0,0,0,0,0,0,0];
						row[0] = i==0?r.name:'';
						row[1] = p.product_code + '-' + p.product_name;
						row[2] = p.all.count;
						total[2] += p.all.count;
						row[3] = this.formatToCurrency(p.all.amount);
						total[3] += p.all.amount;
						row[4] = p.delinquent.count;
						total[4] += p.delinquent.count;
						row[5] = this.formatToCurrency(p.delinquent.amount);
						total[5] += p.delinquent.amount;
						row[6] = p.delinquent.rate + '%';
						total[6] += p.delinquent.rate;
						row[7] = p.pastdue.count;
						total[7] += p.pastdue.count;
						row[8] = this.formatToCurrency(p.pastdue.amount);
						total[8] += p.pastdue.amount;
						row[9] = p.pastdue.rate + '%';
						total[9] += p.pastdue.rate;
						result.push(row);
					});
					total[6] = (total[5]/total[3]*100) % 1 != 0? (total[5]/total[3]*100).toFixed(2):(total[5]/total[3]*100);
					total[6] = isNaN(total[6])? '0%':total[6]+ '%';
					total[9] = (total[8]/total[3]*100) % 1 != 0? (total[8]/total[3]*100).toFixed(2):(total[8]/total[3]*100);
					total[9] = isNaN(total[9])? '0%':total[9]+ '%';
					overall[3] += total[3];
					total[3] = this.formatToCurrency(total[3]);
					overall[2] += total[2];
					overall[4] += total[4];
					overall[5] += total[5];
					overall[7] += total[7];
					total[5] = this.formatToCurrency(total[5]);
					overall[8] += total[8];
					total[8] = this.formatToCurrency(total[8]);
					result.push(total);
				}
			})
			overall[3] = this.formatToCurrency(overall[3]);
			overall[5] = this.formatToCurrency(overall[5]);
			overall[8] = this.formatToCurrency(overall[8]);
			result.push(overall);
			return result;
		},
		delinquentReport:function(){
			var rows = [];
			this.reports.forEach(r=>{
				if(r.data){
					for(var d in r.data){
						var row = [];
						row.push(r.data[d].borrower_name);
						row.push(r.data[d].account_num);
						row.push(r.data[d].date_loan);
						row.push(r.data[d].maturity);
						row.push(this.formatToCurrency(r.data[d].amount_loan));
						row.push(this.formatToCurrency(r.data[d].balance));
						row.push(this.formatToCurrency(r.data[d].principal_balance));
						row.push(this.formatToCurrency(r.data[d].interest_balance));
						row.push(this.formatToCurrency(r.data[d].amortization));
						row.push(this.formatToCurrency(r.data[d].delinquent_amount));
						row.push(r.data[d].type);
						row.push(this.formatToCurrency(r.data[d].missed_amortization));
						row.push(r.data[d].days_missed);
						row.push(r.data[d].status);
						rows.push(row);
					}
				}
			});
			return rows;
		}
	},
	watch:{
		'filter.group'(val){
			// if(val){
			// 	this.fetchReports();
			// }
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
		this.filter.branch_id = this.branch.branch_id;
		this.fetchAo();
		this.fetchTransactionDate();
	}
}
</script>