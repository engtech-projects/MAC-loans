<template>
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between">
			<h1 class="m-0 font-35">Release Entry</h1>
			<a href="#" @click.prevent="clearData.borrower=1" class="btn btn-primary-dark min-w-150">New Client</a>
		</div><!-- /.col -->
		<div class="d-flex flex-column flex-xl-row p-16">
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
							<tr v-if="borrowers.length == 0">
								<td>No borrowers yet.</td>
								<td></td>
								<td></td>
							</tr>
							<tr v-for="b in borrowers" :key="b.borrower_id">
								<td>{{b.borrower_num}}</td>
								<td><a href="#">{{b.firstname + ' ' + b.lastname}}</a></td>
								<td><span @click="selectBorrower(b)" class="text-green c-pointer">select</span></td>
							</tr>
						</tbody>
					</table>
					<div d-flex flex-column>
						<span class="text-red font-md">Existing Current Loan Accounts</span>
						<div class="mb-10"></div>
						<table class="table table-stripped light-border">
							<thead>
								<th>Account #</th>
								<th>Amount</th>
								<th>Rem. Bal.</th>
								<th>Date Rel.</th>
							</thead>
							<tbody>
								<tr>
									<td>0121421</td>
									<td>22,202.00</td>
									<td>5,000.00</td>
									<td>12/12/2021</td>
								</tr>
								<tr>
									<td>0121421</td>
									<td>22,202.00</td>
									<td>5,000.00</td>
									<td>12/12/2021</td>
								</tr>
								<tr>
									<td>0121421</td>
									<td>22,202.00</td>
									<td>5,000.00</td>
									<td>12/12/2021</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div style="flex:20">
					<ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist" style="display:none;">
						<li class="nav-item">
							<a class="nav-link active" id="custom-content-below-borrowerinfo-tab" data-toggle="pill" href="#custom-content-below-borrowerinfo" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Borrower Info</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="custom-content-below-coborrowerinfo-tab" data-toggle="pill" href="#custom-content-below-coborrowerinfo" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Co Borrower Info</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="custom-content-below-loandetails-tab" data-toggle="pill" href="#custom-content-below-loaddetails" role="tab" aria-controls="custom-content-below-messages" aria-selected="false">Loan Details</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="custom-content-below-promisory-tab" data-toggle="pill" href="#custom-content-below-promisory" role="tab" aria-controls="custom-content-below-settings" aria-selected="false">Settings</a>
						</li>
					</ul>
					<div class="tab-content" id="custom-content-below-tabContent">
						<div class="tab-pane fade show active" id="custom-content-below-borrowerinfo" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
							<borrowers-info @borrowerCleared="clearData.borrower=0" @savedInfo="fetchBorrowers()" @saveBorrower="saveInfo=''" @clearBorrowerInfo="borrower=''" :clear="clearData.borrower" :token="token" :pborrower="borrower" :psave="saveInfo"></borrowers-info>
						</div>


						<div class="tab-pane fade" id="custom-content-below-coborrowerinfo" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
							<div class="d-flex flex-column">
								<section class="mb-24" style="flex:21;padding-left:16px;">
									<span class="section-title mb-24">Co-Borrower's Information</span>
									<div class="d-flex flex-row">
										<div class="form-group mb-10" style="flex:1">
											<label for="coFullname" class="form-label">Full Name</label>
											<input type="text" class="form-control form-input " id="coFullname">
										</div>
									</div>
									<div class="form-group mb-10" style="flex: 3">
										<label for="spouseAddress  " class="form-label">Address</label>
										<input type="text" class="form-control form-input " id="spouseAddress  ">
									</div>
									<div class="d-flex flex-row">
										<div class="form-group mb-10 mr-16" style="flex: 3">
											<label for="coIdType" class="form-label">ID Type</label>
											<input type="text" class="form-control form-input " id="coIdType">
										</div>
										<div class="form-group mb-10 mr-16" style="flex: 3">
											<label for="coIdNumber" class="form-label">ID Number</label>
											<input type="text" class="form-control form-input " id="coIdNumber">
										</div>
										<div class="form-group mb-10 mr-16" style="flex: 3">
											<label for="coIdDate" class="form-label">ID Date Issued</label>
											<input type="date" class="form-control form-input " id="coIdDate">
										</div>
										<div style="flex: 3"></div>
									</div>
								</section>

								<section class="mb-24" style="flex:21;padding-left:16px;">
									<span class="section-title mb-24">Co-Maker's Information</span>
									<div class="d-flex flex-row">
										<div class="form-group mb-10" style="flex:1">
											<label for="coFullname" class="form-label">Full Name</label>
											<input type="text" class="form-control form-input " id="coFullname">
										</div>
									</div>
									<div class="form-group mb-10" style="flex: 3">
										<label for="spouseAddress  " class="form-label">Address</label>
										<input type="text" class="form-control form-input " id="spouseAddress  ">
									</div>
									<div class="d-flex flex-row">
										<div class="form-group mb-10 mr-16" style="flex: 3">
											<label for="coIdType" class="form-label">ID Type</label>
											<input type="text" class="form-control form-input " id="coIdType">
										</div>
										<div class="form-group mb-10 mr-16" style="flex: 3">
											<label for="coIdNumber" class="form-label">ID Number</label>
											<input type="text" class="form-control form-input " id="coIdNumber">
										</div>
										<div class="form-group mb-10 mr-16" style="flex: 3">
											<label for="coIdDate" class="form-label">ID Date Issued</label>
											<input type="date" class="form-control form-input " id="coIdDate">
										</div>
										<div style="flex: 3"></div>
									</div>
								</section>

								<div class="d-flex flex-row-reverse mb-45">
									<a @click.prevent="navigate('custom-content-below-loandetails-tab')" href="#" data-tab="custom-content-below-loandetails-tab" class="btn btn-success tab-navigate" style="flex:2">Next</a>
									<a @click.prevent="navigate('custom-content-below-borrowerinfo-tab')" href="#" data-tab="custom-content-below-borrowerinfo-tab" class="btn btn-primary-dark mr-24 tab-navigate" style="flex:2">Back</a>
									<div style="flex:22"></div>
								</div>
							</div>
						</div>



						<div class="tab-pane fade" id="custom-content-below-loaddetails" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
							<div class="d-flex flex-column">
								<section class="mb-24" style="flex:21;padding-left:16px;">
									<span class="section-title mb-24">Loan Details</span>
									<div class="d-flex flex-row">
										<div style="flex:18" class="mr-16"></div>
										<div class="form-group mb-10" style="flex:7">
											<label for="dateRelease" class="form-label">Date Release</label>
											<input type="date" class="form-control form-input " id="dateRelease">
										</div>
									</div>
									<div class="d-flex flex-row">
										<div class="form-group mb-10 mr-16" style="flex:3">
											<label for="cycleNumber" class="form-label">Cycle Number</label>
											<input type="text" class="form-control form-input " id="cycleNumber">
										</div>
										<div class="form-group mb-10 mr-16" style="flex:7">
											<label for="accountOfficer" class="form-label">Account Officer</label>
											<input type="text" class="form-control form-input " id="accountOfficer">
										</div>
										<div class="form-group mb-10 mr-16" style="flex:7">
											<label for="product" class="form-label">Product</label>
											<input type="text" class="form-control form-input " id="product">
										</div>
										<div class="form-group mb-10" style="flex:7">
											<label for="accountNumber" class="form-label">Account Number</label>
											<input type="text" class="form-control form-input " id="accountNumber">
										</div>
									</div>
									<div class="d-flex flex-row">
										<div class="form-group mb-10 mr-16" style="flex:7">
											<label for="center" class="form-label">Center</label>
											<input type="text" class="form-control form-input " id="center">
										</div>
										<!-- <div class="form-group mb-10 mr-16" style="flex:7">
											<label for="group" class="form-label">Group</label>
											<input type="text" class="form-control form-input " id="group">
										</div> -->
										<div class="form-group mb-10 mr-16" style="flex:7">
											<label for="type" class="form-label">Type</label>
											<input type="text" class="form-control form-input " id="type">
										</div>
										<div class="form-group mb-10" style="flex:7">
											<label for="mode" class="form-label">Mode</label>
											<input type="text" class="form-control form-input " id="mode">
										</div>
									</div>
									<div class="d-flex flex-row pb-45 mb-24" style="border-bottom:1px solid #dfdfd0">
										<div class="form-group mb-10 mr-16" style="flex:7">
											<label for="center" class="form-label">Loan Amount</label>
											<input type="text" class="form-control form-input " id="center">
										</div>
										<div class="form-group mb-10 mr-16" style="flex:4">
											<label for="group" class="form-label">Terms</label>
											<input type="text" class="form-control form-input " id="group">
										</div>
										<div class="form-group mb-10 mr-16" style="flex:5">
											<label for="type" class="form-label">Day Schedule</label>
											<select class="form-control form-input " id="type">
												<option value="monday">Monday</option>
												<option value="tuesday">Tuesday</option>
												<option value="wednesday">Wednesday</option>
												<option value="thursday">Thursday</option>
												<option value="friday">Friday</option>
												<option value="saturday">Saturday</option>
												<option value="sunday">Sunday</option>
											</select>
										</div>
										<div style="flex:9"></div>
									</div>

									<div class="d-flex flex-row">
										<div class="form-group mb-10 mr-16" style="flex:6">
											<label for="interestRate" class="form-label">Interest Rate</label>
											<input type="text" class="form-control form-input " id="interestRate">
										</div>
										<div class="form-group mb-10 mr-16" style="flex:6">
											<label for="interestAmount" class="form-label">Interest Amount</label>
											<input type="text" class="form-control form-input " id="group">
										</div>
										<div class="form-group mb-10 mr-16" style="flex:6">
											<label for="numberOfInstallment" class="form-label">Number of Installment</label>
											<input type="text" class="form-control form-input " id="numberOfInstallment">
										</div>
										<div class="form-group mb-10" style="flex:6">
											<label for="dueDate" class="form-label">Due Date</label>
											<input type="date" class="form-control form-input " id="dueDate">
										</div>
									</div>
								</section>

								<section class="mb-24 pb-45" style="flex:21;padding-left:16px;border-bottom:1px solid #AAA">
									<span class="section-title mb-24">Deduction Fees</span>
									<div class="d-flex flex-row">
										<div class="d-flex flex-column mr-45" style="flex:3;">
											<div class="d-flex flex-row mb-16">
												<label for="dueDate" class="form-label" style="flex:3">Filling Fee</label>
												<input type="text" class="form-control form-input text-right mr-16" value="P 25,000.00" style="flex:4" id="dueDate">
												<a href="" class="btn btn-success flex-1" style="line-height:2">Edit</a>
											</div>
											<div class="d-flex flex-row mb-16">
												<label for="dueDate" class="form-label" style="flex:3">Doc. Stamp</label>
												<input type="text" class="form-control form-input text-right mr-16" value="P 25,000.00" style="flex:4" id="dueDate">
												<span class="flex-1" style="padding:7px 15px"></span>
											</div>
											<div class="d-flex flex-row mb-16">
												<label for="dueDate" class="form-label" style="flex:3">Insurance</label>
												<input type="text" class="form-control form-input text-right mr-16" value="P 25,000.00" style="flex:4" id="dueDate">
												<span class="flex-1" style="padding:7px 15px"></span>
											</div>
											<div class="d-flex flex-row mb-16">
												<label for="dueDate" class="form-label" style="flex:3">Notarial Fee</label>
												<input type="text" class="form-control form-input text-right mr-16" value="P 25,000.00" style="flex:4" id="dueDate">
												<span class="flex-1" style="padding:7px 15px"></span>
											</div>
											<div class="d-flex flex-row mb-16">
												<label for="dueDate" class="form-label" style="flex:3">Prepaid Interest</label>
												<input type="text" class="form-control form-input text-right mr-16" value="P 25,000.00" style="flex:4" id="dueDate">
												<span class="flex-1" style="padding:7px 15px"></span>
											</div>
											<div class="d-flex flex-row mb-16">
												<label for="dueDate" class="form-label" style="flex:3">Affidavit</label>
												<input type="text" class="form-control form-input text-right mr-16" value="P 25,000.00" style="flex:4" id="dueDate">
												<span class="flex-1" style="padding:7px 15px"></span>
											</div>
											<div class="d-flex flex-row mb-16">
												<label for="dueDate" class="form-label" style="flex:3">Memo</label>
												<input type="text" class="form-control form-input text-right mr-16" value="P 25,000.00" style="flex:4" id="dueDate">
												<span class="flex-1" style="padding:7px 15px"></span>
											</div>
										</div>
										<div class="d-flex flex-column" style="flex:2;">
											<div class="form-group mb-16">
												<label for="dueDate" class="form-label">Total Deductions</label>
												<input type="number" class="form-control form-input text-right mr-16 text-green " id="dueDate">
												<span class="flex-1" style="padding:7px 15px"></span>
											</div>
											<div class="form-group mb-45">
												<label for="dueDate" class="form-label">Net Proceeds</label>
												<input type="number" class="form-control form-input text-right mr-16 text-green " id="dueDate">
												<span class="flex-1" style="padding:7px 15px"></span>
											</div>
											<div class="form-group">
												<label for="dueDate" class="form-label">Release Type</label>
												<select name="" id="" class="form-control form-input pr-12 text-right mr-16 text-green">
													<option value="">Cash Release</option>
												</select>
											</div>
										</div>
										<div class="flex-1"></div>
									</div>
									<div class="d-flex align-items-center">
										<span class="mr-16 font-20" style="margin-top:10px">Memo - Deduct to Balance</span>
										<div class="d-flex align-items-end flex-1">
											<div class="form-group mr-16 flex-1">
												<select name="" id="" class="form-control form-input pr-12 mr-16 text-green">
													<option value="">5000</option>
												</select>
											</div>
											<div class="form-group flex-2">
												<label for="dueDate" class="form-label">Account # and Balance</label>
												<select name="" id="" class="form-control form-input pr-12 mr-16 text-green">
													<option value="">1232542154 - P 5000.00</option>
												</select>
											</div>
											<div class="flex-1"></div>
										</div>
									</div>
								</section>



								<div class="d-flex flex-row-reverse mb-45 justify-content-between">
									<div class="d-flex">
										<a @click.prevent="navigate('custom-content-below-coborrowerinfo-tab')" href="#" data-tab="custom-content-below-coborrowerinfo-tab" class="btn btn-primary-dark mr-24 tab-navigate min-w-150">Back</a>
										<a href="#" data-toggle="modal" data-target="#warningModal" class="btn btn-success tab-navigate min-w-150">Next</a>
									</div>
									<a href="#" data-toggle="modal" data-target="#lettersModal" class="btn btn-yellow-light">Print Document</a>
									<!-- <div style="flex:22"></div> -->
								</div>
							</div>
						</div>


						<div class="tab-pane fade" id="custom-content-below-promisory" role="tabpanel" aria-labelledby="custom-content-below-settings-tab">
							<div class="d-flex flex-column">
								<section class="mb-24" style="flex:21;padding-left:16px;">
									<span class="section-title mb-24">Promisory Details</span>

								</section>



								<div class="d-flex flex-row-reverse mb-45">
									<a href="#" data-tab="custom-content-below-promisory-tab" class="btn btn-success tab-navigate" style="flex:2">Next</a>
									<a href="#" data-tab="custom-content-below-loandetails-tab" class="btn btn-primary-dark mr-24 tab-navigate" style="flex:2">Back</a>
									<div style="flex:22"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal" id="lettersModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg minw-70" role="document">
		  <div class="modal-content">
			<div class="modal-body p-24">
				<span class="light-bb text-bold text-primary-dark text-lg pb-16 mb-24 text-block">Letters</span>
				<div class="d-flex flex-column flex-md-row align-items-start">
					<div class="flex-2 light-border d-flex flex-column letter-nav xs-mb-32 xs-flex-1">
						<div class="pxy-25 light-bb hover-light" data-tab="">
							<span class="text-20">Reminder Letter</span>
						</div>
						<div class="pxy-25 light-bb hover-light active" data-tab="dacion-en-pago-tab">
							<span class="text-20">DACION EN PAGO</span>
						</div>
						<div class="pxy-25 light-bb hover-light" data-tab="">
							<span class="text-20">DOA For ATM</span>
						</div>
						<div class="pxy-25 light-bb hover-light" data-tab="">
							<span class="text-20">MOA For SME</span>
						</div>
						<div class="pxy-25 light-bb hover-light" data-tab="">
							<span class="text-20">SME Schedule</span>
						</div>
						<div class="pxy-25 hover-light" data-tab="promissory-note-tab">
							<span class="text-20">Promissory Note</span>
						</div>
					</div>
					<div style="flex:6">
						<ul class="nav nav-tabs hide" id="custom-content-below-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="dacion-en-pago-tab" data-toggle="pill" href="#dacion-en-pago" role="tab" aria-controls="custom-content-below-home" aria-selected="true">DACION EN PAGO</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="promissory-note-tab" data-toggle="pill" href="#promissory-note" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Promissory Note</a>
							</li>
						</ul>
						<div class="tab-content" id="custom-content-below-tabContent">
							<div class="tab-pane fade show active" id="dacion-en-pago" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
								<img :src="baseUrl+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
								<div class="d-flex flex-column font-md" style="padding:0 35px;">
									
									<div class="d-flex flex-column title align-items-center mb-24">
										<span class="font-26 text-bold text-primary-dark lh-1">DACION EN PAGO</span>
									</div>
									<section class="font-md">
										<span class="text-block mb-24">KNOW ALL MEN BY THESE PRESENTS:</span>
										<p>
											This INSTURMENT made and executed this 14TH day of DECEMBER 2021 at Button City, Philippines, by and between: <span class="text-underlined">LOLITO T. AMODIA</span> single/married to_________________________________________  of legal age, Filipino citizen, and resident of <span class="text-underlined">P-9 MJ SANTOS TUNGAO, BUTUAN CITY AGUSAN DEL NORTE</span>  herein after called the FIRST PARTY;
										</p>
										<p>
											MAC LENDING a lending institution, duly registered under the laws of the Republic of the Philippines and with postal address at T. Cabo Extension, Butuan City represented by its Branch Manager JANINE L DESCALLAR herein after called as the SECOND PARTY;
										</p>
										<p>WITNESSETH:</p>
										<p>
											That the FIRST PARTY hereby acknowledges to have been indebted to the SECOND PARTY in the sum of THIRTEEN THOUSAND PESOS (P13,000.00). Philippines currency, as of this date, since, he/she could no longer paid it in full by way of cash, hence, by presents the FIRST PARTY, voluntarily assign, transfer convey and set over unto the SECOND PARTY that certain PERSONAL property particularly describe as follows: 
										</p>
										<p>
											<span class="text-block">Description:</span> CR No.:283729891; Plate No.:1501-00000126137; Engine No.: KPY00E276322; Chassis No.: KPY00276400; Make: HONDA MOTOR WORLD, INC.; Series: CETI 25MSE; Body Type: MOTORCYCLE RED; XRM 125 DS 
										</p>
										<p>
											<span class="text-block">of which the FIRST PARTY is registered owner, his/her property thereto being evidence by</span>
											____________________________________________.
										</p>
										<p>
											That the SECOND PARTY does hereby accept this assignment in payment of the total/partial obligation owing to him/her by the FIRST PARTY as above stated, (giving to the Second Party, however, the option to repurchase the above-describe property from the First Party for the sum of and after the date hereof, which right shall automatically be deemed cancelled, it not exercised within 15 days from the date hereof).
										</p>
										<p>
											That by virtue of this presents, the indebtedness of FIRST PARTY as cited above is hereby paid and extinguished. 
										</p>
										<p>
											IN WITNESS WHEREOF, the parties hereto have hereunto set their hands this_____________________________ at Butuan City, Philippines.
										</p>

										<div class="d-flex flex-row mb-24">
											<div class="flex-1">
												<span class="text-block">LOLITO AMODIA </span>
												<span class="text-block">FIRST PARTY</span>
												<span class="text-block">Type of ID: BRGY ID</span>
												<span class="text-block">I.D Number: 2021-13</span>
												<span class="text-block">Date:______________________________</span>
											</div>
											<div class="flex-2">
												<span class="text-block">MARK ANTHONY M. CHAVEZ</span>
												<span class="text-block">(SECOND PARTY)</span>
												<span class="text-block">TIN:920-403-726-000</span>
											</div>
										</div>

										<p class="mb-64">
											WITH MY MARITAL CONSENT: 
										</p>

										<div class="d-flex flex-row align-items-end mb-36">
											<div class="flex-1 mr-64">
												<span class="text-block">SIGNED IN THE PRESENCE OF:</span>
												<span>______________________________________</span>
											</div>
											<div class="flex-2">
												<span>______________________________________</span>
											</div>
										</div>

										<span class="text-block">ACKNOWLEDGEMENT</span>
										<span class="text-block">REPUBLIC OF THE PHILIPPINES)</span>
										<span class="text-block">CITY OF ____________________)S.S.</span>
										<span class="text-block mb-36">X---------------------------------/</span>

										<p>
											BEFORE ME, a notary public for and in the City of Butuan, Philippines this________________ day of_______________,  personally appeared the above named person, known to me and to me known to be the same person of the foregoing instrument, consisting of one (1) page including this page where the acknowledgement is written, signed by the parties and their two (2) instrumental witness, and they acknowledgement to me that the same are their own free will and voluntary act and deed.The Valid ID's of the parties were exhibited to me the same being that which appears below their respective names and signatures above.
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
								</div>
							</div>

							<div class="tab-pane fade" id="promissory-note" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
								<img :src="baseUrl+'/img/company_header.png'" style="width:100%" class="mb-45" alt="Company Header">
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
														<span class="">ID Number  :</span>
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
										<div class= "mb-24">
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
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		  </div>
		</div>
	</div>
			<div class="modal" id="warningModal" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-body p-24">
						<div class="d-flex align-items-center">
							<img :src="baseUrl+'/img/warning.png'" style="width:120px;height:auto;" class="mr-24" alt="warning icon">
							<div class="d-flex flex-column">
								<span class="text-primary-dark text-bold mb-24">
									Please re check all the data if correct and genuine. If checking is done and verified, kindly press proceed.
								</span>
								<div class="d-flex mt-auto justify-content-between">
									<a href="#" data-dismiss="modal" class="btn btn-danger min-w-120">Re Check</a>
									<a @click.prevent="saveInfo=1" href="#" data-dismiss="modal" class="btn btn-primary-dark min-w-120">Proceed</a>
								</div>
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
		props:['token'],
		data(){
			return {
				clearData:{
					borrower:0
				},
				saveInfo:'',
				borrower:'',
				baseUrl: window.location.origin,
				borrowers:[],
			}
		},
		methods: {
			fetchBorrowers:function(){
				axios.get(window.location.origin + '/api/borrower', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					// console.log(response.data);
					this.borrowers = response.data.data;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
			selectBorrower:function(data){
				this.borrower = '';
				this.borrower = JSON.stringify(data);
				// console.log(this.borrower);
			},
			navigate:function(tab){
				document.getElementById(tab).click();
			},
			dateToYMD:function(date) {
				var d = date.getDate();
				var m = date.getMonth() + 1;
				var y = date.getFullYear();
				return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
			}
		},

        mounted() {	
			this.fetchBorrowers();
        }
    }
</script>
