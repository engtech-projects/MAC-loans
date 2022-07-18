<template>
	 <div class="container-fluid pl-16">
		<div class="mb-16"></div>
		<div class="mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">User Settings</h1>
		</div><!-- /.col -->
		<div class="search-bar">
			<input type="text" class="form-control" id="searchBar" placeholder="Search">
			<div><i class="fa fa-search"></i></div>
		</div>
		<table class="table table-stripped" id="clientsList">
			<thead>
				<!-- <th>Account #</th> -->
				<th>Full Name</th>
				<th>Branch</th>
				<th>User Name</th>
				<th>Password</th>
				<th></th>
			</thead>
			<tbody>
				<tr v-for="account in accounts" :key="account.id">
					<td><a href="#">{{account.firstname + ' ' + account.lastname}}</a></td>
					<td><span v-for="branch in account.branch" :key="branch.branch_id">{{branch.branch_name}}</span></td>
					<td>{{account.username}}</td>
					<td>**********************************</td>
					<td><a href="#" @click.prevent="" class="text-green text-sm">Active</a></td>
				</tr>
			</tbody>
		</table>
		<section class="d-flex flex-row">
			<div class="flex-1 mr-24">
				<span class="text-20 py-7 mid-light-bb text-block text-primary-dark text-bold mb-12">Inputs</span>
				<div class="light-border p-16">
					<div class="form-group mb-10">
						<label for="firstName" class="form-label">First Name</label>
						<input type="text" class="form-control form-input " id="firstName">
					</div>
					<div class="form-group mb-10">
						<label for="middleName" class="form-label">Middle Name</label>
						<input type="text" class="form-control form-input " id="middleName">
					</div>
					<div class="form-group mb-10">
						<label for="lastName" class="form-label">Last Name</label>
						<input type="text" class="form-control form-input " id="lastName">
					</div>
					<div class="form-group mb-24">
						<label for="lastName" class="form-label">Branch</label>
						<div class="d-flex align-items-start">
							<div class="d-flex flex-column flex-1 mr-1">
								<select name="" id="" class="form-control form-input mb-12">
									<option value="Butuan">Butuan</option>
								</select>
								<select name="" id="" class="form-control form-input mb-5">
									<option value="Nasipit">Nasipit</option>
								</select>
								<a href="#" class="text-green-bright text-bold text-right link-underline">Add Access Branch</a>
							</div>
							<a href="#" class="btn btn-primary-dark" style="line-height:2;"><i class="fa fa-plus"></i></a>
						</div>
					</div>
					<div class="darker-bb mb-24"></div>

					<div class="form-group mb-10">
						<label for="firstName" class="form-label">Username</label>
						<input type="text" class="form-control form-input " id="firstName">
					</div>
					<div class="form-group mb-24">
						<label for="middleName" class="form-label">Password</label>
						<input type="text" class="form-control form-input " id="middleName">
					</div>
					<div class="d-flex justify-content-between mb-72">
						<a href="#" class="btn btn-lg btn-yellow-light min-w-150">Activate / Deactivate</a>
						<a href="#" class="btn btn-lg btn-success min-w-150">Save</a>
					</div>
				</div>
			</div>
			<div class="flex-2">
				<span class="text-20 py-7 mid-light-bb text-block text-primary-dark text-bold mb-12">Access</span>
				<div class="d-flex flex-column light-border px-16">
					<div class="d-flex flex-row justify-content-between light-bb align-items-center">
						<span class="flex-1 py-10">Client Information</span>
						<input type="checkbox">
					</div>
					<div class="d-flex flex-row justify-content-between light-bb align-items-center">
						<span class="flex-1 py-10">Transaction</span>
						<input type="checkbox">
					</div>
					<div class="d-flex flex-column">
						<div class="d-flex justify-content-between light-bb align-items-center">
							<span class="flex-1 py-10">Maintenance</span>
							<input type="checkbox">
						</div>
						<div class="px-45">
							<div class="d-flex flex-row justify-content-between light-bb align-items-center">
								<span class="flex-1 py-10">Cancel Payments</span>
								<input type="checkbox">
							</div>
							<div class="d-flex flex-row justify-content-between light-bb align-items-center">
								<span class="flex-1 py-10">Product Setup</span>
								<input type="checkbox">
							</div>
							<div class="d-flex flex-row justify-content-between light-bb align-items-center">
								<span class="flex-1 py-10">Center - Group Setup</span>
								<input type="checkbox">
							</div>
							<div class="d-flex flex-row justify-content-between light-bb align-items-center">
								<span class="flex-1 py-10">User Settings</span>
								<input type="checkbox">
							</div>
							<div class="d-flex flex-row justify-content-between light-bb align-items-center">
								<span class="flex-1 py-10">Account Officer</span>
								<input type="checkbox">
							</div>
							<div class="d-flex flex-row justify-content-between align-items-center">
								<span class="flex-1 py-10">Account Re-Tagging</span>
								<input type="checkbox">
							</div>
						</div>
					</div>
					<div class="d-flex flex-row justify-content-between light-bt light-bb align-items-center">
						<span class="flex-1 py-10">Report</span>
						<input type="checkbox">
					</div>
					<div class="d-flex flex-row justify-content-between light-bb align-items-center">
						<span class="flex-1 py-10">End of Day</span>
						<input type="checkbox">
					</div>
				</div>
			</div>
		</section>
	  </div>
</template>

<script>
export default {
	props:['token'],
	data(){
		return {
			accounts:[],
		}
	},
	methods:{
		fetchAccounts: function(){
			axios.get(window.location.origin + '/api/user/', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.accounts = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
	},
	mounted(){
		console.log('hello');
		this.fetchAccounts();
	}

}
</script>