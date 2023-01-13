@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app" id="app">
		<cancel-payments branch="{{Session::get('branch')->branch_id}}" userid="{{Auth::user()->id}}" token="{{Session::get('token')}}"></cancel-payments>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->

  </div>
@endsection