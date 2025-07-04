<template>
	<div>
		<div v-if="loading" class="black-screen d-flex flex-column align-items-center justify-content-center" style="padding-left:0px;">
			<div class="loading-container d-flex align-items-center justify-content-center mb-36">
				<span class="loading-text">LOADING</span>
				<img :src="baseURL() + 'img/loading_default.png'" class="rotating" alt="" style="width:300px;height:300px">
			</div>
			<span class="font-lg" style="color:#ddd">Please wait until the process is complete</span>
		</div>
		<borrowers-info @load="loading=true" @unload="loading=false" @savedInfo="redirect" :borrower_id="borrower_id" :token="token" :idtype="idType" :pclient="pclient" :transactionDate="transactionDate"></borrowers-info>
	</div>
</template>

<script>
export default {
	props:['idtype','borrower_id', 'pclient', 'token', 'pbranch'],
	data(){
		return {
			loading:false,
			transactionDate: {
				branch_id: this.pbranch,
				status: 'closed',
				date_end: '',
			},
		}
	},
	methods:{
		fetchTransactionDate:function(){
			axios.get(this.baseURL() + 'api/eod/eodtransaction/'+this.pbranch, {
			headers: {
				'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.transactionDate = response.data.data;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
		},
		redirect:function(){
			setTimeout(function(){
				window.location.href = this.baseURL() + 'client_information/personal_information_details/' + this.borrower_id;
			}.bind(this), 500)
		}
	},
	computed:{
		idType:function(){
			return JSON.parse(this.idtype);
		}
	},
	async mounted(){
        await this.fetchTransactionDate();
	}
}
</script>