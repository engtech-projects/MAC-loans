<template>
   <div class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-row font-md mb-16">
			<span class="flex-2"></span>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:1">
				<span class="mr-10">As of: </span>
				<input v-model="filter.as_of" type="date" class="form-control flex-1">
			</div>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:1">
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
			</div>				
		</div>
		<div class="sep mb-45"></div>
		<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">


		<section class="mb-72" id="performanceReport">
			<div class="d-flex flex-column mb-24">
				<div class="d-flex flex-row align-items-center">
					<div class="flex-1 d-flex flex-column">
					
					</div>
					<span class="font-30 text-bold text-primary-dark text-center">Loan Aging Summary</span>
					<div class="flex-1" style="padding-left:24px">
						<span class="text-primary-dark mr-10">{{dateFullDay(new Date())}} {{dateToYMD(new Date()).split('-').join('/')}}</span>
						<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
					</div>
				</div>
				<span class="text-center text-primary-dark text-bold">As of {{filter.as_of?dateToMDY2(new Date(filter.as_of)).split('-').join('/'):'---'}}</span>
				<span class="text-center text-primary-dark text-bold font-md mb-5">Butuan Branch (001)</span>
			</div>
			<section class="d-flex flex-column mb-16 p-10 light-border">
				<table class="table table-stripped mb-24">
					<thead>
						<th>STATUS</th>
						<th>DAYS</th>
						<th># Acct.</th>
						<th>Amnt. Loan</th>
						<th>Balance</th>
						<th>Amnt. Due</th>
					</thead>
					<tbody>
						<tr v-if="!filteredResults.length"><td><i>No records found.</i></td></tr>
						<tr :class="fr[0].includes('TOTAL')?'text-bold bg-skyblue':''" v-for="fr,i in filteredResults" :key="i">
							<td v-for="j,k in fr" :key="k">{{k!==0&&k!==1?formatToCurrency(j):j}}</td>
							<!-- <td>1-30</td>
							<td>74</td>
							<td>2,106,000.00</td>
							<td>1,384,805.00</td>
							<td>-63,428.00</td> -->
						</tr>
						<!-- <tr v-for="fr,i in filteredResults" :key="i">
							<td>CURRENT</td>
							<td>1-30</td>
							<td>74</td>
							<td>2,106,000.00</td>
							<td>1,384,805.00</td>
							<td>-63,428.00</td>
						</tr>
						<tr>
							<td></td>
							<td>31-60</td>
							<td>20</td>
							<td>287,000.00</td>
							<td>136,399.00</td>
							<td>14,461.00</td>
						</tr>
						<tr>
							<td></td>
							<td>61-90</td>
							<td>7</td>
							<td>119,000.00</td>
							<td>76,453.00</td>
							<td>-58,219.00</td>
						</tr>
						<tr>
							<td></td>
							<td>91-180</td>
							<td>5</td>
							<td>95,000.00</td>
							<td>58,420.00</td>
							<td>3,748.00</td>
						</tr>
						<tr>
							<td></td>
							<td>180 Above</td>
							<td>3</td>
							<td>184,000.00</td>
							<td>159,634.00</td>
							<td>1,810.00</td>
						</tr>
						<tr class="text-bold bg-skyblue">
							<td>Current TOTAL</td>
							<td></td>
							<td>80</td>
							<td>4,338.00</td>
							<td>1,810.00</td>
							<td>4,338.00</td>
						</tr>


						<tr>
							<td>DELINQUENT</td>
							<td>1-30</td>
							<td>74</td>
							<td>2,106,000.00</td>
							<td>1,384,805.00</td>
							<td>-63,428.00</td>
						</tr>
						<tr>
							<td></td>
							<td>31-60</td>
							<td>20</td>
							<td>287,000.00</td>
							<td>136,399.00</td>
							<td>14,461.00</td>
						</tr>
						<tr>
							<td></td>
							<td>61-90</td>
							<td>7</td>
							<td>119,000.00</td>
							<td>76,453.00</td>
							<td>-58,219.00</td>
						</tr>
						<tr>
							<td></td>
							<td>91-180</td>
							<td>5</td>
							<td>95,000.00</td>
							<td>58,420.00</td>
							<td>3,748.00</td>
						</tr>
						<tr>
							<td></td>
							<td>180 Above</td>
							<td>3</td>
							<td>184,000.00</td>
							<td>159,634.00</td>
							<td>1,810.00</td>
						</tr>
						<tr class="text-bold bg-skyblue">
							<td>Delinquent TOTAL</td>
							<td></td>
							<td>80</td>
							<td>4,338.00</td>
							<td>1,810.00</td>
							<td>4,338.00</td>
						</tr>


						<tr>
							<td>PAST DUE</td>
							<td>1-30</td>
							<td>74</td>
							<td>2,106,000.00</td>
							<td>1,384,805.00</td>
							<td>-63,428.00</td>
						</tr>
						<tr>
							<td></td>
							<td>31-60</td>
							<td>20</td>
							<td>287,000.00</td>
							<td>136,399.00</td>
							<td>14,461.00</td>
						</tr>
						<tr>
							<td></td>
							<td>61-90</td>
							<td>7</td>
							<td>119,000.00</td>
							<td>76,453.00</td>
							<td>-58,219.00</td>
						</tr>
						<tr>
							<td></td>
							<td>91-180</td>
							<td>5</td>
							<td>95,000.00</td>
							<td>58,420.00</td>
							<td>3,748.00</td>
						</tr>
						<tr>
							<td></td>
							<td>180 Above</td>
							<td>3</td>
							<td>184,000.00</td>
							<td>159,634.00</td>
							<td>1,810.00</td>
						</tr>
						<tr class="text-bold bg-skyblue">
							<td>Past Due TOTAL</td>
							<td></td>
							<td>80</td>
							<td>4,338.00</td>
							<td>1,810.00</td>
							<td>4,338.00</td>
						</tr>


						<tr>
							<td>RESTRUCTED</td>
							<td>1-30</td>
							<td>74</td>
							<td>2,106,000.00</td>
							<td>1,384,805.00</td>
							<td>-63,428.00</td>
						</tr>
						<tr>
							<td></td>
							<td>31-60</td>
							<td>20</td>
							<td>287,000.00</td>
							<td>136,399.00</td>
							<td>14,461.00</td>
						</tr>
						<tr>
							<td></td>
							<td>61-90</td>
							<td>7</td>
							<td>119,000.00</td>
							<td>76,453.00</td>
							<td>-58,219.00</td>
						</tr>
						<tr>
							<td></td>
							<td>91-180</td>
							<td>5</td>
							<td>95,000.00</td>
							<td>58,420.00</td>
							<td>3,748.00</td>
						</tr>
						<tr>
							<td></td>
							<td>180 Above</td>
							<td>3</td>
							<td>184,000.00</td>
							<td>159,634.00</td>
							<td>1,810.00</td>
						</tr>
						<tr class="text-bold bg-skyblue">
							<td>Restructed TOTAL</td>
							<td></td>
							<td>80</td>
							<td>4,338.00</td>
							<td>1,810.00</td>
							<td>4,338.00</td>
						</tr>


						<tr>
							<td>RES WO / PDI</td>
							<td>1-30</td>
							<td>74</td>
							<td>2,106,000.00</td>
							<td>1,384,805.00</td>
							<td>-63,428.00</td>
						</tr>
						<tr>
							<td></td>
							<td>31-60</td>
							<td>20</td>
							<td>287,000.00</td>
							<td>136,399.00</td>
							<td>14,461.00</td>
						</tr>
						<tr>
							<td></td>
							<td>61-90</td>
							<td>7</td>
							<td>119,000.00</td>
							<td>76,453.00</td>
							<td>-58,219.00</td>
						</tr>
						<tr>
							<td></td>
							<td>91-180</td>
							<td>5</td>
							<td>95,000.00</td>
							<td>58,420.00</td>
							<td>3,748.00</td>
						</tr>
						<tr>
							<td></td>
							<td>180 Above</td>
							<td>3</td>
							<td>184,000.00</td>
							<td>159,634.00</td>
							<td>1,810.00</td>
						</tr>
						<tr class="text-bold bg-skyblue">
							<td>Res Wo/ PDI TOTAL</td>
							<td></td>
							<td>80</td>
							<td>4,338.00</td>
							<td>1,810.00</td>
							<td>4,338.00</td>
						</tr>


						<tr>
							<td>CASE FILED</td>
							<td>1-30</td>
							<td>74</td>
							<td>2,106,000.00</td>
							<td>1,384,805.00</td>
							<td>-63,428.00</td>
						</tr>
						<tr>
							<td></td>
							<td>31-60</td>
							<td>20</td>
							<td>287,000.00</td>
							<td>136,399.00</td>
							<td>14,461.00</td>
						</tr>
						<tr>
							<td></td>
							<td>61-90</td>
							<td>7</td>
							<td>119,000.00</td>
							<td>76,453.00</td>
							<td>-58,219.00</td>
						</tr>
						<tr>
							<td></td>
							<td>91-180</td>
							<td>5</td>
							<td>95,000.00</td>
							<td>58,420.00</td>
							<td>3,748.00</td>
						</tr>
						<tr>
							<td></td>
							<td>180 Above</td>
							<td>3</td>
							<td>184,000.00</td>
							<td>159,634.00</td>
							<td>1,810.00</td>
						</tr>
						<tr class="text-bold bg-skyblue">
							<td>Case Filed TOTAL</td>
							<td></td>
							<td>80</td>
							<td>4,338.00</td>
							<td>1,810.00</td>
							<td>4,338.00</td>
						</tr>


						<tr>
							<td>LITIGATED</td>
							<td>1-30</td>
							<td>74</td>
							<td>2,106,000.00</td>
							<td>1,384,805.00</td>
							<td>-63,428.00</td>
						</tr>
						<tr>
							<td></td>
							<td>31-60</td>
							<td>20</td>
							<td>287,000.00</td>
							<td>136,399.00</td>
							<td>14,461.00</td>
						</tr>
						<tr>
							<td></td>
							<td>61-90</td>
							<td>7</td>
							<td>119,000.00</td>
							<td>76,453.00</td>
							<td>-58,219.00</td>
						</tr>
						<tr>
							<td></td>
							<td>91-180</td>
							<td>5</td>
							<td>95,000.00</td>
							<td>58,420.00</td>
							<td>3,748.00</td>
						</tr>
						<tr>
							<td></td>
							<td>180 Above</td>
							<td>3</td>
							<td>184,000.00</td>
							<td>159,634.00</td>
							<td>1,810.00</td>
						</tr>
						<tr class="text-bold bg-skyblue">
							<td>Litigated TOTAL</td>
							<td></td>
							<td>80</td>
							<td>4,338.00</td>
							<td>1,810.00</td>
							<td>4,338.00</td>
						</tr>
						<tr>
							<td style="padding:45px"></td>
						</tr>
						<tr class="text-bold font-20" style="background-color:#bfffff">
							<td>TOTAL</td>
							<td></td>
							<td>2</td>
							<td>22,000.00</td>
							<td>4,338.00</td>
							<td>4,338.00</td>
						</tr> -->
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
				<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
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
				account_officer:'all',
				product:'all',
				as_of:'',
				branch_id:'',
				type:'loan_aging_summary'
			},
			reports:[],
			products:[],
			aos:[]
		}
	},
    methods: {
		async fetchReports(){
			await axios.post(this.baseURL() + 'api/report/branch', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.reports = response.data.data;n  
				console.log(this.reports);
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		async fetchProducts(){
			await axios.get(this.baseURL() + 'api/product/', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.products = response.data.data;
				this.fetchAo();
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
        print: function () {
            var content = document.getElementById("printContent").innerHTML;
            var target = document.querySelector(".to-print");
            target.innerHTML = content;
            window.print();
        },
    },
	computed:{
		filteredResults:function(){
			var rows = [];
			if(this.reports.current){
				var row = [];
				row.push('CURRENT');
				row.push('');
				row.push(this.reports.current.num_accts)
				row.push(this.reports.current.loan_amt)
				row.push(this.reports.current.balance)
				row.push(this.reports.current.due_amt)
				rows.push(row);
				var rowTotal = JSON.parse(JSON.stringify(row));
				rowTotal[0] = 'CURRENT TOTAL';
				rows.push(rowTotal);			}
			for(var i in this.reports){
				if(i != 'current'){
					var rowTotal = [i.toUpperCase() + ' TOTAL', '', 0,0,0,0];
					var count = 0;
					for (var j in this.reports[i]){
						var row = [];
						row.push(count==0?i.toUpperCase():'');
						row.push(j);
						row.push(this.reports[i][j].num_accts);
						rowTotal[2] += this.reports[i][j].num_accts;
						row.push(this.reports[i][j].loan_amt);
						rowTotal[3] += this.reports[i][j].loan_amt;
						row.push(this.reports[i][j].balance);
						rowTotal[4] += this.reports[i][j].balance;
						row.push(this.reports[i][j].due_amt);
						rowTotal[5] += this.reports[i][j].due_amt;
						count++;
						rows.push(row);
					}
					rows.push(rowTotal);
				}
			}
			return rows;
		}
	},
	watch:{
		 filter: {
			handler(val){
				if(val.as_of && val.product && val.account_officer){
					this.fetchReports();
				}
			},
			deep: true
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
		this.filter.branch_id = this.branch.branch_id;
		this.fetchProducts();
	}
};
</script>
