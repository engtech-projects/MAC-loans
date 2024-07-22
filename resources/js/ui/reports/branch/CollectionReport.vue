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


</style>



<template>
	<div class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark" style="flex:4">Transaction</span>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<!-- <span class="mr-10">Date: </span>
				<input type="date" class="form-control"> -->
			</div>
			
			<div class="d-flex flex-row align-items-center mr-24" style="flex:3">
				<span class="mr-10">A.O: </span>
				<select v-model="filter.account_officer" name="" id="selectProductClient" class="form-control">
					<option v-for="ao in aos.filter(aa=>aa.status=='active'&&aa.branch_id==branch.branch_id)" :key="ao.ao_id" :value="ao.ao_id">{{ao.name}}</option>
				</select>
			</div>
			<div class="d-flex flex-row align-items-center" style="flex:3">
				<span class="mr-10">Center: </span>
				<select v-model="filter.center" name="" id="selectProductClient" class="form-control">
					<option v-for="center in centers" :key="center.center_id" :value="center.center_id">{{center.center}}</option>
				</select>
			</div>
		</div>
		<div class="sep mb-45"></div>
		<div id="printContent" class="mt-0.2" style="font-family: 'Courier New', Courier, monospace;">
			<!-- <img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt=""> -->
				<section class="" id="clientSection">
						<div class="d-flex flex-column mb-24" style="font-size:25px;">
							<div class="d-flex flex-row align-items-center">
								<div class="flex-1 d-flex flex-column">
									
									
								</div>
								<span class="font-30 text-bold text-center text-primary-dark flex-1">COLLECTION SHEET REPORT</span>

								<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
									<current-transactiondate :branch="branch.branch_id" :token="token" :reports="true"></current-transactiondate>
									<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
								</div>
							</div>
							<span class="text-center text-primary-dark text-bold font-md mb-5">MICRO ACCESS LOAN CORPORATION</span>
							<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name + ' Branch (' + branch.branch_code + ')'}}</span>
							<div class="d-flex flex-row justify-content-center text-primary-dark">
								<span class="text-center text-primary-dark text-bold">As of {{filter.as_of?dateToMDY2(new Date(filter.as_of)).split('-').join('/'):'---'}}</span>
							</div>
						</div>
						<section class="d-flex flex-column mb-16">
							<div>
								<div class="d-flex flex-row" style="font-size:25px;">
									
									<span v-if="filter.account_officer" class="text-bold">{{branch.branch_code}} - {{accountOfficer.name}}  - {{centerName}}</span>
								
								</div>
								
								<table class="table table-thin table-stripped" style="font-size:20px;">
									<thead>
										<th style="width: 10px;">Client</th>
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
										<th>Signature</th>
									</thead>
									<tbody>
										<tr v-for="c,i in collections.sort(sortClient)" :key="i">
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
											<td ></td>
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
											<td></td>
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
											<td></td>
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
						<section class="d-flex mb-24" style="font-size:20px;">
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
						</section>

					
				</section>
			
			<div class="d-flex mb-24">
				<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
			</div>
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
			branch:{branch_id:null,branch_code:null,branch_name:null},
			filter:{
				branch_id:'',
				account_officer:null,
				center:null,
				type:'collection'
			},
			collections:[],
			centers:[],
			aos:[]
		}
	},
	methods:{
		print:function(){
			var content = document.getElementById('printContent').innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			target.innerHTML += '<style type="text/css" media="print">@page { size: portrait; } .to-print { scale:10in; margin-left: 0.80in; margin-right: 0.80in;  margin-top: 0.25in; margin-bottom: 0; font-family:"Courier New" } </style>';
			window.print();
		},
		async fetchCollections(){
			await axios.post(this.baseURL() + 'api/report/branch', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}

			})
			.then(function (response) {
				console.log(response);
				this.collections = response.data.data.data
			}.bind(this))
			.catch(function (error) {
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
			await axios.get(this.baseURL() + 'api/accountofficer/', {
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