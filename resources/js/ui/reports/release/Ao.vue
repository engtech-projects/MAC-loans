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
				<span class="mr-10">AO: </span>
				<select v-model="filter.account_officer" name="" id="selectProductClient" class="form-control">
					<option value="all">All Records</option>
					<option v-for="a in ao" :key="a.ao_id" :value="a.ao_id">{{a.name}}</option>
				</select>
			</div>
		</div>
		<div class="sep mb-45"></div>
		<div id="printContent">
			<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">

			<section class="" id="clientSection">
				<div class="d-flex flex-column mb-24">
					<div class="d-flex flex-row align-items-center">
						<div class="flex-1 d-flex flex-column">
							<span>Account Officer</span>
							<span v-if="filter.account_officer!='all'" class="text-bold">{{accountOfficer}}</span>
							<span v-if="filter.account_officer=='all'" class="text-bold">All Records</span>
						</div>
						<span class="font-30 text-bold text-primary-dark">ACCOUNT OFFICER SUMMARY REPORT</span>
						<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
							<current-transactiondate :branch="branch_id" :token="token" :reports="true" @update-transaction-date="setTransactionDate"></current-transactiondate>
							<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
						</div>
					</div>
					<span v-if="filter.account_officer!='all'" class="text-center text-primary-dark text-bold font-md mb-5">{{branchName}}</span>
					<span v-if="filter.account_officer=='all'" class="text-center text-primary-dark text-bold font-md mb-5">All Branches</span>
					<div v-if="filter.date_from&&filter.date_to" class="d-flex flex-row justify-content-center text-primary-dark">
						<span class="mr-5">From:</span><span class="mr-16">{{dateToMDY2(new Date(filter.date_from)).split('-').join('/')}}</span>
						<span class="mr-5">To:</span><span>{{dateToMDY2(new Date(filter.date_to)).split('-').join('/')}}</span>
					</div>
					<div v-if="!filter.date_from||!filter.date_to" class="d-flex flex-row justify-content-center text-primary-dark">
						<span class="mr-5">From:</span><span class="mr-16">---</span>
						<span class="mr-5">To:</span><span>---</span>
					</div>
				</div>
			</section>
			<section class="d-flex flex-column mb-72">
					<span class="text-bold bg-yellow-light" style="padding:2px 5px;">RELEASES SUMMARY</span>
					<table class="table td-nb table-thin">
						<thead>
							<th>Reference</th>
							<th>New Acct.</th>
							<th>Amt. Released</th>
							<th>Rep. Acct</th>
							<th>Amt. Released</th>
							<th>Total Released</th>
						</thead>
						<tbody>
							<tr v-if="!accounts.length">
								<td><i>No records found.</i></td>
							</tr>
							<tr v-else v-for="t,i in tableData" :key="i">
								<td v-for="j,k in t" :key="k">{{j}}</td>
							</tr>
							<tr class="border-cell-gray-7">
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr v-if="accounts.length > 0" class="tr-pt-7 text-bold bg-skyblue">
								<td>TOTAL RELEASES</td>
								<td>{{totalReleases.newAccount}}</td>
								<td>{{formatToCurrency(totalReleases.newAccountAmount)}}</td>
								<td>{{totalReleases.repAccount}}</td>
								<td>{{formatToCurrency(totalReleases.repAccountReleased)}}</td>
								<td>{{formatToCurrency(totalReleases.totalReleased)}}</td>
							</tr>
						</tbody>
					</table>
					<div class="d-flex flex-row bg-yellow-pale p-5 align-items-center hide">
						<div class="d-flex flex-column flex-1 mr-64">
							<div class="d-flex flex-row flex-1 mb-5">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL CASH RELEASE</span>
									<span>:</span>
								</div>
								<span class="flex-1">6,347.00</span>
							</div>
							<div class="d-flex flex-row flex-1 mb-5">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL CHECK RELEASE</span>
									<span>:</span>
								</div>
								<span class="flex-1">0.00</span>
							</div>
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL MEMO RELEASE</span>
									<span>:</span>
								</div>
								<span class="flex-1">1,484.00</span>
							</div>
						</div>
						<div class="d-flex flex-column flex-1">
							<div class="info-display">
								<span class="text-primary-dark">TOTAL RELEASES</span>
								<span class="text-primary-dark">17,000.00</span>
							</div>
						</div>
						<div class="flex-2"></div>
					</div>
			</section>
			<section class="d-flex flex-row mb-72" style="margin-top:auto">
				<span class="flex-2 pb-24 text-bold darker-bb mr-64">Prepared By:</span>
				<span class="flex-2 pb-24 text-bold darker-bb mr-64">Certified Corrected By:</span>
				<span class="flex-2 pb-24 text-bold darker-bb mr-64">Approved By:</span>
				<span class="flex-1"></span>
			</section>
			<div class="d-flex mb-64">
				<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
			</div>
		</div>
		<div class="d-flex flex-row justify-content-between mb-45">
			<a href="#" data-toggle="modal" data-target="#dstModal" class="btn btn-purple min-w-150">Generate DST</a>
			<div class="d-flex flex-row-reverse">
				<a @click="print" href="#" class="btn btn-default min-w-150">Print</a>
				<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
			</div>
		</div>
	</div>

</template>

<script>
export default {
	props:['token', 'branch_id'],
	data(){
		return {
			loading:false,
			ao:[],
			accounts:[],
			filter:{
				date_from: null,
				date_to: null,
				account_officer:'all',
				category:'account_officer',
			},
			totalReleases:{
				newAccount:0,
				newAccountAmount:0,
				repAccount:0,
				repAccountReleased:0,
				totalReleased:0
			}
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
				this.accounts = [];
				this.accounts = response.data.data;
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
		fetchOfficers:function(){
			axios.get(this.baseURL() + 'api/accountofficer', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.ao = response.data.data;
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
		productsReference:function(products){
			if(products.length > 0 && products){
				return products[0].reference;
			}
		},
		newAccounts:function(products){
			var amount = 0;
			products.map(function(val){
				amount += val.new_account;
			});
			return amount;
		},
		newAccountsReleased:function(products){
			var amount = 0;
			products.map(function(val){
				amount += val.new_account_amount;
			});
			return amount;
		},
		repeatAccount:function(products){
			var amount = 0;
			products.map(function(val){
				amount += val.repeat_account;
			});
			return amount;
		},
		repeatAccountReleased:function(products){
			var amount = 0;
			products.map(function(val){
				amount += val.repeat_account_amount;
			});
			return amount;
		}
	},
	watch:{
		filter: {
			handler(val){
				if(val.date_from && val.date_to && val.account_officer){
					this.fetchAccounts();
				}
			},
			deep: true
		}
	},
	computed:{
		accountOfficer:function(){
			var result = '';
			if(this.filter.account_officer != 'all'){
				this.ao.map(function(data){
					if(this.filter.account_officer == data.ao_id){
						result += data.branch.branch_code + ' - ' +data.name;
					}
				}.bind(this));
			}
			return result;
		},
		branchName:function(){
			var result = '';
			if(this.filter.account_officer != 'all'){
				this.ao.map(function(data){
					if(this.filter.account_officer == data.ao_id){
						result += data.branch.branch_name + ' (' + data.branch.branch_code + ')';
					}
				}.bind(this));
			}
			return result;
		},
		totalNewAccounts:function(){
			var amount = 0;
			this.accounts.map(function(val){
				val.products.map(function(val2){
					amount += val2.new_account;
				}.bind(this));
			}.bind(this));
			return amount;
		},
		totalNewAccountsReleased:function(){
			var amount = 0;
			this.accounts.map(function(val){
				val.products.map(function(val2){
					amount += val2.new_account_amount;
				}.bind(this));
			}.bind(this));
			return amount;
		},
		totalRepeatAccount:function(){
			var amount = 0;
			this.accounts.map(function(val){
				val.products.map(function(val2){
					amount += val2.repeat_account;
				}.bind(this));
			}.bind(this));
			return amount;
		},
		totalRepeatAccountReleased:function(){
			var amount = 0;
			this.accounts.map(function(val){
				val.products.map(function(val2){
					amount += val2.repeat_account_amount;
				}.bind(this));
			}.bind(this));
			return amount;
		},
		references:function(){
			var ref = [];
			this.accounts.forEach(a => {
				a.products.forEach(p => {
					if(!ref.includes(p.reference)){
						ref.push(p.reference);
					}
				})
			})
			return ref;
		},
		tableData:function(){
			var totalReleases = {
				newAccount:0,
				newAccountAmount:0,
				repAccount:0,
				repAccountReleased:0,
				totalReleased:0
			};
			var rows = [];
			this.references.forEach(td => {
				var row = [td,0,0,0,0,0];
				this.accounts.forEach(a => {
					a.products.forEach(p => {
						if(td == p.reference){
							row[1] += p.new_account?p.new_account:0;
							row[2] += p.new_account_amount_released?p.new_account_amount_released:0;
							row[3] += p.repeat_account?p.repeat_account:0;
							row[4] += p.repeat_account_amount_released?p.repeat_account_amount_released:0;
							row[5] += p.total_released?p.total_released:0;

							totalReleases.newAccount += p.new_account?p.new_account:0;
							totalReleases.newAccountAmount += p.new_account_amount_released?p.new_account_amount_released:0;
							totalReleases.repAccount += p.repeat_account?p.repeat_account:0;
							totalReleases.repAccountReleased += p.repeat_account_amount_released?p.repeat_account_amount_released:0;
							totalReleases.totalReleased += p.total_released?p.total_released:0;
						}
					});
				});
				row[2] = this.formatToCurrency(row[2]);
				row[4] = this.formatToCurrency(row[4]);
				row[5] = this.formatToCurrency(row[5]);
				rows.push(row);
				this.totalReleases = totalReleases;
			});
			return rows;
		}
	},
	mounted(){
		this.fetchOfficers();
	}
}
</script>