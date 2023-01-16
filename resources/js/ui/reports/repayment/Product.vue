<template>
	<div class="d-flex flex-column" style="flex:8;min-height:1600px">
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark" style="flex:3">Transaction</span>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">From: </span>
				<input @change="filter.date_from&&filter.date_to?fetchReports():0" v-model="filter.date_from" type="date" class="form-control">
			</div>
			<div class="d-flex flex-row align-items-center" style="flex:2">
				<span class="mr-10">To: </span>
				<input @change="filter.date_from&&filter.date_to?fetchReports():0" v-model="filter.date_to" type="date" class="form-control">
			</div>
			<div class="d-flex flex-row align-items-center mr-24 hide" style="flex:2">
				<span class="mr-10">Type: </span>
				<select name="" id="selectProductClient" class="form-control">
					<option value="all_records">All Records</option>
					<option value="new_accounts">New Accounts</option>
					<option value="">By Center</option>
					<option value="">By Product</option>
					<option value="">By Account Officer</option>
				</select>
			</div>
			<div class="d-flex flex-row align-items-center hide" style="flex:2">
				<span class="mr-10">Spec: </span>
				<select name="" id="selectProductClient" class="form-control">
					<option value="">Allotment Loan</option>
					<option value="">Micro Group</option>
					<option value="">Micro Individual</option>
					<option value="">Pension Emergency</option>
					<option value="">Pension Loan</option>
					<option value="">SME Loan</option>
				</select>
			</div>
		</div>
		<div class="sep mb-45"></div>
		<div id="printContent">
			<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">

			<section class="" id="clientSection">
				<div class="d-flex flex-column mb-16">
					<div class="d-flex flex-row align-items-center">
						<div class="flex-1"></div>
						<span class="font-30 text-bold text-primary-dark">SUMMARY RELEASE AND PAYMENT BY PRODUCT</span>
						<div class="flex-1" style="padding-left:24px">
							<span class="text-primary-dark mr-10">{{dateFullDay(new Date())}} {{dateToYMD(new Date()).split('-').join('/')}}</span>
							<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
						</div>
					</div>
					<span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name + ' Branch (' + branch.branch_code + ')'}}</span>
					<div v-if="filter.date_from&&filter.date_to" class="d-flex flex-row justify-content-center text-primary-dark">
						<span class="mr-5">From:</span><span class="mr-16">{{dateToMDY2(new Date(filter.date_from)).split('-').join('/')}}</span>
						<span class="mr-5">To:</span><span>{{dateToMDY2(new Date(filter.date_to)).split('-').join('/')}}</span>
					</div>
					<div v-else class="d-flex flex-row justify-content-center text-primary-dark">
						<span class="mr-5">From:</span><span class="mr-16">---</span>
						<span class="mr-5">To:</span><span>---</span>
					</div>
				</div>
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
								<th>Net Int.</th>
								<th>VAT</th>
							</thead>
							<tbody>
								<tr :class="rowBorders(p[0])" v-for="p,i in paymentSummary" :key="i">
									<td v-for="j,k in p" :key="k">{{p[0]=='TOTAL PRODUCT'&&k>1?formatToCurrency(j):j}}</td>
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
									<span class="flex-1">{{formatToCurrency(paymentSummaryTotal.cash)}}</span>
								</div>
								<div class="d-flex flex-row flex-1 mb-5">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1">TOTAL CHECK PAYMENT</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(paymentSummaryTotal.check)}}</span>
								</div>
								<!-- <div class="d-flex flex-row flex-1 mb-5">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1">TOTAL POS PAYMENT</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(paymentSummaryTotal.pos)}}</span>
								</div> -->
								<div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1">TOTAL MEMO PAYMENT</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(paymentSummaryTotal.memo)}}</span>
								</div>
								<div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1 pl-24">DED BALANCE</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(paymentSummaryTotal.dedbal)}}</span>
								</div>
								<div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1 pl-24">OFFSET PF</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(paymentSummaryTotal.offsetPf)}}</span>
								</div>
								<!-- <div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1 pl-24">OVER PAYMENT</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(paymentSummaryTotal.overpayment)}}</span>
								</div> -->
								<div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1 pl-24">DISCOUNT</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(paymentSummaryTotal.discount)}}</span>
								</div>
								<!-- <div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1 pl-24">CANCELLED</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(paymentSummaryTotal.cancelled)}}</span>
								</div> -->
								<div class="d-flex flex-row flex-1">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1 pl-24">BRANCH</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(paymentSummaryTotal.branch)}}</span>
								</div>
								<div class="d-flex flex-row flex-1 mb-5">
									<div class="d-flex flex-row justify-content-between flex-2 mr-24">
										<span class="flex-1">TOTAL POS PAYMENT</span>
										<span>:</span>
									</div>
									<span class="flex-1">{{formatToCurrency(paymentSummaryTotal.pos)}}</span>
								</div>
							</div>
							<div class="d-flex flex-column flex-1">
								<div class="info-display">
									<span class="text-primary-dark">TOTAL PAYMENT</span>
									<span class="text-primary-dark">{{formatToCurrency(paymentSummaryTotal.cash + paymentSummaryTotal.check + paymentSummaryTotal.memo + paymentSummaryTotal.pos)}}</span>
								</div>
							</div>
							<div class="flex-2"></div>
						</div>
					</section>
				<!-- <section class="d-flex flex-column mb-72">
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
							<tr>
								<td>0063 - Pension Loan</td>
								<td>8,500.00</td>
								<td>2,435.00</td>
								<td>121.00</td>
								<td>41.66</td>
								<td>500.00</td>
								<td>200.00</td>
								<td>0.00</td>
								<td>1,484.00</td>
								<td>0.00</td>
								<td>6,347.00</td>
							</tr>
							<tr>
								<td>0064 - Micro Group</td>
								<td>8,500.00</td>
								<td>2,435.00</td>
								<td>121.00</td>
								<td>41.66</td>
								<td>500.00</td>
								<td>200.00</td>
								<td>0.00</td>
								<td>1,484.00</td>
								<td>0.00</td>
								<td>6,347.00</td>
							</tr>
							<tr>
								<td>0065 - Salary Loan</td>
								<td>8,500.00</td>
								<td>2,435.00</td>
								<td>121.00</td>
								<td>41.66</td>
								<td>500.00</td>
								<td>200.00</td>
								<td>0.00</td>
								<td>1,484.00</td>
								<td>0.00</td>
								<td>6,347.00</td>
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
							<tr class="tr-pt-7">
								<td>TOTAL RELEASES</td>
								<td>122,500.00</td>
								<td>8,435.00</td>
								<td>121.00</td>
								<td>41.66</td>
								<td>500.00</td>
								<td>200.00</td>
								<td>0.00</td>
								<td>1,484.00</td>
								<td>0.00</td>
								<td>20,347.00</td>
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
								<span class="flex-1">6,347.00</span>
							</div>
							<div class="d-flex flex-row flex-1 mb-5">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL CHECK RELEASE</span>
									<span>:</span>
								</div>
								<span class="flex-1">0.00</span>
							</div>
							<div class="d-flex flex-row flex-1">
								<div class="d-flex flex-row justify-content-between flex-2 mr-24">
									<span class="flex-1">TOTAL MEMO RELEASE</span>
									<span>:</span>
								</div>
								<span class="flex-1">1,484.00</span>
							</div>
						</div>
						<div class="d-flex flex-column flex-1">
							<div class="info-display">
								<span class="text-primary-dark">TOTAL RELEASES</span>
								<span class="text-primary-dark">17,000.00</span>
							</div>
						</div>
						<div class="flex-2"></div>
					</div>
				</section> -->
				
			</section>
			<div class="d-flex mb-64 mt-auto">
				<img :src="this.baseURL()+'/img/logo-footer.png'" class="w-100" alt="">
			</div>
		</div>
		<div class="d-flex flex-row justify-content-between mb-45">
			<div class="d-flex flex-row-reverse justify-content-start flex-1">
				<a @click="print()" href="#" class="btn btn-default min-w-150">Print</a>
				<!-- <a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a> -->
			</div>
		</div>
	</div>

</template>

<script>
export default {
	props:['pbranch','token'],
	data(){
		return {
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
			},
			filter:{
				date_from:null,
				date_to:null,
				type:'product',
				branch_id:''
			},
			branch:{
				branch_id:null,
				branch_name:'',
				branch_code:''
			},
			reports:[],
		}
	},
	methods:{
		async fetchReports(){
			await axios.post(this.baseURL() + 'api/report/repayment', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.reports = response.data
				console.log(response.data);
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
		rowBorders:function(str){
			if(str == ' '){
				return 'border-cell-dashed';
			}else if(str == '  '){
				return 'border-cell-gray-7-dark'
			}else if(str == 'TOTAL PRODUCT'){
				return 'text-bold'
			}
		},
	},
	computed:{
		paymentSummary:function(){
			var result = [];
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
			this.reports.forEach((t,p)=>{
				var totalRow = ['TOTAL PRODUCT', '',0,0,0,0,0,0,0,0];
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
						this.paymentSummaryTotal.discount += t.payment[i].memo["Rebates and Discount"]?t.payment[i].memo["Rebates and Discount"]:0;
						this.paymentSummaryTotal.dedbal += t.payment[i].memo["deduct to balance"]?t.payment[i].memo["deduct to balance"]:0;
						this.paymentSummaryTotal.offsetPf += t.payment[i].memo["Offset PF"]?t.payment[i].memo["Offset PF"]:0;
						this.paymentSummaryTotal.branch += t.payment[i].memo["Interbranch"]?t.payment[i].memo["Interbranch"]:0;
					}
					var row = [];
					row.push(!refIndex==0?'':t.reference);
					refIndex++
					row.push(i.toUpperCase());
					row.push(this.formatToCurrency(t.payment[i].principal));
					totalRow[index] += t.payment[i].principal;
					index++;
					row.push(this.formatToCurrency(t.payment[i].interest));
					totalRow[index] += t.payment[i].interest;
					index++;
					row.push(this.formatToCurrency(t.payment[i].pdi));
					totalRow[index] += t.payment[i].pdi;
					index++;
					row.push(this.formatToCurrency(t.payment[i].over));
					totalRow[index] += t.payment[i].over;
					index++;
					row.push(this.formatToCurrency(t.payment[i].discount));
					totalRow[index] += t.payment[i].discount;
					index++;
					row.push(this.formatToCurrency(t.payment[i].total_payment));
					totalRow[index] += t.payment[i].total_payment;
					index++;
					row.push(this.formatToCurrency(t.payment[i].net_int));
					totalRow[index] += t.payment[i].net_int;
					index++;
					row.push(this.formatToCurrency(t.payment[i].vat));
					totalRow[index] += t.payment[i].vat;
					result.push(row);
				}
				if(index != 2){
					result.push([' ','','','','','','','','',''])
					result.push(totalRow)
					result.push(['  ','','','','','','','','',''])
				}
			})
			return result;
		},
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
		this.filter.branch_id = this.branch.branch_id;
	}
}
</script>