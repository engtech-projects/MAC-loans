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
									<span>Account Officer</span>
									<span class="text-bold">001 - Jose Magbanua</span>
								</div>
								<span class="font-30 text-bold text-primary-dark">MATURITY REPORT</span>
								<div class="flex-1 d-flex justify-content-end" style="padding-left:24px">
									<span class="text-primary-dark mr-10">Tuesday 12/21/2021</span>
									<span class="text-primary-dark">Time: 11:36 AM</span>
								</div>
							</div>
							<span class="text-center text-primary-dark text-bold font-md mb-5">Butuan Branch (001)</span>
							<div class="d-flex flex-row justify-content-center text-primary-dark">
								<span class="mr-5">From:</span><span class="mr-16">12/14/2021</span>
								<span class="mr-5">To:</span><span>12/15/2021</span>
							</div>
						</div>
						<section class="d-flex flex-column mb-16">
							<div>
								<table class="table table-thin table-stripped" style="font-size:14.2px;">
									<thead>
										<th>Client</th>
										<th>Granted</th>
										<th>Maturity</th>
										<th>Principal Balance</th>
										<th>Interest Balance</th>
										<th>Center</th>
									</thead>
									<tbody>
										<tr>
											<td>Gabriel, Julio A.</td>
											<td>12/15/2022</td>
											<td>12/15/2022</td>
											<td>2,845.00</td>
											<td>0.00</td>
											<td>NEEM TREE CENTER</td>
										</tr>
										<tr>
											<td>Gabriel, Julio A.</td>
											<td>12/15/2022</td>
											<td>12/15/2022</td>
											<td>2,845.00</td>
											<td>0.00</td>
											<td>NEEM TREE CENTER</td>
										</tr>
										<tr>
											<td>Gabriel, Julio A.</td>
											<td>12/15/2022</td>
											<td>12/15/2022</td>
											<td>2,845.00</td>
											<td>0.00</td>
											<td>NEEM TREE CENTER</td>
										</tr>
										<tr>
											<td>Gabriel, Julio A.</td>
											<td>12/15/2022</td>
											<td>12/15/2022</td>
											<td>2,845.00</td>
											<td>0.00</td>
											<td>NEEM TREE CENTER</td>
										</tr>
										<tr>
											<td>Gabriel, Julio A.</td>
											<td>12/15/2022</td>
											<td>12/15/2022</td>
											<td>2,845.00</td>
											<td>0.00</td>
											<td>NEEM TREE CENTER</td>
										</tr>
										<tr>
											<td>Gabriel, Julio A.</td>
											<td>12/15/2022</td>
											<td>12/15/2022</td>
											<td>2,845.00</td>
											<td>0.00</td>
											<td>NEEM TREE CENTER</td>
										</tr>
										<tr>
											<td>Gabriel, Julio A.</td>
											<td>12/15/2022</td>
											<td>12/15/2022</td>
											<td>2,845.00</td>
											<td>0.00</td>
											<td>NEEM TREE CENTER</td>
										</tr>
										<tr>
											<td>Gabriel, Julio A.</td>
											<td>12/15/2022</td>
											<td>12/15/2022</td>
											<td>2,845.00</td>
											<td>0.00</td>
											<td>NEEM TREE CENTER</td>
										</tr>
										<tr>
											<td>Gabriel, Julio A.</td>
											<td>12/15/2022</td>
											<td>12/15/2022</td>
											<td>2,845.00</td>
											<td>0.00</td>
											<td>NEEM TREE CENTER</td>
										</tr>
										<tr>
											<td>Gabriel, Julio A.</td>
											<td>12/15/2022</td>
											<td>12/15/2022</td>
											<td>2,845.00</td>
											<td>0.00</td>
											<td>NEEM TREE CENTER</td>
										</tr>
										<tr>
											<td>Gabriel, Julio A.</td>
											<td>12/15/2022</td>
											<td>12/15/2022</td>
											<td>2,845.00</td>
											<td>0.00</td>
											<td>NEEM TREE CENTER</td>
										</tr>
										<tr>
											<td>Gabriel, Julio A.</td>
											<td>12/15/2022</td>
											<td>12/15/2022</td>
											<td>2,845.00</td>
											<td>0.00</td>
											<td>NEEM TREE CENTER</td>
										</tr>
										<tr class="border-cell-gray-7">
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
										</tr>
										<tr class="tr-py-7 text-bold bg-green-mint">
											<td>TOTAL</td>
											<td></td>
											<td>15</td>
											<td>17,800.00</td>
											<td>14,300.00</td>
											<td></td>
										</tr>
									</tbody>
								</table>
							</div>
						</section>
					</section>

					<section class="d-flex flex-row mb-72">
						<span class="flex-2 pb-24 text-bold darker-bb mr-64">Prepared By:</span>
						<span class="flex-2 pb-24 text-bold darker-bb mr-64">Certified Corrected By:</span>
						<span class="flex-2 pb-24 text-bold darker-bb mr-64">Approved By:</span>
						<span class="flex-1"></span>
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