@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<product-setup token="{{Session::get('token')}}"></product-setup>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection