@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<div class="container-fluid" style="padding:0!important">
			<div class="mb-16"></div>
			<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block">
				<h1 class="m-0 font-35">Product Setup</h1>
			</div><!-- /.col -->
			<div class="d-flex flex-column flex-xl-row ml-16">
				<div style="flex:9;">
					<section class="mb-24" style="flex:21;padding-left:16px;">
						<span class="section-title section-subtitle mb-12">Inputs</span>

						<div class="d-flex flex-column p-16 light-border">
							<div class="form-group mb-10" style="flex:1">
								<label for="productName" class="form-label">Product Name</label>
								<input type="text" class="form-control form-input " id="productName">
							</div>
							<div class="d-flex flex-row mb-24">
								<div class="form-group mb-10 mr-24" style="flex:1">
									<label for="productName" class="form-label">Product Code</label>
									<input type="text" class="form-control form-input " id="productName">
								</div>
								<div class="form-group mb-10" style="flex:1">
									<label for="productName" class="form-label">Percentage</label>
									<input type="text" class="form-control form-input " id="productName">
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
						<span class="section-title section-subtitle mb-12">List</span>
						<product-list api="{{url('/')}}"></product-list>
					</section>
				</div>
		   </div>
		</div>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection