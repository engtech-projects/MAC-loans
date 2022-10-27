<template>
	<div class="container-fluid px-16">
		<div class="mb-16"></div>
		<div class="mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">{{title}}</h1>
		</div><!-- /.col -->
		<div class="search-bar">
			<input v-model="filter" type="text" class="form-control" id="searchBar" placeholder="Search">
			<div><i class="fa fa-search"></i></div>
		</div>
		<table class="table table-stripped" id="clientsList">
			<thead>
				<th>Account #</th>
				<th>Client Name</th>
				<th>Contact Number</th>
				<th>Address</th>
			</thead>
			<tbody>
				<tr v-for="(borrower, i) in filteredBorrowers" :key="i">
					<td>{{borrower.borrower_num}}</td>
					<td><a :href="url.replace(':id', borrower.borrower_id)">{{borrower.firstname + ' ' + borrower.lastname}}</a></td>
					<td>{{borrower.contact_number}}</td>
					<td>{{borrower.address}}</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
export default {
	props:['title', 'url', 'token', 'pbranch'],
	data(){
		return {
			borrowers:[],
			filter:'',
		}
	},
	methods:{
		fetchBorrowers:function(){
			axios.get(this.baseURL() + 'api/borrower/list/' + this.pbranch, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				// console.log(response.data);
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
		}
	},
	mounted(){
		this.fetchBorrowers();
	}
}
</script>