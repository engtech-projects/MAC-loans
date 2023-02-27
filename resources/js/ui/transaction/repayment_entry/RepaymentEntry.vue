<template>
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between">
			<h1 class="m-0 font-35">Repayment Entry</h1>
		</div><!-- /.col -->
		<div class="d-flex flex-column flex-xl-row p-16" v-if="transactionDate.status == 'open'">
			<div style="flex:9;">
				<client-list-side :pborrowers="unpaidBorrowers" :id="{}" @selectBorrower="selectBorrower"></client-list-side>
			</div>
			<repayment-details @load="loading=true" @unload="loading=false" :ppaymenttype="paymenttype" :pbranch="pbranch" :pborrower="borrower" :token="token"></repayment-details>
		</div>
		<day-ended v-else></day-ended>



	</div>
</template>

<script>
export default {
	props:['token', 'pbranch','paymenttype'],
	data(){
		return {
			loading:false,
			paymentType:'cash',
			borrowers:[],
			transactionDate: {
				branch_id: this.pbranch,
				status: 'closed',
				date_end: '',
			},
			borrower : {
					borrower_id: null,
					date_registered:'',
					borrower_num:'##################',
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
					loan_accounts:[],
				},
		}
	},
	methods:{
		fetchBorrowers:function(){
			this.loading = true;
			axios.get(this.baseURL() + 'api/borrower/list/'+this.pbranch,{params:{onlyunpaid:true}}, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loading = false;
				this.borrowers = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		fetchTransactionDate:function(){
			axios.get(this.baseURL() + 'api/eod/eodtransaction/'+this.pbranch, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.transactionDate = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		selectBorrower:function(arg1){
			this.fetchBorrowerInfo(arg1);
		},
		fetchBorrowerInfo:function(borrower){
			this.loading = true;
			axios.get(this.baseURL() + 'api/borrower/' + borrower, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loading = false;
				this.borrower = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
	},
	computed:{
		unpaidBorrowers:function(){
			return this.borrowers;
		}
	},
	mounted(){
		this.fetchBorrowers();
		this.fetchTransactionDate();
	},
}
</script>

<style lang="scss">
	@-webkit-keyframes rotating /* Safari and Chrome */ {
		from {
			-webkit-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		to {
			-webkit-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		}
		}
		@keyframes rotating {
		from {
			-ms-transform: rotate(0deg);
			-moz-transform: rotate(0deg);
			-webkit-transform: rotate(0deg);
			-o-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		to {
			-ms-transform: rotate(360deg);
			-moz-transform: rotate(360deg);
			-webkit-transform: rotate(360deg);
			-o-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}
	.rotating {
		-webkit-animation: rotating 5s linear infinite;
		-moz-animation: rotating 5s linear infinite;
		-ms-animation: rotating 5s linear infinite;
		-o-animation: rotating 5s linear infinite;
		animation: rotating 5s linear infinite;
	}
	.loading-container {
		position:relative;
		width:300px;height:300px;
		img{
			position:absolute;
			width:300px;height:300px;
			left:0;top:0;
		}
	}
	.loading-text {
		font-size: 24px;
		font-weight: bold;
		color: #ddd;
	}
</style>
