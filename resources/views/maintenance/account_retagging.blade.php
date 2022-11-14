@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<account-retagging pbranch="{{Session::get('branch')->branch_id}}" token="{{Session::get('token')}}"></account-retagging>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection