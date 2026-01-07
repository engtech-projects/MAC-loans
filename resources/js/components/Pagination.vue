<template>
	<div class="d-flex justify-content-end">
		<div v-if="data.length" class="d-flex pagination align-items-center" :class="mini?'pagination-mini':''">
			<!-- <span @click="setPage(i)" :class="i==page?'active':''" v-for="i in Math.ceil(data.length/range)" :key="i">{{i}}</span> -->
			<span v-if="page>1" @click="page>1?setPage(page - 1):0" class="arrowbtn"><i class="fa fa-chevron-left"></i></span>
			<span v-else class="disabled"><i class="fa fa-chevron-left"></i></span>
			<b class="mr-10 ml-5 range">{{page}} of {{Math.ceil(data.length/range)}}</b>
			<span v-if="page<Math.ceil(data.length/range)" @click="page<Math.ceil(data.length/range)?setPage(page + 1):0" class="arrowbtn"><i class="fa fa-chevron-right"></i></span>
			<span v-else class="disabled"><i class="fa fa-chevron-right"></i></span>
		</div>
	</div>
</template>

<script>
export default {
	props:['ppage', 'pdata', 'prange','mini'],
	data(){
		return {
			data:[],
			page:1,
			range:1
		}
	},
	methods:{
		setPage:function(page){
			this.$emit('setpage',page);
		}
	},
	watch:{
		'ppage'(val){
			this.page = val;
		},
		'prange'(val){
			this.range = val;
		},
		'pdata'(val){
			this.data = val;
		}
	},
	mounted(){
		this.page = this.ppage;
		this.range = this.prange;
		this.data = this.pdata;
	}
}
</script>

<style scoped>
	.ml-5{
		margin-left:5px!important;
	}
	.range {
		color: #777;
		font-size:18px;
		font-weight: normal;
		color: #111;
		height:35px;
		display:flex;
		align-items: center;
		background-color: #e5e5e5;
		padding: 0 15px;
	}
	.arrowbtn:active{
		background-color: #293f54;
		color: #fff;
	}
	.disabled {
		border: 1px solid #bbb;
		color: #bbb;
		cursor:auto;
	}
	.disabled:hover {
		border: 1px solid #bbb;
	}
</style>