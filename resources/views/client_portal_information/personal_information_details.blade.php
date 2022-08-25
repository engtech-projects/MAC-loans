@extends('client_portal_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<personal-information borrower_id="{{$id}}" token="{{Session::get('token')}}"></personal-information>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection