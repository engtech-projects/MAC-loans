@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<rejected-release pbranch="{{Session::get('branch')->branch_id}}" token="{{Session::get('token')}}"></rejected-release>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection