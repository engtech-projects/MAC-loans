<template>
	<div class="px-16">
		<div class="container-fluid">
			<div class="mb-16"></div>
			<div class="d-flex justify-content-between mb-24 bb-primary-dark pb-7 text-block">
				<h1 class="m-0 font-35">Statement of Account Details</h1>
			</div><!-- /.col -->

			<form action="" class="mb-10">
		<input type="text" class="form-control" placeholder="Search">
	</form>
	<table class="table table-stripped table-hover light-border mb-24 table-row-clickable" id="accountTable">
		<thead>
			<th>Account #</th>
			<th>Loan Amount</th>
			<th>Date Granted</th>
			<th>Term</th>
			<th>Collection Rate</th>
			<th>Payment History</th>
			<th>Current Loan Status</th>
		</thead>
		<tbody>
			<tr>
				<td>100-3429-15421</td>
				<td>28,000.00</td>
				<td>8/8/2021</td>
				<td>3 Months</td>
				<td>30%</td>
				<td>Delinquent</td>
				<td>On going</td>
			</tr>
			<tr>
				<td>100-3429-15421</td>
				<td>28,000.00</td>
				<td>8/8/2021</td>
				<td>3 Months</td>
				<td>30%</td>
				<td>Delinquent</td>
				<td>On going</td>
			</tr>
			<tr>
				<td>100-3429-15421</td>
				<td>28,000.00</td>
				<td>8/8/2021</td>
				<td>3 Months</td>
				<td>30%</td>
				<td>Delinquent</td>
				<td>On going</td>
			</tr>
			<tr>
				<td>100-3429-15421</td>
				<td>28,000.00</td>
				<td>8/8/2021</td>
				<td>3 Months</td>
				<td>30%</td>
				<td>Delinquent</td>
				<td>On going</td>
			</tr>
			<tr>
				<td>100-3429-15421</td>
				<td>28,000.00</td>
				<td>8/8/2021</td>
				<td>3 Months</td>
				<td>30%</td>
				<td>Delinquent</td>
				<td>On going</td>
			</tr>
		</tbody>
	</table>
	<div class="sep mb-24"></div>
	<section class="d-flex mb-24">
		<div class="d-flex flex-1 flex-sm-row personal-info" style="margin-bottom:24px;">
			<div class="upload-photo mb-24">
				<img :src="borrowerPhoto" alt="" style="max-width:250px;">
				<a href="#" data-toggle="modal" data-target="#uploadModal" class="btn btn-primary" style="padding:10px!important">Upload or Take a Photo</a>
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
							<span>Gender</span>
							<span>{{borrower.gender}}</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>Status</span>
							<span>{{borrower.status}}</span>
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
							<span>12/12/2019</span>
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
	<section id="accountDetails" class="hide">
		<div class="info-display title mb-12">
			<span>Account Details</span>
		</div>
		<div class="flex-col accounts-list">
			<div class="card mb-12">
				<div class="card-header" style="background-color:#dfdfd0!important;">
					<h3 class="card-title" style="color: #283f53;">Account Number: 1001-3429-15248</h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
							<i class="fas fa-minus"></i>
						</button>
					</div>
				</div>
				<div class="card-body p-0" style="padding:25px 20px!important">
					<div class="flex mb-16">
						<div class="flex-col granted-amount mr-24">
							<span>Amount Granted</span>
							<span>P 28,000.00</span>
						</div>
						<div class="flex-col flex-1">
							<div class="row mb-16">
								<div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Amortization</span>
										<span>P 3,000.00</span>
									</div>
								</div>
								<div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Release Date</span>
										<span>February 3, 2022</span>
									</div>
								</div>
								<div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Term</span>
										<span>360 Days / 12 Month (s)</span>
									</div>
								</div>
								<div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Due Date</span>
										<span>03/21/2022</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Interest</span>
										<span>30% p.a / 3% p.m</span>
									</div>
								</div>
								<div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Mode</span>
										<span>Monthly</span>
									</div>
								</div>
								<div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Group</span>
										<span>Various Pension</span>
									</div>
								</div>
								<div class="col-xl-3 col-lg-6">
									<div class="info-display">
										<span class="font-blue">Type</span>
										<span>Add-on</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row mb-16">
						<div class="col-xl-3 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Product Name</span>
								<span>Pension Load</span>
							</div>
						</div>
						<div class="col-xl-2 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Cycle</span>
								<span>20th</span>
							</div>
						</div>
						<div class="col-xl-2 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Status</span>
								<span>Current</span>
							</div>
						</div>
						<div class="col-xl-2 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Center</span>
								<span>---</span>
							</div>
						</div>
						<div class="col-xl-3 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Collection Rate</span>
								<span>30%</span>
							</div>
						</div>
					</div>

					<div class="row mb-16">
						<div class="col-xl-3 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Co-Borrower</span>
								<span>Cioneveve C. Langahit</span>
							</div>
						</div>
						<div class="col-xl-5 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Co-Borrower Address</span>
								<span>P-10 Brgy. San Mateo, Butuan City</span>
							</div>
						</div>
						<div class="col-xl-4 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Co-Borrower ID</span>
								<span>05-08452-054784</span>
							</div>
						</div>
					</div>

					<div class="row mb-45">
						<div class="col-xl-3 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Co-Maker</span>
								<span>Cioneveve C. Langahit</span>
							</div>
						</div>
						<div class="col-xl-5 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Co-Maker Address</span>
								<span>P-10 Brgy. San Mateo, Butuan City</span>
							</div>
						</div>
						<div class="col-xl-4 col-lg-6">
							<div class="info-display">
								<span class="font-blue">Co-Maker ID</span>
								<span>05-08452-054784</span>
							</div>
						</div>
					</div>

					<div class="flex-col payments-list">
						<span class="header">Payments</span>
						<table class="table table-stripped mb-64">
																	<thead>
																		<th>Date</th>
																		<th>O.R #</th>
																		<th>Payment Type</th>
																		<th>Reference</th>
																		<th>Principal</th>
																		<th>Interest</th>
																		<th>PDI</th>
																		<th>Penalty</th>
																		<th>Total Payment</th>
																		<th>Remarks</th>
																	</thead>
																	<tbody>
																		<tr>
																			<td>12/12/2021</td>
																			<td>00212</td>
																			<td>Cash</td>
																			<td></td>
																			<td>250.00</td>
																			<td>100.00</td>
																			<td>0.00</td>
																			<td>0.00</td>
																			<td>350.00</td>
																			<td></td>
																		</tr>
																		<tr>
																			<td>12/12/2021</td>
																			<td>00212</td>
																			<td>Cash</td>
																			<td></td>
																			<td>250.00</td>
																			<td>100.00</td>
																			<td>0.00</td>
																			<td>0.00</td>
																			<td>350.00</td>
																			<td>CANCELLED</td>
																		</tr>
																		<tr>
																			<td>12/12/2021</td>
																			<td>00212</td>
																			<td>Cash</td>
																			<td></td>
																			<td>250.00</td>
																			<td>100.00</td>
																			<td>0.00</td>
																			<td>0.00</td>
																			<td>350.00</td>
																			<td></td>
																		</tr>
																		<tr>
																			<td>12/12/2021</td>
																			<td>00212</td>
																			<td>Cash</td>
																			<td></td>
																			<td>250.00</td>
																			<td>100.00</td>
																			<td>0.00</td>
																			<td>0.00</td>
																			<td>350.00</td>
																			<td>CANCELLED</td>
																		</tr>
																		<tr>
																			<td>12/12/2021</td>
																			<td>00212</td>
																			<td>Cash</td>
																			<td></td>
																			<td>250.00</td>
																			<td>100.00</td>
																			<td>0.00</td>
																			<td>0.00</td>
																			<td>350.00</td>
																			<td></td>
																		</tr>
																		<tr>
																			<td>12/12/2021</td>
																			<td>00212</td>
																			<td>Cash</td>
																			<td></td>
																			<td>250.00</td>
																			<td>100.00</td>
																			<td>0.00</td>
																			<td>0.00</td>
																			<td>350.00</td>
																			<td></td>
																		</tr>
																	</tbody>
																</table>
					</div>

				</div>
				<!-- /.card-body -->
			</div>

			<!-- <div class="card collapsed-card mb-12">
				<div class="card-header" style="background-color:#dfdfd0!important;">
				<h3 class="card-title" style="color: #283f53;">Account Number: 1001-3429-15248</h3>
		
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
					<i class="fas fa-plus"></i>
					</button>
				</div>
				</div>
				<div class="card-body p-0">
				

				</div>
			</div> -->
		</div>
	</section>
	<div class="mb-72"></div>
	<div class="d-flex flex-row mb-72 justify-content-between">
		<a href="#" data-toggle="modal" data-target="#uploadedFilesModal" class="btn btn-darkorange"><i class="fa fa-folder mr-10"></i> <span>Upload Document</span></a>
		<div class="d-flex flex-row justify-content-end">
			<a href="#" data-toggle="modal" data-target="#lettersModal" class="btn btn-sky-blue mr-10 min-w-150">Letters</a>
			<a href="#" data-toggle="modal" data-target="#statusReportModal" class="btn btn-bright-blue mr-10 min-w-150">Print Payment Status</a>
			<a href="#" data-toggle="modal" data-target="#cashVoucherModal" class="btn btn-purple mr-10 min-w-150">Voucher</a>
			<a href="#" data-toggle="modal" data-target="#promisoryNoteModal" class="btn btn-success mr-10 min-w-150">Promissory Note</a>
			<a href="#" data-toggle="modal" data-target="#schedulesModal" class="btn btn-yellow mr-10 min-w-150">Amortization Sched.</a>
			<a href="#" data-toggle="modal" data-target="#soaModal" class="btn btn-primary-dark min-w-150">Print SOA</a>
		</div>
	</div>
		
		</div>
		<upload-file @imageCapture="imageCapture"/>



		<div class="modal" id="lettersModal" tabindex="-1" role="dialog">
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
							<div class="flex-5">
								<img src="/img/company_header.png" style="width:100%" class="mb-16" alt="Company Header">
								<div class="d-flex flex-column font-md" style="padding:0 35px;">

									<ul class="metadata base-list font-md mb-64">
										<li>January 8, 2021</li>
										<li>Nakila, Bernabe D.</li>
										<li>Nakila, Roxanne C.</li>
										<li>Nakila, Virgilio P.</li>
										<li>P5-B Puting Bato, Brgy. Pinamanculan</li>
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
											As our valued client, building and preserving good relationship with you is what concerns us most. We want to provide quick access to loans and continuous credit line for your utmost convenience. For the continuation of your credit line and to further our relationship, we are closely monitoring your account.It has then come to our attention that your accunt is in delinquent status. The total delinquent amount has reached to Php 1,530.00. Please take note that one of our agreement stated in your Loan Promissory Note No. 001-002-0009414 dated October 30, 2020 that in case of default/delinquent, this promissory note will be due and demandable.
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
							<a href="#" class="btn btn-default min-w-150">Print</a>
							<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
						</div>
						<div class="d-flex mb-24">
							<img src="/img/logo-footer.png" class="w-100" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>





		<div class="modal" id="statusReportModal" tabindex="-1" role="dialog">
					<div class="modal-dialog modal-lg minw-70" role="document">
						<div class="modal-content">
							<div class="modal-body">
								<img src="/img/company_header.png" style="width:100%" class="mb-16" alt="Company Header">
								<div class="d-flex flex-column" style="padding:0 50px;">
									<span class="text-center text-block dark-bb pb-10 text-bold font-lg mb-16">PAYMENT STATUS REPORT</span>

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
												<span class="mr-5"">A/O: </span>
								<span class="">025 - Janine C. Escallar</span>
							</div>
							<div class=" d-flex mb-7">
													<span class="mr-5"">Due Date: </span>
								<span class="">08/08/22</span>
							</div>
							<div class=" d-flex mb-7">
														<span class="mr-5"">Loan Type: </span>
								<span class="">Add-on</span>
							</div>
							<div class=" d-flex mb-7">
															<span class="mr-5"">Interest: </span>
								<span class="">8,400.00</span>
							</div>
							<div class=" d-flex mb-7">
																<span class="mr-5"">Int. Rate: </span>
								<span class="">30% p.a. / 2.50% p.m.</span>
							</div>
							<div class=" d-flex mb-7">
																	<span class="mr-5"">Mode: </span>
								<span class="">Monthly</span>
							</div>
							<div class=" d-flex mb-7">
																		<span class="mr-5"">Center: </span>
								<span class="">Various Pension</span>
							</div>
							<div class=" d-flex mb-7">
																			<span class="mr-5"">ID #: </span>
								<span class="">08-052415427-4</span>
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
																					<a href="#" class="btn btn-default min-w-150">Print</a>
																					<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
																				</div>
																				<div class="d-flex mb-24">
																					<img src="/img/logo-footer.png" class="w-100" alt="">
																				</div>
											</div>
										</div>
									</div>
								</div>
							</div>





		<div class="modal" id="cashVoucherModal" tabindex="-1" role="dialog">
											<div class="modal-dialog modal-lg minw-70" role="document">
												<div class="modal-content">
													<div class="modal-body font-md">
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
																	<span class=" mr-10">Tuesday 12/21/2021</span>
																	<span class="">Time: 11:36 AM</span>
																</div>
															</div>
															<section class="mb-16">
																<div class="d-flex flex-row">
																	<div class="d-flex flex-column flex-2">
																		<div class="d-flex flex-row mb-10">
																			<span class="flex-1 mw-150">Pay to</span>
																			<div class="d-flex flex-1">
																				<span class="mr-5">: </span>
																				<span> Puro, Jeryll R.</span>
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
																				<span> Loan Granted P 9,000.00 for 6 month(s) / weekly payment. With interest of 4% per month</span>
																			</div>
																		</div>
																		<div class="d-flex flex-row">
																			<span class="flex-1 mw-150">Net Amount</span>
																			<div class="d-flex flex-2">
																				<span class="mr-5">: </span>
																				<span> P 8,607.00</span>
																			</div>
																		</div>
																	</div>
																</div>
																<p class="mb-45">
																	Received payment from MICRO ACCESS LOANS CORPORATION - BUTUAN BRANCH (001) The sum of Eight Thousand Six Hundred Seven Pesos only.
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
																				<span> 5 Monthly</span>
																			</div>
																		</div>
																		<div class="d-flex flex-row">
																			<span class="flex-1 mw-150">Amortization</span>
																			<div class="d-flex flex-2">
																				<span class="mr-5">: </span>
																				<span> P 1,150.00</span>
																			</div>
																		</div>
																	</div>
																</div>

																<table class="table dark-border th-nb th-bb-dark mb-24">
																	<thead>
																		<th>Acct</th>
																		<th>Title</th>
																		<th>S/L</th>
																		<th>Debit</th>
																		<th>Credit</th>
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
															<div class="d-flex flex-row-reverse mb-45">
																<a href="#" class="btn btn-default min-w-150">Print</a>
																<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
															</div>
															<div class="d-flex mb-24">
						<img src="/img/logo-footer.png" class="w-100" alt="">
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
														<img src="/img/company_header.png" style="width:100%" class="mb-45" alt="Company Header">
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
																<p class="font-md">
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
																<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
															</div>
															<div class="d-flex mb-24">
																<img src="/img/logo-footer.png" class="w-100" alt="">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>




		<div class="modal" id="schedulesModal" tabindex="-1" role="dialog">
								<div class="modal-dialog modal-lg minw-70" role="document">
									<div class="modal-content">
										<div class="modal-body">
											<img src="/img/company_header.png" style="width:100%" class="mb-16" alt="Company Header">
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
															<span class="mr-5"">A/O: </span>
								<span class="">025 - Janine C. Escallar</span>
							</div>
							<div class=" d-flex mb-7">
																<span class="mr-5"">Due Date: </span>
								<span class="">08/08/22</span>
							</div>
							<div class=" d-flex mb-7">
																	<span class="mr-5"">Loan Type: </span>
								<span class="">Add-on</span>
							</div>
							<div class=" d-flex mb-7">
																		<span class="mr-5"">Interest: </span>
								<span class="">8,400.00</span>
							</div>
							<div class=" d-flex mb-7">
																			<span class="mr-5"">Int. Rate: </span>
								<span class="">30% p.a. / 2.50% p.m.</span>
							</div>
							<div class=" d-flex mb-7">
																				<span class="mr-5"">Mode: </span>
								<span class="">Monthly</span>
							</div>
							<div class=" d-flex mb-7">
																					<span class="mr-5"">Center: </span>
								<span class="">Various Pension</span>
							</div>
							<div class=" d-flex mb-7">
																						<span class="mr-5"">ID #: </span>
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
																								<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
																							</div>
																							<div class="d-flex mb-24">
																								<img src="/img/logo-footer.png" class="w-100" alt="">
																							</div>
														</div>
													</div>
												</div>
											</div>
										</div>


		





		<div class="modal" id="soaModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg minw-70" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<img src="/img/company_header.png" style="width:100%" class="mb-16" alt="Company Header">
					<div class="d-flex flex-column" style="padding:0 50px;">
						<span class="text-center text-block dark-bb pb-10 text-bold font-lg mb-16">STATEMENT OF ACCOUNT</span>

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
									<span class="mr-5"">A/O: </span>
								<span class="">025 - Janine C. Escallar</span>
							</div>
							<div class=" d-flex mb-7">
										<span class="mr-5"">Due Date: </span>
								<span class="">08/08/22</span>
							</div>
							<div class=" d-flex mb-7">
											<span class="mr-5"">Loan Type: </span>
								<span class="">Add-on</span>
							</div>
							<div class=" d-flex mb-7">
												<span class="mr-5"">Interest: </span>
								<span class="">8,400.00</span>
							</div>
							<div class=" d-flex mb-7">
													<span class="mr-5"">Int. Rate: </span>
								<span class="">30% p.a. / 2.50% p.m.</span>
							</div>
							<div class=" d-flex mb-7">
														<span class="mr-5"">Mode: </span>
								<span class="">Monthly</span>
							</div>
							<div class=" d-flex mb-7">
															<span class="mr-5"">Center: </span>
								<span class="">Various Pension</span>
							</div>
							<div class=" d-flex mb-7">
																<span class="mr-5"">ID #: </span>
								<span class="">08-052415427-4</span>
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
																		<table class="table table-stripped mb-64">
																			<thead>
																				<th>Date</th>
																				<th>O.R #</th>
																				<th>Payment Type</th>
																				<th>Reference</th>
																				<th>Principal</th>
																				<th>Interest</th>
																				<th>PDI</th>
																				<th>Penalty</th>
																				<th>Total Payment</th>
																				<th>Remarks</th>
																			</thead>
																			<tbody>
																				<tr>
																					<td>12/12/2021</td>
																					<td>00212</td>
																					<td>Cash</td>
																					<td></td>
																					<td>250.00</td>
																					<td>100.00</td>
																					<td>0.00</td>
																					<td>0.00</td>
																					<td>350.00</td>
																					<td></td>
																				</tr>
																				<tr>
																					<td>12/12/2021</td>
																					<td>00212</td>
																					<td>Cash</td>
																					<td></td>
																					<td>250.00</td>
																					<td>100.00</td>
																					<td>0.00</td>
																					<td>0.00</td>
																					<td>350.00</td>
																					<td>CANCELLED</td>
																				</tr>
																				<tr>
																					<td>12/12/2021</td>
																					<td>00212</td>
																					<td>Cash</td>
																					<td></td>
																					<td>250.00</td>
																					<td>100.00</td>
																					<td>0.00</td>
																					<td>0.00</td>
																					<td>350.00</td>
																					<td></td>
																				</tr>
																				<tr>
																					<td>12/12/2021</td>
																					<td>00212</td>
																					<td>Cash</td>
																					<td></td>
																					<td>250.00</td>
																					<td>100.00</td>
																					<td>0.00</td>
																					<td>0.00</td>
																					<td>350.00</td>
																					<td>CANCELLED</td>
																				</tr>
																				<tr>
																					<td>12/12/2021</td>
																					<td>00212</td>
																					<td>Cash</td>
																					<td></td>
																					<td>250.00</td>
																					<td>100.00</td>
																					<td>0.00</td>
																					<td>0.00</td>
																					<td>350.00</td>
																					<td></td>
																				</tr>
																				<tr>
																					<td>12/12/2021</td>
																					<td>00212</td>
																					<td>Cash</td>
																					<td></td>
																					<td>250.00</td>
																					<td>100.00</td>
																					<td>0.00</td>
																					<td>0.00</td>
																					<td>350.00</td>
																					<td></td>
																				</tr>
																			</tbody>
																		</table>



																		<div>
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
																								<td>28,00.00</td>
																								<td>8,632.00</td>
																								<td>19,368.00</td>
																							</tr>
																							<tr>
																								<td>Interest</td>
																								<td>8,00.00</td>
																								<td>3,500.00</td>
																								<td>4,900.00</td>
																							</tr>
																							<tr>
																								<td>Int. Rebates</td>
																								<td>00.00</td>
																								<td>00.00</td>
																								<td>00.00</td>
																							</tr>
																							<tr>
																								<td style="border-bottom: 2px solid #aaa!important;"></td>
																								<td style="border-bottom: 2px solid #aaa!important;"></td>
																								<td style="border-bottom: 2px solid #aaa!important;"></td>
																								<td style="border-bottom: 2px solid #aaa!important;"></td>
																							</tr>
																							<tr>
																								<td class="text-bold">Total Balance</td>
																								<td>36,400.00</td>
																								<td>12,132.00</td>
																								<td>24,266.00</td>
																							</tr>
																							<tr>
																								<td class="text-bold" style="padding-top:24px;padding-bottom:5px;">CURRENT CHARGES</td>
																								<td></td>
																								<td></td>
																								<td></td>
																							</tr>
																							<tr>
																								<td>Penalty</td>
																								<td>00.00</td>
																								<td>00.00</td>
																								<td>00.00</td>
																							</tr>
																							<tr>
																								<td>PD Int.</td>
																								<td>00.00</td>
																								<td>00.00</td>
																								<td>00.00</td>
																							</tr>
																							<tr>
																								<td style="border-bottom: 2px solid #aaa!important;"></td>
																								<td style="border-bottom: 2px solid #aaa!important;"></td>
																								<td style="border-bottom: 2px solid #aaa!important;"></td>
																								<td style="border-bottom: 2px solid #aaa!important;"></td>
																							</tr>
																							<tr>
																								<td class="text-bold">Current Balance</td>
																								<td>36,400.00</td>
																								<td>12,132.00</td>
																								<td>24,266.00</td>
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
																		<a href="#" class="btn btn-default min-w-150">Print</a>
																		<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
																	</div>
																	<div class="d-flex mb-24">
																		<img src="/img/logo-footer.png" class="w-100" alt="">
																	</div>
								</div>
							</div>
						</div>
					</div>
				</div>




		<div class="modal" id="uploadedFilesModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg minw-70" role="document">
				<div class="modal-content">
					<div class="modal-body font-md pxy-25">
						<span class="bb-dark-8 text-block text-bold pb-10">Uploaded Documents</span>
					</div>
				</div>
			</div>
		</div>


	</div>
	
</template>

<script>
export default {
	props:['borrower_id','token'],
	data(){
		return {
			baseUrl: this.baseURL(),
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
			img:'/img/user.png',
		}
	},
	methods:{
		fetchBorrower:function(){
			axios.get(this.baseURL() + 'api/borrower/' + this.borrower_id, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.borrower = response.data.data;
				this.fetchStatements();
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},

		fetchStatements:function(){
			axios.get(this.baseURL() + 'api/account/statement/' + this.borrower_id, {
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

		imageCapture:function(img){
			this.img = img;
		}
	},
	computed:{
		borrowerPhoto:function(){
			return this.borrower.photo? this.borrower.photo : this.img;
		}
	},
	mounted(){
		this.fetchBorrower();
	}
}
</script>