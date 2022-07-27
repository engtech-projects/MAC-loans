<template>
	<div class="card card-outline">
		<div class="card-header text-center">
		<span href="" class="h1"><b>δάνειο</b>s</span>
		</div>
		<div class="card-body">
			<p class="login-box-msg">Sign in</p>

			<form action="" method="post" @submit.prevent="login">
				<div class="input-group mb-3">
				<input required v-model="data.credentials.username" name="username" type="text" class="form-control" placeholder="Username">
				<div class="input-group-append">
					<div class="input-group-text">
					<span class="fas fa-user"></span>
					</div>
				</div>
				</div>
				<div class="input-group mb-3">
				<input required v-model="data.credentials.password" name="password" type="password" autocomplete="off" class="form-control" placeholder="Password">
				<div class="input-group-append">
					<div class="input-group-text">
					<span class="fas fa-lock"></span>
					</div>
				</div>
				</div>
				<div class="row">
				<div class="col-8">
					<select required v-model="data.credentials.branch_id" class="form-control">
						<option value="" disabled selected>Select</option>
						<option v-for="b in branches" :key="b.branch_id" :value="b.branch_id">{{b.branch_name}}</option>
					</select>
				</div>
				<!-- /.col -->
				<div class="col-4">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
				</div>
				<!-- /.col -->
				</div>
			</form>

		</div>
    <!-- /.card-body -->
  	</div>
</template>

<script>
export default {
	props:['csrf'],
	data(){
		return {
			data:{
				credentials: {
					username:'',
					password:'',
					branch_id: '',
				},
				token:''
			},
			branches:[],
		}
	},
	methods: {
		login:function(){
			axios.post(this.baseURL() + 'api/login', this.data.credentials)
			.then(function (response) {
				this.data.token = response.data.data.token;
				window.location.replace(this.baseURL() + 'dashboard');
				this.makeAuth();
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		fetchBranches:function(){
			axios.get('/branch')
			.then(function (response) {
				this.branches = response.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		}, 
		makeAuth:function(){
			axios.post(this.baseURL() + 'login', this.data)
			.then(function (response) {
				window.location.replace(this.baseURL() + 'maintenance/product_setup');
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
	},
	mounted(){
		this.fetchBranches();
	}
}
</script>