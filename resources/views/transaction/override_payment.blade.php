@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<override-payment pbranch="{{Session::get('branch')->branch_id}}" token="{{Session::get('token')}}" candelete="{{Auth::user()->hasAccess('delete override payment')?1:0}}" canoverride="{{Auth::user()->hasAccess('override releases')?1:0}}"/>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection