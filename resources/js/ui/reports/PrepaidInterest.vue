<template>
	<div class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark" style="flex:4">Prepaid Interest</span>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">From: </span>
				<input type="date" class="form-control">
			</div>
			<div class="d-flex flex-row align-items-center" style="flex:2">
				<span class="mr-10">To: </span>
				<input type="date" class="form-control">
			</div>
		</div>
		<div class="sep mb-45"></div>
		<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">



		<section class="" id="productSection">
			<div class="d-flex flex-column mb-16">
				<div class="d-flex flex-row align-items-center">
					<div class="flex-1"></div>
					<span class="font-30 text-bold text-primary-dark">PREPAID INTEREST REPORT</span>
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
			<section class="d-flex flex-column mb-45">
				<table class="table table-stripped table-thin" style="font-size:13px">
					<thead>
						<tr>
							<th>Client</th>
							<th>Amount</th>
							<th>Date</th>
							<th>Term</th>
							<th>Total UID</th>
							<th>Bal.</th>
							<th>Monthly UID</th>
							<th>Year</th>
							<th>Jan</th>
							<th>Feb</th>
							<th>Mar</th>
							<th>Apr</th>
							<th>May</th>
							<th>Jun</th>
							<th>Jul</th>
							<th>Aug</th>
							<th>Sep</th>
							<th>Oct</th>
							<th>Nov</th>
							<th>Dec</th>
							<th>TOTAL</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Mark</td>
							<td>100,000.00</td>
							<td>12/12/2021</td>
							<td>36</td>
							<td>24,000.00</td>
							<td>18,000.00</td>
							<td>2,000.00</td>
							<td>2021</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td class="text-bold">24000</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>2022</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td class="text-bold">24000</td>
						</tr>
						<tr>
						<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>2023</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td class="text-bold">24000</td>
						</tr>
						<tr>
							<td>Jose</td>
							<td>100,000.00</td>
							<td>12/12/2021</td>
							<td>36</td>
							<td>24,000.00</td>
							<td>18,000.00</td>
							<td>2,000.00</td>
							<td>2021</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td class="text-bold">24000</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>2022</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td class="text-bold">24000</td>
						</tr>
						<tr>
							<td>John</td>
							<td>100,000.00</td>
							<td>12/12/2021</td>
							<td>36</td>
							<td>24,000.00</td>
							<td>18,000.00</td>
							<td>2,000.00</td>
							<td>2021</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td class="text-bold">24000</td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td>2022</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td>2000</td>
							<td class="text-bold">24000</td>
						</tr>
						<tr class="bg-green-mint text-bold">
							<td></td>
							<td>300,000.00</td>
							<td></td>
							<td></td>
							<td>72,000.00</td>
							<td>34,000.00</td>
							<td></td>
							<td></td>
							<td>14000</td>
							<td>14000</td>
							<td>14000</td>
							<td>14000</td>
							<td>14000</td>
							<td>14000</td>
							<td>14000</td>
							<td>14000</td>
							<td>14000</td>
							<td>14000</td>
							<td>14000</td>
							<td>14000</td>
							<td>166000</td>
						</tr>
					</tbody>
				</table>
				<div class="d-flex flex-row justify-content-end mb-24">
					<a href="#" class="text-green text-md text-bold mr-24">Previous Page</a>
					<a href="#" class="text-green text-md text-bold">Next Page</a>
				</div>
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