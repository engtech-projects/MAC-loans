<template>
	<div class="d-flex flex-column" style="flex:8;min-height:1500px;">
		<div class="d-flex flex-row font-md align-items-center mb-16">
			<span class="font-lg text-primary-dark" style="flex:3">Transaction</span>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">From: </span>
				<input v-model="filter.date_from" type="date" class="form-control">
			</div>
			<div class="d-flex flex-row align-items-center mr-64" style="flex:2">
				<span class="mr-10">To: </span>
				<input v-model="filter.date_to" type="date" class="form-control">
			</div>
			<div class="d-flex flex-row align-items-center mr-24" style="flex:2">
				<span class="mr-10">Type: </span>
				<select v-model="filter.type" name="" id="selectProductClient" class="form-control">
					<option value="0">All Records</option>
					<option value="new_accounts">New Accounts</option>
					<option value="by_center">By Center</option>
					<option value="by_product">By Product</option>
					<option value="by_ao">By Account Officer</option>
				</select>
			</div>
			<div class="d-flex flex-row align-items-center" style="flex:2">
				<span class="mr-10">Spec: </span>
				<select v-model="filter.spec" name="" id="selectProductClient" class="form-control">
					<option v-for="(s, i) in spec" :key="i" :value="s.id">{{s.name}}</option>
					<!-- <option value="0">All Records</option>
					<option value="aloan">Allotment Loan</option>
					<option value="micro group">Micro Group</option>
					<option value="micro individual">Micro Individual</option>
					<option value="pension emergency">Pension Emergency</option>
					<option value="pension loan">Pension Loan</option>
					<option value="sme loan">SME Loan</option> -->
				</select>
			</div>
		</div>
		<div class="sep mb-45"></div>
		<div id="printContent">
			<img src="/img/company_header_fit.png" class="mb-24" alt="">

			<section class="" id="clientSection">
				<div class="d-flex flex-column mb-16">
					<div class="d-flex flex-row align-items-center">
						<div class="flex-1"></div>
						<span class="font-30 text-bold text-primary-dark">SUMMARY OF LOAN RELEASE</span>
						<div class="flex-1" style="padding-left:24px">
							<span class="text-primary-dark mr-10">{{dateFullDay(new Date())}} {{dateToYMD(new Date()).split('-').join('/')}}</span>
							<span class="text-primary-dark">Time: {{todayTime(new Date())}} {{(new Date()).getHours() > 12? 'PM':'AM'}}</span>
						</div>
					</div>
					<span class="text-center text-primary-dark text-bold font-md mb-5">Butuan Branch (001)</span>
					<div class="d-flex flex-row justify-content-center text-primary-dark">
						<span class="mr-5">From:</span><span class="mr-16">{{dateToMDY2(new Date(filter.date_from)).split('-').join('/')}}</span>
						<span class="mr-5">To:</span><span>{{dateToMDY2(new Date(filter.date_to)).split('-').join('/')}}</span>
					</div>
				</div>
				<section class="d-flex flex-column mb-72">
					<span class="text-bold bg-yellow-light" style="padding:2px 5px;">RELEASES SUMMARY</span>
					<table class="table td-nb table-thin">
						<thead>
							<th>Account #</th>
							<th>Account Name</th>
							<th>Date Loan</th>
							<th>Terms</th>
							<th>Amount Loan</th>
							<th>Fil. Fee</th>
							<th>D.S</th>
							<th>Ins.</th>
							<th>Noti</th>
							<th>Affidavit</th>
							<th>Ded. Bal</th>
							<th>Prep.</th>
							<th>Net. Prcds</th>
							<th>Type</th>
						</thead>
						<tbody>
							<tr v-for="(a, b) in accounts" :key="b">
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
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<!-- <tr>
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
								<td></td>
								<td></td>
								<td></td>
							</tr> -->
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
				</section>
				
			</section>
			<div class="d-flex mb-64" style="margin-top:auto">
				<img src="/img/logo-footer.png" class="w-100" alt="">
			</div>
		</div>
		
		<div class="d-flex flex-row justify-content-between mb-45">
			<div class="d-flex flex-row-reverse justify-content-start flex-1">
				<a @click="print()" href="#" class="btn btn-default min-w-150">Print</a>
				<a href="#" class="btn btn-success min-w-150 mr-24">Download Excel</a>
			</div>
		</div>
	</div>

</template>

<script>
export default {
	props:['token'],
	data(){
		return {
			filter:{
				date_from: null,
				date_to: null,
				type:0,
				spec:0,
				category:'product',
			},
			products:[],
			centers:[],
			ao:[],
			accounts:[],
		}
	},
	methods:{
		fetchAccounts:function(){
			axios.post('/api/report/release', this.filter, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.accounts = response.data.data;
				console.log(response.data);
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		}, 
		fetchProducts: function(){
			axios.get(window.location.origin + '/api/product/', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.products = response.data.data;
				this.fetchCenters();
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		fetchCenters:function(){
			axios.get(window.location.origin + '/api/center', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.centers = response.data.data;
				this.fetchOfficers();
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		fetchOfficers:function(){
			axios.get(window.location.origin + '/api/accountofficer', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.ao = response.data.data;
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
	},
	computed:{
		spec:function(){
			if(this.filter.type == 'by_product'){
				return this.productSet;
			}else if(this.filter.type == 'by_center'){
				return this.centerSet;
			}else if(this.filter.type == 'by_ao'){
				return this.aoSet;
			}else{
				return [];
			}
		},
		productSet:function(){
			var set = [];
			this.products.map(function(item){
				set.push({id:item.product_id, name:item.product_name});
			}.bind(this));
			return set;
		},
		centerSet:function(){
			var set = [];
			this.centers.map(function(item){
				set.push({id:item.center_id, name:item.center});
			}.bind(this));
			return set;
		},
		aoSet:function(){
			var set = [];
			this.ao.map(function(item){
				set.push({id:item.ao_id, name:item.name});
			}.bind(this));
			return set;
		}
	},
	watch:{
		 filter: {
			handler(val){
				if(val.date_from && val.date_to){
					this.fetchAccounts();
				}
			},
			deep: true
		}
	},
	mounted(){
		this.fetchProducts();
	}
}
</script>