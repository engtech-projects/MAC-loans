<template>
    <div class="d-flex flex-column" style="flex: 8">
        <div class="d-flex flex-row font-md mb-16">
            <span class="flex-2"></span>
            <div
                class="d-flex flex-row align-items-center mr-24"
                style="flex: 1"
            >
                <span class="mr-10">Date From: </span>
                <input v-model="filter.date_from" type="date" class="form-control flex-1" />
            </div>
            <div class="d-flex flex-row align-items-center" style="flex: 1">
                <span class="mr-10">Date To: </span>
                <input v-model="filter.date_to" type="date" class="form-control flex-1" />
            </div>
        </div>
        <div class="sep mb-45"></div>
        <img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">

        <section class="mb-72" id="performanceReport">
            <div class="d-flex flex-column mb-24">
                <div class="d-flex flex-row align-items-center">
                    <div class="flex-1 d-flex flex-column"></div>
                    <span
                        class="font-30 text-bold text-primary-dark text-center"
                        >Loan Interest Collected From Microfinance Unit</span
                    >
                    <div class="flex-1 d-flex justify-content-end">
                        <current-transactiondate :branch="branch.branch_id" :token="token" :reports="true"></current-transactiondate>
						<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
                    </div>
                </div>
                <!-- <span class="text-center text-primary-dark text-bold"
                    >As of 12/12/2021</span
                > -->
                <span class="text-center text-primary-dark text-bold font-md mb-5">{{branch.branch_name + ' Branch (' + branch.branch_code + ')'}}</span>
				<div class="d-flex flex-row justify-content-center text-primary-dark">
					<span class="mr-5">From:</span><span class="mr-16">{{filter.date_from?dateToMDY2(new Date(filter.date_from)).split('-').join('/'):'---'}}</span>
					<span class="mr-5">To:</span><span>{{filter.date_to?dateToMDY2(new Date(filter.date_to)).split('-').join('/'):'---'}}</span>
				</div>
            </div>
            <section class="d-flex flex-column mb-16 p-10 light-border">
                <div class="d-flex bg-yellow-verylight mb-5">
                    <span class="text-primary-dark font-20">CURRENT</span>
                </div>
                <div class="bb-dark-8"></div>
                <table class="table table-stripped mb-24">
                    <thead>
                        <th class="col-md-2">Account Officer</th>
                        <th>
                            Outstanding Loan Portfolio
                        </th>
                        <th>
                            Filing Fee
                        </th>
                        <th>
                            Interest Income
                        </th>
                        <th>
                            Penalty
                        </th>
                        <th>PDI</th>
                    </thead>
                    <tbody>
						<tr v-if="!reports.length"><td><i>No records found.</i></td></tr>
                        <tr v-for="r,i in reports" :key="i">
                            <td>{{r.account_officer}}</td>
                            <td>{{formatToCurrency(r.outstanding_loan_portfolio)}}</td>
                            <td>{{formatToCurrency(r.filing_fee)}}</td>
                            <td>{{formatToCurrency(r.interest_income)}}</td>
                            <td>{{formatToCurrency(r.penalty)}}</td>
                            <td>{{formatToCurrency(r.pdi)}}</td>
                        </tr>
						<tr class="tr-py-7 text-bold">
							<td>TOTAL</td>
							<td>{{formatToCurrency(totalRevenue.outstandingLoanPortfolio)}}</td>
							<td>{{formatToCurrency(totalRevenue.filingFee)}}</td>
							<td>{{formatToCurrency(totalRevenue.interestIncome)}}</td>
							<td>{{formatToCurrency(totalRevenue.penalty)}}</td>
							<td>{{formatToCurrency(totalRevenue.pdi)}}</td>
						</tr>
                    </tbody>
                </table>
            </section>
        </section>

        <section class="d-flex flex-row mb-72">
            <span class="flex-2 pb-24 text-bold darker-bb mr-64"
                >Prepared By:</span
            >
            <span class="flex-2 pb-24 text-bold darker-bb mr-64"
                >Certified Corrected By:</span
            >
            <span class="flex-2 pb-24 text-bold darker-bb mr-64"
                >Approved By:</span
            >
            <span class="flex-1"></span>
        </section>

        <div class="d-flex flex-row justify-content-end mb-45">
            <div class="d-flex flex-row-reverse">
                <a href="#" class="btn btn-default min-w-150">Print</a>
                <a href="#" class="btn btn-success min-w-150 mr-24"
                    >Download Excel</a
                >
            </div>
        </div>
    </div>
</template>

<script>
export default {
	props:['pbranch','token'],
	data(){
		return {
			branch:{},
			reports:[],
			filter:{
				date_from:'',
				date_to:'',
				branch_id:'',
				type:'revenue'
			}
		}
	},
    methods: {
		async fetchReports(){
			this.filter.branch_id = this.branch.branch_id;
			await axios.post(this.baseURL() + 'api/report/branch', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.reports = response.data.data
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
        print: function () {
            var content = document.getElementById("printContent").innerHTML;
            var target = document.querySelector(".to-print");
            target.innerHTML = content;
            window.print();
        },
    },
	computed:{
		totalRevenue:function(){
			var total = {
				outstandingLoanPortfolio:0,
				filingFee:0,
				interestIncome:0,
				penalty:0,
				pdi:0
			}
			this.reports.forEach(r => {
				total.outstandingLoanPortfolio += r.outstanding_loan_portfolio;
				total.filingFee += r.filing_fee;
				total.interestIncome += r.interest_income;
				total.penalty += r.penalty;
				total.pdi += r.pdi;
			})
			return total;
		}
	},
	watch:{
		 filter: {
			handler(val){
				if(val.date_from && val.date_to){
					this.fetchReports();   
				}
			},
			deep: true
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
	}
};
</script>
