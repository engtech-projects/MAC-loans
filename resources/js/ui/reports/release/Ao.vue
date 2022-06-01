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
		</div>
		<div class="sep mb-45"></div>
		<div id="printContent">
			<img src="/img/company_header_fit.png" class="mb-24" alt="">

			<section class="" id="clientSection">
				<div class="d-flex flex-column mb-24">
					<div class="d-flex flex-row align-items-center">
						<div class="flex-1 d-flex flex-column">
							<span>Account Officer</span>
							<span class="text-bold">001 - Jose Magbanua</span>
						</div>
						<span class="font-30 text-bold text-primary-dark">ACCOUNT OFFICER RELEASE SUMMARY REPORT</span>
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
			</section>
			<section class="d-flex flex-column mb-72">
					<span class="text-bold bg-yellow-light" style="padding:2px 5px;">RELEASES SUMMARY</span>
					<table class="table td-nb table-thin">
						<thead>
							<th>Reference</th>
							<th>New Acct.</th>
							<th>Amt. Released</th>
							<th>Rep. Acct</th>
							<th>Amt. Released</th>
							<th>Total Released</th>
						</thead>
						<tbody>
							<tr>
								<td>003-Pension Loan</td>
								<td>0</td>
								<td>25,214.00</td>
								<td>2</td>
								<td>22,000.00</td>
								<td>22,000.00</td>
								
							</tr>
							<tr>
								<td>004-Micro Group</td>
								<td>0</td>
								<td>25,214.00</td>
								<td>2</td>
								<td>22,000.00</td>
								<td>22,000.00</td>
								
							</tr>
							<tr>
								<td>005-Salary Loan</td>
								<td>0</td>
								<td>25,214.00</td>
								<td>2</td>
								<td>22,000.00</td>
								<td>22,000.00</td>
								
							</tr>
							<tr class="border-cell-gray-7">
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr class="tr-pt-7 text-bold bg-skyblue">
								<td>TOTAL RELEASES</td>
								<td>0</td>
								<td>542,412.00</td>
								<td>6</td>
								<td>66,000.00</td>
								<td>66,000.00</td>
							</tr>
						</tbody>
					</table>
					<div class="d-flex flex-row bg-yellow-pale p-5 align-items-center hide">
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
			<section class="d-flex flex-row mb-72" style="margin-top:auto">
				<span class="flex-2 pb-24 text-bold darker-bb mr-64">Prepared By:</span>
				<span class="flex-2 pb-24 text-bold darker-bb mr-64">Certified Corrected By:</span>
				<span class="flex-2 pb-24 text-bold darker-bb mr-64">Approved By:</span>
				<span class="flex-1"></span>
			</section>
			<div class="d-flex mb-64">
				<img src="/img/logo-footer.png" class="w-100" alt="">
			</div>
		</div>
		<div class="d-flex flex-row justify-content-between mb-45">
			<a href="#" data-toggle="modal" data-target="#dstModal" class="btn btn-purple min-w-150">Generate DST</a>
			<div class="d-flex flex-row-reverse">
				<a @click="print" href="#" class="btn btn-default min-w-150">Print</a>
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