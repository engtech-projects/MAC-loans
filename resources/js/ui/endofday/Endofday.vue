<template>
	<div class="container-fluid" style="padding:0!important">
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
		<div v-if="success" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<span class="mb-24" style="color:#ddd;font-size:36px;">Process complete...</span>
			<!-- <button class="btn btn-success" style="padding-left:35px;padding-right:35px">OK</button> -->
		</div>
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between">
			<h1 class="m-0 font-35">End of Day</h1>
		</div><!-- /.col -->
		<div v-if="!failed && !success && !loading" class="d-flex flex-column align-items-center p-16 " style="padding-top:65px">
			<p class="text-center lh-1 text-lg">You are about to end the transaction dated <span class="text-green">{{dateToMDY(new Date())}}</span></p>
			<p class="text-red text-xl text-center mb-24" style="max-width:575px">You will not be able to do any transactions after End of Day.</p>
			<p class="font-lg text-center lh-1 mb-45">How would you like to end the transaction?</p>
			<div class="d-flex">
				<button @click="posted=true" data-toggle="modal" data-target="#postedModal" class="btn btn-success mr-24 px-35">Posted</button>
				<button @click="posted=false" data-toggle="modal" data-target="#postedModal" class="btn btn-success px-35">Unposted</button>
			</div>
		</div>

		<div v-if="failed" class="d-flex flex-column align-items-center p-16" style="padding-top:65px">
			<p class="font-lg text-center lh-1">End of Day Stopped</p>
			<p class="font-lg text-center lh-1">Due to Incomplete Override Release / Repayment</p>
			<p class="font-lg text-center lh-1 mb-45">Transaction</p>
			<button @click="endOfDay()" class="btn btn-primary-dark px-35">Retry</button>
		</div>

		<div class="modal" id="postedModal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-body">
					<div class="d-flex flex-column" style="min-height:200px;padding:16px;">
						<div class="d-flex flex-1 justify-content-center align-items-center">
						<p v-if="posted" class="text-24 text-center">Are you sure you want to end {{dateToMDY(new Date())}} Transactions as Posted?</p>
						<p v-if="!posted" class="text-24 text-center">Are you sure you want to end {{dateToMDY(new Date())}} Transactions as Unposted?</p>
						</div>
						<div class="d-flex flex-row">
							<div style="flex:2"></div>
							<button @click="endOfDay()" data-dismiss="modal" class="btn btn-lg btn-success mr-24" style="flex:3">Yes</button>
							<button data-dismiss="modal" class="btn btn-lg btn-success" style="flex:3">No</button>
							<div style="flex:2"></div>
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
	props:['token','pbranch'],
	data(){
		return {
			posted:false,
			branch:{
				branch_id:null,
			},
			failed:false,
			loading:false,
			success:false,
		}
	},
	methods:{
		async endOfDay(){
			this.loading = true;
			await axios.get(this.baseURL() + 'api/eod/eodtransaction/' + this.branch.branch_id,{status:this.posted?'posted':'unposted'},{
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
				this.success = true;
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