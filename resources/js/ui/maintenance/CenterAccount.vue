<template>
	<div class="container-fluid px-16">
		<notifications group="foo" />
		<div class="mb-16"></div>
		<div class="mb-36 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">Center - Account Officer Setup</h1>
		</div><!-- /.col -->
		<div class="d-flex flex-column flex-xl-row mb-24">
			<div style="flex:9;">
				<section class="mb-24" style="flex:21;" v-if="center.center_id">
					<span class="section-title section-subtitle mb-12">Center Office</span>
					<div class="d-flex flex-column light-border">
						<div class="d-flex justify-content-between bg-primary-dark text-white px-16 py-7">
							<span class="text-bold font-md">Edit {{center.center}}</span>
							<a href="" @click="resetCenter()" class="text-white"><i class="fa fa-times"></i></a>
						</div>
						<div class="p-16">
							<div class="form-group mb-24" style="flex:1">
								<label for="centerName" class="form-label">Center Name</label>
								<input type="text" v-model="center.center" class="form-control form-input " id="centerName">
							</div>
							<div class="form-group mb-24" style="flex:1">
								<label for="centerName" class="form-label">Days Schedule for Collection</label>
								<select class="form-control form-input " id="centerName" v-model="center.day_sched">
									<option v-for="(day, d) in ddays" :key="d" :value="day">{{upperFirst(day)}}</option>
								</select>
							</div>
							<div class="d-flex justify-content-between">
								<a @click="center.status='active'" v-if="center.status!='active'" href="#" class="btn btn-lg btn-yellow-light min-w-150">Activate</a>
								<a @click="center.status='inactive'" v-if="center.status=='active'" href="#" class="btn btn-lg btn-danger min-w-150">Deactivate</a>
								<a href="#" @click="save()" class="btn btn-lg btn-success min-w-150">Save</a>
							</div>
						</div>
					</div>
				</section>
				<section class="mb-24" style="flex:21;" v-if="!center.center_id">
					<span class="section-title section-subtitle mb-12">Center Office</span>

					<div class="d-flex flex-column p-16 light-border">
						<div class="form-group mb-24" style="flex:1">
							<label for="centerName" class="form-label">Center Name</label>
							<input type="text" v-model="center.center" class="form-control form-input " id="centerName">
						</div>
						<div class="form-group mb-24" style="flex:1">
							<label for="centerName" class="form-label">Days Schedule for Collection</label>
							<select class="form-control form-input " id="centerName" v-model="center.day_sched">
								<option v-for="(day, d) in ddays" :key="d" :value="day">{{upperFirst(day)}}</option>
							</select>
						</div>
						<div class="d-flex justify-content-end">
							<a href="#" @click="save()" class="btn btn-lg btn-success min-w-150">Save</a>
						</div>
					</div>
				</section>
			</div>
			<div style="flex:20">
				<section class="mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-12">Center List</span>
					<div class="p-10 light-border">
						<table class="table table-stripped th-nb m-0">
							<tbody>
								<tr v-if="centers.length == 0">
									<td>No centers found.</td>
								</tr>
								<tr v-for="center in centers" :key="center.center_id">
									<td class="">{{center.center}}</td>
									<td>{{upperFirst(center.day_sched)}}</td>
									<td class="text-right"><a href="#" class="text-green text-sm">{{upperFirst(center.status)}}</a></td>
									<td class="text-right"><a @click="setEdit(center)" href="#" class="fa fa-edit"></a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</section>
			</div>
		</div>
		
		<div class="d-flex flex-column flex-xl-row mb-24">
			<div style="flex:9;">
				<section class="mb-24" style="flex:21;">
					<span class="section-title section-subtitle mb-12">Account Officer</span>

					<div class="d-flex flex-column p-16 light-border">
						<div class="form-group mb-24" style="flex:1">
							<label for="centerName" class="form-label">Code</label>
							<input type="text" class="form-control form-input " id="centerName">
						</div>
						<div class="form-group mb-24" style="flex:1">
							<label for="centerName" class="form-label">Full Name</label>
							<input type="text" class="form-control form-input " id="centerName">
						</div>
						<div class="form-group mb-24" style="flex:1">
							<label for="centerName" class="form-label">Branch</label>
							<div class="d-flex">
								<select name="" id="" class="form-control form-input mr-1">
									<option value="Butuan">Butuan</option>
								</select>
								<a href="#" class="btn btn-primary-dark" style="line-height:2;"><i class="fa fa-plus"></i></a>
							</div>
						</div>
						<div class="d-flex justify-content-between">
							<a href="#" class="btn btn-lg btn-yellow-light min-w-150">Activate / Deactivate</a>
							<a href="#" class="btn btn-lg btn-success min-w-150">Save</a>
						</div>
					</div>
				</section>
			</div>
			<div style="flex:20">
				<section class="mb-24" style="flex:21;padding-left:16px;">
					<span class="section-title section-subtitle mb-12">Group List</span>
					<div class="p-10 light-border">
						<table class="table table-stripped th-nb m-0">
							<tbody>
								<tr>
									<td class="nbt">John Mark Barcenas</td>
									<td class="text-right"><a href="#" class="text-green text-sm">ACTIVE</a></td>
								</tr>
								<tr>
									<td>John Mark Barcenas</td>
									<td class="text-right"><a href="#" class="text-green text-sm">ACTIVE</a></td>
								</tr>
								<tr>
									<td>John Mark Barcenas</td>
									<td class="text-right"><a href="#" class="text-green text-sm">ACTIVE</a></td>
								</tr>
								<tr>
									<td>John Mark Barcenas</td>
									<td class="text-right"><a href="#" class="text-green text-sm">ACTIVE</a></td>
								</tr>
								<tr>
									<td>John Mark Barcenas</td>
									<td class="text-right"><a href="#" class="text-green text-sm">ACTIVE</a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</section>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props:['days'],
	data(){
		return {
			csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
			ddays:[],
			centers:[],
			center:{
				center_id:null,
				center:'',
				day_sched:'',
				status:'active',
				deleted:0
			},
		}
	},
	methods:{
		fetchCenters:function(){
			$.get(window.location.origin + '/api/centers', function(data){
				this.centers = data.data;
				console.log(data.data);
			}.bind(this));
		},
		upperFirst:function (string) {
			return string.charAt(0).toUpperCase() + string.slice(1);
		},
		save: function(){
			if(this.center.center_id){
					axios.put(window.location.origin + '/api/centers/' + this.center.center_id, this.center)
					.then(function (response) {
						this.notify('',response.data.message, 'success');
						console.log(response.data);
						this.fetchCenters();
					}.bind(this))
					.catch(function (error) {
						console.log(error);
					}.bind(this));
			}else {
				axios.post(window.location.origin + '/api/centers', this.center)
				.then(function (response) {
					this.notify('',response.data.message, 'success');
					console.log(response.data);
					this.fetchCenters();
				}.bind(this))
				.catch(function (error) {
					console.log(error);
				}.bind(this));
			}
			
		},
		setEdit: function(data){
				this.center.center_id = data.center_id;
				this.center.center = data.center;
				this.center.day_sched = data.day_sched;
				this.center.status = data.status;
				this.center.deleted = data.deleted;
		},
		notify:function(title, text, type){
			this.$notify({
				group: 'foo',
				title: title,
				text: text,
				type: type,
			});
		},

		resetCenter: function(){
			this.center = {
				center_id:null,
				center:'',
				day_sched:'',
				status:'active',
				deleted:0
			}
		}
	},
	mounted(){
		this.ddays = JSON.parse(this.days);
		this.fetchCenters();
	}
}
</script>