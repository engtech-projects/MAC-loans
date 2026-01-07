<style>
@media print {
    body {
        margin-top: 0.19;

        padding: 0;
		/* font-family: "Courier New"; */
		font-family: "Courier New", Courier, monospace;
    }
    /* Additional print styles can be added here */
	.section-collection{
		page-break-before: always;
		
	}
}

.section-collection{
	text-align: center;
}

.table th, .table td{
	padding: 0.20rem;
}

.collection-sheet td {
	border-bottom: 1px dashed black;
}
.collection-sheet th {
	border-bottom: 1px dashed black;
}

</style>



<template>
	<div class="d-flex flex-column" style="flex:8;">
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px;">
			</div>
			<span class="font-lg" style="color:#ddd;">Please wait until the process is complete</span>
		</div>
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark" style="flex:4">Transactions</span>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<!-- <span class="mr-10">Date: </span>
				<input type="date" class="form-control"> -->
			</div>
			
			<div class="d-flex flex-row align-items-center mr-24" style="flex:3">
				<span class="mr-10">A.O: </span>
				<select v-model="filter.account_officer" name="" id="selectProductClient" class="form-control">
					<option v-for="ao in aos.filter(aa=>aa.status=='active')" :key="ao.ao_id" :value="ao.ao_id">{{ao.name}}</option>
				</select>
			</div>
			<div class="d-flex flex-row align-items-center" style="flex:3">
				<span class="mr-10">Center: </span>
				<div class="d-flex flex-column">
					<search-dropdown 
						:reset="resetCenter" 
						@centerReset="resetCenter=false" 
						@sdSelect="centerSelect" 
						:data="centers"
						:center-id="filter.center"
						:height="'38px'"
						:fontSize="'16px'"
						:borderRadius="'5px'"
						id="center_id" 
						name="center"
					></search-dropdown>
					<input style="border:none!important;width:100%!important;height:0px!important;opacity:0!important;" type="text" v-model="filter.center">
				</div>
			</div>
		</div>
		<div class="sep mb-45"></div>
		<div id="printContent" class="mt-0.2" style="font-family: 'Courier New', Courier, monospace;">
			<!-- <img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt=""> -->
				<section class="" id="clientSection">
					<div class="d-flex justify-content-between align-items-center mb-36">
						<!-- Left column: Branch name and promissory note number -->
						<div class="d-flex flex-column flex-1">
							<span v-if="filter.account_officer" class="text-primary-dark font-25">
							<!-- //	{{branch.branch_name}} Branch ({{branch.branch_code}}) -->
							{{accountOfficer.name}}
							</span>
							<span class="text-bold"> {{centerName}}</span>
							
						</div>

						<!-- Center column: Promissory Note and Micro Access Loan Corporation -->
						<div class="d-flex flex-column text-center">
							<span class="font-26 text-bold text-primary-dark lh-1">
								COLLECTION SHEET REPORT
							</span>
							<span class="text-primary-dark text-bold font-md mb-5">
								MICRO ACCESS LOAN CORPORATION
							</span>
							<span class="text-center text-primary-dark text-bold">
								As of {{filter.as_of?dateToMDY2(new Date(filter.as_of)).split('-').join('/'):'---'}}
							</span>
						</div>

						<!-- Right column: Date and time -->
						<div class="d-flex flex-column flex-1 text-right">
							<span class="mr-10">
								{{dateFullDay(new Date())}} {{dateToYMD(new Date()).split('-').join('/')}}
							</span>
						</div>
					</div>
						<section class="d-flex flex-column mb-16">
							<div>
								<div class="d-flex flex-row" style="font-size:25px;">
									
									
								
								</div>
								
								<table class="table-stripped" style="font-size:15px;">
									<thead class="collection-sheet">
										<th>Client</th>
										<th>Date Loan</th>
										<th>Maturity Date</th>
										<th>Amount Loan</th>
										<th>Outstand Bal.</th>
										<th>Principal Bal.</th>
										<th>Delnqt</th>
										<!-- <th>Penalty</th> -->
										<th>Amt. Due</th>
										<th>Weekly Amort.</th>
										<th>Cont. #</th>
										<!-- <th>Address</th> -->
										<th>Payment</th>
										<!-- <th>Signature</th> -->
									</thead>
									<tbody>
										<tr class="collection-sheet" v-for="c,i in collections" :key="i">
											<td>{{c.client}}</td>
											<td>{{c.date_loan.replaceAll('-','/')}}</td>
											<td>{{c.maturity_date.replaceAll('-','/')}}</td>
											<td>{{formatToCurrency(c.amount_loan)}}</td>
											<td>{{formatToCurrency(c.outstanding_balance)}}</td>
											<td>{{formatToCurrency(c.principal_balance)}}</td>
											<td>{{formatToCurrency(c.delinquent)}}</td>
											<!-- <td>{{formatToCurrency(c.penalty)}}</td> -->
											<td>{{formatToCurrency(c.amount_due)}}</td>
											<td>{{formatToCurrency(c.weekly_amortization)}}</td>
											<td>{{c.contact}}</td>
											<!-- <td>{{c.address}}</td> -->
											<td ></td>
											<!-- <td ></td> -->
										</tr>
										<tr v-if="!collections.length"><td><i>No data available.</i></td></tr>
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
											<!-- <td></td> -->
										</tr>
										<tr class="py-7">
											<td class="py-7"></td>
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
											<!-- <td></td> -->
										</tr>
										<tr class="tr-py-7 text-bold bg-green-mint">
											<td>TOTAL</td>
											<td></td>
											<td>{{collections.length}}</td>
											<td v-for="t,i in total" :key="i">{{formatToCurrency(t)}}</td>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</section>
						<!-- <section class="d-flex mb-24" style="font-size:25px;">
							<table class="flex-1 table table-bordered">
								<thead>
									<th>Cash Breakdown</th>
									<th>Pc(s)</th>
									<th>Total Amount</th>
								</thead>
								<tbody>
									<tr>
										<td>1,000.00</td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td>500.00</td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td>200.00</td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td>100.00</td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td>50.00</td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td>20.00</td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td>10.00</td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td>5.00</td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td>1.00</td>
										<td></td>
										<td></td>
									</tr>
									<tr>
										<td>0.25</td>
										<td></td>
										<td></td>
									</tr>
								</tbody>
							</table>
							<div class="flex-1"></div>
						</section> -->

					
				</section>
			
			<!-- <div class="d-flex mb-24">
				<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
			</div> -->
		</div>
		<!-- <div class="d-flex flex-row justify-content-end mb-24">
			<a href="#" class="text-green text-md text-bold mr-24">Previous Page</a>
			<a href="#" class="text-green text-md text-bold">Next Page</a>
		</div> -->
		<div class="d-flex flex-row block mb-45">
			<div class="d-flex justify-content-end block flex-1">
				<a @click="print()" href="#" class="btn btn-default min-w-150">Print</a>
				<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
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
			resetCenter:false,
			branch:{branch_id:null,branch_code:null,branch_name:null},
			filter:{
				branch_id:'',
				account_officer:null,
				center:'',
				type:'collection'
			},
			collections:[],
			centers:[],
			aos:[]
		}
	},
	methods:{
		centerSelect:function(center){
			this.filter.center = center.center_id;
		},
		print:function(){
			var content = document.getElementById('printContent').innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			//target.innerHTML += '<style type="text/css" media="print">@page { size: portrait;} font-family:"Courier New"</style>';
			var style = document.createElement('style');
			style.innerHTML =  `
					@media print {
						@page {
							size: 8.5in 14in portrait !important; /* Custom paper size */
								/* Custom margin */
							padding:10px;
							line-height:1.3em!important;
							margin-left: -5px; /* Custom left margin */
							margin-right: -5px; /* Custom right margin */
						}
						body {
								/* Custom body margin for print */
								padding:10px;
							font-weight: bolder;
							font-size:16px!important;
							line-height:1.3em!important;
							font-family: "Arial", "Helvetica", sans-serif;
							text-align: justify;
						}
						.to-print {
							transform: scale(108px); /* Custom scale of 75% for print */
							transform-origin: top left; /* Ensure scaling starts from the top left */
						}
					}
				`;
			
			document.head.appendChild(style);
			window.print();
			window.onafterprint = function() {
				document.head.removeChild(style);
			};
			
			window.print();
		},
		async fetchCollections(){
			this.loading = true;
			await axios.post(this.baseURL() + 'api/report/branch', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loading = false;
				console.log(response);
				this.collections = response.data.data.data
			}.bind(this))
			.catch(function (error) {
				this.loading = false;
				console.log(error);
			}.bind(this));
		},
		async fetchTransactionDate(){
			await axios.get(this.baseURL() + 'api/eod/eodtransaction/' + this.branch.branch_id,{
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.filter.as_of = response.data.data.date_end;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
		},
		async fetchAo(){
			await axios.get(this.baseURL() + 'api/accountofficer/getActivesInBranch/' + this.branch.branch_id, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.aos = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		async fetchCenters(){
			await axios.get(this.baseURL() + 'api/center', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.centers = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		sortClient:function(a, b){
			let aclient = a.client.toLowerCase(),
        		bclient = b.client.toLowerCase();

			if (aclient < bclient) {
				return -1;
			}
			if (aclient > bclient) {
				return 1;
			}
			return 0;
		}
	},
	computed:{
		total:function(){
			var row = [0,0,0,0,0,0,0];
			this.collections.forEach(c=>{
				row[0] += c.amount_loan;
				row[1] += c.outstanding_balance;
				row[2] += c.principal_balance;
				row[3] += c.delinquent;
				row[4] += c.penalty;
				row[5] += c.amount_due;
				row[6] += c.weekly_amortization;
			})
			return row;
		},
		accountOfficer:function(){
			var aos = this.aos.filter(ao=>ao.ao_id==this.filter.account_officer);
			return aos.length?aos[0]:[];
		},
		centerName:function(){
			return this.filter.center?this.centers.filter(c=>c.status=='active'&&c.center_id==this.filter.center)[0].center:'';
		}
	},
	watch:{
		filter:{
			handler(val){
				if(val.account_officer&&val.center){
					this.fetchCollections();
				}
			},
			deep:true
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch)
		this.filter.branch_id = this.branch.branch_id;
		this.fetchAo();
		this.fetchCenters();
		this.fetchTransactionDate();
	}
}
</script>