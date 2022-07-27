<template>
	<div class="d-flex flex-column" style="flex:8;min-height:1600px;">
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
					<option v-for="a in ao" :key="a.ao_id" :value="a.ao_id">{{a.name}}</option>
				</select>
			</div>
		</div>
		<div class="sep mb-45"></div>
		<div id="printContent">
			<img src="/img/company_header_fit.png" class="mb-24" alt="">

			<section class="" id="clientSection">
				<div class="d-flex flex-column mb-24">
					<div class="d-flex flex-row align-items-center">
						<div class="flex-1 d-flex flex-column">
							<span>Account Officer</span>
							<span v-if="filter.type!='all'" class="text-bold">{{accountOfficer}}</span>
							<span v-if="filter.type=='all'" class="text-bold">All Records</span>
						</div>
						<span class="font-30 text-bold text-primary-dark">ACCOUNT OFFICER RELEASE SUMMARY REPORT</span>
						<div class="flex-1 d-flex justify-content-end" style="padding-left:24px">
							<span class="text-primary-dark mr-10">{{dateFullDay(new Date())}} {{dateToYMD(new Date()).split('-').join('/')}}</span>
							<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
						</div>
					</div>
					<span v-if="filter.type!='all'" class="text-center text-primary-dark text-bold font-md mb-5">{{branchName}}</span>
					<span v-if="filter.type=='all'" class="text-center text-primary-dark text-bold font-md mb-5">All Branches</span>
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
							<tr v-for="(account, a) in accounts" :key="a">
								<td>{{productsReference(account.products)}}</td>
								<td>{{newAccounts(account.products)}}</td>
								<td>{{formatToCurrency(newAccountsReleased(account.products))}}</td>
								<td>{{repeatAccount(account.products)}}</td>
								<td>{{formatToCurrency(repeatAccountReleased(account.products))}}</td>
								<td>{{formatToCurrency(newAccountsReleased(account.products) + repeatAccountReleased(account.products))}}</td>
								
							</tr>
							<!-- <tr>
								<td>004-Micro Group</td>
								<td>0</td>
								<td>25,214.00</td>
								<td>2</td>
								<td>22,000.00</td>
								<td>22,000.00</td>
								
							</tr>
							<tr>
								<td>005-Salary Loan</td>
								<td>0</td>
								<td>25,214.00</td>
								<td>2</td>
								<td>22,000.00</td>
								<td>22,000.00</td>
								
							</tr> -->
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
								<td>{{totalNewAccounts}}</td>
								<td>{{formatToCurrency(totalNewAccountsReleased)}}</td>
								<td>{{totalRepeatAccount}}</td>
								<td>{{formatToCurrency(totalRepeatAccountReleased)}}</td>
								<td>{{formatToCurrency(totalNewAccountsReleased + totalRepeatAccountReleased)}}</td>
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
				<img src="/img/logo-footer.png" class="w-100" alt="">
			</div>
		</div>
		<div class="d-flex flex-row justify-content-between mb-45">
			<a href="#" data-toggle="modal" data-target="#dstModal" class="btn btn-purple min-w-150">Generate DST</a>
			<div class="d-flex flex-row-reverse">
				<a @click="print" href="#" class="btn btn-default min-w-150">Print</a>
				<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
			</div>
		</div>
	</div>

</template>

<script>
export default {
	props:['token'],
	data(){
		return {
			ao:[],
			accounts:[],
			filter:{
				date_from: null,
				date_to: null,
				type:'all',
				category:'account_officer',
			},
		}
	},
	methods:{
		fetchAccounts:function(){
			axios.post('/api/report/release', this.filter, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.accounts = [];
				this.accounts = response.data.data;
				console.log(response.data);
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		}, 
		fetchOfficers:function(){
			axios.get(this.baserUrl() + '/api/accountofficer', {
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
				if(val.date_from && val.date_to && val.type){
					this.fetchAccounts();
				}
			},
			deep: true
		}
	},
	computed:{
		accountOfficer:function(){
			var result = '';
			if(this.filter.type != 'all'){
				this.ao.map(function(data){
					if(this.filter.type == data.ao_id){
						result += data.branch.branch_code + ' - ' +data.name;
					}
				}.bind(this));
			}
			return result;
		},
		branchName:function(){
			var result = '';
			if(this.filter.type != 'all'){
				this.ao.map(function(data){
					if(this.filter.type == data.ao_id){
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
		}
	},
	mounted(){
		this.fetchOfficers();
	}
}
</script>