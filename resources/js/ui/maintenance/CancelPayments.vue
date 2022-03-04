<template>
	<div class="container-fluid px-16">
		<div class="mb-16"></div>
		<div class="d-flex justify-content-between mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">Cancel Payments</h1>
			<a href="#" class="btn btn-primary-dark min-w-150">New Client</a>
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
								<div class="form-group mb-10" style="flex: 5">
									<label for="transactionDate" class="form-label">Transaction Date</label>
									<input type="date" class="form-control form-input text-right" id="transactionDate">
								</div>
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
					<span class="section-title section-subtitle">Select Loan Accounts Payable</span>
					<table class="table table-stripped table-hover light-border th-blue">
						<thead>
							<th>Account Number</th>
							<th>Date Transaction</th>
							<th>Balance</th>
						</thead>
						<tbody>
							<tr>
								<td>0542121212412</td>
								<td>12/12/2021</td>
								<td>P 79,411.00</td>
							</tr>
							<tr>
								<td>0542121212412</td>
								<td>12/12/2021</td>
								<td>P 79,411.00</td>
							</tr>
							<tr>
								<td>0542121212412</td>
								<td>12/12/2021</td>
								<td>P 79,411.00</td>
							</tr>
						</tbody>
					</table>
				</section>

				<section class="mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-24">Loan Account Number: 00021241</span>
					<div class="d-flex flex-row loan-details">
						<div class="d-flex flex-column flex-1">
							<h4 class="text-primary-dark mb-12">Loan Details</h4>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Amount</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">9,000.00</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Filling Fee</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">200.71</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Documents</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">33.5</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Insurance</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">59.00</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Notarial</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">100.00</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Prepaid Interest</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">0.00</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Other / Mem</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">0.00</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Net Amount</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">8,670.29</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Cash Release Type</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">9,000.00</span>
							</div>
						</div>
						<div class="d-flex flex-column flex-1">
							<h4 class="text-primary-dark mb-12">SUMMARY OF RELEASE</h4>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Release Type</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">CHEQUE RELEASE DETAILS</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Total Cash</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">8,607.00</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Total Memo</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">0.00</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Total Check</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">0.00</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Total Release</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">8,607.00</span>
							</div>
						</div>
					</div>
				</section>

				<section class="mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-24">Cancel Payment Transactions</span>
					<div class="loan-details mb-24">
						<table class="table table-stripped th-nbt">
							<thead>
								<th class="text-primary-dark">No.</th>
								<th class="text-primary-dark">Date</th>
								<th class="text-primary-dark">Amount</th>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
								</tr>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
								</tr>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
								</tr>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
								</tr>
								<tr>
									<td>1</td>
									<td>08/22/21</td>
									<td>1,542.00</td>
								</tr>
							</tbody>
						</table>
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