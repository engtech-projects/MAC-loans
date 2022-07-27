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
			<img src="/img/company_header_fit.png" class="mb-24" alt="">

			<section class="" id="clientSection">
				<div class="d-flex flex-column mb-16">
					<div class="d-flex flex-row align-items-center">
						<div class="flex-1"></div>
						<span class="font-30 text-bold text-primary-dark">SUMMARY RELEASE BY PRODUCT</span>
						<div class="flex-1" style="padding-left:24px">
							<span class="text-primary-dark mr-10">{{dateFullDay(new Date())}} {{dateToYMD(new Date()).split('-').join('/')}}</span>
							<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
						</div>
					</div>
					<span class="text-center text-primary-dark text-bold font-md mb-5">Butuan Branch (001)</span>
					<div class="d-flex flex-row justify-content-center text-primary-dark">
						<span class="mr-5">From:</span><span class="mr-16">{{dateToMDY2(new Date(filter.date_from)).split('-').join('/')}}</span>
						<span class="mr-5">To:</span><span>{{dateToMDY2(new Date(filter.date_to)).split('-').join('/')}}</span>
					</div>
				</div>
				<section class="d-flex flex-column mb-72">
					<span class="text-bold bg-yellow-light" style="padding:2px 5px;">RELEASES SUMMARY</span>
					<table class="table td-nb table-thin">
						<thead>
							<th>Reference</th>
							<th>Principal</th>
							<th>Interest</th>
							<th>Filing Fee</th>
							<th>Doc. Stamp</th>
							<th>Insurance</th>
							<th>Notarial</th>
							<th>Affidavit</th>
							<th>Deduct Bal</th>
							<th>Prepaid</th>
							<th>Net Proceeds</th>
						</thead>
						<tbody>
							<tr v-for="(a, i) in accounts" :key="i">
								<td>{{a.reference}}</td>
								<td>{{formatToCurrency(a.principal)}}</td>
								<td>{{formatToCurrency(a.interest)}}</td>
								<td>{{formatToCurrency(a.filing_fee)}}</td>
								<td>{{formatToCurrency(a.document_stamp)}}</td>
								<td>{{formatToCurrency(a.insurance)}}</td>
								<td>{{formatToCurrency(a.notarial_fee)}}</td>
								<td>{{formatToCurrency(a.affidavit_fee)}}</td>
								<td>{{formatToCurrency(a.total_deduction)}}</td>
								<td>{{formatToCurrency(a.prepaid_interest)}}</td>
								<td>{{formatToCurrency(a.net_proceeds)}}</td>
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
							</tr>
							<tr v-if="accounts.length > 0" class="tr-pt-7">
								<td>TOTAL RELEASES</td>
								<td>{{formatToCurrency(total('principal'))}}</td>
								<td>{{formatToCurrency(total('interest'))}}</td>
								<td>{{formatToCurrency(total('filing_fee'))}}</td>
								<td>{{formatToCurrency(total('document_stamp'))}}</td>
								<td>{{formatToCurrency(total('insurance'))}}</td>
								<td>{{formatToCurrency(total('notarial_fee'))}}</td>
								<td>{{formatToCurrency(total('affidavit_fee'))}}</td>
								<td>{{formatToCurrency(total('total_deduction'))}}</td>
								<td>{{formatToCurrency(total('prepaid_interest'))}}</td>
								<td>{{formatToCurrency(total('net_proceeds'))}}</td>
							</tr>
						</tbody>
					</table>
					<div v-if="accounts.length > 0" class="d-flex flex-row bg-yellow-pale p-5 align-items-center">
						<div class="d-flex flex-column flex-1 mr-64">
							<div class="d-flex flex-row flex-1 mb-5">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL CASH RELEASE</span>
									<span>:</span>
								</div>
								<span class="flex-1">{{formatToCurrency(totalRelease)}}</span>
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
								<span class="flex-1">0.00</span>
							</div>
						</div>
						<div class="d-flex flex-column flex-1">
							<div class="info-display">
								<span class="text-primary-dark">TOTAL RELEASES</span>
								<span class="text-primary-dark">{{formatToCurrency(totalRelease)}}</span>
							</div>
						</div>
						<div class="flex-2"></div>
					</div>
				</section>
				
			</section>
			<div class="d-flex mb-64" style="margin-top:auto">
				<img src="/img/logo-footer.png" class="w-100" alt="">
			</div>
		</div>
		
		<div class="d-flex flex-row justify-content-between mb-45">
			<div class="d-flex flex-row-reverse justify-content-start flex-1">
				<a @click="print()" href="#" class="btn btn-default min-w-150">Print</a>
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
			filter:{
				date_from: null,
				date_to: null,
				type:'by_product',
				spec:0,
				category:'product',
			},
			accounts:[],
		}
	},
	methods:{
		fetchAccounts:function(){
			axios.post('api/report/release', this.filter, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.accounts = response.data.data;
				console.log(response.data);
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
		totalRelease:function(){
			var amount = 0;
			this.accounts.map(function(item){
				amount += parseFloat(item.net_proceeds)
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
		this.total('principal');
	}
}
</script>