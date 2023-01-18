<template>
	<div>
		<div class="report-main-item pxy-25 light-bb d-flex flex-column relative hover-light report-nav-item" :class="collapse?'active':''">
			<div @click="collapse=!collapse" class="nav-item-body d-flex justify-content-between align-items-center">
				<a href="" @click.prevent class="text-20 base-link">{{name}}</a>
				<i class="fa fa-caret-right" style="display:block"></i>
			</div>
			<div class="sub-item-container mt-10">
				<div v-for="sn,i in subNavigation" :key="i" class="pxy-15 light-bt light-bb d-flex justify-content-between align-items-center hover-primary-dark" :class="(nav2.toLowerCase()==sn.name.toLowerCase()&&name.toLowerCase()==nav1.toLowerCase())?'active':''">
					<a :href="baseURL() + sn.url" class="text-md base-link">{{sn.name}}</a>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props:['name','nav','nav1','nav2','subnavs'],
	data(){
		return {
			collapse:false,
			selected:'',
			subNavigation:[]
		}
	},
	mounted(){
		this.subNavigation = JSON.parse(this.subnavs);
		this.collapse=this.nav1 == this.name.toLowerCase()?true:false;
	}
}
</script>
