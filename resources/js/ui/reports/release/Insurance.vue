<template>
	<div class="d-flex flex-column justify-content-between" style="flex:8;min-height:100vh;">
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
		<div>
			<form @submit.prevent="fetchAccounts">
			<div class="d-flex flex-row font-md align-items-center mb-16">
				<span class="font-lg text-primary-dark" style="flex:6">Insurance Report</span>
				<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
					<span class="mr-10">From: </span>
					<input v-model="filter.date_from" type="date" required class="form-control">
				</div>
				<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
					<span class="mr-10">To: </span>
					<input v-model="filter.date_to" type="date" required class="form-control">
				</div>
				<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
					<span v-show="accounts.length > 0"class="mr-10">Age: </span>
					<select v-show="accounts.length > 0" v-model="filter.age" @change="filterAge">
						<option value="">All</option>
						<option value="less_70">Less than or equal to 70</option>
						<option value="greater_70">Greater than 70</option>
					</select>
				</div>
				<!-- Branch Dropdown -->
				<select v-model="filter.branch_id" :required="filter.branch_id !== ''" class="form-control">
					<option value="">All</option> <!-- Option for "All" -->
					<option v-for="branch in branches" :key="branch.branch_id" :value="branch.branch_id">
						{{ branch.branch_name }} ({{ branch.branch_code }})
					</option>
				</select>
				
				<div class="d-flex flex-row align-items-center mr-24 justify-content-start flex-1">
					<button class="btn btn-primary">Generate</button>
				</div>
			</div>
			</form>
			<div class="sep mb-45"></div>
			<div id="printContent">
				<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">

				<section class="" id="clientSection">
					<div class="d-flex flex-column mb-16">
						<div class="d-flex flex-row align-items-center">
							<div class="flex-1"></div>
							<span class="font-30 text-bold text-primary-dark">INSURANCE REPORT</span>
							<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
								<current-transactiondate :branch="branch.branch_id" :token="token" :reports="true"></current-transactiondate>
								<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
							</div>
						</div>
						<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name + ' Branch (' + branch.branch_code + ')'}}</span>
						<div v-if="filter.date_from&&filter.date_to" class="d-flex flex-row justify-content-center text-primary-dark">
							<span class="mr-5">From:</span><span class="mr-16">{{dateToMDY2(new Date(filter.date_from)).split('-').join('/')}}</span>
							<span class="mr-5">To:</span><span>{{dateToMDY2(new Date(filter.date_to)).split('-').join('/')}}</span>
						</div>
						<div v-else class="d-flex flex-row justify-content-center text-primary-dark">
							<span class="mr-5">From:</span><span class="mr-16">---</span>
							<span class="mr-5">To:</span><span>---</span>
						</div>
					</div>
					<section class="d-flex flex-column mb-72">
						<table class="table td-nb table-thin">
							<thead>
								<th>Account No.</th>
								<th>Full Name</th>
								<th>Birthdate</th>
								<th>Gender</th>
								<th>Age</th>
								<th>Status</th>
								<th>Amount Loan</th>
								<th>Insurance</th>
								<th>Date Released</th>
								<th>Due Date</th>
								<th>Term</th>
							</thead>
							<tbody>
								<tr v-if="!accounts.length"><td><i>No records found.</i></td></tr>
								<tr v-else v-for="a,i in accounts.sort((a, b) => a.name.localeCompare(b.name))" :key="i">
									<td>{{a.account_num}}</td>
									<td>{{a.name}}</td>
									<td>{{dateToMDY(new Date(a.birthdate))}}</td>
									<td>{{upperFirst(a.gender)}}</td>
									<td>{{ calculateAge(a.birthdate) }}</td> <!-- Display calculated age -->
									<td>{{upperFirst(a.marital_status)}}</td>
									<td>{{formatToCurrency(a.amount_loan)}}</td>
									<td>{{formatToCurrency(a.insurance)}}</td>
									<td>{{dateToMDY(new Date(a.date_loan))}}</td>
									<td>{{dateToMDY(new Date(a.due_date))}}</td>
									<td>{{a.term / 30}} Mos</td>
								</tr>
							</tbody>
						</table>
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
					<a @click="exportToExcelAgeAbove71" href="#" class="btn btn-warning min-w-150 mr-24">Download Excel (Age Greater 71)</a>
					<a @click="exportToExcelAgeBelow70" href="#" class="btn btn-info min-w-150">Download Excel (Age Less 70)</a>
				</div>
			</div>
		</div>
	</div>

</template>

<script>
import * as XLSX from 'xlsx';

export default {
	props:['token','pbranch'],
	data(){
		return {
			loading:false,
			filter:{
				date_from: null,
				date_to: null,
				branch_id:null,
				category:'insurance',
				age: "all",
			},
			branches:[
				{ branch_id:1, branch_name: 'Butuan', branch_code:'001'},
				{ branch_id:2, branch_name: 'Nasipit', branch_code:'002'},
			],
			tempAccount:[],
			accounts: [],
		}
	},
	methods:{
		fetchAccounts:function(){
			this.loading = true;
			console.log("Filters:", this.filter);

			 // Modify the filter before making the API call
			 let filterData = { ...this.filter };

			// If "All" branch is selected (branch_id is empty), remove it from the filter data
			if (!filterData.branch_id) {
				delete filterData.branch_id;
}
			axios.post(this.baseURL() + 'api/report/release', this.filter, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loading = false;
				this.tempAccount = response.data.data;
				this.accounts = this.tempAccount
			}.bind(this))
			.catch(function (error) {
				this.loading = false;
				console.log(error);
			}.bind(this));
		}, 
		filterAge: function() {
			if (this.filter.age === "less_70") {
				// Filter accounts where age is less than or equal to 70
				this.accounts = this.tempAccount.filter((e) => {
					return this.calculateAge(e.birthdate) <= 70;
				});
			} else if (this.filter.age === "greater_70") {
				// Filter accounts where age is greater than 70
				this.accounts = this.tempAccount.filter((e) => {
					return this.calculateAge(e.birthdate) > 70;
				});
			} else {
				// If no age filter is selected, show all accounts
				this.accounts = this.tempAccount;
			}
		},
		print:function(){
			var content = document.getElementById('printContent').innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			window.print();
		},
		calculateAge(birthdate) {
        const birthDate = new Date(birthdate);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDifference = today.getMonth() - birthDate.getMonth();
        if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
            age--; // Adjust if the birthday hasn't occurred yet this year
        }
        return age;
    },
	exportToExcelAgeBelow70() {
			// Filter accounts with age <= 70
		const filteredData = this.accounts.filter(account => {
        return this.calculateAge(account.birthdate) <= 70;
      });

      // Create Excel file from filtered data
      this.generateExcel(filteredData);
			

	},
	exportToExcelAgeAbove71() {
			// Filter accounts with age <= 70
		const filteredData = this.accounts.filter(account => {
        return this.calculateAge(account.birthdate) >= 71;
      });

      // Create Excel file from filtered data
      this.generateExcel(filteredData);
	

	},
	generateExcel(filteredData) {
      // Transform data into the format SheetJS expects
      const data = filteredData.map((account) => {
        // Split name by commas
        const nameParts = account.name.split(',').map(part => part.trim());
        const lastname = nameParts[0] || '';
        const firstname = nameParts[1] || '';
        const middlename = nameParts[2] || '';

        return {
          'Last Name': lastname,
          'First Name': firstname,
          'Middle Name': middlename,
          'Gender': this.upperFirst(account.gender),
          'Birthdate': this.dateToMDY(new Date(account.birthdate)),
          'Age': this.calculateAge(account.birthdate),
          'Date Released': this.dateToMDY(new Date(account.date_loan)),
          'Amount Loan': this.formatToCurrency(account.amount_loan),
          'Term': account.term / 30 + ' Mos',
        };
      });

      // Create a new worksheet and add the data
      const worksheet = XLSX.utils.json_to_sheet(data);
      const workbook = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbook, worksheet, 'Insurance Report');

      // Export the workbook as an Excel file
      XLSX.writeFile(workbook, 'Insurance_Report.xlsx');
    },
  },
	computed:{
		
	},
	watch:{
		 filter: {
			handler(val){
				if(val.date_from && val.date_to){
					// this.fetchAccounts();
				}
			},
			deep: true
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
		this.filter.branch_id = this.branch.branch_id
	}
}
</script>