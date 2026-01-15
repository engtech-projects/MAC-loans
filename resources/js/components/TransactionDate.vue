<template>
	<div :class="transactionDate?'':'hide'">
		<input v-if="!reports" type="text" class="hide" id="currentTransactionDate" :value="transactionDate">
		<span v-else class="text-primary-dark mr-10">{{dateFullDay(new Date(transactionDate))}} {{dateToYMD(new Date(transactionDate)).split('-').join('/')}}</span>
	</div>
</template>

<script>
export default {
	props:['token', 'branch', 'reports'],
	data(){
		return {
			filter:{
				token:null,
				branch:null
			},
			transactionDate:null
		}
	},
	methods:{
		async fetchTransactionDate(){
			await axios.get(this.baseURL() + 'api/eod/eodtransaction/' + this.branch,{
				headers: {
					'Authorization': 'Bearer ' + this.token,
					'Content-Type': 'application/json',
					'Accept': 'application/json'
					}
				})
				.then(function (response) {
					this.transactionDate = response.data.data.date_end;
					this.$emit('update-transaction-date', this.transactionDate);
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
		}
	},
	watch:{
		filter: {
			handler(val){
				if(val.token && val.branch){
					this.fetchTransactionDate();
				}
			},
			deep: true
		},
		'token':function(val){
			this.filter.token = val;
		},
		'branch':function(val){
			this.filter.branch = val;
		}
	},
	mounted(){
		this.filter.token = this.token;
		this.filter.branch = this.branch;
	}
}
</script>
<style scoped>
	.hide {
		display: none!important;
	}
</style>