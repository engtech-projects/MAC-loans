<template>
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between">
			<h1 class="m-0 font-35">Repayment Entry</h1>
		</div><!-- /.col -->
		<div class="d-flex flex-column flex-xl-row p-16">
			<div style="flex:9;">
				<client-list-side :pborrowers="unpaidBorrowers" :id="{}" @selectBorrower="selectBorrower"></client-list-side>
			</div>
			<repayment-details :ppaymenttype="paymenttype" :pbranch="pbranch" :pborrower="borrower" :token="token"></repayment-details>
		</div>


		
	</div>
</template>

<script>
export default {
	props:['token', 'pbranch','paymenttype'],
	data(){
		return {
			paymentType:'cash',
			borrowers:[],
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
					created_at: this.dateToYMD(new Date()),
					loanAccounts:[],
					loan_accounts:[],
				},				
		}
	},
	methods:{
		fetchBorrowers:function(){
			axios.get(this.baseURL() + 'api/borrower/list/'+this.pbranch, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.borrowers = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		selectBorrower:function(arg1){
			this.unpaidBorrowers.map(function(data){
				if(data.borrower_id == arg1){
					this.borrower = data;
				}
			}.bind(this));
		}
	},
	computed:{
		unpaidBorrowers:function(){
			let filteredData = [];
			this.borrowers.map(function(data){
				let flag = false;
				if(data.loan_accounts){
					data.loan_accounts.map(function(data2){
						if(flag){
							return;
						}
						if(data2.remainingBalance.memo.balance > 0){
							filteredData.push(data);
							flag = true
							return;
						}
					}.bind(this))	
				}
			}.bind(this))
			return filteredData;
		}
	},
	mounted(){
		this.fetchBorrowers();
	},
}
</script>