<style>

.payments-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: auto; /* keeps columns aligned */
  }

  .payments-table th,
  .payments-table td {
    padding: 4px 6px;
    white-space: nowrap; /* prevent wrapping */
    border: 1px solid #ccc;
    font-size: 13px;
	white-space: nowrap;
  }

  /* Narrow columns (small values) */
.payments-table th:nth-child(5),  /* PDI */
.payments-table td:nth-child(5),
.payments-table th:nth-child(6),  /* Penalty */
.payments-table td:nth-child(6),
.payments-table th:nth-child(7),  /* Rebates */
.payments-table td:nth-child(7) {
  width: 60px;      /* force small width */
  text-align: right;
}

.payments-table th:nth-child(8),
.payments-table td:nth-child(8),
/* Total Payment (9th col) */
.payments-table th:nth-child(9),
.payments-table td:nth-child(9) {
  text-align: center;
}

/* Bank Name expands to fit */
.payments-table th:nth-child(11),
.payments-table td:nth-child(11) {
  width: auto;         /* auto size */
  white-space: nowrap; /* don't break text */
  text-align: center;
}

.nowrap {
  white-space: nowrap;
}

@media print {
	.payments-table th {
    text-align: center;
    vertical-align: middle;
  }
	.print-page-break {
	  page-break-inside: avoid; /* Prevents being split */
	}
  }
</style>



<template>
	<div class="px-16">
		<notifications group="foo" />
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
		<div class="container-fluid">
			<div class="mb-16"></div>
			<div class="d-flex justify-content-between mb-24 bb-primary-dark pb-7 text-block">
				<h1 class="m-0 font-35">Statement of Account Details</h1>
		</div><!-- /.col -->


	<div class="sep mb-24"></div>
	<section class="d-flex mb-24">
		<div class="d-flex flex-1 flex-sm-row personal-info" style="margin-bottom:24px;">
			<div class="upload-photo mb-24">
				<img :src="borrowerPhoto" alt="" style="max-width:250px;">
				<!-- <a href="#" data-toggle="modal" data-target="#uploadModal" class="btn btn-primary" style="padding:10px!important">Upload or Take a Photo</a> -->
			</div>
			<div class="flex-gap-24"></div>
			<div class="info-main-container" style="width:100%;">
				<div class="row info-container">
					<div class="col-xl-2 col-lg-6">
						<div class="customer-number">
							<span>Customer Number</span>
							<span>{{borrower.borrower_num}}</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>First Name</span>
							<span class="xs-font-24">{{borrower.firstname}}</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>Middle Name</span>
							<span>{{borrower.middlename}}</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>Last Name</span>
							<span>{{borrower.lastname}}</span>
						</div>
					</div>
					<div class="col-xl-4">
						<div class="info-display">
							<span>Suffix</span>
							<span>{{borrower.suffix}}</span>
						</div>
					</div>

				</div>
				<div class="row info-container">
					<div class="col-xl-3 col-lg-6">
						<div class="info-display">
							<span>Birth Date</span>
							<span>{{dateToMDY(new Date(borrower.birthdate))}}</span>
						</div>
					</div>
					<div class="col-xl-1 col-lg-6">
						<div class="info-display">
							<span>Age</span>
							<span>{{calculateAge(dateToYMD(new Date(borrower.birthdate)))}}</span>
						</div>
					</div>
					<div class="col-xl-1 col-lg-6">
						<div class="info-display">
							<span>Gender</span>
							<span>{{capitalizeFirstLetter(borrower.gender)}}</span>
						</div>
					</div>
					<div class="col-xl-1 col-lg-6">
						<div class="info-display">
							<span>Status</span>
							<span>{{capitalizeFirstLetter(borrower.status)}}</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>Contact Number</span>
							<span>{{borrower.contact_number}}</span>
						</div>
					</div>
					<div class="col-xl-4 col-lg-6">
						<div class="info-display">
							<span>Registration Date</span>
							<span>{{dateToMDY(new Date(borrower.date_registered))}}</span>
						</div>
					</div>
				</div>
				<div class="row info-container">
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>ID. Type</span>
							<span>{{borrower.id_type}}</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6">
						<div class="info-display">
							<span>ID. Number</span>
							<span>{{borrower.id_no}}</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>ID. Date</span>
							<span>{{dateToMDY(new Date(borrower.id_date_issued))}}</span>
						</div>
					</div>
				</div>
				<div class="row info-container xs-mb-32">
					<div class="col-md-12">
						<div class="info-display">
							<span class="text-block">Address</span>
							<span>{{borrower.address}}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div>
		<form action="" class="mb-10">
		<input v-model="filter" type="text" class="form-control" placeholder="Search">
	</form>
	<div style="max-height:300px!important;overflow:auto;">
		<table class="table table-stripped table-hover light-border mb-24 table-row-clickable" id="accountTable">
			<thead>
				<th>Account #</th>
				<th>Loan Amount</th>
				<th>Date Granted</th>
				<th>Term</th>
				<th>Collection Rate</th>
				<th>Payment History</th>
				<th>Current Loan Status</th>
				<th></th>
			</thead>
			<tbody>
				<tr @click="fetchAccountId (a.account_num);selected=i" v-for="(a, i) in filteredAccounts" :key="i" :class="i==selected?'account-active':''">
					<td>{{a.account_num}}</td>
					<td>{{formatToCurrency(a.loan_amount)}}</td>
					<td>{{dateToMDY(new Date(a.date_granted))}}</td>
					<td>{{Math.ceil(a.term / 30)}} Month(s)</td>
					<td>{{a.collection_rate}}%</td>
					<td>{{a.payment_history}}</td>
					<td>{{a.loan_status}}</td>
					<td><a v-show="hasAccessToEdit" @click.prevent="editAccount=a" href="" data-toggle="modal" data-target="#editAccountModal"><i class="fa fa-edit"></i> Edit</a></td>
				</tr>
				<tr v-if="filteredAccounts.length == 0">
					<td>No accounts found.</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- <mac-pagination v-if="canPaginate" @setpage="setPage" :pdata="filteredAccounts" :ppage="pagination.page" :prange="pagination.range" class="mb-24"></mac-pagination> -->
	</div>



	<div class="info-display title mb-12">
		<span>Account Details</span>
	</div>
	<account-details @load="loading=true" @unload="loading=false" v-if="loanDetails.loan_account_id" :ploanDetails="loanDetails.loan_account_id" :showPayments="true" :token="token"></account-details>

	<div class="mb-72"></div>
	<div v-if="loanDetails.loan_account_id" class="d-flex flex-row mb-72 justify-content-between">
		<a href="#" data-toggle="modal" data-target="#uploadedFilesModal" class="btn btn-darkorange"><i class="fa fa-folder mr-10"></i> <span>Upload Document</span></a>
		<div class="d-flex flex-row justify-content-end">
			<a href="#" data-toggle="modal" data-target="#lettersModal" class="btn btn-sky-blue mr-10 min-w-150">Letters</a>
			<!-- <a href="#" data-toggle="modal" data-target="#statusReportModal" class="btn btn-bright-blue mr-10 min-w-150">Print Payment Status</a> -->
			<a href="#" data-toggle="modal" data-target="#cashVoucherModal" class="btn btn-purple mr-10 min-w-150">Voucher</a>
			<a href="#" data-toggle="modal" data-target="#promisoryNoteModal" class="btn btn-success mr-10 min-w-150">Promissory Note</a>
			<a href="#" data-toggle="modal" data-target="#schedulesModal" class="btn btn-yellow mr-10 min-w-150">Amortization Sched.</a>
			<a href="#" data-toggle="modal" data-target="#soaModal" class="btn btn-primary-dark min-w-150">Print SOA</a>
		</div>
	</div>

		</div>
		<upload-file @imageCapture="imageCapture"/>



		<div class="modal" id="lettersModals" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg minw-70" role="document">
				<div class="modal-content">
					<div class="modal-body p-24">
						<span class="light-bb text-bold text-primary-dark text-lg pb-16 mb-24 text-block">Letters</span>
						<div class="d-flex flex-column flex-md-row align-items-start">
							<div class="flex-2 light-border d-flex flex-column letter-nav xs-mb-32 xs-flex-1">
								<div class="pxy-25 light-bb">
									<span class="text-20">Reminder Letter</span>
								</div>
								<div class="pxy-25 light-bb active">
									<span class="text-20">First Letter</span>
								</div>
								<div class="pxy-25 light-bb">
									<span class="text-20">Second Letter</span>
								</div>
								<div class="pxy-25 light-bb">
									<span class="text-20">Final Demand</span>
								</div>
								<div class="pxy-25 light-bb">
									<span class="text-20">Final Notice</span>
								</div>
								<div class="pxy-25 light-bb">
									<span class="text-20">Return Check</span>
								</div>
								<div class="pxy-25 light-bb">
									<span class="text-20">Bouncing Check</span>
								</div>
								<div class="pxy-25 light-bb">
									<span class="text-20">Attorney's Demand</span>
								</div>
								<div class="pxy-25 light-bb">
									<span class="text-20">DACION EN PAGO</span>
								</div>
								<div class="pxy-25 light-bb">
									<span class="text-20">DOA For ATM</span>
								</div>
								<div class="pxy-25">
									<span class="text-20">MOA For SME</span>
								</div>
							</div>
							<div class="flex-5" id="firstLetterPrintContent">
								<img :src="this.baseURL()+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
								<div class="d-flex flex-column font-md" style="padding:0 35px;">

									<ul class="metadata base-list font-md mb-64">
										<li>{{dateToMDY(new Date)}}</li>
										<li>{{borrower.firstname + ' ' + borrower.lastname}}</li>
										<li>{{loanDetails.co_borrower_name}}</li>
										<li>{{loanDetails.co_maker_name}}</li>
										<li>{{borrower.address}}</li>
									</ul>

									<div class="d-flex flex-column title align-items-center mb-16">
										<span class="text-lg text-bold">NOTICE OF PAYMENT DELINQUENCY</span>
										<span class="text-lg">(FIRST NOTICE)</span>
									</div>
									<div class="salutation mb-24 d-flex flex-column">
										<span class="mb-45">Dear Sir/Madam :</span>
										<span>G r e e t i n g s!</span>
									</div>
									<div class="body mb-64">
										<p>
											As our valued client, building and preserving good relationship with you is what concerns us most. We want to provide quick access to loans and continuous credit line for your utmost convenience. For the continuation of your credit line and to further our relationship, we are closely monitoring your account.It has then come to our attention that your accunt is in delinquent status. The total delinquent amount has reached to Php {{formatToCurrency(delinquentAmount)}}. Please take note that one of our agreement stated in your Loan Promissory Note No. {{loanDetails.documents.promissory_number}} dated {{dateToMDY(new Date(loanDetails.documents.date_release))}} that in case of default/delinquent, this promissory note will be due and demandable.
										</p>
										<p>
											We therefore, hope and expect that you will be able to settle your obligation the soonest posssible. Please give this matter your greatest attention to avoid embarassment.
										</p>
										<p>
											Shoud you have any inquiries regarding your loan outstanding balance, we would really appreciate if you can visit our branches located near you or call us at (085)816-3284 Butuan Branch (085) 343-3574 Nasipit Branch.
										</p>
									</div>
									<div class="truly-yours d-flex flex-column mb-64">
										<span class="mb-36">Very truly yours,</span>
										<span>JANINE L. DESCALLAR</span>
										<span>Branch Manager</span>
									</div>
									<div class="d-flex flex-row-reverse">
										<div class="d-flex flex-column">
											<span class="pb-36 darker-bb mb-10">Received by:</span>
											<span class="pr-24">(Signature over printed name)</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="mb-72"></div>
						<div class="d-flex flex-row-reverse mb-45">
							<a @click.prevent="printContent('firstLetterPrintContent')" href="#" class="btn btn-default min-w-150">Print</a>
							<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
						</div>
						<div class="d-flex mb-24">
							<!-- <img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="Company Footer"> -->
						</div>
					</div>
				</div>
			</div>
		</div>

		<print-docs :branch="branch" :ploanDetails="loanDetails" :token="token" statement="1"></print-docs>



		<div class="modal" id="statusReportModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg minw-70" role="document">
				<div class="modal-content">
					<div class="modal-body" id="paymentStatusPrintContent">
						<img :src="this.baseURL()+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
						<div class="d-flex flex-column" style="padding:0 50px;">
							<span class="text-center text-block dark-bb pb-10 text-bold font-lg mb-16">PAYMENT STATUS REPORT</span>

							<div class="d-flex flex-row mb-24">
								<div class="d-flex flex-column flex-2">
									<div class="d-flex mb-7">
										<span class="mr-5 text-primary-dark text-bold">Name: </span>
										<span class="text-primary-dark text-bold">{{fullNameReverse(borrower.firstname, borrower.middlename, borrower.lastname)}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Address: </span>
										<span>{{borrower.address}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Date Release: </span>
										<span>{{dateToMDY(new Date(loanDetails.date_release))}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Amount Granted: </span>
										<span>{{formatToCurrency(loanDetails.loan_amount)}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Term: </span>
										<span>{{loanDetails.terms}} Days / {{loanDetails.terms / 30}} Month(s)</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Amort: </span>
										<span>{{formatToCurrency(loanDetails.amortization.total)}}</span>
									</div>
									<!-- <div class="d-flex mb-7">
										<span class="mr-5">Group: </span>
									</div> -->
									<div class="d-flex mb-7">
										<span class="mr-5">Co-Borrower: </span>
										<span>{{loanDetails.co_borrower_name}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Co-Address: </span>
										<span>{{loanDetails.co_borrower_address}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Co-Maker: </span>
										<span>{{loanDetails.co_maker_name}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Co-Address: </span>
										<span>{{loanDetails.co_maker_address}}</span>
									</div>
								</div>
								<div class="flex-1"></div>
								<div class="d-flex flex-column flex-2">
									<div class="d-flex mb-7">
										<span class="mr-5 text-primary-dark text-bold">Acc. #: </span>
										<span class="text-primary-dark text-bold">{{loanDetails.account_num}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">A/O: </span>
										<span class="">{{loanDetails.account_officer.name}}</span>
									</div>
									<div class=" d-flex mb-7">
										<span class="mr-5">Due Date: </span>
										<span class="">{{dateToMDY(new Date(loanDetails.due_date))}}</span>
									</div>
									<div class=" d-flex mb-7">
										<span class="mr-5">Loan Type: </span>
										<span class="">{{loanDetails.type}}</span>
									</div>
									<div class=" d-flex mb-7">
										<span class="mr-5">Interest: </span>
										<span class="">{{formatToCurrency(loanDetails.interest_amount)}}</span>
									</div>
									<div class=" d-flex mb-7">
										<span class="mr-5">Int. Rate: </span>
										<span class="">{{loanDetails.interest_rate * 12}}% p.a. / {{loanDetails.interest_rate}}% p.m.</span>
									</div>
									<div class=" d-flex mb-7">
										<span class="mr-5">Mode: </span>
										<span class="">{{loanDetails.payment_mode}}</span>
									</div>
									<div class=" d-flex mb-7">
										<span class="mr-5">Center: </span>
										<span class="">{{loanDetails.center?loanDetails.center.center:'None'}}</span>
									</div>
									<div class=" d-flex mb-7">
										<span class="mr-5">ID #: </span>
										<span class="">{{borrower.id_no}}</span>
									</div>
								</div>
							</div>

							<section class=" mb-24 d-flex flex-column">
								<span class="text-bold bg-yellow" style="padding:0 5px;">Release</span>
								<table class="table th-nb td-nb table-thin">
									<thead>
										<th>Date</th>
										<th>Details</th>
										<th>Debit</th>
										<th>Credit</th>
										<th>Total Balance</th>
									</thead>
									<tbody>
										<tr>
											<td>12/12/2021</td>
											<td>Amount Loan</td>
											<td>28,000.00</td>
											<td></td>
											<td>28,000.00</td>
										</tr>
										<tr>
											<td>12/12/2021</td>
											<td>Amount Loan</td>
											<td>28,000.00</td>
											<td></td>
											<td>28,000.00</td>
										</tr>
									</tbody>
								</table>
							</section>

							<section class="mb-24 d-flex flex-column">
								<span class="text-bold bg-gray" style="padding:0 5px;">Payment</span>
								<div class="mb-10">
									<table class="table th-nbt">
										<thead>
											<th>Date</th>
											<th>Debit</th>
											<th>Credit</th>
											<th>Balance</th>
											<th>Status</th>
											<th>Late</th>
											<th>Late Range</th>
										</thead>
										<tbody>
											<tr>
												<td>12/12/2021</td>
												<td>0.00</td>
												<td>2,500.00</td>
												<td>-2,500.00</td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<td>12/12/2021</td>
												<td>0.00</td>
												<td>2,500.00</td>
												<td>-2,500.00</td>
												<td>Advance</td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<td>12/12/2021</td>
												<td>0.00</td>
												<td>2,500.00</td>
												<td>-2,500.00</td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<td>12/12/2021</td>
												<td>0.00</td>
												<td>2,500.00</td>
												<td>-2,500.00</td>
												<td>Advance</td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<td>12/12/2021</td>
												<td>0.00</td>
												<td>2,500.00</td>
												<td>-2,500.00</td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<td>12/12/2021</td>
												<td>0.00</td>
												<td>2,500.00</td>
												<td>-2,500.00</td>
												<td>Advance</td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<td>12/12/2021</td>
												<td>0.00</td>
												<td>2,500.00</td>
												<td>-2,500.00</td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<td>12/12/2021</td>
												<td>0.00</td>
												<td>2,500.00</td>
												<td>-2,500.00</td>
												<td>Advance</td>
												<td></td>
												<td></td>
											</tr>
										</tbody>
									</table>

								</div>
								<div class="mb-45"></div>
								<div class="mb-45"></div>
								<p class="text-block text-center" style="line-height:0!important;">This statement is a system generated copy!</p>
								<p class="text-block text-center">&lt; End of file &gt;</p>
							</section>
							<div class="d-flex flex-row-reverse mb-45">
								<a @click.prevent="printContent('paymentStatusPrintContent')" href="#" class="btn btn-default min-w-150">Print</a>
								<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
							</div>
							<div class="d-flex mb-24">
								<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="Company Footer">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal text-justify" id="promisoryNoteModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg minw-70" role="document">
			<div class="modal-content">
				<div class="modal-body font-md" id="promissoryPrintContent">
					<!-- <img :src="this.baseURL()+'/img/company_header.png'" style="width:100%" class="mb-45" alt="Company Header"> -->
					<div class="d-flex flex-column justify-content-between" style="padding:0 50px;min-height:420mm">
											<div>
												<div class="d-flex flex-row align-items-center mb-36">
													<div class="flex-1">
														<span class="text-primary-dark font-25">{{branch.branch_name}} Branch ({{branch.branch_code}})</span>
													</div>
													<div class="d-flex flex-column">
														<span style="display: block; text-align: center;" class="font-26 text-bold text-primary-dark lh-1">PROMISSORY NOTE</span>
														<span class="text-center text-primary-dark text-bold font-md mb-5">MICRO ACCESS LOAN CORPORATION</span>
														<span class="text-center text-primary-dark font-20">{{loanDetails.documents.promissory_number}}</span>
													</div>
													<div class="flex-1 d-flex justify-content-end pr-10">
														<span class=" mr-10">{{dateFullDay(new Date())}} {{dateToYMD(new Date()).split('-').join('/')}}</span>
														<!-- <span class="">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span> -->
													</div>
												</div>
												<section>
													<p class="font-md" style="line-height:1.3;font-size:15px!important">
														I/We <b> {{borrower.lastname + ', ' + borrower.firstname + ' ' + borrower.middlename.charAt(0) + '. and ' + loanDetails.co_borrower_name}}</b>  borrowed and received the amount of <span class="allcaps"><b>{{numToWords(loanDetails.loan_amount)}} </b> PESOS</span> (P {{formatToCurrency(loanDetails.loan_amount)}}) and promise to pay jointly and severally (solidarily) to the <b>MICRO ACCESS LOANS CORPORATION</b>  until full payment of the said amount including interest rate of ( <b> {{formatToCurrency(loanDetails.interest_rate)}}%</b> ) per month. And with the following terms and conditions stated below:
													</p>
												</section>
												<span class="bbt-8 py-7 text-center text-block text-20 text-bold mb-16">TERMS AND CONDITIONS</span>
												<section class="mb-24" style="font-size:16px!important;line-height:1.3em!important">
													<div class="d-flex flex-row">
														<div class="d-flex flex-column flex-1 font-md">
															<div class="d-flex flex-row">
																<div class="d-flex flex-row flex-1 justify-content-between pr-24">
																	<span class="flex-50">Interest Rate</span>
																	<span>:</span>
																</div>
																<span class="flex-2">{{formatToCurrency(loanDetails.interest_rate)}}%</span>
															</div>

															<div class="d-flex flex-row">
																<div class="d-flex flex-row flex-1 justify-content-between pr-24">
																	<span class="flex-50">Term (No. of days)</span>
																	<span>:</span>
																</div>
																<span class="flex-2">{{loanDetails.terms}} day(s)</span>
															</div>

															<div class="d-flex flex-row">
																<div class="d-flex flex-row flex-1 justify-content-between pr-24">
																	<span class="">Mode of Payment</span>
																	<span>:</span>
																</div>
																<span class="flex-2">{{loanDetails.payment_mode}}</span>
															</div>
														</div>
														<div class="d-flex flex-column flex-1 font-md">
															<div class="d-flex flex-row">
																<div class="d-flex flex-row flex-1 justify-content-between pr-24">
																	<span class="">Due Date</span>
																	<span>:</span>
																</div>
																<span class="flex-2 darker-bb"></span>
															</div>

															<div class="d-flex flex-row">
																<div class="d-flex flex-row flex-1 justify-content-between pr-24">
																	<span class="">Product</span>
																	<span>:</span>
																</div>
																<span class="flex-2">{{loanDetails.product.product_name}}</span>
															</div>
														</div>
													</div>
												</section>
												<span class="bbt-8 py-7 text-center text-block text-20 text-bold mb-16">OTHER CONDITIONS</span>
												<section class="font-md mb-24" style="font-size:15px!important;line-height:1.3em!important">
													<p style="line-height:1.3" class="mb-36 text-justify">
														In case of default, this note will be due and demandable without further demand, and an additional fee of (2%) per missed payment of the scheduled amortization as penalty, And in case this note be given to hands of an attorney an additional charged of (10%) of the total amount due will be charged as attorney's fee, further, the borrower is liable to litigation expenses, damages, etc. should the failure on the part of the borrower reach the courts. In cases that the borrower/s changes address/ transfer of residence without notice to <b>MICRO ACCESS LOANS CORPORATION </b> in writing, the address indicated in this note shall be the address for purposes of delivery of notices and other matters pertaining to the loan. Shall any issue/case that may arise as a result of this promissory note on any document in relation hereto, venue shall be at the civil courts of Butuan City, Agusan del Norte, to the exclusion of other court or at the option of <b>MICRO ACCESS LOANS CORPORATION</b> The Borrower/s hereby authorized the <b> MICRO ACCESS LOANS CORPORATION </b> to assign, sell or otherwise negotiate this note with any financial institution on its face value. Done this _____ day of ____________________.
													</p>

													<div class="d-flex flex-row">
														<div class="flex-1"></div>
														<div class="d-flex flex-column flex-3">
															<div class="d-flex">
																<span class="mr-5">{{fullName(borrower.firstname, borrower.middlename,borrower.lastname)}} </span>
																<span></span>
															</div>
															<div class="d-flex">
																<span class="mr-5">Borrower Signature</span>
																<span></span>
															</div>
															<div class="d-flex">
																<span class="mr-5">Type of ID : </span>
																<span>{{borrower.id_type}}</span>
															</div>
															<div class="d-flex">
																<span class="mr-5">ID Number : </span>
																<span>{{borrower.id_no}}</span>
															</div>
															<div class="d-flex">
																<span class="mr-5">Date Issue : </span>
																<span>{{dateToYMD(new Date(borrower.id_date_issued)).split('-').join('/')}}</span>
															</div>
														</div>
														<div class="d-flex flex-column flex-3 align-items-end">
															<div>
																<div class="d-flex">
																	<span class="mr-5">{{loanDetails.co_borrower_name}} </span>
																	<span></span>
																</div>
																<div class="d-flex">
																	<span class="mr-5">Co-Borrower Signature</span>
																	<span></span>
																</div>
																<div class="d-flex">
																	<span class="mr-5">Type of ID : </span>
																	<span>{{loanDetails.co_borrower_id_type}}</span>
																</div>
																<div class="d-flex">
																	<span class="mr-5">ID Number : </span>
																	<span>{{loanDetails.co_borrower_id_number}}</span>
																</div>
																<div class="d-flex">
																	<span class="mr-5">Date Issue : </span>
																	<span>{{dateToYMD(new Date(loanDetails.co_borrower_id_date_issued)).split('-').join('/')}}</span>
																</div>
																</div>

														</div>
														<div class="flex-1"></div>
													</div>
												</section>
												<span class="bbt-8 py-7 text-center text-block text-20 text-bold mb-16">COMAKER STATEMENT</span>
												<section class="font-md mb-24" style="font-size:15px!important;line-height:1.3em!important">
													<p class="mb-24">
														I agree to become a co-maker to this Promissory Note, I aware of the joint and severally (solidarilly) accountability in this note that in case the principal borrower missed their due amortization, I will assume all the obligation including all other penalties until full payment as stated in the condition of this note.
													</p>
													<div class="d-flex flex-row align-items-center">
														<div class="flex-1"></div>
														<div class="d-flex flex-column flex-2 font-md">
															<div class="d-flex">
																<span class="mr-5">{{loanDetails.co_maker_name}} </span>
																<span></span>
															</div>
															<div class="d-flex">
																<span class="mr-5">Co-Maker Signature</span>
																<span></span>
															</div>
															<div class="d-flex">
																<span class="mr-5">Address : </span>
																<span>{{loanDetails.co_maker_address}}</span>
															</div>
														</div>
														<div class="d-flex flex-row flex-2 font-md justify-content-end">
															<div class="d-flex flex-column">
																<div class="d-flex flex-row flex-1 justify-content-between pr-24">
																	<span class="">Type of ID : {{loanDetails.co_maker_id_type}}</span>
																</div>
																<div class="d-flex flex-row flex-1 justify-content-between pr-24">
																	<span class="">ID Number  : {{loanDetails.co_maker_id_number}}</span>
																</div>
																<div class="d-flex flex-row flex-1 justify-content-between pr-24">
																	<span class="">Date Issue : {{loanDetails.co_maker_id_date_issued}}</span>
																</div>
															</div>
														</div>
														<div class="flex-1"></div>
													</div>
												</section>
												<span class="bbt-8 py-7 text-center text-block text-20 text-bold mb-16">ACKNOWLEDGEMENT</span>
												<section class="font-md" style="font-size:15px!important;line-height:1.3em!important">
													<div class= "mb-24">
														<span class="text-block">Republic of the Philippines</span>
														<span>Butuan City</span>
													</div>
													<p>
														SUBSCRIBE AND SWORN before me this _______, day of __________ and tax identetification number written above,
														Known to me and to me known to be the same person who executed the foregoing Promissory Note and they Acknowledged to me that the same is their own free and voluntary act and as well as the free and voluntary act and deed of the entitles herein represented with full power so to do and for the uses and purposes thereon set forth.
													</p>
													<p>
														IN WITNESS WHEREOF, I have set my hand and affixed my Notarial Seal on date place above written.
													</p>
													<p class="text-block text-right">
														NOTARY PUBLIC
													</p>
													<div class="d-flex flex-column mb-24">
														<span>Doc. No.___________</span>
														<span>Page No.___________</span>
														<span>Book No.___________</span>
														<span>Series of___________</span>
													</div>
												</section>
											</div>
											<div>
												<div class="d-flex mb-24">
													<!-- <img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt=""> -->
												</div>
												<div class="mb-72"></div>
												<div class="d-flex flex-row-reverse mb-45 no-print">
													<a @click.prevent="printContent('promissory-note')" href="#" class="btn btn-default min-w-150">Print</a>
													<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
												</div>
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
					<img :src="this.baseURL()+'/img/company_header.png'" style="width:100%" class="mb-24" alt="Company Header">
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
											<span> {{borrower.lastname + ', ' + borrower.firstname + ' ' + borrower.middlename.charAt(0).toUpperCase() + './ ' + loanDetails.co_borrower_name}}</span>
										</div>
									</div>
									<div class="d-flex flex-row">
										<span class="flex-1 mw-150">Voucher No.</span>
										<div class="d-flex flex-1">
											<span class="mr-5">: </span>
											<span>{{loanDetails.account_num}}</span>
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
								<!-- <div class="flex-1"></div> -->
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
											<span> Loan Granted P {{formatToCurrency(loanDetails.loan_amount)}} for {{loanDetails.terms / 30}} Month(s) / {{loanDetails.payment_mode}} Payment. With interest of {{loanDetails.interest_rate}}% per month</span>
										</div>
									</div>
									<div class="d-flex flex-row">
										<span class="flex-1 mw-150">Net Amount</span>
										<div class="d-flex flex-2">
											<span class="mr-5">: </span>
											<span> P {{formatToCurrency(loanDetails.net_proceeds)}}</span>
										</div>
									</div>
								</div>
							</div>
							<p class="mb-45">
								MICRO ACCESS LOANS CORPORATION - BUTUAN BRANCH (001) The sum of <span class="allcaps">{{numToWords(parseFloat(loanDetails.net_proceeds))}}</span> Pesos only.
							</p>
							<div class="d-flex flex-row">
								<!-- <span class="flex-1">Received By: _________________________________</span> -->
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
											<span> {{loanDetails.no_of_installment}} {{loanDetails.payment_mode}}</span>
										</div>
									</div>
									<div class="d-flex flex-row">
										<span class="flex-1 mw-150">Amortization</span>
										<div class="d-flex flex-2">
											<span class="mr-5">: </span>
											<span> P {{loanDetails.type == "Prepaid"? formatToCurrency(Math.ceil(loanDetails.loan_amount/loanDetails.no_of_installment)) : formatToCurrency(loanDetails.amortization.total)}}</span>
										</div>
									</div>
								</div>
							</div>

							<table class="table dark-border th-nb th-bb-dark mb-24 table-thin">
								<thead>
									<th >Acct</th>
									<th >Title</th>
									<th >S/L</th>
									<th >Debit</th>
									<th >Credit</th>
								</thead>
								<tbody>
									<tr v-for="(voucher, i) in vouchers" v-if="voucher.debit != 0 || voucher.credit != 0" :key="i">
										<td>{{voucher.acct}}</td>
										<td>{{voucher.title}}</td>
										<td>{{voucher.sl}}</td>
										<td>{{formatToCurrency(voucher.debit)}}</td>
										<td>{{formatToCurrency(voucher.credit)}}</td>
									</tr>
									<!-- <tr>
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
									</tr>-->
									<tr>
										<td>TOTAL</td>
										<td></td>
										<td></td>
										<td>{{formatToCurrency(totalDebit)}}</td>
										<td>{{formatToCurrency(totalCredit)}}</td>
									</tr>
								</tbody>
							</table>

							<p class="mb-72">
								<!-- I/We acknowledge and understand the statement above prior to the signing and consummation of the credit transaction and that I/We fully agree to the to the terms and conditions stated on promissory note. -->
								I/We received the amount stated above from Micro Access Loans Corporation and acknowledge, understand the statement above prior to the signing and consummation of the credit transaction and that I/We fully agreed to the terms and conditions stated on promissory note.
							</p>
							<p class="mb-72">Received By:</p>
							<div class="d-flex flex-row px-45">
								<div class="d-flex flex-column flex-1">
									<span class="text-center text-lg text-bold">{{borrower.firstname + ' ' + borrower.middlename.charAt(0).toUpperCase() + '. ' + borrower.lastname}}</span>
									<span class="text-center bt-dark-2 py-12 mb-45">Borrow Sign / Printed Name</span>
									<span class="text-center bt-dark-2 py-12 mb-45">Date Disbursed / Acknowledged</span>
								</div>
								<div class="flex-1"></div>
								<div class="d-flex flex-column flex-1">
									<span class="text-center text-lg text-bold">{{loanDetails.co_borrower_name}}</span>
									<span class="text-center bt-dark-2 py-12 mb-45">Co-Borrow Sign / Printed Name</span>
									<span class="text-center bt-dark-2 py-12 mb-45">MAC Representative Signature</span>
								</div>
							</div>

						</section>

						<div class="mb-72"></div>
						<div class="d-flex flex-row-reverse mb-45 no-print">
							<a @click="printContent('voucherPrintContent')" href="#" class="btn btn-default min-w-150">Print</a>
							<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
							<a href="#" id="cancelVoucherModal" data-dismiss="modal" class="btn btn-danger min-w-150 mr-24 hide">Cancel</a>
						</div>
						<div class="d-flex mb-24">
						<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="Company Footer">
					</div>
					</div>
				</div>
			</div>
			</div>
		</div>

		<div class="modal" id="promisoryNoteModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg minw-70" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<img :src="this.baseURL()+'/img/company_header.png'" style="width:100%" class="mb-45" alt="Company Header">
						<div class="d-flex flex-column" style="padding:0 50px;">
							<div class="d-flex flex-row align-items-center mb-36">
								<div class="flex-1">
									<span class="text-primary-dark font-26">Butuan Branch (001)</span>
								</div>
								<div class="d-flex flex-column">
									<span class="font-26 text-bold text-primary-dark lh-1">PROMISSORY NOTE</span>
									<span class="text-center text-primary-dark font-20">001-003-002371</span>
								</div>
								<div class="flex-1 d-flex justify-content-end pr-10">
									<span class=" mr-10">Tuesday 12/21/2021</span>
									<span class="">Time: 11:36 AM</span>
								</div>
							</div>
							<section>
								<p class="text-20">
									I/We Lagahit, Virginia C. borrowed and received the amount of Five Thousand Pesos (P 5,000.00) and promise to pay jointly and severally (solidarily) to the MICRO ACCESS LOANS CORPORATION until full payment of the said amount including interest rate of ( 3.00% ) per month. And with the following terms and conditions stated below:
								</p>
							</section>
							<span class="bbt-8 py-7 text-center text-20 text-bold mb-16">TERMS AND CONDITIONS</span>
							<section class="mb-24">
								<div class="d-flex flex-row">
									<div class="d-flex flex-column flex-1 font-md">
										<div class="d-flex flex-row">
											<div class="d-flex flex-row flex-1 justify-content-between pr-24">
												<span class="">Interest Rate</span>
												<span>:</span>
											</div>
											<span class="flex-2">3.00%</span>
										</div>

										<div class="d-flex flex-row">
											<div class="d-flex flex-row flex-1 justify-content-between pr-24">
												<span class="">Term (No. of days)</span>
												<span>:</span>
											</div>
											<span class="flex-2">150 day(s)</span>
										</div>

										<div class="d-flex flex-row">
											<div class="d-flex flex-row flex-1 justify-content-between pr-24">
												<span class="">Mode of Payment</span>
												<span>:</span>
											</div>
											<span class="flex-2">Monthly</span>
										</div>
									</div>
									<div class="d-flex flex-column flex-1 font-md">
										<div class="d-flex flex-row">
											<div class="d-flex flex-row flex-1 justify-content-between pr-24">
												<span class="">Due Date</span>
												<span>:</span>
											</div>
											<span class="flex-2 darker-bb"></span>
										</div>

										<div class="d-flex flex-row">
											<div class="d-flex flex-row flex-1 justify-content-between pr-24">
												<span class="">Product</span>
												<span>:</span>
											</div>
											<span class="flex-2">Pension Loan</span>
										</div>
									</div>
								</div>
							</section>
							<span class="bbt-8 py-7 text-center text-20 text-bold mb-16">OTHER CONDITIONS</span>
							<section class="font-md mb-45">
								<p style="line-height:1.8" class="mb-64">
									In case of default, this note will be due and demandable without further demand, and an additional fee of (2%) per missed payment of the scheduled amortization as penalty, And in case this note be given to hands of an attorney an additional charged of (10%) of the total amount due will be charged as attorney's fee, further, the borrower is liable to litigation expenses, damages, etc. should the failure on the part of the borrower reach the courts. In cases that the borrower/s changes address/ transfer of residence without notice to MICRO ACCESS LOANS CORPORATION in writing, the address indicated in this note shall be the address for purposes of delivery of notices and other matters pertaining to the loan. Shall any issue/case that may arise as a result of this promissory note on any document in relation hereto, venue shall be at the civil courts of Butuan City, Agusan del Norte, to the exclusion of other court or at the option of MICRO ACCESS LOANS CORPORATION The Borrower/s hereby authorized the MICRO ACCESS LOANS CORPORATION to assign, sell or otherwise negotiate this note with any financial institution on its face value. Done this _____________ day of _________________________.
								</p>

								<div class="d-flex flex-row">
									<div class="flex-1"></div>
									<div class="d-flex flex-column flex-3">
										<div class="d-flex">
											<span class="mr-5">Lagahit, Virginia C. </span>
											<span></span>
										</div>
										<div class="d-flex">
											<span class="mr-5">Borrower Signature</span>
											<span></span>
										</div>
										<div class="d-flex">
											<span class="mr-5">Type of ID : </span>
											<span>SENIOR ID</span>
										</div>
										<div class="d-flex">
											<span class="mr-5">ID Number : </span>
											<span>7124-A</span>
										</div>
										<div class="d-flex">
											<span class="mr-5">Date Issue : </span>
											<span>01/01/00</span>
										</div>
									</div>
									<div class="d-flex flex-column flex-3 align-items-end">
										<div>
											<div class="d-flex">
												<span class="mr-5">Lagahit, Virginia C. </span>
												<span></span>
											</div>
											<div class="d-flex">
												<span class="mr-5">Borrower Signature</span>
												<span></span>
											</div>
											<div class="d-flex">
												<span class="mr-5">Type of ID : </span>
												<span>SENIOR ID</span>
											</div>
											<div class="d-flex">
												<span class="mr-5">ID Number : </span>
												<span>7124-A</span>
											</div>
											<div class="d-flex">
												<span class="mr-5">Date Issue : </span>
												<span>01/01/00</span>
											</div>
										</div>

									</div>
									<div class="flex-1"></div>
								</div>
							</section>
							<span class="bbt-8 py-7 text-center text-20 text-bold mb-16">COMAKER STATEMENT</span>
							<section class="font-md mb-24">
								<p class="mb-45">
									I agree to become a co-maker to this Promissory Note, I aware of the joint and severally (solidarilly) accountability in this note that in case the principal borrower missed their due amortization, I will assume all the obligation including all other penalties until full payment as stated in the condition of this note.
								</p>
								<div class="d-flex flex-row align-items-center">
									<div class="flex-1"></div>
									<div class="d-flex flex-column flex-2 font-md">
										<div class="d-flex flex-row flex-1 justify-content-between pr-24">
											<span class="">Co-Borrower Signature</span>
										</div>
									</div>
									<div class="d-flex flex-row flex-2 font-md justify-content-end">
										<div class="d-flex flex-column">
											<div class="d-flex flex-row flex-1 justify-content-between pr-24">
												<span class="">Type of ID :</span>
											</div>
											<div class="d-flex flex-row flex-1 justify-content-between pr-24">
												<span class="">ID Number :</span>
											</div>
											<div class="d-flex flex-row flex-1 justify-content-between pr-24">
												<span class="">Date Issue :</span>
											</div>
										</div>
									</div>
									<div class="flex-1"></div>
								</div>
							</section>
							<span class="bbt-8 py-7 text-center text-20 text-bold mb-16">ACKNOWLEDGEMENT</span>
							<section class="font-md">
								<div class="mb-24">
									<span class="text-block">Republic of the Philippines</span>
									<span>Butuan City</span>
								</div>
								<p>
									SUBSCRIBE AND SWORN before me this___ day of ___________, 20___, and tax identetification number written above,
									Known to me and to me known to be the same person who executed the foregoing Promissory Note and they Acknowledged to me that the same is their own free and voluntary act and as well as the free and voluntary act and deed of the entitles herein represented with full power so to do and for the uses and purposes thereon set forth.
								</p>
								<p>
									IN WITNESS WHEREOF, I have set my hand and affixed my Notarial Seal on date place above written.
								</p>
								<p class="text-block text-right">
									NOTARY PUBLIC
								</p>
								<div class="d-flex flex-column">
									<span>Doc. No.___________</span>
									<span>Page No.___________</span>
									<span>Book No.___________</span>
									<span>Series of___________</span>
								</div>
							</section>

							<div class="mb-72"></div>
							<div class="d-flex flex-row-reverse mb-45">
								<a href="#" class="btn btn-default min-w-150">Print</a>
								<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
							</div>
							<div class="d-flex mb-24">
								<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="Company Footer">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="modal" id="schedulesModals" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg minw-70" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<img :src="this.baseURL()+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
						<div class="d-flex flex-column" style="padding:0 50px;">
							<span class="text-center text-block dark-bb pb-10 text-bold font-lg mb-16">AMORTIZATION SCHEDULES</span>

							<div class="d-flex flex-row mb-24">
								<div class="d-flex flex-column flex-2">
									<div class="d-flex mb-7">
										<span class="mr-5 text-primary-dark text-bold">Name: </span>
										<span class="text-primary-dark text-bold">Lagahit, Virginia C.</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Address: </span>
										<span>P-10 Brgy. San Mateo, Butuan City</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Date Release: </span>
										<span>08/09/2021</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Amount Granted: </span>
										<span>28,000.00</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Term: </span>
										<span>360 Days / 12 Month(s)</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Amort: </span>
										<span>3,033.00</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Group: </span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Co-Borrower: </span>
										<span>Cionevive C. Lagahit</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Co-Address: </span>
										<span>P-10 Brgy. San Mateo, Butuan City</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Co-Maker: </span>
										<span>Cionevive C. Lagahit</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Co-Address: </span>
										<span>P-10 Brgy. San Mateo, Butuan City</span>
									</div>
								</div>
								<div class="flex-1"></div>
								<div class="d-flex flex-column flex-2">
									<div class="d-flex mb-7">
										<span class="mr-5 text-primary-dark text-bold">Acc. #: </span>
										<span class="text-primary-dark text-bold">001-003-1458752</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">A/O: </span>
										<span class="">{{loanDetails.account_officer.name}}</span>
									</div>
									<div class=" d-flex mb-7">
										<span class="mr-5">Due Date: </span>
										<span class="">08/08/22</span>
									</div>
									<div class=" d-flex mb-7">
										<span class="mr-5">Loan Type: </span>
										<span class="">Add-on</span>
									</div>
									<div class=" d-flex mb-7">
										<span class="mr-5">Interest: </span>
										<span class="">8,400.00</span>
									</div>
									<div class=" d-flex mb-7">
										<span class="mr-5">Int. Rate: </span>
										<span class="">30% p.a. / 2.50% p.m.</span>
									</div>
									<div class=" d-flex mb-7">
										<span class="mr-5">Mode: </span>
										<span class="">Monthly</span>
									</div>
									<div class=" d-flex mb-7">
										<span class="mr-5">Center: </span>
										<span class="">Various Pension</span>
									</div>
									<div class=" d-flex mb-7">
										<span class="mr-5">ID #: </span>
										<span class="">08-052415427-4</span>
									</div>
								</div>
							</div>
							<section class=" mb-24 d-flex flex-column">
								<span class="text-bold bg-gray" style="padding:0 5px;">Schedules</span>
								<div class="mb-10">
									<table class="table th-nbt">
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
											<tr>
												<td>1</td>
												<td>12/12/2021</td>
												<td>2,300.00</td>
												<td>700.00</td>
												<td>3,033.00</td>
												<td>25,667.00</td>
												<td>7,700.00</td>
											</tr>
											<tr>
												<td>2</td>
												<td>12/12/2021</td>
												<td>2,300.00</td>
												<td>700.00</td>
												<td>3,033.00</td>
												<td>25,667.00</td>
												<td>7,700.00</td>
											</tr>
											<tr>
												<td>3</td>
												<td>12/12/2021</td>
												<td>2,300.00</td>
												<td>700.00</td>
												<td>3,033.00</td>
												<td>25,667.00</td>
												<td>7,700.00</td>
											</tr>
											<tr>
												<td>4</td>
												<td>12/12/2021</td>
												<td>2,300.00</td>
												<td>700.00</td>
												<td>3,033.00</td>
												<td>25,667.00</td>
												<td>7,700.00</td>
											</tr>
											<tr>
												<td>5</td>
												<td>12/12/2021</td>
												<td>2,300.00</td>
												<td>700.00</td>
												<td>3,033.00</td>
												<td>25,667.00</td>
												<td>7,700.00</td>
											</tr>
											<tr>
												<td>6</td>
												<td>12/12/2021</td>
												<td>2,300.00</td>
												<td>700.00</td>
												<td>3,033.00</td>
												<td>25,667.00</td>
												<td>7,700.00</td>
											</tr>
											<tr>
												<td>7</td>
												<td>12/12/2021</td>
												<td>2,300.00</td>
												<td>700.00</td>
												<td>3,033.00</td>
												<td>25,667.00</td>
												<td>7,700.00</td>
											</tr>
											<tr>
												<td>8</td>
												<td>12/12/2021</td>
												<td>2,300.00</td>
												<td>700.00</td>
												<td>3,033.00</td>
												<td>25,667.00</td>
												<td>7,700.00</td>
											</tr>
										</tbody>
									</table>

								</div>
								<div class="mb-45"></div>
								<div class="mb-45"></div>
								<p class="text-block text-center" style="line-height:0!important;">This statement is a system generated copy!</p>
								<p class="text-block text-center">&lt; End of file &gt;</p>
							</section>
							<div class="d-flex flex-row-reverse mb-45">
								<a href="#" class="btn btn-default min-w-150">Print</a>
								<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
							</div>
							<div class="d-flex mb-24">
								<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="Company Footer">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal" id="soaModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg minw-70" role="document">
				<div class="modal-content">
					<div class="modal-body" id="soaPrintContent">
						<!-- <img :src="this.baseURL()+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header"> -->
						<div class="d-flex flex-column" style="padding:0 50px;">
						<!-- <span class="text-center text-block dark-bb pb-10 text-bold font-lg mb-16">STATEMENT OF ACCOUNT</span> -->
							<div class="d-flex flex-row align-items-center mb-36">
								<div class="flex-1">
									<!-- <span class="text-primary-dark font-25">{{branch.branch_name}} Branch ({{branch.branch_code}})</span> -->
								</div>
								<div class="d-flex flex-column">
									<span style="display: block; text-align: center;" class="font-26 text-bold text-primary-dark lh-1">MICRO ACCESS LOAN CORPORATION</span>
									<span class="text-center text-primary-dark text-bold font-md mb-5">STATEMENT OF ACCOUNT</span>
								</div>
								<div class="flex-1 d-flex justify-content-end pr-10">
									<span class=" mr-10">{{dateFullDay(new Date())}} {{dateToYMD(new Date()).split('-').join('/')}}</span>
									<!-- <span class="">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span> -->
								</div>
							</div>
							<div class="d-flex flex-row mb-24">

								<div class="d-flex flex-column flex-2">
									<div class="d-flex mb-7">
										<span class="mr-5 text-primary-dark text-bold">Name: </span>
										<span class="text-primary-dark text-bold">{{borrower.lastname + ', ' + borrower.firstname}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Address: </span>
										<span class="nowrap">{{borrower.address}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Date Release: </span>
										<span>{{dateToMDY(new Date(loanDetails.date_release))}}</span>
									</div>
										<div class="d-flex mb-7">
										<span class="mr-5">Due Date: </span>
										<span class="">{{dateToMDY(new Date(loanDetails.due_date))}}</span>
									</div>
									
									<div class="d-flex mb-7">
										<span class="mr-5">Amount Granted: </span>
										<span>{{formatToCurrency(loanDetails.loan_amount)}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Interest: </span>
										<span class="">{{formatToCurrency(loanDetails.interest_amount)}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Term: </span>
										<span>{{loanDetails.terms + ' Days'}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Amort: </span>
										<span>{{loanDetails.type == "Prepaid"? formatToCurrency(Math.ceil(loanDetails.loan_amount/loanDetails.no_of_installment)) : formatToCurrency(loanDetails.amortization.total)}}</span>
									</div>
									<!-- <div class="d-flex mb-7">
										<span class="mr-5">&nbsp;</span>
										<span>&nbsp;</span>
									</div> -->
									<div class="d-flex mb-7">
										<span class="mr-5">Co-Borrower: </span>
										<span>{{loanDetails.co_borrower_name}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5 nowrap">Co-Address: </span>
										<span class="nowrap">{{loanDetails.co_borrower_address}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Co-Maker: </span>
										<span>{{loanDetails.co_maker_name}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5 nowrap">Co-Address: </span>
										<span class="nowrap">{{loanDetails.co_maker_address}}</span>
									</div>
								</div>
								<div class="flex-1"></div>
								<div class="d-flex flex-column flex-2">
									<div class="d-flex mb-7">
										<span class="mr-5 text-primary-dark text-bold">Branch: </span>
										<span class="text-primary-dark text-bold">{{branch.branch_name}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5 text-primary-dark text-bold">Acc. #: </span>
										<span class="text-primary-dark text-bold">{{loanDetails.account_num}}</span>
									</div>

									<div class="d-flex mb-7">
										<span class="mr-5">Product: </span>
										<span class="">{{loanDetails.product.product_name}}</span>
										<span></span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">A/O: </span>
										<span class="">{{loanDetails.account_officer.name}}</span>
										<span></span>
									</div>
									
								
									
									<div class="d-flex mb-7">
										<span class="mr-5">Loan Type: </span>
										<span class="">{{loanDetails.type}}</span>
									</div>
									<!-- <div class="d-flex mb-7">
										<span class="mr-5">Interest: </span>
										<span class="">{{formatToCurrency(loanDetails.interest_amount)}}</span>
									</div> -->
									<!-- <div class="d-flex mb-7">
										<span class="mr-5">Int. Rate: </span>
										<span class="">{{loanDetails.interest_rate + '%'}}</span>
									</div> -->
									<div class="d-flex mb-7">
										<span class="mr-5">Payment Mode: </span>
										<span class="">{{loanDetails.payment_mode}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">Center: </span>
										<span class="">{{loanDetails.center? loanDetails.center.center:'None'}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5">&nbsp;</span>
										<span>&nbsp;</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5 nowrap">Co-Borrower ID #: </span>
										<span class="nowrap">{{loanDetails.co_borrower_id_number}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5 nowrap">Co-Borrower ID Type: </span>
										<span class="nowrap">{{loanDetails.co_borrower_id_type}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5 nowrap">Co-Maker ID #: </span>
										<span class="nowrap">{{loanDetails.co_maker_id_number}}</span>
									</div>
									<div class="d-flex mb-7">
										<span class="mr-5" nowrap> Co-Maker ID ID Type: </span>
										<span class="nowrap"> {{loanDetails.co_maker_id_type}}</span>
									</div>
								</div>
							</div>
							<section class="mb-24 d-flex flex-column">
									<span class="bbt-8 py-7  text-center text-10 text-bold mb-10">SUMMARY OF PAYMENTS</span>
								<table class="table table-stripped mb-64 payments-table">
									<thead>
										<th>Date</th>
										<th>O.R #</th>
										<!-- <th>Reference</th> -->
										<th>Principal</th>
										<th>Interest</th>
										<th>PDI</th>
										<th>Penalty</th>
										<th>Rebates</th>
										<th>Over Payment</th>
										<th>Total Payment</th>
										<th>Cheque No.</th>
										<th>Bank Name</th>

									</thead>
									<tbody>
										<tr v-for="(py,x) in loanDetails.payments" :key="x">
											<td>{{dateToYMD(new Date(py.transaction_date)).split('-').join('/')}}</td>
											<td>{{py.or_no}}</td>
											<!-- <td>{{py.reference_no}}</td> -->
											<td>{{formatToCurrency(py.principal)}}</td>
											<td>{{formatToCurrency(py.interest)}}</td>
											<td>{{formatToCurrency(py.pdi)}}</td>
											<td>{{formatToCurrency(py.penalty)}}</td>
											<td>{{formatToCurrency(py.rebates)}}</td>
											<td>{{formatToCurrency(py.over_payment)}}</td>
											<td>{{formatToCurrency(py.amount_applied)}}</td>
											<td>{{ py.cheque_no }}</td>
											 <td>{{ py.bank_name === 'BDO' ? 'Cash in Bank - BDO' : py.bank_name }}</td>

										</tr>
										<tr v-if="loanDetails.payments.length < 1">
											<td>No payment records found.</td>
										</tr>
									</tbody>
								</table>



								<div class="account-balance-summary print-page-break">
									<span class="text-primary-dark text-lg text-bold mb-15">ACCOUNT BALANCE SUMMARY</span>
									<div class="d-flex flex-row mb-45">
										<div class="light-border p-10" style="flex:4">
											<table class="table th-nbt td-nb table-thin">
												<thead>
													<th class="col-md-3"></th>
													<th class="col-md-3">Debit</th>
													<th class="col-md-3">Credit</th>
													<th class="col-md-3">Balance</th>
												</thead>
												<tbody>
													<tr>
														<td>Principal</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.principal.debit)}}</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.principal.credit)}}</td>
														<td class="text-bold">{{formatToCurrency(loanDetails.remaining_balance.principal.balance)}}</td>
													</tr>
													<tr>
														<td>Interest</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.interest.debit)}}</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.interest.credit)}}</td>
														<td class="text-bold">{{formatToCurrency(loanDetails.remaining_balance.interest.balance)}}</td>
													</tr>
													<tr>
														<td>Int. Rebates</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.rebates.debit)}}</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.rebates.credit)}}</td>
														<td class="text-bold">{{formatToCurrency(loanDetails.remaining_balance.rebates.balance)}}</td>
													</tr>
													<tr>
														<td style="border-bottom: 2px solid #aaa!important;"></td>
														<td style="border-bottom: 2px solid #aaa!important;"></td>
														<td style="border-bottom: 2px solid #aaa!important;"></td>
														<td style="border-bottom: 2px solid #aaa!important;"></td>
													</tr>
													<tr class="text-bold">
														<td >Total Balance</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.principal.debit + loanDetails.remaining_balance.interest.debit + loanDetails.remaining_balance.rebates.debit)}}</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.principal.credit + loanDetails.remaining_balance.interest.credit + loanDetails.remaining_balance.rebates.credit)}}</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.principal.balance + loanDetails.remaining_balance.interest.balance + loanDetails.remaining_balance.rebates.balance)}}</td>
													</tr>
													<tr>
														<td class="text-bold" style="padding-top:24px;padding-bottom:5px;">CURRENT CHARGES</td>
														<td class="text-bold" style="padding-top:24px;padding-bottom:5px;">Charge</td>
														<td class="text-bold" style="padding-top:24px;padding-bottom:5px;">Waived</td>
														<td></td>
													</tr>
													<tr>
														<td>Penalty</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.penalty.debit)}}</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.penalty.credit)}}</td>
														<td class="text-bold">{{formatToCurrency(loanDetails.remaining_balance.penalty.balance)}}</td>
													</tr>
													<tr>
														<td>PD Int.</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.pdi.debit)}}</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.pdi.credit)}}</td>
														<td class="text-bold">{{formatToCurrency(loanDetails.remaining_balance.pdi.balance)}}</td>
													</tr>
													<tr>
														<td style="border-bottom: 2px solid #aaa!important;"></td>
														<td style="border-bottom: 2px solid #aaa!important;"></td>
														<td style="border-bottom: 2px solid #aaa!important;"></td>
														<td style="border-bottom: 2px solid #aaa!important;"></td>
													</tr>
													<tr class="text-bold">
														<td >Current Balance</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.penalty.debit + loanDetails.remaining_balance.pdi.debit)}}</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.penalty.credit + loanDetails.remaining_balance.pdi.credit)}}</td>
														<td>{{formatToCurrency(loanDetails.remaining_balance.penalty.balance + loanDetails.remaining_balance.pdi.balance)}}</td>
													</tr>
													<tr class="text-bold">
														<td >TOTAL OVERALL BALANCE</td>
														<td ></td>
														<td ></td>
														<td>{{formatToCurrency((loanDetails.remaining_balance.principal.balance + loanDetails.remaining_balance.interest.balance + loanDetails.remaining_balance.rebates.balance)+loanDetails.remaining_balance.penalty.balance + loanDetails.remaining_balance.pdi.balance)}}</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div style="flex:1"></div>
									</div>
									<p class="text-block text-center" style="line-height:0!important;">This statement is a system generated copy!</p>
									<p class="text-block text-center">&lt; End of file &gt;</p>
								</div>
							</section>
							<div class="d-flex flex-row-reverse mb-45">
								<a @click.prevent="printContent('soaPrintContent')" href="#" class="btn btn-default min-w-150">Print</a>
								<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
							</div>
							<!-- <div class="d-flex mb-24">
								<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="Company Footer">
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="modal" id="schedulesModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg minw-70" role="document">
			  <div class="modal-content">
				<div class="modal-body" id="amortPrintContent">
				  	<img :src="this.baseURL()+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
					<div class="d-flex flex-column" style="padding:0 50px;">
						<span class="text-center text-block dark-bb pb-10 text-bold font-lg mb-16">AMORTIZATION SCHEDULE</span>

						<div class="d-flex flex-row mb-24">
							<div class="d-flex flex-column flex-2">
								<div class="d-flex mb-7">
									<span class="mr-5 text-primary-dark text-bold">Name: </span>
									<span class="text-primary-dark text-bold">{{borrower.lastname + ', ' + borrower.firstname}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">Address: </span>
									<span>{{borrower.address}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">Date Release: </span>
									<span>{{dateToMDY(new Date(loanDetails.date_release))}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">Amount Granted: </span>
									<span>{{formatToCurrency(loanDetails.loan_amount)}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">Term: </span>
									<span>{{loanDetails.terms + ' Days'}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">Amort: </span>
									<span>{{loanDetails.type == "Prepaid"? formatToCurrency(Math.ceil(loanDetails.loan_amount/loanDetails.no_of_installment)) : formatToCurrency(loanDetails.amortization.total)}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">&nbsp;</span>
									<span>&nbsp;</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">Co-Borrower: </span>
									<span>{{loanDetails.co_borrower_name}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">Co-Address: </span>
									<span>{{loanDetails.co_borrower_address}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">Co-Maker: </span>
									<span>{{loanDetails.co_maker_name}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">Co-Address: </span>
									<span>{{loanDetails.co_maker_address}}</span>
								</div>
							</div>
							<div class="flex-1"></div>
							<div class="d-flex flex-column flex-2">
								<div class="d-flex mb-7">
									<span class="mr-5 text-primary-dark text-bold">Acc. #: </span>
									<span class="text-primary-dark text-bold">{{loanDetails.account_num}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">A/O: </span>
									<span class="">{{loanDetails.account_officer.name}}</span>
									<span></span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">Due Date: </span>
									<span class="">{{dateToMDY(new Date(loanDetails.due_date))}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">Loan Type: </span>
									<span class="">{{loanDetails.type}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">Interest: </span>
									<span class="">{{formatToCurrency(loanDetails.interest_amount)}}</span>
								</div>
								<!-- <div class="d-flex mb-7">
									<span class="mr-5">Int. Rate: </span>
									<span class="">{{loanDetails.interest_rate + '%'}}</span>
								</div> -->
								<div class="d-flex mb-7">
									<span class="mr-5">Mode: </span>
									<span class="">{{loanDetails.payment_mode}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">Center: </span>
									<span class="">{{loanDetails.center? loanDetails.center.center:''}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">ID #: </span>
									<span>{{loanDetails.co_borrower_id_number}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">ID Type: </span>
									<span>{{loanDetails.co_borrower_id_type}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">ID #: </span>
									<span>{{loanDetails.co_maker_id_number}}</span>
								</div>
								<div class="d-flex mb-7">
									<span class="mr-5">ID Type: </span>
									<span>{{loanDetails.co_maker_id_type}}</span>
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
							<div>
								<p class="text-block text-center" style="line-height:0!important;">This statement is a system generated copy!</p>
								<p class="text-block text-center">&lt; End of file &gt;</p>
								<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100 page-footer" alt="Company Footer">
							</div>
						</section>
						<div class="d-flex flex-row-reverse mb-45 no-print">
							<a href="#" @click.prevent="printContent('amortPrintContent')" class="btn btn-default min-w-150">Print</a>
							<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
							<a href="#" id="cancelModal" data-dismiss="modal" class="btn btn-danger min-w-150 mr-24 hide">Cancel</a>
						</div>
					</div>
				</div>
			  </div>
			</div>
		</div>

		<div class="modal" id="uploadedFilesModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg minw-70" role="document">
				<div class="modal-content" style="padding-bottom:50px;">
					<div class="modal-body font-md pxy-25">
						<div class="d-flex justify-content-between bb-dark-8">
							<span class="text-block text-bold pb-10">Uploaded Documents</span>
							<form method="post" enctype="multipart/form-data">
								<input @change="fileChange($event)" type="file" class="hide" id="fileUploadDocs">
							</form>
							<i data-dismiss="modal" class="fa fa-times"></i>
						</div>
						<div class="d-flex" style="padding-top:32px;">
							<div class="d-flex flex-column mr-24">
								<div @mouseenter="activeBrowse=true" @mouseleave="activeBrowse=false" style="position:relative;" class="mb-16">
									<div @click="browseFile()" v-if="activeBrowse" class="d-flex justify-content-center align-items-center" style="position:absolute;z-index:999;width:175px;height:100%;background-color:rgba(0,0,0,.7);border-radius:25px;cursor:pointer">
										<span style="color:#FFF">Browse Files</span>
									</div>
									<div class="d-flex flex-column">
										<img @click="browseFile()" :src="baseURL() + 'img/file_temp.png'" style="max-width:175px;cursor:pointer" alt="">
										<span class="text-center text-sm">{{concatW(fileName)}}</span>
									</div>
								</div>
								<button :disabled="fileName==''" @click="uploadFile()" id="fileUploadDocsBtn" class="btn btn-yellow">Upload File</button>
							</div>
							<div class="d-flex flex-1 bg-very-light" style="min-height:500px;padding:16px">
								<div v-if="!loanDetails.docs" class="d-flex justify-content-center align-items-center" style="width:100%">
									<span >No uploaded files yet.</span>
								</div>

								<div class="d-flex flex-wrap">
									<div v-for="(doc, dc) in loanDetails.docs" :key="dc" class="d-flex flex-column align-items-center" style="padding:16px;background-color:#f2f2f2;">
										<a :href="doc"><img :src="baseURL() + '/img/fileicon.png'" alt="" style="max-width:95px;" class="mb-5"></a>
										<b style="font-size:12px;"><i>{{extractFileName(doc)}}</i></b>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="modal" id="editAccountModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<form @submit.prevent="">
							<section class="mb-24 p-16" style="flex:21;padding-left:16px;">
								<span class="section-title mb-12">Edit Account</span>
								<div class="d-flex flex-column">
									<!-- <div class="d-flex flex-column flex-lg-row">
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Date</label>
											<div class="form-group">
												<input v-model="editAccount.transaction_date" type="date" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">OR No.</label>
											<div class="form-group">
												<input v-model="editAccount.or_no" type="text" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Trans. No.</label>
											<div class="form-group">
												<input v-model="editAccount.transaction_number" type="text" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Refrerence No.</label>
											<div class="form-group">
												<input v-model="editAccount.reference_no" type="text" class="form-control form-input">
											</div>
										</div>
									</div> -->

									<div class="d-flex flex-column flex-lg-row">
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Account No.</label>
											<div class="form-group">
												<input v-model="editAccount.account_num" type="text" class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Loan Amount</label>
											<div class="form-group">
												<input v-model="editAccount.loan_amount" type="text" disabled class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Date Granted</label>
											<div class="form-group">
												<input v-model="editAccount.date_granted" type="text" disabled class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Term</label>
											<div class="form-group">
												<input v-model="editAccount.term" type="text" disabled class="form-control form-input">
											</div>
										</div>
									</div>


									<div class="d-flex flex-column flex-lg-row">
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Collection Rate</label>
											<div class="form-group">
												<input v-model="editAccount.collection_rate" type="text" disabled class="form-control form-input">
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Payment History</label>
											<div class="form-group">
												<!-- <input v-model="editAccount.payment_history" type="text" class="form-control form-input"> -->
												<select name="" id="" class="form-control form-input" v-model="editAccount.payment_history">
													<option value="Current">Current</option>
													<option value="Delinquent">Delinquent</option>
												</select>
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1">
											<label for="transactionDate" class="form-label">Current Loan Status</label>
											<div class="form-group">
												<!-- <input v-model="editAccount.loan_status" type="text" class="form-control form-input"> -->
												<select name="" id="" class="form-control form-input" v-model="editAccount.loan_status">
													<option value="Ongoing">Ongoing</option>
													<option value="Write-Off">Write-Off</option>
													<option value="Past Due">Past Due</option>
													<option value="Restructed">Restructed</option>
													<option value="Res WO-PDI">Res WO-PDI</option>
													<option value="Case Filed">Case Filed</option>
													<option value="Litigated">Litigated</option>
                                                    <option value="Paid">Paid</option>
												</select>
											</div>
										</div>
										<div class="form-group mb-10 mr-16 flex-1 d-flex align-items-end">
											<button @click="updateAccount({'payment_status':editAccount.payment_history,'account_num':editAccount.account_num}, 'Payment Status')" data-dismiss="modal" class="btn btn-success" style="margin-bottom:1rem;width:100%;height:47px;">UPDATE</button>
										</div>
									</div>
								</div>
							</section>
						</form>
					</div>
				</div>
			</div>
		</div>

	</div>

</template>

<script>
	export default {
		props:['borrower_id','token', 'pbranch'],
		data(){
			return {
				branch:{},
				pagination:{
					page: 1,
					range: 3
				},
				editAccount:{},
                authUser:{},
                hasAccessToEdit:false,
				loading:false,
				loanAccount:{},
				activeBrowse:false,
				fileName:'',
				baseUrl: this.baseURL(),
				selected:null,
				borrower:{
					borrower_id: null,
					borrower_num:'',
					firstname:'',
					lastname:'',
					middlename:'',
					suffix :'' ,
					address :'' ,
					birthdate :'',
					gender :'' ,
					status :'' ,
					contact_number :'',
					id_type :'',
					id_no :'',
					id_date_issued :'',
					spouse_firstname:'',
					spouse_lastname:'',
					spouse_middlename:'',
					spouse_address :'',
					spouse_birthdate :'',
					spouse_id_type :'',
					spouse_id_no :'',
					spouse_id_date_issued :'',
					employmentInfo : [],
					businessInfo : [],
					householdMembers : [],
					outstandingObligations : [],
				},
				accounts:[],
				img:this.baseURL()+'/img/user.png',
				loanDetails: {
					amortization:{
						principal:0,
						interest:0,
						total:0,
					},
					loan_account_id:null,
					cycle_no : 1,
					ao_id : '',
					product_id : '',
					center_id : '',
					type : '',
					payment_mode : '',
					terms : 0,
					loan_amount : '',
					no_of_installment : '',
					day_schedule : '',
					date_release:'',
					borrower_num : '',
					co_borrower_name : '',
					co_borrower_address : '',
					co_borrower_id_type : '',
					co_borrower_id_number : '',
					co_borrower_id_date_issued : '',
					co_maker_name : '',
					co_maker_address : '',
					co_maker_id_type : '',
					co_maker_id_number : '',
					co_maker_id_date_issued : '',
					document_stamp : 0.00,
					filing_fee : 0.00,
					insurance : 0.00,
					notarial_fee : 100.00,
					prepaid_interest : 0.00,
					affidavit_fee : 0.00,
					memo : 0.00,
					total_deduction : 0.00,
					net_proceeds : 0.00,
					release_type : '',
					loanfiles:[],
					docs:false,
					remaining_balance:{
						memo:{
							debit:0,
							credit:0,
							balance:0,
						},
						rebates:{
							debit:0,
							credit:0,
							balance:0,
						},
						pdi:{
							debit:0,
							credit:0,
							balance:0,
						},
						penalty:{
							debit:0,
							credit:0,
							balance:0,
						},
						interest:{
							debit:0,
							credit:0,
							balance:0,
						},
						principal:{
							debit:0,
							credit:0,
							balance:0,
						},
					},
					documents: {
						date_release: this.dateToYMD(new Date),
						description: '',
						bank: '',
						account_no: '',
						card_no:'',
						promissory_number: '',
					},
						borrower:{
						borrower_id: null,
						borrower_num:'',
						firstname:'',
						lastname:'',
						middlename:'',
						suffix :'' ,
						address :'' ,
						birthdate :'',
						gender :'' ,
						status :'' ,
						contact_number :'',
						id_type :'',
						id_no :'',
						id_date_issued :'',
						spouse_firstname:'',
						spouse_lastname:'',
						spouse_middlename:'',
						spouse_address :'',
						spouse_birthdate :'',
						spouse_id_type :'',
						spouse_id_no :'',
						spouse_id_date_issued :'',
						employmentInfo : [],
						businessInfo : [],
						householdMembers : [],
						outstandingObligations : [],
					},
					current_amortization:{
						interest:0,
						principal:0,
						principal_balance:0,
						delinquent:{
							ids:[]
						}
					},
					product:{
						product_name:'',
					},
					payments:[],
					center:{
						center:''
					},
					account_officer:{
						name:''
					}
				},
				vouchers:[],
				amortizationSched:[],
				filter:'',
			}
		},
		methods:{
            async fetchAuthUser() {
                await axios.get(this.baseURL() + 'api/auth', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
                    this.authUser = response.data
                    this.hasAccessToEdit = this.authUser.accessibility.some(accessibility => accessibility['permission'] === 'edit statement of account');


				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
            },
			setPage:function(page){
				this.pagination.page = page;
			},
			async updateAccount(data, type){
				await axios.post(this.baseURL() + 'api/account/update/' + this.editAccount.account_id, data, {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'contentType': "multipart/form-data"
					}
				})
				.then(function (response) {
					this.notify('', type + ' has been updated successfully.', 'success');
					if(type=='Payment Status'){
						this.updateAccount({
                            'loan_status':this.editAccount.loan_status,
                            'account_num':this.editAccount.account_num
                        }, 'Loan Status')
					}
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
			notify:function(title, text, type){
				this.$notify({
					group: 'foo',
					title: title,
					text: text,
					type: type,
				});
			},
			async uploadFile(){
				await axios.post(this.baseURL() + 'api/account/update/' + this.loanDetails.loan_account_id, this.loanAccount, {
						headers: {
							'Authorization': 'Bearer ' + this.token,
							'contentType': "multipart/form-data"
						}
					})
					.then(function (response) {
						console.log(response.data);
						this.notify('','File has been successfully uploaded', 'success');
						var file = document.getElementById('fileUploadDocs');
						file.value = '';
						this.fetchAccount(this.loanDetails.loan_account_id);
					}.bind(this))
					.catch(function (error) {
						console.log(error);
					}.bind(this));
			},
			fileChange:function(e){
				if(e.target.files.length){
					this.loanDetails.loanfiles = [];
					let formData = new FormData();
					formData.append('loanfiles', e.target.files[0]);
					formData.append('data',JSON.stringify(this.loanDetails));
					this.loanAccount = formData;
					this.fileName = e.target.files[0].name;
				}
				return
			},
			amortSched:function(){
				axios.post(this.baseURL() + 'api/account/generate-amortization', this.loanDetails, {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.amortizationSched = response.data.data;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
			fetchBorrower:function(){
				this.loading = true;
				axios.get(this.baseURL() + 'api/borrower/' + this.borrower_id, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.loading = false;
					this.borrower = response.data.data;
					this.fetchStatements();
				}.bind(this))
				.catch(function (error) {
					this.loading = false;
					console.log(error);
				}.bind(this));
			},

			fetchStatements:function(){
				this.loading = true;
				axios.get(this.baseURL() + 'api/account/statement/' + this.borrower_id, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.loading = false;
					this.accounts = response.data;
				}.bind(this))
				.catch(function (error) {
					this.loading = false;
					console.log(error);
				}.bind(this));
			},

			fetchCashVoucher:function(id){
				axios.get(this.baseURL() + 'api/account/cashvoucher/' + id, {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.vouchers = response.data.data.cash_voucher;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},

			fetchAccount:function(id){
				axios.get(this.baseURL() + 'api/account/show/' + id, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					console.log(response.data.data);
					this.loanDetails = response.data.data;
					this.loanDetails.documents = response.data.data.document;
					this.amortSched();
					this.fetchCashVoucher(id);
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},

			fetchAccountId:function(id){
				axios.get(this.baseURL() + 'account/statement/' + id, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.fetchAccount(response.data.loan_account_id);
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},

			printContent:function(content){
				var content = document.getElementById(content).innerHTML;
				var target = document.querySelector('.to-print');
				var cancel = document.querySelector('#cancelVoucherModal');
				target.innerHTML = content;
				cancel.click();
				window.print();
			},

			imageCapture:function(img){
				this.img = img;
			},

			browseFile(){
				document.getElementById('fileUploadDocs').click();
			}
		},
		computed:{
			paginate:function(){
				var result = [];
				var start = (this.pagination.page - 1) * this.pagination.range;
				var end = 0;
				for(var i = start; i < this.filteredAccounts.length; i++){
					if(end < this.pagination.range){
						result.push(this.filteredAccounts[i]);
					}
					end++;
				}
				return result;
			},
			loanAccountStatus:function(){
				if(this.loanDetails.current_amortization){
					if(this.loanDetails.current_amortization.delinquent.ids.length > 0){
						return "Delinquent";
					}
				}
				return "Current";
			},
			borrowerPhoto:function(){
				return this.borrower.photo? this.borrower.photo : this.img;
			},
			totalDebit:function(){
				var amount = 0;
				this.vouchers.map(function(val){
					amount+=val.debit;
				}.bind(this));
				return amount;
			},
			totalCredit:function(){
				var amount = 0;
				this.vouchers.map(function(val){
					amount+=val.credit;
				}.bind(this));
				return amount;
			},
			totalAmountBalance:function(){
				var amount = this.loanDetails.loan_amount;
				this.loanDetails.payments.map(function(val){
					amount-=val.principal;
				}.bind(this));
				return amount;
			},
			totalInterestBalance:function(){
				var amount = this.loanDetails.interest_amount;
				this.loanDetails.payments.map(function(val){
					amount-=val.interest;
				}.bind(this));
				return amount;
			},
			totalPrincipalPaid:function(){
				var amount = 0;
				this.loanDetails.payments.map(function(val){
					amount+=val.principal;
				}.bind(this));
				return amount;
			},
			totalInterestPaid:function(){
				var amount = 0;
				this.loanDetails.payments.map(function(val){
					amount+=val.interest;
				}.bind(this));
				return amount;
			},
			filteredAccounts:function(){
				if(this.filter.length > 0){
					var accounts = [];
					this.accounts.map(function(acc){
						if(acc.account_num.includes(this.filter)){
							accounts.push(acc);
						}
					}.bind(this));
					return accounts;
				}
				return this.accounts;
			},
			canPaginate:function(){
				return this.filteredAccounts.length > this.pagination.range
			},
			delinquentAmount: function() {
				return (this.loanDetails.remaining_balance?.interest.balance || 0 + this.loanDetails.remaining_balance?.principal.balance || 0)-(this.loanDetails.current_amortization?.interest_balance || 0 + this.loanDetails.current_amortization?.principal_balance || 0 )
			},
		},
		mounted(){
            this.fetchAuthUser();
			this.branch = JSON.parse(this.pbranch);
			// console.log(this.extractFileName("http://mac-loans.test/storage/borrowers/1/12/hello.pdf"));
			this.fetchBorrower();
		}
	}
</script>

<style>
	.account-active {
		background-color: #eee;
	}
</style>
