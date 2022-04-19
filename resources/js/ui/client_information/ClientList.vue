<template>
	<div class="container-fluid px-16">
		<div class="mb-16"></div>
		<div class="mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">{{title}}</h1>
		</div><!-- /.col -->
		<div class="search-bar">
			<input type="text" class="form-control" id="searchBar" placeholder="Search">
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
				<tr v-for="borrower in borrowers" :key="borrower.borrower_id">
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
	props:['title', 'url', 'token'],
	data(){
		return {
			borrowers:[],
		}
	},
	methods:{
		fetchBorrowers:function(){
			axios.get(window.location.origin + '/api/borrower', {
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
	mounted(){
		this.fetchBorrowers();
	}
}
</script>