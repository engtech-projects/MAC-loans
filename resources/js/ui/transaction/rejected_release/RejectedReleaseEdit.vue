<template>
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between">
			<h1 class="m-0 font-35">{{title}}</h1>
			<a href="#" @click.prevent="clearData.borrower=1;resetLoanDetails()" class="btn btn-primary-dark min-w-150">New Client</a>
		</div><!-- /.col -->
		<div class="d-flex flex-column flex-xl-row p-16">
				<div style="flex:9;">
					<client-list-side @selectAccount="selectAccount" :pborrowers="rejectedAccounts" :account="rejectedAccount.loan_account_id"></client-list-side>
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
							<rejected-borrowers-info @nextBorrower="nextBorrower" :pborrower="rejectedAccount.borrower"></rejected-borrowers-info>
						</div>


						<co-borrower :borrowers="borrowers" :loandetails="rejectedAccount" @nextCoborrower="nextCoborrower"></co-borrower>



						<div class="tab-pane fade" id="custom-content-below-loaddetails" role="tabpanel" aria-labelledby="custom-content-below-messages-tab">
							<rejected-loan-details @save="save" :token="token" :loandetails="rejectedAccount"></rejected-loan-details>
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
			
	</div>
</template>

<script>
    export default {
		props:['token', 'title', 'id'],
		data(){
			return {
				rejectedAccounts:[],
				baseUrl: this.baseURL(),
				rejectedAccount:{
					borrower:{
						borrower_id:null,
						employmentInfo : [],
						businessInfo : [],
						householdMembers : [],
						outstandingObligations : [],
						loanAccounts:[],
					}
				}
			}
		},
		methods: {
			fetchRejectedAccounts:function(){
				axios.get(this.baseURL() + 'api/account/rejected', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.rejectedAccounts = response.data.data;
					// console.log(response.data.data);
					// this.setAccount;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
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
					borrower.borrower = response.data.data;
					borrower.documents = borrower.document;
					this.rejectedAccount = borrower;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},

			fetchRejectedAccount:function(){
				axios.get(this.baseURL() + 'api/account/show/' + this.id, {
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
			
			navigate:function(tab){
				document.getElementById(tab).click();
			},
			
			nextCoborrower:function(data){
				this.rejectedAccount = data;
			},
			nextBorrower:function(data){
				this.rejectedAccount.borrower = data;
			},
			selected:function(id){
				if(id==this.loanDetails.loan_account_id){
					return 'active';
				}
				return '';
			},
			selectAccount:function(data){
				this.fetchBorrower(data);
			},
			resetLoanDetails:function(){
				this.rejectedAccount = {
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
					borrower:{
						borrower_id:null,
						employmentInfo : [],
						businessInfo : [],
						householdMembers : [],
						outstandingObligations : [],
						loanAccounts:[],
					},
					documents:{
						date_release: '',
						description: '',
						bank: '',
						account_no: '',
						card_no:'',
						promissory_number: '',
					}
				}
			},
			saveLoanDetails: function(){
				axios.put(this.baseURL() + 'api/account/update/' + this.rejectedAccount.loan_account_id, this.rejectedAccount, {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.notify('',response.data.message, 'success');
					window.location.replace(this.baseURL() + '/transaction/rejected_release');
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
			saveBorrower: function(){
				axios.put(this.baseURL() + 'api/borrower/' + this.rejectedAccount.borrower.borrower_id, this.rejectedAccount.borrower, {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.notify('',response.data.message, 'success');
					this.rejectedAccount.status = 'pending';
					this.saveLoanDetails();
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
			save:function(data){
				this.rejectedAccount = data;
				this.saveBorrower();
			},
				notify:function(title, text, type){
				this.$notify({
					group: 'foo',
					title: title,
					text: text,
					type: type,
				});
			},
		},
		computed:{
			borrowers:function(){
				var list = [];
				this.rejectedAccounts.map(function(data){
					list.push(data.borrower);
				}.bind(this));
				return list;
			},
			setAccount:function(){
				this.rejectedAccounts.map(function(data){
					if(this.id == data.loan_account_id){
						this.rejectedAccount = data;
					}
				}.bind(this));
			}
		},
        mounted() {	
			this.fetchRejectedAccount();
			this.fetchRejectedAccounts();
			this.resetLoanDetails();
        }
    }
</script>
<style lang="scss" scoped>
	.existing-loans.active {
		background-color: #78e08f;
	}
</style>
