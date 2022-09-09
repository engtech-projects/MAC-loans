<template>
	<div class="container-fluid" style="padding:0!important">
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between">
			<h1 class="m-0 font-35">End of Day</h1>
		</div><!-- /.col -->
		<div v-if="!failed" class="d-flex flex-column align-items-center p-16 " style="padding-top:65px">
			<p class="font-lg text-center lh-1">You are about to end the transaction dated <span class="text-green">{{dateToMDY(new Date())}}</span></p>
			<p class="font-lg text-center lh-1 mb-45">Would you like to auto post the transaction?</p>
			<div class="d-flex">
				<button @click="endOfDay()" class="btn btn-primary-dark mr-24 px-35">Yes</button>
				<button class="btn btn-primary-dark px-35">No</button>
			</div>
		</div>

		<div v-if="failed" class="d-flex flex-column align-items-center p-16" style="padding-top:65px">
			<p class="font-lg text-center lh-1">End of Day Cancelled</p>
			<p class="font-lg text-center lh-1">Due to Incomplete Override Release / Repayment</p>
			<p class="font-lg text-center lh-1 mb-45">Transaction</p>
			<button @click="endOfDay()" class="btn btn-primary-dark px-35">Retry</button>
		</div>


		
	</div>
</template>

<script>
export default {
	props:['token','pbranch'],
	data(){
		return {
			branch:{
				branch_id:null,
			},
			failed:false,
			loading:false,
		}
	},
	methods:{
		async endOfDay(){
			this.loading = true;
			await axios.get(this.baseURL() + 'api/eod/eodtransaction/' + this.branch.branch_id,{
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.failed = false;
				console.log(response.data);
				this.loading = false;
			}.bind(this))
			.catch(function (error) {
				this.failed = true;
				console.log(error);
				this.loading = false;
			}.bind(this));
		}
	},
	watch:{
		'pbranch':function(newValue){
			this.branch = JSON.parse(newValue);
		}
	},
	mounted(){
		this.branch = JSON.parse(this.pbranch);
	}
}
</script>

<style lang="scss">
	@-webkit-keyframes rotating {
		from{
			-webkit-transform: rotate(0deg);
		}
		to{
			-webkit-transform: rotate(360deg);
		}
	}

	.rotating {
		-webkit-animation: rotating 5s linear infinite;
	}
	.loading-container {
		position:relative;
		width:300px;height:300px;
		img{
			position:absolute;
			width:300px;height:300px;
			left:0;top:0;
		}
	}
	.loading-text {
		font-size: 24px;
		font-weight: bold;
		color: #ddd;
	}
</style>