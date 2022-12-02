@extends('client_portal_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<div class="mb-24"></div>
		<borrower-balance-inquiry pborrower="{{$id}}" token="{{Session::get('token')}}"></borrower-balance-inquiry>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection