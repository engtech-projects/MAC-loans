@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<repayment-entry pbranch="{{Session::get('branch')->branch_id}}" paymentType="{{json_encode(config('enums.payment_type'))}}" token="{{Session::get('token')}}"></repayment-entry>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection