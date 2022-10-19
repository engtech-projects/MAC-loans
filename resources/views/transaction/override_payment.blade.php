@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<override-payment pbranch="{{Session::get('branch')->branch_id}}" token="{{Session::get('token')}}" />
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection