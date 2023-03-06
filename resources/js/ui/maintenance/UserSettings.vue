<template>
	 <div class="container-fluid pl-16">
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">User Settings</h1>
		</div><!-- /.col -->
		<div class="search-bar">
			<input v-model="filter" type="text" class="form-control" id="searchBar" placeholder="Search">
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
				<th></th>
			</thead>
			<tbody>
				<tr v-for="acc in filteredAccounts" :key="acc.id" :class="account.id==acc.id?'active-account':''">
					<td><a href="#">{{acc.firstname + ' ' + acc.lastname}}</a></td>
					<td><span v-for="branch in acc.branch" :key="branch.branch_id">{{branch.branch_name + ' '}}</span></td>
					<td>{{acc.username}}</td>
					<td>**********************************</td>
					<td><a href="#" @click.prevent="" class="text-green text-sm">{{upperFirst(acc.status)}}</a></td>
					<td><span @click="assignAccount(acc)" class="text-green c-pointer text-sm hover-underline"><i class="fa fa-edit"></i> Edit</span></td>
				</tr>
			</tbody>
		</table>
		<form @submit.prevent="submit()">
		<section class="d-flex flex-row">
			<div class="flex-1 mr-24">
				<span class="text-20 py-7 mid-light-bb text-block text-primary-dark text-bold mb-12">Inputs</span>
				<div class="light-border p-16 relative" :style="account.id?'padding-top:65px;':''">
					<div v-if="account.id" class="flex bg-primary-dark align-items-center justify-content-between" style="position:absolute;width:100%;padding:12px 15px;left:0;top:0;">
						<span class="text-white text-bold">Edit {{account.username}}</span>
						<i @click="resetAccount" class="fa fa-times text-lg text-offwhite c-pointer hover-white"></i>
					</div>
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
						<div class="d-flex mb-12">
							<select v-model="selected.branch" name="" id="" class="form-control form-input mr-10">
								<option v-for="br in branches" :key="br.branch_id" :value="br.branch_id">{{br.branch_name}}</option>
							</select>
							<a @click.prevent="addBranch()" href="#" class="btn btn-primary-dark" style="line-height:2;"><i class="fa fa-plus"></i></a>
						</div>
						<div class="d-flex flex-column">
							<div class="d-flex mb-12" v-for="ab in account.branch" :key="ab.branch_id">
								<input type="text" :value="ab.branch_name" disabled name="" id="" class="form-control form-input mr-10">
								<a @click.prevent="removeBranch(ab,$event)" href="#" class="btn btn-default" style="line-height:2;"><i class="fa fa-times text-red"></i></a>
							</div>
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
					<div class="form-group mb-16">
						<label for="firstName" class="form-label">Status</label>
						<input :value="upperFirst(account.status)" type="text" class="form-control form-input " id="status" disabled>
					</div>
					<div class="d-flex justify-content-between mb-72">
						<a v-if="account.id" @click.prevent="account.status=='active'?account.status='inactive':account.status='active'" href="#" class="btn btn-lg min-w-150" :class="account.status=='active'?'btn-danger':'btn-yellow-light'">{{account.status=='active'?'Deactivate':'Activate'}}</a>
						<!-- <a href="#" ></a> -->
						<div>
							<button v-if="account.id" class="btn btn-lg btn-success btn-wide">Update</button>
							<button v-else class="btn btn-lg btn-success btn-wide">Save</button>
						</div>
					</div>
				</div>
			</div>
			<div class="flex-2">
				<span class="text-20 py-7 mid-light-bb text-block text-primary-dark text-bold mb-12">Access</span>
				<div class="d-flex flex-column light-border px-16">
					<div class="d-flex flex-column">
						<div class="d-flex justify-content-between light-bb align-items-center">
							<span class="flex-1 py-10 text-bold">Client Information</span>
							<input @change="toggleChildren('Client Information', $event)" type="checkbox" :checked="areChildrenChecked('Client Information')">
						</div>
						<div class="px-45">
							<div v-for="cinfo in permissionList('Client Information')" :key="cinfo.access_id">
								<div class="d-flex flex-row justify-content-between light-bb align-items-center hover-border-dark">
									<span class="flex-1 py-10">{{cinfo.label}}</span>
									<input @change="togglePermission(cinfo, $event)" type="checkbox" :checked="isChecked(cinfo)">
								</div>
								<div v-for="cc in cinfo.child_permissions" :key="cc.access_id" class="d-flex flex-row justify-content-between light-bb align-items-center mx-45 hover-border-dark">
									<span class="flex-1 py-10 text-tomato">{{cc.label}}</span>
									<input @change="togglePermission(cc, $event)" type="checkbox" :checked="isChecked(cc)">
								</div>
							</div>
						</div>
					</div>
					<div class="d-flex flex-column">
						<div class="d-flex justify-content-between light-bb align-items-center">
							<span class="flex-1 py-10 text-bold">Transaction</span>
							<input @change="toggleChildren('Transaction', $event)" type="checkbox" :checked="areChildrenChecked('Transaction')">
						</div>
						<div class="px-45">
							<div v-for="cinfo in permissionList('Transaction')" :key="cinfo.access_id">
								<div class="d-flex flex-row justify-content-between light-bb align-items-center hover-border-dark">
									<span class="flex-1 py-10">{{cinfo.label}}</span>
									<input @change="togglePermission(cinfo, $event)" type="checkbox" :checked="isChecked(cinfo)">
								</div>
								<div v-for="cc in cinfo.child_permissions" :key="cc.access_id" class="d-flex flex-row justify-content-between light-bb align-items-center mx-45 hover-border-dark">
									<span class="flex-1 py-10 text-tomato">{{cc.label}}</span>
									<input @change="togglePermission(cc, $event)" type="checkbox" :checked="isChecked(cc)">
								</div>
							</div>
						</div>
					</div>
					<div class="d-flex flex-column">
						<div class="d-flex justify-content-between light-bb align-items-center">
							<span class="flex-1 py-10 text-bold">Maintenance</span>
							<input @change="toggleChildren('Maintenance', $event)" type="checkbox" :checked="areChildrenChecked('Maintenance')">
						</div>
						<div class="px-45">
							<div v-for="cinfo in permissionList('Maintenance')" :key="cinfo.access_id">
								<div class="d-flex flex-row justify-content-between light-bb align-items-center hover-border-dark">
									<span class="flex-1 py-10">{{cinfo.label}}</span>
									<input @change="togglePermission(cinfo, $event)" type="checkbox" :checked="isChecked(cinfo)">
								</div>
								<div v-for="cc in cinfo.child_permissions" :key="cc.access_id" class="d-flex flex-row justify-content-between light-bb align-items-center mx-45 hover-border-dark">
									<span class="flex-1 py-10 text-tomato">{{cc.label}}</span>
									<input @change="togglePermission(cc, $event)" type="checkbox" :checked="isChecked(cc)">
								</div>
							</div>
						</div>
					</div>
					<div class="d-flex flex-column">
						<div class="d-flex justify-content-between light-bb align-items-center">
							<span class="flex-1 py-10 text-bold">Reports</span>
							<input @change="toggleChildren('Reports', $event)" type="checkbox" :checked="areChildrenChecked('Reports')">
						</div>
						<div class="px-45">
							<div v-for="cinfo in permissionList('Reports')" :key="cinfo.access_id">
								<div class="d-flex flex-row justify-content-between light-bb align-items-center hover-border-dark">
									<span class="flex-1 py-10">{{cinfo.label}}</span>
									<input @change="togglePermission(cinfo, $event)" type="checkbox" :checked="isChecked(cinfo)">
								</div>
								<!-- <div v-for="cc in cinfo.child_permissions" :key="cc.access_id" class="d-flex flex-row justify-content-between light-bb align-items-center mx-45 hover-border-dark">
									<span class="flex-1 py-10 text-tomato">{{cc.label}}</span>
									<input @change="togglePermission(cc, $event)" type="checkbox" :checked="isChecked(cc)">
								</div> -->
							</div>
						</div>
					</div>
					<div class="d-flex flex-column">
						<div class="d-flex justify-content-between light-bb align-items-center">
							<span class="flex-1 py-10 text-bold">End of Day</span>
							<input @change="toggleChildren('End of Day', $event)" type="checkbox" :checked="areChildrenChecked('End of Day')">
						</div>
						<div class="px-45">
							<div v-for="cinfo in permissionList('End of Day')" :key="cinfo.access_id">
								<div class="d-flex flex-row justify-content-between light-bb align-items-center hover-border-dark">
									<span class="flex-1 py-10">{{cinfo.label}}</span>
									<input @change="togglePermission(cinfo, $event)" type="checkbox" :checked="isChecked(cinfo)">
								</div>
								<div v-for="cc in cinfo.child_permissions" :key="cc.access_id" class="d-flex flex-row justify-content-between light-bb align-items-center mx-45 hover-border-dark">
									<span class="flex-1 py-10 text-tomato">{{cc.label}}</span>
									<input @change="togglePermission(cc, $event)" type="checkbox" :checked="isChecked(cc)">
								</div>
							</div>
						</div>
					</div>
					<!-- <div class="d-flex flex-row justify-content-between light-bt light-bb align-items-center">
						<span class="flex-1 py-10">Report</span>
						<input type="checkbox">
					</div>
					<div class="d-flex flex-row justify-content-between light-bb align-items-center hover-border-dark">
						<span class="flex-1 py-10">End of Day</span>
						<input type="checkbox">
					</div> -->
				</div>
			</div>
		</section>
		</form>
		<branch :token="token" @branchUpdated="fetchBranches"></branch>
	  </div>
</template>

<script>
export default {
	props:['token'],
	data(){
		return {
			filter:'',
			accounts:[],
			account:{
				id:null,
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
		removeBranch:function(branch, e){
			this.account.branch = this.account.branch.filter(b => b !== branch);
		},
		assignAccount:function(acc){
			let permissions = [];
			this.account = JSON.parse(JSON.stringify(acc));
			this.account.accessibility.forEach(function(a){
				permissions.push(a.access_id);
			})
			this.account.accessibility = permissions;
		},
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
				id:null,
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
		submit:function(){
			if(this.account.branch.length){
				if(this.account.id){
					this.update();
				}else{
					this.save();
				}
			}else{
				this.notify('','Branch is required.', 'error');
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
			this.account.permissions = this.account.accessibility;
			await 	axios.put(this.baseURL() + 'api/user/' + this.account.id, this.account, {
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
		convertPermissions:function(){
			var access = [];
			for(let i in this.permissions){
				this.permissions[i].forEach(p => {
					this.account.accessibility.forEach((a)=>{
						if(p.access_id == a){
							access.push(p);
						}
					})
				})
			}
			return access;
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
			return this.permissions[permission]? this.permissions[permission]:[];
		},
		togglePermission:function(permission, e){
			if(!e.target.checked){
				this.account.accessibility = this.account.accessibility.filter(data => data != permission.access_id);
				if(permission.child_permissions){
					permission.child_permissions.forEach(pc=>{
						this.account.accessibility = this.account.accessibility.filter(a=>a!=pc.access_id)
					})
				}
			}else{
				this.account.accessibility.push(permission.access_id);
				if(!permission.child_permissions){
					var parent = this.plainPermissionsLIst.filter(p=>permission.group == p.label)
					if(parent.length && !this.account.accessibility.includes(parent[0].access_id)){
						this.account.accessibility.push(parent[0].access_id);
					}
				}
			}
		},
		toggleChildren(permission, e){
			if(!e.target.checked){
				this.permissionList(permission).forEach(p=>{
					p.child_permissions?p.child_permissions.forEach(c=>{
						this.account.accessibility = this.account.accessibility.filter(data => data != c.access_id);
					}):0
				})
			}else{
				this.permissionList(permission).forEach(p=>{
					!this.account.accessibility.includes(p.access_id)?this.account.accessibility.push(p.access_id):0
					p.child_permissions?p.child_permissions.forEach(c=>{
						!this.account.accessibility.includes(c.access_id)?this.account.accessibility.push(c.access_id):0
					}):0
				})
			}
		},
		areChildrenChecked:function(permission){
			var checked = true;
			this.permissionList(permission).length?this.permissionList(permission).forEach(p=>{
				!this.account.accessibility.includes(p.access_id)?checked=false:0
					p.child_permissions.forEach(c=>{
						!this.account.accessibility.includes(c.access_id)?checked=false:0
					})
			}):checked=false;
			return checked
		},
		isChecked:function(permission){
			var checked = false;
			this.account.accessibility.forEach(function(data){
				if(data == permission.access_id){
					checked = true;
					// if(!permission.child_permissions){
					// 	var parent = this.plainPermissionsLIst.filter(p=>permission.group == p.label)
					// 	if(parent.length && !this.account.accessibility.includes(parent[0].access_id)){
					// 		this.account.accessibility.push(parent[0].access_id);
					// 	}
					// }
				}
			}.bind(this));
			
			return checked;
		},
		hasBranch:function(account){
			var res = false;
			account.branch.forEach(a => {
				if(a.branch_name.toLowerCase().includes(this.filter.toLowerCase())){
					res = true
				}
			})
			return res
		}
	},
	computed:{
		filteredAccounts:function(){
			return this.accounts.filter(a => a.firstname.toLowerCase().includes(this.filter.toLowerCase()) || 
										a.lastname.toLowerCase().includes(this.filter.toLowerCase()) ||
										(a.firstname + ' ' + a.lastname).toLowerCase().includes(this.filter.toLowerCase()) ||
										(a.lastname + ' ' + a.firstname).toLowerCase().includes(this.filter.toLowerCase()) ||
										a.username.toLowerCase().includes(this.filter.toLowerCase()) ||
										this.hasBranch(a))
		},
		plainPermissionsLIst:function(){
			var permissions = []
			for(var i in this.permissions){
				this.permissions[i].forEach(p=>{
					permissions.push(p)
					p.child_permissions.forEach(c=>{
						permissions.push(c)
					})
				})
			}
			// this.permissions.forEach(p=>{
			// 	permissions.push(p)
			// 	p.child_permissions.forEach(c=>{
			// 		permissions.push(c)
			// 	})
			// })
			return permissions;
		}
	},
	mounted(){
		this.fetchAccounts();
		this.fetchBranches();
		this.fetchPermissions();
	}

}
</script>

<style scoped>
	.active-account {
		background-color: #78e08f !important;
	}
	.hover-border-dark:hover {
		border-color: #95a5a6!important;
	}
</style>