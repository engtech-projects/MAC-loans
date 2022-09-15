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
							<label for="insurance" class="form-label">Deduction Name</label>
							<select name="" id="" class="form-control form-input">
								<option value="Insurance">Insurance</option>
								<option value="Insurance">Document Stamp</option>
								<option value="Insurance">Notarial Fee</option>
								<option value="Insurance">Filing Fee</option>
							</select>
						</div>
						<div class="form-group mb-10" style="flex:1">
							<label for="documentStamp" class="form-label">Rate</label>
							<input type="text" class="form-control form-input " id="documentStamp">
						</div>
						<div class="form-group mb-10" style="flex:1">
							<label for="notarialFee" class="form-label">Product</label>
							<select name="" id="" class="form-control form-input">
								<option v-for="p in products" :key="p.product_id" :value="p.product_id">{{p.product_name}}</option>
							</select>
						</div>
						<div class="mb-10">
							<span class="font-lg">Term Bracket</span>
							<div class="d-flex">
								<div class="d-flex flex-column flex-1 mr-24">
									<span>Start</span>
									<input type="text" class="form-control form-input " id="termStart">
								</div>
								<div class="d-flex flex-column flex-1">
									<span>End</span>
									<input type="text" class="form-control form-input " id="termStart">
								</div>
							</div>
						</div>
						<div class="mb-24">
							<span class="font-lg">Age Bracket</span>
							<div class="d-flex">
								<div class="d-flex flex-column flex-1 mr-24">
									<span>Start</span>
									<input type="text" class="form-control form-input " id="termStart">
								</div>
								<div class="d-flex flex-column flex-1">
									<span>End</span>
									<input type="text" class="form-control form-input " id="termStart">
								</div>
							</div>
						</div>
						<div class="d-flex justify-content-between">
							<a href="#" @click.prevent="" class="btn btn-yellow-light">Activate / Deactivate</a>
							<a href="#" @click.prevent="save()" class="btn btn-lg btn-success min-w-150">Save</a>
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
							</thead>
							<tbody>
								<tr>
									<td>100</td>
									<td>200</td>
									<td>300</td>
									<td></td>
									<td></td>
									<td></td>
									<td>  </td>
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
				deductions:[],
				deduction:{}
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
			
			async save(){
				if(this.product.product_id){
					await axios.put(this.baseURL() + 'api/product/' + this.product.product_id, this.product, {
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
					await axios.post(this.baseURL() + 'api/product', this.product, {
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