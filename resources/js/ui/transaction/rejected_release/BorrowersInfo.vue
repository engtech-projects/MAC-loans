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
							<input disabled type="date" v-model="borrower.date_registered" class="form-control form-input text-right" id="regDate">
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
					<img :src="baseUrl + '/img/user.png'" alt="">
					<a href="#" class="btn btn-primary" style="padding:10px!important">Upload or Take a Photo</a>
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
					<label for="sex" class="form-label">Sex</label>
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
						<option value="widowed">Widowed</option>
						<option value="separated">Separated</option>
					</select>
				</div>
				<div class="form-group mb-10" style="flex: 6">
					<label for="contactNumber" class="form-label">Contact Number</label>
					<input v-model="borrower.contact_number" required type="number" class="form-control form-input " id="contactNumber">
				</div>
			</div>
		</section>

		<section class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Borrower's Identification Details</span>

			<div class="d-flex flex-row">
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="idType" class="form-label">ID Type</label>
					<select v-model="borrower.id_type" required name="" id="" class="form-control form-input">
						<option v-for="type in idType" :key="type" :value="type">{{type}}</option>
					</select>
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="idNumber" class="form-label">ID Number</label>
					<input v-model="borrower.id_no" required type="text" class="form-control form-input " id="idNumber">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="idDate" class="form-label">ID Date Issued</label>
					<input v-model="borrower.id_date_issued" type="date" class="form-control form-input " id="idDate">
				</div>
				<div style="flex: 3"></div>
			</div>
		</section>

		<section class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Borrower's Spouse Information</span>

			<div class="d-flex flex-row">
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="spouseFirstName" class="form-label">First Name</label>
					<input v-model="borrower.spouse_firstname" type="text" class="form-control form-input " id="spouseFirstName">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="spouseMiddleName" class="form-label">Middle Name</label>
					<input v-model="borrower.spouse_middlename" type="text" class="form-control form-input " id="spouseMiddleName">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="spouseLastName" class="form-label">Last Name</label>
					<input v-model="borrower.spouse_lastname" type="text" class="form-control form-input " id="spouseLastName">
				</div>
			</div>
			<div class="form-group mb-10" style="flex: 3">
				<label for="spouseAddress  " class="form-label">Address</label>
				<input v-model="borrower.spouse_address" type="text" class="form-control form-input " id="spouseAddress  ">
			</div>
			<div class="d-flex flex-row">
				<div class="form-group mb-10 mr-16" style="flex: 2">
					<label for="spouseBirthdate" class="form-label">Birth Date</label>
					<input v-model="borrower.spouse_birthdate" type="date" class="form-control form-input " id="spouseBirthdate">
				</div>
				<div class="form-group mb-10" style="flex:2">
					<label for="spouseContactNumber" class="form-label">Contact Number</label>
					<input type="text" class="form-control form-input " id="spouseContactNumber">
				</div>
			</div>
		</section>

		<section class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Borrower's Spouse Identification Details</span>

			<div class="d-flex flex-row">
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="spouseIdType" class="form-label">ID Type</label>
					<select v-model="borrower.spouse_id_type" name="" id="" class="form-control form-input">
						<option v-for="type in idType" :key="type" :value="type">{{type}}</option>
					</select>
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="spouseIdNumber" class="form-label">ID Number</label>
					<input v-model="borrower.spouse_id_no" type="text" class="form-control form-input " id="spouseIdNumber">
				</div>
				<div class="form-group mb-10 mr-16" style="flex: 3">
					<label for="spouseIdDate" class="form-label">ID Date Issued</label>
					<input v-model="borrower.spouse_id_date_issued" type="date" class="form-control form-input " id="spouseIdDate">
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
						<td><a @click.prevent="removeData('householdMembers', i)" href="#" class="text-red font-small">Delete</a></td>
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
					<input v-model="data.outstandingObligations.amortization" required type="number" class="form-control form-input " id="companySalary">
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
					<th>Amort./Freq.</th>
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
						<td><a @click.prevent="removeData('outstandingObligations',i)" href="#" class="text-red font-small">Delete</a></td>
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
						<td><a href="#" @click.prevent="removeData('employmentInfo',i)" class="text-red font-small">Delete</a></td>
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
					<input v-model="data.businessInfo.contact_no" required type="number" class="form-control form-input " id="companyContact">
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
					<input v-model="data.businessInfo.income" required type="number" class="form-control form-input " id="businessIncome">
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
						<td><a @click.prevent="removeData('businessInfo', i)" href="#" class="text-red font-small">Delete</a></td>
					</tr>
				</tbody>
			</table>
		</section>

		<div class="d-flex flex-row-reverse">
			<a @click.prevent="submitForm()" href="#custom-content-below-coborrowerinfo" data-tab="custom-content-below-coborrowerinfo-tab" class="btn btn-success tab-navigate" style="flex:2">Next</a>
			<!-- <a href="#" @click.prevent="clearInfo()" class="btn btn-yellow-light min-w-150 mr-16">Clear Info</a> -->
			<div style="flex:22"></div>
		</div>
	</div>
</template>

<script>
    export default {
		props:['token','pborrower', 'psave','clear', 'idType'],
		data(){
			return {
				baseUrl: this.baseURL(),
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
						amortization : 0
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
						income : 0,
					}
				}
			}
		},
		methods: {
			save: function(){
				if(this.borrower.borrower_id){
						axios.put(this.baseURL() + 'api/borrower/' + this.borrower.borrower_id, this.borrower, {
							headers: {
								'Authorization': 'Bearer ' + this.token,
								'Content-Type': 'application/json',
								'Accept': 'application/json'
							}
						})
						.then(function (response) {
							this.notify('',response.data.message, 'success');
							this.$emit('savedInfo', response.data.data)
							console.log(response.data);
						}.bind(this))
						.catch(function (error) {
							console.log(error);
						}.bind(this));
				}else {
					axios.post(this.baseURL() + 'api/borrower', this.borrower, {
						headers: {
							'Authorization': 'Bearer ' + this.token,
							'Content-Type': 'application/json',
							'Accept': 'application/json'
						}
					})
					.then(function (response) {
						this.notify('',response.data.message, 'success');
						this.$emit('savedInfo', response.data.data)
						console.log(response.data);
					}.bind(this))
					.catch(function (error) {
						console.log(error);
					}.bind(this));
				}

			},

			submitForm:function(){
				document.getElementById('borrowerBtn').click();
			},

			navigate:function(){
				this.$emit('nextBorrower', this.borrower)
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
			clearInfo:function(){
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

			dateToYMD:function(date) {
				var d = date.getDate();
				var m = date.getMonth() + 1;
				var y = date.getFullYear();
				return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
			}
		},
		watch: {
			'pborrower'(newValue) {
				this.borrower = newValue;
			},

		},
        mounted() {
        }
    }
</script>