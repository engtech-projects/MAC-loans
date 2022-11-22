@extends('_layout.app')

@section('content')
    <!-- Main content -->
	<section class="content mb-45">
		
		<div class="container-fluid" style="padding:0!important">
			<div class="mb-16"></div>
			<div class="ml-16 mb-24 bb-primary-dark pb-7 text-block d-flex justify-content-between">
				<h1 class="m-0 font-35">Transaction</h1>
			</div>
			<div class="d-flex flex-row align-items-start">
				@include('_includes/reportsnav')
				<reports-branch-paymentstatus></reports-branch-paymentstatus>
			</div>
		</div>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection