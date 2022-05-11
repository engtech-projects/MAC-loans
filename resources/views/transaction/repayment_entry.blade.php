@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<repayment-entry token="{{Session::get('token')}}"></repayment-entry>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection