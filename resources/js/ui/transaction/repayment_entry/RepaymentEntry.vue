<template>
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between">
			<h1 class="m-0 font-35">Repayment Entry</h1>
			<a href="#" @click.prevent="clearData.borrower=1;resetLoanDetails()" class="btn btn-primary-dark min-w-150">New Client</a>
		</div><!-- /.col -->
		<div class="d-flex flex-column flex-xl-row p-16">
			<div style="flex:9;">
				<client-list-side :pborrowers="borrowers" :id="{}"></client-list-side>
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
									<!-- <label for="transactionDate" class="form-label">Transaction Date</label>
									<input type="date" class="form-control form-input text-right" id="transactionDate"> -->
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
							<img src="/img/user.png" alt="">
						</div>
					</div>
					<div class="sep mb-24"></div>
				</section>

				<section class="mb-36" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-12">Select Loan Accounts Payable</span>
					<div class="p-10 light-border mb-24">
						<table class="table table-stripped m-0 th-nbt  th-blue table-hover">
							<thead>
								<th class="text-primary-dark">Account Number</th>
								<th class="text-primary-dark">Date Transaction</th>
								<th class="text-primary-dark">Balance</th>
							</thead>
							<tbody>
								<tr>
									<td>054212121154</td>
									<td>08/22/21</td>
									<td>P 79,400.00</td>
								</tr>
								<tr>
									<td>054212121154</td>
									<td>08/22/21</td>
									<td>P 79,400.00</td>
								</tr>
								<tr>
									<td>054212121154</td>
									<td>08/22/21</td>
									<td>P 79,400.00</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="sep"></div>
				</section>
				<section class="mb-24" style="flex:21;padding-left:16px;">
					<div class="d-flex flex-row justify-content-between align-items-center section-title pb-12 mb-24">
						<span class="section-title section-subtitle b-none p-0">Loan Details</span>
					</div>
					<div class="d-flex flex-row">
						<div class="d-flex flex-column flex-1 mr-45">
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Acount Number</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">054212121154</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Co Borrower</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">Matina G. Natura</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Address</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">154 JP Laurel Sr Street Corner 6th Avenue 1400, Caloocan City, Philippines</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Co Maker</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">Matina G. Natura</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Address</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">154 JP Laurel Sr Street Corner 6th Avenue 1400, Caloocan City, Philippines</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Contact No.</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">09075214658</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Date Release</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">12/21/2021</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Product Name</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">SMD</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Missed Payments</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">2</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Type</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">Add-on</span>
							</div>

							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Cycle</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">2</span>
							</div>
						</div>
						<div class="d-flex flex-column flex-1">
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Last Transaction</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">11/12/2021</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Loan Amount</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">42,754.00</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Interest</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">2,00.00</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Due Date</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">12/21/2021</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Monthly</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">20,000.00</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Int. Rate</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">500.00</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Mode</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">Monthly</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Rate</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">24%</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Term</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">720 Days</span>
							</div>
							<div class="d-flex flex-row mb-12">
								<div class="d-flex flex-row flex-1 justify-content-between pr-24">
									<span class="">Status</span>
									<span>:</span>
								</div>
								<span class="flex-2 text-primary-dark">Delinquent</span>
							</div>
						</div>
					</div>
				</section>
				<div class="flex-1 d-flex flex-row-reverse align-items-end">
					<button data-toggle="modal" data-target="#paymentModal" class="btn btn-bright-blue min-w-150 mb-5">Pay</button>
				</div>
				
			</div>
		</div>


		<div class="modal" id="paymentModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-xl" role="document">
		  <div class="modal-content">
			<div class="modal-body">
				<section class="mb-24 p-16" style="flex:21;padding-left:16px;">
					<span class="section-title mb-12">Payment</span>
					<div class="d-flex flex-column flex-lg-row">
						<div class="form-group mb-10 mr-16 flex-1">
							<label for="transactionDate" class="form-label">Payment Type</label>
							<div class="form-group">
								<select class="form-control form-input" v-model="paymentType">
								  <option value="cash">Cash Payment</option>
								  <option value="cheque">Cheque Payment</option>
								  <option value="memo">Memo</option>
								  <option value="pos">POS</option>
								</select>
							</div>
						</div>
						<div class="form-group mb-10 mr-16 flex-1" v-if="paymentType!='memo'">
							<label for="transactionDate" class="form-label">OR #</label>
							<input type="text" class="form-control form-input" id="transactionDate">
						</div>
						<div class="flex-2" v-if="paymentType=='cash'"></div>
						<div class="form-group mb-10 mr-16 flex-1" v-if="paymentType=='pos'">
							<label for="transactionDate" class="form-label">Referrence #</label>
							<input type="text" class="form-control form-input" id="transactionDate">
						</div>
						<div class="form-group mb-10 mr-16 flex-1" v-if="paymentType=='cheque'">
							<label for="transactionDate" class="form-label">Cheque #</label>
							<input type="text" class="form-control form-input" id="transactionDate">
						</div>
						<div class="form-group mb-10 flex-1" v-if="paymentType=='pos'">
							<label for="transactionDate" class="form-label">Bank Name</label>
							<input type="text" class="form-control form-input" id="transactionDate">
						</div>
						<div class="form-group mb-10 mr-16 flex-1" v-if="paymentType=='cheque'">
							<label for="transactionDate" class="form-label">Bank Name</label>
							<div class="form-group">
								<select class="form-control form-input">
									<option value="">Land Bank</option>
									<option value="">PNB</option>
									<option value="">BDO</option>
								</select>
							</div>
						</div>
						<div class="form-group mb-10 flex-1  mr-16" v-if="paymentType=='memo'">
							<label for="transactionDate" class="form-label">Memo Referece #</label>
							<input type="text" class="form-control form-input" id="transactionDate">
						</div>
						<div class="form-group mb-10 mr-16 flex-1" v-if="paymentType=='memo'">
							<label for="transactionDate" class="form-label">Type</label>
							<div class="form-group">
								<select class="form-control form-input">
								  <option value="">Deduct to Balance</option>
								</select>
							</div>
						</div>
						<div class="flex-1" v-if="paymentType=='memo'"></div>
					</div>
					<div class="d-flex flex-row mb-24">
						<div class="form-group mb-0 flex-2 mr-24">
							<label for="transactionDate" class="form-label mb-5">Amount</label>
							<div class="d-flex flex-column flex-lg-row align-items-center justify-content-between">
								<div class="d-flex align-items-center">
									<span class="text-bold mr-10" style="font-size:60px;color:#263f52;line-height:1;">P</span>
									<input type="text" class="form-control form-input mw-250" id="transactionDate">
								</div>
								<!-- <a href="#" class="btn btn-primary min-w-200 br-0" style="padding:12px!important;" data-dismiss="modal">Pay</a> -->
							</div>
						</div>
						<div class="d-flex flex-column flex-1 mr-16">
							<span class="font-20 text-primary-dark lh-1 mb-3">Waive</span>
							<div class="d-flex flex-row align-items-center mb-3">
								<input type="checkbox" class="form-check-input" style="margin:0">
								<span class="ml-18 text-primary-dark text-24 lh-1">PDI</span>
							</div>
							<input type="text" class="form-control" placeholder="Approval #">
						</div>
						<div class="d-flex flex-column flex-1 mr-16">
							<span class="font-20 text-primary-dark lh-1 invis mb-3">l</span>
							<div class="d-flex flex-row align-items-center mb-3">
								<input type="checkbox" class="form-check-input" style="margin:0">
								<span class="ml-18 text-primary-dark text-24 lh-1">Penalty</span>
							</div>
							<input type="text" class="form-control" placeholder="Approval #">
						</div>
						<div class="d-flex flex-column flex-1 mr-16">
							<span class="font-20 text-primary-dark lh-1 invis mb-3">l</span>
							<div class="d-flex flex-row align-items-center mb-3">
								<input type="checkbox" class="form-check-input" style="margin:0">
								<span class="ml-18 text-primary-dark text-24 lh-1">Rebates</span>
							</div>
							<input type="text" class="form-control" placeholder="Approval #">
						</div>
						<div class="d-flex flex-column flex-1 mr-24">
							<span class="font-20 text-primary-dark lh-1 invis mb-3">l</span>
							<div class="d-flex flex-row align-items-center mb-3 invis">
								<input type="checkbox" class="form-check-input" style="margin:0">
								<span class="ml-18 text-primary-dark text-24 lh-1">Rebates</span>
							</div>
							<input type="text" class="form-control" placeholder="Amount">
						</div>
					</div>
					<div class="sep-dark mb-10"></div>
					<section class="mb-24">
						<span class="py-12 darker-bb text-primary-dark text-24 text-bold text-block mb-10">Preview</span>
						<div class="d-flex flex-row">
							<div class="d-flex flex-column br-dark pr-16 flex-1 text-primary-dark font-md justify-content-start">
								<div class="d-flex flex-column" style="margin-bottom:100px;">
									<span class="mb-5 text-bold">Amortization Scheduled Payment</span>
									<div class="d-flex flex-row mb-7 font-md">
										<div class="d-flex flex-row justify-content-between flex-1 mr-16">
											<span>Amort. Principal</span>
											<span>:</span>
										</div>
										<span class="flex-1">P 321.00</span>
									</div>
									<div class="d-flex flex-row">
										<div class="d-flex flex-row justify-content-between flex-1 mr-16">
											<span>Interest</span>
											<span>:</span>
										</div>
										<span class="flex-1">P 90.00</span>
									</div>
								</div>
								<div class="d-flex flex-column mb-10">
									<span class="text-20 text-primary-dark">TOTAL</span>
									<span class="bg-primary-dark text-white font-30 pxy-25 lh-1">P 411.00</span>
								</div>
								<div class="d-flex flex-column bg-peach p-16">
									<div class="d-flex flex-column mb-12">
										<div class="d-flex flex-row">
											<div class="d-flex flex-row justify-content-between flex-1 mr-16">
												<span class="">Short Principal</span>
												<span>:</span>
											</div>
											<span class="flex-1">P 321.00</span>
										</div>
										<div class="d-flex flex-row mb-10">
											<div class="d-flex flex-row justify-content-between flex-1 mr-16">
												<span class="">Adv. Principal</span>
												<span>:</span>
											</div>
											<span class="flex-1">P 90.00</span>
										</div>
										<div class="d-flex flex-row">
											<div class="d-flex flex-row justify-content-between flex-1 mr-16">
												<span class="">Short Interest</span>
												<span>:</span>
											</div>
											<span class="flex-1">P 2,000.00</span>
										</div>
										<div class="d-flex flex-row">
											<div class="d-flex flex-row justify-content-between flex-1 mr-16">
												<span class="">Adv. Interest</span>
												<span>:</span>
											</div>
											<span class="flex-1">P 0.00</span>
										</div>
									</div>
									
								</div>
							</div>
							<div class="d-flex flex-column br-dark pr-16 pl-24 flex-1 font-md justify-content-between">
								<div class="d-flex flex-column mb-24">
									<span class="mb-5 text-bold">Due Amount</span>
									<div class="d-flex flex-row mb-7">
										<div class="d-flex flex-row justify-content-between flex-1 mr-16">
											<span>Principal</span>
											<span>:</span>
										</div>
										<span class="flex-1">P 321.00</span>
									</div>
									<div class="d-flex flex-row mb-7">
										<div class="d-flex flex-row justify-content-between flex-1 mr-16">
											<span>Interest</span>
											<span>:</span>
										</div>
										<span class="flex-1">P 90.00</span>
									</div>
									<div class="d-flex flex-row mb-7">
										<div class="d-flex flex-row justify-content-between flex-1 mr-16">
											<span>Penalty</span>
											<span>:</span>
										</div>
										<span class="flex-1">P 90.00</span>
									</div>
									<div class="d-flex flex-row mb-7">
										<div class="d-flex flex-row justify-content-between flex-1 mr-16">
											<span>PDI</span>
											<span>:</span>
										</div>
										<span class="flex-1">P 90.00</span>
									</div>
									<!-- <div class="d-flex flex-row">
										<div class="d-flex flex-row justify-content-between flex-1 mr-16">
											<span>Overpayment</span>
											<span>:</span>
										</div>
										<span class="flex-1">P 90.00</span>
									</div> -->
								</div>
								<div class="d-flex flex-column mb-auto">
									<span class="text-20 text-primary-dark">TOTAL</span>
									<span class="bg-primary-dark text-white font-30 pxy-25 lh-1">P 411.00</span>
								</div>
								
							</div>
							<div class="d-flex flex-column br-dark pr-16 pl-24 flex-1 font-md justify-content-between">
								<div class="d-flex flex-column mb-24">
									<span class="mb-5 text-bold">Distribution</span>
									<div class="d-flex flex-row mb-7">
										<div class="d-flex flex-row justify-content-between flex-1 mr-16">
											<span>Principal</span>
											<span>:</span>
										</div>
										<span class="flex-1">P 321.00</span>
									</div>
									<div class="d-flex flex-row mb-7">
										<div class="d-flex flex-row justify-content-between flex-1 mr-16">
											<span>Interest</span>
											<span>:</span>
										</div>
										<span class="flex-1">P 90.00</span>
									</div>
									<div class="d-flex flex-row mb-7">
										<div class="d-flex flex-row justify-content-between flex-1 mr-16">
											<span>Penalty</span>
											<span>:</span>
										</div>
										<span class="flex-1">P 90.00</span>
									</div>
									<div class="d-flex flex-row mb-7">
										<div class="d-flex flex-row justify-content-between flex-1 mr-16">
											<span>PDI</span>
											<span>:</span>
										</div>
										<span class="flex-1">P 90.00</span>
									</div>
									<div class="d-flex flex-row mb-7">
										<div class="d-flex flex-row justify-content-between flex-1 mr-16">
											<span>Total Waive</span>
											<span>:</span>
										</div>
										<span class="flex-1">P 250.00</span>
									</div>
									<!-- <div class="d-flex flex-row">
										<div class="d-flex flex-row justify-content-between flex-1 mr-16">
											<span>Overpayment</span>
											<span>:</span>
										</div>
										<span class="flex-1">P 90.00</span>
									</div> -->
								</div>
								<div class="d-flex flex-column mb-10">
									<span class="text-20 text-primary-dark">TOTAL</span>
									<span class="bg-darkgreen text-white font-30 pxy-25 lh-1">P 411.00</span>
								</div>
								<div class="d-flex flex-column bg-peach p-16">
									<span>Waive</span>
									<div class="d-flex flex-column mb-12">
										<div class="d-flex flex-row">
											<div class="d-flex flex-row justify-content-between flex-1 mr-16">
												<span class="pl-16">PDI</span>
												<span>:</span>
											</div>
											<span class="flex-1">P 0.00</span>
										</div>
										<div class="d-flex flex-row">
											<div class="d-flex flex-row justify-content-between flex-1 mr-16">
												<span class="pl-16">Penalty</span>
												<span>:</span>
											</div>
											<span class="flex-1">P 0.00</span>
										</div>
										
									</div>
									
								</div>
							</div>
						</div>
					</section>
					<div class="sep-dark"></div>
					<section>
						<span class="py-7 darker-bb text-primary-dark text-24 text-bold text-block mb-10">Outstanding Balance</span>
						<div class="d-flex flex-row font-md text-primary-dark">
							<div class="flex-1">
								<div class="d-flex flex-row mb-5 font-md">
									<div class="d-flex flex-row justify-content-between flex-1 mr-16">
										<span>Principal Balance</span>
										<span>:</span>
									</div>
									<span class="flex-1">P 7,040.00</span>
								</div>
								<div class="d-flex flex-row mb-5">
									<div class="d-flex flex-row justify-content-between flex-1 mr-16">
										<span>Interest Balance</span>
										<span>:</span>
									</div>
									<span class="flex-1">P 500.00</span>
								</div>
								<div class="d-flex flex-row bb-dashed-2 mb-10">
									<div class="d-flex flex-row justify-content-between flex-1 mr-16 mb-16">
										<span>Surcharge</span>
										<span>:</span>
									</div>
									<span class="flex-1">P 74.37</span>
								</div>
								<div class="d-flex flex-row mb-5 text-bold">
									<div class="d-flex flex-row justify-content-between flex-1 mr-16">
										<span>TOTAL</span>
										<span>:</span>
									</div>
									<span class="flex-1">P 7,614.37</span>
								</div>
							</div>
							<div class="flex-2"></div>
						</div>
					</section>
				</section>
			</div>
		  </div>
		</div>
	  </div>
	</div>
</template>

<script>
export default {
	props:['token'],
	data(){
		return {
			paymentType:'cash',
			borrowers:[]
		}
	},
	methods:{
		fetchBorrowers:function(){
			axios.get(window.location.origin + '/api/borrower', {
			headers: {
				'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.borrowers = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
	},
	mounted(){
		this.fetchBorrowers();
	}
}
</script>