<template>
	<div>
		<borrowers-info :borrower_id="borrower_id" :token="token" :idtype="idType" :pclient="pclient"></borrowers-info>
	</div>
</template>

<script>
export default {
	props:['idtype','borrower_id', 'pclient', 'token'],
	computed:{
		idType:function(){
			return JSON.parse(this.idtype);
		}
	}
}
</script>