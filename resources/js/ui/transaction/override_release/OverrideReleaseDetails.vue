<template>
	<div class="d-flex flex-column">
		<notifications group="foo" />
		<section class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title mb-24">Details</span>
			<div class="d-flex mb-12">
				<div class="d-flex flex-column mr-16" style="flex:20;">
					<div class="d-flex flex-row">
						<div class="borrower-number d-flex flex-column" style="flex: 5">
							<span>Borrower's Number</span>
							<span class="text-center">{{loanaccount.borrower.borrower_num}}</span>
						</div>
						<div style="flex:4"></div>
						<div class="form-group mb-10" style="flex: 5">
							<label for="transactionDate" class="form-label">Transaction Date</label>
							<input :value="dateToYMD(new Date)" type="date" class="form-control form-input text-right" id="transactionDate">
						</div>
					</div>
					<div class="form-group mb-5" style="flex: 5">
						<label for="client" class="form-label mb-3">Client</label>
						<input :value="loanaccount.borrower.firstname + ' ' + loanaccount.borrower.lastname" type="text" class="form-control form-input " id="client">
					</div>
					<div class="form-group mb-10" style="flex: 5">
						<label for="address" class="form-label mb-3">Address</label>
						<input :value="loanaccount.borrower.address" type="text" class="form-control form-input " id="address">
					</div>
				</div>
				<div class="upload-photo d-flex flex-column" style="flex:4;padding-top:36px;">
					<img :src="borrowerPhoto" alt="" style="max-width:250px;">
				</div>
			</div>
			<div class="sep mb-24"></div>
		</section>

		<section v-if="loanaccount.loan_account_id" class="mb-24" style="flex:21;padding-left:16px;">
			<span class="section-title section-subtitle mb-24">Loan Application</span>
			<div class="d-flex flex-row loan-details mb-24">
				<div class="d-flex flex-column flex-1">
					<h4 class="text-primary-dark mb-12">Deduction Fees</h4>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Filling Fee</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanaccount.filing_fee}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Documents</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanaccount.document_stamp}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Insurance</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanaccount.insurance}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Notarial</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanaccount.notarial_fee}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Prepaid Interest</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{formatToCurrency(prepaidInterest)}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Other / Mem</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanaccount.memo}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Net Amount</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanaccount.net_proceeds}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Release Type</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanaccount.release_type}}</span>
					</div>
				</div>
				<div class="d-flex flex-column flex-1">
					<h4 class="text-primary-dark mb-12">Loan Details</h4>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Amount Loan</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{formatToCurrency(loanaccount.loan_amount)}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Interest</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{formatToCurrency(loanaccount.interest_amount)}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Term</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanaccount.terms}} Days</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Rate</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanaccount.interest_rate}}%</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Type</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanaccount.type}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Mode</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanaccount.payment_mode}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Product</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanaccount.product.product_name}}</span>
					</div>

					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Center Name</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanaccount.center? loanaccount.center.center:''}}</span>
					</div>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Date Release</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{loanaccount.date_release.split('-').join('/')}}</span>
					</div>
					<div class="d-flex flex-row mb-12">
						<div class="d-flex flex-row flex-1 justify-content-between pr-24">
							<span class="">Due Date</span>
							<span>:</span>
						</div>
						<span class="flex-1 text-primary-dark">{{dateToYMD(dueDate).split('-').join('/')}}</span>
					</div>

				</div>
			</div>
			<div class="d-flex flex-row">
				<div class="d-flex flex-row align-items-between" style="flex:1">
					<a href="#" data-toggle="modal" data-target="#lettersModal" class="mr-16 flex-1 btn btn-yellow-light">Print Document</a>
					<a href="#" @click.prevent="amortSched" data-toggle="modal" data-target="#schedulesModal" class="mr-16 flex-1 btn btn-orange">Print Amort. Sched.</a>
					<a href="#" data-toggle="modal" data-target="#cashVoucherModal" class="mr-16 flex-1 btn btn-brown">Print Voucher</a>
					<a href="#" data-toggle="modal" data-target="#rejectModal" class="mr-16 flex-1 btn btn-primary-dark">Reject</a>
					<a href="#" class="mr-16 flex-1 btn btn-primary">Delete</a>
					<a href="#" @click="override()" data-toggle="modal" data-target="" class="flex-1 btn btn-success">Override</a>
				</div>
			</div>
		</section>
		<div class="modal" id="schedulesModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg minw-70" role="document">
		  <div class="modal-content">
			<div class="modal-body" id="amortPrintContent">
			  	<img src="/img/company_header.png" style="width:100%" class="mb-16" alt="Company Header">
				<div class="d-flex flex-column" style="padding:0 50px;">
					<span class="text-center text-block dark-bb pb-10 text-bold font-lg mb-16">AMORTIZATION SCHEDULE</span>

					<div class="d-flex flex-row mb-24">
						<div class="d-flex flex-column flex-2">
							<div class="d-flex mb-7">
								<span class="mr-5 text-primary-dark text-bold">Name: </span>
								<span class="text-primary-dark text-bold">{{loanaccount.borrower.lastname + ', ' + loanaccount.borrower.firstname}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">Address: </span>
								<span>{{loanaccount.borrower.address}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">Date Release: </span>
								<span>{{loanaccount.date_release}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">Amount Granted: </span>
								<span>{{loanaccount.loan_amount}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">Term: </span>
								<span>{{loanaccount.terms + ' Days'}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">Amort: </span>
								<span>{{amortAmount}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">Co-Borrower: </span>
								<span>{{loanaccount.co_borrower_name}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">Co-Address: </span>
								<span>{{loanaccount.co_borrower_address}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">Co-Maker: </span>
								<span>{{loanaccount.co_maker_name}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">Co-Address: </span>
								<span>{{loanaccount.co_maker_address}}</span>
							</div>
						</div>
						<div class="flex-1"></div>
						<div class="d-flex flex-column flex-2">
							<div class="d-flex mb-7">
								<span class="mr-5 text-primary-dark text-bold">Acc. #: </span>
								<span class="text-primary-dark text-bold">{{loanaccount.account_num}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">A/O: </span>
								<span class="">{{loanaccount.account_officer.name}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">Due Date: </span>
								<span class="">{{dateToYMD(dueDate).split('-').join('/')}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">Loan Type: </span>
								<span class="">{{loanaccount.type}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">Interest: </span>
								<span class="">{{loanInterest}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">Int. Rate: </span>
								<span class="">{{loanaccount.interest_rate + '%'}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">Mode: </span>
								<span class="">{{loanaccount.payment_mode}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">Center: </span>
								<span class="">{{loanaccount.center? loanaccount.center.center:''}}</span>
							</div>
							<div class="d-flex mb-7">
								<span class="mr-5">ID #: </span>
								<span class="">08-052415427-4</span>
							</div>
						</div>
					</div>			

					<section class="mb-24 d-flex flex-column">
						<span class="text-bold bg-gray" style="padding:0 5px;">Schedules</span>
						<div class="mb-10">
							<table class="table th-nbt table-thin">
								<thead>
									<th>No.</th>
									<th>Date</th>
									<th>Principal</th>
									<th>Interest</th>
									<th>Total</th>
									<th>Principal Balance</th>
									<th>Interest Balance</th>
								</thead>
								<tbody>
									<tr v-for="(sched, i) in amortizationSched" :key="i">
										<td>{{i + 1}}</td>
										<td>{{dateToYMD(new Date(sched.amortization_date))}}</td>
										<td>{{sched.principal}}</td>
										<td>{{sched.interest}}</td>
										<td>{{sched.total}}</td>
										<td>{{sched.principal_balance}}</td>
										<td>{{sched.interest_balance}}</td>
									</tr>
								</tbody>
							</table>
							
						</div>
						<div class="mb-45"></div>	
						<div class="mb-45"></div>			
						<p class="text-block text-center" style="line-height:0!important;">This statement is a system generated copy!</p>
						<p class="text-block text-center">&lt; End of file &gt;</p>
					</section>
					<div class="d-flex flex-row-reverse mb-45 no-print">
						<a href="#" @click="printAmort()" class="btn btn-default min-w-150">Print</a>
						<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
						<a href="#" id="cancelModal" data-dismiss="modal" class="btn btn-danger min-w-150 mr-24 hide">Cancel</a>
					</div>
				</div>
			</div>
		  </div>
		</div>
	</div>


	<div class="modal" id="overrideReleaseModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-xl" style="min-width:90%" role="document">
		  <div class="modal-content">
			<div class="modal-body p-24">
				<div class="d-flex flex-row justify-content-between align-items-center light-bb pb-16 mb-12">
					<span class="text-primary-dark text-bold">OVERRIDE LOAN RELEASE</span>
					<div class="d-flex flex-row">
						<div class="d-flex font-md mr-24 align-items-center">
							<span class="mr-5">Date:</span>
							<span>{{dateToMDY2(new Date(pdate)).split('-').join('/')}}</span>
						</div>
						<div class="d-flex font-md align-items-center mr-45">
							<span class="mr-5">Time:</span>
							<span>{{todayTime(new Date) + ' ' + amPm(new Date)}}</span>
						</div>
						<div class="d-flex flex-row align-items-center mr-24">
							<span class="mr-10 flex-1">Account Officer : </span>
							<select @change="overrideFilter" v-model="filter.ao_id" class="form-control flex-1 min-w-200" name="" id="">
								<option v-for="ao in aofficers" :key="ao.ao_id" :value="ao.ao_id">{{ao.name}}</option>
							</select>
						</div>
						<div class="d-flex flex-row align-items-center mr-24">
							<span class="mr-10 flex-1">Center : </span>
							<select @change="overrideFilter" v-model="filter.center" class="form-control min-w-200 flex-1" name="" id="">
								<option v-for="center in centers" :key="center.center_id" :value="center.center_id">{{center.center}}</option>
							</select>
						</div>
						<div class="d-flex flex-row align-items-center">
							<span class="mr-10 flex-1">Product Name : </span>
							<select @change="overrideFilter" v-model="filter.product" class="form-control min-w-200 flex-1" name="" id="">
								<option v-for="product in products" :key="product.product_id" :value="product.product_id">{{product.product_name}}</option>
							</select>
						</div>
					</div>
				</div>
				<span v-if="filteredOverrides.length == 0" class="py-12">No data available.</span>
				<div id="overridePrintContent">
					<img src="/img/company_header.png" style="width:100%" class="mb-16 to-print" alt="Company Header">
					<table v-if="filteredOverrides.length > 0" class="table table-stripped light-bb darker-bb" style="border-top:7px solid #999;">
						<thead>
							<th>Name</th>
							<th>Amount Loan</th>
							<th>Filling Fee</th>
							<th>Docs.</th>
							<th>Insurance</th>
							<th>Notarial</th>
							<th>Prepaid Interest</th>
							<th>Other / Mem</th>
							<th>Net Amount</th>
							<th>Cash Release Type</th>
						</thead>
						<tbody>
							<tr v-for="fo in filteredOverrides" :key="fo.loan_account_id">
								<td>{{fo.borrower.lastname + ', ' + fo.borrower.firstname}}</td>
								<td>{{fo.loan_amount}}</td>
								<td>{{fo.filing_fee}}</td>
								<td>{{fo.document_stamp}}</td>
								<td>{{fo.insurance}}</td>
								<td>{{fo.notarial_fee}}</td>
								<td>{{fo.prepaid_interest}}</td>
								<td>{{fo.memo}}</td>
								<td>{{fo.net_proceeds}}</td>
								<td>{{fo.release_type}}</td>
							</tr>
						</tbody>
					</table>
					<div class="d-flex flex-row mb-45">
						<div v-if="filteredOverrides.length > 0" class="flex-1 d-flex flex-row font-md">
							<span class="mr-16">SUMMARY : </span>
							<div class="flex-1 d-flex flex-column">
								<div class="d-flex flex-row">
									<div class="d-flex flex-row justify-content-between flex-1 mr-16">
										<span>Total Cash</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(totalCash)}}</span>
								</div>
								<div class="d-flex flex-row">
									<div class="d-flex flex-row justify-content-between flex-1 mr-16">
										<span>Total Memo</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(totalMemo)}}</span>
								</div>
								<div class="d-flex flex-row bb-dark-5 pb-7">
									<div class="d-flex flex-row justify-content-between flex-1 mr-16">
										<span>Total Cheque</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(totalCheque)}}</span>
								</div>
								<div class="d-flex flex-row align-items-center">
									<div class="d-flex flex-row justify-content-between flex-1 mr-16">
										<span>Total Release</span>
										<span>:</span>
									</div>
									<span class="flex-1 text-green text-24">{{formatToCurrency(totalRelease)}}</span>
								</div>
							</div>
						</div>
						<div class="flex-3"></div>
					</div>
					<div class="d-flex flex-row text-bold mb-45">
						<span class="flex-1"></span>
						<span class="flex-4">Prepared by:</span>
						<span class="flex-4">Certified Corrected by:</span>
						<span class="flex-4">Approved by:</span>
					</div>
					</div>
					
					<div class="d-flex flex-row-reverse">
						<a href="#" @click="printOverride()" data-dismiss="modal" class="btn btn-default min-w-150">Print</a>
						<a href="#" data-dismiss="modal" class="btn btn-success mr-16">Download to Excel</a>
						<a href="#" id="canceOverridelModal" data-dismiss="modal" class="btn btn-danger min-w-150 mr-24 hide">Cancel</a>
					</div>
				</div>
			</div>
			</div>
		</div>
			<div class="modal" id="rejectModal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-body">
					<div class="d-flex flex-column" style="min-height:200px;padding:16px;">
						<div class="d-flex flex-1 justify-content-center align-items-center">
						<p class="text-24 text-center">Are you sure you want to reject this loan account?</p>
						</div>
						<div class="d-flex flex-row">
							<div style="flex:2"></div>
							<button @click="reject()" data-dismiss="modal" class="btn btn-lg btn-primary-dark mr-24" style="flex:3">Yes</button>
							<button data-dismiss="modal" class="btn btn-lg btn-primary" style="flex:3">No</button>
							<div style="flex:2"></div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
		<div class="modal" id="cashVoucherModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg minw-70" role="document">
		  <div class="modal-content">
			<div class="modal-body font-md" id="voucherPrintContent">
			  	<img src="/img/company_header.png" style="width:100%" class="mb-24" alt="Company Header">
				<div class="d-flex flex-column" style="padding:0 50px;">
					<div class="d-flex flex-row align-items-center mb-24 darker-bb pb-10">
						<div class="flex-1">
							<span class="text-primary-dark font-26">Butuan Branch (001)</span>
						</div>
						<div class="d-flex flex-column">
							<span class="font-26 text-bold text-primary-dark lh-1">CASH VOUCHER</span>
						</div>
						<div class="flex-1 d-flex justify-content-end pr-10">
							<span class=" mr-10">{{dateFullDay(new Date())}} {{dateToYMD(new Date()).split('-').join('/')}}</span>
							<span class="">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
						</div>
					</div>
					<section class="mb-16">
						<div class="d-flex flex-row">
							<div class="d-flex flex-column flex-2">
								<div class="d-flex flex-row mb-10">
									<span class="flex-1 mw-150">Pay to</span>
									<div class="d-flex flex-1">
										<span class="mr-5">: </span>
										<span> {{loanaccount.account_officer.name}}</span>
									</div>
								</div>
								<div class="d-flex flex-row">
									<span class="flex-1 mw-150">Voucher No.</span>
									<div class="d-flex flex-1">
										<span class="mr-5">: </span>
										<span> 001-002-0010215</span>
									</div>
								</div>
							</div>
							<div class="flex-1"></div>
							<div class="d-flex flex-column-reverse flex-2">
								<div class="d-flex flex-row">
									<span class="flex-1 text-right">Voucher Date</span>
									<div class="d-flex flex-1">
										<span class="mr-5">: </span>
										<span> __________________</span>
									</div>
								</div>
							</div>
							<div class="flex-1"></div>
						</div>
					</section>

					<div class="sep-dark mb-16"></div>

					<section class="mb-24">
						<div class="d-flex flex-row mb-24">
							<div class="d-flex flex-column flex-2">
								<div class="d-flex flex-row mb-10">
									<span class="flex-1 mw-150">Particular</span>
									<div class="d-flex flex-2">
										<span class="mr-5">: </span>
										<span> Loan Granted P {{formatToCurrency(loanaccount.loan_amount)}} for {{loanaccount.terms / 30}} month(s) / weekly payment. With interest of {{loanaccount.interest_rate}}% per month</span>
									</div>
								</div>
								<div class="d-flex flex-row">
									<span class="flex-1 mw-150">Net Amount</span>
									<div class="d-flex flex-2">
										<span class="mr-5">: </span>
										<span> P {{formatToCurrency(loanaccount.net_proceeds)}}</span>
									</div>
								</div>
							</div>
						</div>
						<p class="mb-45">
							Received payment from MICRO ACCESS LOANS CORPORATION - BUTUAN BRANCH (001) The sum of <span class="allcaps">{{numToWords(parseFloat(loanaccount.net_proceeds))}}</span> Pesos only.
						</p>
						<div class="d-flex flex-row">
							<span class="flex-1">Received By: _________________________________</span>
							<span class="flex-1">Disbursed By: _________________________________</span>
						</div>
					</section>

					<div class="sep-dark mb-16"></div>

					<section>
						<div class="d-flex flex-row justify-content-center mb-16 darker-bb pb-10">
							<div class="d-flex flex-column">
								<span class="font-26 text-bold text-primary-dark lh-1 text-center text-block">DISCLOSURE STATEMENT OF LOAN</span>
							</div>
						</div>

						<div class="d-flex flex-row mb-24 bb-dashed pb-16">
							<div class="d-flex flex-column flex-2">
								<div class="d-flex flex-row mb-10">
									<span class="flex-1 mw-150">Installment</span>
									<div class="d-flex flex-2">
										<span class="mr-5">: </span>
										<span> {{loanaccount.terms/30}} Monthly</span>
									</div>
								</div>
								<div class="d-flex flex-row">
									<span class="flex-1 mw-150">Amortization</span>
									<div class="d-flex flex-2">
										<span class="mr-5">: </span>
										<span> P {{amortAmount}}</span>
									</div>
								</div>
							</div>
						</div>

						<table class="table dark-border th-nb th-bb-dark mb-24">
							<thead>
								<th >Acct</th>
								<th >Title</th>
								<th >S/L</th>
								<th >Debit</th>
								<th >Credit</th>
							</thead>
							<tbody>
								<tr>
									<td>1205</td>
									<td>Loans Receivable - Current</td>
									<td></td>
									<td>5,000.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>1205</td>
									<td>Loans Receivable - Current</td>
									<td></td>
									<td>5,000.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>1205</td>
									<td>Loans Receivable - Current</td>
									<td></td>
									<td>5,000.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>1205</td>
									<td>Loans Receivable - Current</td>
									<td></td>
									<td>5,000.00</td>
									<td>0.00</td>
								</tr>
								<tr>
									<td>1205</td>
									<td>Loans Receivable - Current</td>
									<td></td>
									<td>5,000.00</td>
									<td>0.00</td>
								</tr>
								<tr class="bg-black">
									<td>TOTAL</td>
									<td></td>
									<td></td>
									<td>5,000.00</td>
									<td>5,000.00</td>
								</tr>
							</tbody>
						</table>

						<p class="mb-72">
							I/We acknowledge and understand the statement above prior to the signing and consummation of the credit transaction and that I/We fully agree to the to the terms and conditions stated on promissory note.
						</p>

						<div class="d-flex flex-row px-45">
							<div class="d-flex flex-column flex-1">
								<span class="text-center bt-dark-2 py-12 mb-45">Borrow Sign / Printed Name</span>
								<span class="text-center bt-dark-2 py-12 mb-45">Date Disbursed / Ackknowledged</span>
							</div>
							<div class="flex-1"></div>
							<div class="d-flex flex-column flex-1">
								<span class="text-center bt-dark-2 py-12 mb-45">Co-Borrow Sign / Printed Name</span>
								<span class="text-center bt-dark-2 py-12 mb-45">MAC Representative Signature</span>
							</div>
						</div>

					</section>

					<div class="mb-72"></div>
					<div class="d-flex flex-row-reverse mb-45 no-print">
						<a @click="printVoucher()" href="#" class="btn btn-default min-w-150">Print</a>
						<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
						<a href="#" id="cancelVoucherModal" data-dismiss="modal" class="btn btn-danger min-w-150 mr-24 hide">Cancel</a>
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
	props:['ploanaccount', 'pdate', 'token', 'csrf'],
	data(){
		return {
			filter:{ao_id:null,center_id:null,product_id:null, created_at:null},
			borrower:'',
			loanDetails:'',
			loanaccount:{
				borrower:{
					borrower_num:'',
					firstname:'',
					middlename:'',
					lastname:''
				},
				center:{
					center:''
				},
				account_officer:{
					name:'',
				}
			},
			amortizationSched:[],
			centers:[],
			products:[],
			aofficers:[],
			productName:'',
			filteredOverrides:[],
			amortAmount:0,
		}
	},
	methods:{
		notify:function(title, text, type){
			this.$notify({
				group: 'foo',
				title: title,
				text: text,
				type: type,
			});
		},
		amortSched:function(){
			axios.post(window.location.origin + '/api/account/generate-amortization', this.loanaccount, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.amortizationSched = response.data.data;
				this.loanaccount.due_date = this.amortizationSched[this.amortizationSched.length - 1].amortization_date;
				this.amortAmount = this.amortizationSched[0].total;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		fetchCenters:function(){
			axios.get(window.location.origin + '/api/center', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.centers = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		fetchProducts: function(){
			axios.get(window.location.origin + '/api/product/', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.products = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		fetchAo: function(){
			axios.get(window.location.origin + '/api/accountofficer/', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.aofficers = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		fetchFilteredOverride: function(){
			console.log(this.filter);
			this.filter.created_at = this.pdate;
			axios.post(window.location.origin + '/api/account/overrrideaccounts', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.filteredOverrides = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		override: function(){
			this.loanaccount.date_release = this.dateToYMD(new Date);
			axios.post(window.location.origin + '/api/account/override', [this.loanaccount], {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.notify('',response.data.message, 'success');
				this.$emit('updateLoanAccounts');
				this.createAmortization();
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		createAmortization: function(){
			// this.loanaccount.date_release = this.dateToYMD(new Date);
			axios.get(window.location.origin + '/api/account/create-amortization/' + this.loanaccount.loan_account_id + '/', this.loanaccount, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				console.log(response.data);
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		
		reject: function(){
			axios.put(window.location.origin + '/api/account/reject/' + this.loanaccount.loan_account_id, this.loanaccount, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.$emit('updateLoanAccounts');
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		printAmort:function(){
			var content = document.getElementById('amortPrintContent').innerHTML;
			var target = document.querySelector('.to-print');
			var cancel = document.querySelector('#cancelModal');
			target.innerHTML = content;
			cancel.click();
			window.print();
		},
		overrideFilter:function(){
			if(this.filter.product || this.filter.center || this.filter.ao_id){
				this.fetchFilteredOverride();
			}
		},
		printOverride:function(){
			var content = document.getElementById('overridePrintContent').innerHTML;
			var target = document.querySelector('.to-print');
			var cancel = document.querySelector('#canceOverridelModal');
			target.innerHTML = content;
			cancel.click();
			window.print();
		},
		printVoucher:function(){
			var content = document.getElementById('voucherPrintContent').innerHTML;
			var target = document.querySelector('.to-print');
			var cancel = document.querySelector('#cancelVoucherModal');
			target.innerHTML = content;
			cancel.click();
			window.print();
		},
	},
	computed:{
		prepaidInterest:function(){
			return this.loanaccount.type=='Add-On'? 0:this.loanaccount.prepaid_interest;
		},
		dueDate:function(){
			if(this.loanaccount.loan_account_id){
				var dt = new Date(this.loanaccount.date_release);
				dt.setDate(dt.getDate() + this.loanaccount.terms);
				return dt;
			}
			return new Date
		},
		loanInterest:function(){
			if(this.amortizationSched.length > 0){
				return this.amortizationSched[0].interest;
			}
			return '';
		},
		totalCash:function(){
			var amount = 0;
			this.filteredOverrides.map(function(fo){
				if(fo.release_type == 'Cash Release'){
					amount += parseFloat(fo.loan_amount);
				}
			});
			return amount;
		},
		totalMemo:function(){
			var amount = 0;
			this.filteredOverrides.map(function(fo){
				if(fo.release_type == 'Memo Release'){
					amount += parseFloat(fo.loan_amount);
				}
			});
			return amount;
		},
		totalCheque:function(){
			var amount = 0;
			this.filteredOverrides.map(function(fo){
				if(fo.release_type == 'Cheque Release'){
					amount += parseFloat(fo.loan_amount);
				}
			});
			return amount;
		},
		totalRelease:function(){
			var amount = 0;
			return this.totalCash + this.totalMemo + this.totalCheque;
		},
		borrowerPhoto:function(){
			return this.loanaccount.borrower_photo? this.loanaccount.borrower_photo : '/img/user.png';
		}
	},
	watch:{
		'ploanaccount'(newData){
			this.loanaccount = newData;
			this.loanaccount.date_release = this.dateToYMD(new Date());
			this.loanaccount.loan_account_id?this.amortSched():null;
		},
	},
	mounted(){
		this.fetchCenters();
		this.fetchProducts();
		this.fetchAo();
	}
}
</script>

