<template>
    <div class="container-fluid px-16">
		<notifications group="foo" />
        <div class="mb-16"></div>
        <div class="mb-24 bb-primary-dark pb-7 text-block">
            <h1 class="m-0 font-35">Account Retagging</h1>
        </div>
        <!-- /.col -->
        <div class="d-flex flex-column flex-xl-row">
            <div style="flex: 1">
                <div class="search-bar mb-12 relative">
                    <input
                        type="text"
                        v-model="filter"
                        class="form-control"
                        id="searchBar"
                        placeholder="Search"
                    />
                    <div><i class="fa fa-search"></i></div>
					<div class="results-container d-flex flex-column justify-content-start">
						<a v-for="b,f in filteredBorrowers" @click.prevent="selectBorrower(b)" href="" :key="f">{{b.lastname + ', ' + b.firstname}}</a>
					</div>
                </div>
                <table class="table table-stripped" id="clientsList">
                    <thead>
                        <th>All</th>
                        <th>Account #</th>
                        <th>Client Name</th>
                        <th>Date Release</th>
                        <th>Amount</th>
                        <th>AO</th>
                        <th>Product</th>
                        <th>Center</th>
                        <th>Loan Status</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr
                            v-for="account in paginate"
                            :key="account.loan_account_id"
                        >
                            <td>
                                <input
									v-model="account.checked"
                                    type="checkbox"
                                    class="form-control form-box"
                                />
                            </td>
                            <td>{{ account.account_num }}</td>
                            <td>
                                {{
                                    account.borrower.firstname +
                                    " " +
                                    account.borrower.lastname
                                }}
                            </td>
                            <td>
                                {{ account.date_release.replaceAll("-", "/") }}
                            </td>
                            <td>{{ formatToCurrency(account.loan_amount) }}</td>
                            <td>{{ account.account_officer.name }}</td>
                            <td>{{ account.product.product_name }}</td>
                            <td>
                                {{
                                    account.center
                                        ? account.center.center
                                        : "None"
                                }}
                            </td>
                            <td>{{ account.loan_status }}</td>
                            <td>
                                <a
                                    href="#"
                                    @click.prevent="loanAccount = account"
                                    class="text-green-bright text-md"
                                    data-toggle="modal"
                                    data-target="#retagDetailsModal"
                                    ><i>View Details</i></a
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
				<mac-pagination v-if="filteredAccounts.length > pagination.range" @setpage="setPage" :pdata="filteredAccounts" :ppage="pagination.page" :prange="pagination.range" class="mb-24"></mac-pagination>
				<!-- <div v-if="filteredAccounts.length > pagination.range" class="d-flex justify-content-end">
					<div class="d-flex pagination">
						<span @click="pagination.page=i" :class="i==pagination.page?'active':''" v-for="i in Math.ceil(filteredAccounts.length/pagination.range)" :key="i">{{i}}</span>
					</div>
				</div> -->
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <span style="margin-bottom: 12px" class="text-lg"
                            >Retagging Field</span
                        >
                        <select
                            name=""
                            id=""
                            class="form-control"
                            style="min-width: 250px"
							v-model="retaggingField"
                        >
							<option value="product">Product</option>
                            <option value="ao">Account Officer</option>
                            <option value="center">Center / Office</option>
							<option value="loan status">Loan Status</option>
							<option value="remedial">Remedial</option>
                        </select>
                    </div>
                    <button
						:disabled="!canRetagg"
                        class="btn btn-success btn-wide"
                        data-toggle="modal"
                        data-target="#retagModal"
                    >
                        Retag
                    </button>
                </div>
            </div>
            <!-- <div style="flex:20">
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
			</div> -->
        </div>

        <!-- MODALS -->
        <div class="modal" id="retagModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body p-24">
                        <div class="d-flex flex-column">
                            <span
                                class="text-bold font-20 text-primary-dark pb-10 light-bb mb-16"
                                >Retagging</span
                            >
                            <div v-if="retaggingField=='product'" class="form-group mb-10" style="flex: 5">
                                <label for="product" class="form-label"
                                    >Product</label
                                >
                                <select
									v-model="retagValue"
                                    class="form-control form-input"
                                    id="product"
                                >
									<option v-for="p in products.filter(p=>p.status=='active')" :key="p.product_id" :value="p.product_id">{{p.product_name}}</option>
								</select>
                            </div>
                            <div v-if="retaggingField=='ao'" class="form-group mb-10" style="flex: 5">
                                <label for="product" class="form-label"
                                    >Account Officer</label
                                >
                                <select
									v-model="retagValue"
                                    class="form-control form-input"
                                    id="product"
                                >
									<option v-for="a in accountOfficers.filter(ao=>ao.status=='active')" :key="a.ao_id" :value="a.ao_id">{{a.name}}</option>
								</select>
                            </div>
                            <div v-if="retaggingField=='center'" class="form-group mb-10" style="flex: 5">
                                <label for="product" class="form-label"
                                    >Center / Office</label
                                >
                                <select
									v-model="retagValue"
                                    class="form-control form-input"
                                    id="product"
                                >
									<option v-for="c in centers.filter(c=>c.status=='active')" :key="c.center_id" :value="c.center_id">{{c.center}}</option>
								</select>
                            </div>
                            <!-- <div class="form-group mb-10" style="flex: 5">
                                <label for="product" class="form-label"
                                    >Group / Dept.</label
                                >
                                <select
                                    class="form-control form-input"
                                    id="product"
                                ></select>
                            </div> -->
                            <div v-if="retaggingField=='loan status'" class="form-group mb-10" style="flex: 5">
                                <label for="product" class="form-label"
                                    >Loan Status</label
                                >
                                <select
									v-model="retagValue"
                                    class="form-control form-input"
                                    id="product"
                                >
									<option v-for="l in loanStatus" :key="l" :value="l">{{l}}</option>
								</select>
                            </div>
                            <div v-if="retaggingField=='remedial'" class="form-group mb-24" style="flex: 5">
                                <label for="product" class="form-label"
                                    >Remedial</label
                                >
                                <select
									v-model="retagValue"
                                    class="form-control form-input"
                                    id="product"
                                ></select>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a
									@click="setRetaggedAccounts()"
                                    href="#"
                                    data-dismiss="modal"
                                    class="btn btn-success min-w-150"
                                    >Save</a
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="retagDetailsModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-body p-24">
                        <div class="d-flex flex-column">
                            <section
                                class="mb-24"
                                style="flex: 21; padding-left: 16px"
                            >
                                <span class="section-title mb-24">Details</span>
                                <div class="d-flex mb-12">
                                    <div
                                        class="d-flex flex-column mr-16"
                                        style="flex: 20"
                                    >
                                        <div class="d-flex flex-row">
                                            <div
                                                class="borrower-number d-flex flex-column"
                                                style="flex: 5"
                                            >
                                                <span>Borrower's Number</span>
                                                <span class="text-center">{{
                                                    loanAccount.borrower
                                                        .borrower_num
                                                }}</span>
                                            </div>
                                            <div style="flex: 4"></div>
                                            <div
                                                class="form-group mb-10"
                                                style="flex: 5"
                                            >
                                                <!-- <label for="transactionDate" class="form-label">Transaction Date</label>
											<input type="date" class="form-control form-input text-right" id="transactionDate"> -->
                                            </div>
                                        </div>
                                        <div
                                            class="form-group mb-5"
                                            style="flex: 5"
                                        >
                                            <label
                                                for="client"
                                                class="form-label mb-3"
                                                >Client</label
                                            >
                                            <input
                                                disabled
                                                :value="
                                                    loanAccount.borrower
                                                        .borrower_id
                                                        ? loanAccount.borrower
                                                              .firstname +
                                                          ' ' +
                                                          loanAccount.borrower
                                                              .lastname +
                                                          ' ' +
                                                          loanAccount.borrower.middlename.charAt(
                                                              0
                                                          ) +
                                                          '.'
                                                        : ''
                                                "
                                                type="text"
                                                class="form-control form-input"
                                                id="client"
                                            />
                                        </div>
                                        <div
                                            class="form-group mb-10"
                                            style="flex: 5"
                                        >
                                            <label
                                                for="address"
                                                class="form-label mb-3"
                                                >Address</label
                                            >
                                            <input
                                                disabled
                                                :value="
                                                    loanAccount.borrower.address
                                                "
                                                type="text"
                                                class="form-control form-input"
                                                id="address"
                                            />
                                        </div>
                                    </div>
                                    <div
                                        class="upload-photo d-flex flex-column"
                                        style="flex: 4; padding-top: 36px"
                                    >
                                        <img
                                            :src="borrowerPhoto"
                                            alt=""
                                            style="max-width: 230px"
                                        />
                                    </div>
                                </div>
                                <div class="sep mb-24"></div>
                            </section>

                            <section
                                class="mb-24"
                                style="flex: 21; padding-left: 16px"
                            >
                                <div
                                    class="d-flex flex-row justify-content-between align-items-center section-title pb-12 mb-24"
                                >
                                    <span
                                        class="section-title section-subtitle b-none p-0"
                                        >Loan Details</span
                                    >
                                </div>
                                <div class="d-flex flex-row">
                                    <div
                                        class="d-flex flex-column flex-1 mr-45"
                                    >
                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class=""
                                                    >Account Number</span
                                                >
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    loanAccount.account_num
                                                }}</span
                                            >
                                        </div>

                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class=""
                                                    >Co Borrower</span
                                                >
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    loanAccount.co_borrower_name
                                                }}</span
                                            >
                                        </div>

                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class="">Address</span>
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    loanAccount.co_borrower_address
                                                }}</span
                                            >
                                        </div>

                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class="">Co Maker</span>
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    loanAccount.co_maker_name
                                                }}</span
                                            >
                                        </div>

                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class="">Address</span>
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    loanAccount.co_maker_address
                                                }}</span
                                            >
                                        </div>

                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class=""
                                                    >Contact No.</span
                                                >
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    loanAccount.borrower
                                                        .contact_number
                                                }}</span
                                            >
                                        </div>

                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class=""
                                                    >Date Release</span
                                                >
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    dateToMDY(new Date(loanAccount.date_release))
                                                }}</span
                                            >
                                        </div>

                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class=""
                                                    >Product Name</span
                                                >
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    loanAccount.product
                                                        .product_name
                                                }}</span
                                            >
                                        </div>

                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class=""
                                                    >Missed Payments</span
                                                >
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >0</span
                                            >
                                        </div>

                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class="">Type</span>
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{ loanAccount.type }}</span
                                            >
                                        </div>

                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class="">Cycle</span>
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    loanAccount.cycle_no
                                                }}</span
                                            >
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column flex-1">
                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class=""
                                                    >Last Transaction</span
                                                >
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{ lastTransaction }}</span
                                            >
                                        </div>
                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class=""
                                                    >Loan Amount</span
                                                >
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    formatToCurrency(loanAccount.loan_amount)
                                                }}</span
                                            >
                                        </div>
                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class="">Interest</span>
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    formatToCurrency(loanAccount.interest_amount)
                                                }}</span
                                            >
                                        </div>
                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class="">Due Date</span>
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    dateToMDY(new Date(loanAccount.due_date))
                                                }}</span
                                            >
                                        </div>
                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class="">{{
                                                    loanAccount.payment_mode
                                                }}</span>
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    formatToCurrency(
                                                        Math.ceil(
                                                            loanAccount.interest_amount /
                                                                loanAccount.no_of_installment
                                                        ) +
                                                            Math.ceil(
                                                                loanAccount.loan_amount /
                                                                    loanAccount.no_of_installment
                                                            )
                                                    )
                                                }}</span
                                            >
                                        </div>
                                        <!-- <div class="d-flex flex-row mb-12">
										<div class="d-flex flex-row flex-1 justify-content-between pr-24">
											<span class="">Int. Rate</span>
											<span>:</span>
										</div>
										<span class="flex-2 text-primary-dark">{{loanAccount.interest_rate}}%</span>
									</div> -->
                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class="">Mode</span>
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    loanAccount.payment_mode
                                                }}</span
                                            >
                                        </div>
                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class="">Rate</span>
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    loanAccount.interest_rate
                                                }}%</span
                                            >
                                        </div>
                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class="">Term</span>
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    loanAccount.terms
                                                }}
                                                Days</span
                                            >
                                        </div>
										 <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class="">Prin. Balance</span>
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    formatToCurrency(loanAccount.remainingBalance.principal.balance)
                                                }}
                                            </span
                                            >
                                        </div>
										 <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class="">Int. Balance</span>
                                                <span>:</span>
                                            </div>
                                            <span
                                                class="flex-2 text-primary-dark"
                                                >{{
                                                    formatToCurrency(loanAccount.remainingBalance.interest.balance)
                                                }}
                                            </span
                                            >
                                        </div>
                                        <div class="d-flex flex-row mb-12">
                                            <div
                                                class="d-flex flex-row flex-1 justify-content-between pr-24"
                                            >
                                                <span class="">Status</span>
                                                <span>:</span>
                                            </div>
                                            <span class="flex-2" :class="loanAccountStatusColor">{{loanAccount.loan_status}}</span>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["pbranch", "token",'ploanstatus'],
    data() {
        return {
			selectedBorrower:{},
			pagination:{
				page: 1,
				range: 10
			},
			retaggingField:'',
			retagValue:null,
            filter: "",
			products:[],
			accountOfficers:[],
			centers:[],
            borrower: {
                borrower_num: "############",
                photo: null,
            },
			borrowers:[],
            loanAccounts: [],
            loanAccount: {
                loan_account_id: null,
                cycle_no: 1,
                ao_id: "",
                product_id: "",
                center_id: "",
                type: "",
                payment_mode: "",
                terms: "",
                loan_amount: "",
                no_of_installment: "",
                day_schedule: "",
                borrower_num: "",
                co_borrower_name: "",
                co_borrower_address: "",
                co_borrower_id_type: "",
                co_borrower_id_number: "",
                co_borrower_id_date_issued: "",
                co_maker_name: "",
                co_maker_address: "",
                co_maker_id_type: "",
                co_maker_id_number: "",
                co_maker_id_date_issued: "",
                document_stamp: "",
                filing_fee: "",
                insurance: "",
                notarial_fee: "100.00",
                prepaid_interest: "",
                affidavit_fee: "",
                memo: "",
                total_deduction: "",
                net_proceeds: "",
                release_type: "",
                interest_rate: "",
                interest_amount: "",
				loan_status:'',
				remainingBalance:{
					principal:{
						balance:0
					},
					interest:{
						balance:0
					}
				},
                borrower: {
                    borrower_id: null,
                    borrower_num: "############",
                    photo: null,
                },
                product: {
                    product_name: "",
                },
                documents: {
                    date_release: "",
                    description: "",
                    bank: "",
                    account_no: "",
                    card_no: "",
                    promissory_number: "",
                },
                outstandingBalance: {
                    principal_balance: "",
                    interest_balance: "",
                    surcharge: "",
                },
                current_amortization: {
                    principal: "",
                    interest: "",
                    short_interest: "",
                    advance_interest: "",
                    short_principal: "",
                    advance_principal: "",
                    outstandingBalance: {
                        principal_balance: "",
                        interest_balance: "",
                        surcharge: "",
                    },
                    lastPayment: {
                        principal: "",
                        interest: "",
                        short_interest: "",
                        advance_interest: "",
                        short_principal: "",
                        advance_principal: "",
                    },
                },
            },
			loanStatus:['Write-Off','Case Filed','Litigated','Restructured','Restructured w/o PDI']
        };
    },
    methods: {
		setPage:function(page){
			this.pagination.page = page;
		},
		async retag(account){
			await axios.post(this.baseURL() + 'api/account/update/' + account.loan_account_id, account, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.notify('','Account # ' + account.account_num + ' has been updated.', 'success');
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		setRetaggedAccounts:function(){
			this.filteredAccounts.forEach(a=>{
				if(a.checked){
					if(this.retaggingField == 'product'){
						a.product_id = this.retagValue;
					}else if(this.retaggingField == 'ao'){
						a.ao_id = this.retagValue;
					}else if(this.retaggingField == 'center'){
						a.center_id = this.retagValue;
					}else if(this.retaggingField == 'loan status'){
						a.loan_status = this.retagValue;
					}else{

					}
					console.log(a);
					this.retag(a);
				}
			});
			this.fetchBorrowers();
		},
		notify:function(title, text, type){
			this.$notify({
				group: 'foo',
				title: title,
				text: text,
				type: type,
			});
		},
		async fetchCenters(){
			await axios.get(this.baseURL() + 'api/center', {
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
		async fetchOfficers(){
			await axios.get(this.baseURL() + 'api/accountofficer', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.accountOfficers = response.data.data.filter(ao=>ao.branch_id == this.pbranch);
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		async fetchProducts(){
			await axios.get(this.baseURL() + 'api/product/', {
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
        async fetchBorrowers() {
            await axios
                .get(this.baseURL() + "api/borrower/list/" + this.pbranch, {
                    headers: {
                        Authorization: "Bearer " + this.token,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                })
                .then(
                    function (response) {
						console.log(response.data);
						this.borrowers = response.data.data;
                        // this.loanAccounts = this.setAccounts(response.data.data);
                    }.bind(this)
                )
                .catch(
                    function (error) {
                        console.log(error);
                    }.bind(this)
                );
        },
		 async fetchBorrower(borrower) {
            await axios
                .get(this.baseURL() + "api/borrower/accounts/" + borrower.borrower_id, {
                    headers: {
                        Authorization: "Bearer " + this.token,
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                })
                .then(
                    function (response) {
						console.log(response.data);
                    }.bind(this)
                )
                .catch(
                    function (error) {
                        console.log(error);
                    }.bind(this)
                );
        },
        setAccounts: function (borrowers) {
            var accounts = [];
            borrowers.forEach(b => {
                if (b.loan_accounts) {
                    b.loan_accounts.forEach(la => {
                        la.checked = false;
						la.photo = b.photo;
						if(la.loan_status != 'Paid' && la.status == 'released'){
							accounts.push(la);
						}
                    });
                }
            });
            return accounts;
        },
        async fetchAccounts() {
            await axios
                .get(
                    this.baseURL() + "maintenance/account_retagging/accounts/",
                    {
                        headers: {
                            Authorization: "Bearer " + this.token,
                            "Content-Type": "application/json",
                            Accept: "application/json",
                        },
                    }
                )
                .then(
                    function (response) {
                        this.loanAccounts = response.data;
                    }.bind(this)
                )
                .catch(
                    function (error) {
                        console.log(error);
                    }.bind(this)
                );
        },
		selectBorrower:function(b){
			this.fetchBorrower(b)
			// this.selectedBorrower = b;
			this.filter = '';
		}
    },
    computed: {
		canRetagg:function(){
			return this.filteredAccounts.filter(a => a.checked).length && this.retaggingField.length;
		},
		loanAccountStatusColor:function(){
			if(this.loanAccount.loan_status == "Past Due"){
				return "text-danger";
			}else if(this.loanAccount.loan_status == "Delinquent"){
				return "text-danger";
			}
			return "text-ocean";
		},
        borrowerPhoto: function () {
            return this.loanAccount.photo
                ? this.loanAccount.photo
                : this.baseURL() + "/img/user.png";
        },
        lastTransaction: function () {
            return this.loanAccount.payments && this.loanAccount.payments.length
                ? this.dateToMDY(
                      new Date(this.loanAccount.payments[0].transaction_date)
                  )
                : "None";
        },
		filteredBorrowers:function(){
			if(this.filter.length > 0){
				return this.borrowers.filter( data => data.firstname
							.toLowerCase()
							.includes(this.filter.toLowerCase()) ||
						data.lastname.toLowerCase()
                        	.includes(this.filter.toLowerCase()) ||
						(data.lastname.toLowerCase() + ' ' + data.firstname.toLowerCase())
                        	.includes(this.filter.toLowerCase()) ||
						(data.firstname.toLowerCase() + ' ' + data.lastname.toLowerCase())
                        	.includes(this.filter.toLowerCase())
						)
			}
 			return [];
		},
        filteredAccounts: function () {
            return this.loanAccounts.filter(
                (data) =>
                    data.account_num.includes(this.filter) ||
                    data.borrower.firstname
                        .toLowerCase()
                        .includes(this.filter.toLowerCase()) ||
                    data.borrower.lastname
                        .toLowerCase()
                        .includes(this.filter.toLowerCase()) ||
                    (data.borrower.firstname + " " + data.borrower.lastname)
                        .toLowerCase()
                        .includes(this.filter.toLowerCase()) ||
                    (data.borrower.lastname + " " + data.borrower.firstname)
                        .toLowerCase()
                        .includes(this.filter.toLowerCase()) ||
                    data.product.product_name
                        .toLowerCase()
                        .includes(this.filter.toLowerCase()) ||
                    data.loan_status
                        .toLowerCase()
                        .includes(this.filter.toLowerCase()) ||
                    data.account_officer.name
                        .toLowerCase()
                        .includes(this.filter.toLowerCase()) ||
                    (data.center ? data.center.center : "")
                        .toLowerCase()
                        .includes(this.filter.toLowerCase()) ||
                    data.date_release
                        .replaceAll("-", "/")
                        .includes(this.filter.toLowerCase())
            );
        },
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
    },
    mounted() {
        this.fetchBorrowers();
		this.fetchCenters();
		this.fetchOfficers();
		this.fetchProducts();
    },
};
</script>

<style scoped>
	.results-container {
		position:absolute;
		left:0;top:40px;width:100%;height:auto;
		border:1px solid #f2f2f2;
		box-shadow: 1px 1px 2px rgba(0,0,0,.1);
		z-index: 9999999;
		padding: 10px 0px;
		background-color: #FFF;
		overflow: hidden;
	}
	.results-container a {
		width:100%;
		border-bottom: 1px solid #eee;
		padding: 5px 10px;
		background-color: #FFF;
	}
	.results-container a:hover {
		background-color: #eee;
	}
</style>