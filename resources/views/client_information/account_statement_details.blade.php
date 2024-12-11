@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<statement-details borrower_id="{{$id}}" token="{{Session::get('token')}}" pbranch="{{json_encode(Session::get('branch'))}}"></statement-details>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection