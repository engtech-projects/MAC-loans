@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<override-payment token="{{Session::get('token')}}" />
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection