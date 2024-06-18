<template>
	<div id="printContent" class="d-flex flex-column" style="flex:8;">
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
		<form @submit.prevent="fetchReports" action="">
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark no-print" style="flex:4">Prepaid Interest</span>
			<div class="d-flex flex-row align-items-center mr-24 no-print" style="flex:2">
				<span class="mr-10">Post Date: </span>
				<input v-model="filter.due_from" type="month" class="form-control flex-1" required>
			</div>
			<div class="d-flex flex-row align-items-center mr-24 justify-content-start flex-1">
				<button class="btn btn-primary">Generate</button>
			</div>
			<!-- <div class="d-flex flex-row align-items-center" style="flex:2">
				<span class="mr-10">To: </span>
				<input type="date" class="form-control">
			</div> -->
		</div>
		</form>
		<div class="sep mb-45"></div>
		<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">



		<section class="" id="productSection">
			<div class="d-flex flex-column mb-16">
				<div class="d-flex flex-row align-items-center">
					<div class="flex-1"></div>
					<span class="font-30 text-bold text-primary-dark">PREPAID INTEREST REPORT</span>
					<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
						<current-transactiondate :branch="branch.branch_id" :token="token" :reports="true"></current-transactiondate>
						<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
					</div>
				</div>
				<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name}} Branch ({{branch.branch_code}})</span>
				<div class="d-flex flex-row justify-content-center text-primary-dark">
					<span class="text-center text-primary-dark text-bold">Post Date: {{filter.due_from?dateToMDY2(new Date(filter.due_from)).split('-').join('/'):'---'}}</span>
				</div>
			</div>
			<section class="d-flex flex-column mb-45">
				<table class="table table-stripped table-thin" style="font-size:13px">
					<thead>
						<tr>
							<th>Client</th>
							<th>Amount</th>
							<th>Maturity Date</th>
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
			<a href="#" @click="saveJournalEntry" class="btn btn-success min-w-150 mr-24">Post</a>
		</div>
	</div>
</template>

<script>
export default {
	props:['pbranch','token'],
	data(){
		return {
			loading:false,
			branch:{},
			reports:[],
			filter:{
				due_from:null,
				branch_id:null,
			},
		}
	},
	methods:{
		async fetchReports(){
			this.loading = true;
			await axios.post(this.baseURL() + 'api/report/prepaid', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.reports = response.data.data;
				this.loading = false;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
				this.loading = false;
			}.bind(this));
		},
		async saveJournalEntry(){
			var data = {
				branch_id: this.branch.branch_id,
				amount:this.filteredReports.monthlyTotal[this.dateToM(new Date(this.filter.due_from)) - 1]
			}
			await axios.post(this.baseURL() + 'api/report/create-journal-entry', data, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.notify('','Journal Entry has been successfully posted.', 'success');
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		notify:function(title, text, type){
			this.$notify({
				group: 'foo',
				title: title,
				text: text,
				type: type,
			});
		},
		print:function(){
			var content = document.getElementById('printContent').innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			window.print();
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
		filteredReports:function(){
			var monNum = ['01','02','03','04','05','06','07','08','09','10','11','12'];
			var rows = [];
			var overall = ['TOTAL',0,'','',0,0,0,'',0,0,0,0,0,0,0,0,0,0,0,0,0];
			this.reports.sort(this.sortClient).forEach(r=>{
				if(!this.isEmptyObj(r.history)){
					var counter = 0;
					for(var i in r.history){
						var mCount = 8;
						var row = [];
						var total = 0;
						if(counter==0){
							row.push(r.client);
							row.push(this.formatToCurrency(r.amount_loan));
							overall[1] += r.amount_loan;
							row.push(this.dateToMDY(new Date(r.due_date)));
							row.push(r.term);
							row.push(this.formatToCurrency(r.total_uid));
							overall[4] += r.total_uid;
							row.push(this.formatToCurrency(r.balance));
							overall[5] += r.balance;
							row.push(this.formatToCurrency(r.monthly_uid));
							overall[6] += r.monthly_uid;
							counter++;
						}else{
							for(var u = 0; u < 7; u++){
								row.push('');
							}
						}
						row.push(i);
						for(k in monNum){
							for(var j in r.history[i]){
								if(monNum[k] == j){
									total += r.history[i][j];
									overall[20] += r.history[i][j];
									if(mCount < 20){
										overall[mCount] += r.history[i][j];
									}
									mCount++;
									row.push(this.formatToCurrency(r.history[i][j]));
								}
							}
						}
						// overall[20] += total;
						// console.log(total + ' - ' + overall[20]);
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
			var ovcount = 0;
			var monthlyTotal = [];
			overall.forEach(ov=>{
				if(ov!==''&&ov!='TOTAL'){
					finalOverall.push(this.formatToCurrency(ov))
				}else{
					finalOverall.push(ov);
				}
				if(ovcount > 7){
					monthlyTotal.push(ov)
				}
				ovcount++;
			});
			
			return {
				rows:rows,
				overall:finalOverall.slice(0,21),
				monthlyTotal:monthlyTotal.slice(0,12)
			}
		}
	},
	watch:{
		// filter: {
		// 	handler(val){
		// 		if(val.due_from && val.branch_id){
		// 			this.fetchReports();
		// 		}
		// 	},
		// 	deep: true
		// }
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
		this.filter.branch_id = this.branch.branch_id;
	}
}
</script>