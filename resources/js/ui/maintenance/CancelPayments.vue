<template>
	<div class="container-fluid px-16">
		<div class="mb-16"></div>
		<div class="d-flex justify-content-between mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">Cancel Payments</h1>
			<!-- <a href="#" class="btn btn-primary-dark min-w-150">New Client</a> -->
		</div><!-- /.col -->
		<div class="d-flex flex-column flex-xl-row">
			<div style="flex:9;">
				<div class="search-bar mb-12">
					<input type="text" class="form-control" id="searchBar" placeholder="Search">
					<div><i class="fa fa-search"></i></div>
				</div>
				<table class="table table-stripped" id="clientsList">
					<thead>
						<th>Account #</th>
						<th>Client Name</th>
						<th></th>
					</thead>
					<tbody>
						<tr>
							<td>183</td>
							<td><a href="#">John Doe</a></td>
							<td><span class="text-green">select</span></td>
						</tr>
						<tr>
						<td>183</td>
						<td><a href="#">John Doe</a></td>
						<td><span class="text-green">select</span></td>
					</tr>
					<tr>
						<td>183</td>
						<td><a href="#">John Doe</a></td>
						<td><span class="text-green">select</span></td>
					</tr>
					<tr>
						<td>183</td>
						<td><a href="#">John Doe</a></td>
						<td><span class="text-green">select</span></td>
					</tr>
					<tr>
						<td>183</td>
						<td><a href="#">John Doe</a></td>
						<td><span class="text-green">select</span></td>
					</tr>
					</tbody>
				</table>
			</div>
			<div style="flex:20">
				<section class="mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title mb-24">Details</span>
					<div class="d-flex mb-12">
						<div class="d-flex flex-column mr-16" style="flex:20;">
							<div class="d-flex flex-row">
								<div class="borrower-number d-flex flex-column" style="flex: 5">
									<span>Borrower's Number</span>
									<span class="text-center">021512131521</span>
								</div>
								<div style="flex:4"></div>
								<!-- <div class="form-group mb-10" style="flex: 5">
									<label for="transactionDate" class="form-label">Transaction Date</label>
									<input type="date" class="form-control form-input text-right" id="transactionDate">
								</div> -->
							</div>
							<div class="form-group mb-5" style="flex: 5">
								<label for="client" class="form-label mb-3">Client</label>
								<input type="text" class="form-control form-input " id="client">
							</div>
							<div class="form-group mb-10" style="flex: 5">
								<label for="address" class="form-label mb-3">Address</label>
								<input type="text" class="form-control form-input " id="address">
							</div>
						</div>
						<div class="upload-photo d-flex flex-column" style="flex:4;padding-top:36px;">
							<img :src="baseUrl + '/img/user.png'" alt="">
						</div>
					</div>
					<div class="sep mb-24"></div>
				</section>

				<section class="mb-24" style="flex:21;padding-left:16px;">
					<div class="d-flex justify-content-between align-items-center mb-10">
						<span class="section-title section-subtitle flex-2" style="padding:0;margin:0;line-height:1.2;border:none;">Payment Transactions</span>
						<input type="text" class="form-control flex-1" id="searchBar" placeholder="Search">
					</div>
					<table class="table table-stripped table-hover light-border th-blue">
						<thead>
							<th>Account No.</th>
							<th>Date Paid</th>
							<th>O.R.</th>
							<th>Amount</th>
						</thead>
						<tbody>
							<tr>
								<td>0542121212412</td>
								<td>12/12/2021</td>
								<td>00-000-1</td>
								<td>P 79,411.00</td>
							</tr>
							<tr>
								<td>0542121212412</td>
								<td>12/12/2021</td>
								<td>00-000-1</td>
								<td>P 79,411.00</td>
							</tr>
							<tr>
								<td>0542121212412</td>
								<td>12/12/2021</td>
								<td>00-000-1</td>
								<td>P 79,411.00</td>
							</tr>
						</tbody>
					</table>
					<div class="d-flex flex-column">
						<span class="text-bold">Remarks</span>
						<text-area class="form-control mb-16" style="height:95px"></text-area>
						<div class="d-flex justify-content-end">
							<button class="btn btn-bright-blue btn-wide">Cancel - Verify</button>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data(){
		return {
			baseUrl: window.location.origin,
		}
	}
}
</script>