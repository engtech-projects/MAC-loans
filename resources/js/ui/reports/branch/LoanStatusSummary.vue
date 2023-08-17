<template>
	<div class="d-flex flex-column" style="flex:8;">
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
		<form @submit.prevent="fetchReport()">
		<div class="d-flex flex-row font-md mb-16">
			<!-- <span class="font-lg text-primary-dark flex-1 mr-45"></span> -->
			<!-- <div class="d-flex flex-row align-items-center mr-24" style="flex:1">
				<span class="mr-10">As of: </span>
				<input type="date" class="form-control flex-1">
			</div> -->
			<div class="d-flex flex-row align-items-center mr-24 justify-content-start flex-1">
				<span class="mr-10 text-block">Acc. Officer: </span>
				<select required v-model="filter.account_officer" name="" id="selectProductClient" class="form-control flex-1">
					<option v-for="a,o in aos.filter(ao=>ao.branch_id==branch.branch_id)" :key="o" :value="a.ao_id">{{a.name}}</option>
					<option value="all">All</option>
				</select>
			</div>
			<div class="d-flex flex-row align-items-center mr-24 justify-content-start flex-1">
				<span class="mr-10 text-block">Product: </span>
				<select required v-model="filter.product" name="" id="selectProductClient" class="form-control flex-1">
					<option v-for="p,i in products" :key="i" :value="p.product_id">{{p.product_name}}</option>
					<option value="all">All</option>
				</select>
			</div>		
			<div class="d-flex flex-row align-items-center mr-24 justify-content-start flex-1">
				<span class="mr-10 text-block">Center: </span>
				<select required v-model="filter.center" name="" id="selectProductClient" class="form-control flex-1">
					<option v-for="c,n in centers" :key="n" :value="c.center_id">{{c.center}}</option>
					<option value="all">All</option>
				</select>
			</div>	
			<div class="d-flex flex-row align-items-center justify-content-start flex-1 mr-24">
				<span class="mr-10 text-block">Status: </span>
				<select required v-model="filter.loan_status" name="" id="selectProductClient" class="form-control flex-1">
					<option value="Current">Current</option>
					<option value="Delinquent">Delinquent</option>
					<option value="Past Due">Past Due</option>
					<option value="Restructed">Restructed</option>
					<option value="Res WO/ PDI">Res WO/ PDI</option>
					<option value="Case Filed">Case Filed</option>
					<option value="Litegated">Litegated</option>
					<option value="Write-Off">Write-Off</option>
				</select>
			</div>		
			<div class="d-flex flex-row align-items-center justify-content-start">
				<button class="btn btn-primary">Generate</button>
			</div>									
		</div>
		</form>
		<div class="sep mb-45"></div>
		<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">

		<section class="mb-72" id="performanceReport">
			<div class="d-flex flex-column mb-24">
				<div class="d-flex flex-row align-items-center">
					<div class="flex-1 d-flex flex-column">
					
					</div>
					<span class="font-30 text-bold text-primary-dark text-center">LOAN STATUS SUMMARY REPORT</span>
					<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
                        <current-transactiondate :branch="branch.branch_id" :token="token" :reports="true"></current-transactiondate>
                        <span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
                    </div>
				</div>
				<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name}} Branch ({{branch.branch_code}})</span>
							<div class="d-flex flex-row justify-content-center text-primary-dark">
								<span class="text-center text-primary-dark text-bold">As of {{filter.as_of?dateToMDY2(new Date(filter.as_of)).split('-').join('/'):'---'}}</span>
							</div>
			</div>



			<section class="d-flex flex-column mb-16 p-10 light-border">
				<span v-if="!filteredReports.length">No records found.</span>
				<div v-for="fr,i in filteredReports" :key="i">
					<section v-if="fr.rows.length">
						<div class="d-flex bg-yellow-verylight mb-5">
							<div class="d-flex flex-column text-primary-dark p-7 mr-24">
								<span class="font-md text-bold">Account Officer</span>
								<span class="font-sm">{{fr.ao}}</span>
							</div>
							<div class="d-flex flex-column text-primary-dark p-7 mr-24">
								<span class="font-md text-bold">Product</span>
								<span class="font-sm">{{fr.product}}</span>
							</div>
							<div class="d-flex flex-column text-primary-dark p-7 flex-1">
								<span class="font-md text-bold">Center Name</span>
								<span class="font-sm">{{fr.center}}</span>
							</div>
						</div>
						<div class="bb-dark-8"></div>
						<table class="table table-stripped mb-24">
							<thead>
								<th>Borrower's Name</th>
								<th>Account Number</th>
								<th>Date Loan</th>
								<th>Maturity</th>
								<th>Amnt. Loan</th>
								<th>Principal Bal.</th>
								<th>Interest Bal.</th>
								<th>Amort.</th>
								<th>Bitay Principal</th>
								<th>Bitay Interest</th>
								<th>Amnt. Due</th>
								<th># Days</th>
								<th>STATUS</th>
							</thead>
							<tbody>
								<tr v-for="rws,j in fr.rows" :key="j">
									<td v-for="rw,k in rws" :key="k">{{rw}}</td>
								</tr>
								<tr v-if="fr.product=='002 - Micro Group'" class="bg-skyblue text-bold">
									<td v-for="tc,l in fr.centerTotal" :key="l">{{tc===""||tc==="CENTER SUB-TOTAL"||l==1?tc:formatToCurrency(tc)}}</td>
								</tr>
								<tr v-if="fr.productTotal" class="bg-green-mint text-bold">
									<td v-for="tp,m in fr.productTotal" :key="m">{{tp===""||tp==="PRODUCT SUB-TOTAL"||m==1?tp:formatToCurrency(tp)}}</td>
								</tr>
								<tr v-if="fr.aoTotal" class="bg-purple-light text-bold">
									<td v-for="ta,n in fr.aoTotal" :key="n">{{ta===""||ta==="OFFICER SUB-TOTAL"||n==1?ta:formatToCurrency(ta)}}</td>
								</tr>
								<tr v-if="fr.total" class="bg-primary-dark text-white text-bold">
									<td v-for="tt,o in fr.total" :key="o">{{tt===""||tt==="TOTAL"||o==1?tt:formatToCurrency(tt)}}</td>
								</tr>
							</tbody>
						</table>
					</section>
				</div>
			</section>



			<!-- <section class="d-flex flex-column mb-16 p-10 light-border">
				<div class="d-flex bg-yellow-verylight mb-5">
					<div class="d-flex flex-column text-primary-dark p-7 mr-24">
						<span class="font-md text-bold">Account Officer</span>
						<span class="font-sm">001 - John Mark Barcenas</span>
					</div>
					<div class="d-flex flex-column text-primary-dark p-7 mr-24">
						<span class="font-md text-bold">Product</span>
						<span class="font-sm">002 - Micro Group</span>
					</div>
					<div class="d-flex flex-column text-primary-dark p-7 flex-1">
						<span class="font-md text-bold">Center Name</span>
						<span class="font-sm">Accasia Center</span>
					</div>
				</div>
				<div class="bb-dark-8"></div>
				<table class="table table-stripped mb-24">
					<thead>
						<th>Borrower's Name</th>
						<th>Date Loan</th>
						<th>Maturity</th>
						<th>Amnt. Loan</th>
						<th>Principal Bal.</th>
						<th>Interest Bal.</th>
						<th>Amort.</th>
						<th>Amnt. Due</th>
						<th># Days</th>
						<th>STATUS</th>
					</thead>
					<tbody>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr class="bg-skyblue text-bold">
							<td>CENTER SUB-TOTAL</td>
							<td></td>
							<td>22,222.00</td>
							<td>4,338.00</td>
							<td>0.00</td>
							<td></td>
							<td></td>
							<td>4,338.00</td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>

				<div class="d-flex bg-yellow-verylight mb-5">
					<div class="d-flex flex-column text-primary-dark p-7 mr-24">
						<span class="font-md text-bold">Account Officer</span>
						<span class="font-sm">001 - John Mark Barcenas</span>
					</div>
					<div class="d-flex flex-column text-primary-dark p-7 mr-24">
						<span class="font-md text-bold">Product</span>
						<span class="font-sm">002 - Micro Group</span>
					</div>
					<div class="d-flex flex-column text-primary-dark p-7 flex-1">
						<span class="font-md text-bold">Center Name</span>
						<span class="font-sm">Accasia Center</span>
					</div>
				</div>
				<div class="bb-dark-8"></div>
				<table class="table table-stripped mb-24">
					<thead>
						<th>Borrower's Name</th>
						<th>Date Loan</th>
						<th>Maturity</th>
						<th>Amnt. Loan</th>
						<th>Principal Bal.</th>
						<th>Interest Bal.</th>
						<th>Amort.</th>
						<th>Amnt. Due</th>
						<th># Days</th>
						<th>STATUS</th>
					</thead>
					<tbody>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr class="bg-skyblue text-bold">
							<td>CENTER SUB-TOTAL</td>
							<td></td>
							<td>22,222.00</td>
							<td>4,338.00</td>
							<td>0.00</td>
							<td></td>
							<td></td>
							<td>4,338.00</td>
							<td></td>
							<td></td>
						</tr>
						<tr class="bg-green-mint text-bold">
							<td>PRODUCT SUB-TOTAL</td>
							<td></td>
							<td>22,222.00</td>
							<td>4,338.00</td>
							<td>0.00</td>
							<td></td>
							<td></td>
							<td>4,338.00</td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>

				
				<div class="d-flex bg-yellow-verylight mb-5">
					<div class="d-flex flex-column text-primary-dark p-7 mr-24">
						<span class="font-md text-bold">Account Officer</span>
						<span class="font-sm">001 - John Mark Barcenas</span>
					</div>
					<div class="d-flex flex-column text-primary-dark p-7 mr-24">
						<span class="font-md text-bold">Product</span>
						<span class="font-sm">002 - Micro Group</span>
					</div>
					<div class="d-flex flex-column text-primary-dark p-7 flex-1">
						<span class="font-md text-bold">Center Name</span>
						<span class="font-sm">Accasia Center</span>
					</div>
				</div>
				<div class="bb-dark-8"></div>
				<table class="table table-stripped mb-24">
					<thead>
						<th>Borrower's Name</th>
						<th>Date Loan</th>
						<th>Maturity</th>
						<th>Amnt. Loan</th>
						<th>Principal Bal.</th>
						<th>Interest Bal.</th>
						<th>Amort.</th>
						<th>Amnt. Due</th>
						<th># Days</th>
						<th>STATUS</th>
					</thead>
					<tbody>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr class="bg-skyblue text-bold">
							<td>CENTER SUB-TOTAL</td>
							<td></td>
							<td>22,222.00</td>
							<td>4,338.00</td>
							<td>0.00</td>
							<td></td>
							<td></td>
							<td>4,338.00</td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>

				<div class="d-flex bg-yellow-verylight mb-5">
					<div class="d-flex flex-column text-primary-dark p-7 mr-24">
						<span class="font-md text-bold">Account Officer</span>
						<span class="font-sm">001 - John Mark Barcenas</span>
					</div>
					<div class="d-flex flex-column text-primary-dark p-7 mr-24">
						<span class="font-md text-bold">Product</span>
						<span class="font-sm">002 - Micro Group</span>
					</div>
					<div class="d-flex flex-column text-primary-dark p-7 flex-1">
						<span class="font-md text-bold">Center Name</span>
						<span class="font-sm">Accasia Center</span>
					</div>
				</div>
				<div class="bb-dark-8"></div>
				<table class="table table-stripped mb-24">
					<thead>
						<th>Borrower's Name</th>
						<th>Date Loan</th>
						<th>Maturity</th>
						<th>Amnt. Loan</th>
						<th>Principal Bal.</th>
						<th>Interest Bal.</th>
						<th>Amort.</th>
						<th>Amnt. Due</th>
						<th># Days</th>
						<th>STATUS</th>
					</thead>
					<tbody>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr>
							<td>Aplayo, Marialyn M.</td>
							<td>05/10/2017</td>
							<td>11/06/2017</td>
							<td>7.000.00</td>
							<td>2,960.00</td>
							<td>0.00</td>
							<td>362.00</td>
							<td>2,956.00</td>
							<td>1,561.00</td>
							<td>PAST DUE</td>
						</tr>
						<tr class="bg-skyblue text-bold">
							<td>CENTER SUB-TOTAL</td>
							<td></td>
							<td>22,222.00</td>
							<td>4,338.00</td>
							<td>0.00</td>
							<td></td>
							<td></td>
							<td>4,338.00</td>
							<td></td>
							<td></td>
						</tr>
						<tr class="bg-green-mint text-bold">
							<td>PRODUCT SUB-TOTAL</td>
							<td></td>
							<td>22,222.00</td>
							<td>4,338.00</td>
							<td>0.00</td>
							<td></td>
							<td></td>
							<td>4,338.00</td>
							<td></td>
							<td></td>
						</tr>
						<tr class="bg-purple-light text-bold">
							<td>OFFICER SUB-TOTAL</td>
							<td></td>
							<td>22,222.00</td>
							<td>4,338.00</td>
							<td>0.00</td>
							<td></td>
							<td></td>
							<td>4,338.00</td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</section>
			<table class="table table-stripped">
				<tr class="bg-skyblue text-bold">
					<td>TOTAL</td>
					<td></td>
					<td>22,222.00</td>
					<td>4,338.00</td>
					<td>0.00</td>
					<td></td>
					<td></td>
					<td>4,338.00</td>
					<td></td>
					<td></td>
				</tr>
			</table> -->
		</section>

		<section class="d-flex flex-row mb-72">
			<span class="flex-2 pb-24 text-bold darker-bb mr-64">Prepared By:</span>
			<span class="flex-2 pb-24 text-bold darker-bb mr-64">Certified Corrected By:</span>
			<span class="flex-2 pb-24 text-bold darker-bb mr-64">Approved By:</span>
			<span class="flex-1"></span>
		</section>

		<div class="d-flex flex-row justify-content-end mb-45">
			<div class="d-flex flex-row-reverse">
				<a href="#" class="btn btn-default min-w-150">Print</a>
				<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
			</div>
		</div>
	</div>

</template>

<script>
export default {
	props:['pbranch', 'token'],
	data(){
		return {
			loading:false,
			branch:{},
			filter:{
				transaction_date:null,
				type:'loan_listing',
				branch_id:'',
				account_officer:'all',
				product:'all',
				center:'all',
				loan_status:'',
				report:'status_summary'
			},
			products:[],
			centers:[],
			aos:[],
			reports:[]
		}
	},
	methods:{
		async fetchReport(){
			this.loading = true;
			this.filter.branch_id = this.branch.branch_id;
			await axios.post(this.baseURL() + 'api/report/branch', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loading = false;
				this.reports = response.data.data
			}.bind(this))
			.catch(function (error) {
				this.loading = false;
				console.log(error);
			}.bind(this));
		},
		async fetchProducts(){
			axios.get(this.baseURL() + 'api/product', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.products = response.data.data;
				this.fetchAo();
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		async fetchAo(){
			await axios.get(this.baseURL() + 'api/accountofficer/', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.aos = response.data.data;
				this.fetchCenters();
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
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
		async fetchTransactionDate(){
			await axios.get(this.baseURL() + 'api/eod/eodtransaction/' + this.branch.branch_id,{
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.filter.transaction_date = response.data.data.date_end;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
		},
		print:function(){
			var content = document.getElementById('printContent').innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			window.print();
		},
		processCenter:function(centers, product){
			var result = [];
			if(product != 'Micro Group'){
				result = centers;
			}else{
				var ccc = [];
				for(var c in centers){
					if(c !== 'No Center'){
						ccc.push(c);
					}
				}
				var ccenters = ccc.sort(this.sortMicrofunction);
				ccenters.unshift('No Center');
				for(var a in ccenters){
					for(var b in centers){
						if(ccc[a] === b){
							result[b]=(centers[b]);
						}
					}
				}
			}
			return result;
		},
		sortMicrofunction:function(a,b) {
			a = a.toLowerCase();
			b = b.toLowerCase();
			if( a == b) return 0;
			return a < b ? -1 : 1;
		}
	},
	computed:{
		filteredReports:function(){
			var tables = [];
			var total = ['TOTAL',0,'','',0,0,0,'','','',0,'',''];
			this.reports.forEach(ao=>{
				var aoTotal = ['OFFICER SUB-TOTAL',0,'','',0,0,0,'','','',0,'',''];
				var hasAoAccounts = false;
				for(var p in ao.products){
					var hasProductAccounts = false;
					var product = ao.products[p];
					var productTotal = ['PRODUCT SUB-TOTAL',0,'','',0,0,0,'','','',0,'',''];
					for(var c in this.processCenter(product.centers, p)){
						var center = product.centers[c];
						var centerTotal = ['CENTER SUB-TOTAL',0,'','',0,0,0,'','','',0,'',''];
						if(center.accounts){
							var table = {
								ao:'0' + ao.ao_id + ' - ' + ao.name,
								product:product.product_code + ' - ' + product.product_name,
								center:c,
								rows:[],
								centerTotal:null,
								productTotal:null,
								aoTotal:null,
								total:null,
							}
							for(var ac in center.accounts){
								var account = center.accounts[ac];
								var sstatus = account.loan_status=='Ongoing'?account.status:account.loan_status;
								var row = [];
								row.push(account.borrower_name);
                                row.push(account.account_num);
								row.push(account.date_loan);
								row.push(account.maturity);
								centerTotal[1]++;
								productTotal[1]++;
								aoTotal[1]++;
								total[1]++;
								row.push(this.formatToCurrency(account.amount_loan));
								
								row.push(this.formatToCurrency(account.principal_balance));
								
								row.push(this.formatToCurrency(account.interest_balance));
								
								row.push(this.formatToCurrency(account.amortization));
								
                                row.push(account.distribution.short_principal + account.distribution.principal)
								
                                row.push(account.distribution.short_interest + account.distribution.interest)
								
								row.push(this.formatToCurrency(account.amount_due));
								
								row.push('');
								row.push(account.loan_status=='Ongoing'?account.status:account.loan_status);
								// if(sstatus == this.filter.loan_status){
									centerTotal[4] += account.amount_loan;
									centerTotal[5] += account.principal_balance;
									centerTotal[6] += account.interest_balance;
									// centerTotal[7] += account.amortization;
									// centerTotal[8] += account.distribution.short_principal + account.distribution.principal
									// centerTotal[9] += account.distribution.short_interest + account.distribution.interest
									centerTotal[10] += account.amount_due;
									table.rows.push(row);
								// }
							}
							productTotal[4] += centerTotal[4];
							productTotal[5] += centerTotal[5];
							productTotal[6] += centerTotal[6];
							// productTotal[7] += centerTotal[7];
							// productTotal[8] += centerTotal[8];
							// productTotal[9] += centerTotal[9];
							productTotal[10] += centerTotal[10];
							table.centerTotal = centerTotal;
							if(table.rows.length){
								tables.push(table);
							}
							hasProductAccounts = true;
							hasAoAccounts = true;
						}
					}
					aoTotal[4] += productTotal[4];
					aoTotal[5] += productTotal[5];
					aoTotal[6] += productTotal[6];
					// aoTotal[7] += productTotal[7];
					// aoTotal[8] += productTotal[8];
					// aoTotal[9] += productTotal[9];
					aoTotal[10] += productTotal[10];
					if(tables.length && hasProductAccounts){
						tables[tables.length-1].productTotal = productTotal;
					}
				}
				total[4] += aoTotal[4];
				total[5] += aoTotal[5];
				total[6] += aoTotal[6];
				// total[7] += aoTotal[7];
				// total[8] += aoTotal[8];
				// total[9] += aoTotal[9];
				total[10] += aoTotal[10];
				if(tables.length && hasAoAccounts){
					tables[tables.length-1].aoTotal = aoTotal;
				}
			})
			if(tables.length){
				tables[tables.length-1].total = total;
			}
			return tables;
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
		this.fetchProducts();
		this.fetchTransactionDate();
	}
}
</script>