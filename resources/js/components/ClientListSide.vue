<template>
	<div class="d-flex flex-column">
		<div class="search-bar mb-12">
			<input v-model="filter" type="text" class="form-control" id="searchBar" placeholder="Search">
			<div><i class="fa fa-search"></i></div>
		</div>
		<table class="table table-stripped table-hover" id="clientsList">
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
				<tr v-for="b in filterClient" :key="b.borrower_id">
					<td>{{b.borrower_num}}</td>
					<td><a href="#">{{b.firstname + ' ' + b.lastname}}</a></td>
					<td><span @click="$emit('selectBorrower',b)" class="text-green c-pointer">select</span></td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
export default {
	props:['pborrowers'],
	data(){
		return {
			filter:'',
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
		}
	},
}
</script>