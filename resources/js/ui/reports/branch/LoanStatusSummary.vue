<template>
	<div class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-row font-md mb-16">
			<!-- <span class="font-lg text-primary-dark flex-1 mr-45"></span> -->
			<div class="d-flex flex-row align-items-center mr-24" style="flex:1">
				<span class="mr-10">As of: </span>
				<input type="date" class="form-control flex-1">
			</div>
			<div class="d-flex flex-row align-items-center mr-24 justify-content-start flex-1">
				<span class="mr-10 text-block">Acc. Officer: </span>
				<select name="" id="selectProductClient" class="form-control flex-1">
					<option value="">John Mark Bacenas</option>
				</select>
			</div>
			<div class="d-flex flex-row align-items-center mr-24 justify-content-start flex-1">
				<span class="mr-10 text-block">Product: </span>
				<select name="" id="selectProductClient" class="form-control flex-1">
					<option value="">Pension</option>
				</select>
			</div>		
			<div class="d-flex flex-row align-items-center mr-24 justify-content-start flex-1">
				<span class="mr-10 text-block">Center: </span>
				<select name="" id="selectProductClient" class="form-control flex-1">
					<option value="">Accasia</option>
				</select>
			</div>	
			<div class="d-flex flex-row align-items-center justify-content-start flex-1">
				<span class="mr-10 text-block">Status: </span>
				<select name="" id="selectProductClient" class="form-control flex-1">
					<option value="">Delinquent</option>
					<option value="">Past Due</option>
				</select>
			</div>									
		</div>
		<div class="sep mb-45"></div>
		<img :src="this.baseURL()+'/img/company_header_fit.png'" class="mb-24" alt="">

		<section class="mb-72" id="performanceReport">
			<div class="d-flex flex-column mb-24">
				<div class="d-flex flex-row align-items-center">
					<div class="flex-1 d-flex flex-column">
					
					</div>
					<span class="font-30 text-bold text-primary-dark text-center">Loan Status Summary</span>
					<div class="flex-1 d-flex justify-content-end" style="padding-right:16px">
                        <current-transactiondate :branch="branch.branch_id" :token="token" :reports="true"></current-transactiondate>
                        <span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
                    </div>
				</div>
				<span class="text-center text-primary-dark text-bold">As of 12/12/2021</span>
				<span class="text-center text-primary-dark text-bold font-md mb-5">Butuan Branch (001)</span>
			</div>
			<section class="d-flex flex-column mb-16 p-10 light-border">
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
			</table>
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
			branch:{}
		}
	},
	methods:{
		print:function(){
			var content = document.getElementById('printContent').innerHTML;
			var target = document.querySelector('.to-print');
			target.innerHTML = content;
			window.print();
		},
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
	}
}
</script>