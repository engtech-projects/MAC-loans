<template>
	<div id="printContent" class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark no-print" style="flex:4">Prepaid Interest</span>
			<div class="d-flex flex-row align-items-center mr-24 no-print" style="flex:2">
				<span class="mr-10">Due Date: </span>
				<input v-model="filter.date_from" type="date" class="form-control flex-1">
			</div>
			<!-- <div class="d-flex flex-row align-items-center" style="flex:2">
				<span class="mr-10">To: </span>
				<input type="date" class="form-control">
			</div> -->
		</div>
		<div class="sep mb-45"></div>
		<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">



		<section class="" id="productSection">
			<div class="d-flex flex-column mb-16">
				<div class="d-flex flex-row align-items-center">
					<div class="flex-1"></div>
					<span class="font-30 text-bold text-primary-dark">PREPAID INTEREST REPORT</span>
					<div class="flex-1" style="padding-left:24px">
						<span class="text-primary-dark mr-10">{{dateFullDay(new Date())}} {{dateToYMD(new Date()).split('-').join('/')}}</span>
						<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
					</div>
				</div>
				<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name}} Branch ({{branch.branch_code}})</span>
				<div class="d-flex flex-row justify-content-center text-primary-dark">
					<span class="text-center text-primary-dark text-bold">Due Date: {{filter.date_from?dateToMDY2(new Date(filter.date_from)).split('-').join('/'):'---'}}</span>
				</div>
			</div>
			<section class="d-flex flex-column mb-45">
				<table class="table table-stripped table-thin" style="font-size:13px">
					<thead>
						<tr>
							<th>Client</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Term</th>
							<th>Total UID</th>
							<th>Bal.</th>
							<th>Monthly UID</th>
							<th>Year</th>
							<th>Jan</th>
							<th>Feb</th>
							<th>Mar</th>
							<th>Apr</th>
							<th>May</th>
							<th>Jun</th>
							<th>Jul</th>
							<th>Aug</th>
							<th>Sep</th>
							<th>Oct</th>
							<th>Nov</th>
							<th>Dec</th>
							<th>TOTAL</th>
						</tr>
						
					</thead>
					<tbody>
						<tr v-if="!filteredReports.rows.length"><td><i>No records yet.</i></td></tr>
						<tr v-for="fr,i in filteredReports.rows" :key="i">
							<td v-for="c,j in fr" :key="j" :class="j==fr.length-1?'text-bold':''">{{c}}</td>
						</tr>
						<tr v-if="filteredReports.rows.length" class="bg-green-mint text-bold">
							<td v-for="ov,k in filteredReports.overall" :key="k">{{ov}}</td>
						</tr>
					</tbody>
				</table>
				<!-- <div class="d-flex flex-row justify-content-end mb-24">
					<a href="#" class="text-green text-md text-bold mr-24">Previous Page</a>
					<a href="#" class="text-green text-md text-bold">Next Page</a>
				</div> -->
			</section>
			<section class="d-flex flex-row mb-72">
			<span class="flex-2 pb-24 text-bold darker-bb mr-64">Prepared By:</span>
			<span class="flex-2 pb-24 text-bold darker-bb mr-64">Certified Corrected By:</span>
			<span class="flex-2 pb-24 text-bold darker-bb mr-64">Approved By:</span>
			<span class="flex-1"></span>
		</section>
		</section>

		<div class="d-flex flex-row-reverse mb-45">
			<a href="#" @click.prevent="print()" class="btn btn-default min-w-150 no-print">Print</a>
			<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
		</div>
	</div>
</template>

<script>
export default {
	props:['pbranch','token'],
	data(){
		return {
			branch:{},
			reports:[],
			filter:{
				date_from:null
			}
		}
	},
	methods:{
		async fetchReports(){
			await axios.post(this.baseURL() + 'api/report/prepaid', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.reports = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		print:function(){
			var content = document.getElementById('printContent').innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			window.print();
		},
	},
	computed:{
		filteredReports:function(){
			var rows = [];
			var overall = ['TOTAL',0,'','',0,0,0,'',0,0,0,0,0,0,0,0,0,0,0,0,0];
			this.reports.forEach(r=>{
				if(!this.isEmptyObj(r.history)){
					var counter = 0;
					for(var i in r.history){
						var row = [];
						var total = 0;
						if(counter==0){
							var mCount = 8;
							row.push(r.client);
							row.push(this.formatToCurrency(r.amount_loan));
							overall[1] += r.amount_loan;
							row.push(r.due_date);
							row.push(r.term);
							row.push(this.formatToCurrency(r.total_uid));
							overall[4] += r.total_uid;
							row.push(this.formatToCurrency(r.balance));
							overall[5] += r.balance;
							row.push(this.formatToCurrency(r.monthly_uid));
							overall[6] += r.monthly_uid;
							counter++;
						}else{
							row.push(['','','','','','',''])
						}
						row.push(i);
						for(var j in r.history[i]){
							total += r.history[i][j];
							overall[mCount] += r.history[i][j];
							mCount++;
							row.push(this.formatToCurrency(r.history[i][j]));
						}
						overall[20] += total;
						row.push(this.formatToCurrency(total));
						rows.push(row);
					};
				}else{
					var row = [];
					row.push(r.client);
					row.push(this.formatToCurrency(r.amount_loan));
					overall[1] += r.amount_loan;
					row.push(r.due_date);
					row.push(r.term);
					row.push(this.formatToCurrency(r.total_uid));
					overall[4] += r.total_uid;
					row.push(this.formatToCurrency(r.balance));
					overall[5] += r.balance;
					row.push(this.formatToCurrency(r.monthly_uid));
					overall[6] += r.monthly_uid;
					for(var k=0;k<14;k++){
						row.push('')
					}
					rows.push(row);
				}
			});
			var finalOverall = [];
			overall.forEach(ov=>{
				if(ov!==''&&ov!='TOTAL'){
					finalOverall.push(this.formatToCurrency(ov))
				}else{
					finalOverall.push(ov);
				}
			});
			return {
				rows:rows,
				overall:finalOverall
			}
		}
	},
	watch:{
		'filter.date_from':function(){
			this.fetchReports();
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
	}
}
</script>