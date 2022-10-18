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

			<section class="" id="clientSection">
				<div class="d-flex flex-column mb-24">
					<div class="d-flex flex-row align-items-center">
						<div class="flex-1"></div>
						<span class="font-30 text-bold text-primary-dark">COLLECTION RATE SUMMARY REPORT</span>
						<div class="flex-1" style="padding-left:24px">
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
					<span class="text-block p-7 text-bold text-center font-md bbt-dashed-2 mb-7">ACTUAL COLLECTION</span>
					<div>
						<span class="text-block p-7 text-bold bg-yellow-pale">002 - Micro Group</span>
						<table class="table td-nb table-thin">
							<thead>
								<th>Status</th>
								<th>Acct.</th>
								<th>Principal</th>
								<th>Int.</th>
								<th>PD Int.</th>
								<th>Over</th>
								<th>Discount</th>
								<th>Tot. Payment</th>
							</thead>
							<tbody>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr class="tr-pt-7 text-bold">
									<td>TOTAL</td>
									<td></td>
									<td>9,500.00</td>
									<td>210.00</td>
									<td>26.00</td>
									<td>236.66</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr class="border-cell-gray-7">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>

					<div>
						<span class="text-block p-7 text-bold bg-yellow-pale">003 - Pension Loan</span>
						<table class="table td-nb table-thin">
							<thead>
								<th>Status</th>
								<th>Acct.</th>
								<th>Principal</th>
								<th>Int.</th>
								<th>PD Int.</th>
								<th>Over</th>
								<th>Discount</th>
								<th>Tot. Payment</th>
							</thead>
							<tbody>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr class="tr-pt-7 text-bold">
									<td>TOTAL</td>
									<td></td>
									<td>9,500.00</td>
									<td>210.00</td>
									<td>26.00</td>
									<td>236.66</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr class="border-cell-gray-7">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
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
									<td>9,500.00</td>
									<td>210.00</td>
									<td>26.00</td>
									<td>236.66</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
							</tbody>
						</table>
					</div>

					<!-- <div>
						<span class="text-block p-7 text-bold bg-yellow-pale">004 - Salary Loan</span>
						<table class="table td-nb table-thin">
							<thead>
								<th>Status</th>
								<th>Acct.</th>
								<th>Principal</th>
								<th>Int.</th>
								<th>PD Int.</th>
								<th>Over</th>
								<th>Discount</th>
								<th>Tot. Payment</th>
							</thead>
							<tbody>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr class="tr-pt-7 text-bold">
									<td>TOTAL</td>
									<td></td>
									<td>9,500.00</td>
									<td>210.00</td>
									<td>26.00</td>
									<td>236.66</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr class="border-cell-gray-7">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div> -->
					<span class="text-block p-7 text-bold text-center font-md bbt-dashed-2 mb-7">DUE COLLECTION</span>

					<div>
						<span class="text-block p-7 text-bold bg-yellow-pale">005 - Micro Individual</span>
						<table class="table td-nb table-thin">
							<thead>
								<th>Status</th>
								<th>Acct.</th>
								<th>Principal</th>
								<th>Int.</th>
								<th>PD Int.</th>
								<th>Over</th>
								<th>Discount</th>
								<th>Tot. Payment</th>
							</thead>
							<tbody>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>Delinquent</td>
									<td>720</td>
									<td>3,500.00</td>
									<td>70.66</td>
									<td>26.25</td>
									<td>236.00</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr class="tr-pt-7 text-bold">
									<td>TOTAL</td>
									<td></td>
									<td>9,500.00</td>
									<td>210.00</td>
									<td>26.00</td>
									<td>236.66</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
								<tr class="border-cell-gray-7">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
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
									<td>9,500.00</td>
									<td>210.00</td>
									<td>26.00</td>
									<td>236.66</td>
									<td>100.00</td>
									<td>0.00</td>
								</tr>
							</tbody>
						</table>
					</div>

					
					<span class="text-block p-7 text-bold text-center font-md bbt-dashed-2 mb-7">COLLECTION RATE</span>

					<table class="table mb-72">
						<tbody>
							<tr class="bg-skyblue tr-py-7 text-bold">
								<td>Col. Rate</td>
								<td>0%</td>
								<td>0.56%</td>
								<td>0.49%</td>
								<td>1.19%</td>
								<td>0.00%</td>
								<td>0.00%</td>
								<td>0.00%</td>
								<td></td>
								<td></td>
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
			<div class="d-flex mb-24">
				<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
			</div>
		</div>
		<div class="d-flex flex-row justify-content-end mb-24">
			<a href="#" class="text-green text-md text-bold mr-24">Previous Page</a>
			<a href="#" class="text-green text-md text-bold">Next Page</a>
		</div>
		<div class="d-flex flex-row justify-content-between mb-45">
			<a href="#" data-toggle="modal" data-target="#dstModal" class="btn btn-purple min-w-150">Generate DST</a>
			<div class="d-flex flex-row-reverse">
				<a @click="print()" href="#" class="btn btn-default min-w-150">Print</a>
				<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
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