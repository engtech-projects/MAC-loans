<template>
	<div id="printContent" class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-column align-items-center mt-45">
			<span class="mb-24 text-xl  c-primary-dark">Tax Month</span>
			<div class="d-flex mb-36">
				<div class="d-flex align-items-center mr-16">
					<span class="mr-10">From:</span>
					<input v-model="filter.date_from" type="date" class="form-control">
				</div>
				<div class="d-flex align-items-center">
					<span class="mr-10">To:</span>
					<input v-model="filter.date_to" type="date" class="form-control">
				</div>
			</div>
			<a href="#" class="btn btn-success mr-10 max-w-250">Generate DBF File</a>
		</div>
	</div>
</template>

<script>
export default {
	props:['branch_id','token'],
	data(){
		return {
			filter:{
				date_from:null,
				date_to:null,
				branch_id:null
			}
		}
	},
	methods:{
		async generateDbf(){
			this.filter.branch_id = this.branch_id;
			await axios.post(this.baseURL() + 'api/report/bir', this.filter, {
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				console.log(response.data);
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		}
	},
	watch:{
		filter:{
			handler(val){
				if(val.date_from && val.date_to){
					this.generateDbf();
				}
			},
			deep:true
		}
	},
}
</script>

<style scoped>
	.max-w-250 {
		max-width: 250px;
	}
</style>