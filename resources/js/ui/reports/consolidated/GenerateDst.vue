<template>
   <div class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-row font-md mb-16">
			<span class="flex-2"></span>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:1">
				<span class="mr-10">Date From: </span>
				<input v-model="filter.date_from" type="date" class="form-control flex-1">
			</div>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:1">
				<span class="mr-10">Date To: </span>
				<input v-model="filter.date_to" type="date" class="form-control flex-1">
			</div>
			<!-- <div class="d-flex flex-row align-items-center mr-24" style="flex:1">
				<span class="mr-10">Acc. Officer: </span>
				<select v-model="filter.account_officer" name="" id="selectProductClient" class="form-control flex-1">
					<option v-for="ao in aos" :key="ao.ao_id" :value="ao.ao_id">{{ao.name}}</option>
					<option value="all">All</option>
				</select>
			</div>	
			<div class="d-flex flex-row align-items-center mr-24" style="flex:1">
				<span class="mr-10">Product: </span>
				<select v-model="filter.product" name="" id="selectProductClient" class="form-control flex-1">
					<option v-for="product in products" :key="product.product_id" :value="product.product_id">{{product.product_name}}</option>
					<option value="all">All</option>
				</select>
			</div>				 -->
		</div>
		<div class="sep mb-45"></div>
		<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">


		<section class="mb-72" id="performanceReport">
			<div class="d-flex flex-column mb-24">
				<div class="d-flex flex-row align-items-center">
					<div class="flex-1 d-flex flex-column">
					
					</div>
					<span class="font-30 text-bold text-primary-dark text-center">DOCUMENTARY STAMP TAXES</span>
					<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
						<current-transactiondate :branch="branch.branch_id" :token="token" :reports="true"></current-transactiondate>
						<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
					</div>
				</div>
				<!-- <span class="text-center text-primary-dark text-bold">As of {{filter.as_of?dateToMDY2(new Date(filter.as_of)).split('-').join('/'):'---'}}</span> -->
				<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name}} Branch ({{branch.branch_code}})</span>
				<div class="d-flex flex-row justify-content-center text-primary-dark">
					<span class="mr-5">From:</span><span class="mr-16">{{filter.date_from?filter.date_from:'---'}}</span>
					<span class="mr-5">To:</span><span>{{filter.date_to?filter.date_to:'---'}}</span>
				</div>
			</div>
			<section class="d-flex flex-column mb-16 p-10 light-border">
				<span class="text-bold bg-yellow-light" style="padding:2px 5px;">SUMMARY</span>
				<table class="table td-nb table-thin">
					<thead>
						<th>Term</th>
						<th>Butuan</th>
						<th>Nasipit</th>
						<th>Gingoog</th>
						<th>Total Amount</th>
						<!-- <th>Amount</th> -->
					</thead>
					<tbody>
						<tr v-for="r,i in computedReports.rows" :key="i">
							<td v-for="d,j in r" :key="j">{{d}}</td>
						</tr>
						<tr v-if="computedReports.rows.length" class="text-bold bt-8">
							<td v-for="total,k in computedReports.total" :key="k">{{total}}</td>
						</tr>
						<tr v-else><td><i>No records found.</i></td></tr>
					</tbody>
				</table>

			</section>
		</section>

		<section class="d-flex flex-row mb-72">
			<span class="flex-2 pb-24 text-bold darker-bb mr-64">Prepared By:</span>
			<span class="flex-2 pb-24 text-bold darker-bb mr-64">Certified Corrected By:</span>
			<span class="flex-2 pb-24 text-bold darker-bb mr-64">Approved By:</span>
			<span class="flex-1"></span>
		</section>

		<div class="d-flex flex-row justify-content-end mb-45">
			<div class="d-flex flex-row-reverse">
				<a href="#" class="btn btn-default min-w-150">Print</a>
				<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props:['pbranch','token'],
	data(){
		return {
			branch:{},
			filter:{
				date_from:'',
				date_to:'',
				category:'dst'
			},
			reports:[],
			products:[],
			aos:[]
		}
	},
    methods: {
		async fetchReports(){
			await axios.post(this.baseURL() + 'api/report/release', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.reports = response.data.data;
				console.log(response.data);
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
    },
	computed:{
		computedReports:function(){
			var rows = {rows:[],total:['',0,0,0,0]};
			for(var i in this.reports){
				var row = [];
				var count = 1;
				var report = this.reports[i];
				row.push(report.term);
				for(var j in report.branches){
					var branch = report.branches[j];
					row.push(this.formatToCurrency(branch));
					rows.total[count] += branch;
					count++;
				}
				row.push(this.formatToCurrency(report.total_amount))
				rows.total[4] += report.total_amount;
				rows.rows.push(row);
			}
			rows.total[1] = this.formatToCurrency(rows.total[1]);
			rows.total[2] = this.formatToCurrency(rows.total[2]);
			rows.total[3] = this.formatToCurrency(rows.total[3]);
			rows.total[4] = this.formatToCurrency(rows.total[4]);
			return rows;
		}
	},
	watch:{
		filter:{
			handler(val){
				if(val.date_from.length && val.date_to.length){
					this.fetchReports();
				}
			},
			deep:true
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
		this.filter.branch_id = this.branch.branch_id;
	}
};
</script>
