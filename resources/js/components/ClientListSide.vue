<template>
	<div class="d-flex flex-column">
		<div class="search-bar mb-12">
			<input v-model="filter" type="text" class="form-control" id="searchBar" placeholder="Search">
			<div><i class="fa fa-search"></i></div>
		</div>
		<table v-if="id" class="table table-stripped table-hover" id="clientsList">
			<thead>
				<th>Borrower #</th>
				<th>Client Name</th>
				<th></th>
			</thead>
			<tbody>
				<tr v-if="pborrowers.length == 0">
					<td>No borrowers yet.</td>
					<td></td>
					<td></td>
				</tr>
				<tr class="client-item" :class="isActive(b)" v-for="(b, i) in paginate" :key="i">
					<td>{{b.borrower_num}}</td>
					<td><a href="#">{{b.firstname + ' ' + b.lastname}}</a></td>
					<td><span @click="$emit('selectBorrower',b.borrower_id);borrower=b" class="text-green c-pointer">select</span></td>
				</tr>
			</tbody>
		</table>
		<table v-if="account" class="table table-stripped table-hover" id="clientsList">
			<thead>
				<th>Borrower #</th>
				<th>Client Name</th>
				<th></th>
			</thead>
			<tbody>
				<tr v-if="pborrowers.length == 0">
					<td>No borrowers yet.</td>
					<td></td>
					<td></td>
				</tr>
				<tr class="client-item" :class="isActiveAccount(b )" v-for="(b,i) in paginate" :key="i">
					<td>{{b.borrower.borrower_num}}</td>
					<td><a href="#">{{b.borrower.firstname + ' ' + b.borrower.lastname}}</a></td>
					<td><span @click="$emit('selectAccount',b)" class="text-green c-pointer">select</span></td>
				</tr>
			</tbody>
		</table>
		<mac-pagination v-if="account" @setpage="setPage" :pdata="filterAccount" :ppage="pagination.page" :prange="pagination.range" class="mb-24"></mac-pagination>
		<mac-pagination v-else @setpage="setPage" :pdata="filterClient" :ppage="pagination.page" :prange="pagination.range" class="mb-24"></mac-pagination>
		<!-- <div v-if="filterClient.length > pagination.range" class="d-flex justify-content-end">
			<div class="d-flex pagination pagination-mini">
				<span @click="pagination.page=i" :class="i==pagination.page?'active':''" v-for="i in Math.ceil(filterClient.length/pagination.range)" :key="i">{{i}}</span>
			</div>
		</div>
		<div v-if="account && filterAccount.length > pagination.range" class="d-flex justify-content-end">
			<div class="d-flex pagination pagination-mini">
				<span @click="pagination.page=i" :class="i==pagination.page?'active':''" v-for="i in Math.ceil(filterClient.length/pagination.range)" :key="i">{{i}}</span>
			</div>
		</div> -->
	</div>
</template>

<script>
export default {
	props:['pborrowers', 'id', 'account'],
	data(){
		return {
			filter:'',
			borrower:{
				borrower_id:'',
			},
			pagination:{
				page: 1,
				range: 10
			}
		}
	},
	methods:{
		setPage:function(page){
			this.pagination.page = page;
		},
		isActive:function(borrower){
			if(borrower.borrower_id == this.id || borrower.borrower_id == this.borrower.borrower_id){
				return 'active';
			}
			return '';
		},
		isActiveAccount:function(account){
			if(account.loan_account_id == this.account){
				return 'active';
			}
			return '';
		}
	},
	computed:{
		filterClient:function(){
			var result = [];
			if(this.pborrowers.length > 0 && !this.account){
				this.pborrowers.map(function(data){
					if(data.borrower_num.toLowerCase().includes(this.filter.toLowerCase()) || data.firstname.toLowerCase().includes(this.filter.toLowerCase()) || data.lastname.toLowerCase().includes(this.filter.toLowerCase()) || (data.firstname + ' ' + data.lastname).toLowerCase().includes(this.filter.toLowerCase()) || (data.lastname + ' ' + data.firstname).toLowerCase().includes(this.filter.toLowerCase())){
						result.push(data);
					}
				}.bind(this));
			}else{
				result = this.pborrowers;
			}
			return result;
		},
		filterAccount:function(){
			var result = [];
			if(this.pborrowers.length > 0){
				this.pborrowers.map(function(data){
					if(data.borrower.borrower_num.toLowerCase().includes(this.filter.toLowerCase()) || data.borrower.firstname.toLowerCase().includes(this.filter.toLowerCase()) || data.borrower.lastname.toLowerCase().includes(this.filter.toLowerCase()) || (data.borrower.firstname + ' ' + data.borrower.lastname).toLowerCase().includes(this.filter.toLowerCase()) || (data.borrower.lastname + ' ' + data.borrower.firstname).toLowerCase().includes(this.filter.toLowerCase())){
						result.push(data);
					}
				}.bind(this));
			}else{
				result = this.pborrowers;
			}
			return result;
		},
		paginate:function(){
			var arr = this.account?this.filterAccount:this.filterClient;
			var result = [];
			var start = (this.pagination.page - 1) * this.pagination.range;
			var end = 0;
			for(var i = start; i < arr.length; i++){
				if(end < this.pagination.range){
					result.push(arr[i]);
				}
				end++;
			}
			return result;
		}
	},
}
</script>

<style lang="scss" scoped>
	.client-item.active {
		background-color: #78e08f;
	}
</style>