<template>
	<div class="d-flex flex-column" style="flex:8;min-height:1500px;">
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
				<!-- <span class="mr-10">Type: </span>
				<select name="" id="selectProductClient" class="form-control">
					<option value="all_records">All Records</option>
					<option value="new_accounts">New Accounts</option>
					<option value="">By Center</option>
					<option value="">By Product</option>
					<option value="">By Account Officer</option>
				</select> -->
			</div>
			<div class="d-flex flex-row align-items-center" style="flex:2">
				<!-- <span class="mr-10">Spec: </span>
				<select name="" id="selectProductClient" class="form-control">
					<option value="">Allotment Loan</option>
					<option value="">Micro Group</option>
					<option value="">Micro Individual</option>
					<option value="">Pension Emergency</option>
					<option value="">Pension Loan</option>
					<option value="">SME Loan</option>
				</select> -->
			</div>
		</div>
		<div class="sep mb-45"></div>
		<div id="printContent">
			<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">

			<section class="" id="clientSection">
				<div class="d-flex flex-column mb-16">
					<div class="d-flex flex-row align-items-center">
						<div class="flex-1"></div>
						<span class="font-30 text-bold text-primary-dark">CANCELLED PAYMENTS REPORT</span>
						<div class="flex-1" style="padding-left:24px">
							<span class="text-primary-dark mr-10">{{dateFullDay(new Date())}} {{dateToYMD(new Date()).split('-').join('/')}}</span>
							<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
						</div>
					</div>
					<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name + ' Branch (' + branch.branch_code + ')'}}</span>
					<div class="d-flex flex-row justify-content-center text-primary-dark">
						<span class="mr-5">From:</span><span class="mr-16">{{dateToMDY2(new Date(filter.date_from)).split('-').join('/')}}</span>
						<span class="mr-5">To:</span><span>{{dateToMDY2(new Date(filter.date_to)).split('-').join('/')}}</span>
					</div>
				</div>
				<section class="d-flex flex-column mb-72">
					<span class="text-bold bg-yellow-light" style="padding:2px 5px;">RELEASES SUMMARY</span>
					<table class="table td-nb table-thin">
						<thead>
							<th>Date Cancelled</th>
							<th>Cancelled By</th>
							<th>Account No.</th>
							<th>Borrower's Name</th>
							<th>Date Paid</th>
							<th>O.R. #</th>
							<th>Trans. #</th>
							<th>Principal</th>
							<th>Interest</th>
							<th>PDI</th>
							<th>Penalty</th>
							<th>Rebates</th>
							<th>Over Payment</th>
							<th>Total Payment</th>
							<th>Remarks</th>
						</thead>
						<tbody>
							<tr v-if="!accounts.length"><td colspan="4"><i>No records found.</i></td></tr>
							<tr v-for="(a, i) in accounts" :key="i">
								<td>{{a.date_cancelled}}</td>
								<td>{{a.cancelled_by}}</td>
								<td>{{a.account_num}}</td>
								<td>{{a.borrower}}</td>
								<td>{{a.payment_date}}</td>
								<td>{{a.or}}</td>
								<td>{{a.transaction_number}}</td>
								<td>{{formatToCurrency(a.principal)}}</td>
								<td>{{formatToCurrency(a.interest)}}</td>
								<td>{{formatToCurrency(a.pdi)}}</td>
								<td>{{formatToCurrency(a.penalty)}}</td>
								<td>{{formatToCurrency(a.rebates)}}</td>
								<td>{{formatToCurrency(a.overpayment)}}</td>
								<td>{{formatToCurrency(a.total)}}</td>
								<td>{{sentenceCase(a.remarks)}}</td>
							</tr>
							<tr class="border-cell-gray-7">
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr v-if="accounts.length > 0" class="tr-pt-7">
								<td>TOTAL RELEASES</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>{{formatToCurrency(total('principal'))}}</td>
								<td>{{formatToCurrency(total('interest'))}}</td>
								<td>{{formatToCurrency(total('pdi'))}}</td>
								<td>{{formatToCurrency(total('penalty'))}}</td>
								<td>{{formatToCurrency(total('rebates'))}}</td>
								<td>{{formatToCurrency(total('overpayment'))}}</td>
								<td>{{formatToCurrency(total('total'))}}</td>
								<td></td>
							</tr>
						</tbody>
					</table>
					<div v-if="accounts.length > 0" class="d-flex flex-row bg-yellow-pale p-5 align-items-center">
						<div class="d-flex flex-column flex-1 mr-64">
							<div class="d-flex flex-row flex-1 mb-5">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL CASH CANCELLED</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(totalCash)}}</span>
							</div>
							<div class="d-flex flex-row flex-1 mb-5">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL CHECK CANCELLED</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(totalCheck)}}</span>
							</div>
							<div class="d-flex flex-row flex-1 mb-5">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL MEMO CANCELLED</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(totalMemo)}}</span>
							</div>
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL POS CANCELLED</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(totalPos)}}</span>
							</div>
						</div>
						<div class="d-flex flex-column flex-1">
							<div class="info-display">
								<span class="text-primary-dark">TOTAL CANCELLED</span>
								<span class="text-primary-dark">{{formatToCurrency(totalCancelled)}}</span>
							</div>
						</div>
						<div class="flex-2"></div>
					</div>
				</section>
				
			</section>
			<div class="d-flex mb-64" style="margin-top:auto">
				<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
			</div>
		</div>
		
		<div class="d-flex flex-row justify-content-between mb-45">
			<div class="d-flex flex-row-reverse justify-content-start flex-1">
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
			filter:{
				date_from: null,
				date_to: null,
				category:'cancelled',
				branch_id:null,
			},
			branch:{},
			accounts:[],
		}
	},
	methods:{
		fetchAccounts:function(){
			this.filter.branch_id = this.branch.branch_id;
			axios.post(this.baseURL() + 'api/report/repayment', this.filter, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.accounts = response.data;
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
		total:function(val){
			var amount = 0;
			this.accounts.map(function(item){
				amount += parseFloat(item[val]);
			}.bind(this));
			return amount;
		}
	},
	computed:{
		totalCancelled:function(){
			var amount = 0;
			this.accounts.map(function(item){
				amount += parseFloat(item.total)
			}.bind(this));
			return amount;
		},
		totalCash:function(){
			var amount = 0;
			this.accounts.map(function(item){
				console.log(item);
				if(item['payment_type'].toLowerCase().includes('cash')){
					amount += parseFloat(item.total)
				}
			}.bind(this));
			return amount;
		},
		totalCheck:function(){
			var amount = 0;
			this.accounts.map(function(item){
				if(item['payment_type'].toLowerCase().includes('check')){
					amount += parseFloat(item.total)
				}
			}.bind(this));
			return amount;
		},
		totalMemo:function(){
			var amount = 0;
			this.accounts.map(function(item){
				if(item['payment_type'].toLowerCase().includes('memo')){
					amount += parseFloat(item.total)
				}
			}.bind(this));
			return amount;
		},
		totalPos:function(){
			var amount = 0;
			this.accounts.map(function(item){
				if(item['payment_type'].toLowerCase().includes('pos')){
					amount += parseFloat(item.total)
				}
			}.bind(this));
			return amount;
		}
	},
	watch:{
		 filter: {
			handler(val){
				if(val.date_from && val.date_to){
					this.fetchAccounts();
				}
			},
			deep: true
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
		this.total('principal');
	}
}
</script>