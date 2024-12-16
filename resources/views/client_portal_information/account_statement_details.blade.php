@extends('client_portal_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<borrower-statement-details borrower_id="{{$id}}" token="{{Session::get('token')}}"></borrower-statement-details>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection