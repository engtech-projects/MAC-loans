<style>
.nowrap-row {
    white-space: nowrap;
    display: flex;
    align-items: center;
}

.nowrap-text {
    white-space: nowrap;
}
</style>
<template>
		<div class="d-flex flex-column" style="flex:8;">
			<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
				<div class="loading-container d-flex align-items-center justify-content-center mb-36">
					<span class="loading-text">LOADING</span>
					<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px;">
				</div>
				<span class="font-lg" style="color:#ddd;">Please wait until the process is complete</span>
			</div>
			<form ref="reportForm" @submit.prevent="generateReport" class="d-flex flex-row font-md align-items-center mb-16 needs-validation report-form" novalidate>
				<span class="font-lg text-primary-dark" style="flex:3">Transaction</span>
				<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
					<span class="mr-10">From: </span>
					<input v-model="filter.date_from" type="date" class="form-control" required>
				</div>
				<div class="d-flex flex-row align-items-center mr-64" style="flex:2">
					<span class="mr-10">To: </span>
					<input v-model="filter.date_to" type="date" class="form-control" required>
				</div>
				<div class="d-flex flex-row align-items-center" style="flex:4">
					<span class="mr-10">Type: </span>
					<select v-model="type" name="" id="selectProductClient" class="form-control" required>
						<option value="product">Summary Release and Payment by Product</option>
						<option value="client">Summary Release and Payment by Client</option>
					</select>
				</div>
				<div class="d-flex align-items-center mt-6">
					<span class="mr-10"> </span>
					<button type="submit" class="btn btn-primary">
						Generate
					</button>
				</div>
			</form>
			<div class="sep mb-45"></div>
			<div id="printContent">
				<img >

				<section v-if="type=='product'" class="" id="productSection">
					<div class="d-flex flex-column mb-16">
						<div class="d-flex flex-row align-items-center">
							<div class="flex-1"></div>
							<span class="font-30 text-bold text-primary-dark">SUMMARY RELEASE AND PAYMENT BY PRODUCT</span>
							<div class="flex-1 d-flex justify-content-end" style="padding-right:16px; @media print { display: none; }">
								<current-transactiondate :branch="branch" :token="token" :reports="true" @update-transaction-date="setTransactionDate"></current-transactiondate>
								<!-- <span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span> -->
							</div>
						</div>
						<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch_name + ' Branch (' + branch_code + ')'}}</span>
						<div class="d-flex flex-row justify-content-center text-primary-dark">
							<span class="mr-5">From:</span><span class="mr-16">{{filter.date_from?filter.date_from:'---'}}</span>
							<span class="mr-5">To:</span><span>{{filter.date_to?filter.date_to:'---'}}</span>
						</div>
					</div>
					<section class="d-flex flex-column mb-16">
						<span class="text-bold bg-yellow-light" style="padding:2px 5px;">RELEASES SUMMARY</span>
						<table class="table td-nb table-thin">
							<thead>
								<th>Reference</th>
								<th>Principal</th>
								<th>Interest</th>
								<th>Filing Fee</th>
								<th>Doc. Stamp</th>
								<th>Insurance</th>
								<th>Notarial</th>
								<th>Affidavit</th>
								<th>Deduct Bal</th>
								<th>Prepaid</th>
								<th>Net Proceeds</th>
							</thead>
							<tbody>
								<tr v-for="(prod,i) in transactions.product" :key="i">
									<td>{{prod.reference}}</td>
									<td>{{formatToCurrency(prod.release.principal)}}</td>
									<td>{{formatToCurrency(prod.release.interest)}}</td>
									<td>{{formatToCurrency(prod.release.filing_fee)}}</td>
									<td>{{formatToCurrency(prod.release.document_stamp)}}</td>
									<td>{{formatToCurrency(prod.release.insurance)}}</td>
									<td>{{formatToCurrency(prod.release.notarial_fee)}}</td>
									<td>{{formatToCurrency(prod.release.affidavit_fee)}}</td>
									<td>{{formatToCurrency(prod.release.memo)}}</td>
									<td>{{formatToCurrency(prod.release.prepaid_interest)}}</td>
									<td>{{formatToCurrency(prod.release.net_proceeds)}}</td>
								</tr>
								<tr class="border-cell-gray-7">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr class="tr-pt-7 text-bold">
									<td>TOTAL RELEASES</td>
									<td v-for="t,i in totalReleases" :key="i">{{formatToCurrency(t)}}</td>
								</tr>
							</tbody>
						</table>
						<div class="d-flex flex-row bg-yellow-pale p-5 align-items-center">
							<div class="d-flex flex-column flex-1 mr-64">
								<div class="d-flex flex-row flex-1 mb-5 nowrap-row">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24 nowrap-row">
										<span class="flex-1 nowrap-text">TOTAL CASH RELEASE</span>
										<span>:</span>
									</div>
									<span class="flex-1 nowrap-text">{{formatToCurrency(totalCash)}}</span>
								</div>
								<div class="d-flex flex-row flex-1 mb-5 nowrap-row">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24 nowrap-row">
										<span class="flex-1 nowrap-text">TOTAL CHECK RELEASE</span>
										<span>:</span>
									</div>
									<span class="flex-1 nowrap-text">{{formatToCurrency(totalCheck)}}</span>
								</div>
								<div class="d-flex flex-row flex-1 nowrap-row">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24 nowrap-row">
										<span class="flex-1 nowrap-text">TOTAL MEMO RELEASE</span>
										<span>:</span>
									</div>
									<span class="flex-1 nowrap-text">{{formatToCurrency(totalMemo)}}</span>
								</div>
							</div>
							<div class="d-flex flex-column flex-1">
								<div class="info-display">
									<span class="text-primary-dark text-bold">TOTAL RELEASES</span>
									<span class="text-primary-dark">{{formatToCurrency(totalCash + totalCheck)}}</span>
								</div>
							</div>
						<div class="flex-2"></div>
					</div>
					</section>
					<section class="d-flex flex-column flex-1">
						<span class="text-bold bg-skyblue" style="padding:2px 5px;">PAYMENT SUMMARY</span>
						<table class="table td-nb table-thin">
							<thead>
								<th>Reference</th>
								<th>Payment Type</th>
								<th>Principal</th>
								<th>Interest</th>
								<th>PD Int.</th>
								<th>Over</th>
								<th>Discount</th>
								<th>Total Payment</th>
								<th>VATable Int</th>
								<th>VATable PDI</th>
								<th>VAT</th>
							</thead>
							<tbody>
								<tr :class="rowBorders(p[0])" v-for="p,i in paymentSummary.row" :key="i">
									<td v-for="j,k in p" :key="k">{{p[0]=='TOTAL PRODUCT'&&k>1?formatToCurrency(j):j}}</td>
								</tr>
								<tr class="text-bold">
									<td style="padding:7px!important">TOTAL</td>
									<td style="padding:7px!important"></td>
									<td style="padding:7px!important">{{formatToCurrency(paymentSummary.total.principal)}}</td>
									<td style="padding:7px!important">{{formatToCurrency(paymentSummary.total.interest)}}</td>
									<td style="padding:7px!important">{{formatToCurrency(paymentSummary.total.pdint)}}</td>
									<td style="padding:7px!important">{{formatToCurrency(paymentSummary.total.over)}}</td>
									<td style="padding:7px!important">{{formatToCurrency(paymentSummary.total.discount)}}</td>
									<td style="padding:7px!important">{{formatToCurrency(paymentSummary.total.totalPayment)}}</td>
									<td style="padding:7px!important">{{formatToCurrency(paymentSummary.total.netInt)}}</td>
									<td style="padding:7px!important">{{formatToCurrency(paymentSummary.total.pdivat)}}</td>
									<td style="padding:7px!important">{{formatToCurrency(paymentSummary.total.vat)}}</td>
								</tr>
							</tbody>
						</table>

						<div class="d-flex flex-row bg-skyblue p-10 align-items-center mb-72">
							<div class="d-flex flex-column flex-1 mr-64">
								<div class="d-flex flex-row flex-1 mb-5 nowrap-row">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24 nowrap-row">
										<span class="flex-1 nowrap-text">TOTAL CASH PAYMENT</span>
										<span>:</span>
									</div>
									<span class="flex-1 nowrap-text">{{formatToCurrency(paymentSummaryTotal.cash)}}</span>
								</div>
								<div class="d-flex flex-row flex-1 mb-5 nowrap-row">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24 nowrap-row">
										<span class="flex-1 nowrap-text">TOTAL CHECK PAYMENT</span>
										<span>:</span>
									</div>
									<span class="flex-1 nowrap-text">{{formatToCurrency(paymentSummaryTotal.check)}}</span>
								</div>
								<!-- <div class="d-flex flex-row flex-1 mb-5">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1">TOTAL POS PAYMENT</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(paymentSummaryTotal.pos)}}</span>
								</div> -->
								<div class="d-flex flex-row flex-1 nowrap-row">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24 nowrap-row">
										<span class="flex-1 nowrap-text">TOTAL MEMO PAYMENT</span>
										<span>:</span>
									</div>
									<span class="flex-1 nowrap-text">{{formatToCurrency(paymentSummaryTotal.memo)}}</span>
								</div>
								<div class="d-flex flex-row flex-1 nowrap-row">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24 nowrap-row">
										<span class="flex-1 pl-24 nowrap-text">DED BALANCE</span>
										<span>:</span>
									</div>
									<span class="flex-1 nowrap-text">{{formatToCurrency(paymentSummaryTotal.dedbal)}}</span>
								</div>
								<div class="d-flex flex-row flex-1 nowrap-row">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24 nowrap-row">
										<span class="flex-1 pl-24 nowrap-text">OFFSET PF</span>
										<span>:</span>
									</div>
									<span class="flex-1 nowrap-text">{{formatToCurrency(paymentSummaryTotal.offsetPf)}}</span>
								</div>
								<!-- <div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1 pl-24">OVER PAYMENT</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(paymentSummaryTotal.overpayment)}}</span>
								</div> -->
								<div class="d-flex flex-row flex-1 nowrap-row">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24 nowrap-row">
										<span class="flex-1 pl-24 nowrap-text">DISCOUNT</span>
										<span>:</span>
									</div>
									<span class="flex-1 nowrap-text">{{formatToCurrency(paymentSummaryTotal.discount)}}</span>
								</div>
								<!-- <div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1 pl-24">CANCELLED</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(paymentSummaryTotal.cancelled)}}</span>
								</div> -->
								<div class="d-flex flex-row flex-1 nowrap-row">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24 nowrap-row">
										<span class="flex-1 pl-24 nowrap-text">BRANCH</span>
										<span>:</span>
									</div>
									<span class="flex-1 nowrap-text">{{formatToCurrency(paymentSummaryTotal.branch)}}</span>
								</div>
								<div class="d-flex flex-row flex-1 mb-5 nowrap-row">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24 nowrap-row">
										<span class="flex-1 nowrap-text">TOTAL POS PAYMENT</span>
										<span>:</span>
									</div>
									<span class="flex-1 nowrap-text">{{formatToCurrency(paymentSummaryTotal.pos)}}</span>
								</div>
							</div>
							<div class="d-flex flex-column flex-1">
								<div class="info-display">
									<span class="text-primary-dark text-bold">TOTAL PAYMENT</span>
									<span class="text-primary-dark">{{formatToCurrency(paymentSummaryTotal.cash + paymentSummaryTotal.check + paymentSummaryTotal.pos + paymentSummaryTotal.memo)}}</span>
								</div>
							</div>
							<div class="flex-2"></div>
						</div>
					</section>
				</section>

				<section v-else id="clientSection">
					<div class="d-flex flex-column mb-16">
						<div class="d-flex flex-row align-items-center">
							<div class="flex-1"></div>
							<span class="font-30 text-bold text-primary-dark">SUMMARY RELEASE AND PAYMENT BY CLIENT</span>
							<div class="flex-1 d-flex justify-content-end" style="padding-right:16px; @media print { display: none; } ">
								<current-transactiondate :branch="branch" :token="token" :reports="true"></current-transactiondate>
								<!-- <span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span> -->
							</div>
						</div>
						<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch_name + ' Branch (' + branch_code + ')'}}</span>
						<div class="d-flex flex-row justify-content-center text-primary-dark">
							<span class="mr-5">From:</span><span class="mr-16">{{filter.date_from?filter.date_from:'---'}}</span>
							<span class="mr-5">To:</span><span>{{filter.date_to?filter.date_to:'---'}}</span>
						</div>
					</div>
					<section class="d-flex flex-column mb-16">
						<span class="text-bold bg-yellow-light" style="padding:2px 5px;">RELEASES SUMMARY</span>
						<table class="table td-nb table-thin">
							<thead>
								<th>Borrower's Name</th>
								<th>Date Loan</th>
								<th>Term</th>
								<th>Amount Loan</th>
								<th>Fil. Fee</th>
								<th>D.S</th>
								<th>Ins.</th>
								<th>Notarial</th>
								<th>Affidavit</th>
								<th>Ded. Bal</th>
								<th>Prep</th>
								<th>Net Prcds</th>
								<th>Type</th>
							</thead>
							<tbody v-if="transactions">
								<tr v-for="t,i in transactions?.client?.release?.sort((a, b) => a.borrower.localeCompare(b.borrower))" :key="i">
									<td>{{t.borrower}}</td>
									<td>{{t.date_loan}}</td>
									<td>{{t.term}}</td>
									<td>{{formatToCurrency(t.amount_loan)}}</td>
									<td>{{formatToCurrency(t.filing_fee)}}</td>
									<td>{{formatToCurrency(t.document_stamp)}}</td>
									<td>{{formatToCurrency(t.insurance)}}</td>
									<td>{{formatToCurrency(t.notarial_fee)}}</td>
									<td>{{formatToCurrency(t.affidavit_fee)}}</td>
									<td>{{formatToCurrency(t.memo)}}</td>
									<td>{{formatToCurrency(t.prepaid_interest)}}</td>
									<td>{{formatToCurrency(t.net_proceeds)}}</td>
									<td>{{t.type.toUpperCase()}}</td>
								</tr>
								<tr class="border-cell-gray-7">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr class="tr-pt-7 text-bold">
									<td>TOTAL</td>
									<td></td>
									<td></td>
									<td v-for="c,i in totalReleasesClient" :key="i">{{formatToCurrency(c)}}</td>
									<td></td>
								</tr>
							</tbody>
							<tbody v-else>
								<tr>
									<td colspan="13">NO DATA</td>
								</tr>
							</tbody>
						</table>
						<div class="d-flex flex-row bg-yellow-pale p-5 align-items-center">
							<div class="d-flex flex-column flex-1 mr-64">
								<div class="d-flex flex-row flex-1 mb-5">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1">TOTAL CASH RELEASE</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(totalCashClient)}}</span>
								</div>
								<div class="d-flex flex-row flex-1 mb-5">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1">TOTAL CHECK RELEASE</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(totalCheckClient)}}</span>
								</div>
								<div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1">TOTAL MEMO RELEASE</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(totalMemoClient)}}</span>
								</div>
							</div>
							<div class="d-flex flex-column flex-1">
								<div class="info-display">
									<span class="text-primary-dark text-bold">TOTAL RELEASES</span>
									<span class="text-primary-dark">{{formatToCurrency(totalCashClient + totalCheckClient)}}</span>
								</div>
							</div>
							<div class="flex-2"></div>
						</div>
					</section>
					<section class="d-flex flex-column flex-1">
						<span class="text-bold bg-skyblue" style="padding:2px 5px;">COLLECTION REPORT</span>
						<table class="table td-nb table-thin">
							<thead>
								<th>Borrower's Name</th>
								<th>Date Pay</th>
								<th>O.R#</th>
								<th>Principal</th>
								<th>Int.</th>
								<th>PD Int.</th>
								<th>Over</th>
								<th>Discount</th>
								<th>Tot. Payment</th>
								<th>Net Int.</th>
								<th>VAT</th>
								<th>Type</th>
							</thead>
							<tbody v-if="transactions">
								<tr v-for="t,i in transactions?.client?.collection?.sort((a, b) => a.borrower.localeCompare(b.borrower))" :key="i">
									<td>{{t.borrower}}</td>
									<td>{{t.date_paid}}</td>
									<td>{{t.or}}</td>
									<td>{{formatToCurrency(t.principal)}}</td>
									<td>{{formatToCurrency(t.interest)}}</td>
									<td>{{formatToCurrency(t.pdi)}}</td>
									<td>{{formatToCurrency(t.over)}}</td>
									<td>{{formatToCurrency(t.discount)}}</td>
									<td>{{formatToCurrency(t.total_payment)}}</td>
									<td>{{formatToCurrency(t.net_int)}}</td>
									<td>{{formatToCurrency(t.vat)}}</td>
									<td>{{t.payment_type}}</td>
								</tr>
								<tr class="border-cell-gray-7">
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr class="tr-pt-7 text-bold">
									<td>TOTAL</td>
									<td></td>
									<td></td>
									<td v-for="c,i in totalCollectionClient" :key="i">{{formatToCurrency(c)}}</td>
									<td></td>
								</tr>
							</tbody>
							<tbody v-else>
								<tr>
									<td colspan="13">NO DATA</td>
								</tr>
							</tbody>
						</table>

						<div class="d-flex flex-row bg-skyblue p-10 align-items-center mb-72">
							<div class="d-flex flex-column flex-1 mr-64">
								<div class="d-flex flex-row flex-1 mb-5">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1">TOTAL CASH PAYMENT</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(totalCashClientCollection)}}</span>
								</div>
								<div class="d-flex flex-row flex-1 mb-5">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1">TOTAL CHECK PAYMENT</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(totalCheckClientCollection)}}</span>
								</div>
								<div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1">TOTAL MEMO PAYMENT</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(totalMemoClientCollection)}}</span>
								</div>
								<div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1 pl-24">DED BALANCE</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(totalDeductToBalanceMemo)}}</span>
								</div>
								<div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1 pl-24">OFFSET PF</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(totalOffsetMemo)}}</span>
								</div>
								
								<div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1 pl-24">DISCOUNT</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(totalRebatesDiscountMemo)}}</span>
								</div>
								
								<div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1 pl-24">BRANCH</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(totalInterbranchMemo)}}</span>
								</div>
								<div class="d-flex flex-row flex-1 mb-5">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1">TOTAL POS PAYMENT</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(totalPosClientCollection)}}</span>
								</div>
							</div>
							<div class="d-flex flex-column flex-1">
								<div class="info-display">
									<span class="text-primary-dark text-bold" >TOTAL PAYMENT</span>
									<span class="text-primary-dark">{{formatToCurrency(totalCashClientCollection + totalCheckClientCollection + totalPosClientCollection + totalMemoClientCollection)}}</span>
								</div>
							</div>
							<div class="flex-2"></div>
						</div>
					</section>
				</section>
			
				<section class="d-flex flex-row mb-72">
					<span class="flex-2 pb-24 text-bold darker-bb mr-64">Prepared By:</span>
					<span class="flex-2 pb-24 text-bold darker-bb mr-64">Certified Corrected By:</span>
					<span class="flex-2 pb-24 text-bold darker-bb mr-64">Approved By:</span>
					<span class="flex-1"></span>
				</section>
				<!-- <div class="d-flex mb-64">
					<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
				</div> -->
			</div>
			
			<div class="d-flex flex-row-reverse mb-45">
				<a @click="print()" href="#" class="btn btn-default min-w-150">Print</a>
				 <!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
			</div>
		</div>
</template>

<script>
export default {
	props:['token','branch','branch_name','branch_code'],
	data(){
		return {
			loading:false,
			type:'product',
			transactions:{product:[],client:{release:[],collection:[]}},
			filter:{
				date_from:'',
				date_to:'',
				branch_id:'',
			},
			paymentSummaryTotal:{
				cash:0,
				check:0,
				memo:0,
				dedbal:0,
				offsetPf:0,
				overpayment:0,
				discount:0,
				cancelled:0,
				branch:0,
				pos:0
			}
		}
	},
	methods:{
		generateReport(){
			const { date_from, date_to} = this.filter;
			const form = this.$refs.reportForm;

				if (!form.checkValidity()) {
					form.reportValidity(); // Show native browser tooltips
					return;
				}

				// Prepare payload
				const payload = {
					date_from,
					date_to,
				};
				
				this.fetchTransactions(payload);
		},
		async fetchTransactions(){
			this.loading = true;
			await axios.post(this.baseURL() + 'api/report/transaction', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loading = false;
				this.transactions = response.data.data;
				console.log(response.data.data);
			}.bind(this))
			.catch(function (error) {
				this.loading = false;
				console.log(error);
			}.bind(this));
		},
		setTransactionDate(transactionDate) {
			this.filter.date_from = transactionDate;
			this.filter.date_to = transactionDate;
		},
		print:function(){
			var content = document.getElementById('printContent').innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			
			var style = document.createElement('style');
				style.innerHTML =  `
						@media print {
							@page {
								size: 8.5in 11in portrait; /* Custom paper size */
								margin: 0.11in 0.25in; 
								
							}
							body {
								margin: 0.11in 0.25in; 
								font-weight: bolder;
							}
							.to-print {
								transform: scale(108px); /* Custom scale of 75% for print */
								transform-origin: top left; /* Ensure scaling starts from the top left */
							}
						}
					`;
			document.head.appendChild(style);
			window.print();
			window.onafterprint = function() {
				document.head.removeChild(style);
			};
		},
		rowBorders:function(str){
			if(str == ' '){
				return 'border-cell-dashed';
			}else if(str == '  '){
				return 'border-cell-gray-7-dark'
			}else if(str == 'TOTAL PRODUCT'){
				return 'text-bold'
			}
		},
		collectionTotal:function(val){
			var amount = 0;
			if(this.transactions.client.collection){
				this.transactions.client.collection.forEach(p=>{
					// row[0] += p.principal;
					// row[1] += p.interest;
					// row[2] += p.pdi;
					// row[3] += p.over;
					// row[4] += p.discount;
					// row[5] += p.total_payment;
					// row[6] += p.net_int;
					// row[7] += p.vat;
					amount += p[val];
				})
				return amount;
			}
		}
	},
	computed:{
		totalReleases:function(){
			var row = [0,0,0,0,0,0,0,0,0,0];
			if(this.transactions.product){
				this.transactions.product.forEach(p=>{
					row[0] += p.release.principal;
					row[1] += p.release.interest;
					row[2] += p.release.filing_fee;
					row[3] += p.release.document_stamp;
					row[4] += p.release.insurance;
					row[5] += p.release.notarial_fee;
					row[6] += p.release.affidavit_fee;
					row[7] += p.release.memo;
					row[8] += p.release.prepaid_interest;
					row[9] += p.release.net_proceeds;
				})
			}
			
			return row;
		},
		totalReleasesClient:function(){
			var row = [0,0,0,0,0,0,0,0,0];
			if(this.transactions.client.release){
				this.transactions.client.release.forEach(p=>{
					row[0] += p.amount_loan;
					row[1] += p.filing_fee;
					row[2] += p.document_stamp;
					row[3] += p.insurance;
					row[4] += p.notarial_fee;
					row[5] += p.affidavit_fee;
					row[6] += p.memo;
					row[7] += p.prepaid_interest;
					row[8] += p.net_proceeds;
				})
			}
			
			return row;
		},
		totalCollectionClient:function(){
			var row = [0,0,0,0,0,0,0,0];
			if(this.transactions.client.collection){
				this.transactions.client.collection.forEach(p=>{
					row[0] += p.principal;
					row[1] += p.interest;
					row[2] += p.pdi;
					row[3] += p.over;
					row[4] += p.discount;
					row[5] += p.total_payment;
					row[6] += p.net_int;
					row[7] += p.vat;
				})
			}
			
			return row;
		},
		totalCash:function(){
			var amount = 0;
			this.transactions.product.forEach(p=>{
				amount += p.release.cash;
			})
			return amount;
		},
		totalCheck:function(){
			var amount = 0;
			this.transactions.product.forEach(p=>{
				amount += p.release.check;
			})
			return amount;
		},
		totalMemo:function(){
			var amount = 0;
			this.transactions.product.forEach(p=>{
				amount += p.release.memo;
			})
			return amount;
		},
		totalCashClient:function(){
			var amount = 0;
			if(this.transactions.client.release){
				this.transactions.client.release.forEach(p=>{
					if(p.type == 'Cash'){
						amount += p.net_proceeds;
					}
				})
			}
			return amount;
		},
		totalCheckClient:function(){
			var amount = 0;
			if(this.transactions.client.release){
				this.transactions.client.release.forEach(p=>{
					if(p.type == 'Check'){
						amount += p.net_proceeds;
					}
				})
			}
			return amount;
		},
		totalMemoClient:function(){
			var amount = 0;
			if(this.transactions.client.release){
				this.transactions.client.release.forEach(p=>{
					amount += p.memo;
				})
			}
			return amount;
		},
		totalCashClientCollection:function(){
			var amount = 0;
			if(this.transactions.client.collection){
				this.transactions.client.collection.forEach(p=>{
					if(p.payment_type == 'Cash Payment'){
						amount += p.total_payment;
					}
				})
			}
			
			return amount;
		},
		totalCheckClientCollection:function(){
			var amount = 0;
			if(this.transactions.client.collection){
				this.transactions.client.collection.forEach(p=>{
					if(p.payment_type == 'Check Payment'){
						amount += p.total_payment;
					}
				})
			}
			return amount;
		},
		totalPosClientCollection:function(){
			var amount = 0;
			if(this.transactions.client.collection){
				this.transactions.client.collection.forEach(p=>{
					if(p.payment_type == 'POS'){
						amount += p.total_payment;
					}
				})
			}
			return amount;
		},
		totalMemoClientCollection:function(){
			var amount = 0;
			if(this.transactions.client.collection){
				this.transactions.client.collection.forEach(p=>{
					if(p.payment_type == 'Memo'){
						amount += p.total_payment;
					}
				})
			}
			return amount;
		},

		paymentSummary:function(){
			var result = {row:[],total:{principal:0,interest:0,pdint:0,over:0,discount:0,totalPayment:0,netInt:0,pdivat:0,vat:0}};
			this.paymentSummaryTotal = {
				cash:0,
				check:0,
				memo:0,
				dedbal:0,
				offsetPf:0,
				overpayment:0,
				discount:0,
				cancelled:0,
				branch:0,
				pos:0
			}
			this.transactions.product.forEach((t,p)=>{
				var totalRow = ['TOTAL PRODUCT', '',0,0,0,0,0,0,0,0,0];
				var index = 2;
				var refIndex = 0;
				for(var i in t.payment){
					index = 2
					i=='Cash Payment'? this.paymentSummaryTotal.cash += t.payment[i].total_payment:false;
					i=='Check Payment'? this.paymentSummaryTotal.check += t.payment[i].total_payment:false;
					i=='Memo'? this.paymentSummaryTotal.memo += t.payment[i].total_payment:false;
					i=='POS'? this.paymentSummaryTotal.pos += t.payment[i].total_payment:false;
					if(i == 'Memo'){
						this.paymentSummaryTotal.overpayment += t.payment[i].over;
						// if(t.payment[i].memo["Rebates and Discount"]){
						// 	this.paymentSummaryTotal.discount += t.payment[i].memo["Rebates and Discount"];
						// }
						if(t.payment[i].memo["deduct to balance"]){
							this.paymentSummaryTotal.dedbal += t.payment[i].memo["deduct to balance"];
						}
						if(t.payment[i].memo["Offset PF"]){
							this.paymentSummaryTotal.offsetPf += t.payment[i].memo["Offset PF"];
						}
						if(t.payment[i].memo["Interbranch"]){
							this.paymentSummaryTotal.branch += t.payment[i].memo["Interbranch"];
						}
					}
					this.paymentSummaryTotal.discount += t.payment[i].discount;
					var row = [];
					row.push(!refIndex==0?'':t.reference);
					refIndex++
					row.push(i.toUpperCase());
					row.push(this.formatToCurrency(t.payment[i].principal));
					totalRow[index] += t.payment[i].principal;
					result.total.principal += t.payment[i].principal;
					index++;
					row.push(this.formatToCurrency(t.payment[i].interest));
					totalRow[index] += t.payment[i].interest;
					result.total.interest += t.payment[i].interest;
					index++;
					row.push(this.formatToCurrency(t.payment[i].pdi));
					totalRow[index] += t.payment[i].pdi;
					result.total.pdint += t.payment[i].pdi;
					index++;
					row.push(this.formatToCurrency(t.payment[i].over));
					totalRow[index] += t.payment[i].over;
					result.total.over += t.payment[i].over;
					index++;
					row.push(this.formatToCurrency(t.payment[i].discount));
					totalRow[index] += t.payment[i].discount;
					result.total.discount += t.payment[i].discount;
					index++;
					row.push(this.formatToCurrency(t.payment[i].total_payment));
					totalRow[index] += t.payment[i].total_payment;
					result.total.totalPayment += t.payment[i].total_payment;
					index++;
					row.push(this.formatToCurrency(t.payment[i].interest/1.12));
					totalRow[index] += t.payment[i].interest/1.12;
					result.total.netInt += t.payment[i].interest/1.12;
					index++;
					row.push(this.formatToCurrency(t.payment[i].pdi/1.12));
					totalRow[index] += t.payment[i].pdi/1.12;
					result.total.pdivat += t.payment[i].pdi/1.12;
					index++;
					row.push(this.formatToCurrency(t.payment[i].vat));
					totalRow[index] += t.payment[i].vat;
					result.total.vat += t.payment[i].vat;
					result.row.push(row);
				}
				if(index != 2){
					result.row.push([' ','','','','','','','','','',''])
					result.row.push(totalRow)
					result.row.push(['  ','','','','','','','','','',''])
				}
			})
			return result;
		},

		paymentSummaryTotalCash:function(){
			var amount = 0;
			this.transactions.product.forEach((t,p)=>{
				for(var i in t.payment){
					i=='Cash Payment'? amount += t.payment[i].total_payment:false;
				}
			})
			return amount;
		},
		paymentSummaryTotalCheck:function(){
			var amount = 0;
			this.transactions.product.forEach((t,p)=>{
				for(var i in t.payment){
					i=='Check Payment'? amount += t.payment[i].total_payment:false;
				}
			})
			return amount;
		},
		paymentSummaryTotalMemo:function(){
			var amount = 0;
			this.transactions.product.forEach((t,p)=>{
				for(var i in t.payment){
					i=='Memo'? amount += t.payment[i].total_payment:false;
				}
			})
			return amount;
		},
		totalDeductToBalanceMemo:function(){
			var amount = 0;
			if(this.transactions.client.collection){
				this.transactions.client.collection.forEach(p=>{
					if(p.memo_type && p.memo_type == 'deduct to balance'){
						amount += p.total_payment;
					}
				})
			}
			return amount;
		},
		totalInterbranchMemo:function(){
			var amount = 0;
			if(this.transactions.client.collection){
				this.transactions.client.collection.forEach(p=>{
					if(p.memo_type && p.memo_type == 'Interbranch'){
						amount += p.total_payment;
					}
				})
			}
			return amount;
		},
		totalOffsetMemo:function(){
			var amount = 0;
			if(this.transactions.client.collection){
				this.transactions.client.collection.forEach(p=>{
					if(p.memo_type && p.memo_type == 'Offset PF'){
						amount += p.total_payment;
					}
				})
			}
			return amount;
		},
		totalRebatesDiscountMemo:function(){
			var amount = 0;
			if(this.transactions.client.collection){
				this.transactions.client.collection.forEach(p=>{
					amount += p.discount;
					// if(p.memo_type && p.memo_type == 'Rebates and Discount'){
					// 	amount += p.total_payment;
					// }
				})
			}
			return amount;
		},
	},
	mounted(){
		this.filter.branch_id = this.branch;
	}
}
</script>