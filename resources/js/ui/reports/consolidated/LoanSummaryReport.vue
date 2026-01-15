<template>
	<div class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-row font-md mb-16">
			<span class="flex-2"></span>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:1">
				<span class="mr-10">As of: </span>
				<input type="date" class="form-control flex-1">
			</div>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:1">
				<span class="mr-10">Acc. Officer: </span>
				<select name="" id="selectProductClient" class="form-control flex-1">
					<option value="">All</option>
				</select>
			</div>	
			<div class="d-flex flex-row align-items-center mr-24" style="flex:1">
				<span class="mr-10">Product: </span>
				<select name="" id="selectProductClient" class="form-control flex-1">
					<option value="">All</option>
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
					<span class="font-30 text-bold text-primary-dark text-center">Consolidated Loan Summary Report</span>
					<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
						<current-transactiondate :branch="branch.branch_id" :token="token" :reports="true"></current-transactiondate>
						<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
					</div>
				</div>
				<span class="text-center text-primary-dark text-bold">As of 12/12/2021</span>
				<span class="text-center text-primary-dark text-bold font-md mb-5">Butuan Branch (001)</span>
			</div>
			<section class="d-flex flex-column mb-16 p-10 light-border">
				<table class="table table-stripped mb-24">
					<thead>
						<th>Status</th>
						<th># Acct.</th>
						<th>Amnt. Loan</th>
						<th>Loan Portfolio</th>
						<th>Balance</th>
						<th>Amnt. Due</th>
					</thead>
					<tbody>
						<tr>
							<td>CURRENT</td>
							<td>0</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
						</tr>
						<tr>
							<td>DELINQUENT</td>
							<td>0</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
						</tr>
						<tr>
							<td>PAST DUE</td>
							<td>0</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
						</tr>
						<tr>
							<td>RESTRICTED</td>
							<td>8,875.00</td>
							<td>44,375,000.00</td>
							<td>94,287,775.00</td>
							<td>123,401,000.00</td>
							<td>123,401,000.00</td>
						</tr>
						<tr>
							<td>RES WO/PDI</td>
							<td>0</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
						</tr>
						<tr>
							<td>CASE FILED</td>
							<td>0</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
						</tr>
						<tr>
							<td>LITIGATED</td>
							<td>0</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
						</tr>
						<tr>
							<td>WRITE-OFF</td>
							<td>0</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
							<td>0.00</td>
						</tr>
						<tr class="bg-skyblue text-bold">
							<td>TOTAL</td>
							<td>8,875.00</td>
							<td>44,375,000.00</td>
							<td>94,287,775.00</td>
							<td>123,401,000.00</td>
							<td>123,401,000.00</td>
						</tr>
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
				due_from:'',
				due_to:'',
				type:''
			}
		}
	},
    methods: {
        print: function () {
            var content = document.getElementById("printContent").innerHTML;
            var target = document.querySelector(".to-print");
            target.innerHTML = content;
            window.print();
        },
    },
	mounted(){
		this.branch = JSON.parse(this.pbranch);
	}
};
</script>
