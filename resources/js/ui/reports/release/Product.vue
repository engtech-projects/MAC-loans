<template>
	<div class="d-flex flex-column justify-content-between" style="flex:8;min-height:100vh;">
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px;">
			</div>
			<span class="font-lg" style="color:#ddd;">Please wait until the process is complete</span>
		</div>
		<div>
			<form ref="reportForm" @submit.prevent="generateReport" class="d-flex flex-row font-md align-items-center mb-16 needs-validation report-form" novalidate>
				<span class="font-lg text-primary-dark" style="flex:3">Release - Product </span>
				<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
					<span class="mr-10">From: </span>
					<input v-model="filter.date_from" type="date" class="form-control" required>
				</div>
				<div class="d-flex flex-row align-items-center" style="flex:2">
					<span class="mr-10">To: </span>
					<input v-model="filter.date_to" type="date" class="form-control" required>
				</div>
				
				<div class="d-flex align-items-center mt-6">
					<span class="mr-10"> </span>
					<button @click="generateReport" class="btn btn-primary">
						Generate
					</button>
				</div> 

			

			</form>
			<div class="sep mb-45"></div>
			<div id="printContent">
				<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">

				<section class="" id="clientSection">
					<div class="d-flex flex-column mb-16">
						<div class="d-flex flex-row align-items-center">
							<div class="flex-1"></div>
							<span class="font-30 text-bold text-primary-dark">SUMMARY RELEASE BY PRODUCT</span>
							<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
								<current-transactiondate :branch="branch.branch_id" :token="token" :reports="true" @update-transaction-date="setTransactionDate"></current-transactiondate>
								<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
							</div>
						</div>
						<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name + ' Branch (' + branch.branch_code + ')'}}</span>
						<div class="d-flex flex-row justify-content-center text-primary-dark">
							<span class="mr-5">From:</span><span class="mr-16">{{filter.date_from?filter.date_from:'---'}}</span>
							<span class="mr-5">To:</span><span>{{filter.date_to?filter.date_to:'---'}}</span>
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
									<td>{{formatToCurrency(a.release.principal)}}</td>
									<td>{{formatToCurrency(a.release.interest)}}</td>
									<td>{{formatToCurrency(a.release.filing_fee)}}</td>
									<td>{{formatToCurrency(a.release.document_stamp)}}</td>
									<td>{{formatToCurrency(a.release.insurance)}}</td>
									<td>{{formatToCurrency(a.release.notarial_fee)}}</td>
									<td>{{formatToCurrency(a.release.affidavit_fee)}}</td>
									<td>{{formatToCurrency(a.release.memo)}}</td>
									<td>{{formatToCurrency(a.release.prepaid_interest)}}</td>
									<td>{{formatToCurrency(a.release.net_proceeds)}}</td>
								</tr>
								<tr v-if="accounts.length == 0">
									<td><i>No accounts on the list.</i></td>
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
									<td>{{formatToCurrency(total('memo'))}}</td>
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
									<span class="flex-1">{{formatToCurrency(total('cash'))}}</span>
								</div>
								<div class="d-flex flex-row flex-1 mb-5">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1">TOTAL CHECK RELEASE</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(total('check'))}}</span>
								</div>
								<div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1">TOTAL MEMO RELEASE</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(total('memo'))}}</span>
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
				type:'by_product',
				spec:0,
				category:'product',
			},
			branch:{
				branch_id:'',
				branch_name:''
			},
			accounts:[],
		}
	},
	methods:{
		generateReport(){
			const { date_from, date_to} = this.filter;
			const form = this.$refs.reportForm;

				if (!form.checkValidity()) {
					form.reportValidity(); // Show native browser tooltips
					return;
				}

				// Prepare payload
				const payload = {
					date_from,
					date_to,
				
				};
				this.fetchAccounts(payload);
		},
		fetchAccounts:function(){
			this.loading = true;
			this.filter.branch_id = this.branch.branch_id;
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
				console.log(response.data);
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
		print:function(){
			var content = document.getElementById('printContent').innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			window.print();
		},
		total:function(val){
			var amount = 0;
			this.accounts.map(function(item){
				amount += parseFloat(item['release'][val]);
			}.bind(this));
			return amount;
		}
	},
	computed:{
		totalRelease:function(){
			return this.total('cash') + this.total('check');
		},
		
	},
	watch:{
		 filter: {
			handler(val){
				// if(val.date_from && val.date_to){
				// 	this.fetchAccounts();
				// }
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

<style>
	/* Style invalid required inputs */
	.report-form input:required:invalid,
	.report-form select:required:invalid {
		border-color: red;
		background-color: #fff5f5;
	}

	/* Optional: remove ugly default outline in some browsers */
	.report-form input:focus:invalid,
	.report-form select:focus:invalid {
		outline: none;
		box-shadow: 0 0 5px red;
	}
</style>