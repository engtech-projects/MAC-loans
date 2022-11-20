<template>
    <div class="px-16">
        <div class="container-fluid">
            <div class="mb-16"></div>
            <div
                class="d-flex justify-content-between align-items-center mb-24 bb-primary-dark pb-7 text-block"
            >
                <h1 class="m-0 font-35">Statement of Account Details</h1>
                <a
                    :href="baseURL() + 'client_information/balance_inquiry_list'"
                    class="btn btn-primary-dark float-right"
                    style="padding: 7px 50px !important; font-size: 14px"
                    >Back</a
                >
            </div>
            <!-- /.col -->
            <section class="content">
                <div class="container-fluid" style="padding: 0 !important">
                    <div class="flex mb-24">
                        <div class="upload-photo">
                            <img
                                :src="borrowerPhoto"
                                style="
                                    border: 1px solid #ccc;
                                    margin-right: 16px;
									max-width:240px;
                                "
                                alt=""
                            />
                        </div>
                        <div class="flex-col">
                            <div class="customer-number mb-5">
                                <span>Customer Number</span>
                                <span>{{borrower.borrower_num}}</span>
                            </div>
                            <div class="info-display">
                                <span style="color: #2f4b67">Client Name</span>
                                <span>{{fullName(borrower.firstname, borrower.middlename, borrower.lastname)}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-display title mb-12">
                        <span>Accounts</span>
                    </div>
                    <div class="flex-col accounts-list">
                        <div v-for="(a, i) in borrower.loan_accounts" :key="a.loan_account_id" class="card mb-12" :class="i > 0? 'collapsed-card':''">
                            <div
                                class="card-header"
                                style="background-color: #dfdfd0 !important"
                            >
                                <h3 class="card-title" style="color: #283f53">
                                    Account Number: {{a.account_num}}
                                </h3>

                                <div class="card-tools">
                                    <button
                                        type="button"
                                        class="btn btn-tool"
                                        data-card-widget="collapse"
                                        title="Collapse"
                                    >
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div
                                class="card-body p-0"
                                style="padding: 25px 20px !important"
                            >
                                <div class="flex mb-24">
                                    <div class="flex-col granted-amount mr-24">
                                        <span>Amount Granted</span>
                                        <span>P {{formatToCurrency(a.loan_amount)}}</span>
                                    </div>
                                    <div class="flex-col flex-1">
                                        <div class="row mb-24">
                                            <div class="col-xl-3 col-lg-6">
                                                <div class="info-display">
                                                    <span class="font-blue"
                                                        >Amortization</span
                                                    >
                                                    <span>P {{formatToCurrency(a.current_amortization.principal + a.current_amortization.interest)}}</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6">
                                                <div class="info-display">
                                                    <span class="font-blue"
                                                        >Release Date</span
                                                    >
                                                    <span
                                                        >{{dateToMDY(new Date(a.date_release))}}</span
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6">
                                                <div class="info-display">
                                                    <span class="font-blue"
                                                        >Term</span
                                                    >
                                                    <span
                                                        >{{a.terms}} Days / {{a.terms / 30}} Month
                                                        (s)</span
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6">
                                                <div class="info-display">
                                                    <span class="font-blue"
                                                        >Due Date</span
                                                    >
                                                    <span>{{dateToMDY(new Date(a.due_date))}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-6">
                                                <div class="info-display">
                                                    <span class="font-blue"
                                                        >Interest</span
                                                    >
                                                    <span
                                                        >{{a.interest_rate * 12}}% p.a / {{a.interest_rate}}% p.m</span
                                                    >
                                                </div>
                                            </div>
                                            <div class="col-xl-3 col-lg-6">
                                                <div class="info-display">
                                                    <span class="font-blue"
                                                        >Mode</span
                                                    >
                                                    <span>{{a.payment_mode}}</span>
                                                </div>
                                            </div>
                                            <!-- <div class="col-xl-3 col-lg-6">
                                                <div class="info-display">
                                                    <span class="font-blue"
                                                        >Group</span
                                                    >
                                                    <span>Various Pension</span>
                                                </div>
                                            </div> -->
                                            <div class="col-xl-3 col-lg-6">
                                                <div class="info-display">
                                                    <span class="font-blue"
                                                        >Type</span
                                                    >
                                                    <span>{{a.type}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-24">
                                    <div class="col-xl-3 col-lg-6">
                                        <div class="info-display">
                                            <span class="font-blue"
                                                >Product Name</span
                                            >
                                            <span>{{a.product.product_name}}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6">
                                        <div class="info-display">
                                            <span class="font-blue">Cycle</span>
                                            <span>{{nthDay(a.cycle_no)}}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6">
                                        <div class="info-display">
                                            <span class="font-blue"
                                                >Status</span
                                            >
                                            <span>{{a.status}}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6">
                                        <div class="info-display">
                                            <span class="font-blue"
                                                >Center</span
                                            >
                                            <span>{{a.center?a.center.center:'---'}}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-6">
                                        <div class="info-display">
                                            <span class="font-blue"
                                                >Collection Rate</span
                                            >
                                            <span>---</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sep mb-24"></div>

                                <div class="row mb-24">
                                    <div class="col-xl-3 col-lg-6">
                                        <div class="info-display">
                                            <span class="font-blue"
                                                >Co-Borrower</span
                                            >
                                            <span>{{a.co_borrower_name}}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-5 col-lg-6">
                                        <div class="info-display">
                                            <span class="font-blue"
                                                >Co-Borrower Address</span
                                            >
                                            <span
                                                >{{a.co_borrower_address}}</span
                                            >
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div class="info-display">
                                            <span class="font-blue"
                                                >Co-Borrower ID</span
                                            >
                                            <span>{{a.co_borrower_id_number}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-24">
                                    <div class="col-xl-3 col-lg-6">
                                        <div class="info-display">
                                            <span class="font-blue"
                                                >Co-Maker</span
                                            >
                                            <span>{{a.co_maker_name}}</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-5 col-lg-6">
                                        <div class="info-display">
                                            <span class="font-blue"
                                                >Co-Maker Address</span
                                            >
                                            <span
                                                >{{a.co_maker_address}}</span
                                            >
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6">
                                        <div class="info-display">
                                            <span class="font-blue"
                                                >Co-Maker ID</span
                                            >
                                            <span>{{a.co_maker_id_number}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="sep mb-24"></div>
								
								<div class="d-flex">
									<div class="flex-1 d-flex flex-column justify-content-between pr-16 br-primary-dark">
										<div class="mb-45">
											<span class="pb-10 text-primary-dark text-lg bb-primary-dark text-bold text-block">Amortization Scheduled Payment</span>
											<div class="d-flex justify-content-between py-5 text-primary-dark">
												<div class="flex-4 d-flex justify-content-between">
													<span>Amort. Principal</span>
													<span>:</span>
												</div>
												<span class="flex-3 pl-10">P {{formatToCurrency(a.current_amortization.principal)}}</span>
											</div>
											<div class="d-flex justify-content-between py-5 text-primary-dark">
												<div class="flex-4 d-flex justify-content-between">
													<span>Interest</span>
													<span>:</span>
												</div>
												<span class="flex-3 pl-10">P {{formatToCurrency(a.current_amortization.interest)}}</span>
											</div>
										</div>
										<div>
											<span class="text-lg text-bold text-primary-dark">TOTAL</span>
											<span class="text-block bg-primary-dark text-white px-16 text-45 mr-36">P {{formatToCurrency(a.current_amortization.principal + a.current_amortization.interest)}}</span>
										</div>
									</div>
									<div class="flex-1 px-16 br-primary-dark d-flex flex-column justify-content-between">
										<div class="mb-45">
											<span class="pb-10 text-primary-dark text-lg bb-primary-dark text-bold text-block">Total Amount Due</span>
											<div class="d-flex justify-content-between py-5 text-primary-dark">
												<div class="flex-4 d-flex justify-content-between">
													<span>Principal</span>
													<span>:</span>
												</div>
												<span class="flex-3 pl-10">P {{formatToCurrency(a.current_amortization.principal)}}</span>
											</div>
											<div class="d-flex justify-content-between py-5 text-primary-dark">
												<div class="flex-4 d-flex justify-content-between">
													<span>Interest</span>
													<span>:</span>
												</div>
												<span class="flex-3 pl-10">P {{formatToCurrency(a.current_amortization.interest)}}</span>
											</div>
											<div class="d-flex justify-content-between py-5 text-primary-dark">
												<div class="flex-4 d-flex justify-content-between">
													<span>Penalty</span>
													<span>:</span>
												</div>
												<span class="flex-3 pl-10">P {{formatToCurrency(a.current_amortization.penalty)}}</span>
											</div>
											<div class="d-flex justify-content-between py-5 text-primary-dark">
												<div class="flex-4 d-flex justify-content-between">
													<span>PDI</span>
													<span>:</span>
												</div>
												<span class="flex-3 pl-10">P {{formatToCurrency(a.current_amortization.pdi)}}</span>
											</div>
										</div>
										<div>
											<span class="text-lg text-bold text-primary-dark">TOTAL</span>
											<span class="text-block bg-primary-dark text-white px-16 text-45 mr-36">P {{formatToCurrency(a.current_amortization.principal + a.current_amortization.interest + a.current_amortization.pdi + a.current_amortization.penalty)}}</span>
										</div>
									</div>
									<div class="flex-1 px-16 d-flex flex-column justify-content-between">
										<div class="mb-45">
											<span class="pb-10 text-primary-dark text-lg bb-primary-dark text-bold text-block">Outstanding Balance</span>
											<div class="d-flex justify-content-between py-5 text-primary-dark">
												<div class="flex-4 d-flex justify-content-between">
													<span>Principal Balance</span>
													<span>:</span>
												</div>
												<span class="flex-3 pl-10">P {{formatToCurrency(a.current_amortization.principal_balance)}}</span>
											</div>
											<div class="d-flex justify-content-between py-5 text-primary-dark">
												<div class="flex-4 d-flex justify-content-between">
													<span>Interest Balance</span>
													<span>:</span>
												</div>
												<span class="flex-3 pl-10">P {{formatToCurrency(a.current_amortization.interest_balance)}}</span>
											</div>
											<div class="d-flex justify-content-between py-5 text-primary-dark">
												<div class="flex-4 d-flex justify-content-between">
													<span>Surcharge</span>
													<span>:</span>
												</div>
												<span class="flex-3 pl-10">P 0.00</span>
											</div>
										</div>
										<div>
											<span class="text-lg text-bold text-primary-dark">TOTAL</span>
											<span class="text-block bg-primary-dark text-white px-16 text-45 mr-36">P {{formatToCurrency(a.current_amortization.principal_balance + a.current_amortization.interest_balance)}}</span>
										</div>
									</div>
									<div class="flex-1 px-16"></div>
								</div>
								<div class="d-flex">
									<div class="flex-1 d-flex flex-column pr-16 br-primary-dark">
										<div class="d-flex flex-column pxy-15 mt-10 bg-peach mr-36">
											<div class="d-flex justify-content-between text-primary-dark">
												<div class="flex-4 d-flex justify-content-between">
													<span>Short Principal</span>
													<span>:</span>
												</div>
												<span class="flex-3 pl-10">P {{formatToCurrency(a.current_amortization.short_principal)}}</span>
											</div>
											<div class="d-flex justify-content-between mb-10 text-primary-dark">
												<div class="flex-4 d-flex justify-content-between">
													<span>Adv. Principal</span>
													<span>:</span>
												</div>
												<span class="flex-3 pl-10">P {{formatToCurrency(a.current_amortization.advance_principal)}}</span>
											</div>
											<div class="d-flex justify-content-between text-primary-dark">
												<div class="flex-4 d-flex justify-content-between">
													<span>Short Interest</span>
													<span>:</span>
												</div>
												<span class="flex-3 pl-10">P {{formatToCurrency(a.current_amortization.short_interest)}}</span>
											</div>
											<div class="d-flex justify-content-between text-primary-dark">
												<div class="flex-4 d-flex justify-content-between">
													<span>Overpayment</span>
													<span>:</span>
												</div>
												<span class="flex-3 pl-10">P 0.00</span>
											</div>
										</div>
									</div>
									<div class="flex-1 px-16 br-primary-dark d-flex flex-column justify-content-between">
										
									</div>
									<div class="flex-1 px-16 d-flex flex-column justify-content-between">
										
									</div>
									<div class="flex-1 px-16"></div>
								</div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
export default {
	props:['pborrower','token'],
	data(){
		return {
			borrower: {
				borrower_id: null,
				date_registered:'',
				borrower_num:'',
				firstname:'',
				lastname:'',
				middlename:'',
				suffix :'' ,
				address :'' ,
				birthdate :'',
				gender :'' ,
				status :'' ,
				photo: null,
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
				loan_accounts:[],
				created_at: '',
			}
		}
	},
	methods:{
		async fetchBorrower(){
			await axios.get(this.baseURL() + 'api/borrower/' + this.pborrower, {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'contentType': "multipart/form-data"
					}
				})
				.then(function (response) {
					this.borrower = response.data.data;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
		}
	},
	computed:{
		borrowerPhoto:function(){
			return this.borrower.photo? this.borrower.photo : this.baseURL()+'/img/user.png';
		},
	},
	mounted(){
		this.borrower = JSON.parse(this.pborrower);
		this.fetchBorrower();
	}
}
</script>
