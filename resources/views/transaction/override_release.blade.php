@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<override-release pbranch="{{Session::get('branch')->branch_id}}" token="{{Session::get('token')}}" staff="{{Session::get('fullname')}}" branch_mgr="{{Session::get('branch')->branch_manager}}"></override-release>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection