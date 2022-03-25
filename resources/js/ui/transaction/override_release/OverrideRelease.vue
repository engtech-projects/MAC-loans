<template>
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div class="mb-16"></div>
			<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between">
				<h1 class="m-0 font-35">Override Release</h1>
				<a href="#" class="btn btn-primary-dark min-w-150">New Client</a>
			</div>
		<div class="d-flex flex-column flex-xl-row p-16">
			<div style="flex:9;">
				<div class="d-flex">
					<div class="form-group mr-7 flex-1">
						<!-- <select class="form-control select2 select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true">
							<option data-select2-id="42">12/12/2021</option>
						</select> -->
						<input v-model="preference.date" type="date" class="form-control" placeholder="Pick a date">
					</div>
					<div class="form-group flex-2">
						<input v-model="preference.specification" type="text" class="form-control" placeholder="Specifications">
					</div>
				</div>
				
				<table class="table table-stripped table-hover" id="clientsList">
					<thead>
						<th>All</th>
						<th>Account #</th>
						<th>Client Name</th>
						<th></th>
					</thead>
					<tbody>
						<tr v-if="filterClient.length==0">
							<td>No records found.</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr v-for="b in filterClient" :key="b.borrower_id">
							<td><input v-model="b.checked" type="checkbox" class="form-control form-box"></td>
							<td>{{b.borrower_num}}</td>
							<td><a href="#">{{b.firstname + ' ' + b.lastname}}</a></td>
							<td><span @click="borrower=b" class="text-green c-pointer">select</span></td>
						</tr>
					</tbody>
				</table>
				<div class="d-flex flex-row-reverse sep-thin pb-10 mb-16" style="border-bottom-color:#CCC!important;">
					<a href="#" class="btn btn-success">Batch Override</a>
					<a href="#" data-toggle="modal" data-target="#overrideReleaseModal" class="btn btn-primary min-w-150 mr-16">View</a>
				</div>
				<section class="mb-16" style="border-bottom:1px solid #CCC!important;">
					<div class="d-flex flex-column mb-16">
						<div class="d-flex flex-row mb-12">
							<div class="d-flex flex-row flex-2 justify-content-between pr-24">
								<span class="">Unselected</span>
								<span>:</span>
							</div>
							<span class="flex-3 text-primary-dark">P {{formatToCurrency(unselected)}}</span>
						</div>
						<div class="d-flex flex-row mb-12">
							<div class="d-flex flex-row flex-2 justify-content-between pr-24">
								<span class="">Selected</span>
								<span>:</span>
							</div>
							<span class="flex-3 text-primary-dark">P {{formatToCurrency(selected)}}</span>
						</div>
						<div class="d-flex flex-row mb-12">
							<div class="d-flex flex-row flex-2 justify-content-between pr-24">
								<span class="">TOTAL</span>
								<span>:</span>
							</div>
							<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalProceeds)}}</span>
						</div>
					</div>
				</section>
				<section>
					<h4 class="section-title section-subtitle b-none">Release Summary</h4>
					<div class="d-flex flex-column mb-16">
						<div class="d-flex flex-row mb-12">
							<div class="d-flex flex-row flex-2 justify-content-between pr-24">
								<span class="">Total Cash</span>
								<span>:</span>
							</div>
							<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalCash)}}</span>
						</div>
						<!-- <div class="d-flex flex-row mb-12">
							<div class="d-flex flex-row flex-2 justify-content-between pr-24">
								<span class="">Total Cheque</span>
								<span>:</span>
							</div>
							<span class="flex-3 text-primary-dark">P 0.00</span>
						</div> -->
						<div class="d-flex flex-row mb-12">
							<div class="d-flex flex-row flex-2 justify-content-between pr-24">
								<span class="">Total Check</span>
								<span>:</span>
							</div>
							<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalCheck)}}</span>
						</div>
						<div class="d-flex flex-row mb-12">
							<div class="d-flex flex-row flex-2 justify-content-between pr-24">
								<span class="">Total Deduct to Balance</span>
								<span>:</span>
							</div>
							<span class="flex-3 text-primary-dark">P {{formatToCurrency(totalDeduction)}}</span>
						</div>
					</div>
					<div class="d-flex flex-column button-text">
						<span>TOTAL RELEASE FOR TODAY</span>
						<div class="d-flex flex-row">
							<span>P</span>
							<span>{{formatToCurrency(totalRelease)}}</span>
						</div>
					</div>
				</section>
			</div>
			<div style="flex:20">
				<override-release-details :token="token" :pborrower="borrower" :pdate="preference.date"></override-release-details>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props:['token'],
	data(){
		return {
			preference:{date:'',specification:''},
			borrowers:[],
			borrower:{}
		}
	},
	methods:{
		fetchBorrowers:function(){
			axios.get(window.location.origin + '/api/borrower', {
			headers: {
				'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.borrowers = this.setCheckbox(response.data.data);
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},   
		setCheckbox:function(data){
			for(let i in data){
				data[i].checked = false;
			}
			return data;
		},
		formatToCurrency:function(amount) {
			return parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
		},
		dateToYMD:function(date) {
			var d = date.getDate();
			var m = date.getMonth() + 1;
			var y = date.getFullYear();
			return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
		},
		resetBorrower:function(){
			this.borrower = {
				borrower_id: null,
				date_registered:'',
				borrower_num:'###############',
				firstname:'',
				lastname:'',
				middlename:'',
				suffix :'' ,
				address :'' ,
				birthdate :'',
				gender :'' ,
				status :'' ,
				contact_number :'',
				id_type :'',
				id_no :'',
				id_date_issued :'',
				spouse_firstname:'',
				spouse_lastname:'',
				spouse_middlename:'',
				spouse_address :'',
				spouse_birthdate :'',
				spouse_id_type :'',
				spouse_id_no :'',
				spouse_id_date_issued :'',
				employmentInfo : [],
				businessInfo : [],
				householdMembers : [],
				outstandingObligations : [],
				loanAccounts:[],
				created_at: this.dateToYMD(new Date()),
			};				
		},
	},
	computed:{
		selected:function(){
			var amount = 0;
			this.borrowers.map(function(val){
				if(val.checked){
					val.loanAccounts.map(function(account){
						if(this.dateToYMD(new Date(account.created_at)) == this.dateToYMD(new Date(this.preference.date))){
							amount += account.net_proceeds;
						}
					}.bind(this));
				}
			}.bind(this));
			return amount;
		},
		unselected:function(){
			var amount = 0;
			this.borrowers.map(function(val){
				if(!val.checked){
					val.loanAccounts.map(function(account){
						if(this.dateToYMD(new Date(account.created_at)) == this.dateToYMD(new Date(this.preference.date))){
							amount += account.net_proceeds;
						}
					}.bind(this));
				}
			}.bind(this));
			return amount;
		},
		totalProceeds:function(){
			var amount = 0;
			this.borrowers.map(function(val){
				val.loanAccounts.map(function(account){
					if(this.dateToYMD(new Date(account.created_at)) == this.dateToYMD(new Date(this.preference.date))){
						amount += account.net_proceeds;
					}
				}.bind(this));
			}.bind(this));
			return amount;
		},
		totalCash:function(){
			var amount = 0;
			this.borrowers.map(function(val){
				val.loanAccounts.map(function(account){
					if(this.dateToYMD(new Date(account.created_at)) == this.dateToYMD(new Date(this.preference.date)) && account.release_type == 'Cash Release'){
						amount += account.net_proceeds;
					}
				}.bind(this));
			}.bind(this));
			return amount;
		},
		totalCheck:function(){
			var amount = 0;
			this.borrowers.map(function(val){
				val.loanAccounts.map(function(account){
					if(this.dateToYMD(new Date(account.created_at)) == this.dateToYMD(new Date(this.preference.date)) && account.release_type == 'Cheque Release'){
						amount += account.net_proceeds;
					}
				}.bind(this));
			}.bind(this));
			return amount;
		},
		totalDeduction:function(){
			var amount = 0;
			this.borrowers.map(function(val){
				val.loanAccounts.map(function(account){
					if(this.dateToYMD(new Date(account.created_at)) == this.dateToYMD(new Date(this.preference.date))){
						amount += account.total_deduction;
					}
				}.bind(this));
			}.bind(this));
			return amount;
		},
		totalRelease:function(){
			var amount = 0;
			this.borrowers.map(function(val){
				val.loanAccounts.map(function(account){
					if(this.dateToYMD(new Date(account.created_at)) == this.dateToYMD(new Date(this.preference.date))){
						amount += account.net_proceeds;
					}
				}.bind(this));
			}.bind(this));
			return amount;
		},
		filterClient:function(){
			var result = [];
			if(this.preference.date != ''){
				this.borrowers.map(function(data){
					data.loanAccounts.map(function(val){
						if(this.dateToYMD(new Date(val.created_at)) == this.dateToYMD(new Date(this.preference.date))){
							if(this.preference.specification == ''){
								result.push(data);
								return
							}else{
								if(data.firstname.toLowerCase().includes(this.preference.specification.toLowerCase()) || data.lastname.toLowerCase().includes(this.preference.specification.toLowerCase()) || (data.firstname + ' ' + data.lastname).toLowerCase().includes(this.preference.specification.toLowerCase()) || (data.lastname + ' ' + data.firstname).toLowerCase().includes(this.preference.specification.toLowerCase())){
									result.push(data);
									return
								}
							}
						}
						console.log();
					}.bind(this))			
				}.bind(this))
			}
			return result;
		}
	},
	mounted(){
		this.resetBorrower();
		this.fetchBorrowers();
		this.preference.date = this.dateToYMD(new Date());
	}
}
</script>