<template>
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">Deduction Rate</h1>
		</div><!-- /.col -->
		<div class="d-flex flex-column flex-xl-row ml-16">
			<div style="flex:9;">
				<section class="mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-12">Inputs</span>

					<div class="d-flex flex-column p-16 light-border">
						<div class="form-group mb-10" style="flex:1">
							<label for="insurance" class="form-label">Insurance</label>
							<input type="text" class="form-control form-input " id="insurance">
						</div>
						<div class="form-group mb-10" style="flex:1">
							<label for="documentStamp" class="form-label">Document Stamp</label>
							<input type="text" class="form-control form-input " id="documentStamp">
						</div>
						<div class="form-group mb-10" style="flex:1">
							<label for="notarialFee" class="form-label">Notarial Fee</label>
							<input type="text" class="form-control form-input " id="notarialFee">
						</div>
						<div class="d-flex justify-content-end">
							<a href="#" @click="save()" class="btn btn-lg btn-success min-w-150">Save</a>
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
								<th>Insurance</th>
								<th>Document Stamp</th>
								<th>Notarial Fee</th>
							</thead>
							<tbody>
								<tr>
									<td>100</td>
									<td>200</td>
									<td>300</td>
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
				axios.get(this.baseURL() + 'api/product/', {
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
						axios.put(this.baseURL() + 'api/product/' + this.product.product_id, this.product, {
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
					axios.post(this.baseURL() + 'api/product', this.product, {
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