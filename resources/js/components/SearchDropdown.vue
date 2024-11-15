<template>
	<div class="d-flex c-pointer relative">
		<div @click="dd=!dd" class="d-flex dd-container align-items-center justify-content-between no-select">
			<span class="font-lg c-primary-dark">{{selectedData[name]}}</span>
			<i class="fa fa-chevron-down text-xs"></i>
		</div>
		<div v-if="dd" class="dd-box d-flex flex-column">
			<div class="search-container">
				<input v-model="search" type="text" class="form-control form-input search-bar" placeholder="Search">
			</div>
			<div class="data-list d-flex flex-column text-lg c-primary-dark no-select">
				<span v-for="d,i in filteredData" :key="i" @click="select(d)">{{d[name]}}</span>
				<span v-if="search.length>0 && filteredData.length==0"><i>No result found.</i></span>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
	  data: Array,
	  name: String,
	  reset: Boolean,
	  product: String,
	  centerId: Number
	},
	data(){
		return {
			dd:false,
			search:''
		}
	},
	methods:{
		select:function(selected){
			this.dd=!this.dd;
			this.search = '';
			this.$emit('sdSelect', selected)
		}
	},
	computed:{
		selectedData() {
			return this.data.find(d => d.center_id === this.centerId) || {};
		},
		filteredData:function(){
			return this.search.length>0?this.data.filter(d=>d[this.name].toLowerCase().includes(this.search.toLowerCase())):this.data;
		}
	},
	watch:{
		'reset':function(val){
			if(val){
				this.$emit('centerReset');
			}
		}
	}
}
</script>
<style scoped>
	.dd-container {
		height:48px;
		border: 1px solid #aaa;
		background: #FFF;
		padding: 3px 10px;
		width:100%;
	}
	.dd-text {
		color: #222;
	}
	.dd-box {
		position: absolute;
		width:100%;
		min-height: 100px;
		left:0;top:48px;
		border: 1px solid #777;
		box-shadow: 1px 1px 3px rgba(0, 0, 0, .1);
		background-color: #FFF;
		padding: 3px 0px;
	}
	.search-container {
		padding: 0 3px;
	}
	.search-bar {
		height:35px!important;
		font-size: 16px!important;
		padding:0px 7px;
		margin-bottom: 10px;
	}
	.data-list span {
		padding: 2px 15px;
		font-size: 24px;
	}
	.data-list span:hover {
		background-color: #1e90ff;
		color: #FFF;
	}
</style>