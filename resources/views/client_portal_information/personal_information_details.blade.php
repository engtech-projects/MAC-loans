@extends('client_portal_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<borrower-personal-information borrower_id="{{$id}}" token="{{Session::get('token')}}"></borrower-personal-information>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection