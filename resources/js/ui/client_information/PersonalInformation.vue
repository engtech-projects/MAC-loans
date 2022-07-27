<template>
	<div class="px-16">
		<div class="container-fluid">
		<div class="mb-16"></div>
		<div class="d-flex justify-content-between mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">Personal Information</h1>
			<a :href="'/client_information/personal_information_details/edit/' + borrower_id" class="btn btn-success min-w-150">Edit Information</a>
		</div><!-- /.col -->
		<div class="d-flex flex-column flex-sm-row personal-info" style="margin-bottom:24px;">
			<div class="upload-photo mb-24">
				<img :src="borrowerPhoto" alt="" style="max-width:250px;">
				<a href="#" class="btn btn-primary" style="padding:10px!important">Upload or Take a Photo</a>
			</div>
			<div class="flex-gap-24"></div>
			<div class="info-main-container" style="width:100%;">
				<div class="row info-container">
					<div class="col-xl-2 col-lg-6">
						<div class="customer-number">
							<span>Customer Number</span>
							<span>{{borrower.borrower_num}}</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>First Name</span>
							<span class="xs-font-24">{{borrower.firstname}}</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>Middle Name</span>
							<span>{{borrower.middlename}}</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>Last Name</span>
							<span>{{borrower.lastname}}</span>
						</div>
					</div>
					<div class="col-xl-4">
						<div class="info-display">
							<span>Suffix</span>
							<span>{{borrower.suffix}}</span>
						</div>
					</div>
					
				</div>
				<div class="row info-container">
					<div class="col-xl-3 col-lg-6">
						<div class="info-display">
							<span>Birth Date</span>
							<span>{{dateToMDY(new Date(borrower.birthdate))}}</span>
						</div>
					</div>
					<div class="col-xl-1 col-lg-6">
						<div class="info-display">
							<span>Gender</span>
							<span>{{borrower.gender}}</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>Status</span>
							<span>{{borrower.status}}</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>Contact Number</span>
							<span>{{borrower.contact_number}}</span>
						</div>
					</div>
					<div class="col-xl-4 col-lg-6">
						<div class="info-display">
							<span>Registration Date</span>
							<span>{{dateToMDY(new Date(borrower.date_registered))}}</span>
						</div>
					</div>
				</div>
				<div class="row info-container">
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>ID. Type</span>
							<span>{{borrower.id_type}}</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6">
						<div class="info-display">
							<span>ID. Number</span>
							<span>{{borrower.id_no}}</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>ID. Date</span>
							<span>12/12/2019</span>
						</div>
					</div>
				</div>
				<div class="row info-container xs-mb-32">
					<div class="col-md-12">
						<div class="info-display">
							<span class="text-block">Address</span>
							<span>{{borrower.address}}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row info-container mb-24" style="width:100%">
			<div class="col-md-12" style="height:60px!important;">
				<div class="info-display title">
					<span>Spouse Information</span>
				</div>
			</div>
			<div class="col-xl-2 col-lg-6">
				<div class="info-display">
					<span>First Name</span>
					<span>{{borrower.spouse_firstname}}</span>
				</div>
			</div>
			<div class="col-xl-2 col-lg-6">
				<div class="info-display">
					<span>Middle Name</span>
					<span>{{borrower.spouse_middlename}}</span>
				</div>
			</div>
			<div class="col-xl-2 col-lg-6">
				<div class="info-display">
					<span>Last Name</span>
					<span>{{borrower.spouse_lastname}}</span>
				</div>
			</div>
			<div class="col-xl-3">
				<div class="info-display">
					<span>Suffix</span>
					<span>{{borrower.suffix}}</span>
				</div>
			</div>
			<div class="col-xl-3">
				<div class="info-display">
					<span>Birth Date</span>
					<span>March 12, 1976</span>
				</div>
			</div>
		</div>	
	</div>
		<div class="row info-container mb-36" style="width:100%">
				<div class="col-md-12" style="height:60px!important;">
					<div class="info-display title">
						<span>Employment Information</span>
					</div>
				</div>
				<table class="table table-stripped text-primary-dark light-border">
					<thead>
						<th>Name of Company</th>
						<th>Address/Contact No.</th>
						<th>No. of Years Employed</th>
						<th>Position</th>
						<th>Monthly Salary</th>
					</thead>
					<tbody>
						<tr v-if="borrower.employmentInfo.length == 0"><td>No employment information found.</td></tr>
						<tr v-for="emp in borrower.employmentInfo" :key="emp.id">
							<td>{{emp.company_name}}</td>
							<td>{{emp.company_address}}</td>
							<td>{{emp.years_employed}}</td>
							<td>{{emp.position}}</td>
							<td>{{emp.salary}}</td>
						</tr>
					</tbody>
				</table>
		</div>

		<div class="row info-container mb-36" style="width:100%">
				<div class="col-md-12" style="height:60px!important;">
					<div class="info-display title">
						<span>Household Member's Information</span>
					</div>
				</div>
				<table class="table table-stripped text-primary-dark light-border">
					<thead>
						<th>Name of Dependents</th>
						<th>Age</th>
						<th>Relationship</th>
						<th>Occupation</th>
						<th>Contact No.</th>
						<th>School/Business/Employment Address</th>
					</thead>
					<tbody>
						<tr v-if="borrower.householdMembers.length == 0"><td>No household member information found.</td></tr>
						<tr v-for="hh in borrower.householdMembers" :key="hh.id">
							<td>{{hh.dependent}}</td>
							<td>{{hh.age}}</td>
							<td>{{hh.relationship}}</td>
							<td>{{hh.occupation}}</td>
							<td>{{hh.contact_no}}</td>
							<td>{{hh.sbe_address}}</td>
						</tr>
					</tbody>
				</table>
		</div>

		<div class="row info-container mb-36" style="width:100%">
				<div class="col-md-12" style="height:60px!important;">
					<div class="info-display title">
						<span>Outstanding Obligations for Other Creditors (Please include credit card)</span>
					</div>
				</div>
				<table class="table table-stripped text-primary-dark light-border">
					<thead>
						<th>Name of Creditors</th>
						<th>Loan Amount</th>
						<th>Outstanding Balance</th>
						<th>Term</th>
						<th>Due Date</th>
						<th>Amortization Frequency</th>
					</thead>
					<tbody>
						<tr v-if="borrower.outstandingObligations.length == 0"><td>No outstanding obligation information found.</td></tr>
						<tr v-for="ob in borrower.outstandingObligations" :key="ob.id">
							<td>Maria Lagahit</td>
							<td>32,000.00</td>
							<td>21,201.00</td>
							<td>12 Months</td>
							<td>12/12/2021</td>
							<td></td>
						</tr>
					</tbody>
				</table>
		</div>

		<div class="row info-container mb-72" style="width:100%">
				<div class="col-md-12" style="height:60px!important;">
					<div class="info-display title">
						<span>Business Information</span>
					</div>
				</div>
				<table class="table table-stripped text-primary-dark light-border">
					<thead>
						<th>Type of Business</th>
						<th>Business Address</th>
						<th>Contact No.</th>
						<th>Years in Business</th>
						<th>Income Frequency</th>
					</thead>
					<tbody>
						<tr v-if="borrower.businessInfo.length == 0"><td>No business information found.</td></tr>
						<tr v-for="biz in borrower.businessInfo" :key="biz.id">
							<td>Car Rental Service</td>
							<td>Butuan City</td>
							<td>09458545474</td>
							<td>5</td>
							<td>2,000.00</td>
						</tr>
					</tbody>
				</table>
		</div>
	</div>
	
</template>

<script>
export default {
	props:['borrower_id','token'],
	data(){
		return {
			baseUrl: this.baseURL(),
			borrower:{
				borrower_id: null,
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
			}
		}
	},
	methods:{
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
	},
	computed:{
		borrowerPhoto:function(){
			return this.borrower.photo? this.borrower.photo : '/img/user.png';
		}
	},
	mounted(){
		this.fetchBorrower();
	}
}
</script>