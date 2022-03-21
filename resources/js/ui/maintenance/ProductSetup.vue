<template>
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">Product Setup</h1>
		</div><!-- /.col -->
		<div class="d-flex flex-column flex-xl-row ml-16">
			<div style="flex:9;">
				<section class="mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-12">Inputs</span>

					<div class="d-flex flex-column p-16 light-border" v-if="product.product_id==null">
						<div class="form-group mb-10" style="flex:1">
							<label for="productName" class="form-label">Product Name</label>
							<input type="text" v-model="product.product_name" class="form-control form-input " id="productName">
						</div>
						<div class="d-flex flex-row mb-24">
							<div class="form-group mb-10 mr-24" style="flex:1">
								<label for="productName" class="form-label">Product Code</label>
								<input type="text" v-model="product.product_code" class="form-control form-input " id="productName">
							</div>
							<div class="form-group mb-10" style="flex:1">
								<label for="productName" class="form-label">Percentage</label>
								<input type="text" v-model="product.interest_rate" class="form-control form-input " id="productName">
							</div>
						</div>
						<div class="d-flex justify-content-end">
							<a href="#" @click="save()" class="btn btn-lg btn-success min-w-150">Save</a>
						</div>
					</div>
					<div class="d-flex flex-column light-border" v-if="product.product_id">
						<div class="d-flex justify-content-between mb-16 bg-primary-dark text-white px-16 py-7">
							<span class="text-bold font-md">Edit {{product.product_name}}</span>
							<a href="" @click="resetProduct()" class="text-white"><i class="fa fa-times"></i></a>
						</div>
						<div class="px-16 mb-16">
							<div class="form-group mb-10" style="flex:1">
								<label for="productName" class="form-label">Product Name</label>
								<input type="text" v-model="product.product_name" class="form-control form-input " id="productName">
							</div>
							<div class="d-flex flex-row mb-24">
								<div class="form-group mb-10 mr-24" style="flex:1">
									<label for="productName" class="form-label">Product Code</label>
									<input type="text" v-model="product.product_code" class="form-control form-input " id="productName">
								</div>
								<div class="form-group mb-10" style="flex:1">
									<label for="productName" class="form-label">Percentage</label>
									<input type="text" v-model="product.interest_rate" class="form-control form-input " id="productName">
								</div>
							</div>
							<div class="d-flex justify-content-between">
								<a @click="product.status='active'" v-if="product.status!='active'" href="#" class="btn btn-lg btn-yellow-light min-w-150">Activate</a>
								<a @click="product.status='inactive'" v-if="product.status=='active'" href="#" class="btn btn-lg btn-danger min-w-150">Deactivate</a>
								<a href="#" @click="save()" class="btn btn-lg btn-success min-w-150">Save</a>
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
								<th>Product Name</th>
								<th>Product Code</th>
								<th>Percentage</th>
								<th></th>
							</thead>
							<tbody>
								<tr v-if="products.length==0">
									<td>No products found.</td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr v-for="product in products" :key="product.product_id">
									<td>{{product.product_name}}</td>
									<td>{{product.product_code}}</td>
									<td>{{product.interest_rate}}%</td>
									<td class="text-green text-sm"><a href="#" class="text-green">{{product.status}}</a></td>
									<td><a @click.prevent="setEdit(product)" href="#"><i class="fa fa-edit"></i></a></td>
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
				products:[],
				product:{
					product_id:null,
					product_code:'',
					product_name:'',
					product_description:'',
					interest_rate:'',
					status:'active',
					deleted:0
				}
			}
		},
		methods: {
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
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			},
			setEdit: function(data){
					this.product.product_id = data.product_id;
					this.product.product_code = data.product_code;
					this.product.product_name = data.product_name;
					this.product.product_description = data.product_description;
					this.product.interest_rate = data.interest_rate;
					this.product.status = data.status;
					this.product.deleted = data.deleted;
			},
			save: function(){
				if(this.product.product_id){
						axios.put(window.location.origin + '/api/product/' + this.product.product_id, this.product, {
						headers: {
								'Authorization': 'Bearer ' + this.token,
								'Content-Type': 'application/json',
								'Accept': 'application/json'
							}
						})
						.then(function (response) {
							this.notify('',response.data.message, 'success');
							this.fetchProducts();
						}.bind(this))
						.catch(function (error) {
							console.log(error);
						}.bind(this));
				}else {
					axios.post(window.location.origin + '/api/product', this.product, {
						headers: {
								'Authorization': 'Bearer ' + this.token,
								'Content-Type': 'application/json',
								'Accept': 'application/json'
							}
						})
						.then(function (response) {
							this.notify('',response.data.message, 'success');
							this.fetchProducts();
						}.bind(this))
						.catch(function (error) {
							console.log(error);
						}.bind(this));
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
			resetProduct: function(){
				this.product = {
									product_id:null,
									product_code:'',
									product_name:'',
									product_description:'',
									interest_rate:'',
									status:'active',
									deleted:0
								}
			}
		},
        mounted() {
           	this.fetchProducts();
        }
    }
</script>

<style scoped>
	td {
		cursor: pointer;
	}
</style>