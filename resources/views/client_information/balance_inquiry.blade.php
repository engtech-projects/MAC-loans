@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<div class="mb-24"></div>
		<balance-inquiry pborrower="{{$id}}" token="{{Session::get('token')}}"></balance-inquiry>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection