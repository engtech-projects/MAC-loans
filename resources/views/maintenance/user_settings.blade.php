@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<user-settings token="{{Session::get('token')}}"></user-settings>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection