<template>
	<div class="container-fluid px-16">
		<div class="mb-16"></div>
		<div class="mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">{{title}}</h1>
		</div>
		<div class="search-bar">
			<input v-model="filter" type="text" class="form-control" id="searchBar" placeholder="Search">
			<div><i class="fa fa-search"></i></div>
		</div>
		<div class="">
			<table class="table table-stripped" id="clientsList">
				<thead>
					<th>Account #</th>
					<th>Client Name</th>
					<th>Contact Number</th>
					<th>Address</th>
				</thead>
				<tbody>
					<tr v-for="(borrower, i) in paginate" :key="i">
						<td>{{borrower.borrower_num}}</td>
						<td><a :href="url.replace(':id', borrower.borrower_id)">{{borrower.firstname + ' ' + borrower.lastname}}</a></td>
						<td>{{borrower.contact_number}}</td>
						<td>{{borrower.address}}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<mac-pagination v-if="filteredBorrowers.length > pagination.range" @setpage="setPage" :pdata="filteredBorrowers" :ppage="pagination.page" :prange="pagination.range" class="mb-24"></mac-pagination>
		<!-- <div v-if="filteredBorrowers.length > pagination.range" class="d-flex justify-content-end">
			<div class="d-flex pagination">
				<span @click="pagination.page=i" :class="i==pagination.page?'active':''" v-for="i in Math.ceil(filteredBorrowers.length/pagination.range)" :key="i">{{i}}</span>
			</div>
		</div> -->
	</div>
</template>

<script>
export default {
	props:['title', 'url', 'token', 'pbranch'],
	data(){
		return {
			borrowers:[],
			filter:'',
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
		fetchBorrowers:function(){
			axios.get(this.baseURL() + 'api/borrower/list/' + this.pbranch, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.borrowers = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
	},
	computed:{
		filteredBorrowers:function(){
			var borrowers = [];
			this.pagination.page = 1;
			if(this.filter.length > 0){
				this.borrowers.map(function(data){
					if(data.borrower_num.toLowerCase().includes(this.filter.toLowerCase()) || data.firstname.toLowerCase().includes(this.filter.toLowerCase()) || data.lastname.toLowerCase().includes(this.filter.toLowerCase()) || (data.firstname + ' ' + data.lastname).toLowerCase().includes(this.filter.toLowerCase()) || (data.lastname + ' ' + data.firstname).toLowerCase().includes(this.filter.toLowerCase())){
						borrowers.push(data);
					}
				}.bind(this));
			}else{
				borrowers = this.borrowers;
			}
			return borrowers;
		},
		paginate:function(){
			var result = [];
			var start = (this.pagination.page - 1) * this.pagination.range;
			var end = 0;
			for(var i = start; i < this.filteredBorrowers.length; i++){
				if(end < this.pagination.range){
					result.push(this.filteredBorrowers[i]);
				}
				end++;
			}
			return result;
		}
	},
	mounted(){
		this.fetchBorrowers();
	}
}
</script>

<style>
	.pagination span {
		font-weight: bold;
		font-size: 14px;
		border: 1px solid #ddd;
		width:35px;
		height:35px;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-right: 5px;
		cursor: pointer;
	}
	.pagination.pagination-mini span{
		width:25px;
		height:25px;
	}
	.pagination span:hover {
		border: 1px solid #293f54;
	}
	.pagination span.active {
		background: #293f54;
		color: #fff;
	}
</style>