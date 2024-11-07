@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<deduction-rate token="{{Session::get('token')}}"></deduction-rate>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection