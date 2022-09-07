<template>
	 <div class="container-fluid pl-16">
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">User Settings</h1>
		</div><!-- /.col -->
		<div class="search-bar">
			<input type="text" class="form-control" id="searchBar" placeholder="Search">
			<div><i class="fa fa-search"></i></div>
		</div>
		<table class="table table-stripped table-hover" id="clientsList">
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
		<form @submit.prevent="save()">
		<section class="d-flex flex-row">
			<div class="flex-1 mr-24">
				<span class="text-20 py-7 mid-light-bb text-block text-primary-dark text-bold mb-12">Inputs</span>
				<div class="light-border p-16">
					<div class="form-group mb-10">
						<label for="firstName" class="form-label">First Name</label>
						<input v-model="account.firstname" type="text" class="form-control form-input " id="firstName" required>
					</div>
					<div class="form-group mb-10">
						<label for="middleName" class="form-label">Middle Name</label>
						<input v-model="account.middlename" type="text" class="form-control form-input " id="middleName" required>
					</div>
					<div class="form-group mb-10">
						<label for="lastName" class="form-label">Last Name</label>
						<input v-model="account.lastname" type="text" class="form-control form-input " id="lastName" required>
					</div>
					<div class="form-group mb-24">
						<label for="lastName" class="form-label">Branch</label>
						<div class="d-flex align-items-start">
							<div class="d-flex flex-column flex-1 mr-1">
								<select v-model="selected.branch" name="" id="" class="form-control form-input mb-12">
									<option v-for="br in branches" :key="br.branch_id" :value="br.branch_id">{{br.branch_name}}</option>
								</select>
								<select v-for="ab in account.branch" :key="ab.branch_id" name="" id="" class="form-control form-input mb-5">
									<option value="ab.branch_id">{{ab.branch_name}}</option>
								</select>
								<a href="#" class="text-green-bright text-bold text-right link-underline">Add Access Branch</a>
							</div>
							<a @click.prevent="addBranch()" href="#" class="btn btn-primary-dark" style="line-height:2;"><i class="fa fa-plus"></i></a>
						</div>
					</div>
					<div class="darker-bb mb-24"></div>

					<div class="form-group mb-10">
						<label for="firstName" class="form-label">Username</label>
						<input v-model="account.username" type="text" class="form-control form-input " id="username" required>
					</div>
					<div class="form-group mb-24">
						<label for="middleName" class="form-label">Password</label>
						<input v-model="account.password" type="password" class="form-control form-input " id="password" required>
					</div>
					<div class="form-group mb-10">
						<label for="firstName" class="form-label">Status</label>
						<input v-model="account.status" type="text" class="form-control form-input " id="status" disabled>
					</div>
					<div class="d-flex justify-content-between mb-72">
						<a @click.prevent="account.status=='active'?account.status='inactive':account.status='active'" href="#" class="btn btn-lg btn-yellow-light min-w-150">Activate / Deactivate</a>
						<!-- <a href="#" ></a> -->
						<button class="btn btn-lg btn-success min-w-150">Save</button>
					</div>
				</div>
			</div>
			<div class="flex-2">
				<span class="text-20 py-7 mid-light-bb text-block text-primary-dark text-bold mb-12">Access</span>
				<div class="d-flex flex-column light-border px-16">
					<!-- <div class="d-flex flex-row justify-content-between light-bb align-items-center">
						<span class="flex-1 py-10">Client Information</span>
						<input type="checkbox">
					</div>
					<div class="d-flex flex-row justify-content-between light-bb align-items-center">
						<span class="flex-1 py-10">Transaction</span>
						<input type="checkbox">
					</div> -->
					<div class="d-flex flex-column">
						<div class="d-flex justify-content-between light-bb align-items-center">
							<span class="flex-1 py-10 text-bold">Client Information</span>
							<input type="checkbox">
						</div>
						<div class="px-45">
							<div v-for="cinfo in permissionList('Client Information')" :key="cinfo.access_id" class="d-flex flex-row justify-content-between light-bb align-items-center">
								<span class="flex-1 py-10">{{cinfo.label}}</span>
								<input @change="togglePermission(cinfo.access_id, $event)" type="checkbox" :checked="isChecked(cinfo.access_id)">
							</div>
						</div>
					</div>
					<div class="d-flex flex-column">
						<div class="d-flex justify-content-between light-bb align-items-center">
							<span class="flex-1 py-10 text-bold">Transaction</span>
							<input type="checkbox">
						</div>
						<div class="px-45">
							<div v-for="cinfo in permissionList('Transaction')" :key="cinfo.access_id" class="d-flex flex-row justify-content-between light-bb align-items-center">
								<span class="flex-1 py-10">{{cinfo.label}}</span>
								<input @change="togglePermission(cinfo.access_id, $event)" type="checkbox">
							</div>
						</div>
					</div>
					<div class="d-flex flex-column">
						<div class="d-flex justify-content-between light-bb align-items-center">
							<span class="flex-1 py-10 text-bold">Maintenance</span>
							<input type="checkbox">
						</div>
						<div class="px-45">
							<div v-for="cinfo in permissionList('Maintenance')" :key="cinfo.access_id" class="d-flex flex-row justify-content-between light-bb align-items-center">
								<span class="flex-1 py-10">{{cinfo.label}}</span>
								<input @change="togglePermission(cinfo.access_id, $event)" type="checkbox">
							</div>
						</div>
					</div>
					<div class="d-flex flex-column">
						<div class="d-flex justify-content-between light-bb align-items-center">
							<span class="flex-1 py-10 text-bold">Reports</span>
							<input type="checkbox">
						</div>
						<div class="px-45">
							<div v-for="cinfo in permissionList('Reports')" :key="cinfo.access_id" class="d-flex flex-row justify-content-between light-bb align-items-center">
								<span class="flex-1 py-10">{{cinfo.label}}</span>
								<input @change="togglePermission(cinfo.access_id, $event)" type="checkbox">
							</div>
						</div>
					</div>
					<div class="d-flex flex-column">
						<div class="d-flex justify-content-between light-bb align-items-center">
							<span class="flex-1 py-10 text-bold">End of Day</span>
							<input type="checkbox">
						</div>
						<div class="px-45">
							<div v-for="cinfo in permissionList('End of Day')" :key="cinfo.access_id" class="d-flex flex-row justify-content-between light-bb align-items-center">
								<span class="flex-1 py-10">{{cinfo.label}}</span>
								<input @change="togglePermission(cinfo.access_id, $event)" type="checkbox">
							</div>
						</div>
					</div>
					<!-- <div class="d-flex flex-row justify-content-between light-bt light-bb align-items-center">
						<span class="flex-1 py-10">Report</span>
						<input type="checkbox">
					</div>
					<div class="d-flex flex-row justify-content-between light-bb align-items-center">
						<span class="flex-1 py-10">End of Day</span>
						<input type="checkbox">
					</div> -->
				</div>
			</div>
		</section>
		</form>
	  </div>
</template>

<script>
export default {
	props:['token'],
	data(){
		return {
			accounts:[],
			account:{
				username:'',
				password:'',
				firstname:'',
				middlename:'',
				lastname:'',
				status:'active',
				branch:[],
				accessibility:[],
				permissions:[],
			},
			branches:[],
			selected:{
				branch:null,
			},
			permissions:[],
		}
	},
	methods:{
		fetchAccounts: function(){
			axios.get(this.baseURL() + 'api/user/', {
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
		fetchBranches:function(){
			axios.get(this.baseURL() + 'branch')
			.then(function (response) {
				this.branches = response.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		}, 
		fetchPermissions: function(){
			axios.get(this.baseURL() + 'api/accessibility/', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.permissions = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		setAccount:function(account){
			this.account = account;
		},
		resetAccount:function(){
			this.account = {
				username:'',
				password:'',
				firstname:'',
				middlename:'',
				lastname:'',
				status:'active',
				branch:[],
				accessibility:[],
				permissions:[],
			};
		},
		addBranch:function(){
			if(this.selected.branch){
				this.branches.map(function(data){
					if(this.selected.branch == data.branch_id){
						var exist = false;
						this.account.branch.map(function(b){
							if(data.branch_id == b.branch_id){
								exist = true;
							}
						}.bind(this));
						if(!exist){
							this.account.branch.push(data);
						}else{
							alert('This branch has already been added.')
						}
					}
				}.bind(this));
			}
		},
		async save(){
			this.account.permissions = this.account.accessibility;
			await 	axios.post(this.baseURL() + 'api/user', this.account, {
						headers: {
							'Authorization': 'Bearer ' + this.token,
							'Content-Type': 'application/json',
							'Accept': 'application/json'
						}
					})
					.then(function (response) {
						this.notify('',response.data.message, 'success');
						this.resetAccount();
						this.fetchAccounts();
					}.bind(this))
					.catch(function (error) {
						console.log(error);
					}.bind(this));
		},
		async update(){
			await 	axios.post(this.baseURL() + 'api/user', this.account, {
						headers: {
							'Authorization': 'Bearer ' + this.token,
							'Content-Type': 'application/json',
							'Accept': 'application/json'
						}
					})
					.then(function (response) {
						this.notify('',response.data.message, 'success');
						this.resetAccount();
						this.fetchAccounts();
					}.bind(this))
					.catch(function (error) {
						console.log(error);
					}.bind(this));
		},
		notify:function(title, text, type){
			this.$notify({
				group: 'foo',
				title: title,
				text: text,
				type: type,
			});
		},
		permissionList:function(permission){
			if(this.permissions[permission]){
				return this.permissions[permission]? this.permissions[permission]:[];
			}
		},
		togglePermission:function(permission, e){
			if(!e.target.checked){
				this.account.accessibility = this.account.accessibility.filter(data => data != permission);
			}else{
				this.account.accessibility.push(permission);
			}
		},
		isChecked:function(permission){
			var checked = false;
			this.account.accessibility.map(function(data){
				if(data == permission){
					checked = true;
				}
			}.bind(this));
			return checked;
		}
	},
	computed:{
		
	},
	mounted(){
		this.fetchAccounts();
		this.fetchBranches();
		this.fetchPermissions();
	}

}
</script>