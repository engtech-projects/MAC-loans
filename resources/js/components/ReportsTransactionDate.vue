<template>
	<span class="text-primary-dark mr-10">{{dateFullDay(new Date())}} {{dateToYMD(new Date()).split('-').join('/')}}</span>
</template>

<script>
export default {
	props:['token'],
	methods:{
		
	},
	mounted(){

	}
}
</script>