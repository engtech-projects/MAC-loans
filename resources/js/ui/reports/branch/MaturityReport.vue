<template>
	<div class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark" style="flex:3">Transaction</span>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">From: </span>
				<input v-model="filter.due_from" type="date" class="form-control">
			</div>
			<div class="d-flex flex-row align-items-center mr-64" style="flex:2">
				<span class="mr-10">To: </span>
				<input v-model="filter.due_to" type="date" class="form-control">
			</div>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:3">
				<span class="mr-10">A.O: </span>
				<select v-model="filter.account_officer" name="" id="selectProductClient" class="form-control">
					<option value="all">All</option>
					<option v-for="ao in aos.filter(aa=>aa.status=='active'&&aa.branch_id==branch.branch_id)" :key="ao.ao_id" :value="ao.ao_id">{{ao.name}}</option>
				</select>
			</div>
			<div class="d-flex flex-row align-items-center" style="flex:3">
				<span class="mr-10">Center: </span>
				<select v-model="filter.center" name="" id="selectProductClient" class="form-control">
					<option value="all">All</option>
					<option v-for="center in centers" :key="center.center_id" :value="center.center_id">{{center.center}}</option>
				</select>
			</div>
		</div>
		<div class="sep mb-45"></div>
		<div id="printContent">
			<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">
				<section class="mb-72" id="clientSection">
						<div class="d-flex flex-column mb-24">

							<div class="d-flex flex-row align-items-center">
								<div class="flex-1 d-flex flex-column">
									<span v-if="filter.account_officer">Account Officer</span>
									<!-- <span v-if="filter.account_officer" class="text-bold">{{branch.branch_code}} - {{accountOfficer.name}}</span> -->
                                    <span v-text="filter.account_officer !='all' ? branch.branch_code + ' - ' + accountOfficer.name : branch.branch_code + ' - ' +'All'" class="text-bold">
                                    </span>
								</div>
								<span class="font-30 text-bold text-primary-dark text-center">MATURITY REPORT</span>
								<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
									<current-transactiondate :branch="branch.branch_id" :token="token" :reports="true"></current-transactiondate>
									<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
								</div>
							</div>
							<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name + ' (' + branch.branch_code + ')'}}</span>
							<div class="d-flex flex-row justify-content-center text-primary-dark">
								<span class="mr-5">From:</span><span class="mr-16">{{filter.due_from?filter.due_from:'---'}}</span>
								<span class="mr-5">To:</span><span>{{filter.due_to?filter.due_to:'---'}}</span>
							</div>
						</div>
						<section class="d-flex flex-column mb-16">
							<div>
								<table class="table table-thin table-stripped" style="font-size:14.2px;">
									<thead>
										<th>Client</th>
										<th>Granted</th>
										<th>Maturity</th>
										<th>Principal Balance</th>
										<th>Interest Balance</th>
										<th>Center</th>
									</thead>
									<tbody>
										<tr v-if="!reports.length"><td><i>No data available.</i></td></tr>
										<tr v-for="r,i in reports" :key="i">
											<td>{{r.client}}</td>
											<td>{{r.date_released.replaceAll('-','/')}}</td>
											<td>{{r.due_date.replaceAll('-','/')}}</td>
											<td>{{formatToCurrency(r.principal_balance)}}</td>
											<td>{{formatToCurrency(r.interest_balance)}}</td>
											<td>{{r.center}}</td>
										</tr>
										<tr class="border-cell-gray-7">
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr class="py-7">
											<td class="py-7"></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr class="tr-py-7 text-bold bg-green-mint">
											<td>TOTAL</td>
											<td></td>
											<td>{{reports.length}}</td>
											<td v-for="t,i in total" :key="i">{{formatToCurrency(t)}}</td>
											<td></td>
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
			reports:[],
			filter:{
				due_from:'',
				due_to:'',
				branch_id:'',
				account_officer:'all',
				center:'all',
				type:'maturity'
			},
			branch:{},
			aos:[],
			centers:[]
		}
	},
	methods:{
		async fetchReports(){
			this.filter.branch_id = this.branch.branch_id;
			await axios.post(this.baseURL() + 'api/report/branch', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.reports = response.data.data
				console.log(response.data);
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
		}
	},
	watch:{
		filter:{
			handler(val){
				if(val.account_officer&&val.center&&val.due_from&&val.due_to){
					this.fetchReports();
				}
			},
			deep:true
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
		this.filter.branch_id = this.branch.branch_id;
		this.fetchAo();
		this.fetchCenters();
	}
}
</script>
