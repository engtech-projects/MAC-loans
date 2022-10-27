<template>
	<div>
		<borrowers-info @savedInfo="redirect" :borrower_id="borrower_id" :token="token" :idtype="idType" :pclient="pclient"></borrowers-info>
	</div>
</template>

<script>
export default {
	props:['idtype','borrower_id', 'pclient', 'token'],
	methods:{
		redirect:function(){
			setTimeout(function(){
				window.location.href = this.baseURL() + 'client_information/personal_information_list';
			}.bind(this), 500)
		}
	},
	computed:{
		idType:function(){
			return JSON.parse(this.idtype);
		}
	}
}
</script>