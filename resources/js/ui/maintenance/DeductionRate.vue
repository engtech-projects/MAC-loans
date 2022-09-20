<template>
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">Deduction Rate</h1>
		</div><!-- /.col -->
		<form @submit.prevent="save()">
		<div class="d-flex flex-column flex-xl-row ml-16">
			<div style="flex:9;">
				<section class="mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-12">Inputs</span>

					<div class="d-flex flex-column p-16 light-border">
						<div class="form-group mb-10" style="flex:1">
							<label for="insurance" class="form-label">Deduction Name</label>
							<select v-model="deduction.name" name="" id="" class="form-control form-input" required>
								<option value="Insurance">Insurance</option>
								<option value="Document Stamp">Document Stamp</option>
								<option value="Notarial Fee">Notarial Fee</option>
								<option value="Filing Fee">Filing Fee</option>
							</select>
						</div>
						<div class="form-group mb-10" style="flex:1">
							<label for="documentStamp" class="form-label">Rate</label>
							<input v-model="deduction.rate" type="text" class="form-control form-input " id="Rate">
						</div>
						<div class="form-group mb-10" style="flex:1">
							<label for="notarialFee" class="form-label">Product</label>
							<select v-model="deduction.product_id" name="" id="" class="form-control form-input">
								<option v-for="p in products" :key="p.product_id" :value="p.product_id">{{p.product_name}}</option>
							</select>
						</div>
						<div class="mb-10">
							<span class="font-lg">Term Bracket</span>
							<div class="d-flex">
								<div class="d-flex flex-column flex-1 mr-24">
									<span>Start</span>
									<input v-model="deduction.term_start" type="number" class="form-control form-input " id="termStart">
								</div>
								<div class="d-flex flex-column flex-1">
									<span>End</span>
									<input v-model="deduction.term_end" type="number" class="form-control form-input " id="termEnd">
								</div>
							</div>
						</div>
						<div class="mb-12">
							<span class="font-lg">Age Bracket</span>
							<div class="d-flex">
								<div class="d-flex flex-column flex-1 mr-24">
									<span>Start</span>
									<input v-model="deduction.age_start" type="number" class="form-control form-input " id="ageStart">
								</div>
								<div class="d-flex flex-column flex-1">
									<span>End</span>
									<input v-model="deduction.age_end" type="number" class="form-control form-input " id="ageEnd">
								</div>
							</div>
						</div>
						<div class="form-group mb-24" style="flex:1">
							<label for="documentStamp" class="form-label">Status</label>
							<input v-model="deduction.status" type="text" disabled class="form-control form-input " id="Rate">
						</div>
						<div class="d-flex justify-content-between">
							<a href="#" @click.prevent="setDeductionStatus()" class="btn btn-yellow-light">Activate / Deactivate</a>
							<input type="submit" class="btn btn-lg btn-success min-w-150" value="Save">
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
								<th>Deduction Name</th>
								<th>Rate</th>
								<th>Product</th>
								<th>Term Start</th>
								<th>Term End</th>
								<th>Age Start</th>
								<th>Age End</th>
								<th>Status</th>
							</thead>
							<tbody>
								<tr v-if="!deductions.length">
									<td>No deductions yet.</td>
								</tr>
								<tr v-for="d in deductions" :key="d.id">
									<td>{{d.name}}</td>
									<td>{{d.rate}}</td>
									<td>{{productName(d.product_id)}}</td>
									<td>{{d.term_start}}</td>
									<td>{{d.term_end}}</td>
									<td>{{d.age_start}}</td>
									<td> {{d.age_end}}</td>
									<td v-if="d.status=='active'"><i class="text-green">{{upperFirst(d.status)}}</i></td>
									<td v-if="d.status!='active'"><i class="text-red">{{upperFirst(d.status)}}</i></td>
									<td><a href="#" @click.prevent="deduction=d"><i class="fa fa-edit text-sm mr-16"></i></a><a href="#" @click.prevent="attemptDelete(d.id)"><i class="fa fa-trash text-sm"></i></a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</section>
			</div>
		</div>
		</form>
	</div>
</template>

<script>
    export default {
		props:['token'],
		data(){
			return {
				csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
				products:[],
				deductions:[],
				deduction:{
					id:null,
					name:'',
					rate:'',
					product_id:'',
					term_start:'',
					term_end:'',
					age_start:'',
					age_end:'',
					status:'active',
				}
			}
		},
		methods: {
			async fetchProducts(){
				await axios.get(this.baseURL() + 'api/product/', {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.products = response.data.data;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},

			async fetchDeductions(){
				await axios.get(this.baseURL() + 'api/deduction/', {
					headers: {
						'Authorization': 'Bearer ' + this.token,
						'Content-Type': 'application/json',
						'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.deductions = response.data.data;
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
			
			async save(){
				if(this.deduction.id){
					await axios.put(this.baseURL() + 'api/deduction/' + this.deduction.id, this.deduction, {
						headers: {
								'Authorization': 'Bearer ' + this.token,
								'Content-Type': 'application/json',
								'Accept': 'application/json'
							}
						})
						.then(function (response) {
							this.notify('',response.data.message, 'success');
							this.fetchDeductions();
						}.bind(this))
						.catch(function (error) {
							console.log(error);
						}.bind(this));
				}else {
					await axios.post(this.baseURL() + 'api/deduction', this.deduction, {
						headers: {
								'Authorization': 'Bearer ' + this.token,
								'Content-Type': 'application/json',
								'Accept': 'application/json'
							}
						})
						.then(function (response) {
							this.notify('',response.data.message, 'success');
							this.fetchDeductions();
						}.bind(this))
						.catch(function (error) {
							console.log(error);
						}.bind(this));
				}
				
			},

			async delete(id){
				await axios.delete(this.baseURL() + 'api/deduction/' + id, {
					headers: {
							'Authorization': 'Bearer ' + this.token,
							'Content-Type': 'application/json',
							'Accept': 'application/json'
						}
					})
					.then(function (response) {
						this.notify('',response.data.message, 'success');
						this.fetchDeductions();
					}.bind(this))
					.catch(function (error) {
						console.log(error);
					}.bind(this));
			},
			attemptDelete:function(id){
				var del = window.confirm("Do you want to delete this item?");
				if (del) {
					this.delete(id);
				}
				else {
					//some code
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
			productName:function(id){
				var pname = '';
				this.products.map(function(prod){
					if(id == prod.product_id){
						pname = prod.product_name
					}
				}.bind(this));
				return pname;
			},
			setDeductionStatus:function(){
				this.deduction.status = this.deduction.status=='active'?'inactive':'active';
			}
		},
        mounted() {
			this.fetchDeductions();
           	this.fetchProducts();
        }
    }
</script>

<style scoped>
	td {
		cursor: pointer;
	}
</style>