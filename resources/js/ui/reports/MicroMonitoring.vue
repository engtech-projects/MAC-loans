<template>
	<div class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark" style="flex:4">Micro Monitoring</span>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">Date: </span>
				<input v-model="filter.date" type="month" class="form-control">
			</div>
			<!-- <div class="d-flex flex-row align-items-center" style="flex:2">
				<span class="mr-10">To: </span>
				<input v-model="filter.date_to" type="date" class="form-control">
			</div> -->
		</div>
		<div class="sep mb-45"></div>
		<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">

		<section class="" id="productSection">
			<div class="d-flex flex-column mb-16">
				<div class="d-flex flex-row align-items-center">
					<div class="flex-1"></div>
					<span class="font-30 text-bold text-primary-dark">MICRO MONITORING - BY CENTER</span>
					<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
						<current-transactiondate :branch="branch" :token="token" :reports="true"></current-transactiondate>
						<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
					</div>
				</div>
				<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch_name + ' Branch (' + branch_code + ')'}}</span>
				<div class="d-flex flex-row justify-content-center text-primary-dark">
					<span class="mr-16">{{this.dateToFullMonth(new Date(filter.date)) + ' ' + new Date(filter.date).getFullYear()}}</span>
				</div>
			</div>
			<section class="d-flex flex-column mb-45">
				<table class="table table-thin table-bordered tv-center mb-24">
					<thead style="font-size:12px">
						<tr>
							<th colspan="6">MICRO GROUP MONITORING</th>
							<th v-for="(w, i) in tranSched" :key="w.start" colspan="2">Week {{parseInt(i) + 1}}</th>
							<th rowspan="2">Total Amt.</th>
						</tr>
						<tr>
							<th>#</th>
							<th>Center</th>
							<th>No. Clients</th>
							<th>Active</th>
							<th>Areas of Ope.</th>
							<th>Sched</th>
							<th v-for="(s, i) in schedHeader" :key="i">{{s}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(m, i) in group.rows" :key="i" :class="m[0]==''?'td-nb text-bold bg-yellow-pale':''">
							<td v-for="(j, k) in m" :key="k">{{j}}</td>
						</tr>
						<tr class="text-bold bg-skyblue bt-8">
							<td v-for="over,m in group.overall" :key="m">{{over}}</td>
						</tr>
					</tbody>
				</table>


				<table class="table table-thin td-nb td-br table-bordered tv-center">
					<thead>
						<tr>
							<th colspan="4">MICRO INDIVIDUAL COLLECTION MONITORING</th>
							<th v-for="(t, i) in tranSched" :key="i">Week {{i + 1}}</th>
							<th rowspan="2">Total Amount Collected</th>
						</tr>
						<tr>
							<th>#</th>
							<th>Name of Client</th>
							<th>Areas of Ope.</th>
							<th>Schedule</th>
							<th v-for="s in individualSchedHeaader" :key="s">{{s}}</th>
						</tr>
					</thead>
					<tbody>
						<tr v-if="!transactions.individual.length"><td>No data available.</td></tr>
						<tr v-for="(t,i) in individual" :key="i" :class="t[0]=='TOTAL SUMMARY'?'text-bold bg-green-mint':''">
							<td v-for="(j,k) in t" :key="k">{{j}}</td>
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
			<a href="#" class="btn btn-default min-w-150">Print</a>
			<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
		</div>
	</div>
</template>

<script>
export default {
	props:['token', 'branch', 'branch_name', 'branch_code'],
	data(){
		return {
			transactions:{schedule:[],group:[],individual:[]},
			filter:{
				date:'',
				branch_id:'',
			}
		}
	},
	methods:{
		async fetchTransactions(){
			await axios.post(this.baseURL() + 'api/report/micro', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.transactions = response.data.data;
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
		tranSched:function(){
			var data = [];
			for(var i in this.transactions.schedule){
				if(this.transactions.schedule[i].start){
					data.push(this.transactions.schedule[i])
				}
			}
			return data;
		},
		schedHeader:function(){
			var sched = [];
			this.tranSched.forEach(t=>{
				sched.push('Active');
				if(t.start != t.end){
					sched.push(this.dateToHalfMonth(new Date(t.start)) + '.' + new Date(t.start).getDate() + '-' + new Date(t.end).getDate());
				}else{
					sched.push(this.dateToHalfMonth(new Date(t.start)) + '.' + new Date(t.start).getDate());
				}
			})
			return sched;
		},
		individualSchedHeaader:function(){
			return this.schedHeader.filter(s=>s!='Active')
		},
		groupTransaction:function(){
			var days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']
			var group = {};
			days.forEach(d=>{
				for(var i in this.transactions.group){
					if(d == i){
						group[d]=this.transactions.group[i];
					}
				}
			})
			return  group;
		},
		group:function(){
			var data = {rows:[],overall:[]};
			var overall = ['','TOTAL',0,0,'',''];
			var overallCollection = 0;
			for(var i in this.groupTransaction){
				if(this.groupTransaction[i].length !== 0){
					var count = 1;
					var totalRow = ['','','','','',''];
					var coll = 0;
					for(var p in this.groupTransaction[i]){
						var row = [];
						var weekly = this.groupTransaction[i][p].weeklyData;
						var collection = 0
						var c= 6;
						row.push(count);
						row.push(p);
						row.push(this.groupTransaction[i][p].all.no_of_clients);
						overall[2] += this.groupTransaction[i][p].all.no_of_clients
						row.push(this.groupTransaction[i][p].all.num_of_payments);
						overall[3] += this.groupTransaction[i][p].all.num_of_payments?this.groupTransaction[i][p].all.num_of_payments:0;
						console.log(this.groupTransaction[i][p].all.num_of_payments);
						row.push(this.groupTransaction[i][p].all.area_of_operation);
						row.push(i.toUpperCase().slice(0,3));
						for(var w in weekly){
							totalRow[c] = !totalRow[c]?0:totalRow[c];
							overall[c] = !overall[c]?0:overall[c];
							row.push(weekly[w].num_of_payments);
							totalRow[c] += parseFloat(weekly[w].num_of_payments);
							overall[c] += parseFloat(weekly[w].num_of_payments);
							c++;
							totalRow[c] = !totalRow[c]?0:totalRow[c];
							overall[c] = !overall[c]?0:overall[c];
							row.push(weekly[w].total_paid);
							totalRow[c] += parseFloat(weekly[w].total_paid);
							overall[c] += parseFloat(weekly[w].total_paid);
							collection += parseFloat(weekly[w].total_paid);
							c++;
						}
						coll += collection;
						overallCollection += collection;
						row.push(collection);
						count++;
						data.rows.push(row);
					}
					totalRow.push(coll);
					data.rows.push(totalRow);
				}
			}
			overall.push(overallCollection);
			data.overall = overall;
			return data;
		},
		individual:function(){
			var data = this.transactions.individual;
			var result = [];
			var weeklyRow = ['TOTAL SUMMARY','','',''];
			for(var i in data){
				var index = 4;
				var row = [];
				var total = 0;
				row.push(parseInt(i) + 1);
				row.push(data[i].borrower);
				row.push(data[i].center);
				row.push(data[i].centerSched.toUpperCase().slice(0,3));
				for(var w in data[i].weeklyData){
					weeklyRow[index] = !weeklyRow[index]?0:weeklyRow[index];
					weeklyRow[index] += data[i].weeklyData[w].total_paid;
					row.push(data[i].weeklyData[w].total_paid);
					total += parseFloat(data[i].weeklyData[w].total_paid);
					index++;
				}
				weeklyRow[index] = !weeklyRow[index]?0:weeklyRow[index];
				weeklyRow[index] += total;
				row.push(total);
				result.push(row);
			}
			result.push(weeklyRow);
			return result;
		}
	},
	watch:{
		'filter.date'(){
			this.fetchTransactions();
		}
	},
	mounted(){
		this.filter.branch_id = this.branch;
		this.filter.date = this.dateToYM(new Date);
	}
}
</script>