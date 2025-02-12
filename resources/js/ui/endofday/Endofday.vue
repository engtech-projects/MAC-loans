<template>
	<div class="container-fluid" style="padding:0!important">
		<notifications group="foo" />
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
		<div v-if="1==11" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<span class="mb-24" style="color:#ddd;font-size:36px;">Process complete...</span>
			<!-- <button class="btn btn-success" style="padding-left:35px;padding-right:35px">OK</button> -->
		</div>
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between">
			<h1 class="m-0 font-35">End of Day</h1>
		</div><!-- /.col -->
		<form action="" @submit.prevent="createTransactionDate">
		<div v-if="newDay" class="d-flex flex-column align-items-center" style="padding-top:95px">
			<img :src="baseURL() + 'img/company_logo.png'" class="mb-36" alt="">
			<span class="text-lg text-bold text-primary-dark">You are able to open today's transaction,</span>
			<span class="text-lg text-bold text-primary-dark mb-24">kindly set up the date below.</span>
			<input type="date" v-model="newTransactionDate" style="max-width:450px;" class="form-control mb-45" required>
			<button class="btn btn-primary-dark btn-wide">Save</button>
		</div>
		</form>
		<div v-if="!newDay&&!failed && !success && !loading" class="d-flex flex-column align-items-center p-16 " style="padding-top:65px">
			<p class="text-center lh-1 text-lg">You are about to end the transaction dated <span class="text-green">{{dateToMDY(new Date(transactionDate))}}</span></p>
			<p class="text-red text-xl text-center mb-24" style="max-width:575px">You will not be able to do any transactions after End of Day.</p>
			<p class="font-lg text-center lh-1 mb-45">How would you like to end the transaction?</p>
			<div class="d-flex">
				<button @click="posted=true" data-toggle="modal" data-target="#postedModal" class="btn btn-success mr-24 px-35">Posted</button>
				<button @click="posted=false" data-toggle="modal" data-target="#postedModal" class="btn btn-success px-35">Unposted</button>
			</div>
		</div>
		<day-ended v-if="success"></day-ended>

		<div v-if="failed" class="d-flex flex-column align-items-center p-16" style="padding-top:65px">
			<p class="font-lg text-center lh-1">End of Day Stopped</p>
			<p class="font-lg text-center lh-1">{{pendingResponse}}</p>
			<button @click="checkPendingTransactions()" class="btn btn-primary-dark px-35">Retry</button>
		</div>

		<div class="modal" id="postedModal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-body">
					<div class="d-flex flex-column" style="min-height:200px;padding:16px;">
						<div class="d-flex flex-1 justify-content-center align-items-center">
						<p v-if="posted" class="text-24 text-center">Are you sure you want to end {{dateToMDY(new Date(transactionDate))}} Transactions as Posted?</p>
						<p v-if="!posted" class="text-24 text-center">Are you sure you want to end {{dateToMDY(new Date(transactionDate))}} Transactions as Unposted?</p>
						</div>
						<div class="d-flex flex-row">
							<div style="flex:2"></div>
							<button @click="checkPendingTransactions()" data-dismiss="modal" class="btn btn-lg btn-success mr-24" style="flex:3">Yes</button>
							<button data-dismiss="modal" class="btn btn-lg btn-success" style="flex:3">No</button>
							<div style="flex:2"></div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
		<div class="modal" id="eodModal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-body">
					<div class="d-flex flex-column justify-content-center align-items-center" style="min-height:200px;padding:16px;">
						<span class="text-lg">End of day Completed.</span>
						<span class="text-lg">Today's transactions is now closed.</span>
					</div>
				</div>
				</div>
			</div>
		</div>
		<div class="modal" id="noTransactionsModal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-body">
					<div class="d-flex flex-column" style="min-height:200px;padding:16px;">
						<div class="d-flex flex-1 justify-content-center align-items-center">
						<p class="text-24 text-center">Stopped end of day. No transactions have been conducted during this day. Do you still want to proceed with the end of day?</p>
						</div>
						<div class="d-flex flex-row">
							<div style="flex:2"></div>
							<button @click="endWithoutTransactions()" data-dismiss="modal" class="btn btn-lg btn-success mr-24" style="flex:3">Yes</button>
							<button data-dismiss="modal" class="btn btn-lg btn-success" style="flex:3">No</button>
							<div style="flex:2"></div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
		<button class="hide" id="eodModalBtn" data-toggle="modal" data-target="#eodModal">eod</button>
		<button class="hide" id="noTransactionsBtn" data-toggle="modal" data-target="#noTransactionsModal">No Transactions</button>
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
            toUpdate:false,
			failed:false,
			loading:false,
			success:false,
			transactionDate:this.dateToYMD(new Date),
			pendingResponse:'',
			newDay:false,
			newTransactionDate:'',
		}
	},
	methods:{
		async createTransactionDate(){
			var data = {
				transaction_date: this.newTransactionDate,
				branch_id: this.branch.branch_id
			}
			await axios.post(this.baseURL() + 'api/eod/eodtransaction/create',data,{
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
					}
				})
				.then(function (response) {
					if(response.data.success == 'false'){
						this.notify('',response.data.message + ', ' + response.data.data, 'error');
					}else{
						this.fetchTransactionDate();
						document.getElementById("currentTransactionDate").value = this.newTransactionDate;
                        this.toUpdate = true
					}

				}.bind(this))
				.catch(function (error) {
					this.notify('',error.response.data.data, 'error');
                    toUpdate = false;
					console.log(error);
				}.bind(this));
                if(this.toUpdate) {
                    this.loading = true
                    await axios.get(this.baseURL() + 'api/get-current-amortization/'+this.branch.branch_id,{
                        headers:{
                            'Authorization': 'Bearer ' + this.token,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    }).then(function(response) {
                        var message = response.data.message
                        window.location.href = this.baseURL() + 'dashboard';
                        this.toUpdate = false
                        setTimeout(() => {
	                        this.loading = false;
                        }, 2000);
                        this.notify('','Transaction date has been set successfully', 'success');
                    }.bind(this))
                    .catch(function(error) {
                        console.log(error)
                        this.loading = false
                        this.toUpdate = false
                    }.bind(this))
                }
		},
		async fetchTransactionDate(){
			await axios.get(this.baseURL() + 'api/eod/eodtransaction/' + this.branch.branch_id,{
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				console.log(response.data.data);
				this.transactionDate = response.data.data.date_end;
				this.success = response.data.data.status == 'open' ? false : true;
				this.newDay = response.data.data.status == 'open' ? false : true;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		async checkPendingTransactions(){
			this.loading = true;
			this.failed = false;
			await axios.post(this.baseURL() + 'api/eod/eodtransaction/check', {branch_id:this.branch.branch_id},{
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				console.log(response.data.data);
				this.loading = false;
				if(response.data.data == 0){
					this.loading = false;
					// this.createPerformanceReport();
					this.endOfDay();
				}else{
					this.pendingResponse = response.data.message;
					this.failed = true;
				}
			}.bind(this))
			.catch(function (error) {
				this.loading = false;
				console.log(error);
			}.bind(this));
		},
		async endWithoutTransactions(){
			this.loading = true;
			await axios.post(this.baseURL() + 'api/eod/eodtransaction/closewithouttransactions',{status:this.posted?'posted':'unposted', branch_id:this.branch.branch_id},{
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loading = false;
				document.getElementById('eodModalBtn').click();
				this.success = true;
				this.newDay = true;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
				this.loading = false;
			}.bind(this));
		},
		async createPerformanceReport(){
			this.loading = true;
			await axios.post(this.baseURL() + 'api/report/branch/performancereport/create',{branch_id:this.branch.branch_id},{
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				console.log(response.data)
				this.endOfDay();
			}.bind(this))
			.catch(function (error) {
				console.log(error);
				this.loading = false;
			}.bind(this));
		},
		async endOfDay(){
			this.loading = true;
			await axios.post(this.baseURL() + 'api/eod/eodtransaction/exec',{status:this.posted?'posted':'unposted', branch_id:this.branch.branch_id},{
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loading = false;
				document.getElementById('eodModalBtn').click();
				this.success = true;
				this.newDay = true;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
				if(error.response.data.data == 'No Transaction'){
					var btn = document.getElementById('noTransactionsBtn');
					btn.click();
				}
				this.loading = false;
			}.bind(this));
		},
		async checkEOD(){
			this.loading = true;
			await axios.get(this.baseURL() + 'eod/check', {
			headers: {
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.loading = false;
				if(response.data == 1){
					this.success = true;
				}
			}.bind(this))
			.catch(function (error) {
				this.loading = false;
				console.log(error);
			}.bind(this));
		},
		notify:function(title, text, type){
			this.$notify({
				group: 'foo',
				title: title,
				text: text,
				type: type,
			});
		},
	},
	watch:{
		'pbranch':function(newValue){
			this.branch = JSON.parse(newValue);
		}
	},
	mounted(){
		// this.checkEOD();
		this.branch = JSON.parse(this.pbranch);
		// this.checkPendingTransactions();
		this.fetchTransactionDate();
	}
}
</script>

// <style lang="scss">
// 	@-webkit-keyframes rotating {
// 		from{
// 			-webkit-transform: rotate(0deg);
// 		}
// 		to{
// 			-webkit-transform: rotate(360deg);
// 		}
// 	}

// 	.rotating {
// 		-webkit-animation: rotating 5s linear infinite;
// 	}
// 	.loading-container {
// 		position:relative;
// 		width:300px;height:300px;
// 		img{
// 			position:absolute;
// 			width:300px;height:300px;
// 			left:0;top:0;
// 		}
// 	}
// 	.loading-text {
// 		font-size: 24px;
// 		font-weight: bold;
// 		color: #ddd;
// 	}
// </style>
