<template>
	<div class="modal" id="branchModal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg minw-70" role="document">
			<div class="modal-content">
				<div class="modal-body font-md pxy-25">
					<notifications group="foo" />
					<div class=" mb-24 dark-bb d-flex justify-content-between">
						<span class="text-block text-bold pb-7">Branch</span>
						<a data-dismiss="modal" href="" class=""><i class="fa fa-times"></i></a>
					</div>
					<div class="d-flex mb-24">
						<div class="flex-1 mr-16">
							<div v-if="branch.branch_id" class="d-flex flex-column light-border">
								<div class="d-flex justify-content-between bg-primary-dark text-white px-16 py-7">
									<span class="text-bold font-md">Edit {{branch.branch_name}}</span>
									<a href="" @click.prevent="resetBranch()" class="text-white"><i class="fa fa-times"></i></a>
								</div>
								<div class="p-16">
									<div class="form-group mb-24" style="flex:1">
										<label for="branchCode" class="form-label">Branch Code</label>
										<input type="text" v-model="branch.branch_code" class="form-control form-input " id="branchCode">
									</div>
									<div class="form-group mb-24" style="flex:1">
										<label for="branchName" class="form-label">Branch Name</label>
										<input type="text" v-model="branch.branch_name" class="form-control form-input " id="branchName">
									</div>
									<div class="form-group mb-24" style="flex:1">
										<label for="branchManager" class="form-label">Branch Manager</label>
										<input type="text" v-model="branch.branch_manager" class="form-control form-input " id="branchManager">
									</div>
									<div class="form-group mb-24" style="flex:1">
										<label for="branchAddress" class="form-label">Branch Address</label>
										<input type="text" v-model="branch.branch_address" class="form-control form-input " id="branchAddress">
									</div>
									<div class="d-flex justify-content-between">
										<a @click="branch.status='active'" v-if="branch.status!='active'" href="#" class="btn btn-lg btn-yellow-light min-w-150">Activate</a>
										<a @click="branch.status='inactive'" v-if="branch.status=='active'" href="#" class="btn btn-lg btn-danger min-w-150">Deactivate</a>
										<a href="#" @click.prevent="save()" class="btn btn-lg btn-success min-w-150">Save</a>
									</div>
								</div>
							</div>
							<div v-if="!branch.branch_id" class="d-flex flex-column light-border">
								<div class="p-16">
									<div class="form-group mb-24" style="flex:1">
										<label for="branchCode" class="form-label">Branch Code</label>
										<input type="text" v-model="branch.branch_code" class="form-control form-input " id="branchCode">
									</div>
									<div class="form-group mb-24" style="flex:1">
										<label for="branchName" class="form-label">Branch Name</label>
										<input type="text" v-model="branch.branch_name" class="form-control form-input " id="branchName">
									</div>
									<div class="form-group mb-24" style="flex:1">
										<label for="branchManager" class="form-label">Branch Manager</label>
										<input type="text" v-model="branch.branch_manager" class="form-control form-input " id="branchManager">
									</div>
									<div class="form-group mb-24" style="flex:1">
										<label for="branchAddress" class="form-label">Branch Address</label>
										<input type="text" v-model="branch.branch_address" class="form-control form-input " id="branchAddress">
									</div>
									<div class="d-flex justify-content-end">
										<a href="#" @click.prevent="save()" class="btn btn-lg btn-success min-w-150">Save</a>
									</div>
								</div>
							</div>
						</div>
						<div class="flex-2 light-border px-16">
							<table class="table table-stripped">
								<thead>
									<th>Code</th>
									<th>Branch Name</th>
									<th>Branch Manager</th>
									<th>Address</th>
									<th>Status</th>
									<th></th>
								</thead>
								<tbody>
									<tr v-if="branches.length == 0">
										<td>No Branches found.</td>
									</tr>
									<tr v-for="branch in branches" :key="branch.branch_id">
										<td>{{branch.branch_code}}</td>
										<td>{{branch.branch_name}}</td>
										<td>{{branch.branch_manager}}</td>
										<td>{{branch.branch_address}}</td>
										<td class="text-green">{{upperFirst(branch.status)}}</td>
										<td><a @click.prevent="setEdit(branch)" href="#"><i class="fa fa-edit"></i></a></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props:['token'],
	data(){
		return {
			branches:[],
			branch:{
				branch_id:null,
				branch_code:'',
				branch_name:'',
				branch_manager:'',
				branch_address:'',
				status:'active',
				deleted:0
			}
		}
	},
	methods:{
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
		save: function(){
			if(this.branch.branch_id){
					axios.put(this.baseURL() + 'api/branch/' + this.branch.branch_id, this.branch,{
						headers: {
							'Authorization': 'Bearer ' + this.token,
							'Content-Type': 'application/json',
							'Accept': 'application/json'
						}
					})
					.then(function (response) {
						this.notify('',response.data.message, 'success');
						this.fetchBranches();
						this.resetBranch();
						this.$emit('branchUpdated');
					}.bind(this))
					.catch(function (error) {
						this.notify('',"Something went wrong. Please make sure all fields have been filled correctly.",'error')
						console.log(error);
					}.bind(this));
			}else {
				axios.post(this.baseURL() + 'api/branch', this.branch,{
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.notify('',response.data.message, 'success');
					this.resetBranch();
					this.fetchBranches();
					this.$emit('branchUpdated');
				}.bind(this))
				.catch(function (error) {
					this.notify('',"Something went wrong. Please make sure all fields have been filled correctly.",'error')
					console.log(error);
				}.bind(this));
			}
			
		},
		setEdit: function(data){
			this.branch.branch_id = data.branch_id;
			this.branch.branch_code = data.branch_code;
			this.branch.branch_name = data.branch_name;
			this.branch.branch_address = data.branch_address;
			this.branch.status = data.status;
			this.branch.deleted = data.deleted;
		},
		notify:function(title, text, type){
			this.$notify({
				group: 'foo',
				title: title,
				text: text,
				type: type,
			});
		},
		resetBranch:function(){
			this.branch = {
				branch_id:null,
				branch_code:'',
				branch_name:'',
				branch_address:'',
				status:'active',
				deleted:0
			}
		},
		upperFirst:function (string) {
			return string.charAt(0).toUpperCase() + string.slice(1);
		},
	},
	mounted(){
		this.fetchBranches();
	}
}
</script>