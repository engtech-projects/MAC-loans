<template>
	<input type="text" class="hide" id="currentTransactionDate" :value="transactionDate">
</template>

<script>
export default {
	props:['token', 'branch'],
	data(){
		return {
			transactionDate:''
		}
	},
	async mounted(){
		await axios.get(this.baseURL() + 'api/eod/eodtransaction/' + this.branch,{
			headers: {
				'Authorization': 'Bearer ' + this.token,
				'Content-Type': 'application/json',
				'Accept': 'application/json'
				}
			})
			.then(function (response) {
				this.transactionDate = response.data.data.date_end;
			}.bind(this))
			.catch(function (error) {
				console.log(error);
			}.bind(this));
	}
}
</script>