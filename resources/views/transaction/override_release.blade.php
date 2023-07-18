@extends('_layout.app')

@section('content')
    <!-- Main content -->
    <section class="content mb-45 app">
		<override-release pbranch="{{json_encode(Session::get('branch'))}}" 
			token="{{Session::get('token')}}" staff="{{Session::get('fullname')}}" 
			branch_mgr="{{Session::get('branch')->branch_manager}}" 
			canreject="{{Auth::user()->hasAccess('reject releases')?1:0}}"
			candelete="{{Auth::user()->hasAccess('delete releases')?1:0}}"
		>
		</override-release>
    </section>
    <!-- /.content -->
	<!-- MODALS  -->
  </div>
@endsection