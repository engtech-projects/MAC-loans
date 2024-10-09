@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<endof-day token="{{Session::get('token')}}" pbranch="{{json_encode(Session::get('branch'))}}"></endof-day>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection