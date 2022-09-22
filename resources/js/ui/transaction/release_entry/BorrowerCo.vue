<template>
	<div class="tab-pane fade" id="custom-content-below-coborrowerinfo" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
		<form action="" @submit.prevent="navigate('custom-content-below-loandetails-tab')">
		<div class="d-flex flex-column">
			<section class="mb-24" style="flex:21;padding-left:16px;">
				<span class="section-title mb-24">Co-Borrower's Information</span>
				<div class="d-flex flex-row">
					<div class="form-group mb-10 relative" style="flex:1">
						<label for="coFullname" class="form-label">Full Name</label>
						<input required @keyup="searchMode=true" type="text" v-model="loanDetails.co_borrower_name" class="form-control form-input " id="coFullname">
						<div class="d-flex flex-column light-border" v-if="loanDetails.co_borrower_name.length > 2 && searchMode" style="box-shadow:2px 2px 7px rgba(0,0,0, .1)">
							<span @click="setCoborrower(b)" v-for="b in searchBorrower" :key="b.borrower_id" class="p-10 light-bb b-item">{{b.firstname +  ' ' + b.lastname}}</span>
						</div>
					</div>
				</div>
				<div class="form-group mb-10" style="flex: 3">
					<label for="spouseAddress  " class="form-label">Address</label>
					<input required v-model="loanDetails.co_borrower_address" type="text" class="form-control form-input " id="spouseAddress  ">
				</div>
				<div class="d-flex flex-row">
					<div class="form-group mb-10 mr-16" style="flex: 3">
						<label for="coIdType" class="form-label">ID Type</label>
						<select v-model="loanDetails.co_borrower_id_type" required name="" id="" class="form-control form-input">
							<option v-for="i in idtype" :key="i" :value="i">{{i}}</option>
							<!-- <option value="UMID">GSIS/UMID</option>
							<option value="Driver's License">Driver's License</option>
							<option value="Passport">Passport</option>
							<option value="Senior ID">Senior ID</option> -->
						</select>
					</div>
					<div class="form-group mb-10 mr-16" style="flex: 3">
						<label for="coIdNumber" class="form-label">ID Number</label>
						<input required v-model="loanDetails.co_borrower_id_number" type="text" class="form-control form-input " id="coIdNumber">
					</div>
					<div class="form-group mb-10 mr-16" style="flex: 3">
						<label for="coIdDate" class="form-label">ID Date Issued</label>
						<input required v-model="loanDetails.co_borrower_id_date_issued" type="date" class="form-control form-input " id="coIdDate">
					</div>
					<div style="flex: 3"></div>
				</div>
			</section>

			<section class="mb-24" style="flex:21;padding-left:16px;">
				<span class="section-title mb-24">Co-Maker's Information</span>
				<div class="d-flex flex-row">
					<div class="form-group mb-10" style="flex:1">
						<label for="coFullname" class="form-label">Full Name</label>
						<input v-model="loanDetails.co_maker_name" required type="text" class="form-control form-input " id="coFullname">
					</div>
				</div>
				<div class="form-group mb-10" style="flex: 3">
					<label for="spouseAddress  " class="form-label">Address</label>
					<input v-model="loanDetails.co_maker_address" required type="text" class="form-control form-input " id="spouseAddress  ">
				</div>
				<div class="d-flex flex-row">
					<div class="form-group mb-10 mr-16" style="flex: 3">
						<label for="coIdType" class="form-label">ID Type</label>
						<select v-model="loanDetails.co_maker_id_type" required name="" id="" class="form-control form-input">
							<option v-for="i in idtype" :key="i" :value="i">{{i}}</option>
						</select>
					</div>
					<div class="form-group mb-10 mr-16" style="flex: 3">
						<label for="coIdNumber" class="form-label">ID Number</label>
						<input v-model="loanDetails.co_maker_id_number" required type="text" class="form-control form-input " id="coIdNumber">
					</div>
					<div class="form-group mb-10 mr-16" style="flex: 3">
						<label for="coIdDate" class="form-label">ID Date Issued</label>
						<input v-model="loanDetails.co_maker_id_date_issued" required type="date" class="form-control form-input " id="coIdDate">
					</div>
					<div style="flex: 3"></div>
				</div>
			</section>

			<div class="d-flex flex-row-reverse mb-45">
				<!-- <a @click.prevent="navigate('custom-content-below-loandetails-tab')" href="#" data-tab="custom-content-below-loandetails-tab" class="btn btn-success tab-navigate" style="flex:2">Next</a> -->
				<button class="btn btn-success flex-2">Next</button>
				<a @click.prevent="navigate('custom-content-below-borrowerinfo-tab')" href="#" data-tab="custom-content-below-borrowerinfo-tab" class="btn btn-primary-dark mr-24 tab-navigate" style="flex:2">Back</a>
				<div style="flex:22"></div>
			</div>
		</div>
		</form>
	</div>
</template>
<script>
export default {
	props:['loandetails', 'borrowers', 'idtype','pborrower'],
	data(){
		return {
			searchMode:true,
			loanDetails: {
				cycle_no : 1,
				ao_id : '',
				product_id : '',
				center_id : '',
				type : '',
				payment_mode : '',
				terms : '',
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
				document_stamp : '',
				filing_fee : '',
				insurance : '',
				notarial_fee : '100.00',
				prepaid_interest : '',
				affidavit_fee : '',
				memo : '',
				total_deduction : '',
				net_proceeds : '',
				release_type : ''
			}
		}
	},
	methods:{
		navigate:function(tab){
			this.$emit('update-loan-details', this.loanDetails);
			document.getElementById(tab).click();
		},
		search:function(fullname){
			if(this.loanDetails.co_borrower_name.length > 1){
				if(fullname.toLowerCase().includes(this.loanDetails.co_borrower_name.toLowerCase())){
					return true;
				}
			}
			return false;
		},
		// setCoborrower:function(borrower){
		// 	this.loanDetails.co_borrower_name = borrower.firstname + ' ' + borrower.lastname;
		// 	this.loanDetails.co_borrower_address = borrower.address;
		// 	this.loanDetails.co_borrower_id_type = borrower.id_type;
		// 	this.loanDetails.co_borrower_id_number = borrower.id_no;
		// 	this.loanDetails.co_borrower_id_date_issued = borrower.id_date_issued;
		// 	this.searchMode = false;
		// },
		setCoBorrower:function(){
			this.loanDetails.co_borrower_name = this.pborrower.spouse_firstname + ' ' + this.pborrower.spouse_middlename.charAt(0) + '. ' + this.pborrower.spouse_lastname;
			this.loanDetails.co_borrower_address = this.pborrower.spouse_address;
			this.loanDetails.co_borrower_id_type = this.pborrower.spouse_id_type;
			this.loanDetails.co_borrower_id_number = this.pborrower.spouse_id_no;
			this.loanDetails.co_borrower_id_date_issued = this.pborrower.spouse_id_date_issued;
		}
	},
	watch: {
		'loandetails'(newValue) {
			this.loanDetails = newValue;
		},
		'pborrower.status'(newValue){
			if(newValue == 'married'){
				this.setCoBorrower();
			}
		},
		'pborrower.borrower_id'(newValue){
			if(this.pborrower.status == 'married'){
				this.setCoBorrower();
			}
		}
	},
	computed:{
		searchBorrower: function () {
			return this.borrowers.filter(i => i.firstname.toLowerCase().includes(this.loanDetails.co_borrower_name.toLowerCase()) || i.lastname.toLowerCase().includes(this.loanDetails.co_borrower_name.toLowerCase()));
		},
	},
	mounted(){
		this.loanDetails = this.loandetails;
	}
}
</script>

<style lang="scss" scoped>
	.b-item:hover {
		color:#3498db;
		cursor: pointer;
		background-color: #fafafa;
	}
</style>