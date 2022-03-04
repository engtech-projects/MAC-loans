<template>
	<div class="container-fluid px-16">
		<div class="mb-16"></div>
		<div class="mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">Account Retagging</h1>
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
					<span class="section-title section-subtitle">Select Loan Accounts</span>
					<table class="table table-stripped table-hover light-border th-blue">
						<thead>
							<th>Account Number</th>
							<th>Date Trans.</th>
							<th>Balance</th>
							<th>Prin. Bal.</th>
							<th>Int. Bal.</th>
							<th>Surcharge</th>
							<th>Amrt.</th>
							<th>Adv</th>
							<th>Short</th>
						</thead>
						<tbody>
							<tr>
								<td>0542121212412</td>
								<td>12/12/2021</td>
								<td>P 79,411.00</td>
								<td>500.00</td>
								<td>201.00</td>
								<td>500.00</td>
								<td>210.00</td>
								<td>0.00</td>
								<td>0.00</td>
							</tr>
							<tr>
								<td>0542121212412</td>
								<td>12/12/2021</td>
								<td>P 79,411.00</td>
								<td>500.00</td>
								<td>201.00</td>
								<td>500.00</td>
								<td>210.00</td>
								<td>0.00</td>
								<td>0.00</td>
							</tr>
							<tr>
								<td>0542121212412</td>
								<td>12/12/2021</td>
								<td>P 79,411.00</td>
								<td>500.00</td>
								<td>201.00</td>
								<td>500.00</td>
								<td>210.00</td>
								<td>0.00</td>
								<td>0.00</td>
							</tr>
						</tbody>
					</table>
				</section>

				<section class="mb-45" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-24">Loan Details</span>
					<div class="d-flex flex-row">
						<div class="d-flex flex-column flex-1 mr-45">
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Account #</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">054521212545254</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Co Borrower</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">Matina G. Natura</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Address</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">P4 Brgy. Matin-ao, Butuan City</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Co Maker</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">Jose Abilardo</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Address</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">P4 Brgy. Matin-ao, Butuan City</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Contact #</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">09856562521</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Date Release</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">December 2, 2021</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Product Name</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">SMD</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Center</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">Acassia</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Type</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">Add-on</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Cycle</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">2</span>
							</div>
						</div>
						<div class="d-flex flex-column flex-1">
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Account Officer</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">Johan Mar Cabelo</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Group</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">Various Pension</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Transaction</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">11/11/2021</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Loan Amount</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">P 42,205.00</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Interest</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">P 2,205.00</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Due Date</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">12/12/2021</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Monthly</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">P 20,205.00</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Int. Rate</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">P 500.00</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Mode</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">Monthly</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Rate</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">24%</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Term</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">720 Days</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Status</span>
									<span>:</span>
								</div>
								<span class="flex-1 text-primary-dark">Delinquent</span>
							</div>
						</div>
					</div>
				</section>
				<div class="d-flex flex-row-reverse mb-72">
					<a href="#" data-toggle="modal" data-target="#retagModal" class="btn btn-primary-dark min-w-150">Re-tag</a>
				</div>
			</div>
		</div>

		<!-- MODALS -->
		<div class="modal" id="retagModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-md" role="document">
			<div class="modal-content">
				<div class="modal-body p-24">
					<div class="d-flex flex-column">
						<span class="text-bold font-20 text-primary-dark pb-10 light-bb mb-16">Retagging</span>
						<div class="form-group mb-10" style="flex: 5">
							<label for="product" class="form-label">Product</label>
							<select class="form-control form-input " id="product">
							</select>
						</div>
						<div class="form-group mb-10" style="flex: 5">
							<label for="product" class="form-label">Account Officer</label>
							<select class="form-control form-input " id="product">
							</select>
						</div>
						<div class="form-group mb-10" style="flex: 5">
							<label for="product" class="form-label">Center / Office</label>
							<select class="form-control form-input " id="product">
							</select>
						</div>
						<div class="form-group mb-10" style="flex: 5">
							<label for="product" class="form-label">Group / Dept.</label>
							<select class="form-control form-input " id="product">
							</select>
						</div>
						<div class="form-group mb-10" style="flex: 5">
							<label for="product" class="form-label">Loan Status</label>
							<select class="form-control form-input " id="product">
							</select>
						</div>
						<div class="form-group mb-24" style="flex: 5">
							<label for="product" class="form-label">Remedial</label>
							<select class="form-control form-input " id="product">
							</select>
						</div>
						<div class="d-flex justify-content-end">
							<a href="#" data-dismiss="modal" class="btn btn-success min-w-150">Save</a>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data(){
		return {
			baseUrl: window.location.origin
		}
	}
}
</script>