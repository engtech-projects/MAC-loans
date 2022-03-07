<template>
	<div class="container-fluid px-16">
		<div class="mb-16"></div>
		<div class="d-flex justify-content-between mb-24 bb-primary-dark pb-7 text-block">
			<h1 class="m-0 font-35">Personal Information</h1>
			<a href="#" class="btn btn-success min-w-150">Edit Information</a>
		</div><!-- /.col -->
		<div class="d-flex flex-column flex-sm-row personal-info" style="margin-bottom:24px;">
			<div class="upload-photo mb-24">
				<img :src="baseUrl + '/img/user.png'" alt="">
				<a href="#" class="btn btn-primary" style="padding:10px!important">Upload or Take a Photo</a>
			</div>
			<div class="flex-gap-24"></div>
			<div class="info-main-container" style="width:100%;">
				<div class="row info-container">
					<div class="col-xl-2 col-lg-6">
						<div class="customer-number">
							<span>Customer Number</span>
							<span>1003429</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>First Name</span>
							<span class="xs-font-24">Juan</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>Middle Name</span>
							<span>Cardo</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>Last Name</span>
							<span>Lagahit</span>
						</div>
					</div>
					<div class="col-xl-4">
						<div class="info-display">
							<span>Suffix</span>
							<span>Jr.</span>
						</div>
					</div>
					
				</div>
				<div class="row info-container">
					<div class="col-xl-3 col-lg-6">
						<div class="info-display">
							<span>Birth Date</span>
							<span>January 12, 1985</span>
						</div>
					</div>
					<div class="col-xl-1 col-lg-6">
						<div class="info-display">
							<span>Gender</span>
							<span>Male</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>Status</span>
							<span>Married</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>Contact Number</span>
							<span>09285541258</span>
						</div>
					</div>
					<div class="col-xl-4 col-lg-6">
						<div class="info-display">
							<span>Registration Date</span>
							<span>December 12, 2021</span>
						</div>
					</div>
				</div>
				<div class="row info-container">
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>ID. Type</span>
							<span>UMID</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6">
						<div class="info-display">
							<span>ID. Number</span>
							<span>136524548847</span>
						</div>
					</div>
					<div class="col-xl-2 col-lg-6">
						<div class="info-display">
							<span>ID. Date</span>
							<span>12/12/2019</span>
						</div>
					</div>
				</div>
				<div class="row info-container xs-mb-32">
					<div class="col-xs-12">
						<div class="info-display">
							<span>Address</span>
							<span>154 JP Laurel Sr Street Corner 6th Avenue 1400, Caloocan City, Philippines</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row info-container" style="width:100%">
			<div class="col-md-12" style="height:60px!important;">
				<div class="info-display title">
					<span>Spouse Information</span>
				</div>
			</div>
			<div class="col-xl-2 col-lg-6">
				<div class="info-display">
					<span>First Name</span>
					<span>Maria</span>
				</div>
			</div>
			<div class="col-xl-2 col-lg-6">
				<div class="info-display">
					<span>Middle Name</span>
					<span>Reyes</span>
				</div>
			</div>
			<div class="col-xl-2 col-lg-6">
				<div class="info-display">
					<span>Last Name</span>
					<span>Lagahit</span>
				</div>
			</div>
			<div class="col-xl-3">
				<div class="info-display">
					<span>Suffix</span>
					<span>Jr.</span>
				</div>
			</div>
			<div class="col-xl-3">
				<div class="info-display">
					<span>Birth Date</span>
					<span>March 12, 1976</span>
				</div>
			</div>
		</div>	
	</div>
</template>

<script>
export default {
	data(){
		return {
			baseUrl: window.location.origin
		}
	}
}
</script>