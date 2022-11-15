<template>
	<!-- <div>
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">General Ledger Setup</h1>
		</div>
		<div class="d-flex ml-16">
			<div class="flex-1 mr-24">
				<span class="text-20 py-7 mid-light-bb text-block text-primary-dark text-bold mb-12">Inputs</span>
				<div class="light-border p-16">
					<div class="form-group mb-10">
						<label for="loansPortal" class="form-label">Loan's Portal</label>
						<input type="text" class="form-control form-input " id="loansPortal">
					</div>
					<div class="form-group mb-10">
						<label for="code" class="form-label">Code</label>
						<input type="text" class="form-control form-input " id="code">
					</div>
					<div class="form-group mb-10">
						<label for="accountingPortal" class="form-label">Accounting Portal</label>
						<input type="text" class="form-control form-input " id="accountingPortal">
					</div>
					<div class="form-group mb-16">
						<label for="account" class="form-label">Account</label>
						<div class="d-flex align-items-start">
							<div class="d-flex flex-column flex-1 mr-1">
								<select name="" id="" class="form-control form-input mb-12">
									<option value="Releasing">Releasing</option>
								</select>
							</div>
							<a href="#" class="btn btn-primary-dark" style="line-height:2;"><i class="fa fa-plus"></i></a>
						</div>
					</div>
					<div class="d-flex justify-content-end mb-36">
						<a href="#" class="btn btn-lg btn-success min-w-150">Save</a>
					</div>
				</div>
			</div>
			<div class="flex-2">
				<span class="text-20 py-7 mid-light-bb text-block text-primary-dark text-bold mb-12">Accounts</span>
				<div class="p-12 light-border">
					<table class="table table-stripped th-blue th-nbt">
						<thead>
							<th>Loan's Portal</th>
							<th>Code</th>
							<th>Accounting Portal</th>
							<th>Account</th>
						</thead>
						<tbody>
							<tr v-for="ledgerAcc in ledgerAccounts" :key="ledgerAcc.dl_id">
								<td>{{ledgerAcc.loans}}</td>
								<td>{{ledgerAcc.code}}</td>
								<td>{{ledgerAcc.accounting}}</td>
								<td>{{ledgerAcc.type=="releasing" ? "Releasing" : "Repayment"}}</td>
							</tr>
						</tbody>
					</table>
				</div>
				
			</div>
		</div>
	</div> -->
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">General Ledger Setup</h1>
		</div><!-- /.col -->
		<div class="d-flex flex-column flex-xl-row ml-16">
			<div style="flex:9;">
				<section class="mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-12">Inputs</span>

					<div class="d-flex flex-column p-16 light-border">
						<div class="form-group mb-10" style="flex:1">
							<label for="loansPortal" class="form-label">Loans Portal</label>
							<input type="text" class="form-control form-input " id="loansPortal">
						</div>
						<div class="form-group mb-10" style="flex:1">
							<label for="codePortal" class="form-label">Code</label>
							<input type="text" class="form-control form-input " id="codePortal">
						</div>
						<div class="form-group mb-10" style="flex:1">
							<label for="loansPortal" class="form-label">Accounting Portal</label>
							<input type="text" class="form-control form-input " id="loansPortal">
						</div>
						<div class="d-flex align-items-end mb-16">
							<div class="form-group mb-0 mr-10" style="flex:1">
								<label for="loansPortal" class="form-label">Account</label>
								<select name="" id="" class="form-control form-input"></select>
							</div>
							<button class="btn btn-primary-dark" style="height:49px;"><i class="fa fa-plus"></i></button>
						</div>
						<div class="d-flex justify-content-end">
							<a href="#" class="btn btn-lg btn-success min-w-150">Save</a>
						</div>
					</div>
					<div class="d-flex flex-column light-border" v-if="1==0">
						<div class="d-flex justify-content-between mb-16 bg-primary-dark text-white px-16 py-7">
							<span class="text-bold font-md">Edit</span>
							<a href="" @click.prevent="" class="text-white"><i class="fa fa-times"></i></a>
						</div>
						<div class="px-16 mb-16">
							<div class="form-group mb-10" style="flex:1">
								<label for="productName" class="form-label">Product Name</label>
								<input type="text" class="form-control form-input " id="productName">
							</div>
							<div class="d-flex flex-row mb-24">
								<div class="form-group mb-10 mr-24" style="flex:1">
									<label for="productName" class="form-label">Product Code</label>
									<input type="text" class="form-control form-input " id="productName">
								</div>
								<div class="form-group mb-10" style="flex:1">
									<label for="productName" class="form-label">Percentage</label>
									<input type="number" class="form-control form-input " id="productName" min="0" max="100">
								</div>
							</div>
							<div class="d-flex justify-content-between">
								<a href="#" class="btn btn-lg btn-yellow-light min-w-150">Activate</a>
								<a href="#" class="btn btn-lg btn-danger min-w-150">Deactivate</a>
								<a href="#" class="btn btn-lg btn-success min-w-150">Save</a>
							</div>
						</div>
						
					</div>
				</section>
			</div>
			<div style="flex:20">
				<section class="mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-12">List</span>
					<div class="p-16 light-border">
						<table class="table table-stripped th-nbt table-hover">
							<thead>
								<th>Loan's Portal</th>
								<th>Code</th>
								<th>Accounting Portal</th>
								<th>Account</th>
								<th></th>
							</thead>
							<tbody>
								<tr v-if="1==0">
									<td>No products found.</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
				</section>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
		props:['token'],
		data(){
			return {
				csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
				ledgerAccounts:[],
			}
		},
		methods: {
			fetchLedgerAccounts: function(){
				axios.get(this.baseURL() + 'api/gl', {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.ledgerAccounts = response.data.data;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
		},
        mounted() {
           	this.fetchLedgerAccounts();
        }
    }
</script>