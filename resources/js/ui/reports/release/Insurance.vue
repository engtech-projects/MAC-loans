<template>
	<div class="d-flex flex-column justify-content-between" style="flex:8;min-height:100vh;">
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
		<div>
			<form @submit.prevent="fetchAccounts">
			<div class="d-flex flex-row font-md align-items-center mb-16">
				<span class="font-lg text-primary-dark" style="flex:6">Insurance Report</span>
				<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
					<span class="mr-10">From: </span>
					<input v-model="filter.date_from" type="date" required class="form-control">
				</div>
				<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
					<span class="mr-10">To: </span>
					<input v-model="filter.date_to" type="date" required class="form-control">
				</div>
				<div class="d-flex flex-row align-items-center mr-24 justify-content-start flex-1">
					<button class="btn btn-primary">Generate</button>
				</div>
			</div>
			</form>
			<div class="sep mb-45"></div>
			<div id="printContent">
				<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">

				<section class="" id="clientSection">
					<div class="d-flex flex-column mb-16">
						<div class="d-flex flex-row align-items-center">
							<div class="flex-1"></div>
							<span class="font-30 text-bold text-primary-dark">INSURANCE REPORT</span>
							<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
								<current-transactiondate :branch="branch.branch_id" :token="token" :reports="true"></current-transactiondate>
								<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
							</div>
						</div>
						<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name + ' Branch (' + branch.branch_code + ')'}}</span>
						<div v-if="filter.date_from&&filter.date_to" class="d-flex flex-row justify-content-center text-primary-dark">
							<span class="mr-5">From:</span><span class="mr-16">{{dateToMDY2(new Date(filter.date_from)).split('-').join('/')}}</span>
							<span class="mr-5">To:</span><span>{{dateToMDY2(new Date(filter.date_to)).split('-').join('/')}}</span>
						</div>
						<div v-else class="d-flex flex-row justify-content-center text-primary-dark">
							<span class="mr-5">From:</span><span class="mr-16">---</span>
							<span class="mr-5">To:</span><span>---</span>
						</div>
					</div>
					<section class="d-flex flex-column mb-72">
						<table class="table td-nb table-thin">
							<thead>
								<th>Account No.</th>
								<th>Full Name</th>
								<th>Birthdate</th>
								<th>Gender</th>
								<th>Status</th>
								<th>Amount Loan</th>
								<th>Insurance</th>
								<th>Date Loan</th>
								<th>Due Date</th>
								<th>Term</th>
							</thead>
							<tbody>
								<tr v-if="!accounts.length"><td><i>No records found.</i></td></tr>
								<tr v-else v-for="a,i in accounts" :key="i">
									<td>{{a.account_num}}</td>
									<td>{{a.name}}</td>
									<td>{{dateToMDY(new Date(a.birthdate))}}</td>
									<td>{{upperFirst(a.gender)}}</td>
									<td>{{upperFirst(a.marital_status)}}</td>
									<td>{{formatToCurrency(a.amount_loan)}}</td>
									<td>{{formatToCurrency(a.insurance)}}</td>
									<td>{{dateToMDY(new Date(a.date_loan))}}</td>
									<td>{{dateToMDY(new Date(a.due_date))}}</td>
									<td>{{a.term / 30}} Mos</td>
								</tr>
							</tbody>
						</table>
					</section>
				</section>
			</div>
		</div>
		<div>
			<div class="d-flex mb-64" style="margin-top:auto">
					<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
			</div>
			<div class="d-flex flex-row justify-content-between mb-45">
				
				<div class="d-flex flex-row-reverse justify-content-start flex-1">
					<a @click="print()" href="#" class="btn btn-default min-w-150">Print</a>
					<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
				</div>
			</div>
		</div>
	</div>

</template>

<script>
export default {
	props:['token','pbranch'],
	data(){
		return {
			loading:false,
			filter:{
				date_from: null,
				date_to: null,
				branch_id:null,
				category:'insurance',
			},
			branch:{
				branch_id:'',
				branch_name:''
			},
			accounts:[],
		}
	},
	methods:{
		fetchAccounts:function(){
			this.loading = true;
			axios.post(this.baseURL() + 'api/report/release', this.filter, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loading = false;
				this.accounts = response.data.data;
			}.bind(this))
			.catch(function (error) {
				this.loading = false;
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
		
		
	},
	watch:{
		 filter: {
			handler(val){
				if(val.date_from && val.date_to){
					// this.fetchAccounts();
				}
			},
			deep: true
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
		this.filter.branch_id = this.branch.branch_id
	}
}
</script>