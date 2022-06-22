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
						<select v-model="preference.date" class="form-control select2 select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true">
							<option v-for="(date, d) in dates" :key="d" :value="dateToYMD(new Date(date))" data-select2-id="42">{{date.replace(/-/g,'/')}}</option>
						</select>
						<!-- <input v-model="preference.date" type="date" class="form-control" placeholder="Pick a date"> -->
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
						<tr v-for="b in filterClient" :key="b.borrower.borrower_id" class="loan-item" :class="isActive(b)">
							<td><input v-model="b.checked" type="checkbox" class="form-control form-box"></td>
							<td>{{b.account_num}}</td>
							<td><a href="#">{{b.borrower.firstname + ' ' + b.borrower.lastname}}</a></td>
							<td><span @click="loanAccount=b" class="text-green c-pointer">Select</span></td>
						</tr>
					</tbody>
				</table>
				<div class="d-flex flex-row-reverse sep-thin pb-10 mb-16" style="border-bottom-color:#CCC!important;">
					<a href="#" @click="batchOverride()" class="btn btn-success">Batch Override</a>
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
				<override-release-details @updateLoanAccounts="fetchAccounts();resetLoanAccount();" :csrf="csrf" :token="token" :ploanaccount="loanAccount" :pdate="preference.date"></override-release-details>
			</div>
		</div>
		<print-docs :ploanDetails="loanAccount" :token="token"></print-docs>
	</div>
</template>

<script>

export default {
	props:['token', 'csrf'],
	data(){
		return {
			loanAccounts:[],
			preference:{date:'',specification:''},
			borrowers:[],
			todaysReleases:[],
			loanAccount:{
				loan_amount:0,
				documents: {
					date_release: this.dateToYMD(new Date),
					description: '',
					bank: '',
					account_no: '',
					card_no:'',
					promissory_number: '',
				},
				borrower:{
					firstname:'',
					middlename:'',
					lastname:''
				},
				account_officer:{
					name:'',
				}
			},
			dates:[],
			filter:{ao_id:null,product_id:null,center_id:null,date:null}
		}
	},
	methods:{
		notify:function(title, text, type){
			this.$notify({
				group: 'foo',
				title: title,
				text: text,
				type: type,
			});
		},
		fetchAccounts:function(){
			axios.post(window.location.origin + '/api/account/overrrideaccounts', this.filter, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loanAccounts = this.setCheckbox(response.data.data);
				this.setDates;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		}, 
		todaysRelease:function(){
			axios.get(window.location.origin + '/transaction/todaysrelease')
			.then(function (response) {
				this.todaysReleases = response.data;
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
		override:function(){
			axios.get(window.location.origin + '/api/account/overrrideaccounts', {
			headers: {
				'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loanAccounts = this.setCheckbox(response.data.data);
				this.setDates;
				this.todaysRelease();
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		batchOverride:function(){
			var accounts = [];
			this.loanAccounts.map(function(account){
				if(account.checked){
					accounts.push(account);
				}
			});
			axios.post(window.location.origin + '/api/account/override', accounts, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.notify('',response.data.message, 'success');
				this.fetchAccounts();
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		resetLoanAccount:function(){
			this.loanAccount = {
				loan_account_id:null,
				cycle_no : 1,
				ao_id : '',
				product_id : '',
				center_id : '',
				type : '',
				payment_mode : '',
				terms : 0,
				loan_amount : '',
				no_of_installment : '',
				day_schedule : '',
				borrower_num : '',
				co_borrower_name : '',
				co_borrower_address : '',
				co_borrower_id_type : '',
				co_borrower_id_number : '',
				co_borrower_id_date_issued : '',
				co_maker_name : '',  
				co_maker_address : '',
				co_maker_id_type : '',
				co_maker_id_number : '',
				co_maker_id_date_issued : '',
				document_stamp : 0.00,
				filing_fee : 0.00,
				insurance : 0.00,
				notarial_fee : 100.00,
				prepaid_interest : 0.00,
				affidavit_fee : 0.00,
				memo : 0.00,
				total_deduction : 0.00,
				net_proceeds : 0.00,
				release_type : '',
				borrower:{
					borrower_num:'################',
					firstname:'',
					middlename:'',
					lastname:''
				},
				center:{
					center:''
				},
				documents: {
					date_release: this.dateToYMD(new Date),
					description: '',
					bank: '',
					account_no: '',
					card_no:'',
					promissory_number: '',
				},
				account_officer:{
					name:'',
				}
			};				
		},
		isActive:function(data){
			if(data.loan_account_id == this.loanAccount.loan_account_id){
				return 'active'
			}
			return '';
		},
		reject:function(){
			this.loanAccount.status = 'rejected';
			axios.put(window.location.origin + '/api/account/update/' + this.loanAccount.loan_account_id, this.loanAccount, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.notify('',response.data.message, 'success');
				this.fetchAccounts();
				this.resetLoanAccount();
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		}
	},
	computed:{
		selected:function(){
			var amount = 0;
			this.loanAccounts.map(function(account){
				if(account.checked){
					if(this.dateToYMD(new Date(account.created_at)) == this.dateToYMD(new Date(this.preference.date))){
						amount += account.net_proceeds;
					}
				}
			}.bind(this));
			return amount;
		},
		unselected:function(){
			var amount = 0;
			this.loanAccounts.map(function(account){
				if(!account.checked){
					if(this.dateToYMD(new Date(account.created_at)) == this.dateToYMD(new Date(this.preference.date))){
						amount += account.net_proceeds;
					}
				}
			}.bind(this));
			return amount;
		},
		totalProceeds:function(){
			var amount = 0;
			this.loanAccounts.map(function(account){
				if(this.dateToYMD(new Date(account.created_at)) == this.dateToYMD(new Date(this.preference.date))){
					amount += account.net_proceeds;
				}
			}.bind(this));
			return amount;
		},
		totalCash:function(){
			var amount = 0;
			this.todaysReleases.map(function(account){
				if(account.release_type == 'Cash Release'){
					amount += account.net_proceeds;
				}
			}.bind(this));
			return amount;
		},
		totalCheck:function(){
			var amount = 0;
			this.todaysReleases.map(function(account){
				if(account.release_type == 'Cheque Release'){
					amount += account.net_proceeds;
				}
			}.bind(this));
			return amount;
		},
		totalDeduction:function(){
			var amount = 0;
			this.todaysReleases.map(function(account){
				amount += account.total_deduction;
			}.bind(this));
			return 0;
		},
		totalRelease:function(){
			var amount = 0;
			this.todaysReleases.map(function(account){
				amount += account.net_proceeds;
			}.bind(this));
			return amount - this.totalDeduction;
		},
		filterClient:function(){
			var result = [];
			if(this.preference.date != ''){
				this.loanAccounts.map(function(val){
					if(this.dateToYMD(new Date(val.created_at)) == this.dateToYMD(new Date(this.preference.date))){
						if(this.preference.specification == ''){
							result.push(val);
							return
						}else{
							if(val.product.product_name.toLowerCase().includes(this.preference.specification.toLowerCase()) || (val.center && val.center.center.toLowerCase().includes(this.preference.specification.toLowerCase())) || val.account_num.toLowerCase().includes(this.preference.specification.toLowerCase()) || val.borrower.firstname.toLowerCase().includes(this.preference.specification.toLowerCase()) || val.borrower.lastname.toLowerCase().includes(this.preference.specification.toLowerCase()) || (val.borrower.firstname + ' ' + val.borrower.lastname).toLowerCase().includes(this.preference.specification.toLowerCase()) || (val.borrower.lastname + ' ' + val.borrower.firstname).toLowerCase().includes(this.preference.specification.toLowerCase())){
								result.push(val);
								return
							}
						}
					}
				}.bind(this))			
			}
			return result;
		},
		setDates:function(){
			this.loanAccounts.map(function(data){
				let date = this.dateToYMD(new Date(data.created_at));
				if(!this.dates.includes(date)){
					this.dates.push(date);
				}
			}.bind(this));
			if(!this.dates.includes(this.dateToYMD(new Date))){
				this.dates.unshift(this.dateToYMD(new Date));
			}
			return true;
		}
	},
	watch:{
		'preference.date':function(newValue){
			this.todaysRelease();
		}
	},
	mounted(){
		this.resetLoanAccount();
		this.preference.date = this.dateToYMD(new Date);
		this.fetchAccounts();
		this.preference.date = this.dateToYMD(new Date());
	}
}
</script>

<style lang="scss" scoped>
	.loan-item.active {
		background-color: #ccffcc;
	}
</style>