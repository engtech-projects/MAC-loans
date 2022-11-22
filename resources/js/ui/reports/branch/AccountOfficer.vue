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
				<section class="mb-72" id="performanceReport">
						<div class="d-flex flex-column mb-24">
							<div class="d-flex flex-row align-items-center">
								<div class="flex-1 d-flex flex-column">
								
								</div>
								<span class="font-30 text-bold text-primary-dark">Account Officer Performace Report</span>
								<div class="flex-1 d-flex justify-content-end" style="padding-left:24px">
									
								</div>
							</div>
							<span class="text-center text-primary-dark text-bold">As of 12/12/2021</span>
							<span class="text-center text-primary-dark text-bold font-md mb-5">Butuan Branch (001)</span>
						</div>
						<section class="d-flex flex-column mb-16">
							<div class="p-10 light-border">
								<table class="table table-stripped th-blue th-nbt">
									<thead>
										<th>Account Officer</th>
										<th>Product</th>
										<th># Acct.</th>
										<th>Portfolio</th>
										<th># Acct.</th>
										<th>Delinquent Amount</th>
										<th>Due Rate</th>
										<th># Acct.</th>
										<th>Pastdue</th>
										<th>PD Rate</th>
									</thead>
									<tbody>
										<tr>
											<td>001 - John Mark Bacenas</td>
											<td>002 - Micro Group</td>
											<td>663</td>
											<td>1,866,321,00</td>
											<td>70</td>
											<td>106,205.00</td>
											<td>5.64%</td>
											<td>537</td>
											<td>1,477,405.00</td>
											<td>78.45%</td>
										</tr>
										<tr>
											<td></td>
											<td>002 - Micro Group</td>
											<td>663</td>
											<td>1,866,321,00</td>
											<td>70</td>
											<td>106,205.00</td>
											<td>5.64%</td>
											<td>537</td>
											<td>1,477,405.00</td>
											<td>78.45%</td>
										</tr>
										<tr>
											<td></td>
											<td>002 - Micro Group</td>
											<td>663</td>
											<td>1,866,321,00</td>
											<td>70</td>
											<td>106,205.00</td>
											<td>5.64%</td>
											<td>537</td>
											<td>1,477,405.00</td>
											<td>78.45%</td>
										</tr>
										<tr>
											<td></td>
											<td>002 - Micro Group</td>
											<td>663</td>
											<td>1,866,321,00</td>
											<td>70</td>
											<td>106,205.00</td>
											<td>5.64%</td>
											<td>537</td>
											<td>1,477,405.00</td>
											<td>78.45%</td>
										</tr>
										<tr>
											<td></td>
											<td>002 - Micro Group</td>
											<td>663</td>
											<td>1,866,321,00</td>
											<td>70</td>
											<td>106,205.00</td>
											<td>5.64%</td>
											<td>537</td>
											<td>1,477,405.00</td>
											<td>78.45%</td>
										</tr>
										<tr>
											<td></td>
											<td>002 - Micro Group</td>
											<td>663</td>
											<td>1,866,321,00</td>
											<td>70</td>
											<td>106,205.00</td>
											<td>5.64%</td>
											<td>537</td>
											<td>1,477,405.00</td>
											<td>78.45%</td>
										</tr>
										<tr class="bbt-8-light">
											<td class="text-primary-dark text-bold">OFFICER SUB-TOTAL</td>
											<td class="text-primary-dark text-bold"></td>
											<td class="text-primary-dark text-bold">665</td>
											<td class="text-primary-dark text-bold">2,889,655.00</td>
											<td class="text-primary-dark text-bold">70</td>
											<td class="text-primary-dark text-bold">8,888,888.000</td>
											<td class="text-primary-dark text-bold">58%</td>
											<td class="text-primary-dark text-bold">421</td>
											<td class="text-primary-dark text-bold">145,123,456.00</td>
											<td class="text-primary-dark text-bold">100%</td>
										</tr>
										<tr>
											<td>002 - Janine L. Descalar</td>
											<td>002 - Micro Group</td>
											<td>663</td>
											<td>1,866,321,00</td>
											<td>70</td>
											<td>106,205.00</td>
											<td>5.64%</td>
											<td>537</td>
											<td>1,477,405.00</td>
											<td>78.45%</td>
										</tr>
										<tr>
											<td></td>
											<td>002 - Micro Group</td>
											<td>663</td>
											<td>1,866,321,00</td>
											<td>70</td>
											<td>106,205.00</td>
											<td>5.64%</td>
											<td>537</td>
											<td>1,477,405.00</td>
											<td>78.45%</td>
										</tr>
										<tr>
											<td></td>
											<td>002 - Micro Group</td>
											<td>663</td>
											<td>1,866,321,00</td>
											<td>70</td>
											<td>106,205.00</td>
											<td>5.64%</td>
											<td>537</td>
											<td>1,477,405.00</td>
											<td>78.45%</td>
										</tr>
										<tr>
											<td></td>
											<td>002 - Micro Group</td>
											<td>663</td>
											<td>1,866,321,00</td>
											<td>70</td>
											<td>106,205.00</td>
											<td>5.64%</td>
											<td>537</td>
											<td>1,477,405.00</td>
											<td>78.45%</td>
										</tr>
										<tr>
											<td></td>
											<td>002 - Micro Group</td>
											<td>663</td>
											<td>1,866,321,00</td>
											<td>70</td>
											<td>106,205.00</td>
											<td>5.64%</td>
											<td>537</td>
											<td>1,477,405.00</td>
											<td>78.45%</td>
										</tr>
										<tr>
											<td></td>
											<td>002 - Micro Group</td>
											<td>663</td>
											<td>1,866,321,00</td>
											<td>70</td>
											<td>106,205.00</td>
											<td>5.64%</td>
											<td>537</td>
											<td>1,477,405.00</td>
											<td>78.45%</td>
										</tr>
										<tr class="bbt-8-light">
											<td class="text-primary-dark text-bold">OFFICER SUB-TOTAL</td>
											<td class="text-primary-dark text-bold"></td>
											<td class="text-primary-dark text-bold">665</td>
											<td class="text-primary-dark text-bold">2,889,655.00</td>
											<td class="text-primary-dark text-bold">70</td>
											<td class="text-primary-dark text-bold">8,888,888.000</td>
											<td class="text-primary-dark text-bold">58%</td>
											<td class="text-primary-dark text-bold">421</td>
											<td class="text-primary-dark text-bold">145,123,456.00</td>
											<td class="text-primary-dark text-bold">100%</td>
										</tr>
										<tr class="bg-skyblue">
											<td class="text-primary-dark text-bold">TOTAL</td>
											<td class="text-primary-dark text-bold"></td>
											<td class="text-primary-dark text-bold">665</td>
											<td class="text-primary-dark text-bold">2,889,655.00</td>
											<td class="text-primary-dark text-bold">70</td>
											<td class="text-primary-dark text-bold">8,888,888.000</td>
											<td class="text-primary-dark text-bold">58%</td>
											<td class="text-primary-dark text-bold">421</td>
											<td class="text-primary-dark text-bold">145,123,456.00</td>
											<td class="text-primary-dark text-bold">100%</td>
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