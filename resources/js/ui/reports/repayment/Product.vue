<template>
	<div class="d-flex flex-column" style="flex:8;min-height:1600px">
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark" style="flex:3">Transaction</span>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">From: </span>
				<input type="date" class="form-control">
			</div>
			<div class="d-flex flex-row align-items-center" style="flex:2">
				<span class="mr-10">To: </span>
				<input type="date" class="form-control">
			</div>
			<div class="d-flex flex-row align-items-center mr-24 hide" style="flex:2">
				<span class="mr-10">Type: </span>
				<select name="" id="selectProductClient" class="form-control">
					<option value="all_records">All Records</option>
					<option value="new_accounts">New Accounts</option>
					<option value="">By Center</option>
					<option value="">By Product</option>
					<option value="">By Account Officer</option>
				</select>
			</div>
			<div class="d-flex flex-row align-items-center hide" style="flex:2">
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
			<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">

			<section class="" id="clientSection">
				<div class="d-flex flex-column mb-16">
					<div class="d-flex flex-row align-items-center">
						<div class="flex-1"></div>
						<span class="font-30 text-bold text-primary-dark">SUMMARY RELEASE AND PAYMENT BY PRODUCT</span>
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
				<section class="d-flex flex-column mb-72">
					<span class="text-bold bg-yellow-light" style="padding:2px 5px;">RELEASES SUMMARY</span>
					<table class="table td-nb table-thin">
						<thead>
							<th>Reference</th>
							<th>Principal</th>
							<th>Interest</th>
							<th>Filing Fee</th>
							<th>Doc. Stamp</th>
							<th>Insurance</th>
							<th>Notarial</th>
							<th>Affidavit</th>
							<th>Deduct Bal</th>
							<th>Prepaid</th>
							<th>Net Proceeds</th>
						</thead>
						<tbody>
							<tr>
								<td>0063 - Pension Loan</td>
								<td>8,500.00</td>
								<td>2,435.00</td>
								<td>121.00</td>
								<td>41.66</td>
								<td>500.00</td>
								<td>200.00</td>
								<td>0.00</td>
								<td>1,484.00</td>
								<td>0.00</td>
								<td>6,347.00</td>
							</tr>
							<tr>
								<td>0064 - Micro Group</td>
								<td>8,500.00</td>
								<td>2,435.00</td>
								<td>121.00</td>
								<td>41.66</td>
								<td>500.00</td>
								<td>200.00</td>
								<td>0.00</td>
								<td>1,484.00</td>
								<td>0.00</td>
								<td>6,347.00</td>
							</tr>
							<tr>
								<td>0065 - Salary Loan</td>
								<td>8,500.00</td>
								<td>2,435.00</td>
								<td>121.00</td>
								<td>41.66</td>
								<td>500.00</td>
								<td>200.00</td>
								<td>0.00</td>
								<td>1,484.00</td>
								<td>0.00</td>
								<td>6,347.00</td>
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
							</tr>
							<tr class="tr-pt-7">
								<td>TOTAL RELEASES</td>
								<td>122,500.00</td>
								<td>8,435.00</td>
								<td>121.00</td>
								<td>41.66</td>
								<td>500.00</td>
								<td>200.00</td>
								<td>0.00</td>
								<td>1,484.00</td>
								<td>0.00</td>
								<td>20,347.00</td>
							</tr>
						</tbody>
					</table>
					<div class="d-flex flex-row bg-yellow-pale p-5 align-items-center">
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
						</div>
						<div class="d-flex flex-column flex-1">
							<div class="info-display">
								<span class="text-primary-dark">TOTAL RELEASES</span>
								<span class="text-primary-dark">17,000.00</span>
							</div>
						</div>
						<div class="flex-2"></div>
					</div>
				</section>
				
			</section>
			<div class="d-flex mb-64 mt-auto">
				<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
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