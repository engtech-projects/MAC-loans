@extends('_layout.app')

@section('content')
    <!-- Main content -->
	<section class="content mb-45">
		
		<div class="container-fluid" style="padding:0!important">
			<div class="mb-16"></div>
			<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between">
				<h1 class="m-0 font-35">Reports - Release</h1>
			</div>
			<div class="d-flex flex-row align-items-start">
				@include('_includes/reportsnav')

				<reports-release-ao token="{{Session::get('token')}}" branch_id="{{Session::get('branch')->branch_id}}"></reports-release-ao>

			</div>
		</div>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection