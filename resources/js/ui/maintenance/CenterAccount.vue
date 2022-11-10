<template>
	<div class="container-fluid px-16">
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="mb-36 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">Center - Account Officer Setup</h1>
		</div><!-- /.col -->
		<div class="d-flex flex-column flex-xl-row mb-24">
			<div style="flex:9;">
				<section class="mb-24" style="flex:21;" v-if="center.center_id">
					<span class="section-title section-subtitle mb-12">Center Office</span>
					<div class="d-flex flex-column light-border">
						<div class="d-flex justify-content-between bg-primary-dark text-white px-16 py-7">
							<span class="text-bold font-md">Edit {{center.center}}</span>
							<a href="" @click.prevent="resetCenter()" class="text-white"><i class="fa fa-times"></i></a>
						</div>
						<div class="p-16">
							<div class="form-group mb-24" style="flex:1">
								<label for="centerName" class="form-label">Center Name</label>
								<input type="text" v-model="center.center" class="form-control form-input " id="centerName">
							</div>
							<div class="form-group mb-24" style="flex:1">
								<label for="centerName" class="form-label">Days Schedule for Collection</label>
								<select class="form-control form-input " id="centerName" v-model="center.day_sched">
									<option v-for="(day, d) in ddays" :key="d" :value="day">{{upperFirst(day)}}</option>
								</select>
							</div>
							<div class="d-flex justify-content-between">
								<a @click="center.status='active'" v-if="center.status!='active'" href="#" class="btn btn-lg btn-yellow-light min-w-150">Activate</a>
								<a @click="center.status='inactive'" v-if="center.status=='active'" href="#" class="btn btn-lg btn-danger min-w-150">Deactivate</a>
								<a href="#" @click="save()" class="btn btn-lg btn-success min-w-150">Save</a>
							</div>
						</div>
					</div>
				</section>
				<section class="mb-24" style="flex:21;" v-if="!center.center_id">
					<span class="section-title section-subtitle mb-12">Center Office</span>

					<div class="d-flex flex-column p-16 light-border">
						<div class="form-group mb-24" style="flex:1">
							<label for="centerName" class="form-label">Center Name</label>
							<input type="text" v-model="center.center" class="form-control form-input " id="centerName">
						</div>
						<div class="form-group mb-24" style="flex:1">
							<label for="centerName" class="form-label">Days Schedule for Collection</label>
							<select class="form-control form-input " id="centerName" v-model="center.day_sched">
								<option v-for="(day, d) in ddays" :key="d" :value="day">{{upperFirst(day)}}</option>
							</select>
						</div>
						<div class="d-flex justify-content-end">
							<a href="#" @click="save()" class="btn btn-lg btn-success min-w-150">Save</a>
						</div>
					</div>
				</section>
			</div>
			<div style="flex:20">
				<section class="mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-12">Center List</span>
					<div class="p-10 light-border">
						<table class="table table-stripped th-nb m-0">
							<tbody>
								<tr v-if="centers.length == 0">
									<td>No centers found.</td>
								</tr>
								<tr v-for="center in centers" :key="center.center_id">
									<td class="">{{center.center}}</td>
									<td>{{upperFirst(center.day_sched)}}</td>
									<td class="text-right"><a href="#" class="text-green text-sm">{{upperFirst(center.status)}}</a></td>
									<td class="text-right"><a @click="setEdit(center, 'center')" href="#" class="fa fa-edit"></a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</section>
			</div>
		</div>
		
		<div class="d-flex flex-column flex-xl-row mb-24">
			<div style="flex:9;">
				<section class="mb-24" style="flex:21;">
					<span class="section-title section-subtitle mb-12">Account Officer</span>

					<div class="d-flex flex-column light-border" v-if="officer.ao_id">
						<div class="d-flex justify-content-between bg-primary-dark text-white px-16 py-7">
							<span class="text-bold font-md">Edit {{officer.name}}</span>
							<a href="" @click.prevent="resetOfficer()" class="text-white"><i class="fa fa-times"></i></a>
						</div>
						<div class="p-16">
							<div class="form-group mb-24" style="flex:1">
								<label for="centerName" class="form-label">Code</label>
								<input v-model="branch_code" disabled type="text" class="form-control form-input " id="centerName">
							</div>
							<div class="form-group mb-24" style="flex:1">
								<label for="centerName" class="form-label">Full Name</label>
								<input v-model="officer.name" type="text" class="form-control form-input " id="centerName">
							</div>
							<div class="form-group mb-24" style="flex:1">
								<label for="centerName" class="form-label">Branch</label>
								<div class="d-flex">
									<select @select="branchCode(officer.branch_id)" v-model="officer.branch_id" name="" id="" class="form-control form-input mr-1">
										<option value="" disabled>Select Branch</option>
										<option v-for="branch in branches" :key="branch.branch_id" :value="branch.branch_id">{{branch.branch_name}}</option>
									</select>
									<a data-toggle="modal" data-target="#branchModal" href="#" class="btn btn-primary-dark" style="line-height:2;"><i class="fa fa-plus"></i></a>
								</div>
							</div>
							<div class="d-flex justify-content-between">
								<a @click.prevent="officer.status='active'" v-if="officer.status!='active'" href="#" class="btn btn-lg btn-yellow-light min-w-150">Activate</a>
								<a @click.prevent="officer.status='inactive'" v-if="officer.status=='active'" href="#" class="btn btn-lg btn-danger min-w-150">Deactivate</a>
								<a href="#" @click.prevent="saveOfficer()" class="btn btn-lg btn-success min-w-150">Save</a>
							</div>
						</div>
					</div>

					<div class="d-flex flex-column p-16 light-border" v-if="!officer.ao_id">
						<div class="form-group mb-24" style="flex:1">
							<label for="centerName" class="form-label">Code</label>
							<input v-model="branch_code" disabled type="text" class="form-control form-input " id="centerName">
						</div>
						<div class="form-group mb-24" style="flex:1">
							<label for="centerName" class="form-label">Full Name</label>
							<input v-model="officer.name" type="text" class="form-control form-input " id="centerName">
						</div>
						<div class="form-group mb-24" style="flex:1">
							<label for="centerName" class="form-label">Branch</label>
							<div class="d-flex">
								<select @select="branchCode(officer.branch_id)" v-model="officer.branch_id" name="" id="" class="form-control form-input mr-1">
									<option value="" disabled>Select Branch</option>
									<option v-for="branch in branches" :key="branch.branch_id" :value="branch.branch_id">{{branch.branch_name}}</option>
								</select>
								<a data-toggle="modal" data-target="#branchModal" href="#" class="btn btn-primary-dark" style="line-height:2;"><i class="fa fa-plus"></i></a>
							</div>
						</div>
						<div class="d-flex justify-content-end">
							<!-- <a href="#" class="btn btn-lg btn-yellow-light min-w-150">Activate / Deactivate</a> -->
							<a href="#" @click.prevent="saveOfficer()" class="btn btn-lg btn-success min-w-150">Save</a>
						</div>
					</div>
				</section>
			</div>
			<div style="flex:20">
				<section class="mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-12">Account Officer List</span>
					<div class="p-10 light-border">
						<table class="table table-stripped th-nb m-0">
							<tbody>
								<tr v-if="officers.length == 0">
									<td>No Account officers found.</td>
								</tr>
								<tr v-for="officer in officers" :key="officer.ao_id">
									<td>{{officer.name}}</td>
									<td class="text-right"><a href="#" class="text-green text-sm">{{upperFirst(officer.status)}}</a></td>
									<td class="text-right"><a @click.prevent="setEdit(officer,'officer')" href="#" class="fa fa-edit"></a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</section>
			</div>
		</div>
		<branch @branchUpdated="fetchBranches" :token="token"></branch>
	</div>
</template>

<script>
export default {
	props:['days','token'],
	data(){
		return {
			ddays:[],
			centers:[],
			center:{
				center_id:null,
				center:'',
				day_sched:'',
				status:'active',
				deleted:0
			},
			officers:[],
			officer:{
				ao_id:null,
				name:'',
				branch_id:'',
				status:'active',
				deleted:0,
			},
			branches:[],
			branch_code: '',
		}
	},
	methods:{
		resetOfficer:function(){
			this.officer = {
				ao_id:null,
				name:'',
				branch_id:'',
				status:'active',
				deleted:0,
			}
		},
		resetCenter:function(){
			this.center = {
				center_id:null,
				center:'',
				day_sched:'',
				status:'active',
				deleted:0
			}
		},
		fetchCenters:function(){
			axios.get(this.baseURL() + 'api/center', {
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
		fetchOfficers:function(){
			axios.get(this.baseURL() + 'api/accountofficer', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.officers = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		upperFirst:function (string) {
			return string.charAt(0).toUpperCase() + string.slice(1);
		},

		fetchBranches:function(){
			axios.get(this.baseURL() + 'api/branch', {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.branches = response.data.data;
				console.log(response.data);
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		
		saveOfficer: function(){
			if(this.officer.ao_id){
					axios.put(this.baseURL() + 'api/accountofficer/' + this.officer.ao_id, this.officer,{
						headers: {
							'Authorization': 'Bearer ' + this.token,
							'Content-Type': 'application/json',
							'Accept': 'application/json'
						}
					})
					.then(function (response) {
						this.notify('',response.data.message, 'success');
						this.fetchOfficers();
					}.bind(this))
					.catch(function (error) {
						console.log(error);
					}.bind(this));
			}else {
				axios.post(this.baseURL() + 'api/accountofficer', this.officer,{
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.notify('',response.data.message, 'success');
					this.fetchOfficers();
					this.resetOfficer();
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			}
			
		},

		save: function(){
			if(this.center.center_id){
					axios.put(this.baseURL() + 'api/center/' + this.center.center_id, this.center,{
						headers: {
							'Authorization': 'Bearer ' + this.token,
							'Content-Type': 'application/json',
							'Accept': 'application/json'
						}
					})
					.then(function (response) {
						this.notify('',response.data.message, 'success');
						this.fetchCenters();
					}.bind(this))
					.catch(function (error) {
						console.log(error);
					}.bind(this));
			}else {
				axios.post(this.baseURL() + 'api/center', this.center,{
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.notify('',response.data.message, 'success');
					this.fetchCenters();
					this.resetCenter();
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			}
			
		},

		setEdit: function(data, type){
			if(type=='center'){
				this.center.center_id = data.center_id;
				this.center.center = data.center;
				this.center.day_sched = data.day_sched;
				this.center.status = data.status;
				this.center.deleted = data.deleted;
			}else{
				this.officer.ao_id= data.ao_id;
				this.officer.name= data.name;
				this.officer.branch_id= data.branch_id;
				this.officer.status= data.status;
				this.officer.deleted= data.deleted;
			}
				
		},

		notify:function(title, text, type){
			this.$notify({
				group: 'foo',
				title: title,
				text: text,
				type: type,
			});
		},

		resetCenter: function(){
			this.center = {
				center_id:null,
				center:'',
				day_sched:'',
				status:'active',
				deleted:0
			}
		},

		resetOfficer: function(){
			this.officer = {
				ao_id:null,
				name:'',
				branch_id:1,
				status:'active',
				deleted:0,
			}
		}
	},
	watch: {
    // Note: only simple paths. Expressions are not supported.
		'officer.branch_id'(newValue) {
			for(let i in this.branches){
				if(this.branches[i].branch_id == newValue){
					this.branch_code = this.branches[i].branch_code;
				}			
			}
		}
	},
	mounted(){
		this.ddays = JSON.parse(this.days);
		this.fetchCenters();
		this.fetchOfficers();
		this.fetchBranches();
	}
}
</script>