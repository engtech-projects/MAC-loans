<template>
	<div class="d-flex flex-column">
		<div class="search-bar mb-12">
			<input v-model="filter" type="text" class="form-control" id="searchBar" placeholder="Search">
			<div><i class="fa fa-search"></i></div>
		</div>
		<table v-if="id" class="table table-stripped table-hover" id="clientsList">
			<thead>
				<th>Account #</th>
				<th>Client Name</th>
				<th></th>
			</thead>
			<tbody>
				<tr v-if="pborrowers.length == 0">
					<td>No borrowers yet.</td>
					<td></td>
					<td></td>
				</tr>
				<tr class="client-item" :class="isActive(b)" v-for="(b) in filterClient" :key="b.borrower_id">
					<td>{{b.borrower_num}}</td>
					<td><a href="#">{{b.firstname + ' ' + b.lastname}}</a></td>
					<td><span @click="$emit('selectBorrower',b.borrower_id)" class="text-green c-pointer">select</span></td>
				</tr>
			</tbody>
		</table>
		<table v-if="account" class="table table-stripped table-hover" id="clientsList">
			<thead>
				<th>Account #</th>
				<th>Client Name</th>
				<th></th>
			</thead>
			<tbody>
				<tr v-if="pborrowers.length == 0">
					<td>No borrowers yet.</td>
					<td></td>
					<td></td>
				</tr>
				<tr class="client-item" :class="isActiveAccount(b)" v-for="(b) in filterAccount" :key="b.loan_account_id">
					<td>{{b.borrower.borrower_num}}</td>
					<td><a href="#">{{b.borrower.firstname + ' ' + b.borrower.lastname}}</a></td>
					<td><span @click="$emit('selectAccount',b)" class="text-green c-pointer">select</span></td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
export default {
	props:['pborrowers', 'id', 'account'],
	data(){
		return {
			filter:'',
		}
	},
	methods:{
		isActive:function(borrower){
			if(borrower.borrower_id == this.id){
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
			if(this.pborrowers.length > 0){
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
		}
	},
}
</script>

<style lang="scss" scoped>
	.client-item.active {
		background-color: #78e08f;
	}
</style>