<template>
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between">
			<h1 class="m-0 font-35">Repayment Entry</h1>
			<a href="#" @click.prevent="clearData.borrower=1;resetLoanDetails()" class="btn btn-primary-dark min-w-150">New Client</a>
		</div><!-- /.col -->
		<div class="d-flex flex-column flex-xl-row p-16">
			<div style="flex:9;">
				<client-list-side :pborrowers="borrowers" :id="{}" @selectBorrower="selectBorrower"></client-list-side>
			</div>
			<repayment-details :pborrower="borrower" :token="token"></repayment-details>
		</div>


		
	</div>
</template>

<script>
export default {
	props:['token'],
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
				},				
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
				this.borrowers = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		selectBorrower:function(arg1){
			this.borrowers.map(function(data){
				if(data.borrower_id == arg1){
					this.borrower = data;
				}
			}.bind(this));
		}
	},
	mounted(){
		this.fetchBorrowers();
	}
}
</script>