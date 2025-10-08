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
				<section class="edit-section mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-12">Inputs</span>

					<div v-if="deduction.id" class="d-flex justify-content-between bg-primary-dark text-white px-16 py-7">
						<span class="text-bold font-md">Edit {{deduction.name}}</span>
						<a href="" @click.prevent="resetDeduction()" class="text-white"><i class="fa fa-times"></i></a>
					</div>
					<div class="d-flex flex-column p-16 light-border">
						<div class="form-group mb-10" style="flex:1">
							<label for="insurance" class="form-label">Deduction Name</label>
							<select v-model="deduction.name" name="" id="" class="form-control form-input" required>
								<option value="Insurance">Insurance</option>
								<option value="Documentary Stamp">Documentary Stamp</option>
								<option value="Notarial Fee">Notarial Fee</option>
								<option value="Filing Fee">Filing Fee</option>
							</select>
						</div>
						<div class="form-group mb-10" style="flex:1">
							<label for="documentStamp" class="form-label">Rate</label>
							<input v-model="deduction.rate" type="text" class="form-control form-input " id="Rate" required>
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
						<div class="mb-24" style="flex:1">
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
						<!-- <div class="form-group mb-24" style="flex:1">
							<label for="documentStamp" class="form-label">Status</label>
							<input v-model="deduction.status" type="text" disabled class="form-control form-input " id="Rate">
						</div> -->
						<div class="d-flex justify-content-between">
							<a @click="deduction.status='active'" v-if="deduction.id && deduction.status!='active'" href="#" class="btn btn-lg btn-yellow-light min-w-150">Activate</a>
							<a @click="deduction.status='inactive'" v-if="deduction.id && deduction.status=='active'" href="#" class="btn btn-lg btn-danger min-w-150">Deactivate</a>
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
								<th></th>
								<th></th>
							</thead>
							<tbody>
								<tr v-if="!deductions.length">
									<td>No deductions yet.</td>
								</tr>
								<tr v-for="deductionItem in deductions" :key="deductionItem.id" :class="getRowClass(deductionItem)">
									<td>{{deductionItem.name}}</td>
									<td>{{deductionItem.rate}}</td>
									<td>{{productName(deductionItem.product_id)}}</td>
									<td>{{deductionItem.term_start}}</td>
									<td>{{deductionItem.term_end}}</td>
									<td>{{deductionItem.age_start}}</td>
									<td> {{deductionItem.age_end}}</td>
									<td v-if="deductionItem.status=='active'"><i class="text-green">{{upperFirst(deductionItem.status)}}</i></td>
									<td v-if="deductionItem.status!='active'"><i class="text-red">{{upperFirst(deductionItem.status)}}</i></td>
									<td>
										<a href="#" @click.prevent="editDeduction(deductionItem)"><i class="fa fa-edit text-sm mr-16"></i></a>
										<a href="#" @click.prevent="deleteDeduction(deductionItem)"><i class="fa fa-trash text-sm"></i></a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</section>
			</div>
		</div>
		</form>
		<div v-if="showDeleteModal" class="modal" tabindex="-1" role="dialog" style="display: block; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.5); z-index: 9999; margin: 0;">
		    <div class="modal-dialog modal-md" role="document" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 500px; margin: 0;">
		        <div class="modal-content">
		            <div class="modal-body p-24">
		                <div class="d-flex align-items-center">
		                    <img :src="baseURL()+'/img/warning.png'" style="width:120px;height:auto;" class="mr-24" alt="warning icon">
		                    <div class="d-flex flex-column">
		                        <span class="text-primary-dark text-bold mb-16">
		                            Are you sure you want to delete this deduction?
		                        </span>
		                        <div v-if="deductionToDelete" class="mb-24 text-primary-dark text-bold text-center">
		                            <strong>{{deductionToDelete.name}}<br>Rate: {{deductionToDelete.rate}}<br>Product: {{productName(deductionToDelete.product_id)}}<br>Term: {{deductionToDelete.term_start}} - {{deductionToDelete.term_end}}<br>Age: {{deductionToDelete.age_start}} - {{deductionToDelete.age_end}}</strong>
		                        </div>
		                        <div class="d-flex mt-auto justify-content-between">
		                            <a href="#" @click.prevent="cancelDelete()" class="btn btn-danger min-w-120">Cancel</a>
		                            <a @click.prevent="confirmDelete()" href="#" class="btn btn-primary-dark min-w-120">Proceed</a>
		                        </div>
		                    </div>
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
				},
				deletingDeductionId: null,
				showDeleteModal: false,
				deductionToDelete: null
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
							this.resetDeduction();
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
							this.resetDeduction();
						}.bind(this))
						.catch(function (error) {
							console.log(error);
						}.bind(this));
				}
				
			},

			async confirmDelete() {
			    await axios.delete(this.baseURL() + 'api/deduction/' + this.deductionToDelete.id, {
			        headers: {
			            'Authorization': 'Bearer ' + this.token,
			            'Content-Type': 'application/json',
			            'Accept': 'application/json'
			        }
			    })
			    .then(function (response) {
			        this.notify('', response.data.message, 'success');
			        this.deletingDeductionId = null;
			        this.fetchDeductions();
			        this.showDeleteModal = false;
			        this.deductionToDelete = null;
			    }.bind(this))
			    .catch(function (error) {
			        console.log(error);
			        this.notify('', 'Error deleting deduction', 'error');
			        this.deletingDeductionId = null;
			        this.showDeleteModal = false;
			        this.deductionToDelete = null;
			    }.bind(this));
			},
			cancelDelete: function() {
			    this.deletingDeductionId = null;
			    this.showDeleteModal = false;
			    this.deductionToDelete = null;
			},
			deleteDeduction: function(deductionItem) {
			    this.resetDeduction();
			    this.deletingDeductionId = deductionItem.id;
			    this.deductionToDelete = deductionItem;
			    this.showDeleteModal = true;
			},
			editDeduction: function(deductionItem) {
			    this.deduction = JSON.parse(JSON.stringify(deductionItem));
			    this.$nextTick(() => {
			        const editForm = document.querySelector('.edit-section');
			        if (editForm) {
			            editForm.scrollIntoView({ 
			                behavior: 'smooth', 
			                block: 'start' 
			            });
			        }
			    });
			},
			getRowClass: function(deductionItem) {
			    if (this.deletingDeductionId == deductionItem.id) {
			        return 'deleting-deduction';
			    }
			    if (this.deduction.id === deductionItem.id) {
			        return 'row-being-edited';
			    }
			    return '';
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
			},
			resetDeduction:function(){
				this.deduction = {
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
        mounted() {
			this.fetchDeductions();
           	this.fetchProducts();
        }
    }
</script>

<style scoped>
	.deleting-deduction {
	    background-color: #ffcccb !important;
	}
</style>