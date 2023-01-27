<template>
	<div id="printContent" class="d-flex flex-column" style="flex:8;">
		<div class="d-flex flex-column align-items-center mt-45">
			<span class="mb-24 text-xl  c-primary-dark">Tax Month</span>
			<div class="d-flex mb-36">
				<div class="d-flex align-items-center mr-16">
					<span class="mr-10">From:</span>
					<input type="date" class="form-control">
				</div>
				<div class="d-flex align-items-center">
					<span class="mr-10">To:</span>
					<input type="date" class="form-control">
				</div>
			</div>
			<a href="#" class="btn btn-success mr-10 max-w-250">Generate DBF File</a>
		</div>
	</div>
</template>

<script>
export default {
	props:['pbranch','token'],
	data(){
		return {
			
		}
	},
	methods:{
		
	},
	computed:{
		
	},
	watch:{
		
	},
	mounted(){
		
	}
}
</script>

<style scoped>
	.max-w-250 {
		max-width: 250px;
	}
</style>