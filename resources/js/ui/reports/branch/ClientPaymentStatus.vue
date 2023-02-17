<template>
	<div class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<div class="d-flex align-items-center" style="flex:1">
				<div class="d-flex flex-column flex-3 mr-64">
					<input v-model="search" type="text" class="form-control" placeholder="Search Client">
					<div v-if="search.length > 1" class="clientlistsearch d-flex flex-column">
						<span @click="selectClient(c)" v-for="c in filteredClients" :key="c.borrower_id">{{fullNameReverse(c.firstname, c.middlename, c.lastname)}}</span>
						<span v-if="!filteredClients.length"><i>No clients found.</i></span>
					</div>
				</div>
				 <!-- <div class="d-flex flex-row align-items-center mr-24" style="flex:1">
					<span class="mr-10">As of: </span>
					<input v-model="filter.as_of" type="date" class="form-control flex-1">
				</div> -->
			</div>
		</div>
		<div class="sep mb-45"></div>
		<div id="printContent">
			<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">
				<section class="mb-72" id="clientSection">
						<div class="d-flex flex-column mb-24">
							<div class="d-flex flex-row align-items-center">
								<div class="flex-1 d-flex flex-column">
								
								</div>
								<span class="font-30 text-bold text-primary-dark">CLIENT's STATUS REPORT</span>
								<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
									<current-transactiondate :branch="branch.branch_id" :token="token" :reports="true"></current-transactiondate>
									<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
								</div>
							</div>
							<span class="text-center text-primary-dark text-bold">As of {{filter.as_of?dateToYMD(new Date(filter.as_of)).replaceAll('-','/'):'---'}}</span>
							<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name}} Branch ({{branch.branch_code}})</span>
						</div>
						<section v-if="client.borrower_id" class="d-flex flex-column align-items-start mb-24">
							<span class="pxy-7 font-20 bg-primary-dark text-white">Borrower's Number: {{client.borrower_num}}</span>
							<span class="text-primary-dark font-20 text-bold">Name: {{fullNameReverse(client.firstname, client.middlename, client.lastname)}}</span>
							<span class="text-primary-dark font-20">Address: {{client.address}}</span>
						</section>
						<section class="d-flex flex-column mb-16">
							<span class="bbt-8-light font-20 text-primary-dark text-center text-bold p-7">Performance of Previous Loan</span>
							<div class="p-10 light-border">
								<table class="table table-stripped th-blue">
									<thead>
										<th>Cumulative Loan</th>
										<th>Loan Acct.#</th>
										<th>Date Disbursed</th>
										<th>Amnt Loan Disbursed</th>
										<th># of Amort.</th>
										<th># of Late Amort.</th>
										<th>Max Days Late</th>
										<th>% Amort. Made on Time</th>
										<th>Business Activity</th>
									</thead>
									<tbody>
										<tr v-if="!closedLoans.length"><td><i>No records found.</i></td></tr>
										<tr v-for="c,i in closedLoans" :key="i">
											<td>{{c.cumulative_loan}}</td>
											<td>{{c.account_num}}</td>
											<td>{{c.date_loaned}}</td>
											<td>{{formatToCurrency(c.amt_loan)}}</td>
											<td>{{c.no_of_amort}}</td>
											<td>0</td>
											<td>{{c.max_late}}</td>
											<td>{{c.amort_ontime}}%</td>
											<td>--</td>
										</tr>
									</tbody>
								</table>
							</div>
						</section>

						<section  class="d-flex flex-column mb-16">
							<span class="bbt-8-light font-20 text-primary-dark text-center text-bold p-7 mb-16">Current Loan Information</span>
							<div v-for="o,i in ongoingLoans" :key="i" class="mb-24">
								<div class="d-flex mb-16 text-20 text-primary-dark">
									<div class="d-flex flex-column flex-1">
										<span>Loan Date: {{o.date_loaned}}</span>
										<span># of Amortizations: {{o.no_of_amort}}</span>
										<span># of Amort. made on time to 12/21/2021: {{o.amort_ontime}}</span>
									</div>
									<div class="d-flex flex-column flex-1" flex-1>
										<span>Loan Amount: {{formatToCurrency(o.amt_loan)}}</span>
										<span># of Amortizations expected to date {{o.amortizations?o.amortizations[o.amortizations.length -1].amort_due_date:''}}: {{o.amortizations?o.amortizations.length:''}}</span>
										<span>% Made on time to date 12/21/2021: 72.73%</span>
									</div>
								</div>
								<div class="p-10 light-border">
									<table class="table table-stripped th-blue">
										<thead>
											<th>Amor. No.</th>
											<th>Amor. Amount</th>
											<th>Amor. Due Date</th>
											<th>Amor. Paid Date</th>
											<th>Amor. Status</th>
											<th>Days Late</th>
										</thead>
										<tbody>
											<tr v-if="!ongoingLoans.length"><td><i>No records found.</i></td></tr>
											<tr v-for="oa,j in o.amortizations" :key="j">
												<td>{{oa.amort_no}}</td>
												<td>{{oa.amort_amt?oa.amort_amt:0}}</td>
												<td>{{oa.amort_due_date?oa.amort_due_date:0}}</td>
												<td>{{oa.amort_paid_date?oa.amort_paid_date:0}}</td>
												<td>{{oa.amor_status?oa.amor_status:0}}</td>
												<td>{{oa.days_late?oa.days_late:0}}</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							
						</section>
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
	props:['token','pbranch'],
	data(){
		return {
			filter:{
				type:'client_payment_status',
				borrower_id:null,
				as_of:null,
			},
			clients:[],
			client:{
				borrower_id:null,
				borrower_num:'',
				firstname:'',
				middlename:'',
				lastname:'',
				address:''
			},
			branch:{},
			search:'',
			reports:[],
		}
	},
	methods:{
		async fetchTransactionDate(){
			await axios.get(this.baseURL() + 'api/eod/eodtransaction/'+this.branch.branch_id, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				// console.log(response.data.data)
				this.filter.as_of = response.data.data.date_end;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		async fetchBorrower(){
			await axios.get(this.baseURL() + 'api/borrower/', {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'contentType': "multipart/form-data"
					}
				})
				.then(function (response) {
					this.clients = response.data.data;
					this.fetchTransactionDate();
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
		},
		async fetchReport(){
			await axios.post(this.baseURL() + 'api/report/branch', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.reports = response.data.data;
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
		selectClient:function(client){
			this.filter.borrower_id = client.borrower_id;
			this.client = client;
			this.search = '';
		},
		clientInBranch:function(client){
			if(client.loan_accounts){
				console.log(client.loan_accounts[0].branch_code == this.branch.branch_code);
				return client.loan_accounts[0].branch_code == this.branch.branch_code;
			}
			return false;
		},
		ongoingTotal:function(amort){
			var total = {

			}
		}
	},
	computed:{
		branchClients:function(){
			return this.clients.filter(c=>this.clientInBranch(c));
		},
		filteredClients:function(){
			if(this.search.length > 1){
				return this.branchClients.filter(i => i.firstname.toLowerCase().includes(this.search.toLowerCase()) || i.lastname.toLowerCase().includes(this.search.toLowerCase()));
			}
			return this.branchClients;
		},
		closedLoans:function(){
			return this.reports.closed?this.reports.closed:[];
		},
		ongoingLoans:function(){
			return this.reports.ongoing?this.reports.ongoing:[];
		},
	},
	watch:{
		filter: {
			handler(val){
				if(val.as_of && val.borrower_id){
					this.fetchReport();
				}
			},
			deep: true
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
		this.fetchBorrower();
	}
}
</script>
<style scoped>
	.clientlistsearch {
		border: 1px solid #eee;
		box-shadow: 1px 1px 7px rgba(0,0,0,.2);
		cursor: pointer;
	}
	.clientlistsearch > span {
		padding: 5px 10px;
	}
	.clientlistsearch > span:not(:last-child) {
		border-bottom: 1px solid #e5e5e5;
	}
	.clientlistsearch > span:hover {
		background-color: #eee;
		color: #2980b9;
	}
	.clientlistsearch > span:active {
		background-color: #e2e2e2;
		color: #3498db;
	}
</style>