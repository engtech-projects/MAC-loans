<template>
	<div class="d-flex flex-column" style="flex:8;min-height:1600px;">
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
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">Type: </span>
				<select name="" id="selectProductClient" class="form-control">
					<option value="all_records">All Records</option>
					<option value="new_accounts">New Accounts</option>
					<option value="">By Center</option>
					<option value="">By Product</option>
					<option value="">By Account Officer</option>
				</select>
			</div>
			<div class="d-flex flex-row align-items-center" style="flex:2">
				<span class="mr-10">Spec: </span>
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
			<img src="/img/company_header_fit.png" class="mb-24" alt="">

			<section class="" id="clientSection">
				<div class="d-flex flex-column mb-16">
					<div class="d-flex flex-row align-items-center">
						<div class="flex-1"></div>
						<span class="font-30 text-bold text-primary-dark">SUMMARY OF LOAN REPAYMENTS</span>
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
				<section class="d-flex flex-column flex-1">
					<table class="table td-nb table-thin th-nbt">
						<thead>
							<th>Borrower's Name</th>
							<th>Date Pay</th>
							<th>O.R#</th>
							<th>Principal</th>
							<th>Int.</th>
							<th>PD Int.</th>
							<th>Over</th>
							<th>Discount</th>
							<th>Tot. Payment</th>
							<th>Net Int.</th>
							<th>VAT</th>
							<th>Type</th>
						</thead>
						<tbody>
							<tr>
								<td>Gabriel, Julio A.</td>
								<td>12/15/21</td>
								<td>720</td>
								<td>3,500.00</td>
								<td>70.66</td>
								<td>26.25</td>
								<td>236.00</td>
								<td>100.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>CSH</td>
							</tr>
							<tr>
								<td>Lagahit, Mario A.</td>
								<td>12/15/21</td>
								<td>720</td>
								<td>3,500.00</td>
								<td>70.66</td>
								<td>26.25</td>
								<td>236.00</td>
								<td>100.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>CSH</td>
							</tr>
							<tr>
								<td>Marco, Georgia A.</td>
								<td>12/15/21</td>
								<td>720</td>
								<td>3,500.00</td>
								<td>70.66</td>
								<td>26.25</td>
								<td>236.00</td>
								<td>100.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>CSH</td>
							</tr>
							<tr>
								<td>Gabriel, Julio A.</td>
								<td>12/15/21</td>
								<td>720</td>
								<td>3,500.00</td>
								<td>70.66</td>
								<td>26.25</td>
								<td>236.00</td>
								<td>100.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>CSH</td>
							</tr>
							<tr>
								<td>Lagahit, Mario A.</td>
								<td>12/15/21</td>
								<td>720</td>
								<td>3,500.00</td>
								<td>70.66</td>
								<td>26.25</td>
								<td>236.00</td>
								<td>100.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>CSH</td>
							</tr>
							<tr>
								<td>Marco, Georgia A.</td>
								<td>12/15/21</td>
								<td>720</td>
								<td>3,500.00</td>
								<td>70.66</td>
								<td>26.25</td>
								<td>236.00</td>
								<td>100.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>CSH</td>
							</tr>
							<tr>
								<td>Gabriel, Julio A.</td>
								<td>12/15/21</td>
								<td>720</td>
								<td>3,500.00</td>
								<td>70.66</td>
								<td>26.25</td>
								<td>236.00</td>
								<td>100.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>CSH</td>
							</tr>
							<tr>
								<td>Lagahit, Mario A.</td>
								<td>12/15/21</td>
								<td>720</td>
								<td>3,500.00</td>
								<td>70.66</td>
								<td>26.25</td>
								<td>236.00</td>
								<td>100.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>CSH</td>
							</tr>
							<tr>
								<td>Marco, Georgia A.</td>
								<td>12/15/21</td>
								<td>720</td>
								<td>3,500.00</td>
								<td>70.66</td>
								<td>26.25</td>
								<td>236.00</td>
								<td>100.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>CSH</td>
							</tr>
							<tr>
								<td>Gabriel, Julio A.</td>
								<td>12/15/21</td>
								<td>720</td>
								<td>3,500.00</td>
								<td>70.66</td>
								<td>26.25</td>
								<td>236.00</td>
								<td>100.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>CSH</td>
							</tr>
							<tr>
								<td>Lagahit, Mario A.</td>
								<td>12/15/21</td>
								<td>720</td>
								<td>3,500.00</td>
								<td>70.66</td>
								<td>26.25</td>
								<td>236.00</td>
								<td>100.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>CSH</td>
							</tr>
							<tr>
								<td>Marco, Georgia A.</td>
								<td>12/15/21</td>
								<td>720</td>
								<td>3,500.00</td>
								<td>70.66</td>
								<td>26.25</td>
								<td>236.00</td>
								<td>100.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>CSH</td>
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
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr class="tr-pt-7 text-bold">
								<td>TOTAL</td>
								<td></td>
								<td></td>
								<td>9,500.00</td>
								<td>210.00</td>
								<td>26.00</td>
								<td>236.66</td>
								<td>100.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td>0.00</td>
								<td></td>
							</tr>
						</tbody>
					</table>

					<div class="d-flex flex-row bg-skyblue p-10 align-items-center mb-72">
						<div class="d-flex flex-column flex-1 mr-64">
							<div class="d-flex flex-row flex-1 mb-5">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL CASH RELEASE</span>
									<span>:</span>
								</div>
								<span class="flex-1">6,347.00</span>
							</div>
							<div class="d-flex flex-row flex-1 mb-5">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL CHECK RELEASE</span>
									<span>:</span>
								</div>
								<span class="flex-1">0.00</span>
							</div>
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL MEMO RELEASE</span>
									<span>:</span>
								</div>
								<span class="flex-1">1,484.00</span>
							</div>
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1 pl-24">DED BALANCE</span>
									<span>:</span>
								</div>
								<span class="flex-1">14,852.00</span>
							</div>
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1 pl-24">OFFSET PF</span>
									<span>:</span>
								</div>
								<span class="flex-1">14,852.00</span>
							</div>
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1 pl-24">OVER PAYMENT</span>
									<span>:</span>
								</div>
								<span class="flex-1">14,852.00</span>
							</div>
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1 pl-24">DISCOUNT</span>
									<span>:</span>
								</div>
								<span class="flex-1">14,852.00</span>
							</div>
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1 pl-24">CANCELLED</span>
									<span>:</span>
								</div>
								<span class="flex-1">14,852.00</span>
							</div>
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1 pl-24">BRANCH</span>
									<span>:</span>
								</div>
								<span class="flex-1">14,852.00</span>
							</div>
						</div>
						<div class="d-flex flex-column flex-1">
							<div class="info-display">
								<span class="text-primary-dark">TOTAL RELEASES</span>
								<span class="text-primary-dark">172,222.00</span>
							</div>
						</div>
						<div class="flex-2"></div>
					</div>
				</section>
				
			</section>
			<div class="d-flex mb-64 mt-auto">
				<img src="/img/logo-footer.png" class="w-100" alt="">
			</div>
		</div>
		<div class="d-flex flex-row justify-content-between mb-45">
			<div class="d-flex flex-row-reverse justify-content-start flex-1">
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