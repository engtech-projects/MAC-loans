<template>
	<div class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark" style="flex:3">Transaction</span>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">From: </span>
				<input type="date" class="form-control">
			</div>
			<div class="d-flex flex-row align-items-center mr-64" style="flex:2">
				<span class="mr-10">To: </span>
				<input type="date" class="form-control">
			</div>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:3">
				<span class="mr-10">Type: </span>
				<select name="" id="selectProductClient" class="form-control">
					<option value="all_records">All Records</option>
					<option value="new_accounts">New Accounts</option>
					<option value="">By Center</option>
					<option value="">By Product</option>
					<option value="">By Account Officer</option>
				</select>
			</div>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:3">
				<span class="mr-10">A.O: </span>
				<select name="" id="selectProductClient" class="form-control">
					<option value="">Allotment Loan</option>
					<option value="">Micro Group</option>
					<option value="">Micro Individual</option>
					<option value="">Pension Emergency</option>
					<option value="">Pension Loan</option>
					<option value="">SME Loan</option>
				</select>
			</div>
			<div class="d-flex flex-row align-items-center" style="flex:3">
				<span class="mr-10">Center: </span>
				<select name="" id="selectProductClient" class="form-control">
					<option value="">Allotment Loan</option>
					<option value="">Micro Group</option>
					<option value="">Micro Individual</option>
					<option value="">Pension Emergency</option>
					<option value="">Pension Loan</option>
					<option value="">SME Loan</option>
				</select>
			</div>
		</div>
		<div class="sep mb-45"></div>
		<div id="printContent">
			<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">
				<section class="mb-72" id="clientSection">
						<div class="d-flex flex-column mb-24">
							<div class="d-flex flex-row align-items-center">
								<div class="flex-1 d-flex flex-column">
								
								</div>
								<span class="font-30 text-bold text-primary-dark">MATURITY REPORT</span>
								<div class="flex-1 d-flex justify-content-end" style="padding-left:24px">
								
								</div>
							</div>
							<span class="text-center text-primary-dark text-bold font-md mb-5">Butuan Branch (001)</span>
						</div>
						<section class="d-flex flex-column align-items-start mb-24">
							<span class="pxy-7 font-20 bg-primary-dark text-white">Borrower's Number: 10054521124547</span>
							<span class="text-primary-dark font-20 text-bold">Name: Lagahit, Virginia C.</span>
							<span class="text-primary-dark font-20">Address: P-10 Brgy. San Mateo, Butuan City</span>
						</section>
						<section class="d-flex flex-column mb-16">
							<span class="bbt-8-light font-20 text-primary-dark text-center text-bold p-7">Performance of Previous Loan</span>
							<div class="p-10 light-border">
								<table class="table table-stripped th-blue">
									<thead>
										<th>Cumulative Loan</th>
										<th>Loan Acct.#</th>
										<th>Date Disbursed</th>
										<th>Amnt Loan Disbursed</th>
										<th># of Amort.</th>
										<th># of Late Amort.</th>
										<th>Max Days Late</th>
										<th>% Amort. Made on Time</th>
										<th>Business Activity</th>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td>10212455854574</td>
											<td>02/02/2021</td>
											<td>5,000.00</td>
											<td>12</td>
											<td>0</td>
											<td>66</td>
											<td>100%</td>
											<td>--</td>
										</tr>
										<tr>
											<td>1</td>
											<td>10212455854574</td>
											<td>02/02/2021</td>
											<td>5,000.00</td>
											<td>12</td>
											<td>0</td>
											<td>66</td>
											<td>100%</td>
											<td>--</td>
										</tr>
										<tr>
											<td>1</td>
											<td>10212455854574</td>
											<td>02/02/2021</td>
											<td>5,000.00</td>
											<td>12</td>
											<td>0</td>
											<td>66</td>
											<td>100%</td>
											<td>--</td>
										</tr>
										<tr>
											<td>1</td>
											<td>10212455854574</td>
											<td>02/02/2021</td>
											<td>5,000.00</td>
											<td>12</td>
											<td>0</td>
											<td>66</td>
											<td>100%</td>
											<td>--</td>
										</tr>
										<tr>
											<td>1</td>
											<td>10212455854574</td>
											<td>02/02/2021</td>
											<td>5,000.00</td>
											<td>12</td>
											<td>0</td>
											<td>66</td>
											<td>100%</td>
											<td>--</td>
										</tr>
									</tbody>
								</table>
							</div>
						</section>

						<section class="d-flex flex-column mb-16">
							<span class="bbt-8-light font-20 text-primary-dark text-center text-bold p-7 mb-16">Current Loan Information</span>
							<div class="d-flex mb-16 text-20 text-primary-dark">
								<div class="d-flex flex-column flex-1">
									<span>Loan Date: 01/13/21</span>
									<span># of Amortizations: 18</span>
									<span># of Amort. made on time to 12/21/2021: 8</span>
								</div>
								<div class="d-flex flex-column flex-1" flex-1>
									<span>Loan Amount: 50,000.00</span>
									<span># of Amortizations expected to date 12/21/2021: 11</span>
									<span>% Made on time to date 12/21/2021: 72.73%</span>
								</div>
							</div>
							<div class="p-10 light-border">
								<table class="table table-stripped th-blue">
									<thead>
										<th>Amor. No.</th>
										<th>Amor. Amount</th>
										<th>Amor. Due Date</th>
										<th>Amor. Paid Date</th>
										<th>Amor. Status</th>
										<th>Days Late</th>
									</thead>
									<tbody>
										<tr>
											<td>1</td>
											<td>3,777.00</td>
											<td>02/12/2021</td>
											<td>02/08/2021</td>
											<td>Paid</td>
											<td>0</td>
										</tr>
										<tr>
											<td>1</td>
											<td>3,777.00</td>
											<td>02/12/2021</td>
											<td>02/08/2021</td>
											<td>Paid</td>
											<td>0</td>
										</tr>
									
										<tr>
											<td>1</td>
											<td>3,777.00</td>
											<td>02/12/2021</td>
											<td>02/08/2021</td>
											<td>Paid</td>
											<td>0</td>
										</tr>
									
										<tr>
											<td>1</td>
											<td>3,777.00</td>
											<td>02/12/2021</td>
											<td>02/08/2021</td>
											<td>Paid</td>
											<td>0</td>
										</tr>
									
										<tr>
											<td>1</td>
											<td>3,777.00</td>
											<td>02/12/2021</td>
											<td>02/08/2021</td>
											<td>Paid</td>
											<td>0</td>
										</tr>
										<tr>
											<td>1</td>
											<td>3,777.00</td>
											<td>02/12/2021</td>
											<td>02/08/2021</td>
											<td>Paid</td>
											<td>0</td>
										</tr>
										<tr>
											<td>1</td>
											<td>3,777.00</td>
											<td>02/12/2021</td>
											<td>02/08/2021</td>
											<td>Paid</td>
											<td>0</td>
										</tr>
										<tr>
											<td>1</td>
											<td>3,777.00</td>
											<td>02/12/2021</td>
											<td>02/08/2021</td>
											<td>Paid</td>
											<td>0</td>
										</tr>
										<tr>
											<td>1</td>
											<td>3,777.00</td>
											<td>02/12/2021</td>
											<td>02/08/2021</td>
											<td>Paid</td>
											<td>0</td>
										</tr>
										<tr>
											<td>1</td>
											<td>3,777.00</td>
											<td>02/12/2021</td>
											<td>02/08/2021</td>
											<td>Paid</td>
											<td>0</td>
										</tr>
										<tr>
											<td>1</td>
											<td>3,777.00</td>
											<td>02/12/2021</td>
											<td>02/08/2021</td>
											<td>Paid</td>
											<td>0</td>
										</tr>
										<tr>
											<td>1</td>
											<td>3,777.00</td>
											<td>02/12/2021</td>
											<td>02/08/2021</td>
											<td>Paid</td>
											<td>0</td>
										</tr>
									
									</tbody>
								</table>
							</div>
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
	methods:{
		print:function(){
			var content = document.getElementById('printContent').innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			window.print();
		},
	}
}
</script>