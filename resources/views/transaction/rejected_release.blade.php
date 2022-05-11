@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<rejected-release token="{{Session::get('token')}}"></rejected-release>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection