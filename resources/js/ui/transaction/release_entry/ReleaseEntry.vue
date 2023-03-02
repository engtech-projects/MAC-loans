<template>
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between">
			<h1 class="m-0 font-35">{{title}}</h1>
			<a v-if="!rejectid && transactionDate.status == 'open'" href="#" @click.prevent="clearData.borrower=1;resetLoanDetails()" class="btn btn-primary-dark min-w-150">New Client</a>
		</div><!-- /.col -->
		<div v-if="transactionDate.status == 'open'">
			<div class="d-flex flex-column flex-xl-row p-16">
					<div style="flex:9;">
						<client-list-side @resetAllBorrower="resetAllVal=false" v-if="rejectid" @selectAccount="selectAccount" :pborrowers="rejectedAccounts" :account="rejectedAccount.loan_account_id" :resetall="resetAllVal"></client-list-side>
						<client-list-side @resetAllBorrower="resetAllVal=false" v-if="!rejectid" @selectBorrower="selectBorrower" :pborrowers="borrowers" :id="{}" :resetall="resetAllVal"></client-list-side>
						<div d-flex flex-column v-if="borrower.borrower_id && !rejectid">
							<span class="text-red font-md">Existing Current Loan Accounts</span>
							<div class="mb-10"></div>
							<table class="table table-stripped light-border table-hover">
								<thead>
									<th>Account #</th>
									<th>Amount</th>
									<th>Rem. Bal.</th>
									<th>Date Rel.</th>
								</thead>
								<tbody>
									<tr v-if="pendingLoanAccounts.length < 1"><td>No existing current account.</td></tr>
									<tr @click="loanDetails=bl;setCycle()" class="existing-loans" :class="selected(bl.loan_account_id)" v-for="bl in pendingLoanAccounts" :key="bl.loan_account_id">
										<td>{{bl.account_num}}</td>
										<td>{{bl.loan_amount}}</td>
										<td>{{formatToCurrency(bl.remainingBalance.memo.balance)}}</td>
										<td>{{dateToMDY(new Date(bl.date_release))}}</td>
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
								<borrowers-info
								:idtype="idType"
								:loan_id="loanDetails.loan_account_id" @nextBorrower="nextBorrower" @borrowerCleared="clearData.borrower=0" @savedInfo="savedInfo" @saveBorrower="saveInfo=''" @clearBorrowerInfo="resetBorrower"
								:clear="clearData.borrower"
								:token="token"
								:pborrower="borrower"
								:psave="saveInfo"
								@load="loading=true"
								@unload="loading=false"
								:transactionDate="transactionDate"></borrowers-info>
							</div>


							<co-borrower @cbcopy="copyCB=false" :copycb="copyCB" :idtype="idType" :borrowers="borrowers" :loandetails="loanDetails" @update-loan-details="updateLoanDetails" :pborrower="borrower"></co-borrower>



							<div class="tab-pane fade" id="custom-content-below-loaddetails" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
								<loan-details
								:prejected="rejectid"
								:loanaccounts="pendingLoanAccounts"
								:releasetype="releasetype"
								:idtype="idtype"
								:saveloandetails="saveLoanDetails"
								:borrowerswitch="borrower.borrower_id"
								:borrowerbday="borrowerBirthdate"
								:borrower="bborrower"
								:token="token"
								:loandetails="loanDetails"
								:pbranch="pbranch"
								:transactionDate="transactionDate"
								@load="loading=true"
								@unload="loading=false"
								@resetall="resetAll()"
								></loan-details>
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

									<div @click="switchTab('reminder-letter-tab')" class="pxy-25 light-bb hover-light" data-tab="" :class="isActive('reminder-letter-tab',activeTab)">
										<span class="text-20">Reminder Letter</span>
									</div>
									<div @click="switchTab('dacion-en-pago-tab')" class="pxy-25 light-bb hover-light" :class="isActive('dacion-en-pago-tab',activeTab)" data-tab="dacion-en-pago-tab">
										<span class="text-20">DACION EN PAGO</span>
									</div>
									<div @click="switchTab('doa-for-atm-tab')" class="pxy-25 light-bb hover-light" :class="isActive('doa-for-atm-tab',activeTab)" data-tab="">
										<span class="text-20">DOA For ATM</span>
									</div>
									<div @click="switchTab('moa-for-sme-tab')" class="pxy-25 light-bb hover-light" :class="isActive('moa-for-sme-tab',activeTab)" data-tab="">
										<span class="text-20">MOA For SME</span>
									</div>
									<div @click="switchTab('sme-schedule-tab')" class="pxy-25 light-bb hover-light" :class="isActive('sme-schedule-tab',activeTab)" data-tab="">
										<span class="text-20">SME Schedule</span>
									</div>
									<div @click="switchTab('promissory-note-tab')" class="pxy-25 hover-light" :class="isActive('promissory-note-tab',activeTab)" data-tab="promissory-note-tab">
										<span class="text-20">Promissory Note</span>
									</div>
								</div>
								<div style="flex:6">
									<ul class="nav nav-tabs hide" id="custom-content-below-tab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="reminder-letter-tab" data-toggle="pill" href="#reminder-letter" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Reminder Letter</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="dacion-en-pago-tab" data-toggle="pill" href="#dacion-en-pago" role="tab" aria-controls="custom-content-below-home" aria-selected="true">DACION EN PAGO</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="doa-for-atm-tab" data-toggle="pill" href="#doa-for-atm" role="tab" aria-controls="custom-content-below-home" aria-selected="true">DACION EN PAGO</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="moa-for-sme-tab" data-toggle="pill" href="#moa-for-sme" role="tab" aria-controls="custom-content-below-home" aria-selected="true">MOA FOR SME</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="sme-schedule-tab" data-toggle="pill" href="#sme-schedule" role="tab" aria-controls="custom-content-below-home" aria-selected="true">SME Schedule</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="promissory-note-tab" data-toggle="pill" href="#promissory-note" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Promissory Note</a>
										</li>
									</ul>
									<div class="tab-content" id="custom-content-below-tabContent">

										<div  class="tab-pane fade show active legaldoc" id="reminder-letter" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
											<div class="d-flex flex-column font-md" style="padding:0 35px;">
												<div style="position:relative;">
													<img :src="baseUrl+'/img/company_header.png'" style="width:100%" class="mb-45" alt="Company Header">
												</div>
												<div class="d-flex flex-column title align-items-start mb-24">
													<span class="font-26 lh-1">MGA PAHINUMDOM</span>
												</div>
												<section class="font-md">
													<ol class="mb-64">
														<li class="mb-12">Ginadili ang pagdawat o pagbayad kong walay resibo. Gikinahanglan adunay e-isyu Nga resibo gikan sa Account Officer sa MAC.</li>
														<li class="mb-12">Ginadili ang pagpahulam ug kwarta Sa Account Officer gikan sa cliente.</li>
														<li class="mb-12">Ginadili ug bawal ang "Sakay sakay loan"</li>
														<li class="mb-12">Ginadilang pagbayad pinaagi sa pera padala or money transfer;
															Kong pananglitan aduna kamoy ipadala pambayad, palihog pagpahibalo sa kani nga mga numero (Nasipit: 0917.723.5473, Butuan: 0917-676-5066)</li>
													</ol>
													<p class="" style="margin-bottom:150px">
														Ako si <b class="allcaps darker-bb">{{fullName(borrower.firstname, borrower.middlename,borrower.lastname)}}</b>
														akong giila ug nasabtan ang pamahayag sa wala pa ang pag pirma ug pagkahingpit sa transaksyon sa kredito ug nga ako ug kami hingpit nga nagka uyon sa mga kondisyon nga gipahayag sa maong kasabutan
													</p>
													<span class="mb-72"></span>
													<div class="d-flex flex-column mb-72">
														<span class="dark-bb mb-12" style="max-width:350px"></span>
														<span>( Perma sa Borrower / Petsa )</span>
													</div>
												</section>
												<div class="d-flex mb-24">
													<div style="position:relative;">
														<img :src="baseURL() + 'img/logo-footer.png'" class="w-100 page-footer" alt="">
													</div>
												</div>
												<div class="mb-72"></div>
												<div class="d-flex flex-row-reverse mb-45 no-print">
													<button id="cancelDacionModal" data-dismiss="modal" class="btn btn-danger min-w-150 mr-24 hide">Cancel</button>
													<button @click="printReminder()" class="btn btn-default min-w-150">Print</button>
													<!-- <button @click.prevent="export2Word('reminder-letter', 'reminder_letter')" id="excelBtn" class="btn btn-success min-w-150 mr-24">Download Document</button> -->
												</div>
											</div>
										</div>


										<div  class="tab-pane fade" id="dacion-en-pago" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
											<img :src="baseUrl+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
											<div class="d-flex flex-column font-md" style="padding:0 35px;">

												<div class="d-flex flex-column title align-items-center mb-24">
													<span class="font-26 text-bold text-primary-dark lh-1">DACION EN PAGO</span>
												</div>
												<section style="font-size:16px!important;line-height:1.4em">
													<span class="text-block mb-24">KNOW ALL MEN BY THESE PRESENTS:</span>
													<p>
														This INSTURMENT made and executed this _________ day of ___________  at Butuan City, Philippines, by and between: <span class="text-underlined allcaps text-bold">{{fullName(borrower.firstname, borrower.middlename,borrower.lastname)}}</span> single/married to <span class="text-underlined allcaps text-bold">{{fullName(borrower.spouse_firstname,borrower.spouse_middlename,borrower.spouse_lastname)}}</span> of legal age, Filipino citizen, and resident of <span class="text-underlined allcaps text-bold">{{borrower.address}}</span>  herein after called the <b>FIRST PARTY</b>;
													</p>
													<p>
														MAC LENDING a lending institution, duly registered under the laws of the Republic of the Philippines and with postal address at T. Calo Extension, Butuan City represented by its Branch Manager <b class="allcaps">{{branch_mgr}}</b> herein after called as the <b>SECOND PARTY</b>;
													</p>
													<p>WITNESSETH:</p>
													<p>
														That the <b>FIRST PARTY</b> hereby acknowledges to have been indebted to the SECOND PARTY in the sum of <span class="text-underlined allcaps text-bold">{{numToWords(loanDetails.loan_amount)}}</span> <b>(P{{formatToCurrency(loanDetails.loan_amount)}})</b>. Philippines currency, as of this date, since, he/she could no longer paid it in full by way of cash, hence, by presents the <b>FIRST PARTY</b>, voluntarily assign, transfer convey and set over unto the <b>SECOND PARTY</b> that certain PERSONAL property particularly describe as follows:
													</p>
													<p>
														<span class="text-block">Description:</span> <b>{{loanDetails.documents.description}}</b>
													</p>
													<p>
														<span class="text-block">of which the <b>FIRST PARTY</b> is registered owner, his/her property thereto being evidence by</span>
														____________________________________________.
													</p>
													<p>
														That the SECOND PARTY does hereby accept this assignment in payment of the total/partial obligation owing to him/her by the <b>FIRST PARTY</b> as above stated, (giving to the Second Party, however, the option to repurchase the above-describe property from the <b>FIRST PARTY</b> for the sum of and after the date hereof, which right shall automatically be deemed cancelled, it not exercised within 15 days from the date hereof).
													</p>
													<p>
														That by virtue of this presents, the indebtedness of <b>FIRST PARTY</b> as cited above is hereby paid and extinguished.
													</p>
													<p>
														IN WITNESS WHEREOF, the parties hereto have hereunto set their hands this {{dacionDate()}} at Butuan City, Philippines.
													</p>

													<div class="d-flex flex-row mb-24">
														<div class="flex-1 text-bold">
															<span class="text-block allcaps">{{fullName(borrower.firstname,borrower.middlename,borrower.lastname)}} </span>
															<span class="text-block">FIRST PARTY</span>
															<span class="text-block">Type of ID: {{borrower.id_type}}</span>
															<span class="text-block">I.D Number: {{borrower.id_no}}</span>
															<span class="text-block">Date: {{borrower.id_date_issued}}</span>
														</div>
														<div class="flex-2 text-bold">
															<span class="text-block">MARK ANTHONY M. CHAVEZ</span>
															<span class="text-block">(SECOND PARTY)</span>
															<span class="text-block">TIN: 920-403-726-000</span>
														</div>
													</div>

													<p class="mb-24 text-bold">
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
														BEFORE ME, a notary public for and in the City of Butuan, Philippines this ____ day of ______________,  personally appeared the above named person, known to me and to me known to be the same person of the foregoing instrument, consisting of one (1) page including this page where the acknowledgement is written, signed by the parties and their two (2) instrumental witness, and they acknowledgement to me that the same are their own free will and voluntary act and deed.The Valid ID's of the parties were exhibited to me the same being that which appears below their respective names and signatures above.
													</p>
													<div class="d-flex flex-column mb-24">
														<span>Doc. No.___________</span>
														<span>Page No.___________</span>
														<span>Book No.___________</span>
														<span>Series of___________</span>
													</div>
												</section>
												<div class="d-flex mb-24">
													<img :src="baseURL() + 'img/logo-footer.png'" class="w-100 page-footer" alt="">
												</div>
												<div class="mb-72"></div>
												<div class="d-flex flex-row-reverse mb-45 no-print">
													<button id="cancelDacionModal" data-dismiss="modal" class="btn btn-danger min-w-150 mr-24 hide">Cancel</button>
													<button @click="print()" class="btn btn-default min-w-150">Print</button>
													<!-- <button @click.prevent="export2Word('dacion-en-pago', 'dacion_en_pago')" id="excelBtn" class="btn btn-success min-w-150 mr-24">Download Document</button> -->
												</div>
											</div>
										</div>



										<div  class="tab-pane fade" id="doa-for-atm" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
											<img :src="baseUrl+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
											<div class="d-flex flex-column font-md" style="padding:0 35px;">

												<div class="d-flex flex-column title align-items-center mb-24">
													<span class="font-26 text-bold text-primary-dark lh-1">DEED OF ASSIGNMENT</span>
												</div>
												<section style="font-size:16px!important;line-height:1.4em">
													<span class="text-block mb-24 text-bold">KNOW ALL MEN BY THESE PRESENTS:</span>
													<p>
														That I, <b><u> {{fullName(borrower.firstname, borrower.middlename,borrower.lastname)}} </u></b> Filipino, of legal age, married/single and a resident of <b> <u> {{borrower.address}}</u> </b> herein known as the <b>ASSIGNOR;</b>
													</p>
													<b class="text-center text-block allcaps mb-24">-AND-</b>
													<p>
														<b> Micro Access Loans Corporation </b> a lending institution, duly registered under the laws of the Republic of the Philippines and with postal address at T. Calo St. Limaha , Butuan City represented by the Branch Manager <b> <u class="allcaps">{{branch_mgr}}  </u></b> hereinafter known as the <b> ASSIGNEE;</b>
													</p>
													<p>
														That for an in consideration of the Loan obtained by the ASSIGNOR from the ASSIGNEE the sum of <span class="allcaps text-bold">{{numToWords(loanDetails.loan_amount)}}</span>  <span class="text-bold text-underline">(P{{formatToCurrency(loanDetails.loan_amount)}})</span>. ASSIGNOR, by these presents, assign his/her Pension/Salary  through ATM Card to ASSIGNEE, with the following ATM Card details to wit;
													</p>
													<div class="d-flex mb-24">
														<div class="flex-1 flex-column align-items-center">
															<b class="text-center text-block mb-16">Name of Bank</b>
															<b class="text-center text-block text-underlined">{{loanDetails.documents.bank}}</b>
														</div>
														<div class="flex-1 flex-column align-items-center">
															<b class="text-center text-block mb-10">Account Number</b>
															<b class="text-center text-block text-underlined" style="padding-bottom:3px;">Card No: {{loanDetails.documents.card_no}}</b>
															<b class="text-center text-block" style="line-height:.1">Account No.: {{loanDetails.documents.account_no}}</b>
														</div>
													</div>
													<p>That the ASSIGNOR hereby gives the full power to the ASSIGNEE the authority to take/withdraw and deduct in full the monthly amortization of <span class="allcaps">{{numToWords(Math.ceil(amortAmountSingle))}}</span> <span>(P{{formatToCurrency(amortAmountSingle)}})</span> until the full settlement of the terms and conditions stated in the Promissory note. </p>

													<p>
														IN WITNESS WHEREOF, the parties hereto have hereunto set their hands this _____ day of __________ at Butuan City, Philippines.
													</p>

													<div class="d-flex mb-45">
														<div class="flex-1 d-flex flex-column align-items-center">
															<b class="text-block allcaps">{{fullName(borrower.firstname, borrower.middlename,borrower.lastname)}}</b>
															<span>ASSIGNOR</span>
														</div>
														<div class="flex-1 d-flex flex-column align-items-center">
															<b class="allcaps text-block">{{branch_mgr}}</b>
															<span>ASSIGNEE</span>
														</div>
													</div>

													<center class="text-sm text-bold">SIGNED IN THE PRESENCE OF</center>


													<div class="d-flex mb-45">
														<div class="flex-1 d-flex flex-column align-items-center">
															<b class="allcaps text-block">{{loanDetails.co_borrower_name}}</b>
															<span>Witness</span>
														</div>
														<div class="flex-1 d-flex flex-column align-items-center">
															<b class="allcaps text-block">{{staff}}</b>
															<span>Witness</span>
														</div>
													</div>

													<center class="text-sm text-bold">ACKNOWLEDGEDMENT</center>
													<span class="text-block">Republic of the Philippines     )</span>
													<span class="text-block mb-16">Butuan City		    )</span>

													<p class="mb-24">
														<center>BEFORE ME  a notary public in this ________ day of ______________ at City of Butuan, Philippines, personally appeared the following persons:</center>
													</p>
													<div class="d-flex flex-column mb-24">
														<div class="d-flex mb-24">
															<span class="flex-1">Name</span>
															<span class="flex-1">CTC NO./I.D. No.</span>
															<span class="flex-1">Date</span>
															<span class="flex-1">Place</span>
														</div>
														<div class="d-flex mb-16">
															<b class="flex-1 allcaps">{{fullName(borrower.firstname, borrower.middlename,borrower.lastname)}}</b>
															<b class="flex-1"><span class="allcaps">{{borrower.id_type}}</span> ID: {{borrower.id_no}}</b>
															<b class="flex-1"></b>
															<b class="flex-1">BUTUAN CITY</b>
														</div>
														<div class="d-flex">
															<b class="flex-1">JANINE L. DESCALLAR</b>
															<b class="flex-1">TIN: 938-417-539-000</b>
															<b class="flex-1"></b>
															<b class="flex-1">BUTUAN CITY</b>
														</div>
													</div>

													<p class="mb-24">
														Known to me and to me known to be the same persons who executed the foregoing Deed of Assignment and Acknowledgement to me that the same is their own free and voluntary act and as well as the free and voluntary act and deed of the entities herein represented with full power so to do and for the uses and purposes thereon set forth.
													</p>
													<p class="mb-24">
														<center>IN WITNESS WHEREOF, I have set my hand and affixed my Notarial Seal on date place above written.</center>
													</p>

													<div class="d-flex align-items-end mb-36">
														<div class="d-flex flex-column mb-24 flex-3">
															<span>Doc. No.___________</span>
															<span>Page No.___________</span>
															<span>Book No.___________</span>
															<span>Series of___________</span>
														</div>
														<span class="flex-1">Notary Public</span>
													</div>

												</section>
												<div class="d-flex mb-24">
													<img :src="baseURL() + 'img/logo-footer.png'" class="w-100 page-footer" alt="">
												</div>
												<div class="mb-72"></div>
												<div class="d-flex flex-row-reverse mb-45 no-print">
													<button id="cancelDacionModal" data-dismiss="modal" class="btn btn-danger min-w-150 mr-24 hide">Cancel</button>
													<button @click="printDoa()" class="btn btn-default min-w-150">Print</button>
													<!-- <button @click.prevent="export2Word('doa-for-atm', 'doa')" id="excelBtn" class="btn btn-success min-w-150 mr-24">Download Document</button> -->
												</div>
											</div>
										</div>





										<div  class="tab-pane fade" id="moa-for-sme" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
											<img :src="baseUrl+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
											<div class="d-flex flex-column font-md" style="padding:0 35px;">

												<div class="d-flex flex-column title align-items-center mb-24">
													<span class="font-26 text-bold text-primary-dark lh-1">MEMORANDUM AGREEMENT</span>
												</div>
												<section style="font-size:16px!important;line-height:1.3em!important">
													<span class="text-block mb-24">KNOW ALL MEN BY THESE PRESENTS:</span>

													<p class="mb-24">
														This AGREEMENT made and entered into this      th day of          at MICRO ACCESS LOANS CORPORATION Butuan City, Philippines by and among the undersigned borrowers under the loan program of  Micro Access Loans Corporation.

													</p>

													<div class="d-flex mb-24">
														<div class="flex-1">
															<center>MAKER/S</center>
															<center> <b class="text-block allcaps">{{fullName(borrower.firstname,borrower.middlename,borrower.lastname)}}</b></center>
														</div>
														<div class="flex-1">
															<center>ADDRESS</center>
															<center>  <b class="text-block allcaps">{{borrower.address}}</b></center>
														</div>
													</div>

													<div class="d-flex mb-24">
														<div class="flex-1">
															<center>CO-MAKER</center>
															<center><b class="text-block allcaps">{{loanDetails.co_maker_name}}</b></center>
														</div>
														<div class="flex-1">
															<center>ADDRESS</center>
															<center><b class="text-block allcaps">{{loanDetails.co_maker_address}}</b></center>
														</div>
													</div>

													<p class="mb-24">
														WHEREAS, we the borrowers of <b>Micro Access Loans Corporation</b> have voluntarily promised, committed and bound as we do hereby promised, commit and bind ourselves solidarily to fully pay our <b>loan</b> with <b>Micro Access Loans Corporation</b> in the amount of <span class="text-underlined allcaps text-bold">{{numToWords(loanDetails.loan_amount)}}</span> <b>(P{{formatToCurrency(loanDetails.loan_amount)}})</b> and until the full settlement of the term and condition as stated in the Promissory Note with PN No. <b> {{loanDetails.documents.promissory_number}}</b>
													</p>

													<p class="mb-24">
														<b>NOW, THEREFORE,</b> for and in consideration of the premises herein set forth, the parties have agreed to enter into a Memorandum of Agreement subject to the following condition:
													</p>

													<ol class="mb-24">
														<li>To open a checking account to be used for issuance of post-dated checks to <b>Micro Access Loans Corporation</b> as payment for our <b>loan</b> amortization;
														</li>
														<li>
															Remit the loan amortization based on the schedule of amortization as stated in the <b class="text-underlined">Promissory Note</b>;
														</li>
														<li>
															That we, the borrowers shall pay our obligation promptly according to the schedule;
														</li>
														<li>
															That <b>Micro Access Loans Corporation</b> shall release the proceeds of the loan to the applicant upon issuance and delivery of the checks in favor of <b>MAC</b>. to cover the amortization of the loan to <b>Micro Access Loans Corporation;</b>
														</li>
														<li>
															That we, the borrowers may verify our remaining <b>loan</b> balance with <b>Micro Access Loans Corporation</b> to ensure payment of our amortization;
														</li>
														<li>
															That we bind ourselves jointly and severally liable (act as surety) to <b>Micro Access Loans Corporation</b> in the event the check issued to <b>Micro Access Loans Corporation</b> may bounced, and
														</li>
														<li>
															That I/We understand the contents of this document, and hereby voluntarily and willingly affix our signature below.
														</li>
													</ol>

													<p class="mb-24">
														<b>IN WITNESS WHEREOF</b>, the parties hereunto signed this instrument on this ________day of ____________ at ___________________ Butuan City, Philippines.
													</p>

													<div class="d-flex justify-content-center mb-24">
														<div class="flex-1 text-center">
															<b class="allcaps text-block">{{fullName(borrower.firstname,borrower.middlename,borrower.lastname)}}</b>
															<span>Name and Signature of Borrower</span>
														</div>
														<div class="flex-1 text-center">
															<b class="allcaps text-block">{{loanDetails.co_borrower_name}} </b>
															<span> Name and Signature of Co-Borrower</span>
														</div>
													</div>

													<div class="d-flex justify-content-center mb-24">
														<div class="flex-1 text-center">
															<b class="allcaps text-block">{{fullName(borrower.spouse_firstname,borrower.spouse_middlename,borrower.spouse_lastname)}} </b>
															<span>Name and Signature of Marital Consent</span>
														</div>
														<div class="flex-1 text-center">
															<b class="allcaps text-block">{{loanDetails.co_maker_name}} </b>
															<span> Name and Signature of Co-Maker</span>
														</div>
													</div>

													<center class="mb-16">SIGNED IN THE PRESENCE OF:</center>

													<div class="d-flex justify-content-center mb-24">
														<div class="flex-1 text-center">
															<b class="allcaps text-block">{{staff}}</b>
														</div>
														<div class="flex-1 text-center">
															<b class="allcaps text-block">{{branch_mgr}}</b>
														</div>
													</div>

													<center class="mb-16">ACKNOWLEDGMENT</center>

													<span class="text-block">REPUBLIC OF THE PHILIPPINES)</span>
													<span class="text-block mb-24">City of Butuan			) S.S</span>

													<p class="mb-24">BEFORE ME, a Notary Public for and in the above jurisdiction, personally appeared:</p>

													<div class="d-flex mb-24">
														<span class="flex-2 mr-45">Name</span>
														<span class="flex-1 mr-45">CTC/ID No.</span>
														<span class="flex-3 mr-45">Issued at</span>
														<span class="flex-1">issued on</span>
													</div>

													<div class="d-flex flex-column mb-24">
														<div class="d-flex mb-24">
															<div class="flex-2 bb-black-1 mr-45"></div>
															<div class="flex-1 bb-black-1 mr-45"></div>
															<div class="flex-3 bb-black-1 mr-45"></div>
															<div class="flex-1 bb-black-1"></div>
														</div>
														<div class="d-flex mb-24">
															<div class="flex-2 bb-black-1 mr-45"></div>
															<div class="flex-1 bb-black-1 mr-45"></div>
															<div class="flex-3 bb-black-1 mr-45"></div>
															<div class="flex-1 bb-black-1"></div>
														</div>
														<div class="d-flex mb-24">
															<div class="flex-2 bb-black-1 mr-45"></div>
															<div class="flex-1 bb-black-1 mr-45"></div>
															<div class="flex-3 bb-black-1 mr-45"></div>
															<div class="flex-1 bb-black-1"></div>
														</div>
														<div class="d-flex">
															<div class="flex-2 bb-black-1 mr-45"></div>
															<div class="flex-1 bb-black-1 mr-45"></div>
															<div class="flex-3 bb-black-1 mr-45"></div>
															<div class="flex-1 bb-black-1"></div>
														</div>
													</div>

													<p class="mb-24">
														Known to me and to me known to be the same person who executed the foregoing MOA on which  the Acknowledgement is  written signed by the parties and their instrumental witnesses on each and every hereof, and the parties have acknowledged to me that the same is their free and voluntary act and deed, as well as those of the parties which they respectively present.

													</p>

													<p class="mb-24">
														WITNESS MY HAND AND SEAL on this  ________ day of ___________ at the place first written above.
													</p>

													<div class="d-flex align-items-end mb-24">
														<div class="d-flex flex-column mb-24 flex-3">
															<span>Doc. No.___________</span>
															<span>Page No.___________</span>
															<span>Book No.___________</span>
															<span>Series of___________</span>
														</div>
													</div>

												</section>
												<div class="d-flex mb-24">
													<img :src="baseURL() + 'img/logo-footer.png'" class="w-100 page-footer" alt="">
												</div>
												<div class="mb-72"></div>
												<div class="d-flex flex-row-reverse mb-45 no-print">
													<button id="cancelDacionModal" data-dismiss="modal" class="btn btn-danger min-w-150 mr-24 hide">Cancel</button>
													<button @click="printMoa()" class="btn btn-default min-w-150">Print</button>
													<!-- <button  @click.prevent="export2Word('moa-for-sme', 'memorandum_of_agreement')" id="excelBtn" class="btn btn-success min-w-150 mr-24">Download Document</button> -->
												</div>
											</div>
										</div>



										<div  class="tab-pane fade" id="sme-schedule" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
											<img :src="baseUrl+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
											<div class="d-flex flex-column font-md" style="padding:0 35px;">

												<div class="d-flex flex-column title align-items-center mb-24">
													<span class="font-26 text-bold text-primary-dark lh-1">SME SCHEDULE</span>
												</div>
												<section class="font-md mb-45">
													<div class="d-flex flex-column mb-36">
														<span>Loan Account Number : <b>{{loanDetails.account_num}}</b></span>
														<span>Loan Status : <b>{{loanDetails.status}}</b></span>
														<span>Customer Number : <b>{{borrower.borrower_num}}</b></span>
														<span>Account Name : <b>{{fullName(borrower.firstname,borrower.middlename,borrower.lastname)}}</b></span>
														<span>Address : <b>{{borrower.address}}</b></span>
													</div>
													<table class="table table-bordered table-thin">
														<thead>
															<th>AMORT NO.</th>
															<th>DATE</th>
															<th>PRINCIPAL</th>
															<th>INTEREST</th>
															<th>TOTAL</th>
															<th>BALANCE</th>
														</thead>
														<tbody>
															<tr v-for="(sched, i) in amortizationSched" :key="i">
																<td>{{i+1}}</td>
																<td>{{dateToYMD(new Date(sched.amortization_date)).split('/').join('')}}</td>
																<td>{{sched.principal}}</td>
																<td>{{sched.interest}}</td>
																<td>{{sched.total}}</td>
																<td>{{sched.principal_balance}}</td>
															</tr>
															<tr class="dark-bt bg-very-light">
																<td colspan="2"><b>TOTAL</b></td>
																<td><b>{{formatToCurrency(totalPrincipal)}}</b></td>
																<td><b>{{formatToCurrency(totalInterest)}}</b></td>
																<td><b>{{formatToCurrency(totalPayable)}}</b></td>
																<td></td>
															</tr>
														</tbody>
													</table>
												</section>
												<div class="d-flex mb-24">
													<img :src="baseURL() + 'img/logo-footer.png'" class="w-100 page-footer" alt="">
												</div>
												<div class="mb-72"></div>
												<div class="d-flex flex-row-reverse mb-45 no-print">
													<button id="cancelDacionModal" data-dismiss="modal" class="btn btn-danger min-w-150 mr-24 hide">Cancel</button>
													<button @click="printSchedule()" class="btn btn-default min-w-150">Print</button>
													<!-- <button @click.prevent="export2Word('sme-schedule', 'sme_schedule')" id="excelBtn" class="btn btn-success min-w-150 mr-24">Download Document</button> -->
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
														<span class="text-center text-primary-dark font-20">{{loanDetails.documents.promissory_number}}</span>
													</div>
													<div class="flex-1 d-flex justify-content-end pr-10">
														<span class=" mr-10">{{dateFullDay(new Date())}} {{dateToYMD(new Date()).split('-').join('/')}}</span>
														<span class="">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
													</div>
												</div>
												<section>
													<p class="font-md">
														I/We {{borrower.lastname + ', ' + borrower.firstname + ' ' + borrower.middlename.charAt(0) + '.'}} borrowed and received the amount of <span class="allcaps">{{numToWords(loanDetails.loan_amount)}} PESOS</span> (P {{formatToCurrency(loanDetails.loan_amount)}}) and promise to pay jointly and severally (solidarily) to the MICRO ACCESS LOANS CORPORATION until full payment of the said amount including interest rate of ( {{formatToCurrency(loanDetails.interest_rate)}}% ) per month. And with the following terms and conditions stated below:
													</p>
												</section>
												<span class="bbt-8 py-7 text-center text-20 text-bold mb-16">TERMS AND CONDITIONS</span>
												<section class="mb-24" style="font-size:16px!important;line-height:1.3em!important">
													<div class="d-flex flex-row">
														<div class="d-flex flex-column flex-1 font-md">
															<div class="d-flex flex-row">
																<div class="d-flex flex-row flex-1 justify-content-between pr-24">
																	<span class="">Interest Rate</span>
																	<span>:</span>
																</div>
																<span class="flex-2">{{formatToCurrency(loanDetails.interest_rate)}}%</span>
															</div>

															<div class="d-flex flex-row">
																<div class="d-flex flex-row flex-1 justify-content-between pr-24">
																	<span class="">Term (No. of days)</span>
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
																<span class="flex-2 darker-bb">{{dueDate.split('-').join('/')}}</span>
															</div>

															<div class="d-flex flex-row">
																<div class="d-flex flex-row flex-1 justify-content-between pr-24">
																	<span class="">Product</span>
																	<span>:</span>
																</div>
																<span class="flex-2">{{productName}}</span>
															</div>
														</div>
													</div>
												</section>
												<span class="bbt-8 py-7 text-center text-20 text-bold mb-16">OTHER CONDITIONS</span>
												<section class="font-md mb-24" style="font-size:16px!important;line-height:1.3em!important">
													<p style="line-height:1.8" class="mb-36">
														In case of default, this note will be due and demandable without further demand, and an additional fee of (2%) per missed payment of the scheduled amortization as penalty, And in case this note be given to hands of an attorney an additional charged of (10%) of the total amount due will be charged as attorney's fee, further, the borrower is liable to litigation expenses, damages, etc. should the failure on the part of the borrower reach the courts. In cases that the borrower/s changes address/ transfer of residence without notice to MICRO ACCESS LOANS CORPORATION in writing, the address indicated in this note shall be the address for purposes of delivery of notices and other matters pertaining to the loan. Shall any issue/case that may arise as a result of this promissory note on any document in relation hereto, venue shall be at the civil courts of Butuan City, Agusan del Norte, to the exclusion of other court or at the option of MICRO ACCESS LOANS CORPORATION The Borrower/s hereby authorized the MICRO ACCESS LOANS CORPORATION to assign, sell or otherwise negotiate this note with any financial institution on its face value. Done this ________ day of __________.
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
												<span class="bbt-8 py-7 text-center text-20 text-bold mb-16">COMAKER STATEMENT</span>
												<section class="font-md mb-24" style="font-size:16px!important;line-height:1.3em!important">
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
												<span class="bbt-8 py-7 text-center text-20 text-bold mb-16">ACKNOWLEDGEMENT</span>
												<section class="font-md" style="font-size:16px!important;line-height:1.3em!important">
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
												<div class="d-flex mb-24">
													<img :src="baseURL() + 'img/logo-footer.png'" class="w-100 page-footer" alt="">
												</div>
												<div class="mb-72"></div>
												<div class="d-flex flex-row-reverse mb-45 no-print">
													<a @click.prevent="printPromissory()" href="#" class="btn btn-default min-w-150">Print</a>
													<!-- <a href="#" @click.prevent="export2Word('promissory-note', 'promissory_note')" class="btn btn-success min-w-150 mr-24">Download Document</a> -->
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
		</div>
		<day-ended v-else></day-ended>
		<div class="modal" id="zeroModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-md" role="document">
				<div class="modal-content">
					<div class="modal-body p-24">
						<div class="d-flex align-items-center">
							<img :src="baseURL()+'/img/warning.png'" style="width:120px;height:auto;" class="mr-24" alt="warning icon">
							<div class="d-flex flex-column">
								<span class="text-primary-dark text-bold mb-24">
									Cannot proceed if the net amount is less than zero.
								</span>
								<div class="d-flex mt-auto justify-content-end">
									<a href="#" data-dismiss="modal" class="btn btn-danger min-w-120 pull-right">Close</a>
									<!-- <a @click.prevent="saveInfo=1" href="#" data-dismiss="modal" class="btn btn-primary-dark min-w-120">OK</a> -->
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
		props:['token', 'idtype','rejectid','title', 'releasetype', 'pbranch', 'staff', 'branch_mgr'],
		data(){
			return {
				resetAllVal:false,
				loading:false,
				transactionDate: {
					branch_id: this.pbranch,
					status: 'closed',
					date_end: '',
				},
				rejectedAccounts:[],
				rejectedAccount:{
					borrower:{
						borrower_id:null,
						employmentInfo : [],
						businessInfo : [],
						householdMembers : [],
						outstandingObligations : [],
						loanAccounts:[],
					}
				},
				clearData:{
					borrower:0
				},
				activeTab:'reminder-letter-tab',
				borrowerBirthdate:'',
				saveInfo:'',
				saveLoanDetails:false,
				bborrower:{borrower_id:'', borrower_num:''},
				borrower:{
					borrower_id: null,
					date_registered: this.dateToYMD(new Date()),
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
					loanAccounts:[],
				},
				baseUrl: this.baseURL(),
				borrowers:[],
				loanDetails: {
					loan_account_id:null,
					cycle_no : 1,
					ao_id : '',
					product_id : '',
					center_id : '',
					type : '',
					payment_mode : '',
					terms : 0,
					loan_amount : 0,
					no_of_installment : '',
					day_schedule : '',
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
					documents: {
						date_release: this.dateToYMD(new Date),
						description: '',
						bank: '',
						account_no: '',
						card_no:'',
						promissory_number: '',
					},
					branch:{
						branch_id:null
					},
					product:{
						product_name:'',
					}
				},
				products:[],
				amortizationSched:[],
				dueDate:'',
				branch:{
					branch_id:null
				},
				copyCB:false,
			}
		},
		methods: {
			resetAll:function(){
				this.resetBorrower();
				this.resetLoanDetails();
				this.resetAllVal = true;
			},
			fetchTransactionDate:function(){
				axios.get(this.baseURL() + 'api/eod/eodtransaction/'+this.pbranch, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.transactionDate = response.data.data;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
			selectAccount:function(data){
				this.fetchBorrower(data);
			},
			fetchBorrowerInfo:function(borrower){
				this.loading = true;
				axios.get(this.baseURL() + 'api/borrower/' + borrower, {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.borrower = response.data.data;
					this.loading = false;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
					this.loading = false;
				}.bind(this));
			},
			fetchBorrower:function(borrower){
				axios.get(this.baseURL() + 'api/borrower/' + borrower.borrower.borrower_id, {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					console.log(response.data.data);
					borrower.borrower = response.data.data;
					borrower.documents = borrower.document;
					this.rejectedAccount = borrower;
					this.borrower = borrower.borrower;
					this.loanDetails = borrower;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
			fetchRejectedAccounts:function(){

				axios.get(this.baseURL() + 'api/account/rejected/' + this.pbranch, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					// this.rejectedAccounts = response.data.data;
					response.data.data.map(function(data){
						if(data.loan_account_id == this.rejectid){
							// console.log(data.loan_account_id);
							this.rejectedAccounts.push(data);
						}
					}.bind(this));
					// console.log(response.data.data);
					// this.setAccount;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
			fetchRejectedAccount:function(){
				axios.get(this.baseURL() + 'api/account/show/' + this.rejectid, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.fetchBorrower(response.data.data);
					// console.log(response.data.data);
					// this.rejectedAccount = response.data.data;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
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
					if(this.amortizationSched.length > 0){
						this.dueDate = this.amortizationSched[this.amortizationSched.length-1].amortization_date;
					}
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
			fetchProducts: function(){
				axios.get(this.baseURL() + 'api/products/activeProducts', {
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
			fetchBorrowers:function(unload){
				this.loading=true;
				axios.get(this.baseURL() + 'api/borrower/list/' + this.branch, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.borrowers = response.data.data;
					if(!unload){
						this.loading = false;
					}
				}.bind(this))
				.catch(function (error) {
					console.log(error);
					if(!unload){
						this.loading = false;
					}
				}.bind(this));
			},
			fetchLoanAccounts:function(){
				axios.get(this.baseURL() + 'transaction/release_entry/loanaccounts?borrower=' + this.borrower.borrower_id)
				.then(function (response) {
					this.borrower.loan_accounts = response.data;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
			resetBorrower:function(){
				this.borrower = {
					borrower_id: null,
					date_registered: this.transactionDate.date_end,
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
					loanAccounts:[],
				};
			},

			navigate:function(tab){
				document.getElementById(tab).click();
			},

			updateLoanDetails:function(data){
				this.loanDetails = data;
			},
			savedInfo:function(data){
				this.fetchBorrowers(1);
				this.bborrower = data;
				this.saveLoanDetails = true;
				this.navigate('custom-content-below-borrowerinfo-tab');
			},
			nextBorrower:function(data){
				this.borrowerBirthdate = data;
				if(this.borrower.status == 'married'){
					this.copyCB = true;
				}
			},
			selected:function(id){
				if(id==this.loanDetails.loan_account_id){
					return 'active';
				}
				return '';
			},

			resetLoanDetails:function(){
				this.loanDetails = {
					loan_account_id:null,
					cycle_no : 1,
					ao_id : '',
					product_id : '',
					center_id : '',
					type : '',
					payment_mode : '',
					terms : 0,
					loan_amount : 0,
					no_of_installment : '',
					day_schedule : '',
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
					interest_rate:null,
					interest_amount:'',
					transaction_date: this.transactionDate.date_end,
					documents: {
						date_release: this.transactionDate.date_end,
						description: '',
						bank: '',
						account_no: '',
						card_no:'',
						promissory_number: '',
					},
					branch:{
						branch_id:this.pbranch,
					},
					product:{
						product_name:'',
					}

				}
			},
			setCycle:function(){
				this.loanDetails.cycle_no = this.loanDetails.loan_account_id ? this.loanDetails.cycle_no : parseInt(this.borrower.loan_accounts.length + 1);
			},
			selectBorrower:function(borrower){
				this.fetchBorrowerInfo(borrower);
				// if(this.borrower.borrower_id && this.borrower.borrower_id != borrower){
				// 	this.fetchBorrower(borrower);
				// 	// this.borrowers.map(function(data){
				// 	// 	if(borrower == data.borrower_id){
				// 	// 		this.borrower = data;
				// 	// 		this.resetLoanDetails();
				// 	// 		this.navigate('custom-content-below-borrowerinfo-tab');
				// 	// 		this.setCycle();
				// 	// 	}
				// 	// }.bind(this));
				// }
			},

			print:function(){
				var content = document.getElementById('dacion-en-pago').innerHTML;
				var target = document.querySelector('.to-print');
				target.innerHTML = content;
				var cancelButton = document.getElementById('cancelDacionModal');
				cancelButton.click();
				window.print();
			},
			printPromissory:function(){
				var content = document.getElementById('promissory-note').innerHTML;
				var target = document.querySelector('.to-print');
				target.innerHTML = content;
				var cancelButton = document.getElementById('cancelDacionModal');
				cancelButton.click();
				window.print();
			},
			printReminder:function(){
				var content = document.getElementById('reminder-letter').innerHTML;
				var target = document.querySelector('.to-print');
				target.innerHTML = content;
				var cancelButton = document.getElementById('cancelDacionModal');
				cancelButton.click();
				window.print();
			},
			downloadReminder:function(){
				var content = document.getElementById('reminder-letter').innerHTML;
				this.export2Word('reminder-letter');
			},
			printDoa:function(){
				var content = document.getElementById('doa-for-atm').innerHTML;
				var target = document.querySelector('.to-print');
				target.innerHTML = content;
				var cancelButton = document.getElementById('cancelDacionModal');
				cancelButton.click();
				window.print();
			},
			printMoa:function(){
				var content = document.getElementById('moa-for-sme').innerHTML;
				var target = document.querySelector('.to-print');
				target.innerHTML = content;
				var cancelButton = document.getElementById('cancelDacionModal');
				cancelButton.click();
				window.print();
			},
			printSchedule:function(){
				var content = document.getElementById('sme-schedule').innerHTML;
				var target = document.querySelector('.to-print');
				target.innerHTML = content;
				var cancelButton = document.getElementById('cancelDacionModal');
				cancelButton.click();
				window.print();
			},
			say(say){
				alert(say);
			},
			dacionDate:function(){
				var text = '';
				text += this.nthDay(this.dateToD(new Date)) + ' day of ';
				text += this.dateToFullMonth(new Date) + ' ';
				text += this.dateToY(new Date);
				return text;
			},
			switchTab:function(tab){
				this.activeTab = tab;
				document.getElementById(tab).click();
			},
			export2Word:function(element, filename = ''){
				var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
				var postHtml = "</body></html>";
				var html = preHtml+document.getElementById(element).innerHTML+postHtml;

				var blob = new Blob(['\ufeff', html], {
					type: 'application/msword'
				});

				// Specify link url
				var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);

				// Specify file name
				filename = filename?filename+'.doc':'document.doc';

				// Create download link element
				var downloadLink = document.createElement("a");

				document.body.appendChild(downloadLink);

				if(navigator.msSaveOrOpenBlob ){
					navigator.msSaveOrOpenBlob(blob, filename);
				}else{
					// Create a link to the file
					downloadLink.href = url;

					// Setting the file name
					downloadLink.download = filename;

					//triggering the function
					downloadLink.click();
				}

				document.body.removeChild(downloadLink);
			},
		},
		computed:{
			idType:function(){
				return JSON.parse(this.idtype);
			},
			productName:function(){
				var result = '';
				this.products.map(function(product){
					if(product.product_id==this.loanDetails.product_id){
						result = product.product_name;
					}
				}.bind(this));
				return result;
			},
			pendingLoanAccounts:function(){
				var accounts = [];
				if(this.borrower.loan_accounts){
					this.borrower.loan_accounts.map(function(account){
						if(account.status == 'released' && account.remainingBalance.memo.balance > 0){
							accounts.push(account);
						}
					}.bind(this));
				}
				return accounts;
			},
			amortAmount:function(){
				if(this.amortizationSched.length > 0){
					return this.amortizationSched[0].principal;
				}
				return 0;
			},
			totalPrincipal:function(){
				var amount = 0;
				this.amortizationSched.map(function(sched){
					amount += parseFloat(this.formatToAmount(sched.principal));
				}.bind(this));
				return amount;
			},
			totalInterest:function(){
				var amount = 0;
				this.amortizationSched.map(function(sched){
					amount += parseFloat(this.formatToAmount(sched.interest));
				}.bind(this));
				return amount;
			},
			totalPayable:function(){
				return this.totalPrincipal + this.totalInterest;
			},
			amortAmountSingle:function(){
				return ((parseInt(this.loanDetails.loan_amount) + parseInt(this.loanDetails.interest_amount)) / parseInt(this.numberOfInstallment)).toFixed(1);
			},
			numberOfInstallment:function(){
				let mode = this.loanDetails.terms;
				let result = 0;
				if(this.loanDetails.payment_mode == 'Monthly'){
					mode = 30;
					result = Math.ceil((this.loanDetails.terms / mode))
				}else if(this.loanDetails.payment_mode == 'Bi-Monthly'){
					mode = 15;
					result = Math.ceil((this.loanDetails.terms / mode))
				}else if(this.loanDetails.payment_mode == 'Weekly'){
					mode = 30;
					result = Math.ceil((this.loanDetails.terms / mode)*4);
				}else{
					mode = this.loanDetails.terms
					result = Math.ceil((this.loanDetails.terms / mode))
				}
				this.loanDetails.no_of_installment = result;
				return result;
			},
		},
		watch:{
			'loanDetails.loan_account_id':function(newValue){
				newValue? this.amortSched():[];
			},
			'pbranch':function(newValue){
				this.branch = JSON.parse(newValue);
			}
		},
        mounted() {
			this.branch = JSON.parse(this.pbranch);
			this.fetchTransactionDate();
			this.fetchBorrowers();
			this.resetBorrower();
			this.resetLoanDetails();
			this.fetchProducts();
			if(this.rejectid){
				this.fetchRejectedAccounts();
				this.fetchRejectedAccount();
			}
			// this.navigate('custom-content-below-loandetails-tab');
			// this.navigate('custom-content-below-coborrowerinfo-tab');
        }
    }
</script>
<style lang="scss" scoped>
	.existing-loans.active {
		background-color: #78e08f;
	}
</style>
