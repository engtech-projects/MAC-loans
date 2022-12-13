<template>
	<section>
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
								<div v-if="statement" @click="switchTab('first-letter-tab')" class="pxy-25 light-bb hover-light" data-tab="" :class="isActive('first-letter-tab',activeTab)">
									<span class="text-20">First Letter</span>
								</div>
								<div v-if="statement" @click="switchTab('second-letter-tab')" class="pxy-25 light-bb hover-light" data-tab="" :class="isActive('second-letter-tab',activeTab)">
									<span class="text-20">Second Letter</span>
								</div>
								<div v-if="statement" @click="switchTab('final-demand-tab')" class="pxy-25 light-bb hover-light" data-tab="" :class="isActive('final-demand-tab',activeTab)">
									<span class="text-20">Final Demand</span>
								</div>
								<div v-if="statement" @click="switchTab('final-notice-tab')" class="pxy-25 light-bb hover-light" data-tab="" :class="isActive('final-notice-tab',activeTab)">
									<span class="text-20">Final Notice</span>
								</div>
								<div v-if="statement" @click="switchTab('return-check-tab')" class="pxy-25 light-bb hover-light" data-tab="" :class="isActive('return-check-tab',activeTab)">
									<span class="text-20">Return Check</span>
								</div>
								<div v-if="statement" @click="switchTab('bouncing-check-tab')" class="pxy-25 light-bb hover-light" data-tab="" :class="isActive('bouncing-check-tab',activeTab)">
									<span class="text-20">Bouncing Check</span>
								</div>
								<div v-if="statement" @click="switchTab('attorneys-demand-tab')" class="pxy-25 light-bb hover-light" data-tab="" :class="isActive('attorneys-demand-tab',activeTab)">
									<span class="text-20">Attorney's Demand</span>
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
								<div v-if="!statement" @click="switchTab('sme-schedule-tab')" class="pxy-25 light-bb hover-light" :class="isActive('sme-schedule-tab',activeTab)" data-tab="">
									<span class="text-20">SME Schedule</span>
								</div>
								<div v-if="!statement" @click="switchTab('promissory-note-tab')" class="pxy-25 hover-light" :class="isActive('promissory-note-tab',activeTab)" data-tab="promissory-note-tab">
									<span class="text-20">Promissory Note</span>
								</div>
							</div>
							<div style="flex:6">
								<ul class="nav nav-tabs hide" id="custom-content-below-tab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="reminder-letter-tab" data-toggle="pill" href="#reminder-letter" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Reminder Letter</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="first-letter-tab" data-toggle="pill" href="#first-letter" role="tab" aria-controls="custom-content-below-home" aria-selected="true">First Letter</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="second-letter-tab" data-toggle="pill" href="#second-letter" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Second Letter</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="final-demand-tab" data-toggle="pill" href="#final-demand" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Final Demand</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="final-notice-tab" data-toggle="pill" href="#final-notice" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Final Demand</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="return-check-tab" data-toggle="pill" href="#return-check" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Final Demand</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="bouncing-check-tab" data-toggle="pill" href="#bouncing-check" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Final Demand</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="attorneys-demand-tab" data-toggle="pill" href="#attorneys-demand" role="tab" aria-controls="custom-content-below-home" aria-selected="true">Final Demand</a>
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
									<li>
										<li class="nav-item">
										<a class="nav-link" id="sme-schedule-tab" data-toggle="pill" href="#sme-schedule" role="tab" aria-controls="custom-content-below-home" aria-selected="true">SME Schedule</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="promissory-note-tab" data-toggle="pill" href="#promissory-note" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">Promissory Note</a>
									</li>
								</ul>
								<div class="tab-content" id="custom-content-below-tabContent">

									<div  class="tab-pane fade show active" id="reminder-letter" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
										<img :src="baseUrl+'/img/company_header.png'" style="width:100%" class="mb-45" alt="Company Header">
										<div class="d-flex flex-column font-md justify-content-between" style="padding:0 35px; min-height:420mm">
											<div>
												<div class="d-flex flex-column title align-items-start mb-24">
												<span class="font-26 lh-1">MGA PAHINUMDOM</span>
												</div>
												<section class="font-lg">
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
											</div>
											<div>
												<div class="d-flex mb-24">
													<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
												</div>
												<div class="mb-72"></div>
												<div class="d-flex flex-row-reverse mb-45 no-print">
													<button @click="printContent('reminder-letter')" class="btn btn-default min-w-150">Print</button>
													<!-- <button data-dismiss="modal" id="excelBtn" class="btn btn-success min-w-150 mr-24">Download Excel</button> -->
												</div>
											</div>

										</div>
									</div>

									<div  class="tab-pane fade" id="first-letter" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
										<img :src="this.baseURL()+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
										<div class="d-flex flex-column font-md" style="padding:0 35px;">

											<ul class="metadata base-list font-md mb-64">
												<li class="mb-16">{{dateToMDY(new Date)}}</li>
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
													As our valued client, building and preserving good relationship with you is what concerns us most. We want to provide quick access to loans and continuous credit line for your utmost convenience. For the continuation of your credit line and to further our relationship, we are closely monitoring your account.It has then come to our attention that your accunt is in delinquent status. The total delinquent amount has reached to Php {{formatToCurrency(loanDetails.remaining_balance.memo.balance)}}. Please take note that one of our agreement stated in your Loan Promissory Note No. {{loanDetails.documents.promissory_number}} dated {{dateToMDY(new Date(loanDetails.documents.date_release))}} that in case of default/delinquent, this promissory note will be due and demandable.
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
												<span>{{branch_mgr}}</span>
												<span>Branch Manager</span>
											</div>
											<div class="d-flex flex-row-reverse mb-72">
												<div class="d-flex flex-column">
													<span class="pb-36 darker-bb mb-10">Received by:</span>
													<span class="pr-24">(Signature over printed name)</span>
												</div>
											</div>
											<div class="d-flex flex-row-reverse mb-72 no-print">
												<a @click.prevent="printContent('first-letter')" href="#" class="btn btn-default min-w-150">Print</a>
												<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
											</div>
											<div class="d-flex mb-24">
												<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
											</div>
										</div>
									</div>

									<div  class="tab-pane fade" id="second-letter" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
										<img :src="this.baseURL()+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
										<div class="d-flex flex-column font-md" style="padding:0 35px;">

											<ul class="metadata base-list font-md mb-64">
												<li class="mb-16">{{dateToMDY(new Date)}}</li>
												<li>{{borrower.firstname + ' ' + borrower.lastname}}</li>
												<li>{{loanDetails.co_borrower_name}}</li>
												<li>{{loanDetails.co_maker_name}}</li>
												<li>{{borrower.address}}</li>
											</ul>

											<div class="d-flex flex-column title align-items-center mb-16">
												<span class="text-lg text-bold">NOTICE OF PAYMENT DELINQUENCY</span>
												<span class="text-lg">(SECOND NOTICE)</span>
											</div>
											<div class="salutation mb-24 d-flex flex-column">
												<span class="mb-45">Dear Sir/Madam :</span>
												<span>G r e e t i n g s!</span>
											</div>
											<div class="body mb-64">
												<p>
													As our valued client, building and preserving good relationship with you is what concerns us most. We want to provide quick access to loans and continuous credit line for your utmost convenience. For the continuation of your credit line and to further our relationship, we are closely monitoring your account.It has then come to our attention that your accunt is in delinquent status. The total delinquent amount has reached to Php {{formatToCurrency(loanDetails.remaining_balance.memo.balance)}}. Please take note that one of our agreement stated in your Loan Promissory Note No. {{loanDetails.documents.promissory_number}} dated {{dateToMDY(new Date(loanDetails.documents.date_release))}} that in case of default/delinquent, this promissory note will be due and demandable.
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
												<span>{{branch_mgr}}</span>
												<span>Branch Manager</span>
											</div>
											<div class="d-flex flex-row-reverse mb-72">
												<div class="d-flex flex-column">
													<span class="pb-36 darker-bb mb-10">Received by:</span>
													<span class="pr-24">(Signature over printed name)</span>
												</div>
											</div>
											<div class="d-flex flex-row-reverse mb-72 no-print">
												<a @click.prevent="printContent('second-letter')" href="#" class="btn btn-default min-w-150">Print</a>
												<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
											</div>
											<div class="d-flex mb-24">
												<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
											</div>
										</div>
									</div>


									<div  class="tab-pane fade" id="final-demand" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
										<img :src="this.baseURL()+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
										<div class="d-flex flex-column font-md" style="padding:0 35px;">

											<ul class="metadata base-list font-md mb-64">
												<li class="mb-16">{{dateToMDY(new Date)}}</li>
												<li>{{borrower.firstname + ' ' + borrower.lastname}}</li>
												<li>{{loanDetails.co_borrower_name}}</li>
											</ul>

											<div class="d-flex flex-column title align-items-center mb-16">
												<span class="text-lg text-bold">FINAL DEMAND</span>
											</div>
											<div class="salutation mb-24 d-flex flex-column">
												<span class="mb-45">Dear Sir/Madam :</span>
												<span>G r e e t i n g s!</span>
											</div>
											<div class="body mb-64">
												<p>
													Despite notice reminding you to settle your obligation in due time, it is very unfortunate that the same fell in deaf ears. Several days have passed and we do not hear movements or arrangements up to this date suggesting that you are willing to settle your loan obligation with this office.
												</p>
												<p>
													This office intends this letter as the last and final notice. We will initiate legal action as soon as possible should you fail to comply the possible terms of paying your loan obligation within Seven (7) days from receipt of this notice.
												</p>

												<p>Your outstanding loan obligation until of {{dateToMDY(new Date())}} is as follows:</p>

												<div class="d-flex flex-column mb-24">
													<div class="d-flex justify-content-between ps-75">
														<div class="flex-1 text-bold">Principal</div>
														<div class="flex-1 text-bold">PHP {{formatToCurrency(loanDetails.remaining_balance.principal.balance)}}</div>
													</div>
													<div class="d-flex justify-content-between ps-75">
														<div class="flex-1 text-bold">Current interest balance</div>
														<div class="flex-1 text-bold">PHP {{formatToCurrency(loanDetails.remaining_balance.interest.balance)}}</div>
													</div>
													<div class="d-flex justify-content-between ps-75">
														<div class="flex-1 text-bold">Past due interest</div>
														<div class="flex-1 text-bold">PHP {{formatToCurrency(loanDetails.remaining_balance.pdi.balance)}}</div>
													</div>
													<div class="d-flex justify-content-between ps-75">
														<div class="flex-1 text-bold">Penalties on past due loans</div>
														<div class="flex-1 text-bold">PHP {{formatToCurrency(0)}}</div>
													</div>
													<div class="d-flex justify-content-between ps-75">
														<div class="flex-1 text-bold">On late amortization</div>
														<div class="flex-1 text-bold">PHP {{formatToCurrency(loanDetails.remaining_balance.penalty.balance)}}</div>
													</div>
													<div class="d-flex justify-content-between ps-75">
														<div class="flex-1 text-bold"></div>
														<div class="flex-1 text-bold">-----------------------------</div>
													</div>
													<div class="d-flex justify-content-between ps-75">
														<div class="flex-1 text-bold">Total Amount Due</div>
														<div class="flex-1 text-bold">PHP {{formatToCurrency(loanDetails.remaining_balance.principal.balance + loanDetails.remaining_balance.interest.balance + loanDetails.remaining_balance.pdi.balance + loanDetails.remaining_balance.penalty.balance )}}</div>
													</div>
												</div>

												<p class="mb-16">Please give this letter your utmost concern to avoid complications in the future.
													Trusting that you will see your way through. Thank you very much.
												</p>

												<p>(Disregard this notice if payment/s has been made.)</p>

											</div>
											<div class="truly-yours d-flex flex-column mb-64">
												<span class="mb-36">Very truly yours,</span>
												<span>Mark Anthony M. Chavez</span>
												<span>President and CEO</span>
											</div>
											<div class="d-flex flex-row-reverse mb-72">
												<div class="d-flex flex-column">
													<span class="pb-36 darker-bb mb-10">.</span>
													<span class="pr-24">(Date)</span>
												</div>
												<div class="d-flex flex-column mr-10">
													<span class="pb-36 darker-bb mb-10">Received by:</span>
													<span class="pr-24">(Signature over printed name)</span>
												</div>
											</div>
											<div class="d-flex flex-row-reverse mb-72 no-print">
												<a @click.prevent="printContent('final-demand')" href="#" class="btn btn-default min-w-150">Print</a>
												<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
											</div>
											<div class="d-flex mb-24">
												<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
											</div>
										</div>
									</div>


									<div  class="tab-pane fade" id="final-notice" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
										<img :src="this.baseURL()+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
										<div class="d-flex flex-column font-md" style="padding:0 35px;">

											<ul class="metadata base-list font-md mb-64">
												<li class="mb-16">{{dateToMDY(new Date)}}</li>
												<li>{{borrower.firstname + ' ' + borrower.lastname}}</li>
												<li>{{borrower.address}}</li>
											</ul>

											<div class="d-flex flex-column title align-items-center mb-16">
												<span class="text-lg text-bold">FINAL NOTICE</span>
											</div>
											<div class="salutation mb-24 d-flex flex-column">
												<span class="mb-45">Dear Sir/Madam :</span>
											</div>
											<div class="body mb-64">
												<p>
													My client,   MICRO ACCESS LOANS CORPORATION   has referred to me your
     												long overdue account for legal action.
												</p>
												<p>
													It appears from the records with particular reference to a Promissory
													Note dated {{dateToMDY(new Date(loanDetails.documents.date_release))}}. Since then your  account has  been  place  under
													past due status  incurring  pastdue  interest,  penalties  and  other
													charges. As of today your total outstanding liabilities are indicated
													Below to wit:
												</p>

												<div class="d-flex">
													<div class="flex-1"></div>
													<div class="d-flex flex-column mb-24 flex-3">
														<div class="d-flex justify-content-between">
															<div class="flex-1 text-bold d-flex">
																<b class="flex-2">Principal</b>
																<b class="flex-1">:</b>
															</div>
															<div class="flex-1 text-bold d-flex justify-content-between">
																<b class="flex-1">P</b>
																<b class="flex-1 text-right">{{formatToCurrency(loanDetails.remaining_balance.principal.balance)}}</b>
															</div>
														</div>
														<div class="d-flex justify-content-between">
															<div class="flex-1 text-bold d-flex">
																<b class="flex-2">Interest</b>
																<b class="flex-1">:</b>
															</div>
															<div class="flex-1 text-bold d-flex justify-content-between">
																<b class="flex-1">P</b>
																<b class="flex-1 text-right">{{formatToCurrency(loanDetails.remaining_balance.interest.balance)}}</b>
															</div>
														</div>
														<div class="d-flex justify-content-between">
															<div class="flex-1 text-bold d-flex">
																<b class="flex-2">Penalties</b>
																<b class="flex-1">:</b>
															</div>
															<div class="flex-1 text-bold d-flex justify-content-between">
																<b class="flex-1">P</b>
																<b class="flex-1 text-right">{{formatToCurrency(loanDetails.remaining_balance.penalty.balance + loanDetails.remaining_balance.pdi.balance)}}</b>
															</div>
														</div>
														<div class="d-flex justify-content-between">
															<div class="flex-1 text-bold d-flex">
																<b class="flex-2">Attorney's Fee</b>
																<b class="flex-1">:</b>
															</div>
															<div class="flex-1 text-bold d-flex justify-content-between">
																<b class="flex-1">P</b>
																<b class="flex-1 text-right">{{formatToCurrency(loanDetails.remaining_balance.memo.balance*.1)}}</b>
															</div>
														</div>
														<div class="d-flex justify-content-between">
															<div class="flex-1 text-bold d-flex">

															</div>
															<div class="flex-1 text-bold d-flex justify-content-between">
																<b class="flex-1"></b>
																<b class="flex-1 text-right">---------------------</b>
															</div>
														</div>
														<div class="d-flex justify-content-between">
															<div class="flex-1 text-bold d-flex">
																<b class="flex-2">TOTAL</b>
																<b class="flex-1">:</b>
															</div>
															<div class="flex-1 text-bold d-flex justify-content-between">
																<b class="flex-1">P</b>
																<b class="flex-1 text-right">{{formatToCurrency(loanDetails.remaining_balance.principal.balance + loanDetails.remaining_balance.interest.balance + loanDetails.remaining_balance.penalty.balance + loanDetails.remaining_balance.pdi.balance + (loanDetails.remaining_balance.memo.balance * 0.1) )}}</b>
															</div>
														</div>
													</div>
													<div class="flex-1"></div>
												</div>
												<p class="mb-16">Consider this as our FINAL DEMAND, within FIVE (5) days from receipt.
													Failure on your part to comply with my advice will constrain me, much
													to my regret, to proceed to the  filling of appropriate  legal action
													against  you  and  your co-makers  to  protect  the  interest  of  my
													client.
												</p>

												<p>Visit  the undersigned  counsel or to my  client office to effect the payment.</p>

											</div>
											<div class="truly-yours d-flex flex-column mb-64">
												<span class="mb-36">Very truly yours,</span>
												<span>ATTY. DENIS BACALA</span>
												<span>Legal Counsel</span>
											</div>
											<div class="d-flex mb-45">
												<span class="mr-5">COPY FURNISHED: </span>
												<div class="d-flex flex-column">
													<div class="flex-1 d-flex">
														<span class="mr-5">Co-Maker1: </span>
														<div><span class="text-block">{{loanDetails.co_maker_name}}</span><span>{{loanDetails.co_maker_address}}</span></div>
													</div>
													<div class="flex-1 d-flex">
														<span class="mr-5">Co-Maker2: </span>
														<div></div>
													</div>
												</div>
											</div>
											<p>
												NOTE: Please disregard if you have paid your account.<br>
     											Ref. No.: {{loanDetails.account_num}} Loan Amount: P    {{formatToCurrency(loanDetails.loan_amount)}} Term:  {{loanDetails.terms / 30}} month(s).
											</p>
											<!-- <div class="d-flex">
												<span></span>
												<span>Co-Maker2:  </span>
												<span>Cionevive C Lagahit</span>
											</div> -->
											<!-- <div class="d-flex flex-row-reverse mb-72">
												<div class="d-flex flex-column">
													<span class="pb-36 darker-bb mb-10">.</span>
													<span class="pr-24">(Date)</span>
												</div>
												<div class="d-flex flex-column mr-10">
													<span class="pb-36 darker-bb mb-10">Received by:</span>
													<span class="pr-24">(Signature over printed name)</span>
												</div>
											</div> -->
											<div class="d-flex flex-row-reverse mb-72 no-print">
												<a @click.prevent="printContent('final-notice')" href="#" class="btn btn-default min-w-150">Print</a>
												<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
											</div>
											<div class="d-flex mb-24">
												<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
											</div>
										</div>
									</div>


									<div  class="tab-pane fade" id="return-check" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
										<img :src="this.baseURL()+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
										<div class="d-flex flex-column font-md" style="padding:0 35px;">

											<ul class="metadata base-list font-md mb-64">
												<li class="mb-16">{{dateToMDY(new Date)}}</li>
												<li>{{borrower.firstname + ' ' + borrower.lastname}}</li>
												<li>{{borrower.address}}</li>
											</ul>

											<div class="d-flex flex-column title align-items-center mb-16">
												<span class="text-lg text-bold">RETURN CHECK NOTICE</span>
											</div>
											<div class="salutation mb-24 d-flex flex-column">
												<span class="mb-45">Dear Mr./Mrs. {{borrower.lastname}} :</span>
											</div>
											<div class="body mb-64">
												<p>
													Please take notice that the  following check(s) which you negotiated
													with  us was  returned unpaid  for the following reason(s) indicated
													below to wit:
												</p>
												<div class="d-flex mb-24">
													<div class="d-flex flex-column mr-24"><span>Check Date</span><span>/ /</span></div>
													<span class="mr-24">Check Number</span>
													<div class="d-flex flex-column mr-24"><span>Amount</span><span>0.00</span></div>
													<span class="mr-24">Reason</span>
												</div>


												<p class="mb-16">
													Kindly make good or redeem the said  returned check(s) with its Cash
													equivalent winthin  FIVE (5)  banking days from your receipt hereof,
													otherwise, we shall be shall constrained to refer this matter to our
													legal counsel for collection.
												</p>

												<p>
													To avoid  unnecessary  additional  expenses  and  dire consequences,
     												please give this matter your preferential attention
												</p>

											</div>
											<div class="truly-yours d-flex flex-column mb-64">
												<span class="mb-36">Very truly yours,</span>
												<span>ATTY. DENIS BACALA</span>
												<span>Legal Counsel</span>
											</div>
											<div class="d-flex mb-45">
												<span class="mr-5">COPY FURNISHED: </span>
												<div class="d-flex flex-column">
													<div class="flex-1 d-flex">
														<span class="mr-5">Co-Maker1: </span>
														<div><span class="text-block">{{loanDetails.co_maker_name}}</span><span>{{loanDetails.co_maker_address}}</span></div>
													</div>
													<div class="flex-1 d-flex">
														<span class="mr-5">Co-Maker2: </span>
														<div></div>
													</div>
												</div>
											</div>
											<div class="d-flex flex-row-reverse mb-72">
												<div class="d-flex flex-column">
													<span class="pb-36 darker-bb mb-10">Received by:</span>
													<span class="pr-24">(Signature over printed name)</span>
												</div>
											</div>
											<p>
												NOTE: Please disregard if you have paid your account.
     											Ref. No.: {{loanDetails.account_num}} Loan Amount: P    {{formatToCurrency(loanDetails.loan_amount)}} Term:  {{loanDetails.terms / 30}} month(s).
											</p>
											<div class="d-flex flex-row-reverse mb-72 no-print">
												<a @click.prevent="printContent('return-check')" href="#" class="btn btn-default min-w-150">Print</a>
												<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
											</div>
											<div class="d-flex mb-24">
												<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
											</div>
										</div>
									</div>


									<div  class="tab-pane fade" id="attorneys-demand" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
										<div class="d-flex flex-column font-md" style="padding:0 35px;">
											<div class="d-flex letter-head align-items-center mb-24">
												<img :src="baseURL() + 'img/lamigo_logo.png'" class="mr-16" style="max-height:140px" alt="">
												<div class="d-flex flex-column">
													<span style="font-weight:bold;font-size:48px;font-family:'Bookman Old Style';line-height:1">LAMIGO LAW OFFICE</span>
													<span style="font-size:24px">J. Satorre Street (City Hall Rotunda) Butuan City 8600</span>
													<span style="font-size:24px">Tel. No. (085) 817-13-74</span>
												</div>
											</div>
											<div class="d-flex bb-dashed-2 mb-3"></div>
											<div class="d-flex bb-dashed-2 mb-16"></div>

											<div class="d-flex flex-column mb-45">
												<span style="font-size:24px;font-weight:bold;">Attorney:</span>
												<span style="margin-left:75px;font-size:20px;">Atty: Kahlil L. Lamigo</span>
											</div>

											<div class="d-flex flex-column mb-45">
												<span style="text-decoration:underline;font-style:italic;" class="mb-24">{{dateToMDY(new Date)}}</span>
												<b>{{borrower.firstname + ' ' + borrower.lastname}}</b>
												<b>{{loanDetails.co_borrower_name}}</b>
												<b>{{loanDetails.co_maker_name}}</b>
												<b>{{borrower.address}}</b>
											</div>

											<b style="text-decoration:underline" class="mb-36">Dear <i>Sir/Madam</i></b>

											<p>
												Please be informed that our client,  Micro Access Loans Corporation has endorsed to us for appropriate legal action for your accountability amounting to <i class="text-underlined"><b>{{numToWords(loanDetails.remaining_balance.memo.balance)}} ( Php {{formatToCurrency(loanDetails.remaining_balance.memo.balance)}})</b></i> representing your total unpaid obligation to our said client as of
												<i class="text-underlined"><b>{{dateToMDY(new Date)}}</b></i>.
											</p>

											<p>
												According to our client, you have not settled the above-mentioned accountability despite the fact that it has been long overdue and despite repeated demands to fully settle it.
											</p>

											<p>
												Hence, it is hereby demanded that you fully pay your above accountability with cash at the office of our client Micro Access Loans Corporation T. Calo St., Limaha, Butuan City within seven (7) days from your receipt of this letter. Your failure to comply with this demand shall compel us to file the appropriate legal action against you with ten percent (10%) thereof as attorney’s fees plus penalties, damages and other expenses that may incurred.
											</p>

											<p class="mb-45">
												We hope you will give this matter your preferential attention to avoid the inconvenience, humiliation, embarrassment and expenses appurtenant thereto.
											</p>

											<p class="mb-72">
												Very truly yours,
											</p>

											<div class="d-flex flex-column mb-72">
												<span class="text-bold font-20 text-underlined">ATTY. KAHLIL L. LAMIGO</span>
												<i>Counsel for Micro Access Loans Corp</i>
											</div>

											<div class="d-flex flex-column mb-64">
												<span>Cc:</span>
												<span>Co-Borrower</span>
												<span>File for court action</span>
											</div>

											<div class="d-flex flex-row-reverse mb-72 no-print">
												<a @click.prevent="printContent('attorneys-demand')" href="#" class="btn btn-default min-w-150">Print</a>
												<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
											</div>
										</div>
									</div>


									<div  class="tab-pane fade" id="bouncing-check" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
										<img :src="this.baseURL()+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
										<div class="d-flex flex-column font-md" style="padding:0 35px;">

											<ul class="metadata base-list font-md mb-64">
												<li class="mb-16">{{dateToMDY(new Date)}}</li>
												<li>{{borrower.firstname + ' ' + borrower.lastname}}</li>
												<li>{{borrower.address}}</li>
											</ul>

											<div class="d-flex flex-column title align-items-center mb-16">
												<span class="text-lg text-bold">FINAL NOTICE</span>
											</div>
											<div class="salutation mb-24 d-flex flex-column">
												<span class="mb-45">Dear Mr./Mrs. {{borrower.lastname}} :</span>
											</div>
											<div class="body mb-64">
												<p>
													Consider this as our FINAL DEMAND, within  FIVE (5)  days from receipt
													hereof. Make good the check(s) you issued  with its cash equivalent in
													favor of   MICRO ACCESS LOANS CORPORATION   for following  transaction
													indicated below to wit:
												</p>
												<div class="d-flex mb-24">
													<div class="d-flex flex-column mr-24"><span>Check Date</span><span>/ /</span></div>
													<span class="mr-24">Check Number</span>
													<div class="d-flex flex-column mr-24"><span>Amount</span><span>0.00</span></div>
													<span class="mr-24">Reason</span>
												</div>

												<p class="mb-16">
													Otherwise,  we will commence and persistently  pursue, to its ultimate
													conclusion, the appropriate criminal cases with claim for damages, and
													forty (40) percent as Attorney's  fee.
												</p>

												<p>
													Cases  of these  nature  are  entirely  defenseless, Thus,  before the
													courts impose the corresponding penal sanctions and civil liabilities,
													it would  be wise to redeem the  worthless check(S) within  the period
													given.
												</p>

												<p>
													Visit  the undersigned  counsel or to my  client office to  effect the
     												payment.
												</p>

											</div>
											<div class="truly-yours d-flex flex-column mb-64">
												<span class="mb-36">Very truly yours,</span>
												<span>ATTY. DENIS BACALA</span>
												<span>Legal Counsel</span>
											</div>
											<div class="d-flex mb-45">
												<span class="mr-5">COPY FURNISHED: </span>
												<div class="d-flex flex-column">
													<div class="flex-1 d-flex">
														<span class="mr-5">Co-Maker1: </span>
														<div><span class="text-block">{{loanDetails.co_maker_name}}</span><span>{{loanDetails.co_maker_address}}</span></div>
													</div>
													<div class="flex-1 d-flex">
														<span class="mr-5">Co-Maker2: </span>
														<div></div>
													</div>
												</div>
											</div>
											<p>
												NOTE: Please disregard if you have paid your account.
     											Ref. No.: {{loanDetails.account_num}} Loan Amount: P    {{formatToCurrency(loanDetails.loan_amount)}} Term:  {{loanDetails.terms / 30}} month(s).
											</p>
											<div class="d-flex flex-row-reverse mb-72 no-print">
												<a @click.prevent="printContent('bouncing-check')" href="#" class="btn btn-default min-w-150">Print</a>
												<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
											</div>
											<div class="d-flex mb-24">
												<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
											</div>
										</div>
									</div>



									<div  class="tab-pane fade" id="dacion-en-pago" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
										<img :src="baseUrl+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
										<div class="d-flex flex-column font-md justify-content-between" style="padding:0 35px;min-height:420mm">
											<div>
												<div class="d-flex flex-column title align-items-center mb-24">
													<span class="font-26 text-bold text-primary-dark lh-1">DACION EN PAGO</span>
												</div>
												<section style="font-size:16px!important;line-height:1.4em">
													<span class="text-block mb-24">KNOW ALL MEN BY THESE PRESENTS:</span>
													<p>
														This INSTURMENT made and executed this _________ day of ___________  at Butuan City, Philippines, by and between: <span class="text-underlined allcaps text-bold">{{fullName(borrower.firstname, borrower.middlename,borrower.lastname)}}</span> single/married to <span class="text-underlined allcaps text-bold">{{fullName(borrower.spouse_firstname,borrower.spouse_middlename,borrower.spouse_lastname)}}</span> of legal age, Filipino citizen, and resident of <span class="text-underlined allcaps text-bold">{{borrower.address}}</span>  herein after called the <b>FIRST PARTY</b>;
													</p>
													<p>
														MAC LENDING a lending institution, duly registered under the laws of the Republic of the Philippines and with postal address at T. Calo Extension, Butuan City represented by its Branch Manager <b>{{branch_mgr}}</b> herein after called as the <b>SECOND PARTY</b>;
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
											</div>
											<div>
												<div class="d-flex mb-24">
													<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
												</div>
												<div class="mb-72"></div>
												<div class="d-flex flex-row-reverse mb-45 no-print">
													<button @click="printContent('dacion-en-pago')" class="btn btn-default min-w-150">Print</button>
													<!-- <button data-dismiss="modal" id="excelBtn" class="btn btn-success min-w-150 mr-24">Download Excel</button> -->
												</div>
											</div>
										</div>
									</div>



									<div  class="tab-pane fade" id="doa-for-atm" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
										<img :src="baseUrl+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
										<div class="d-flex flex-column font-md justify-content-between" style="padding:0 35px;min-height:420mm;">
											<div>
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
														<b> Micro Access Loans Corporation </b> a lending institution, duly registered under the laws of the Republic of the Philippines and with postal address at T. Calo St. Limaha , Butuan City represented by the Branch Manager <b> <u>{{branch_mgr}}  </u></b> hereinafter known as the <b> ASSIGNEE;</b>
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
															<b class="text-block">{{branch_mgr}}</b>
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
															<b class="flex-1">{{branch_mgr}}</b>
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
											</div>
											<div>
												<div class="d-flex mb-24">
													<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
												</div>
												<div class="mb-72"></div>
												<div class="d-flex flex-row-reverse mb-45 no-print">
													<button @click="printContent('doa-for-atm')" class="btn btn-default min-w-150">Print</button>
													<!-- <button data-dismiss="modal" id="excelBtn" class="btn btn-success min-w-150 mr-24">Download Excel</button> -->
												</div>
											</div>
										</div>
									</div>





									<div  class="tab-pane fade" id="moa-for-sme" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
										<img :src="baseUrl+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
										<div class="d-flex flex-column font-md justify-content-between" style="padding:0 35px;min-height:420mm;">
											<div>
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
											</div>
											<div>
												<div class="d-flex mb-24">
													<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
												</div>
												<div class="mb-72"></div>
												<div class="d-flex flex-row-reverse mb-45 no-print">
													<button @click="printContent('moa-for-sme')" class="btn btn-default min-w-150">Print</button>
													<!-- <button data-dismiss="modal" id="excelBtn" class="btn btn-success min-w-150 mr-24">Download Excel</button> -->
												</div>
											</div>
										</div>
									</div>



									<div  class="tab-pane fade" id="sme-schedule" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
										<img :src="baseUrl+'/img/company_header.png'" style="width:100%" class="mb-16" alt="Company Header">
										<div class="d-flex flex-column font-md justify-content-between" style="padding:0 35px;min-height:420mm;">
											<div>
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
																<!-- <td>{{sched.principal_balance}}</td> -->
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
											</div>
											<div>
												<div class="d-flex mb-24">
													<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
												</div>
												<div class="mb-72"></div>
												<div class="d-flex flex-row-reverse mb-45 no-print">
													<button id="cancelDacionModal" data-dismiss="modal" class="btn btn-danger min-w-150 mr-24 hide">Cancel</button>
													<button @click="printContent('sme-schedule')" class="btn btn-default min-w-150">Print</button>
													<!-- <button data-dismiss="modal" id="excelBtn" class="btn btn-success min-w-150 mr-24">Download Excel</button> -->
												</div>
											</div>
										</div>
									</div>



									<div class="tab-pane fade" id="promissory-note" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
										<img :src="baseUrl+'/img/company_header.png'" style="width:100%" class="mb-45" alt="Company Header">
										<div class="d-flex flex-column justify-content-between" style="padding:0 50px;min-height:420mm">
											<div>
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
												<span class="bbt-8 py-7 text-center text-block text-20 text-bold mb-16">TERMS AND CONDITIONS</span>
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
												<span class="bbt-8 py-7 text-center text-block text-20 text-bold mb-16">OTHER CONDITIONS</span>
												<section class="font-md mb-24" style="font-size:16px!important;line-height:1.3em!important">
													<p style="line-height:1.8" class="mb-36">
														In case of default, this note will be due and demandable without further demand, and an additional fee of (2%) per missed payment of the scheduled amortization as penalty, And in case this note be given to hands of an attorney an additional charged of (10%) of the total amount due will be charged as attorney's fee, further, the borrower is liable to litigation expenses, damages, etc. should the failure on the part of the borrower reach the courts. In cases that the borrower/s changes address/ transfer of residence without notice to MICRO ACCESS LOANS CORPORATION in writing, the address indicated in this note shall be the address for purposes of delivery of notices and other matters pertaining to the loan. Shall any issue/case that may arise as a result of this promissory note on any document in relation hereto, venue shall be at the civil courts of Butuan City, Agusan del Norte, to the exclusion of other court or at the option of MICRO ACCESS LOANS CORPORATION The Borrower/s hereby authorized the MICRO ACCESS LOANS CORPORATION to assign, sell or otherwise negotiate this note with any financial institution on its face value. Done this <b>{{nthDay(this.dateToD(new Date))}}</b> day of <b class="allcaps">{{this.dateToFullMonth(new Date)}}  {{this.dateToY(new Date)}}</b>.
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
												<span class="bbt-8 py-7 text-center text-block text-20 text-bold mb-16">ACKNOWLEDGEMENT</span>
												<section class="font-md" style="font-size:16px!important;line-height:1.3em!important">
													<div class= "mb-24">
														<span class="text-block">Republic of the Philippines</span>
														<span>Butuan City</span>
													</div>
													<p>
														SUBSCRIBE AND SWORN before me this _______, day of __________ </b> and tax identetification number written above,
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
													<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
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
					</div>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
export default {
	props:['ploanDetails', 'token', 'statement', 'staff', 'branch_mgr'],
	data(){
		return {
			activeTab:'reminder-letter-tab',
			baseUrl: this.baseURL(),
			loanDetails:{
				loan_amount:0,
				documents:{
					description:'',
				},
				current_amortization:{
					principal_balance:0,
				},
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
			},
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
			amortizationSched:[],
			dueDate:'',
			products:[],
		}
	},
	methods:{
		switchTab:function(tab){
			this.activeTab = tab;
			document.getElementById(tab).click();
		},
		dacionDate:function(){
			var text = '';
			text += this.nthDay(this.dateToD(new Date)) + ' day of ';
			text += this.dateToFullMonth(new Date) + ' ';
			text += this.dateToY(new Date);
			return text;
		},
		amortSched:function(){
			this.amortizationSched = [];
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
			axios.get(this.baseURL() + 'api/product', {
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
		printContent:function(printcontent){
			var content = document.getElementById(printcontent).innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			window.print();
		}
	},
	computed:{
		productName:function(){
			var result = '';
			this.products.map(function(product){
				if(product.product_id==this.loanDetails.product_id){
					result = product.product_name;
				}
			}.bind(this));
			return result;
		},
		amortAmountSingle:function(){
			return ((parseInt(this.loanDetails.loan_amount) + parseInt(this.loanDetails.interest_amount)) / parseInt(this.numberOfInstallment)).toFixed(1);
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

	},
	watch:{
		'loanDetails.loan_account_id':function(newValue){
			newValue? this.amortSched():[];
		},
		'ploanDetails':function(newValue){
			this.loanDetails = newValue;
			this.loanDetails.documents = newValue.document? newValue.document:this.loanDetails.documents;
			this.borrower = newValue.borrower;
		}
	},
	mounted(){
		this.loanDetails = this.ploanDetails;
		this.borrower = this.ploanDetails.borrower;
		this.fetchProducts();
	}
}
</script>
