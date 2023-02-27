<template>
	<div class="d-flex flex-column">
		<notifications group="foo" />
		<form action="" id="borrowerForm" @submit.prevent="navigate()">
		<section class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Borrower's Basic Information</span>
			<div class="d-flex">
				<div class="d-flex flex-column mr-16" style="flex:20;">
					<div class="d-flex flex-row">
						<div class="borrower-number d-flex flex-column" style="flex: 5">
							<span>Borrower's Number</span>
							<span v-if="borrower.borrower_num == ''" class="text-center">##############</span>
							<span v-if="borrower.borrower_num != ''" class="text-center">{{borrower.borrower_num}}</span>
						</div>
						<div style="flex:4"></div>
						<div class="form-group mb-10" style="flex: 5">
							<label for="regDate" class="form-label">Date Registration</label>
							<input type="date" disabled v-model="borrower.date_registered" class="form-control form-input text-right" id="regDate">
						</div>
					</div>
					<div class="form-group mb-10" style="flex: 5">
						<label for="firstName" class="form-label">First Name</label>
						<input v-model="borrower.firstname" required type="text" class="form-control form-input " id="firstName">
					</div>
					<div class="form-group mb-10" style="flex: 5">
						<label for="middleName" class="form-label">Middle Name</label>
						<input v-model="borrower.middlename" required type="text" class="form-control form-input " id="middleName">
					</div>
				</div>
				<div class="upload-photo d-flex flex-column" style="flex:4">
					<img :src="borrowerPhoto" alt="" style="max-width:250px;">
					<a v-if="!loan_id" href="#" data-toggle="modal" data-target="#uploadModal" class="btn btn-primary" style="padding:10px!important">Upload or Take a Photo</a>
				</div>
			</div>
			<div class="d-flex flex-row">
				<div class="form-group mb-10 mr-16" style="flex: 25">
					<label for="lastName" class="form-label">Last Name</label>
					<input v-model="borrower.lastname" required type="text" class="form-control form-input " id="lastName">
				</div>
				<div class="form-group mb-10" style="flex: 6">
					<label for="suffix" class="form-label">Suffix</label>
					<input v-model="borrower.suffix" type="text" class="form-control form-input " id="suffix">
				</div>
			</div>
			<div class="form-group mb-10">
				<label for="address" class="form-label">Address</label>
				<input v-model="borrower.address" required type="text" class="form-control form-input " id="address">
			</div>
			<div class="d-flex flex-row">
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="birthdate" class="form-label">Birth Date</label>
					<input v-model="borrower.birthdate" required type="date" class="form-control form-input " id="birthdate">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="sex" class="form-label">Gender</label>
					<select v-model="borrower.gender" required name="" id="" class="form-control form-input">
						<option value="male">Male</option>
						<option value="female">Female</option>
					</select>
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="status" class="form-label">Status</label>
					<select v-model="borrower.status" required name="" id="" class="form-control form-input">
						<option value="single">Single</option>
						<option value="married">Married</option>
						<option value="live-in">Live-In</option>
						<option value="widowed">Widowed</option>
						<option value="separated">Separated</option>
					</select>
				</div>
				<div class="form-group mb-10" style="flex: 6">
					<label for="contactNumber" class="form-label">Contact Number</label>
					<input v-model="borrower.contact_number" required type="text" class="form-control form-input " id="contactNumber">
				</div>
			</div>
		</section>

		<section class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Borrower's Identification Details</span>

			<div class="d-flex flex-row">
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="idType" class="form-label">ID Type</label>
					<input v-model="borrower.id_type" required type="text" class="form-control form-input " id="borrowerIdType">
					<select v-if="1==2" v-model="borrower.id_type" required name="" id="" class="form-control form-input">
						<option v-for="i in idtype" :key="i" :value="i">{{i}}</option>
					</select>
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="idNumber" class="form-label">ID Number</label>
					<input v-model="borrower.id_no" required type="text" class="form-control form-input " id="idNumber">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="idDate" class="form-label">ID Date Issued</label>
					<input v-model="borrower.id_date_issued" required type="date" class="form-control form-input " id="idDate">
				</div>
				<div style="flex: 3"></div>
			</div>
		</section>

		<section v-if="borrower.status.toLowerCase()=='married'||borrower.status.toLowerCase()=='live-in'" class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Borrower's Spouse Information</span>

			<div class="d-flex flex-row">
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="spouseFirstName" class="form-label">First Name</label>
					<input v-model="borrower.spouse_firstname" type="text" required class="form-control form-input " id="spouseFirstName">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="spouseMiddleName" class="form-label">Middle Name</label>
					<input v-model="borrower.spouse_middlename" type="text" required class="form-control form-input " id="spouseMiddleName">
				</div>
				<div class="form-group mb-10" style="flex: 3">
					<label for="spouseLastName" class="form-label">Last Name</label>
					<input v-model="borrower.spouse_lastname" type="text" required class="form-control form-input " id="spouseLastName">
				</div>
			</div>
			<div class="form-group mb-10" style="flex: 3">
				<label for="spouseAddress  " class="form-label">Address</label>
				<input v-model="borrower.spouse_address" type="text" required class="form-control form-input " id="spouseAddress  ">
			</div>
			<div class="d-flex flex-row">
				<div class="form-group mb-10 mr-16" style="flex: 2">
					<label for="spouseBirthdate" class="form-label">Birth Date</label>
					<input v-model="borrower.spouse_birthdate" type="date" required class="form-control form-input " id="spouseBirthdate">
				</div>
				<div class="form-group mb-10" style="flex:2">
					<label for="spouseContactNumber" class="form-label">Contact Number</label>
					<input v-model="borrower.spouse_contact_number" type="text" required class="form-control form-input " id="spouseContactNumber">
				</div>
			</div>
		</section>

		<section v-if="borrower.status.toLowerCase()=='married'||borrower.status.toLowerCase()=='live-in'" class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Borrower's Spouse Identification Details</span>

			<div class="d-flex flex-row">
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="spouseIdType" class="form-label">ID Type</label>
					<input v-model="borrower.spouse_id_type" required type="text" class="form-control form-input " id="spouseIdType">
					<select v-if="1==2" v-model="borrower.spouse_id_type" name="" id="" required class="form-control form-input">
						<option v-for="i in idtype" :key="i" :value="i">{{i}}</option>
					</select>
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="spouseIdNumber" class="form-label">ID Number</label>
					<input v-model="borrower.spouse_id_no" type="text" required class="form-control form-input " id="spouseIdNumber">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="spouseIdDate" class="form-label">ID Date Issued</label>
					<input v-model="borrower.spouse_id_date_issued" type="date" required class="form-control form-input " id="spouseIdDate">
				</div>
				<div style="flex: 3"></div>
			</div>
		</section>
		<input type="submit" id="borrowerBtn" class="btn btn-default hide">
		</form>
		<section class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Household Members Information</span>
			<div class="d-flex flex-column mb-16">
				<form action="" @submit.prevent="addData('householdMembers')">
				<div class="d-flex">
					<div class="form-group mb-10 mr-16" style="flex: 2">
						<label for="nameOfDependent" class="form-label">Name of Dependent</label>
						<input required v-model="data.householdMembers.dependent" type="text" class="form-control form-input " id="nameOfDependent">
					</div>
					<div class="form-group mb-10 mr-16" style="flex: 1">
						<label for="ageofDependent" class="form-label">Age</label>
						<input required v-model="data.householdMembers.age" type="text" class="form-control form-input " id="ageofDependent">
					</div>
					<div class="form-group mb-10 mr-16" style="flex: 1">
						<label for="relationshipOfDependent" class="form-label">Relationship</label>
						<input required v-model="data.householdMembers.relationship" type="text" class="form-control form-input " id="relationshipOfDependent">
					</div>
					<div class="form-group mb-10" style="flex: 1">
						<label for="OccupationOfDependent" class="form-label">Occupation</label>
						<input required v-model="data.householdMembers.occupation" type="text" class="form-control form-input " id="OccupationOfDependent">
					</div>
				</div>

				<div class="d-flex">
					<div class="form-group mb-10 mr-16" style="flex: 1">
						<label for="contactOfDepenent" class="form-label">Contact #</label>
						<input required v-model="data.householdMembers.contact_no" type="text" class="form-control form-input " id="contactOfDepenent">
					</div>
					<div class="form-group mb-10 mr-16" style="flex: 3">
						<label for="addressDependent" class="form-label">School/Business/Employment Address</label>
						<input required v-model="data.householdMembers.sbe_address" type="text" class="form-control form-input " id="addressDependent">
					</div>
					<div class="form-group mb-10 d-flex flex-column justify-content-end">
						<button class="btn btn-success d-flex align-items-center" style="height:48px"><i class="fa fa-plus"></i></button>
					</div>
				</div>
				</form>
			</div>
		</section>

		<section v-if="borrower.householdMembers.length > 0" class="mb-24" style="padding-left:16px;">
			<table class="table table-stripped base-table">
				<thead>
					<th>Name of Dependent</th>
					<th>Age</th>
					<th>Relationship</th>
					<th>Occupation</th>
					<th>Contact No.</th>
					<th>School/Business/Employment Address</th>
					<th></th>
				</thead>
				<tbody>
					<tr v-for="(hm, i) in borrower.householdMembers" :key="i">
						<td>{{hm.dependent}}</td>
						<td>{{hm.age}}</td>
						<td>{{hm.relationship}}</td>
						<td>{{hm.occupation}}</td>
						<td>{{hm.contact_no}}</td>
						<td>{{hm.sbe_address}}</td>
						<td><a href="#" @click.prevent="setData('householdMembers',i,hm.id)" data-toggle="modal" data-target="#deleteWarningModal" class="text-red font-small">Delete</a></td>
					</tr>
				</tbody>
			</table>
		</section>

		<section class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Outstanding Obligation from Other Creditors</span>
			<form action="" @submit.prevent="addData('outstandingObligations')">
			<div class="d-flex">
				<div class="form-group mb-10 mr-16" style="flex: 1">
					<label for="nameOfCompany" class="form-label">Name of Creditor</label>
					<input v-model="data.outstandingObligations.creditor" required type="text" class="form-control form-input " id="nameOfCompany">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 1">
					<label for="companyContact" class="form-label">Loan Amount</label>
					<input v-model="data.outstandingObligations.amount" required type="number" class="form-control form-input " id="companyContact">
				</div>
				<div class="form-group mb-10" style="flex: 1">
					<label for="companyYears" class="form-label">Outstanding Balance</label>
					<input v-model="data.outstandingObligations.balance" required type="number" class="form-control form-input " id="companyYears">
				</div>
			</div>

			<div class="d-flex">
				<div class="form-group mb-10 mr-16" style="flex: 1">
					<label for="companyAddress" class="form-label">Term</label>
					<input v-model="data.outstandingObligations.term" required type="text" class="form-control form-input " id="companyAddress">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 1">
					<label for="companyPosition" class="form-label">Due Date</label>
					<input v-model="data.outstandingObligations.due_date" required type="date" class="form-control form-input " id="companyPosition">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 1">
					<label for="companySalary" class="form-label">Amortization / Frequency</label>
					<input v-model="data.outstandingObligations.amortization" required type="text" class="form-control form-input " id="companySalary">
				</div>
				<div class="form-group mb-10 d-flex flex-column justify-content-end">
					<button class="btn btn-success d-flex align-items-center" style="height:48px"><i class="fa fa-plus"></i></button>
				</div>

			</div>
			</form>
		</section>

		<section v-if="borrower.outstandingObligations.length > 0" class="mb-24" style="padding-left:16px;">
			<table class="table table-stripped base-table">
				<thead>
					<th>Name of Creditor</th>
					<th>Term</th>
					<th>Due Date</th>
					<th>Loan Amount</th>
					<th>Outstanding Bal.</th>
					<th>Amort./ Freq.</th>
					<th></th>
				</thead>
				<tbody>
					<tr v-for="(bo, i) in borrower.outstandingObligations" :key="i">
						<td>{{bo.creditor}}</td>
						<td>{{bo.term}}</td>
						<td>{{bo.due_date}}</td>
						<td>{{bo.amount}}</td>
						<td>{{bo.balance}}</td>
						<td>{{bo.amortization}}</td>
						<td><a href="#" @click.prevent="setData('outstandingObligations',i,bo.id)" data-toggle="modal" data-target="#deleteWarningModal" class="text-red font-small">Delete</a></td>
					</tr>
				</tbody>
			</table>
		</section>


		<section class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Employment Information</span>
			<form action="" @submit.prevent="addData('employmentInfo')">
			<div class="d-flex">
				<div class="form-group mb-10 mr-16" style="flex: 2">
					<label for="nameOfCompany" class="form-label">Name of Company</label>
					<input v-model="data.employmentInfo.company_name" required type="text" class="form-control form-input " id="nameOfCompany">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 2">
					<label for="companyContact" class="form-label">Contact No.</label>
					<input v-model="data.employmentInfo.contact_no" required type="text" class="form-control form-input " id="companyContact">
				</div>
				<div class="form-group mb-10" style="flex: 1">
					<label for="companyYears" class="form-label">Years</label>
					<input v-model="data.employmentInfo.years_employed" required type="number" class="form-control form-input " id="companyYears">
				</div>
			</div>

			<div class="d-flex">
				<div class="form-group mb-10 mr-16" style="flex: 2">
					<label for="companyAddress" class="form-label">Address</label>
					<input v-model="data.employmentInfo.company_address" required type="text" class="form-control form-input " id="companyAddress">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 2">
					<label for="companyPosition" class="form-label">Position</label>
					<input v-model="data.employmentInfo.position" required type="text" class="form-control form-input " id="companyPosition">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 1">
					<label for="companySalary" class="form-label">Monthly Salary</label>
					<input v-model="data.employmentInfo.salary" required type="number" class="form-control form-input " id="companySalary">
				</div>
				<div class="form-group mb-10 d-flex flex-column justify-content-end">
					<button class="btn btn-success d-flex align-items-center" style="height:48px"><i class="fa fa-plus"></i></button>
				</div>
			</div>
			</form>
		</section>

		<section v-if="borrower.employmentInfo.length > 0" class="mb-24" style="padding-left:16px;">
			<table class="table table-stripped base-table">
				<thead>
					<th>Name of Business/Agency</th>
					<th>Address</th>
					<th>Contact No.</th>
					<th>Years</th>
					<th>Position</th>
					<th>Monthly Sal.</th>
					<th></th>
				</thead>
				<tbody>
					<tr v-for="(emp, i) in borrower.employmentInfo" :key="i">
						<td>{{emp.company_name}}</td>
						<td>{{emp.company_address}}</td>
						<td>{{emp.contact_no}}</td>
						<td>{{emp.years_employed}}</td>
						<td>{{emp.position}}</td>
						<td>P {{emp.salary}}</td>
						<td><a href="#" @click.prevent="setData('employmentInfo',i,emp.id)" data-toggle="modal" data-target="#deleteWarningModal" class="text-red font-small">Delete</a></td>
					</tr>
				</tbody>
			</table>
		</section>

		<section class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Borrower's Business</span>
			<form action=""  @submit.prevent="addData('businessInfo')">
			<div class="d-flex">
				<div class="form-group mb-10 mr-16" style="flex: 2">
					<label for="businessName" class="form-label">Name of Business / Agency</label>
					<input v-model="data.businessInfo.business_name" required type="text" class="form-control form-input " id="businessName">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 2">
					<label for="companyContact" class="form-label">Contact No.</label>
					<input v-model="data.businessInfo.contact_no" required type="text" class="form-control form-input " id="companyContact">
				</div>
				<div class="form-group mb-10" style="flex: 1">
					<label for="companyYears" class="form-label">Years</label>
					<input v-model="data.businessInfo.years_in_business" required type="number" class="form-control form-input " id="companyYears">
				</div>
			</div>
			<div class="d-flex">
				<div class="form-group mb-10 mr-16" style="flex: 2">
					<label for="businessAddress" class="form-label">Address</label>
					<input v-model="data.businessInfo.business_address" required type="text" class="form-control form-input " id="businessAddress">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 1">
					<label for="businessIncome" class="form-label">Income / Frequency</label>
					<input v-model="data.businessInfo.income" required type="text" class="form-control form-input " id="businessIncome">
				</div>
				<div class="form-group mb-10 d-flex flex-column justify-content-end">
					<button class="btn btn-success d-flex align-items-center" style="height:48px"><i class="fa fa-plus"></i></button>
				</div>
			</div>
			</form>
		</section>

		<section v-if="borrower.businessInfo.length > 0" class="mb-24" style="padding-left:16px;">
			<table class="table table-stripped base-table">
				<thead>
					<th>Name of Business/Agency</th>
					<th>Address</th>
					<th>Contact No.</th>
					<th>Years</th>
					<th>Income / Frequency</th>
				</thead>
				<tbody>
					<tr v-for="(biz, i) in borrower.businessInfo" :key="i">
						<td>{{biz.business_name}}</td>
						<td>{{biz.business_address}}</td>
						<td>{{biz.contact_no}}</td>
						<td>{{biz.years_in_business}}</td>
						<td>P {{biz.income}}</td>
						<td><a href="#" @click.prevent="setData('businessInfo',i,biz.id)" data-toggle="modal" data-target="#deleteWarningModal" class="text-red font-small">Delete</a></td>
					</tr>
				</tbody>
			</table>
		</section>

		<div class="d-flex flex-row-reverse">
			<a v-if="!pclient" @click.prevent="submitForm()" href="#custom-content-below-coborrowerinfo" data-tab="custom-content-below-coborrowerinfo-tab" class="btn btn-success tab-navigate" style="flex:2">Next</a>
			<a v-if="pclient" @click.prevent="submitForm()" href="#custom-content-below-coborrowerinfo" data-tab="custom-content-below-coborrowerinfo-tab" class="btn btn-success tab-navigate" style="flex:2">Save</a>
			<!-- <a href="#" @click.prevent="clearInfo()" class="btn btn-yellow-light min-w-150 mr-16">Clear Info</a> -->
			<div style="flex:22"></div>
		</div>
		<upload-file @imageCapture="imageCapture"/>


		<div class="modal" id="deleteWarningModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-body p-24">
						<div class="d-flex align-items-center">
							<img :src="baseURL()+'/img/warning.png'" style="width:120px;height:auto;" class="mr-24" alt="warning icon">
							<div class="d-flex flex-column">
								<span class="text-primary-dark text-bold mb-24">
									Are you sure you want to delete this info?
								</span>
								<div class="d-flex mt-auto justify-content-end">
									<a @click.prevent="deleteOtherInfo()" href="#" data-dismiss="modal" class="btn btn-primary-dark min-w-120 btn-wide mr-24">YES</a>
									<a href="#" data-dismiss="modal" class="btn btn-danger min-w-120 pull-right btn-wide mr-24">NO</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props:['token','pborrower', 'psave','clear','pclient','borrower_id', 'idtype', 'loan_id', 'transactionDate'],
		data(){
			return {
				baseUrl: this.baseURL(),
				img: null,
				otherInfo:{
					type:'',
					index:null,
					id:null
				},
				borrower: {
					borrower_id: null,
					date_registered:'',
					borrower_num:'',
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
				},
				data: {
					outstandingObligations: {
						id: null,
						creditor : '',
						amount : 0,
						balance : 0,
						term : '',
						due_date : '',
						amortization : ''
					},
					householdMembers: {
						id: null,
						dependent : '',
						age : 0,
						relationship : '',
						occupation : '',
						contact_no : '',
						sbe_address : ''
					},
					employmentInfo: {
						id : null,
						company_name : '' ,
						company_address : '' ,
						contact_no : '' ,
						years_employed : '' ,
						position : '' ,
						salary : ''
					},
					businessInfo: {
						id: null,
						business_name :'',
						business_type : '',
						business_address : '',
						contact_no : '',
						years_in_business : '',
						income : '',
					}
				}
			}
		},
		methods: {
			fetchBorrower:function(){
				axios.get(this.baseURL() + 'api/borrower/' + this.borrower_id, {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.borrower = response.data.data;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
			save: function(){
				this.borrower.img = this.img;
				this.$emit('load')
				// this.borrower.username = this.borrower.firstname+this.borrower.lastname;
				// this.borrower.password = "$2y$10$BrOxloCXFGB4PyCPe7.leefLeosAh9zpS1DCdGlfz8XRyNIkgeHlO";
				delete this.borrower.username;
				delete this.borrower.password;
				if(this.borrower.borrower_id){
						axios.put(this.baseURL() + 'api/borrower/' + this.borrower.borrower_id, this.borrower, {
							headers: {
								'Authorization': 'Bearer ' + this.token,
								'Content-Type': 'application/json',
								'Accept': 'application/json'
							}
						})
						.then(function (response) {
							this.$emit('unload')
							this.notify('',response.data.message, 'success');
							this.$emit('savedInfo', response.data.data)
							console.log(response.data);
						}.bind(this))
						.catch(function (error) {
							console.log(error);
							this.$emit('unload')
						}.bind(this));
				}else {
					this.$emit('load')
					axios.post(this.baseURL() + 'api/borrower', this.borrower, {
						headers: {
							'Authorization': 'Bearer ' + this.token,
							'Content-Type': 'aMpplication/json',
							'Accept': 'application/json'
						}
					})
					.then(function (response) {
						this.$emit('unload')
						this.notify('',response.data.message, 'success');
						this.$emit('savedInfo', response.data.data)
						console.log(response.data);
					}.bind(this))
					.catch(function (error) {
						console.log(error);
						this.$emit('unload')
					}.bind(this));
				}

			},

			submitForm:function(){
				if(!this.pclient){
					this.$emit('nextBorrower', this.borrower.birthdate)
					document.getElementById('borrowerBtn').click();
				}else{
					this.save();
				}
			},

			navigate:function(){
				document.getElementById('custom-content-below-coborrowerinfo-tab').click();
			},

			addData:function(data){
				if(this.borrower.borrower_id){
					this.data[data].borrower_id = this.borrower.borrower_id;
				}
				this.borrower[data].unshift(this.data[data]);
				this.resetData(data);
			},
			resetData:function(data){
				if(data == 'outstandingObligations'){
					this.data[data] = {creditor : '',amount : 0,balance : 0,term : '',due_date : '',amortization : 0}
				}else if(data == 'householdMembers'){
					this.data[data] = {dependent : '',age : 0,relationship : '',occupation : '',contact_no : 0,sbe_address : ''}
				}else if(data == 'employmentInfo'){
					this.data[data] = {id : null,company_name : '',company_address : '',contact_no : '',years_employed : '',position : '',salary : ''}
				}else if(data == 'businessInfo'){
					this.data[data] = {business_name :'',business_type : '',business_address : '',contact_no : '',years_in_business : '',income : 0,}
				}
			},
			removeData:function(data, index){
				let arr = [];
				for(let i in  this.borrower[data]){
					if(i != index){
						arr.push(this.borrower[data][i]);
					}
				}
				this.borrower[data] = arr;
			},
			setData:function(type, i, id){
				this.otherInfo.type = type;
				this.otherInfo.index = i;
				this.otherInfo.id = id;
			},
			clearInfo:function(){
				this.$emit('clearBorrowerInfo')
				this.borrower = {
					borrower_id: null,
					date_registered:'',
					borrower_num:'',
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
				};
			},
			notify:function(title, text, type){
				this.$notify({
					group: 'foo',
					title: title,
					text: text,
					type: type,
				});
			},
			dateToYMD:function(date) {
				var d = date.getDate();
				var m = date.getMonth() + 1;
				var y = date.getFullYear();
				return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
			},
			imageCapture:function(img){
				this.img = img;
			},
			async deleteOtherInfo(){
				if(this.otherInfo.id){
					await axios.post(this.baseURL() + 'client_information/personal_information_details/delete', this.otherInfo, {
						headers: {
							'Authorization': 'Bearer ' + this.token,
							'Content-Type': 'application/json',
							'Accept': 'application/json'
						}
					})
					.then(function (response) {
						if(response.data){
							this.removeData(this.otherInfo.type, this.otherInfo.index);
							this.notify('','Data has been deleted.', 'success');
						}else{
							this.notify('','Something went wrong.', 'error');
						}
					}.bind(this))
					.catch(function (error) {
						console.log(error);
					}.bind(this));
				}else{
					this.removeData(this.otherInfo.type, this.otherInfo.index);
					this.notify('','Data has been deleted.', 'success');
				}

			}
		},
		watch: {
			'img'(newValue){
				if(!newValue){
					// this.img = this.baseUrl + '/img/user.png'
				}
			},
			'pborrower'(newValue) {
				if(!this.pclient){
					this.borrower = newValue;
					// this.img = this.borrower.photo;
				}
			},
			'psave'(newValue) {
				if(newValue != ''){
					this.save();
					this.$emit('saveBorrower')
				}
			},
			'pborrower'(newValue){
				this.borrower = this.pborrower;
			},
			'borrower.status'(newValue){
				if(newValue!='married'){
					this.borrower.spouse_firstname = '';
					this.borrower.spouse_lastname = '';
					this.borrower.spouse_middlename = '';
					this.borrower.spouse_address = '';
					this.borrower.spouse_birthdate = '';
					this.borrower.spouse_id_type = '';
					this.borrower.spouse_id_no = '';
					this.borrower.spouse_id_date_issued = '';
				}
			},
			'clear'(newValue){
				if(newValue == 1){
					this.clearInfo();
					this.$emit('borrowerCleared');
				}
			}
		},
		computed: {
			borrowerImg:function(){
				if(!this.img){
					if(!this.borrower.photo){
						return this.baseURL() + 'img/user.png';
					}
					else{
						return this.borrower.photo;
					}
				}
				return this.img;
			},
			borrowerPhoto:function(){
				if(this.img){
					return this.img;
				}else if(this.borrower.photo && !this.img){
					return this.borrower.photo;
				}else{
					return this.baseURL() + 'img/user.png';
				}
			}
		},
		mounted() {
			this.borrower.date_registered = this.transactionDate.date_end;
			// this.deleteOtherInfo();
			if(this.pclient){
				this.fetchBorrower();
			}else{
				this.borrower = this.pborrower;
				if(this.pborrower.date_registered == ''){
					this.borrower.date_registered = this.transactionDate.date_end
				}
			}
		}
	}
</script>