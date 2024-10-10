<style>
.table-stripped td {
    word-wrap: break-word; /* Break words when they are too long to fit within the cell */
    word-break: break-word;
    vertical-align: top; /* Align cell content to the top */

}

.section-collection{
	text-align: center;
}

.table th, .table td{
	padding: 0.20rem;
}

.collection-sheet td {
	border-bottom: 1px dashed black;
}
.collection-sheet th {
	border-bottom: 1px dashed black;
}

</style>



<template>
	<div class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark" style="flex:4">Transactions</span>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<!-- <span class="mr-10">Date: </span>
				<input type="date" class="form-control"> -->
			</div>
			
			<div class="d-flex flex-row align-items-center mr-24" style="flex:3">
				<span class="mr-10">A.O: </span>
				<select v-model="filter.account_officer" name="" id="selectProductClient" class="form-control">
					<option v-for="ao in aos.filter(aa=>aa.status=='active'&&aa.branch_id==branch.branch_id)" :key="ao.ao_id" :value="ao.ao_id">{{ao.name}}</option>
				</select>
			</div>
			<div class="d-flex flex-row align-items-center" style="flex:3">
				<span class="mr-10">Center: </span>
				<select v-model="filter.center" name="" id="selectProductClient" class="form-control">
					<option v-for="center in centers" :key="center.center_id" :value="center.center_id">{{center.center}}</option>
				</select>
			</div>
		</div>
		<div class="sep mb-45"></div>
		<div id="printContent" class="mt-0.2" style="font-family: 'Courier New', Courier, monospace;">
			<!-- <img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt=""> -->
				<section class="" id="clientSection">
					<div class="d-flex justify-content-between align-items-center mb-36">
						<!-- Left column: Branch name and promissory note number -->
						<div class="d-flex flex-column flex-1">
							<span v-if="filter.account_officer" class="text-primary-dark font-25">
							<!-- //	{{branch.branch_name}} Branch ({{branch.branch_code}}) -->
							{{accountOfficer.name}}
							</span>
							<span class="text-bold"> {{centerName}}</span>
							
						</div>

						<!-- Center column: Promissory Note and Micro Access Loan Corporation -->
						<div class="d-flex flex-column text-center">
							<span class="font-26 text-bold text-primary-dark lh-1">
								COLLECTION SHEET REPORT
							</span>
							<span class="text-primary-dark text-bold font-md mb-5">
								MICRO ACCESS LOAN CORPORATION
							</span>
							<span class="text-center text-primary-dark text-bold">
								As of {{filter.as_of?dateToMDY2(new Date(filter.as_of)).split('-').join('/'):'---'}}
							</span>
						</div>

						<!-- Right column: Date and time -->
						<div class="d-flex flex-column flex-1 text-right">
							<span class="mr-10">
								{{dateFullDay(new Date())}} {{dateToYMD(new Date()).split('-').join('/')}}
							</span>
						</div>
					</div>
						<section class="d-flex flex-column mb-16">
							<div>
								<div class="d-flex flex-row" style="font-size:25px;">
								</div>
								
								<table class="table-stripped">
									<thead class="collection-sheet">
										<th style="min-width: 80px;">Client</th>
										<th style="min-width: 120px;">Date Loan</th>
										<th style="min-width: 120px;">Maturity Date</th>
										<th style="min-width: 120px;">Amount Loan</th>
										<th style="min-width: 120px;">Outstand Bal.</th>
										<th style="min-width: 120px;">Principal Bal.</th>
										<th style="min-width: 120px;">Delnqt</th>
										<th style="min-width: 120px;">Amt. Due</th>
										<th style="min-width: 120px;">Weekly Amort.</th>
										<th style="min-width: 120px;">Cont. #</th>
										<th style="min-width: 120px;">Payment</th>
									</thead>
									<tbody>
										<tr class="collection-sheet" v-for="c, i in collections.sort(sortClient)" :key="i">
											<td style="white-space: normal;">{{c.client}}</td>
											<td>{{c.date_loan.replaceAll('-','/')}}</td>
											<td>{{c.maturity_date.replaceAll('-','/')}}</td>
											<td>{{formatToCurrency(c.amount_loan)}}</td>
											<td>{{formatToCurrency(c.outstanding_balance)}}</td>
											<td>{{formatToCurrency(c.principal_balance)}}</td>
											<td>{{formatToCurrency(c.delinquent)}}</td>
											<td>{{formatToCurrency(c.amount_due)}}</td>
											<td>{{formatToCurrency(c.weekly_amortization)}}</td>
											<td style="white-space: normal;">{{c.contact}}</td>
											<td></td>
										</tr>
										<tr v-if="!collections.length"><td colspan="11"><i>No data available.</i></td></tr>
										<tr class="border-cell-gray-7">
											<td colspan="11"></td>
										</tr>
										<tr class="py-7">
											<td colspan="11"></td>
										</tr>
										<tr class="tr-py-7 text-bold bg-green-mint">
											<td>TOTAL</td>
											<td></td>
											<td>{{collections.length}}</td>
											<td v-for="t, i in total" :key="i">{{formatToCurrency(t)}}</td>
											<td colspan="7"></td>
										</tr>
									</tbody>
								</table>				
							</div>
						</section>
					
				</section>
		</div>
		<div class="d-flex flex-row block mb-45">
			<div class="d-flex justify-content-end block flex-1">
				<a @click="print()" href="#" class="btn btn-default min-w-150">Print</a>
			</div>
		</div>
	</div>

</template>

<script>
export default {
	props:['token','pbranch'],
	data(){
		return {
			branch:{branch_id:null,branch_code:null,branch_name:null},
			filter:{
				branch_id:'',
				account_officer:null,
				center:null,
				type:'collection'
			},
			collections:[],
			centers:[],
			aos:[]
		}
	},
	methods:{
		print: function() {
    var content = document.getElementById('printContent').innerHTML;
    var target = document.querySelector('.to-print');
    target.innerHTML = content;

    // Create a style element for print styles
    var style = document.createElement('style');
    style.type = 'text/css';
    style.media = 'print';

    style.innerHTML = `
        @media print {
            table {
                table-layout: fixed;
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                min-width: 80px;
                padding: 8px;
                text-align: left;
                border: 1px solid #000;
                word-wrap: break-word; /* Ensures long words wrap correctly */
            }
            .collection-sheet {
                font-size: 12px; /* Adjust font size for printing */
            }
        }
    `;

    // Add the print styles to the document head
    document.head.appendChild(style);

    window.onafterprint = function() {
        document.head.removeChild(style);
    };

    window.print();
}.bind(this),
		async fetchCollections(){
			await axios.post(this.baseURL() + 'api/report/branch', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				console.log(response);
				this.collections = response.data.data.data
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
					this.filter.as_of = response.data.data.date_end;
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
		sortClient:function(a, b){
			let aclient = a.client.toLowerCase(),
        		bclient = b.client.toLowerCase();

			if (aclient < bclient) {
				return -1;
			}
			if (aclient > bclient) {
				return 1;
			}
			return 0;
		}
	},
	computed:{
		total:function(){
			var row = [0,0,0,0,0,0,0];
			this.collections.forEach(c=>{
				row[0] += c.amount_loan;
				row[1] += c.outstanding_balance;
				row[2] += c.principal_balance;
				row[3] += c.delinquent;
				row[4] += c.penalty;
				row[5] += c.amount_due;
				row[6] += c.weekly_amortization;
			})
			return row;
		},
		accountOfficer:function(){
			var aos = this.aos.filter(ao=>ao.ao_id==this.filter.account_officer);
			return aos.length?aos[0]:[];
		},
		centerName:function(){
			return this.filter.center?this.centers.filter(c=>c.status=='active'&&c.center_id==this.filter.center)[0].center:'';
		}
	},
	watch:{
		filter:{
			handler(val){
				if(val.account_officer&&val.center){
					this.fetchCollections();
				}
			},
			deep:true
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch)
		this.filter.branch_id = this.branch.branch_id;
		this.fetchAo();
		this.fetchCenters();
		this.fetchTransactionDate();
	}
}
</script>