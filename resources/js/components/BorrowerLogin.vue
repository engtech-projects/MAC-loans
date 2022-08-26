<template>
	<div class="card card-outline">
		<div class="card-header text-center">
		<span href="" class="h1"><b>δάνειο</b>s</span>
		</div>
		<div class="card-body">
			<p class="login-box-msg">Borrower Sign in</p>

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
				<!-- /.col -->
				<div class="col-4">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
				</div>
				<p style="color:red;">{{errorMessage}}</p>
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
				},
				token:''
			},
			errorMessage:'',
			branches:[],
		}
	},
	methods: {
		login:function(){
			axios.post(this.baseURL() + 'api/borrower_login', this.data)
			.then(function (response) {
				if(response.data.success){
					this.data.token = response.data.data.token;
					this.makeAuth();
				}else{
					this.errorMessage = response.data.message
				}
				console.log(response)
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		makeAuth:function(){
			axios.post(this.baseURL() + 'borrower_login', this.data)
			.then(function (response) {
				window.location.replace(this.baseURL() + 'borrower/personal_information');
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
	},
	mounted(){
		console.log(this.baseURL());
	}
}
</script>